@extends('layouts.public')

@section('title', 'Traders')
@section('meta_description', 'Browse verified traders by risk, ROI, drawdown, AUM, and follower activity.')

@push('head')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
    :root {
        --dash-bg: #070b12;
        --dash-surface: rgba(11, 18, 32, 0.96);
        --glass-bg: rgba(255, 255, 255, 0.03);
        --glass-border: rgba(255, 255, 255, 0.06);
        --dash-text: #f8fafc;
        --dash-text-muted: #94a3b8;
        --dash-text-faint: #64748b;
        --accent-gold: #f0b90a;
    }

    body { background-color: var(--dash-bg) !important; font-family: 'Outfit', -apple-system, sans-serif !important; }
    * { font-style: normal !important; }

    .traders-page { min-height: 100vh; background: var(--dash-bg); }

    .dash-glass {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
    }
    .dash-glass:hover { border-color: rgba(255,255,255,0.10); }

    .gold-text { color: var(--accent-gold); }
    .gold-glow { box-shadow: 0 0 20px rgba(240,185,10,0.15); }
    .gold-btn {
        background: linear-gradient(135deg, #f0b90a, #d4a017);
        color: #000;
        font-weight: 800;
        border-radius: 12px;
        padding: 0.6rem 1.25rem;
        font-size: 0.75rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        transition: all 0.2s;
        display: inline-block;
    }
    .gold-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

    .label-tiny {
        font-size: 0.6rem;
        font-weight: 800;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--dash-text-faint);
    }

    /* Stat cards */
    .stat-card {
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
        transition: border-color 0.2s;
    }
    .stat-card:hover { border-color: rgba(240,185,10,0.25); }
    .stat-card .icon-bg {
        position: absolute;
        right: -0.75rem;
        bottom: -0.75rem;
        opacity: 0.05;
        transition: opacity 0.3s;
    }
    .stat-card:hover .icon-bg { opacity: 0.10; }

    /* Filter sidebar inputs */
    .filter-input {
        width: 100%;
        background: rgba(0,0,0,0.4);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 12px;
        padding: 0.65rem 0.9rem;
        font-size: 0.83rem;
        color: #e2e8f0;
        font-family: 'Outfit', sans-serif;
        transition: border-color 0.2s;
        margin-top: 0.4rem;
    }
    .filter-input:focus { outline: none; border-color: rgba(240,185,10,0.4); }
    .filter-input::placeholder { color: #334155; }
    option { background: #0d1117; }

    /* Trader cards */
    .trader-card {
        background: linear-gradient(145deg, rgba(12,19,32,.94), rgba(8,13,23,.95));
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        padding: 1.5rem;
        transition: all 0.25s;
        position: relative;
        overflow: hidden;
    }
    .trader-card:hover { border-color: rgba(255,255,255,0.16); transform: translateY(-2px); box-shadow: 0 20px 60px -20px rgba(0,0,0,0.8); }
    .trader-card .glow-tl { position:absolute; top:-2rem; right:-2rem; width:7rem; height:7rem; background:rgba(240,185,10,.07); border-radius:50%; filter:blur(30px); pointer-events:none; }
    .trader-card .glow-br { position:absolute; bottom:-2rem; left:-2rem; width:7rem; height:7rem; background:rgba(77,212,172,.06); border-radius:50%; filter:blur(30px); pointer-events:none; }

    .metric-cell {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.05);
        border-radius: 14px;
        padding: 0.75rem 0.9rem;
    }

    /* Sidebar scrollable on mobile */
    .filter-sidebar { position: sticky; top: 6rem; max-height: calc(100vh - 7rem); overflow-y: auto; scrollbar-width: thin; }
    .filter-sidebar::-webkit-scrollbar { width: 4px; }
    .filter-sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 4px; }

    /* Mini leaderboard rows */
    .mini-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.55rem 0.75rem;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.06);
        background: rgba(255,255,255,0.02);
        transition: all 0.2s;
        text-decoration: none;
    }
    .mini-row:hover { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.12); }

    /* Scrollbar global */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-track { background: rgba(0,0,0,0.2); }
    ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.14); }

    /* Active filter pill */
    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.2rem 0.65rem;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.10);
        background: rgba(255,255,255,0.03);
        font-size: 0.72rem;
        font-weight: 600;
        color: #cbd5e1;
    }
