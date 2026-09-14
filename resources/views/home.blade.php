<x-layouts.app title="Aliyan Faisal — AI-Powered Full-Stack Laravel & WordPress Developer" description="Aliyan Faisal builds AI-powered Laravel and WordPress products — integrating OpenAI, Claude and Gemini into automated, production-ready web apps.">
    {{-- Hero --}}
    <section class="glow-gradient relative overflow-hidden pt-20">
        <div class="bg-grid absolute inset-0 -z-10"></div>

        {{-- ambient floating tech icons --}}
        <div class="pointer-events-none absolute inset-0 -z-10 hidden overflow-hidden sm:block" aria-hidden="true">
            <span class="animate-float absolute left-[6%] top-[18%] text-2xl opacity-[0.12] blur-[0.5px]" style="animation-delay: 0.2s">💻</span>
            <span class="animate-float absolute left-[16%] top-[68%] text-xl opacity-[0.1] blur-[0.5px]" style="animation-delay: 2.1s">🐘</span>
            <span class="animate-float absolute left-[38%] top-[8%] text-lg opacity-[0.14] blur-[0.5px]" style="animation-delay: 1.3s">🧠</span>
            <span class="animate-float absolute left-[30%] top-[85%] text-xl opacity-[0.1] blur-[0.5px]" style="animation-delay: 3.4s">🗄️</span>
            <span class="animate-float absolute right-[8%] top-[10%] text-xl opacity-[0.12] blur-[0.5px]" style="animation-delay: 0.8s">☁️</span>
            <span class="animate-float absolute right-[4%] top-[55%] text-lg opacity-[0.1] blur-[0.5px]" style="animation-delay: 2.6s">🔗</span>
            <span class="animate-float absolute right-[20%] top-[88%] text-xl opacity-[0.12] blur-[0.5px]" style="animation-delay: 1.8s">🛒</span>
            <span class="animate-float absolute left-[48%] top-[45%] text-lg opacity-[0.1] blur-[0.5px]" style="animation-delay: 4s">✨</span>
        </div>

        <div class="mx-auto grid max-w-6xl gap-12 px-6 pb-16 pt-6 md:grid-cols-2 md:items-center md:pb-24 md:pt-10">
            <div>
                <p class="inline-flex items-center gap-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-500 dark:text-indigo-300">
                    <span class="relative flex size-1.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex size-1.5 rounded-full bg-emerald-400"></span>
                    </span>
                    Available for AI &amp; web development projects
                </p>

                <h1 class="mt-6 text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                    Building
                    <span
                        x-data="{
                            words: ['AI-Powered', 'Laravel & WordPress', 'AI-Automated', 'Chatbot-Ready'],
                            i: 0,
                            visible: true,
                        }"
                        x-init="setInterval(() => { visible = false; setTimeout(() => { i = (i + 1) % words.length; visible = true }, 250) }, 2400)"
                        class="text-gradient block transition-all duration-300"
                        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 -translate-y-1'"
                        x-text="words[i]"
                    >AI-Powered</span>
                    web products.
                </h1>

                <p class="mt-6 max-w-xl text-lg text-zinc-600 dark:text-zinc-400">
                    I'm Aliyan Faisal, a full-stack developer who builds custom Laravel and WordPress products — and increasingly, bakes AI directly in: chatbots, automation, and API integrations with OpenAI, Claude and Gemini. 5+ years turning ideas into production-ready web apps for clients worldwide.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('contact.create') }}" class="rounded-full bg-zinc-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-indigo-400">
                        Start a Project
                    </a>
                    <a href="{{ route('projects.index') }}" class="rounded-full border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-200">
                        View My Work
                    </a>
                </div>

                <dl class="mt-12 grid grid-cols-3 gap-6 border-t border-zinc-200 pt-8 dark:border-white/10">
                    <div>
                        <dt class="text-2xl font-bold text-zinc-900 dark:text-white">5+</dt>
                        <dd class="text-xs text-zinc-500 dark:text-zinc-400">Years Experience</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-bold text-zinc-900 dark:text-white">260+</dt>
                        <dd class="text-xs text-zinc-500 dark:text-zinc-400">Projects Delivered</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-bold text-zinc-900 dark:text-white">5★</dt>
                        <dd class="text-xs text-zinc-500 dark:text-zinc-400">Fiverr Rating (205)</dd>
                    </div>
                </dl>
            </div>

            <div class="relative mx-auto w-full max-w-sm">
                {{-- spotlight glow behind subject --}}
                <div class="absolute left-1/2 top-1/2 -z-10 h-[110%] w-[85%] -translate-x-1/2 -translate-y-1/2 animate-pulse-slow rounded-full bg-gradient-to-br from-indigo-500/50 via-violet-500/40 to-cyan-400/40 blur-3xl"></div>

                {{-- orbiting ring accents --}}
                <div class="absolute inset-0 -z-10 rounded-full border border-indigo-400/20"></div>
                <div class="absolute -inset-6 -z-10 rounded-full border border-dashed border-violet-400/15"></div>
                <div class="absolute -inset-12 -z-10 rounded-full border border-cyan-400/10"></div>

                {{-- ambient particles --}}
                <span class="absolute -left-10 top-4 -z-10 size-2 animate-float rounded-full bg-indigo-400/60 blur-[1px]" style="animation-delay: 0.5s"></span>
                <span class="absolute -right-8 top-20 -z-10 size-1.5 animate-float rounded-full bg-cyan-400/60 blur-[1px]" style="animation-delay: 1.8s"></span>
                <span class="absolute left-2 -top-6 -z-10 size-1.5 animate-float rounded-full bg-violet-400/60 blur-[1px]" style="animation-delay: 3s"></span>
                <span class="absolute -right-4 bottom-24 -z-10 size-2 animate-float rounded-full bg-indigo-400/50 blur-[1px]" style="animation-delay: 0.9s"></span>
                <span class="absolute -left-6 bottom-4 -z-10 size-1.5 animate-float rounded-full bg-cyan-400/50 blur-[1px]" style="animation-delay: 2.4s"></span>

                <img src="{{ asset('images/aliyan-headshot-cutout.png') }}" alt="Aliyan Faisal" class="fade-top relative z-10 mx-auto h-auto w-[85%] drop-shadow-[0_20px_40px_rgba(79,70,229,0.35)] sm:w-full">

                {{-- grounding shadow --}}
                <div class="mx-auto -mt-6 h-6 w-2/3 rounded-full bg-zinc-900/20 blur-xl dark:bg-black/40"></div>

                <div class="glass-card animate-float absolute -left-10 top-2 z-20 hidden w-40 lg:block" style="animation-delay: 0s">
                    <p class="text-lg">🤖</p>
                    <p class="mt-1 text-xs font-semibold text-zinc-800 dark:text-zinc-100">AI Integrations</p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">OpenAI · Claude · Gemini</p>
                </div>

                <div class="glass-card animate-float absolute -right-4 top-1/4 z-20 w-36" style="animation-delay: 1.2s">
                    <p class="text-lg">⭐</p>
                    <p class="mt-1 text-xs font-semibold text-zinc-800 dark:text-zinc-100">5.0 Rating</p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">205 Fiverr reviews</p>
                </div>

                <div class="glass-card animate-float absolute -left-6 top-[35%] z-20 hidden w-36 lg:block" style="animation-delay: 1.8s">
                    <p class="text-lg">🚀</p>
                    <p class="mt-1 text-xs font-semibold text-zinc-800 dark:text-zinc-100">Fast Delivery</p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">Avg. 1–3 day turnaround</p>
                </div>

                <div class="glass-card animate-float absolute -left-2 bottom-10 z-20 w-44" style="animation-delay: 2.4s">
                    <p class="text-lg">⚡</p>
                    <p class="mt-1 text-xs font-semibold text-zinc-800 dark:text-zinc-100">260+ Projects Shipped</p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">Laravel · WordPress · AI</p>
                </div>

                <div class="glass-card animate-float absolute -right-6 bottom-0 z-20 hidden w-36 sm:block" style="animation-delay: 3.2s">
                    <p class="text-lg">🏆</p>
                    <p class="mt-1 text-xs font-semibold text-zinc-800 dark:text-zinc-100">Level 2 Seller</p>
                    <p class="text-[11px] text-zinc-500 dark:text-zinc-400">Fiverr verified</p>
                </div>
            </div>
        </div>

        {{-- Tech marquee --}}
        <div class="border-t border-zinc-200 py-6 dark:border-white/10">
            <div class="overflow-hidden">
                <div class="animate-marquee flex w-max items-center gap-12 text-sm font-medium text-zinc-400 dark:text-zinc-500">
                    @php
                        $stack = ['Laravel', 'WordPress', 'WooCommerce', 'OpenAI', 'Claude', 'Gemini', 'Groq', 'Tailwind CSS', 'MySQL', 'REST APIs', 'Elementor Pro', 'Vue / React'];
                        $stack = array_merge($stack, $stack);
                    @endphp
                    @foreach ($stack as $tech)
                        <span class="flex items-center gap-2 whitespace-nowrap">
                            <span class="size-1.5 rounded-full bg-indigo-400/70"></span>
                            {{ $tech }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Services --}}
    @if ($featuredServices->isNotEmpty())
        <section class="reveal border-b border-zinc-200 py-20 dark:border-white/10">
            <div class="mx-auto max-w-6xl px-6">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-widest text-indigo-500 dark:text-indigo-400">Hire Me On Fiverr</p>
                        <h2 class="mt-2 text-2xl font-bold text-zinc-900 dark:text-white">Popular Services</h2>
                    </div>
                    <a href="{{ route('services.index') }}" class="text-sm font-medium text-indigo-500 hover:underline dark:text-indigo-400">View all &rarr;</a>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @php $topRatingCount = $featuredServices->max('rating_count'); @endphp
                    @foreach ($featuredServices as $service)
                        <x-service-card :service="$service" :bestSeller="$service->rating_count === $topRatingCount && $topRatingCount > 0" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Skills --}}
    @php
        $skillIcons = [
            'Backend' => '⚙️',
            'CMS' => '🌐',
            'AI & Automation' => '🤖',
            'Frontend' => '🎨',
            'DevOps' => '🖥️',
            'Security & Performance' => '🛡️',
        ];
        $categoryColors = [
            'Backend' => ['grad' => 'from-indigo-500 to-blue-500', 'tint' => 'from-indigo-500/10 via-blue-500/5 to-transparent', 'border' => 'hover:border-indigo-400/40', 'glow' => 'hover:shadow-indigo-500/10'],
            'CMS' => ['grad' => 'from-violet-500 to-fuchsia-500', 'tint' => 'from-violet-500/10 via-fuchsia-500/5 to-transparent', 'border' => 'hover:border-violet-400/40', 'glow' => 'hover:shadow-violet-500/10'],
            'AI & Automation' => ['grad' => 'from-cyan-500 to-indigo-500', 'tint' => 'from-cyan-500/10 via-indigo-500/5 to-transparent', 'border' => 'hover:border-cyan-400/40', 'glow' => 'hover:shadow-cyan-500/10'],
            'Frontend' => ['grad' => 'from-rose-500 to-orange-400', 'tint' => 'from-rose-500/10 via-orange-400/5 to-transparent', 'border' => 'hover:border-rose-400/40', 'glow' => 'hover:shadow-rose-500/10'],
            'DevOps' => ['grad' => 'from-emerald-500 to-teal-500', 'tint' => 'from-emerald-500/10 via-teal-500/5 to-transparent', 'border' => 'hover:border-emerald-400/40', 'glow' => 'hover:shadow-emerald-500/10'],
            'Security & Performance' => ['grad' => 'from-amber-500 to-red-500', 'tint' => 'from-amber-500/10 via-red-500/5 to-transparent', 'border' => 'hover:border-amber-400/40', 'glow' => 'hover:shadow-amber-500/10'],
        ];
        $defaultColor = ['grad' => 'from-indigo-500 to-cyan-400', 'tint' => 'from-indigo-500/10 via-cyan-400/5 to-transparent', 'border' => 'hover:border-indigo-400/40', 'glow' => 'hover:shadow-indigo-500/10'];
    @endphp
    @if ($skills->isNotEmpty())
        <section class="mx-auto max-w-6xl px-6 py-16">
            <p class="reveal text-center text-sm font-semibold uppercase tracking-widest text-zinc-400">Core Expertise</p>
            <h2 class="reveal mt-2 text-center text-2xl font-bold text-zinc-900 dark:text-white">The stack behind every build</h2>
            <p class="reveal mx-auto mt-2 max-w-md text-center text-sm text-zinc-500 dark:text-zinc-400">Hover a card to see proficiency.</p>

            <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($skills as $skill)
                    @php $c = $categoryColors[$skill->category] ?? $defaultColor; @endphp
                    <div
                        class="group reveal relative overflow-hidden rounded-2xl border border-zinc-200 bg-zinc-50 p-4 text-center transition-all duration-300 hover:-translate-y-1.5 hover:shadow-xl dark:border-white/10 dark:bg-white/5 {{ $c['border'] }} {{ $c['glow'] }}"
                        style="transition-delay: {{ ($loop->index % 4) * 70 }}ms"
                    >
                        <div class="absolute inset-0 -z-10 bg-gradient-to-br {{ $c['tint'] }} opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                        <div class="mx-auto grid size-11 place-items-center rounded-xl bg-gradient-to-br {{ $c['grad'] }} text-lg text-white shadow-md transition-transform duration-300 group-hover:scale-110 group-hover:rotate-6">
                            {{ $skillIcons[$skill->category] ?? '🔧' }}
                        </div>
                        <p class="mt-3 text-sm font-semibold text-zinc-800 dark:text-zinc-100">{{ $skill->name }}</p>
                        <p class="text-[10px] uppercase tracking-wide text-zinc-400">{{ $skill->category }}</p>

                        <div class="mt-3 h-1.5 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-white/10">
                            <div class="skill-fill h-full rounded-full bg-gradient-to-r {{ $c['grad'] }}" style="width: 0%" data-width="{{ $skill->proficiency }}"></div>
                        </div>
                        <p class="mt-1.5 text-[11px] font-medium text-zinc-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100 dark:text-zinc-400">
                            {{ $skill->proficiency }}% proficiency
                        </p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Skills & Expertise (full breakdown) --}}
    @if ($allSkills->isNotEmpty())
        <section class="reveal border-t border-zinc-200 bg-zinc-50 py-20 dark:border-white/10 dark:bg-white/[0.02]">
            <div class="mx-auto max-w-6xl px-6">
                <p class="text-center text-sm font-semibold uppercase tracking-widest text-indigo-500 dark:text-indigo-400">Full Skill Breakdown</p>
                <h2 class="mt-2 text-center text-2xl font-bold text-zinc-900 dark:text-white">Skills &amp; Expertise</h2>

                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($allSkills->groupBy('category') as $category => $categorySkills)
                        @php $c = $categoryColors[$category] ?? $defaultColor; @endphp
                        <div class="reveal rounded-2xl border border-zinc-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg dark:border-white/10 dark:bg-zinc-900 {{ $c['border'] }} {{ $c['glow'] }}">
                            <div class="flex items-center gap-2.5">
                                <div class="grid size-8 place-items-center rounded-lg bg-gradient-to-br {{ $c['grad'] }} text-sm text-white shadow-sm">
                                    {{ $skillIcons[$category] ?? '🔧' }}
                                </div>
                                <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ $category }}</h3>
                            </div>

                            <div class="mt-5 space-y-4">
                                @foreach ($categorySkills as $skill)
                                    <div>
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="font-medium text-zinc-700 dark:text-zinc-200">{{ $skill->name }}</span>
                                            <span class="text-zinc-400">{{ $skill->proficiency }}%</span>
                                        </div>
                                        <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-zinc-200 dark:bg-white/10">
                                            <div class="skill-fill h-full rounded-full bg-gradient-to-r {{ $c['grad'] }}" style="width: 0%" data-width="{{ $skill->proficiency }}"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Connect --}}
    <section class="reveal border-t border-zinc-200 py-20 dark:border-white/10">
        <div class="mx-auto max-w-6xl px-6">
            <p class="text-center text-sm font-semibold uppercase tracking-widest text-indigo-500 dark:text-indigo-400">Where to Find Me</p>
            <h2 class="mt-2 text-center text-2xl font-bold text-zinc-900 dark:text-white">Let's Connect</h2>

            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $platforms = [
                        [
                            'name' => 'Fiverr',
                            'subtitle' => '5★ · 200+ reviews',
                            'url' => 'https://www.fiverr.com/aliyanfaisal',
                            'badge' => 'bg-[#1dbf73]',
                            'icon' => '<path d="M9 12.75L11.25 15 15 9.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/><circle cx="12" cy="12" r="9" stroke="white" stroke-width="2" fill="none"/>',
                        ],
                        [
                            'name' => 'Upwork',
                            'subtitle' => 'Top Rated Freelancer',
                            'url' => 'https://www.upwork.com/freelancers/~01f763ee3322eda908',
                            'badge' => 'bg-[#14a800]',
                            'icon' => '<text x="12" y="16.5" text-anchor="middle" font-size="10.5" font-weight="700" fill="white" font-family="Arial, sans-serif">Up</text>',
                        ],
                        [
                            'name' => 'LinkedIn',
                            'subtitle' => 'Connect professionally',
                            'url' => 'https://www.linkedin.com/in/aliyan-faisal-5162261b7/',
                            'badge' => 'bg-[#0a66c2]',
                            'icon' => '<path d="M6.94 8.5H4.56V19h2.38V8.5zM5.75 4.75a1.38 1.38 0 100 2.76 1.38 1.38 0 000-2.76zM19.44 19h-2.37v-5.4c0-1.29-.46-2.16-1.6-2.16-.88 0-1.4.59-1.63 1.16-.08.2-.1.49-.1.77V19H11.4s.03-9.6 0-10.5h2.37v1.49a2.35 2.35 0 012.13-1.18c1.56 0 2.73 1.02 2.73 3.2V19z" fill="white"/>',
                        ],
                        [
                            'name' => 'Email',
                            'subtitle' => 'aliyanfaisal15@gmail.com',
                            'url' => 'mailto:aliyanfaisal15@gmail.com',
                            'badge' => 'bg-indigo-500',
                            'icon' => '<path d="M4 4h16v16H4z" stroke="white" stroke-width="2" fill="none" stroke-linejoin="round"/><path d="M22 6l-10 7L2 6" stroke="white" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>',
                        ],
                    ];
                @endphp
                @foreach ($platforms as $platform)
                    <a
                        href="{{ $platform['url'] }}"
                        @if (!str_starts_with($platform['url'], 'mailto:')) target="_blank" rel="noopener" @endif
                        class="group flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-5 transition hover:-translate-y-1 hover:border-indigo-400/40 hover:shadow-lg hover:shadow-indigo-500/5 dark:border-white/10 dark:bg-zinc-900"
                    >
                        <span class="grid size-11 shrink-0 place-items-center rounded-xl {{ $platform['badge'] }} shadow-sm transition group-hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5">{!! $platform['icon'] !!}</svg>
                        </span>
                        <span class="min-w-0">
                            <span class="block text-sm font-semibold text-zinc-900 dark:text-white">{{ $platform['name'] }}</span>
                            <span class="block truncate text-xs text-zinc-500 dark:text-zinc-400">{{ $platform['subtitle'] }}</span>
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-auto size-4 shrink-0 text-zinc-300 transition group-hover:translate-x-0.5 group-hover:text-indigo-400 dark:text-zinc-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M7 17L17 7M7 7h10v10"/></svg>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- AI-Powered Development --}}
    @if ($aiService)
        <section class="reveal glow-gradient relative overflow-hidden border-t border-zinc-200 py-20 dark:border-white/10">
            <div class="bg-grid absolute inset-0 -z-10 opacity-60"></div>
            <div class="mx-auto max-w-6xl px-6">
                <div class="grid gap-10 md:grid-cols-2 md:items-center">
                    <div>
                        <p class="inline-flex items-center gap-2 rounded-full border border-indigo-500/30 bg-indigo-500/10 px-3 py-1 text-xs font-medium text-indigo-500 dark:text-indigo-300">
                            🤖 AI &amp; Automation
                        </p>
                        <h2 class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white">I build AI into the web apps I ship.</h2>
                        <p class="mt-4 text-zinc-600 dark:text-zinc-400">
                            Beyond Laravel and WordPress, I integrate AI agent APIs — OpenAI, Claude, Gemini and Groq — to automate the repetitive parts of running a store or site: customer support, order handling, content and SEO.
                        </p>
                        <a href="{{ route('services.show', $aiService) }}" class="mt-6 inline-flex items-center gap-1 text-sm font-semibold text-indigo-500 hover:underline dark:text-indigo-400">
                            See the AI automation service &rarr;
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        @php
                            $aiCards = [
                                ['icon' => '💬', 'title' => 'AI Chatbots', 'desc' => '24/7 support trained on your products, FAQs and policies.'],
                                ['icon' => '⚙️', 'title' => 'Workflow Automation', 'desc' => 'Automate orders, emails and repetitive store tasks.'],
                                ['icon' => '🔌', 'title' => 'API Integrations', 'desc' => 'Connect your app to OpenAI, Claude, Gemini & Groq.'],
                                ['icon' => '📈', 'title' => 'AI SEO & Content', 'desc' => 'Generate product copy, meta tags & keyword content.'],
                                ['icon' => '🧩', 'title' => 'Custom AI Products', 'desc' => 'Design and build bespoke AI-powered tools and products from the ground up.', 'span' => true],
                            ];
                        @endphp
                        @foreach ($aiCards as $card)
                            <div class="group rounded-2xl border border-zinc-200 bg-white p-5 transition hover:-translate-y-1 hover:border-indigo-400/40 hover:shadow-lg hover:shadow-indigo-500/10 dark:border-white/10 dark:bg-zinc-900 {{ $card['span'] ?? false ? 'col-span-2' : '' }}">
                                <div class="grid size-10 place-items-center rounded-xl bg-gradient-to-br from-indigo-500/15 via-violet-500/15 to-cyan-400/15 text-lg transition group-hover:scale-110">
                                    {{ $card['icon'] }}
                                </div>
                                <p class="mt-3 text-sm font-semibold text-zinc-900 dark:text-white">{{ $card['title'] }}</p>
                                <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ $card['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured Projects --}}
    @if ($featuredProjects->isNotEmpty())
        <section class="reveal border-t border-zinc-200 bg-zinc-50 py-20 dark:border-white/10 dark:bg-white/[0.02]">
            <div class="mx-auto max-w-6xl px-6">
                <div class="flex items-end justify-between">
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Featured Projects</h2>
                    <a href="{{ route('projects.index') }}" class="text-sm font-medium text-indigo-500 hover:underline dark:text-indigo-400">View all &rarr;</a>
                </div>

                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($featuredProjects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if ($testimonials->isNotEmpty())
        <section class="reveal border-t border-zinc-200 bg-zinc-50 py-20 dark:border-white/10 dark:bg-white/[0.02]">
            <div class="mx-auto max-w-6xl px-6">
                <p class="text-center text-sm font-semibold uppercase tracking-widest text-indigo-500 dark:text-indigo-400">{{ $testimonials->count() }}+ Five-Star Reviews</p>
                <h2 class="mt-2 text-center text-2xl font-bold text-zinc-900 dark:text-white">What Clients Say</h2>

                <div x-data="{ expanded: false }" class="mt-10">
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($testimonials as $testimonial)
                            <blockquote
                                @if ($loop->index >= 6) x-show="expanded" x-transition x-cloak @endif
                                class="group relative rounded-2xl border border-zinc-200 bg-white p-6 transition hover:-translate-y-1 hover:border-indigo-400/40 hover:shadow-lg hover:shadow-indigo-500/5 dark:border-white/10 dark:bg-zinc-900"
                            >
                                <svg class="absolute right-6 top-6 size-8 text-indigo-500/10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M9.983 3v7.391c0 5.704-3.731 9.57-8.983 10.609l-.995-2.151c2.432-.917 3.995-3.638 3.995-5.849h-4v-10h9.983zm14.017 0v7.391c0 5.704-3.748 9.571-9 10.609l-.996-2.151c2.433-.917 3.996-3.638 3.996-5.849h-3.983v-10h9.983z"/></svg>
                                <div class="flex items-center gap-2">
                                    <div class="flex gap-0.5 text-amber-400">
                                        @for ($i = 0; $i < $testimonial->rating; $i++)
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-4"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.958a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.37 2.448a1 1 0 00-.363 1.118l1.287 3.957c.3.922-.755 1.688-1.538 1.118l-3.37-2.448a1 1 0 00-1.176 0l-3.37 2.448c-.783.57-1.838-.196-1.539-1.118l1.287-3.957a1 1 0 00-.363-1.118l-3.37-2.448c-.782-.57-.38-1.81.588-1.81h4.163a1 1 0 00.95-.69l1.285-3.958z"/></svg>
                                        @endfor
                                    </div>
                                    @if ($testimonial->source)
                                        <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-[10px] font-medium text-zinc-500 dark:bg-white/5 dark:text-zinc-400">{{ $testimonial->source }}</span>
                                    @endif
                                </div>
                                <p class="mt-4 text-sm text-zinc-600 dark:text-zinc-300">&ldquo;{{ $testimonial->content }}&rdquo;</p>
                                <div class="mt-5 flex items-center gap-3">
                                    <div class="grid size-9 shrink-0 place-items-center rounded-full bg-gradient-to-br from-indigo-500 to-cyan-400 text-xs font-semibold text-white">
                                        {{ strtoupper(substr($testimonial->client_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <cite class="block text-sm font-semibold not-italic text-zinc-900 dark:text-white">{{ $testimonial->client_name }}</cite>
                                        @if ($testimonial->country)
                                            <span class="text-xs text-zinc-400">{{ $testimonial->country }}</span>
                                        @endif
                                    </div>
                                </div>
                            </blockquote>
                        @endforeach
                    </div>

                    @if ($testimonials->count() > 6)
                        <div class="mt-10 text-center">
                            <button
                                @click="expanded = !expanded"
                                type="button"
                                class="inline-flex items-center gap-2 rounded-full border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-200"
                            >
                                <span x-text="expanded ? 'Show Less' : 'View More Reviews'"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 transition" :class="expanded && 'rotate-180'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="reveal py-20">
        <div class="glow-gradient relative mx-auto max-w-4xl overflow-hidden rounded-3xl border border-indigo-500/20 px-6 py-16 text-center">
            <div class="bg-grid absolute inset-0 -z-10 opacity-50"></div>
            <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">Have a project in mind?</h2>
            <p class="mt-4 text-zinc-600 dark:text-zinc-400">Let's talk about what you're building and how I can help you ship it — Laravel, WordPress, or AI-powered from the ground up.</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('contact.create') }}" class="rounded-full bg-zinc-900 px-8 py-3 text-sm font-semibold text-white transition hover:bg-indigo-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-indigo-400">
                    Get in Touch
                </a>
                <a href="https://wa.me/923155687559" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-full border border-zinc-300 px-6 py-3 text-sm font-semibold text-zinc-700 transition hover:border-indigo-400 hover:text-indigo-500 dark:border-white/15 dark:text-zinc-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.94 11.94 0 0012.06 0C5.5 0 .18 5.32.18 11.88c0 2.1.55 4.14 1.6 5.94L0 24l6.34-1.66a11.86 11.86 0 005.72 1.46h.01c6.56 0 11.88-5.32 11.88-11.88 0-3.17-1.24-6.15-3.43-8.44Z"/></svg>
                    WhatsApp Me
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
