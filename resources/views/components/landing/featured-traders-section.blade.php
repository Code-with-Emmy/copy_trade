@props(['traders' => collect()])

@php
    $featured = collect($traders)->take(6);
@endphp

<section id="featured-traders" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    {{-- Section header --}}
    <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between reveal">
        <div class="max-w-2xl">
            <span class="inline-block mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-400">Featured
                Traders</span>
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
                High-conviction profiles with<br class="hidden sm:block"> transparent performance data.
            </h2>
            <p class="mt-4 text-sm leading-7 text-slate-400 max-w-xl">
                Each profile surfaces ROI, drawdown, followers, and risk classification — everything you need to decide
                before committing capital.
            </p>
        </div>
        <a href="{{ route('traders.index') }}"
            class="group inline-flex items-center gap-2 shrink-0 text-sm font-semibold text-slate-300 transition hover:text-white">
            View full marketplace
            <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </a>
    </div>

    {{-- Trader cards grid --}}
    <div class="mt-10 grid gap-5 lg:grid-cols-2 xl:grid-cols-3 reveal" style="transition-delay:.1s">
        @forelse ($featured as $trader)
            <x-public.trader-card :trader="$trader" />
        @empty
            {{-- Skeleton placeholders when no traders --}}
            @for ($i = 0; $i < 3; $i++)
                <div class="glass rounded-[28px] p-6 animate-pulse">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 rounded-2xl bg-white/5"></div>
                        <div class="flex-1">
                            <div class="h-4 w-28 rounded-full bg-white/5"></div>
                            <div class="mt-2 h-3 w-20 rounded-full bg-white/[0.03]"></div>
                        </div>
                    </div>
                    <div class="mt-5 grid grid-cols-3 gap-3">
                        @for ($j = 0; $j < 6; $j++)
                            <div class="h-14 rounded-xl bg-white/[0.03]"></div>
                        @endfor
                    </div>
                    <div class="mt-5 h-10 rounded-full bg-white/[0.03]"></div>
                </div>
            @endfor
        @endforelse
    </div>

    {{-- Bottom CTA hint --}}
    @if ($featured->isNotEmpty())
        <div class="mt-10 text-center reveal" style="transition-delay:.2s">
            <p class="text-sm text-slate-500">
                Showing {{ $featured->count() }} of our top-ranked traders.
                <a href="{{ route('traders.index') }}"
                    class="text-emerald-400 hover:text-emerald-300 font-semibold transition ml-1">See all →</a>
            </p>
        </div>
    @endif
</section>