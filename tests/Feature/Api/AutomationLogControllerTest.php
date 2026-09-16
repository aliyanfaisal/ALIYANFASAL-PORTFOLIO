<?php

namespace Tests\Feature\Api;

use App\Models\AutomationLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutomationLogControllerTest extends TestCase
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
        $this->postJson('/api/automation-logs', ['slot' => '08:00', 'status' => 'success'])
            ->assertStatus(401);

        $this->postJson('/api/automation-logs', ['slot' => '08:00', 'status' => 'success'], [
            'Authorization' => 'Bearer wrong-token',
        ])->assertStatus(401);
    }

    public function test_it_validates_required_fields(): void
    {
        $this->postJson('/api/automation-logs', [], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['slot', 'status']);
    }

    public function test_it_rejects_an_unknown_status_value(): void
    {
        $this->postJson('/api/automation-logs', [
            'slot' => '08:00',
            'status' => 'not_a_real_status',
        ], $this->headers())
            ->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }

    public function test_it_creates_a_log_with_only_the_required_fields(): void
    {
        $response = $this->postJson('/api/automation-logs', [
            'slot' => '12:00',
            'status' => 'blog_failed',
        ], $this->headers());

        $response->assertStatus(201)->assertJson([
            'slot' => '12:00',
            'status' => 'blog_failed',
        ]);

        $this->assertDatabaseHas('automation_logs', [
            'slot' => '12:00',
            'status' => 'blog_failed',
            'blog_post_id' => null,
        ]);
    }

    public function test_it_creates_a_full_success_log(): void
    {
        $response = $this->postJson('/api/automation-logs', [
            'run_at' => '2026-09-16T08:00:00Z',
            'slot' => '08:00',
            'category' => 'AI Tools',
            'topic' => 'Best AI coding assistants 2026',
            'blog_post_id' => 42,
            'blog_url' => 'https://aliyanfaisal.com/blog/best-ai-coding-assistants',
            'word_count' => 1450,
            'linkedin_attempted' => true,
            'linkedin_posted' => true,
            'linkedin_post_url' => 'https://www.linkedin.com/feed/update/urn:li:share:123/',
            'status' => 'success',
        ], $this->headers());

        $response->assertStatus(201)->assertJson([
            'slot' => '08:00',
            'status' => 'success',
            'blog_post_id' => 42,
        ]);

        $log = AutomationLog::firstOrFail();
        $this->assertSame('2026-09-16 08:00:00', $log->run_at->toDateTimeString());
        $this->assertTrue($log->linkedin_posted);
    }

    public function test_it_defaults_run_at_to_now_when_omitted(): void
    {
        $this->postJson('/api/automation-logs', [
            'slot' => '16:00',
            'status' => 'success',
        ], $this->headers())->assertStatus(201);

        $log = AutomationLog::firstOrFail();
        $this->assertNotNull($log->run_at);
    }

    public function test_it_stores_the_error_message_on_a_failed_run(): void
    {
        $this->postJson('/api/automation-logs', [
            'slot' => '20:00',
            'status' => 'linkedin_failed',
            'error_message' => 'LinkedIn API returned 426 NONEXISTENT_VERSION.',
        ], $this->headers())->assertStatus(201);

        $this->assertDatabaseHas('automation_logs', [
            'slot' => '20:00',
            'status' => 'linkedin_failed',
            'error_message' => 'LinkedIn API returned 426 NONEXISTENT_VERSION.',
        ]);
    }
}
