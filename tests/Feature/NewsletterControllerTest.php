<?php

namespace Tests\Feature;

use App\Models\NewsletterSubscriber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_subscribes_a_new_email(): void
    {
        $this->post('/newsletter', ['email' => 'reader@example.com'])
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseHas('newsletter_subscribers', ['email' => 'reader@example.com']);
    }

    public function test_it_does_not_duplicate_an_existing_subscriber(): void
    {
        NewsletterSubscriber::create(['email' => 'reader@example.com']);

        $this->post('/newsletter', ['email' => 'reader@example.com'])
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertSame(1, NewsletterSubscriber::where('email', 'reader@example.com')->count());
    }

    public function test_it_validates_the_email(): void
    {
        $this->post('/newsletter', ['email' => 'not-an-email'])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseCount('newsletter_subscribers', 0);
    }
}
