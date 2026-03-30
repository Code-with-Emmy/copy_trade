@props([
    'trader',
    'compact' => false,
    'watchlisted' => false,
])

@php
    $markets = collect(explode(',', (string) ($trader->markets_traded ?: $trader->preferred_instruments ?: 'Forex, Crypto')))
        ->map(fn ($item) => trim($item))
        ->filter()
        ->take($compact ? 2 : 3);
    $profileRoute = route('traders.show', $trader->slug ?: $trader->id);
    $copyRoute = auth()->check() ? route('copy.show', $trader->slug ?: $trader->id) : route('register');
    $monthlyRoi = (float) ($trader->monthly_roi ?? 0);
    $yearlyRoi = (float) ($trader->yearly_roi ?? 0);
    $maxDrawdown = (float) ($trader->max_drawdown ?? 0);
    $winRate = (float) ($trader->win_rate ?? 0);
    $followers = (int) ($trader->followers ?? 0);
    $aum = (float) ($trader->aum ?? 0);
    $fallbackAvatars = [
        'img/in-theramanuel-4-avatar-1.png',
        'img/in-theramanuel-4-avatar-2.png',
        'img/in-theramanuel-4-avatar-3.png',
        'img/in-theramanuel-4-avatar-4.png',
    ];
    $avatar = $trader->photo
        ? asset('storage/' . $trader->photo)
        : asset($fallbackAvatars[$trader->getKey() % count($fallbackAvatars)]);
@endphp

<article
    {{ $attributes->class('group relative overflow-hidden rounded-[30px] border border-white/10 bg-gradient-to-br from-[#0c1320] via-[#0a111c] to-[#070d16] p-5 shadow-[0_18px_60px_-30px_rgba(2,6,23,.95)] transition duration-300 hover:-translate-y-0.5 hover:border-white/20 sm:p-6') }}>
    <div class="pointer-events-none absolute -right-10 -top-10 h-28 w-28 rounded-full bg-yellow-400/12 blur-3xl"></div>
    <div class="pointer-events-none absolute -left-12 -bottom-12 h-28 w-28 rounded-full bg-yellow-500/10 blur-3xl"></div>

    <div class="relative flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
        <div class="flex min-w-0 items-center gap-4">
            <img src="{{ $avatar }}" alt="{{ $trader->name }}"
                class="h-14 w-14 rounded-2xl border border-white/10 object-cover shadow-[0_0_0_1px_rgba(15,23,42,.65)]">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="truncate font-display text-lg font-bold text-white">{{ $trader->name }}</h3>
                    <x-public.verified-badge :status="$trader->verification_status ?: 'pending'" />
                </div>
                <p class="mt-1 truncate text-sm text-slate-400">
                    {{ $trader->strategy_type ?: ($trader->trading_style ?: 'Multi-asset discretionary') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2 self-end sm:self-auto">
            @auth
                <form method="POST" action="{{ route('copy.watchlist.toggle', $trader->id) }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-xl border transition {{ $watchlisted ? 'border-yellow-400/35 bg-yellow-400/15 text-yellow-200' : 'border-white/10 bg-white/[0.04] text-slate-300 hover:border-white/20 hover:bg-white/[0.08]' }}"
                        aria-label="{{ $watchlisted ? 'Remove from watchlist' : 'Add to watchlist' }}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="{{ $watchlisted ? 'currentColor' : 'none' }}"
                            stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m12 17.25-6.173 3.245 1.179-6.869L2 8.882l6.901-1.002L12 1.625l3.099 6.255L22 8.882l-5.006 4.744 1.179 6.869z" />
                        </svg>
                    </button>
                </form>
            @endauth
            <x-public.risk-badge :level="$trader->risk_level ?: 'medium'" />
        </div>
    </div>

    <div class="relative mt-5 grid grid-cols-2 gap-3 text-sm sm:grid-cols-3">
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Monthly ROI</div>
            <div class="mt-2 text-lg font-bold {{ $monthlyRoi >= 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                {{ $monthlyRoi >= 0 ? '+' : '' }}{{ number_format($monthlyRoi, 1) }}%
            </div>
        </div>
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Annual ROI</div>
            <div class="mt-2 text-lg font-bold {{ $yearlyRoi >= 0 ? 'text-white' : 'text-rose-300' }}">
                {{ $yearlyRoi >= 0 ? '+' : '' }}{{ number_format($yearlyRoi, 1) }}%
            </div>
        </div>
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Max drawdown</div>
            <div class="mt-2 text-lg font-bold text-amber-300">{{ number_format($maxDrawdown, 1) }}%</div>
        </div>
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Win rate</div>
            <div class="mt-2 text-lg font-bold text-white">{{ number_format($winRate, 1) }}%</div>
        </div>
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">Followers</div>
            <div class="mt-2 text-lg font-bold text-white">{{ number_format($followers) }}</div>
        </div>
        <div class="rounded-2xl border border-white/5 bg-white/[0.03] p-3.5">
            <div class="text-[10px] uppercase tracking-[0.2em] text-slate-500">AUM</div>
            <div class="mt-2 text-lg font-bold text-white">${{ number_format($aum, 0) }}</div>
        </div>
    </div>

    <div class="relative mt-4 flex flex-wrap gap-2">
        @foreach ($markets as $market)
            <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1 text-[11px] text-slate-300">{{ $market }}</span>
        @endforeach
        @if ($watchlisted)
            <span class="rounded-full border border-yellow-400/25 bg-yellow-400/10 px-3 py-1 text-[11px] text-yellow-200">
                Watchlisted
            </span>
        @endif
    </div>

    @unless($compact)
        <p class="relative mt-4 line-clamp-3 text-sm leading-6 text-slate-400">
            {{ $trader->bio ?: $trader->description ?: 'Transparent strategy execution, tracked performance history, and active capital controls.' }}
        </p>
    @endunless

    <div class="relative mt-5 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
        <a href="{{ $copyRoute }}"
            class="inline-flex w-full items-center justify-center rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 px-4 py-2.5 text-sm font-semibold text-black transition hover:brightness-110 sm:w-auto">
            {{ auth()->check() ? 'Start Copying' : 'Create Account' }}
        </a>
        <a href="{{ $profileRoute }}"
            class="inline-flex w-full items-center justify-center rounded-full border border-white/10 px-4 py-2.5 text-sm font-semibold text-slate-100 transition hover:border-white/20 hover:bg-white/5 sm:w-auto">
            View profile
        </a>
    </div>
</article>
