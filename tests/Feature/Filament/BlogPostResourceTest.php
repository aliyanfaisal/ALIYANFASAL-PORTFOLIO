<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\BlogPosts\Pages\CreateBlogPost;
use App\Filament\Resources\BlogPosts\Pages\EditBlogPost;
use App\Filament\Resources\BlogPosts\Pages\ListBlogPosts;
use App\Jobs\PushBlogPostToCuelara;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class BlogPostResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_blog_post_with_categories_tags_and_an_image(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create(['is_admin' => true]);
        $category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $tag = Tag::create(['name' => 'PHP', 'slug' => 'php']);

        Livewire::actingAs($admin)
            ->test(CreateBlogPost::class)
            ->fillForm([
                'title' => 'My First Post',
                'slug' => 'my-first-post',
                'excerpt' => 'A short summary.',
                'body' => "Paragraph one.\n\nParagraph two.",
                'image_path' => UploadedFile::fake()->image('cover.jpg'),
                'categories' => [$category->id],
                'tags' => [$tag->id],
                'published_at' => now(),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $post = BlogPost::where('slug', 'my-first-post')->firstOrFail();

        $this->assertTrue($post->categories->contains($category));
        $this->assertTrue($post->tags->contains($tag));
        Storage::disk('public')->assertExists($post->image_path);
    }

    public function test_admin_can_send_a_post_to_cuelara_from_the_edit_page(): void
    {
        Queue::fake();
        config([
            'services.cuelara.url' => 'https://cuelara.test/api/blog-posts',
            'services.cuelara.token' => 'token',
        ]);

        $admin = User::factory()->create(['is_admin' => true]);
        $post = BlogPost::create(['title' => 'Hi', 'slug' => 'hi', 'excerpt' => 'e', 'body' => 'b']);

        Livewire::actingAs($admin)
            ->test(EditBlogPost::class, ['record' => $post->slug])
            ->callAction('sendToCuelara')
            ->assertNotified('Post queued for Cuelara');

        Queue::assertPushed(PushBlogPostToCuelara::class, fn ($job): bool => $job->force && $job->post->is($post));
    }

    public function test_send_button_reflects_whether_the_post_was_already_sent(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $post = BlogPost::create(['title' => 'Hi', 'slug' => 'hi', 'excerpt' => 'e', 'body' => 'b']);

        $component = Livewire::actingAs($admin)
            ->test(EditBlogPost::class, ['record' => $post->slug])
            ->assertActionExists('sendToCuelara', fn ($action): bool => $action->getLabel() === 'Send to Cuelara');

        $post->forceFill(['cuelara_synced_at' => now()])->save();

        Livewire::actingAs($admin)
            ->test(EditBlogPost::class, ['record' => $post->slug])
            ->assertActionExists('sendToCuelara', fn ($action): bool => $action->getLabel() === 'Resend to Cuelara');
    }

    public function test_admin_can_send_a_post_to_cuelara_from_the_table_column(): void
    {
        Queue::fake();
        config([
            'services.cuelara.url' => 'https://cuelara.test/api/blog-posts',
            'services.cuelara.token' => 'token',
        ]);

        $admin = User::factory()->create(['is_admin' => true]);
        $post = BlogPost::create(['title' => 'Hi', 'slug' => 'hi', 'excerpt' => 'e', 'body' => 'b']);

        Livewire::actingAs($admin)
            ->test(ListBlogPosts::class)
            ->assertSee('Send to Cuelara')
            ->callTableAction('sendToCuelara', $post)
            ->assertNotified('Post queued for Cuelara');

        Queue::assertPushed(PushBlogPostToCuelara::class, fn ($job): bool => $job->force && $job->post->is($post));
    }
}
