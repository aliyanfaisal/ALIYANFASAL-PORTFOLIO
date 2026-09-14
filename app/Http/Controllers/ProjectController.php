<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\GithubService;

class ProjectController extends Controller
{
    public function index(GithubService $github)
    {
        return view('projects.index', [
            'projects' => Project::orderBy('sort_order')->get(),
            'repos' => $github->repositories(9),
            'githubProfile' => $github->profile(),
        ]);
    }
}
