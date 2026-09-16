<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_valid_xml_including_static_pages_and_published_posts(): void
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

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('content-type', 'text/xml; charset=UTF-8');

        $xml = $response->getContent();
        $this->assertNotFalse(simplexml_load_string($xml), 'sitemap.xml is not valid XML');

        $this->assertStringContainsString(route('home'), $xml);
        $this->assertStringContainsString(route('blog.index'), $xml);
        $this->assertStringContainsString(route('blog.show', $published), $xml);
        $this->assertStringNotContainsString('draft-post', $xml);
    }
}
