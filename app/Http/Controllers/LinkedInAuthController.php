<?php

namespace App\Http\Controllers;

use App\Models\LinkedInToken;
use App\Services\LinkedInService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LinkedInAuthController extends Controller
{
    /**
     * Redirect to LinkedIn's authorization screen to start the one-time OAuth connect flow.
     * Requires a ?key= query param matching LINKEDIN_CONNECT_KEY, so a stranger can't start
     * the flow and complete it by logging into their own LinkedIn account.
     */
    public function redirect(Request $request): RedirectResponse
    {
        $expectedKey = config('services.linkedin.connect_key');

        if (! $expectedKey || ! hash_equals($expectedKey, (string) $request->query('key'))) {
            abort(403);
        }

        $state = Str::random(40);
        $request->session()->put('linkedin_oauth_state', $state);

        $query = http_build_query([
            'response_type' => 'code',
            'client_id' => config('services.linkedin.client_id'),
            'redirect_uri' => config('services.linkedin.redirect_uri'),
            'scope' => 'openid profile w_member_social',
            'state' => $state,
        ]);

        return redirect("https://www.linkedin.com/oauth/v2/authorization?{$query}");
    }

    public function callback(Request $request, LinkedInService $linkedIn): string
    {
        $expectedState = $request->session()->pull('linkedin_oauth_state');

        if (! $expectedState || $request->query('state') !== $expectedState) {
            abort(403, 'Invalid or expired state.');
        }

        if (! $request->query('code')) {
            abort(400, 'LinkedIn did not return an authorization code.');
        }

        $tokenData = $linkedIn->exchangeAuthorizationCode($request->query('code'));
        $memberUrn = $linkedIn->fetchMemberUrn($tokenData['access_token']);

        LinkedInToken::store([
            'access_token' => $tokenData['access_token'],
            'refresh_token' => $tokenData['refresh_token'] ?? null,
            'expires_at' => now()->addSeconds($tokenData['expires_in']),
            'member_urn' => $memberUrn,
        ]);

        return 'LinkedIn connected successfully.';
    }
}
