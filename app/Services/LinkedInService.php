<?php

namespace App\Services;

use App\Exceptions\LinkedInApiException;
use App\Exceptions\LinkedInNotConnectedException;
use App\Models\LinkedInToken;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class LinkedInService
{
    private const API_VERSION = '202508';

    /**
     * Exchange an OAuth authorization code for an access token.
     *
     * @return array{access_token: string, expires_in: int, refresh_token: ?string, refresh_token_expires_in: ?int}
     */
    public function exchangeAuthorizationCode(string $code): array
    {
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => config('services.linkedin.redirect_uri'),
            'client_id' => config('services.linkedin.client_id'),
            'client_secret' => config('services.linkedin.client_secret'),
        ]);

        $this->assertSuccessful($response, 'Failed to exchange authorization code for an access token.');

        return $response->json();
    }

    /**
     * Fetch the LinkedIn member URN (urn:li:person:{sub}) for the given access token.
     */
    public function fetchMemberUrn(string $accessToken): string
    {
        $response = Http::withToken($accessToken)->get('https://api.linkedin.com/v2/userinfo');

        $this->assertSuccessful($response, 'Failed to fetch LinkedIn member info.');

        return 'urn:li:person:'.$response->json('sub');
    }

    /**
     * Return a currently-valid access token, refreshing it first if it's expired or expiring soon.
     */
    public function getValidAccessToken(): string
    {
        $token = LinkedInToken::current();

        if (! $token) {
            throw new LinkedInNotConnectedException;
        }

        if ($token->expires_at->subMinutes(5)->isFuture()) {
            return $token->access_token;
        }

        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $token->refresh_token,
            'client_id' => config('services.linkedin.client_id'),
            'client_secret' => config('services.linkedin.client_secret'),
        ]);

        $this->assertSuccessful($response, 'Failed to refresh LinkedIn access token.');

        $data = $response->json();

        $token = LinkedInToken::store([
            'access_token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'] ?? $token->refresh_token,
            'expires_at' => now()->addSeconds($data['expires_in']),
        ]);

        return $token->access_token;
    }

    /**
     * Download the image, upload it to LinkedIn, and publish it as a native image post.
     * Returns the created post's URN and its human-viewable feed URL.
     *
     * @return array{urn: string, url: string}
     */
    public function publishImagePost(string $imageUrl, string $caption): array
    {
        $accessToken = $this->getValidAccessToken();
        $memberUrn = LinkedInToken::current()->member_urn;

        $imageResponse = Http::timeout(15)->get($imageUrl);

        if ($imageResponse->failed()) {
            throw new LinkedInApiException(
                "Failed to download image from {$imageUrl}.",
                $imageResponse->status(),
                $imageResponse->body(),
            );
        }

        $contentType = strtolower(explode(';', $imageResponse->header('Content-Type') ?? 'image/jpeg')[0]);

        $imageUrn = $this->registerAndUploadImage($accessToken, $memberUrn, $imageResponse->body(), $contentType);

        $postUrn = $this->createPost($accessToken, $memberUrn, $imageUrn, $caption);

        return [
            'urn' => $postUrn,
            'url' => "https://www.linkedin.com/feed/update/{$postUrn}/",
        ];
    }

    /**
     * Register an image upload with LinkedIn and upload the raw bytes to the returned upload URL.
     * Returns the resulting image URN (e.g. urn:li:image:xxxx).
     */
    private function registerAndUploadImage(string $accessToken, string $memberUrn, string $imageBytes, string $contentType): string
    {
        $initResponse = Http::withHeaders($this->restHeaders($accessToken))
            ->post('https://api.linkedin.com/rest/images?action=initializeUpload', [
                'initializeUploadRequest' => [
                    'owner' => $memberUrn,
                ],
            ]);

        $this->assertSuccessful($initResponse, 'Failed to initialize LinkedIn image upload.');

        $uploadUrl = $initResponse->json('value.uploadUrl');
        $imageUrn = $initResponse->json('value.image');

        $uploadResponse = Http::withBody($imageBytes, $contentType)->put($uploadUrl);

        if ($uploadResponse->failed()) {
            throw new LinkedInApiException(
                'Failed to upload image bytes to LinkedIn.',
                $uploadResponse->status(),
                $uploadResponse->body(),
            );
        }

        return $imageUrn;
    }

    /**
     * Create a published, native image post on the member's profile. Returns the post URN
     * captured from the response's x-restli-id header.
     */
    private function createPost(string $accessToken, string $memberUrn, string $imageUrn, string $caption): string
    {
        $response = Http::withHeaders($this->restHeaders($accessToken))
            ->post('https://api.linkedin.com/rest/posts', [
                'author' => $memberUrn,
                'commentary' => $caption,
                'visibility' => 'PUBLIC',
                'distribution' => [
                    'feedDistribution' => 'MAIN_FEED',
                    'targetEntities' => [],
                    'thirdPartyDistributionChannels' => [],
                ],
                'content' => [
                    'media' => ['id' => $imageUrn],
                ],
                'lifecycleState' => 'PUBLISHED',
                'isReshareDisabledByAuthor' => false,
            ]);

        $this->assertSuccessful($response, 'Failed to create LinkedIn post.');

        return $response->header('x-restli-id') ?? $response->header('X-RestLi-Id');
    }

    /**
     * @return array<string, string>
     */
    private function restHeaders(string $accessToken): array
    {
        return [
            'Authorization' => "Bearer {$accessToken}",
            'Content-Type' => 'application/json',
            'LinkedIn-Version' => self::API_VERSION,
            'X-Restli-Protocol-Version' => '2.0.0',
        ];
    }

    private function assertSuccessful(Response $response, string $message): void
    {
        if ($response->failed()) {
            throw new LinkedInApiException($message, $response->status(), $response->json() ?? $response->body());
        }
    }
}