</style>
@endpush

@section('content')
@php
    $watchlistIds = collect(data_get($sections, 'watchlist_ids', []))->map(fn ($id) => (int) $id)->all();
    $featuredCount = collect(data_get($sections, 'featured', []))->count();
    $topRoiLeader       = collect(data_get($leaderboards, 'top_roi', []))->first();
    $mostCopiedLeader   = collect(data_get($leaderboards, 'most_copied', []))->first();
    $lowestDDLeader     = collect(data_get($leaderboards, 'lowest_drawdown', []))->first();
    $featured  = collect(data_get($sections, 'featured', []))->take(5);
    $trending  = collect(data_get($sections, 'trending', []))->take(5);
    $recent    = collect(data_get($sections, 'recent', []))->take(5);
    $activeFilters = collect([
        'Search'        => data_get($filters, 'search'),
        'Risk'          => data_get($filters, 'risk_level'),
        'Strategy'      => data_get($filters, 'strategy_type'),
        'Min ROI'       => filled(data_get($filters, 'min_roi')) ? data_get($filters, 'min_roi').'%' : null,
        'Max DD'        => filled(data_get($filters, 'max_drawdown')) ? data_get($filters, 'max_drawdown').'%' : null,
        'Followers'     => filled(data_get($filters, 'min_followers')) ? '≥ '.number_format((int) data_get($filters, 'min_followers')) : null,
        'Verified only' => data_get($filters, 'verified') ? 'Yes' : null,
    ])->filter();
@endphp

