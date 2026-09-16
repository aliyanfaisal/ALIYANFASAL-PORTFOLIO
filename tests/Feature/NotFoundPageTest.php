<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotFoundPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_renders_the_custom_404_page_for_an_unmatched_route(): void
    {
        // An unmatched route bypasses the `web` middleware group (session, $errors
        // sharing) unless a fallback route catches it — regression test for that gotcha.
        $response = $this->get('/this-route-does-not-exist');

        $response->assertNotFound();
        $response->assertSee('This route');
        $response->assertSee('404');
        $response->assertSee(route('home'), false);
    }
}
