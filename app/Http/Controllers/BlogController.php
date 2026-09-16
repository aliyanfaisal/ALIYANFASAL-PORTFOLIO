<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');
        $search = trim((string) $request->query('q'));

        $posts = BlogPost::published()
            ->with('categories')
            ->when($category, fn ($query) => $query->whereHas(
                'categories',
                fn ($query) => $query->where('slug', $category)
            ))
            ->when($search !== '', fn ($query) => $query->where(
                fn ($query) => $query->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
            ))
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('blog.index', [
            'posts' => $posts,
            'categories' => Category::orderBy('name')->get(),
            'activeCategory' => $category,
            'search' => $search,
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['categories', 'tags'])
            ->firstOrFail();

        return view('blog.show', ['post' => $post]);
    }
}
