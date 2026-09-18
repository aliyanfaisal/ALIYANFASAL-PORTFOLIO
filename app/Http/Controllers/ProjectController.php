<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\GithubService;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function index(GithubService $github)
    {
        return view('projects.index', [
            'projects' => Project::orderByRaw('external_url IS NULL')->orderBy('sort_order')->get(),
            'repos' => $github->repositories(9),
            'githubProfile' => $github->profile(),
        ]);
    }

    public function downloadLinks(): Response
    {
        $lines = Project::whereNotNull('external_url')
            ->orderByRaw('external_url IS NULL')
            ->orderBy('sort_order')
            ->get()
            ->values()
            ->map(fn (Project $project, int $index) => sprintf('%d. %s — %s', $index + 1, $project->title, $project->external_url))
            ->implode("\n");

        return response($lines, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="aliyan-faisal-projects.txt"',
        ]);
    }
}
