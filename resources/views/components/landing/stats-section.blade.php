@props(['stats' => []])

@php
    $cards = [
        [
            'title' => 'Active Investors',
            'value' => number_format((int) data_get($stats, 'active_investors', 0)) ?: '4,800+',
            'icon' => 'img/in-theramanuel-2-icon-1.png',
            'color' => 'from-emerald-400/20 to-emerald-400/5',
            'border' => 'border-emerald-400/20',
            'badge' => 'text-emerald-300 bg-emerald-400/10',
            'badge_label' => '+12% this month',
        ],
        [
            'title' => 'Verified Traders',
            'value' => number_format((int) data_get($stats, 'verified_traders', 0)) ?: '120+',
            'icon' => 'img/in-theramanuel-2-icon-2.png',
            'color' => 'from-sky-400/20 to-sky-400/5',
            'border' => 'border-sky-400/20',
            'badge' => 'text-sky-300 bg-sky-400/10',
            'badge_label' => 'All audited',
        ],
        [
            'title' => 'Copied Trades',
            'value' => number_format((int) data_get($stats, 'executed_trades', 0)) ?: '180K+',
            'icon' => 'img/in-theramanuel-2-icon-3.png',
            'color' => 'from-violet-400/20 to-violet-400/5',
            'border' => 'border-violet-400/20',
            'badge' => 'text-violet-300 bg-violet-400/10',
            'badge_label' => 'Auto-executed',
        ],
        [
            'title' => 'Assets Managed',
            'value' => '$' . number_format((float) data_get($stats, 'assets_copied', 0), 0) ?: '$12M+',
            'icon' => 'img/in-theramanuel-7-icon-1.png',
            'color' => 'from-amber-400/20 to-amber-400/5',
            'border' => 'border-amber-400/20',
            'badge' => 'text-amber-300 bg-amber-400/10',
            'badge_label' => 'Under management',
        ],
    ];
@endphp

<section id="stats" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-8 reveal">
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
        @foreach ($cards as $card)
            <article
                class="group relative overflow-hidden rounded-3xl border bg-gradient-to-b p-6 transition duration-300 hover:-translate-y-1 hover:shadow-panel {{ $card['color'] }} {{ $card['border'] }}"
                style="background: linear-gradient(145deg, rgba(16,29,49,.85), rgba(8,18,32,.9)); border-color: rgba(148,163,184,.1);">
                {{-- Top icon + badge row --}}
                <div class="flex items-start justify-between gap-3 mb-5">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/[0.06] border border-white/[0.08]">
                        <img src="{{ asset($card['icon']) }}" alt="{{ $card['title'] }} icon" class="h-7 w-7 object-contain"
                            loading="lazy">
                    </div>
                    <span
                        class="rounded-full px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.15em] {{ $card['badge'] }}">
                        {{ $card['badge_label'] }}
                    </span>
                </div>

                {{-- Value --}}
                <p class="font-display text-3xl font-bold text-white">{{ $card['value'] }}</p>
                <p class="mt-1.5 text-xs uppercase tracking-[0.2em] text-slate-500">{{ $card['title'] }}</p>

                {{-- Decorative corner glow --}}
                <div class="pointer-events-none absolute bottom-0 right-0 h-20 w-20 rounded-tl-[40px] bg-gradient-to-tl opacity-20 blur-2xl {{ $card['color'] }}"
                    style="background: inherit"></div>
            </article>
        @endforeach
    </div>
</section>