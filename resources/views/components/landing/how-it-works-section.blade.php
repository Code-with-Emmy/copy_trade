@php
    $steps = [
        [
            'title' => 'Discover Expert Traders',
            'copy' => 'Browse verified profiles and compare return history, max drawdown, win rate, and strategy style before a single dollar is allocated.',
            'icon' => 'img/in-theramanuel-18-icon-1.svg',
            'step' => '01',
            'accent' => 'from-emerald-400/20 to-emerald-400/5 border-emerald-400/15',
            'dot' => 'bg-emerald-400',
        ],
        [
            'title' => 'Allocate Your Investment',
            'copy' => 'Set wallet allocation, copy ratio, and risk preference. Full fee visibility — no hidden charges — before you confirm.',
            'icon' => 'img/in-theramanuel-18-icon-2.svg',
            'step' => '02',
            'accent' => 'from-sky-400/20 to-sky-400/5 border-sky-400/15',
            'dot' => 'bg-sky-400',
        ],
        [
            'title' => 'Automatically Copy Trades',
            'copy' => 'Once active, every position the selected trader opens is automatically mirrored into your subscription account in real time.',
            'icon' => 'img/in-theramanuel-18-icon-3.svg',
            'step' => '03',
            'accent' => 'from-violet-400/20 to-violet-400/5 border-violet-400/15',
            'dot' => 'bg-violet-400',
        ],
        [
            'title' => 'Track Your Portfolio',
            'copy' => 'Monitor P/L, allocation exposure, and copied trade outcomes from your investor dashboard with full audit transparency.',
            'icon' => 'img/in-theramanuel-18-icon-4.svg',
            'step' => '04',
            'accent' => 'from-amber-400/20 to-amber-400/5 border-amber-400/15',
            'dot' => 'bg-amber-400',
        ],
    ];
@endphp

<section id="how-it-works" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Section header --}}
    <div class="text-center max-w-3xl mx-auto reveal">
        <span class="inline-block mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-sky-400">How It
            Works</span>
        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl lg:text-5xl leading-tight">
            From discovery to managed<br class="hidden sm:block"> exposure — in four steps.
        </h2>
        <p class="mt-5 text-base text-slate-400 leading-relaxed">
            Everything you need to make informed copy trading decisions. Reviewed, risk-labelled, and fully transparent.
        </p>
    </div>

    {{-- Steps grid --}}
    <div class="mt-14 grid gap-5 md:grid-cols-2 xl:grid-cols-4 reveal" style="transition-delay:.1s">
        @foreach ($steps as $index => $step)
            <article
                class="group relative overflow-hidden rounded-[28px] border bg-gradient-to-b p-6 transition duration-300 hover:-translate-y-1 hover:shadow-panel {{ $step['accent'] }}"
                style="background: linear-gradient(145deg, rgba(16,29,49,.85), rgba(8,18,32,.9));">
                {{-- Step number --}}
                <div class="flex items-center justify-between mb-6">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/[0.06] border border-white/[0.08]">
                        <img src="{{ asset($step['icon']) }}" alt="{{ $step['title'] }}" class="h-6 w-6" loading="lazy">
                    </div>
                    <span class="font-display text-4xl font-bold text-white/8 select-none">{{ $step['step'] }}</span>
                </div>

                <h3 class="text-lg font-bold text-white leading-snug">{{ $step['title'] }}</h3>
                <p class="mt-3 text-sm leading-7 text-slate-400">{{ $step['copy'] }}</p>

                {{-- Bottom connector dot --}}
                @if ($index < count($steps) - 1)
                    <div class="hidden xl:block absolute -right-3 top-1/2 -translate-y-1/2 z-10">
                        <div class="h-2.5 w-2.5 rounded-full {{ $step['dot'] }} ring-4 ring-ink shadow-lg"></div>
                    </div>
                @endif
            </article>
        @endforeach
    </div>
</section>