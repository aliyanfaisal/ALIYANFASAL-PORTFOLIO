<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TurnstileService
{
    /**
     * Verify a Turnstile response token with Cloudflare's siteverify endpoint.
     */
    public function verify(string $token, ?string $ip = null): bool
    {
        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'),
            'response' => $token,
            'remoteip' => $ip,
        ]);

        if ($response->failed()) {
            Log::warning('Turnstile siteverify request failed', ['status' => $response->status()]);

            return false;
        }

        return (bool) $response->json('success', false);
    }
}
