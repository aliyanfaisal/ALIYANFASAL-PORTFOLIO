<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Rules\NoContactInfo;
use App\Services\TurnstileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, string $slug, TurnstileService $turnstile): RedirectResponse
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', new NoContactInfo],
            'email' => ['required', 'email', 'max:150'],
            'body' => ['required', 'string', 'max:2000', new NoContactInfo],
            'cf-turnstile-response' => ['required', 'string'],
        ]);

        if (! $turnstile->verify($data['cf-turnstile-response'], $request->ip())) {
            return back()
                ->withErrors(['cf-turnstile-response' => 'Verification failed. Please try again.'])
                ->withInput();
        }

        $post->comments()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'body' => $data['body'],
        ]);

        return redirect(route('blog.show', $post).'#comments')
            ->with('status', 'Thanks — your comment has been posted.');
    }
}
