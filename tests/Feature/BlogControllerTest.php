<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_lists_only_published_posts(): void
    {
        $published = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        BlogPost::create([
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'body' => 'Body',
            'published_at' => null,
        ]);

        BlogPost::create([
            'title' => 'Future Post',
            'slug' => 'future-post',
            'body' => 'Body',
            'published_at' => now()->addDay(),
        ]);

        $this->get('/blog')
            ->assertOk()
            ->assertSee($published->title)
            ->assertDontSee('Draft Post')
            ->assertDontSee('Future Post');
    }

    public function test_category_page_filters_posts_by_the_given_category(): void
    {
        $laravel = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $wordpress = Category::create(['name' => 'WordPress', 'slug' => 'wordpress']);

        $laravelPost = BlogPost::create([
            'title' => 'Laravel Tips',
            'slug' => 'laravel-tips',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);
        $laravelPost->categories()->attach($laravel);

        $wordpressPost = BlogPost::create([
            'title' => 'WordPress Tips',
            'slug' => 'wordpress-tips',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);
        $wordpressPost->categories()->attach($wordpress);

        $this->get('/blog/category/laravel')
            ->assertOk()
            ->assertSee('Laravel Tips')
            ->assertDontSee('WordPress Tips');
    }

    public function test_category_page_returns_404_for_an_unknown_category_slug(): void
    {
        $this->get('/blog/category/does-not-exist')->assertNotFound();
    }

    public function test_index_no_longer_filters_by_a_category_query_string(): void
    {
        $laravel = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);

        $laravelPost = BlogPost::create([
            'title' => 'Laravel Tips',
            'slug' => 'laravel-tips',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);
        $laravelPost->categories()->attach($laravel);

        $otherPost = BlogPost::create([
            'title' => 'Unrelated Post',
            'slug' => 'unrelated-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog?category=laravel')
            ->assertOk()
            ->assertSee('Laravel Tips')
            ->assertSee('Unrelated Post');
    }

    public function test_index_filters_by_search_query(): void
    {
        BlogPost::create([
            'title' => 'Building AI Chatbots',
            'slug' => 'building-ai-chatbots',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        BlogPost::create([
            'title' => 'WooCommerce Setup Guide',
            'slug' => 'woocommerce-setup-guide',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog?q=chatbot')
            ->assertOk()
            ->assertSee('Building AI Chatbots')
            ->assertDontSee('WooCommerce Setup Guide');
    }

    public function test_show_displays_a_published_post(): void
    {
        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'excerpt' => 'An excerpt.',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog/'.$post->slug)
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_show_increments_the_view_count(): void
    {
        $post = BlogPost::create([
            'title' => 'Published Post',
            'slug' => 'published-post',
            'body' => 'Body',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/blog/'.$post->slug);
        $this->get('/blog/'.$post->slug);

        $this->assertSame(2, $post->fresh()->views);
    }

    public function test_show_returns_404_for_an_unpublished_post(): void
    {
        $post = BlogPost::create([
            'title' => 'Draft Post',
            'slug' => 'draft-post',
            'body' => 'Body',
            'published_at' => null,
        ]);

        $this->get('/blog/'.$post->slug)->assertNotFound();
    }
}
