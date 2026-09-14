@props(['project'])

@php
    $palettes = [
        'from-indigo-500 to-violet-500',
        'from-violet-500 to-fuchsia-500',
        'from-cyan-500 to-blue-500',
        'from-emerald-500 to-teal-500',
        'from-orange-500 to-rose-500',
        'from-blue-500 to-indigo-500',
    ];
    $palette = $palettes[crc32($project->title) % count($palettes)];
    $initial = strtoupper(substr($project->title, 0, 1));
@endphp

<div class="group relative overflow-hidden rounded-2xl border border-zinc-200 bg-white transition hover:-translate-y-1 hover:border-indigo-400/50 hover:shadow-lg hover:shadow-indigo-500/5 dark:border-white/10 dark:bg-zinc-900">
    <div class="relative flex h-28 items-center justify-center overflow-hidden bg-gradient-to-br {{ $palette }}">
        <div class="bg-grid absolute inset-0 opacity-30"></div>
        <span class="text-5xl font-bold text-white/25">{{ $initial }}</span>
    </div>

    <div class="p-6">
        <div class="flex flex-wrap gap-2">
            @foreach (($project->categories ?? []) as $category)
                <span class="rounded-full bg-indigo-500/10 px-2.5 py-1 text-xs font-medium text-indigo-500 dark:text-indigo-300">{{ $category }}</span>
            @endforeach
        </div>

        <h3 class="mt-4 text-lg font-semibold text-zinc-900 dark:text-white">{{ $project->title }}</h3>
        <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ $project->description }}</p>

        @if ($project->external_url)
            <a href="{{ $project->external_url }}" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-indigo-500 hover:underline dark:text-indigo-400">
                Visit site
                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M7 7h10v10"/></svg>
            </a>
        @endif
    </div>
</div>
