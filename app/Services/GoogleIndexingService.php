<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GoogleIndexingService
{
    public const URL_UPDATED = 'URL_UPDATED';

    public const URL_DELETED = 'URL_DELETED';

    private const SCOPE = 'https://www.googleapis.com/auth/indexing';

    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';

    private const PUBLISH_URL = 'https://indexing.googleapis.com/v3/urlNotifications:publish';

    private const TOKEN_CACHE_KEY = 'google-indexing-access-token';

    public function isConfigured(): bool
    {
        $path = config('services.google_indexing.credentials');

        return is_string($path) && $path !== '' && is_readable($path);
    }

    /**
     * Notify Google that a URL was added, updated (URL_UPDATED) or removed (URL_DELETED).
     *
     * @throws RequestException
     */
    public function notify(string $url, string $type = self::URL_UPDATED): void
    {
        Http::withToken($this->accessToken())
            ->acceptJson()
            ->timeout(20)
            ->post(self::PUBLISH_URL, ['url' => $url, 'type' => $type])
            ->throw();
    }

    private function accessToken(): string
    {
        return Cache::remember(self::TOKEN_CACHE_KEY, now()->addMinutes(55), function (): string {
            $response = Http::asForm()->timeout(20)->post(self::TOKEN_URL, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $this->signedJwt(),
            ])->throw();

            return $response->json('access_token');
        });
    }

    private function signedJwt(): string
    {
        $credentials = json_decode((string) file_get_contents(config('services.google_indexing.credentials')), true);

        if (! isset($credentials['client_email'], $credentials['private_key'])) {
            throw new RuntimeException('Google indexing credentials file must contain client_email and private_key.');
        }

        $issuedAt = time();
        $unsigned = $this->base64Url(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])).'.'.$this->base64Url(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => self::SCOPE,
            'aud' => self::TOKEN_URL,
            'iat' => $issuedAt,
            'exp' => $issuedAt + 3600,
        ]));

        if (! openssl_sign($unsigned, $signature, $credentials['private_key'], OPENSSL_ALGO_SHA256)) {
            throw new RuntimeException('Unable to sign the Google indexing JWT with the provided private key.');
        }

        return $unsigned.'.'.$this->base64Url($signature);
    }

    private function base64Url(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }
}
