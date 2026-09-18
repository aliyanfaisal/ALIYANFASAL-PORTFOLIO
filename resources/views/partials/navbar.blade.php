@php
    $navLinks = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Projects', 'route' => 'projects.index'],
        ['label' => 'Services', 'route' => 'services.index'],
        ['label' => 'Blog', 'route' => 'blog.index'],
        ['label' => 'Contact', 'route' => 'contact.create'],
    ];
    $settings = \App\Models\Setting::current();
@endphp

<header
    x-data="{ mobileOpen: false, scrolled: false }"
    x-init="
        scrolled = window.scrollY > 24;
        window.addEventListener('scroll', () => { scrolled = window.scrollY > 24 }, { passive: true });
    "
    class="fixed inset-x-0 top-0 z-50 px-4 py-4"
>
    <div class="mx-auto flex max-w-6xl items-center justify-center">
        <nav
            class="flex w-full items-center gap-1 rounded-full border border-zinc-200/80 bg-white/90 px-2 py-2 shadow-lg shadow-zinc-900/10 backdrop-blur-xl transition-all duration-300 md:w-auto md:max-w-fit dark:border-white/10 dark:bg-zinc-900/90 dark:shadow-black/50 dark:ring-1 dark:ring-white/5"
            :class="scrolled ? 'shadow-xl dark:shadow-black/70' : ''"
        >
            <button @click="mobileOpen = !mobileOpen" type="button" class="grid size-9 shrink-0 place-items-center rounded-full text-zinc-600 transition hover:bg-zinc-900/5 md:hidden dark:text-zinc-300 dark:hover:bg-white/10" aria-label="Toggle menu">
                <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6L6 18"/></svg>
            </button>

            <div class="hidden items-center gap-1 md:flex">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                       class="relative rounded-full px-4 py-2 text-sm font-medium transition {{ request()->routeIs($link['route']) ? 'text-indigo-500 dark:text-indigo-400' : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-300 dark:hover:text-white' }}">
                        @if (request()->routeIs($link['route']))
                            <span class="absolute inset-0 -z-10 rounded-full bg-gradient-to-r from-indigo-500/15 via-violet-500/15 to-cyan-400/15 dark:from-indigo-500/15 dark:via-violet-500/15 dark:to-cyan-400/10"></span>
                        @endif
                        {{ $link['label'] }}
                    </a>
                @endforeach
            </div>

            <a href="{{ route('home') }}" class="flex-1 truncate px-1 text-center text-sm font-semibold tracking-tight text-zinc-900 md:hidden dark:text-white">
                {{ strtoupper($settings->site_name) }}<span class="text-gradient">.</span>
            </a>

            <div class="mx-1 hidden h-6 w-px bg-zinc-200 md:block dark:bg-white/10"></div>

            <button
                @click="$store.theme.toggle()"
                type="button"
                aria-label="Toggle dark mode"
                class="grid size-9 shrink-0 place-items-center rounded-full text-zinc-500 transition hover:bg-zinc-900/5 hover:text-indigo-500 dark:text-zinc-400 dark:hover:bg-white/10 dark:hover:text-indigo-400"
            >
                <svg x-show="$store.theme.value === 'dark'" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                <svg x-show="$store.theme.value !== 'dark'" xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"/></svg>
            </button>

            <a href="{{ route('contact.create') }}" class="ml-1 hidden shrink-0 rounded-full bg-zinc-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-600 md:inline-block dark:bg-white dark:text-zinc-900 dark:hover:bg-indigo-400">
                Hire Me
            </a>
        </nav>
    </div>

    <div
        x-show="mobileOpen"
        x-transition
        x-cloak
        @click.outside="mobileOpen = false"
        class="mx-auto mt-2 max-w-xs rounded-2xl border border-zinc-200/80 bg-white/95 p-2 shadow-xl backdrop-blur-md md:hidden dark:border-white/10 dark:bg-zinc-950/95"
    >
        <div class="flex flex-col gap-1">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   @click="mobileOpen = false"
                   class="rounded-xl px-4 py-2.5 text-sm font-medium {{ request()->routeIs($link['route']) ? 'bg-indigo-500/10 text-indigo-500 dark:text-indigo-400' : 'text-zinc-600 dark:text-zinc-300' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('contact.create') }}" @click="mobileOpen = false" class="mt-1 rounded-xl bg-zinc-900 px-4 py-2.5 text-center text-sm font-medium text-white dark:bg-white dark:text-zinc-900">
                Hire Me
            </a>
        </div>
    </div>
</header>
