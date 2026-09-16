<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AutomationLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutomationLogController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'run_at' => ['nullable', 'date'],
            'slot' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'topic' => ['nullable', 'string', 'max:255'],
            'blog_post_id' => ['nullable', 'integer'],
            'blog_url' => ['nullable', 'string', 'max:2048'],
            'word_count' => ['nullable', 'integer'],
            'linkedin_attempted' => ['nullable', 'boolean'],
            'linkedin_posted' => ['nullable', 'boolean'],
            'linkedin_post_url' => ['nullable', 'string', 'max:2048'],
            'status' => ['required', 'string', Rule::in(['success', 'blog_failed', 'linkedin_failed', 'partial_success'])],
            'error_message' => ['nullable', 'string'],
        ]);

        $log = AutomationLog::create([
            ...$data,
            'run_at' => $data['run_at'] ?? now(),
        ]);

        return response()->json($log, 201);
    }
}
