<x-layouts.app title="Services — Aliyan Faisal">
    <section class="mx-auto max-w-4xl px-6 py-16 text-center">
        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-500 dark:text-indigo-400">Services</p>
        <h1 class="mt-3 text-4xl font-bold text-zinc-900 dark:text-white">Hire Me on Fiverr</h1>
        <p class="mx-auto mt-4 max-w-2xl text-lg text-zinc-600 dark:text-zinc-400">
            Level 2 Seller with a 5★ rating across 200+ reviews. Pick a service below or
            <a href="{{ route('contact.create') }}" class="font-medium text-indigo-500 hover:underline dark:text-indigo-400">get in touch</a> for something custom.
        </p>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-20">
        @php $topRatingCount = $services->max('rating_count'); @endphp
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($services as $service)
                <x-service-card :service="$service" :bestSeller="$service->rating_count === $topRatingCount && $topRatingCount > 0" />
            @endforeach
        </div>
    </section>
</x-layouts.app>
