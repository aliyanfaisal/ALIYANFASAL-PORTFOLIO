<?php

namespace Tests\Feature\Jobs;

use App\Jobs\PushBlogPostToCuelara;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PushBlogPostToCuelaraTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.cuelara.url' => 'https://cuelara.test/api/blog-posts',
            'services.cuelara.token' => 'cuelara-token',
        ]);
    }

    private function makePost(): BlogPost
    {
        $post = BlogPost::create([
            'title' => 'Hello',
            'slug' => 'hello',
            'excerpt' => 'Ex',
            'body' => 'Body',
            'published_at' => now(),
        ]);
        $post->categories()->attach(Category::create(['name' => 'Laravel', 'slug' => 'laravel'])->id);

        return $post;
    }

    public function test_it_posts_the_payload_and_marks_the_post_synced(): void
    {
        Http::fake(['cuelara.test/*' => Http::response(['ok' => true], 201)]);
        $post = $this->makePost();

        (new PushBlogPostToCuelara($post))->handle();

        Http::assertSent(fn (Request $request): bool => $request->hasHeader('Authorization', 'Bearer cuelara-token')
            && $request['slug'] === 'hello'
            && $request['status'] === 'published'
            && $request['categories'] === ['Laravel']);
        $this->assertNotNull($post->fresh()->cuelara_synced_at);
    }

    public function test_it_does_not_resend_an_already_synced_post(): void
    {
        Http::fake();
        $post = $this->makePost();
        $post->forceFill(['cuelara_synced_at' => now()])->save();

        (new PushBlogPostToCuelara($post))->handle();

        Http::assertNothingSent();
    }

    public function test_it_throws_so_the_queue_retries_on_failure(): void
    {
        Http::fake(['cuelara.test/*' => Http::response('boom', 500)]);
        $post = $this->makePost();

        try {
            (new PushBlogPostToCuelara($post))->handle();
            $this->fail('Expected the job to throw.');
        } catch (RequestException) {
            $this->assertNull($post->fresh()->cuelara_synced_at);
        }
    }
}
