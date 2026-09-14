<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GithubService
{
    protected string $username;

    public function __construct()
    {
        $this->username = config('services.github.username', 'aliyanfaisal');
    }

    /**
     * Get the user's public repositories, sorted by pinned status then stars then recent activity.
     */
    public function repositories(int $limit = 12): array
    {
        return Cache::remember("github.repos.{$this->username}", now()->addHours(12), function () use ($limit) {
            $response = $this->client()->get("https://api.github.com/users/{$this->username}/repos", [
                'per_page' => 100,
                'sort' => 'updated',
            ]);

            if ($response->failed()) {
                Log::warning('GitHub repos fetch failed', ['status' => $response->status()]);

                return [];
            }

            $pinned = $this->pinnedRepoNames();

            return collect($response->json())
                ->reject(fn ($repo) => $repo['fork'] ?? false)
                ->sortByDesc(fn ($repo) => [
                    in_array($repo['name'], $pinned, true) ? 1 : 0,
                    $repo['stargazers_count'],
                    $repo['pushed_at'],
                ])
                ->take($limit)
                ->map(fn ($repo) => [
                    'name' => $repo['name'],
                    'full_name' => $repo['full_name'],
                    'description' => $repo['description'],
                    'url' => $repo['html_url'],
                    'homepage' => $repo['homepage'],
                    'language' => $repo['language'],
                    'stars' => $repo['stargazers_count'],
                    'forks' => $repo['forks_count'],
                    'topics' => $repo['topics'] ?? [],
                    'updated_at' => $repo['pushed_at'],
                    'pinned' => in_array($repo['name'], $pinned, true),
                ])
                ->values()
                ->all();
        });
    }

    /**
     * Get the names of the user's pinned repos via the GraphQL API.
     * Pinned status isn't available through the REST API, and GraphQL always
     * requires authentication, so this silently returns an empty list when
     * no GITHUB_TOKEN is configured.
     */
    protected function pinnedRepoNames(): array
    {
        if (! config('services.github.token')) {
            return [];
        }

        return Cache::remember("github.pinned.{$this->username}", now()->addHours(12), function () {
            $query = <<<'GQL'
                query($login: String!) {
                    user(login: $login) {
                        pinnedItems(first: 6, types: REPOSITORY) {
                            nodes {
                                ... on Repository {
                                    name
                                }
                            }
                        }
                    }
                }
                GQL;

            $response = $this->client()->post('https://api.github.com/graphql', [
                'query' => $query,
                'variables' => ['login' => $this->username],
            ]);

            if ($response->failed()) {
                Log::warning('GitHub pinned repos fetch failed', ['status' => $response->status()]);

                return [];
            }

            return collect($response->json('data.user.pinnedItems.nodes'))
                ->pluck('name')
                ->all();
        });
    }

    /**
     * Get aggregate profile stats (public repos, followers, etc).
     */
    public function profile(): ?array
    {
        return Cache::remember("github.profile.{$this->username}", now()->addHours(12), function () {
            $response = $this->client()->get("https://api.github.com/users/{$this->username}");

            if ($response->failed()) {
                Log::warning('GitHub profile fetch failed', ['status' => $response->status()]);

                return null;
            }

            $data = $response->json();

            return [
                'login' => $data['login'],
                'name' => $data['name'],
                'bio' => $data['bio'],
                'avatar_url' => $data['avatar_url'],
                'html_url' => $data['html_url'],
                'public_repos' => $data['public_repos'],
                'followers' => $data['followers'],
                'following' => $data['following'],
            ];
        });
    }

    protected function client()
    {
        $request = Http::acceptJson()->timeout(8);

        if ($token = config('services.github.token')) {
            $request = $request->withToken($token);
        }

        return $request;
    }
}
