<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function show(string $slug): View
    {
        $post = BlogPost::where('slug', $slug)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with(['categories', 'tags'])
            ->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }
}