<div class="traders-page">
    <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">

        {{-- ── Hero Banner ─────────────────────────────────────────────────── --}}
        <div class="stat-card mb-8 p-6 sm:p-8 lg:p-10 rounded-[28px] overflow-hidden" style="background:linear-gradient(145deg,rgba(12,19,32,.96),rgba(7,11,18,.98));border-color:rgba(255,255,255,0.07)">
            <div class="absolute -right-10 -top-10 w-48 h-48 rounded-full bg-yellow-500/10 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 -bottom-10 w-48 h-48 rounded-full bg-emerald-500/10 blur-3xl pointer-events-none"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="label-tiny gold-text mb-3" style="letter-spacing:.24em">Trader Marketplace</p>
                    <h1 class="text-2xl sm:text-4xl font-black text-white tracking-tight leading-tight">
                        Discover Verified Traders<br class="hidden sm:block"> With Transparent Performance.
                    </h1>
                    <p class="mt-3 text-sm text-slate-400 leading-7 max-w-xl">
                        Screen strategies by ROI, drawdown, and risk profile. Compare capital managers with institution-grade clarity before you allocate.
                    </p>
                </div>

                {{-- Quick stats --}}
                <div class="grid grid-cols-3 gap-3 lg:w-auto lg:min-w-[320px]">
                    <div class="dash-glass rounded-2xl p-4 text-center">
                        <p class="label-tiny mb-2">Featured</p>
                        <p class="text-2xl font-black text-white">{{ number_format($featuredCount) }}</p>
                    </div>
                    <div class="dash-glass rounded-2xl p-4 text-center">
                        <p class="label-tiny mb-2">Top ROI</p>
                        <p class="text-sm font-bold text-emerald-300 truncate">{{ optional($topRoiLeader)->name ?: 'N/A' }}</p>
                    </div>
                    <div class="dash-glass rounded-2xl p-4 text-center">
                        <p class="label-tiny mb-2">Lowest DD</p>
                        <p class="text-sm font-bold text-amber-300 truncate">{{ optional($lowestDDLeader)->name ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Leaderboard Quick Stats ──────────────────────────────────────── --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            {{-- Top ROI --}}
            <div class="stat-card" style="border-color:rgba(34,197,94,0.15)">
                <div class="flex items-center justify-between mb-4">
                    <span class="label-tiny">Top ROI Leader</span>
                    <i data-lucide="trending-up" class="w-4 h-4 text-emerald-500 opacity-60"></i>
                </div>
                <p class="text-lg font-black text-white truncate">{{ optional($topRoiLeader)->name ?: '—' }}</p>
                <p class="text-sm font-bold text-emerald-400 mt-1">+{{ number_format((float) optional($topRoiLeader)->monthly_roi, 1) }}% monthly</p>
                <div class="icon-bg"><i data-lucide="trending-up" class="w-24 h-24 text-emerald-500"></i></div>
            </div>

            {{-- Most Copied --}}
            <div class="stat-card" style="border-color:rgba(240,185,10,0.15)">
                <div class="flex items-center justify-between mb-4">
                    <span class="label-tiny">Most Copied</span>
                    <i data-lucide="users" class="w-4 h-4 opacity-60" style="color:var(--accent-gold)"></i>
                </div>
                <p class="text-lg font-black text-white truncate">{{ optional($mostCopiedLeader)->name ?: '—' }}</p>
                <p class="text-sm font-bold mt-1" style="color:var(--accent-gold)">{{ number_format((int) optional($mostCopiedLeader)->followers) }} followers</p>
                <div class="icon-bg"><i data-lucide="users" class="w-24 h-24" style="color:var(--accent-gold)"></i></div>
            </div>

            {{-- Lowest Drawdown --}}
            <div class="stat-card" style="border-color:rgba(139,92,246,0.15)">
                <div class="flex items-center justify-between mb-4">
                    <span class="label-tiny">Lowest Drawdown</span>
                    <i data-lucide="shield-check" class="w-4 h-4 text-purple-400 opacity-60"></i>
                </div>
                <p class="text-lg font-black text-white truncate">{{ optional($lowestDDLeader)->name ?: '—' }}</p>
                <p class="text-sm font-bold text-purple-300 mt-1">{{ number_format((float) optional($lowestDDLeader)->max_drawdown, 1) }}% max DD</p>
                <div class="icon-bg"><i data-lucide="shield-check" class="w-24 h-24 text-purple-500"></i></div>
            </div>
        </div>

        {{-- ── Main Grid: Sidebar + Cards ──────────────────────────────────── --}}
        <div class="grid gap-8 lg:grid-cols-[290px,1fr]">

            {{-- Filter Sidebar --}}
            <aside class="filter-sidebar dash-glass rounded-[24px] p-6 h-fit">
                <p class="label-tiny mb-1">Filters</p>
                <h2 class="text-xl font-black text-white tracking-tight mb-1">Refine Screen</h2>
                <p class="text-xs text-slate-500 mb-5">Surface high-conviction profiles with precision filters.</p>

                <form action="{{ route('traders.index') }}" method="GET" class="space-y-4">

                    <div>
                        <label for="search" class="label-tiny">Search</label>
                        <input id="search" type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                            placeholder="Trader, market, strategy…" class="filter-input">
                    </div>

                    <div>
                        <label for="risk_level" class="label-tiny">Risk level</label>
                        <select id="risk_level" name="risk_level" class="filter-input">
                            <option value="">Any risk</option>
                            @foreach (['low','medium','high','very high'] as $level)
                                <option value="{{ $level }}" @selected(($filters['risk_level'] ?? null) === $level)>{{ ucfirst($level) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="strategy_type" class="label-tiny">Strategy</label>
                        <input id="strategy_type" type="text" name="strategy_type" value="{{ $filters['strategy_type'] ?? '' }}"
                            placeholder="Scalping, swing, macro…" class="filter-input">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="min_roi" class="label-tiny">Min ROI %</label>
                            <input id="min_roi" type="number" step="0.1" name="min_roi" value="{{ $filters['min_roi'] ?? '' }}" placeholder="8" class="filter-input">
                        </div>
                        <div>
                            <label for="max_drawdown" class="label-tiny">Max DD %</label>
                            <input id="max_drawdown" type="number" step="0.1" name="max_drawdown" value="{{ $filters['max_drawdown'] ?? '' }}" placeholder="12" class="filter-input">
                        </div>
                    </div>

                    <div>
                        <label for="min_followers" class="label-tiny">Min followers</label>
                        <input id="min_followers" type="number" name="min_followers" value="{{ $filters['min_followers'] ?? '' }}" placeholder="100" class="filter-input">
                    </div>

                    <div>
                        <label for="sort" class="label-tiny">Sort by</label>
                        <select id="sort" name="sort" class="filter-input">
                            <option value="top_returns"   @selected(($filters['sort'] ?? 'top_returns') === 'top_returns')>Top returns</option>
                            <option value="trending"      @selected(($filters['sort'] ?? null) === 'trending')>Trending</option>
                            <option value="most_copied"   @selected(($filters['sort'] ?? null) === 'most_copied')>Most copied</option>
                            <option value="lowest_risk"   @selected(($filters['sort'] ?? null) === 'lowest_risk')>Lowest risk</option>
                            <option value="recently_added" @selected(($filters['sort'] ?? null) === 'recently_added')>Recently added</option>
                        </select>
                    </div>

                    <div>
                        <label for="per_page" class="label-tiny">Per page</label>
                        <select id="per_page" name="per_page" class="filter-input">
                            @foreach ([6, 12, 18, 24] as $size)
                                <option value="{{ $size }}" @selected((int)($filters['per_page'] ?? 12) === $size)>{{ $size }} traders</option>
                            @endforeach
                        </select>
                    </div>

                    <label class="flex items-center gap-3 rounded-xl border border-white/08 bg-white/[0.025] px-4 py-3 text-xs text-slate-300 cursor-pointer hover:bg-white/[0.05] transition">
                        <input type="checkbox" name="verified" value="1" @checked(($filters['verified'] ?? false))
                            class="rounded border-white/20 accent-yellow-400">
                        Verified traders only
                    </label>

                    <div class="flex gap-2 pt-1">
                        <button type="submit" class="gold-btn flex-1 text-center">
                            <i data-lucide="sliders-horizontal" class="inline w-3 h-3 mr-1 mb-0.5"></i> Apply
                        </button>
                        <a href="{{ route('traders.index') }}"
                            class="flex-1 text-center rounded-xl border border-white/10 px-4 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:border-white/20 hover:bg-white/5 transition">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            {{-- Main content --}}
            <div class="space-y-6">

                {{-- Section header + active filters --}}
                <div class="dash-glass rounded-[20px] p-5 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <p class="label-tiny gold-text mb-1">Live Discovery</p>
                            <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                                Transparent Strategies, Ranked With Context
                            </h2>
                        </div>
                        <div class="flex-shrink-0 dash-glass rounded-xl px-4 py-2.5 text-center">
                            <p class="label-tiny mb-0.5">Matched</p>
                            <p class="text-2xl font-black text-white">{{ $traders->total() }}</p>
                        </div>
                    </div>

                    @if ($activeFilters->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-white/05">
                            <span class="label-tiny mr-1">Active:</span>
                            @foreach ($activeFilters as $label => $value)
                                <span class="filter-pill">{{ $label }}: <span class="text-white">{{ $value }}</span></span>
                            @endforeach
                            <a href="{{ route('traders.index') }}"
                                class="filter-pill" style="border-color:rgba(240,185,10,0.25);background:rgba(240,185,10,0.08);color:#fef08a">
                                <i data-lucide="x" class="w-3 h-3"></i> Clear
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Trader Cards Grid --}}
                <div class="grid gap-5 xl:grid-cols-2">
                    @forelse ($traders as $trader)
                        @php
                            $markets = collect(explode(',', (string)($trader->markets_traded ?: $trader->preferred_instruments ?: 'Forex, Crypto')))->map(fn($m) => trim($m))->filter()->take(3);
                            $profileRoute = route('traders.show', $trader->slug ?: $trader->id);
                            $copyRoute = auth()->check() ? route('copy.show', $trader->slug ?: $trader->id) : route('register');
                            $monthlyRoi = (float)($trader->monthly_roi ?? 0);
                            $yearlyRoi  = (float)($trader->yearly_roi ?? 0);
                            $maxDD      = (float)($trader->max_drawdown ?? 0);
                            $winRate    = (float)($trader->win_rate ?? 0);
                            $followers  = (int)($trader->followers ?? 0);
                            $aum        = (float)($trader->aum ?? 0);
                            $watchlisted = in_array($trader->id, $watchlistIds, true);
                            $fallbacks = ['img/in-theramanuel-4-avatar-1.png','img/in-theramanuel-4-avatar-2.png','img/in-theramanuel-4-avatar-3.png','img/in-theramanuel-4-avatar-4.png'];
                            $avatar = $trader->photo ? asset('storage/'.$trader->photo) : asset($fallbacks[$trader->getKey() % count($fallbacks)]);
                            $isVerified = ($trader->verification_status === 'verified');
                            $riskColors = ['low'=>'text-emerald-300 bg-emerald-500/10 border-emerald-500/20','medium'=>'text-yellow-300 bg-yellow-500/10 border-yellow-500/20','high'=>'text-orange-300 bg-orange-500/10 border-orange-500/20','very high'=>'text-rose-300 bg-rose-500/10 border-rose-500/20'];
                            $riskColor = $riskColors[$trader->risk_level ?? 'medium'] ?? $riskColors['medium'];
                        @endphp

                        <article class="trader-card group">
                            <div class="glow-tl"></div>
                            <div class="glow-br"></div>

                            {{-- Header --}}
                            <div class="relative flex items-start justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <img src="{{ $avatar }}" alt="{{ $trader->name }}"
                                        class="h-14 w-14 rounded-2xl object-cover border border-white/10 flex-shrink-0">
                                    <div class="min-w-0">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <h3 class="text-base font-black text-white truncate">{{ $trader->name }}</h3>
                                            @if($isVerified)
                                                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-black text-emerald-300 bg-emerald-500/10 border border-emerald-500/20 uppercase tracking-wider">
                                                    <i data-lucide="shield-check" class="w-3 h-3"></i> Verified
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $trader->strategy_type ?: ($trader->trading_style ?: 'Multi-asset discretionary') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    @auth
                                        <form method="POST" action="{{ route('copy.watchlist.toggle', $trader->id) }}">
                                            @csrf
                                            <button type="submit"
                                                class="h-9 w-9 flex items-center justify-center rounded-xl border transition {{ $watchlisted ? 'border-yellow-400/35 bg-yellow-400/15 text-yellow-300' : 'border-white/10 bg-white/[0.04] text-slate-400 hover:border-white/20 hover:text-white' }}"
                                                aria-label="{{ $watchlisted ? 'Remove from watchlist' : 'Add to watchlist' }}">
                                                <i data-lucide="star" class="w-4 h-4 {{ $watchlisted ? 'fill-current' : '' }}"></i>
                                            </button>
                                        </form>
                                    @endauth
                                    <span class="rounded-full border px-2.5 py-1 text-[10px] font-black uppercase {{ $riskColor }}">{{ $trader->risk_level ?: 'medium' }}</span>
                                </div>
                            </div>

                            {{-- Metrics Grid --}}
                            <div class="relative mt-5 grid grid-cols-3 gap-2.5">
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">Monthly ROI</p>
                                    <p class="text-base font-black {{ $monthlyRoi >= 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                        {{ $monthlyRoi >= 0 ? '+' : '' }}{{ number_format($monthlyRoi, 1) }}%
                                    </p>
                                </div>
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">Annual ROI</p>
                                    <p class="text-base font-black text-white">{{ $yearlyRoi >= 0 ? '+' : '' }}{{ number_format($yearlyRoi, 1) }}%</p>
                                </div>
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">Max DD</p>
                                    <p class="text-base font-black text-amber-300">{{ number_format($maxDD, 1) }}%</p>
                                </div>
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">Win rate</p>
                                    <p class="text-base font-black text-white">{{ number_format($winRate, 1) }}%</p>
                                </div>
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">Followers</p>
                                    <p class="text-base font-black text-white">{{ number_format($followers) }}</p>
                                </div>
                                <div class="metric-cell">
                                    <p class="label-tiny mb-1.5">AUM</p>
                                    <p class="text-base font-black text-white">${{ number_format($aum, 0) }}</p>
                                </div>
                            </div>

                            {{-- Tags --}}
                            <div class="relative mt-4 flex flex-wrap gap-1.5">
                                @foreach ($markets as $market)
                                    <span class="rounded-full border border-white/10 bg-white/[0.03] px-2.5 py-0.5 text-[11px] text-slate-400">{{ $market }}</span>
                                @endforeach
                                @if($watchlisted)
                                    <span class="rounded-full border border-yellow-400/25 bg-yellow-400/10 px-2.5 py-0.5 text-[11px] text-yellow-200">⭐ Watchlisted</span>
                                @endif
                            </div>

                            {{-- Bio --}}
                            <p class="relative mt-3 text-xs text-slate-500 line-clamp-2 leading-5">
                                {{ $trader->bio ?: $trader->description ?: 'Transparent strategy execution, tracked performance history, and active capital controls.' }}
                            </p>

                            {{-- Actions --}}
                            <div class="relative mt-5 flex gap-3">
                                <a href="{{ $copyRoute }}" class="gold-btn flex-1 text-center">
                                    <i data-lucide="copy" class="inline w-3 h-3 mr-1 mb-0.5"></i>
                                    {{ auth()->check() ? 'Start Copying' : 'Get Started' }}
                                </a>
                                <a href="{{ $profileRoute }}"
                                    class="flex-1 text-center rounded-xl border border-white/10 px-4 py-2.5 text-[11px] font-black uppercase tracking-widest text-slate-300 hover:border-white/20 hover:bg-white/5 transition">
                                    View Profile
                                </a>
                            </div>
                        </article>

                    @empty
                        <div class="col-span-full dash-glass rounded-[24px] p-12 text-center">
                            <div class="h-16 w-16 rounded-2xl bg-white/5 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="search-x" class="w-8 h-8 text-slate-500"></i>
                            </div>
                            <h3 class="text-xl font-black text-white mb-2">No traders matched this screen.</h3>
                            <p class="text-sm text-slate-500 mb-6">Widen your filters and run another search.</p>
                            <a href="{{ route('traders.index') }}" class="gold-btn">Reset Filters</a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($traders->hasPages())
                    <div class="dash-glass rounded-[18px] px-4 py-4">
                        {{ $traders->links() }}
                    </div>
                @endif

                {{-- Bottom Leaderboard Panels --}}
                <div class="grid gap-5 xl:grid-cols-3">

                    {{-- Featured --}}
                    <div class="dash-glass rounded-[22px] p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="star" class="w-4 h-4 gold-text"></i>
                                <h3 class="label-tiny gold-text">Featured</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-600">{{ $featured->count() }}</span>
                        </div>
                        <div class="space-y-2">
                            @forelse ($featured as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}" class="mini-row">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-white truncate">{{ $entry->name }}</p>
                                        <p class="text-[10px] text-slate-600">{{ ucfirst($entry->risk_level ?: 'medium') }} risk</p>
                                    </div>
                                    <p class="text-xs font-black text-emerald-300 flex-shrink-0">+{{ number_format((float)$entry->monthly_roi, 1) }}%</p>
                                </a>
                            @empty
                                <p class="text-xs text-slate-600 text-center py-3">No featured traders yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Trending --}}
                    <div class="dash-glass rounded-[22px] p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="flame" class="w-4 h-4 text-orange-400"></i>
                                <h3 class="label-tiny text-orange-400">Trending</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-600">{{ $trending->count() }}</span>
                        </div>
                        <div class="space-y-2">
                            @forelse ($trending as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}" class="mini-row">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-white truncate">{{ $entry->name }}</p>
                                        <p class="text-[10px] text-slate-600">{{ number_format((int)$entry->followers) }} followers</p>
                                    </div>
                                    <p class="text-xs font-black text-yellow-300 flex-shrink-0">{{ number_format((float)$entry->win_rate, 1) }}% WR</p>
                                </a>
                            @empty
                                <p class="text-xs text-slate-600 text-center py-3">No trending traders yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Recently Added --}}
                    <div class="dash-glass rounded-[22px] p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <i data-lucide="clock" class="w-4 h-4 text-purple-400"></i>
                                <h3 class="label-tiny text-purple-400">Recently Added</h3>
                            </div>
                            <span class="text-xs font-bold text-slate-600">{{ $recent->count() }}</span>
                        </div>
                        <div class="space-y-2">
                            @forelse ($recent as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}" class="mini-row">
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold text-white truncate">{{ $entry->name }}</p>
                                        <p class="text-[10px] text-slate-600">{{ ucfirst($entry->strategy_type ?: 'Discretionary') }}</p>
                                    </div>
                                    <p class="text-xs font-black text-amber-300 flex-shrink-0">{{ number_format((float)$entry->max_drawdown, 1) }}% DD</p>
                                </a>
                            @empty
                                <p class="text-xs text-slate-600 text-center py-3">No traders added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Init Lucide icons
    document.addEventListener('DOMContentLoaded', () => {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endpush
@endsection
