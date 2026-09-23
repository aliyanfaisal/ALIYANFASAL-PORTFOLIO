<?php

namespace Tests\Feature;

use App\Jobs\SubmitUrlToGoogleIndexing;
use App\Models\BlogPost;
use App\Services\GoogleIndexingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class GoogleIndexingTest extends TestCase
{
    use RefreshDatabase;

    private function configureCredentials(): void
    {
        $key = openssl_pkey_new(['private_key_bits' => 2048]);
        openssl_pkey_export($key, $privateKey);

        $path = tempnam(sys_get_temp_dir(), 'gi');
        file_put_contents($path, json_encode(['client_email' => 'bot@project.iam.gserviceaccount.com', 'private_key' => $privateKey]));

        config(['services.google_indexing.credentials' => $path]);
        Cache::flush();
    }

    private function makePost(array $attributes = []): BlogPost
    {
        return BlogPost::create($attributes + [
            'title' => 'Hello',
            'slug' => 'hello',
            'body' => 'Body',
            'published_at' => now()->subMinute(),
        ]);
    }

    public function test_nothing_is_dispatched_when_credentials_are_not_configured(): void
    {
        Bus::fake();

        $this->makePost();

        Bus::assertNotDispatched(SubmitUrlToGoogleIndexing::class);
    }

    public function test_publishing_and_editing_a_post_dispatches_a_notification_but_views_and_drafts_do_not(): void
    {
        $this->configureCredentials();
        Bus::fake();

        $this->makePost(['slug' => 'draft', 'published_at' => null]);
        Bus::assertNotDispatched(SubmitUrlToGoogleIndexing::class);

        $post = $this->makePost();
        Bus::assertDispatchedTimes(SubmitUrlToGoogleIndexing::class, 1);

        $post->increment('views');
        $post->forceFill(['cuelara_synced_at' => now()])->save();
        Bus::assertDispatchedTimes(SubmitUrlToGoogleIndexing::class, 1);

        $post->update(['body' => 'New body']);
        Bus::assertDispatchedTimes(SubmitUrlToGoogleIndexing::class, 2);

        $post->delete();
        Bus::assertDispatched(
            SubmitUrlToGoogleIndexing::class,
            fn (SubmitUrlToGoogleIndexing $job) => $job->type === GoogleIndexingService::URL_DELETED
        );
    }

    public function test_the_job_sends_a_signed_url_notification_to_google(): void
    {
        $this->configureCredentials();
        Bus::fake();
        $this->makePost();

        Http::fake([
            'oauth2.googleapis.com/*' => Http::response(['access_token' => 'token-123']),
            'indexing.googleapis.com/*' => Http::response(['urlNotificationMetadata' => []]),
        ]);

        (new SubmitUrlToGoogleIndexing('hello'))->handle(app(GoogleIndexingService::class));

        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'oauth2.googleapis.com')
            && substr_count($request['assertion'], '.') === 2);
        Http::assertSent(fn (Request $request) => str_contains($request->url(), 'urlNotifications:publish')
            && $request->hasHeader('Authorization', 'Bearer token-123')
            && $request['url'] === url('/blog/hello')
            && $request['type'] === 'URL_UPDATED');
    }

    public function test_the_job_skips_posts_that_are_no_longer_published(): void
    {
        $this->configureCredentials();
        Bus::fake();
        $this->makePost(['published_at' => null]);
        Http::fake();

        (new SubmitUrlToGoogleIndexing('hello'))->handle(app(GoogleIndexingService::class));

        Http::assertNothingSent();
    }
}
