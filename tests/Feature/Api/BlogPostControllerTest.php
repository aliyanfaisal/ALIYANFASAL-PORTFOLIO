<?php

namespace Tests\Feature\Api;

use App\Models\BlogPost;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogPostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.blog_api.token' => 'test-token']);
    }

    private function headers(): array
    {
        return ['Authorization' => 'Bearer test-token'];
    }

    public function test_it_rejects_requests_without_a_valid_token(): void
    {
        $this->postJson('/api/blog-posts', ['title' => 'Post', 'body' => 'Body'])
            ->assertStatus(401);

        $this->postJson('/api/blog-posts', ['title' => 'Post', 'body' => 'Body'], [
            'Authorization' => 'Bearer wrong-token',
        ])->assertStatus(401);
    }

    public function test_it_validates_required_fields(): void
    {
        $this->postJson('/api/blog-posts', [], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'body']);
    }

    public function test_it_publishes_immediately_when_auto_approve_is_enabled(): void
    {
        Setting::current()->update(['auto_approve_posts' => true]);

        $response = $this->postJson('/api/blog-posts', [
            'title' => 'My First Post',
            'body' => "Paragraph one.\n\nParagraph two.",
            'categories' => ['Laravel', 'Laravel'],
            'tags' => ['php'],
        ], $this->headers());

        $response->assertStatus(201)->assertJson([
            'status' => 'published',
            'slug' => 'my-first-post',
            'categories' => ['Laravel'],
            'tags' => ['php'],
        ]);

        $post = BlogPost::where('slug', 'my-first-post')->firstOrFail();
        $this->assertNotNull($post->published_at);
        $this->assertTrue($post->published_at->isPast());
    }

    public function test_it_saves_as_a_draft_when_auto_approve_is_disabled(): void
    {
        Setting::current()->update(['auto_approve_posts' => false]);

        $response = $this->postJson('/api/blog-posts', [
            'title' => 'Needs Review',
            'body' => 'Body text.',
            'published_at' => now()->toIso8601String(),
        ], $this->headers());

        $response->assertStatus(201)->assertJson(['status' => 'pending_review']);

        $post = BlogPost::where('slug', 'needs-review')->firstOrFail();
        $this->assertNull($post->published_at);
    }

    public function test_it_derives_a_plain_text_excerpt_from_markdown_body(): void
    {
        $response = $this->postJson('/api/blog-posts', [
            'title' => 'Markdown Excerpt',
            'body' => "## Heading\n\nSome **bold** text with a ```code``` span.",
        ], $this->headers());

        $response->assertStatus(201);

        $post = BlogPost::where('slug', 'markdown-excerpt')->firstOrFail();
        $this->assertStringNotContainsString('##', $post->excerpt);
        $this->assertStringNotContainsString('**', $post->excerpt);
        $this->assertStringContainsString('Heading', $post->excerpt);
    }

    public function test_it_generates_a_unique_slug_on_collision(): void
    {
        BlogPost::create(['title' => 'Dup', 'slug' => 'dup', 'body' => 'x', 'published_at' => now()]);

        $response = $this->postJson('/api/blog-posts', [
            'title' => 'Dup',
            'body' => 'Body text.',
        ], $this->headers());

        $response->assertStatus(201)->assertJson(['slug' => 'dup-2']);
    }

    public function test_it_downloads_and_stores_a_remote_image(): void
    {
        Storage::fake('public');

        Http::fake([
            'https://example.com/cover.jpg' => Http::response(
                file_get_contents(base_path('public/images/aliyan-headshot-cutout.png')),
                200,
                ['Content-Type' => 'image/jpeg'],
            ),
        ]);

        $response = $this->postJson('/api/blog-posts', [
            'title' => 'With Image',
            'body' => 'Body text.',
            'image_url' => 'https://example.com/cover.jpg',
        ], $this->headers());

        $response->assertStatus(201);

        $post = BlogPost::where('slug', 'with-image')->firstOrFail();
        $this->assertSame('blog/with-image.jpg', $post->image_path);
        Storage::disk('public')->assertExists('blog/with-image.jpg');
    }

    public function test_it_returns_a_clear_error_when_the_image_download_fails(): void
    {
        Http::fake([
            'https://example.com/missing.jpg' => Http::response('Not Found', 404),
        ]);

        $response = $this->postJson('/api/blog-posts', [
            'title' => 'Broken Image',
            'body' => 'Body text.',
            'image_url' => 'https://example.com/missing.jpg',
        ], $this->headers());

        $response->assertStatus(422)->assertJsonValidationErrors(['image_url']);
        $this->assertDatabaseMissing('blog_posts', ['slug' => 'broken-image']);
    }
}
