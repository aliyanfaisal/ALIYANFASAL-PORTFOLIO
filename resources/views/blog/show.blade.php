@php
    $settings = \App\Models\Setting::current();
    $fallbackOgImage = $settings->default_og_image
        ? asset('storage/'.$settings->default_og_image)
        : asset('images/aliyan-headshot-cutout.png');
    $ogImage = $post->image_path ? asset('storage/'.$post->image_path) : $fallbackOgImage;
@endphp
<x-layouts.app :title="$post->title.' — '.$settings->site_name" :description="$post->excerpt">
    <x-slot:head>
        <meta property="og:title" content="{{ $post->title }}">
        <meta property="og:description" content="{{ $post->excerpt }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:url" content="{{ url('/blog/'.$post->slug) }}">
        <meta property="og:type" content="article">
        @if ($post->categories->isNotEmpty())
            <meta property="article:section" content="{{ $post->categories->first()->name }}">
        @endif
        @foreach ($post->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}">
        @endforeach
        <meta name="twitter:card" content="summary_large_image">
    </x-slot:head>

    <article class="mx-auto max-w-3xl px-6 py-16">
        @if ($post->categories->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach ($post->categories as $category)
                    <span class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-500 dark:text-indigo-400">{{ $category->name }}</span>
                @endforeach
            </div>
        @endif

        <h1 class="mt-3 text-4xl font-bold text-zinc-900 dark:text-white">{{ $post->title }}</h1>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $post->published_at->format('F j, Y') }}</p>

        @if ($post->image_path)
            <img src="{{ asset('storage/'.$post->image_path) }}" alt="{{ $post->title }}" class="mt-8 w-full rounded-2xl">
        @endif

        <div class="mt-8 space-y-5 text-lg leading-relaxed text-zinc-700 dark:text-zinc-300">
            @foreach (explode("\n", trim($post->body)) as $paragraph)
                @continue(trim($paragraph) === '')
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>

        @if ($post->tags->isNotEmpty())
            <div class="mt-10 flex flex-wrap gap-2 border-t border-zinc-200 pt-6 dark:border-white/10">
                @foreach ($post->tags as $tag)
                    <span class="rounded-full border border-zinc-300 px-3 py-1 text-xs font-medium text-zinc-600 dark:border-white/15 dark:text-zinc-400">#{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </article>
</x-layouts.app>
