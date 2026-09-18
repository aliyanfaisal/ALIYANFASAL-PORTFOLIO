<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Carry the session cookie from a prior response into the next request, so that
     * request is treated as coming from the same "session user" as the earlier one.
     */
    private function asSameSession(TestResponse $response): static
    {
        $cookieName = config('session.cookie');
        $cookie = collect($response->headers->getCookies())->first(fn ($cookie) => $cookie->getName() === $cookieName);

        // The cookie value is already encrypted (it came straight off a Set-Cookie header), so it
        // must be sent back via withUnencryptedCookie — withCookie would encrypt it a second time.
        return $this->withUnencryptedCookie($cookieName, (string) $cookie?->getValue());
    }

    public function test_store_creates_a_comment_when_turnstile_verification_succeeds(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Great article!',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect(route('blog.show', $post).'#comments');
        $this->assertDatabaseHas('comments', [
            'blog_post_id' => $post->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Great article!',
        ]);
    }

    public function test_store_rejects_the_comment_when_turnstile_verification_fails(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => false]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Great article!',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('cf-turnstile-response');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_store_rejects_a_comment_body_containing_an_email_address(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Contact me at spammer@example.com for deals.',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_store_rejects_a_comment_body_containing_a_link(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Check out my site at https://spam-example.com for more.',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_store_rejects_a_comment_body_containing_a_phone_number(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Call me at 415-555-0134 to discuss.',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_store_rejects_a_comment_body_containing_a_script_tag(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Nice post <script>alert(1)</script>',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('comments', 0);
    }

    public function test_foreign_keys_are_cast_to_integers_even_when_the_driver_returns_strings(): void
    {
        $comment = new Comment;
        $comment->setRawAttributes(['blog_post_id' => '5', 'parent_id' => '2']);

        $this->assertSame(5, $comment->blog_post_id);
        $this->assertSame(2, $comment->parent_id);
    }

    public function test_store_returns_404_for_an_unpublished_post(): void
    {
        $post = BlogPost::create([
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'body' => 'Body',
            'published_at' => null,
        ]);

        $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Great article!',
            'cf-turnstile-response' => 'test-token',
        ])->assertNotFound();
    }

    public function test_reply_creates_a_threaded_comment_under_the_parent(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $parent = $post->comments()->create([
            'name' => 'Original Author',
            'email' => 'author@example.com',
            'body' => 'Original comment',
            'session_id' => 'original-session',
        ]);

        $response = $this->post(route('blog.comments.reply', [$post->slug, $parent->id]), [
            'name' => 'Replier',
            'email' => 'replier@example.com',
            'body' => 'Thanks for sharing!',
            'cf-turnstile-response' => 'test-token',
        ]);

        $response->assertRedirect(route('blog.show', $post)."#comment-{$parent->id}");
        $this->assertDatabaseHas('comments', [
            'parent_id' => $parent->id,
            'blog_post_id' => $post->id,
            'name' => 'Replier',
            'body' => 'Thanks for sharing!',
        ]);
    }

    public function test_reply_collapses_a_reply_to_a_reply_onto_the_root_comment(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $root = $post->comments()->create([
            'name' => 'Original Author',
            'email' => 'author@example.com',
            'body' => 'Original comment',
            'session_id' => 'original-session',
        ]);

        $childReply = $post->comments()->create([
            'parent_id' => $root->id,
            'name' => 'First Replier',
            'email' => 'first@example.com',
            'body' => 'First reply',
            'session_id' => 'first-session',
        ]);

        $this->post(route('blog.comments.reply', [$post->slug, $childReply->id]), [
            'name' => 'Second Replier',
            'email' => 'second@example.com',
            'body' => 'Reply to the reply',
            'cf-turnstile-response' => 'test-token',
        ]);

        $this->assertDatabaseHas('comments', [
            'parent_id' => $root->id,
            'name' => 'Second Replier',
            'body' => 'Reply to the reply',
        ]);
    }

    public function test_update_allows_the_owning_session_to_edit_their_comment(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $storeResponse = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Original body',
            'cf-turnstile-response' => 'test-token',
        ]);

        $comment = Comment::firstOrFail();

        $response = $this->asSameSession($storeResponse)->put(route('blog.comments.update', [$post->slug, $comment->id]), [
            'name' => 'Jane Doe',
            'body' => 'Updated body',
        ]);

        $response->assertRedirect(route('blog.show', $post)."#comment-{$comment->id}");
        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'body' => 'Updated body']);
    }

    public function test_update_rejects_a_body_containing_a_link(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $storeResponse = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Original body',
            'cf-turnstile-response' => 'test-token',
        ]);

        $comment = Comment::firstOrFail();

        $this->asSameSession($storeResponse)->put(route('blog.comments.update', [$post->slug, $comment->id]), [
            'name' => 'Jane Doe',
            'body' => 'Visit www.spam-example.com now.',
        ])->assertSessionHasErrors('body', null, "comment-edit-{$comment->id}");

        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'body' => 'Original body']);
    }

    public function test_update_is_forbidden_for_a_different_session(): void
    {
        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $comment = $post->comments()->create([
            'name' => 'Original Author',
            'email' => 'author@example.com',
            'body' => 'Original body',
            'session_id' => 'someone-elses-session',
        ]);

        $this->put(route('blog.comments.update', [$post->slug, $comment->id]), [
            'name' => 'Hacker',
            'body' => 'Edited body',
        ])->assertForbidden();

        $this->assertDatabaseHas('comments', ['id' => $comment->id, 'body' => 'Original body']);
    }

    public function test_destroy_allows_the_owning_session_to_delete_their_comment(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $storeResponse = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Delete me',
            'cf-turnstile-response' => 'test-token',
        ]);

        $comment = Comment::firstOrFail();

        $this->asSameSession($storeResponse)->delete(route('blog.comments.destroy', [$post->slug, $comment->id]))
            ->assertRedirect(route('blog.show', $post).'#comments');

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    public function test_destroy_is_forbidden_for_a_different_session(): void
    {
        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $comment = $post->comments()->create([
            'name' => 'Original Author',
            'email' => 'author@example.com',
            'body' => 'Original body',
            'session_id' => 'someone-elses-session',
        ]);

        $this->delete(route('blog.comments.destroy', [$post->slug, $comment->id]))
            ->assertForbidden();

        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    public function test_destroy_removes_replies_via_cascade(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response(['success' => true]),
        ]);

        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $storeResponse = $this->post(route('blog.comments.store', $post->slug), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'body' => 'Parent comment',
            'cf-turnstile-response' => 'test-token',
        ]);

        $comment = Comment::firstOrFail();

        $reply = $post->comments()->create([
            'parent_id' => $comment->id,
            'name' => 'Replier',
            'email' => 'replier@example.com',
            'body' => 'A reply',
            'session_id' => 'reply-session',
        ]);

        $this->asSameSession($storeResponse)->delete(route('blog.comments.destroy', [$post->slug, $comment->id]));

        $this->assertDatabaseMissing('comments', ['id' => $reply->id]);
    }
}
