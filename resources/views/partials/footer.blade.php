<footer class="border-t border-zinc-200 dark:border-white/10">
    <div class="mx-auto max-w-6xl px-6 py-12">
        <div class="grid gap-10 md:grid-cols-3">
            <div>
                <a href="{{ route('home') }}"
                    class="text-lg font-semibold tracking-tight text-zinc-900 dark:text-white">
                    ALIYAN FAISAL<span class="text-gradient">.</span>
                </a>
                <p class="mt-3 max-w-xs text-sm text-zinc-500 dark:text-zinc-400">
                    Full-stack developer building Laravel, WordPress and AI-powered web applications for clients
                    worldwide.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Navigate</h3>
                <ul class="mt-3 space-y-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <li><a href="{{ route('about') }}"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">About</a></li>
                    <li><a href="{{ route('projects.index') }}"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">Projects</a></li>
                    <li><a href="{{ route('services.index') }}"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">Services</a></li>
                    <li><a href="{{ route('contact.create') }}"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">Contact</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Connect</h3>
                <ul class="mt-3 space-y-2 text-sm text-zinc-500 dark:text-zinc-400">
                    <li><a href="https://github.com/aliyanfaisal" target="_blank" rel="noopener"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">GitHub</a></li>
                    <li><a href="https://www.fiverr.com/aliyanfaisal" target="_blank" rel="noopener"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">Fiverr</a></li>
                    <li><a href="https://www.upwork.com/freelancers/~01f763ee3322eda908" target="_blank" rel="noopener"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">Upwork</a></li>
                    <li><a href="mailto:aliyanfaisal15@gmail.com"
                            class="hover:text-indigo-500 dark:hover:text-indigo-400">aliyanfaisal15@gmail.com</a></li>
                </ul>
            </div>
        </div>

        <div
            class="mt-10 flex flex-col items-center justify-between gap-4 border-t border-zinc-200 pt-6 text-xs text-zinc-400 dark:border-white/10 sm:flex-row">
            <p>&copy; {{ date('Y') }} Aliyan Faisal. All rights reserved.</p>
            <p>Built with Laravel &amp; Tailwind CSS.</p>
        </div>
    </div>
</footer>