<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

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
}
