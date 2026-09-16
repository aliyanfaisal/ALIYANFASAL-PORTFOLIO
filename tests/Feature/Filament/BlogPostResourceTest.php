<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\BlogPosts\Pages\CreateBlogPost;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
}
