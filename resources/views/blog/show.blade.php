@php
    $settings = \App\Models\Setting::current();
    $fallbackOgImage = $settings->default_og_image
        ? asset('storage/'.$settings->default_og_image)
        : asset('images/aliyan-headshot-cutout.png');
    $ogImage = $post->image_path ? asset('storage/'.$post->image_path) : $fallbackOgImage;
    $postUrl = url('/blog/'.$post->slug);
    $metaDescription = \Illuminate\Support\Str::limit($post->excerpt ?: strip_tags($post->body), 160);
@endphp
<x-layouts.app :title="$post->title.' — '.$settings->site_name" :description="$metaDescription">
    <x-slot:head>
        <link rel="canonical" href="{{ $postUrl }}">

        <meta property="og:title" content="{{ $post->title }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:url" content="{{ $postUrl }}">
        <meta property="og:type" content="article">
        <meta property="og:site_name" content="{{ $settings->site_name }}">
        <meta property="article:published_time" content="{{ $post->published_at->toIso8601String() }}">
        @if ($post->categories->isNotEmpty())
            <meta property="article:section" content="{{ $post->categories->first()->name }}">
        @endif
        @foreach ($post->tags as $tag)
            <meta property="article:tag" content="{{ $tag->name }}">
        @endforeach

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $post->title }}">
        <meta name="twitter:description" content="{{ $metaDescription }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $post->title,
                'description' => $metaDescription,
                'image' => $ogImage,
                'datePublished' => $post->published_at->toIso8601String(),
                'dateModified' => $post->updated_at->toIso8601String(),
                'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $postUrl],
                'author' => ['@type' => 'Person', 'name' => $settings->site_name],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $settings->site_name,
                    'logo' => ['@type' => 'ImageObject', 'url' => $fallbackOgImage],
                ],
            ], JSON_UNESCAPED_SLASHES) !!}
        </script>
    </x-slot:head>

    <article class="mx-auto max-w-4xl px-6 py-16">
        @if ($post->categories->isNotEmpty())
            <div class="flex flex-wrap gap-2">
                @foreach ($post->categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-indigo-500 transition hover:bg-indigo-500/20 dark:text-indigo-400">{{ $category->name }}</a>
                @endforeach
            </div>
        @endif

        <h1 class="mt-3 text-4xl font-bold text-zinc-900 dark:text-white">{{ $post->title }}</h1>

        <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-zinc-500 dark:text-zinc-400">
            <span>{{ $post->published_at->format('F j, Y') }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">&middot;</span>
            <span class="inline-flex items-center gap-1.5">
                <x-icon name="eye" class="size-4" />
                {{ number_format($post->views) }} views
            </span>
        </div>

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

        <div x-data="{ copied: false }" class="mt-10 flex flex-wrap items-center gap-3 border-t border-zinc-200 pt-6 dark:border-white/10">
            <span class="text-sm font-medium text-zinc-600 dark:text-zinc-300">Share this article:</span>

            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode($postUrl) }}" target="_blank" rel="noopener" aria-label="Share on X" class="grid size-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
            </a>

            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($postUrl) }}" target="_blank" rel="noopener" aria-label="Share on LinkedIn" class="grid size-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 110-4.124 2.062 2.062 0 010 4.124zM7.114 20.452H3.56V9h3.554v11.452z"/></svg>
            </a>

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($postUrl) }}" target="_blank" rel="noopener" aria-label="Share on Facebook" class="grid size-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-300">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4" fill="currentColor"><path d="M22 12.06C22 6.505 17.523 2 12 2S2 6.505 2 12.06c0 5.02 3.657 9.184 8.438 9.94v-7.03H7.898v-2.91h2.54V9.845c0-2.507 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.459h-1.26c-1.243 0-1.63.771-1.63 1.562v1.875h2.773l-.443 2.91h-2.33V22c4.78-.756 8.437-4.92 8.437-9.94z"/></svg>
            </a>

            <button
                type="button"
                @click="navigator.clipboard.writeText(@js($postUrl)); copied = true; setTimeout(() => copied = false, 2000)"
                aria-label="Copy link"
                class="grid size-9 place-items-center rounded-full border border-zinc-300 text-zinc-600 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-300"
            >
                <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"/></svg>
                <svg x-show="copied" x-cloak xmlns="http://www.w3.org/2000/svg" class="size-4 text-emerald-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 13l4 4L19 7"/></svg>
            </button>
        </div>
    </article>
</x-layouts.app>
