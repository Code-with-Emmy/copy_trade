{{--
Features Section — mirrors BitCloven's "Start copying high-performance traders" panel.
5 feature cards: Leaderboard · Risk Guard · Community Signals · Edge · Analytics
--}}

@php
    $features = [
        [
            'icon' => 'img/in-theramanuel-18-icon-1.svg',
            'title' => 'Real-time Leaderboard',
            'copy' => 'Track verified trader performance with live win rates, drawdowns, and risk scores in a live-ranked marketplace.',
            'badge' => 'Live',
            'color' => 'emerald',
        ],
        [
            'icon' => 'img/in-theramanuel-18-icon-2.svg',
            'title' => 'Dynamic Risk Guard',
            'copy' => 'Set equity stops, copy ratios, and allocation limits to protect your capital automatically — no manual intervention needed.',
            'badge' => 'Smart',
            'color' => 'sky',
        ],
        [
            'icon' => 'img/in-theramanuel-18-icon-3.svg',
            'title' => 'Community Signals',
            'copy' => 'Access live strategy discussions, trader insights, and AMAs to understand the rationale behind every mirrored move.',
            'badge' => 'Social',
            'color' => 'violet',
        ],
        [
            'icon' => 'img/in-theramanuel-18-icon-4.svg',
            'title' => 'Platform Edge',
            'copy' => 'We unite proven traders with modern automation. Monitor mirrored positions with granular trade logs and customisable alerts.',
            'badge' => 'Pro',
            'color' => 'amber',
        ],
        [
            'icon' => 'img/in-theramanuel-6-icon-1.png',
            'title' => 'Performance Analytics',
            'copy' => 'Break down copied trades by strategy, asset class, and time horizon — staying informed so you can react faster.',
            'badge' => 'Insight',
            'color' => 'rose',
        ],
    ];

    $colorMap = [
        'emerald' => ['pill' => 'bg-emerald-400/12 text-emerald-300 border-emerald-400/20', 'icon' => 'bg-emerald-400/12', 'glow' => 'from-emerald-400/15'],
        'sky' => ['pill' => 'bg-sky-400/12 text-sky-300 border-sky-400/20', 'icon' => 'bg-sky-400/12', 'glow' => 'from-sky-400/15'],
        'violet' => ['pill' => 'bg-violet-400/12 text-violet-300 border-violet-400/20', 'icon' => 'bg-violet-400/12', 'glow' => 'from-violet-400/15'],
        'amber' => ['pill' => 'bg-amber-400/12 text-amber-300 border-amber-400/20', 'icon' => 'bg-amber-400/12', 'glow' => 'from-amber-400/15'],
        'rose' => ['pill' => 'bg-rose-400/12 text-rose-300 border-rose-400/20', 'icon' => 'bg-rose-400/12', 'glow' => 'from-rose-400/15'],
    ];
@endphp

<section id="features" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Header --}}
    <div class="text-center max-w-3xl mx-auto mb-14 reveal">
        <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.28em] text-emerald-400">Platform
            Features</span>
        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl lg:text-[2.6rem] leading-tight">
            Start copying high-performance<br class="hidden sm:block"> traders today.
        </h2>
        <p class="mt-5 text-base text-slate-400 leading-relaxed">
            Every tool you need to discover, copy, and track elite traders — all in one intelligent platform.
        </p>
    </div>

    {{-- Feature cards: 2-3 grid on large, scrollable on mobile --}}
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 reveal" style="transition-delay:.08s">
        @foreach ($features as $idx => $feat)
            @php $c = $colorMap[$feat['color']]; @endphp
            <article
                class="group glass relative overflow-hidden rounded-[28px] p-6 transition duration-300 hover:-translate-y-1.5 hover:border-white/20 hover:shadow-panel {{ $idx === 4 ? 'sm:col-span-2 lg:col-span-1' : '' }}">
                {{-- Corner glow --}}
                <div
                    class="pointer-events-none absolute -right-8 -top-8 h-24 w-24 rounded-full bg-gradient-to-br {{ $c['glow'] }} to-transparent blur-2xl opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                </div>

                {{-- Icon + badge --}}
                <div class="flex items-start justify-between mb-5">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $c['icon'] }}">
                        <img src="{{ asset($feat['icon']) }}" alt="{{ $feat['title'] }}" class="h-6 w-6" loading="lazy">
                    </div>
                    <span
                        class="rounded-full border px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] {{ $c['pill'] }}">
                        {{ $feat['badge'] }}
                    </span>
                </div>

                <h3 class="text-[1.05rem] font-bold text-white leading-snug">{{ $feat['title'] }}</h3>
                <p class="mt-3 text-sm leading-7 text-slate-400">{{ $feat['copy'] }}</p>
            </article>
        @endforeach
    </div>
</section>