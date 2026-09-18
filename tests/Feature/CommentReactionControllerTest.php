<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CommentReactionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // JSON requests don't send cookies by default (simulating a credential-less fetch),
        // but the reaction endpoint identifies the visitor by session cookie, so tests need it.
        $this->withCredentials();
    }

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

    /**
     * @return array{0: BlogPost, 1: Comment}
     */
    private function makeComment(): array
    {
        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $comment = $post->comments()->create([
            'name' => 'Author',
            'email' => 'author@example.com',
            'body' => 'Body',
            'session_id' => 'author-session',
        ]);

        return [$post, $comment];
    }

    public function test_store_adds_a_reaction_and_returns_json_counts(): void
    {
        [$post, $comment] = $this->makeComment();

        $response = $this->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), [
            'emoji' => '👍',
        ]);

        $response->assertOk()->assertJson([
            'counts' => ['👍' => 1],
            'mine' => '👍',
        ]);

        $this->assertDatabaseHas('comment_reactions', [
            'comment_id' => $comment->id,
            'emoji' => '👍',
        ]);
    }

    public function test_store_toggles_off_the_same_reaction(): void
    {
        [$post, $comment] = $this->makeComment();

        $first = $this->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), ['emoji' => '👍']);

        $response = $this->asSameSession($first)->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), ['emoji' => '👍']);

        $response->assertOk()->assertJson(['mine' => null]);
        $this->assertDatabaseCount('comment_reactions', 0);
    }

    public function test_store_switches_to_a_different_reaction(): void
    {
        [$post, $comment] = $this->makeComment();

        $first = $this->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), ['emoji' => '👍']);
        $response = $this->asSameSession($first)->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), ['emoji' => '❤️']);

        $response->assertOk()->assertJson(['mine' => '❤️']);
        $this->assertDatabaseCount('comment_reactions', 1);
        $this->assertDatabaseHas('comment_reactions', ['comment_id' => $comment->id, 'emoji' => '❤️']);
    }

    public function test_store_rejects_an_invalid_emoji(): void
    {
        [$post, $comment] = $this->makeComment();

        $this->postJson(route('blog.comments.reactions.store', [$post->slug, $comment->id]), ['emoji' => '💀'])
            ->assertJsonValidationErrors('emoji');

        $this->assertDatabaseCount('comment_reactions', 0);
    }

    public function test_store_returns_404_when_the_comment_belongs_to_a_different_post(): void
    {
        [, $comment] = $this->makeComment();

        $otherPost = BlogPost::create([
            'title' => 'Other Post',
            'slug' => 'other-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $this->postJson(route('blog.comments.reactions.store', [$otherPost->slug, $comment->id]), ['emoji' => '👍'])
            ->assertNotFound();
    }
}
