@extends('layouts.public')

@section('title', 'Traders')
@section('meta_description', 'Browse verified traders by risk, ROI, drawdown, AUM, and follower activity.')

@push('head')
    <style>
        .traders-shell {
            background:
                radial-gradient(circle at 5% 0%, rgba(240, 185, 10, .08), transparent 28%),
                radial-gradient(circle at 95% 5%, rgba(77, 212, 172, .08), transparent 28%);
        }

        .traders-panel {
            border: 1px solid rgba(255, 255, 255, .1);
            background: linear-gradient(145deg, rgba(12, 19, 32, .94), rgba(8, 13, 23, .95));
            box-shadow: 0 18px 60px -30px rgba(2, 6, 23, .95);
        }

        .trust-strip img {
            height: 22px;
            width: auto;
            opacity: .76;
            filter: grayscale(100%) brightness(1.8) contrast(.8);
        }
    </style>
@endpush

@section('content')
    @php
        $watchlistIds = collect(data_get($sections, 'watchlist_ids', []))
            ->map(fn ($id) => (int) $id)
            ->all();

        $featuredCount = collect(data_get($sections, 'featured', []))->count();
        $topRoiLeader = collect(data_get($leaderboards, 'top_roi', []))->first();
        $mostCopiedLeader = collect(data_get($leaderboards, 'most_copied', []))->first();
        $lowestDrawdownLeader = collect(data_get($leaderboards, 'lowest_drawdown', []))->first();

        $featured = collect(data_get($sections, 'featured', []))->take(3);
        $trending = collect(data_get($sections, 'trending', []))->take(3);
        $recent = collect(data_get($sections, 'recent', []))->take(3);

        $activeFilters = collect([
            'Search' => data_get($filters, 'search'),
            'Risk' => data_get($filters, 'risk_level'),
            'Strategy' => data_get($filters, 'strategy_type'),
            'Min ROI' => filled(data_get($filters, 'min_roi')) ? data_get($filters, 'min_roi') . '%' : null,
            'Max Drawdown' => filled(data_get($filters, 'max_drawdown')) ? data_get($filters, 'max_drawdown') . '%' : null,
            'Followers' => filled(data_get($filters, 'min_followers')) ? '≥ ' . number_format((int) data_get($filters, 'min_followers')) : null,
            'Verified' => data_get($filters, 'verified') ? 'Only verified' : null,
            'Sort' => match (data_get($filters, 'sort', 'top_returns')) {
                'trending' => 'Trending',
                'most_copied' => 'Most copied',
                'lowest_risk' => 'Lowest risk',
                'recently_added' => 'Recently added',
                default => 'Top returns',
            },
        ])->filter();
    @endphp

    <section class="traders-shell mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
        <div class="traders-panel relative overflow-hidden rounded-[36px] p-6 sm:p-8 lg:p-10">
            <img src="{{ asset('images/Copy-Trading.png') }}" alt="Copy trading analytics dashboard"
                class="pointer-events-none absolute right-0 top-0 hidden h-full w-[46%] object-cover opacity-25 lg:block">
            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-yellow-500/15 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-emerald-500/15 blur-3xl"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-[11px] font-black uppercase tracking-[0.24em] text-yellow-400">Trader Marketplace</p>
                    <h1 class="mt-3 text-2xl font-black tracking-tight text-white sm:text-4xl">
                        Discover Verified Traders With Transparent Performance.
                    </h1>
                    <p class="mt-3 text-sm leading-7 text-slate-300 sm:text-base">
                        Screen strategies by ROI, drawdown, and risk profile. Compare capital managers with institution-grade
                        clarity before you allocate.
                    </p>
                </div>

                <div class="grid w-full grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:w-auto">
                    <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3 backdrop-blur">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Featured</p>
                        <p class="mt-2 text-xl font-black text-white">{{ number_format($featuredCount) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3 backdrop-blur">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Top ROI</p>
                        <p class="mt-2 truncate text-xs font-bold text-slate-200">{{ optional($topRoiLeader)->name ?: 'N/A' }}</p>
                    </div>
                    <div class="col-span-2 rounded-2xl border border-white/10 bg-black/25 px-4 py-3 backdrop-blur sm:col-span-1">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Lowest DD</p>
                        <p class="mt-2 truncate text-xs font-bold text-slate-200">{{ optional($lowestDrawdownLeader)->name ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="trust-strip mt-5 rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 sm:px-6">
            <p class="mb-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Trusted by global investors</p>
            <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                <img src="{{ asset('images/bybit.svg') }}" alt="Bybit">
                <img src="{{ asset('images/allianz.svg') }}" alt="Allianz">
                <img src="{{ asset('images/square.svg') }}" alt="Square">
                <img src="{{ asset('images/morgan.png') }}" alt="Morgan">
                <img src="{{ asset('images/ml.png') }}" alt="Merrill Lynch">
            </div>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[330px,1fr]">
            <aside class="traders-panel h-fit rounded-[30px] p-6 backdrop-blur-xl lg:sticky lg:top-28">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-slate-500">Advanced Filters</p>
                <h2 class="mt-3 text-2xl font-black text-white tracking-tight">Refine The Screen</h2>
                <p class="mt-2 text-sm text-slate-400">Apply quantitative filters to surface high-conviction trader profiles.</p>

                <form action="{{ route('traders.index') }}" method="GET" class="mt-6 space-y-4">
                    <div>
                        <label for="search" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Search</label>
                        <input id="search" type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                            placeholder="Trader, market, strategy"
                            class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/50 focus:outline-none">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">
                        <div>
                            <label for="risk_level" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Risk level</label>
                            <select id="risk_level" name="risk_level"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white focus:border-yellow-500/50 focus:outline-none">
                                <option value="">Any risk</option>
                                @foreach (['low', 'medium', 'high', 'very high'] as $level)
                                    <option value="{{ $level }}" @selected(($filters['risk_level'] ?? null) === $level)>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="strategy_type" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Strategy</label>
                            <input id="strategy_type" type="text" name="strategy_type" value="{{ $filters['strategy_type'] ?? '' }}" placeholder="Scalping, swing, macro"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/50 focus:outline-none">
                        </div>

                        <div>
                            <label for="min_roi" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Minimum monthly ROI</label>
                            <input id="min_roi" type="number" step="0.1" name="min_roi" value="{{ $filters['min_roi'] ?? '' }}" placeholder="8"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/50 focus:outline-none">
                        </div>

                        <div>
                            <label for="max_drawdown" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Maximum drawdown</label>
                            <input id="max_drawdown" type="number" step="0.1" name="max_drawdown" value="{{ $filters['max_drawdown'] ?? '' }}" placeholder="12"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/50 focus:outline-none">
                        </div>

                        <div>
                            <label for="min_followers" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Minimum followers</label>
                            <input id="min_followers" type="number" name="min_followers" value="{{ $filters['min_followers'] ?? '' }}" placeholder="100"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/50 focus:outline-none">
                        </div>

                        <div>
                            <label for="sort" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Sort by</label>
                            <select id="sort" name="sort"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white focus:border-yellow-500/50 focus:outline-none">
                                <option value="top_returns" @selected(($filters['sort'] ?? 'top_returns') === 'top_returns')>Top returns</option>
                                <option value="trending" @selected(($filters['sort'] ?? null) === 'trending')>Trending</option>
                                <option value="most_copied" @selected(($filters['sort'] ?? null) === 'most_copied')>Most copied</option>
                                <option value="lowest_risk" @selected(($filters['sort'] ?? null) === 'lowest_risk')>Lowest risk</option>
                                <option value="recently_added" @selected(($filters['sort'] ?? null) === 'recently_added')>Recently added</option>
                            </select>
                        </div>

                        <div>
                            <label for="per_page" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Per page</label>
                            <select id="per_page" name="per_page"
                                class="mt-2 w-full rounded-xl border border-white/10 bg-black/40 px-4 py-3 text-sm text-white focus:border-yellow-500/50 focus:outline-none">
                                @foreach ([6, 12, 18, 24] as $size)
                                    <option value="{{ $size }}" @selected((int) ($filters['per_page'] ?? 12) === $size)>{{ $size }} traders</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <label class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3 text-sm text-slate-300">
                        <input type="checkbox" name="verified" value="1" @checked(($filters['verified'] ?? false))
                            class="rounded border-white/20 bg-black/30 text-yellow-400 focus:ring-yellow-400">
                        Verified traders only
                    </label>

                    <div class="flex gap-3 pt-2">
                        <button type="submit"
                            class="flex-1 rounded-xl bg-gradient-to-r from-yellow-400 to-amber-500 px-5 py-3 text-[11px] font-black uppercase tracking-[0.2em] text-black transition hover:brightness-110">
                            Apply
                        </button>
                        <a href="{{ route('traders.index') }}"
                            class="rounded-xl border border-white/15 px-5 py-3 text-[11px] font-black uppercase tracking-[0.2em] text-slate-200 transition hover:border-white/30 hover:bg-white/5">
                            Reset
                        </a>
                    </div>
                </form>
            </aside>

            <div class="space-y-7">
                <div class="grid gap-4 sm:grid-cols-3">
                    <article class="traders-panel rounded-2xl p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Top ROI Leader</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($topRoiLeader)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-300">+{{ number_format((float) optional($topRoiLeader)->monthly_roi, 1) }}% monthly</p>
                    </article>
                    <article class="traders-panel rounded-2xl p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Most Copied</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($mostCopiedLeader)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-yellow-300">{{ number_format((int) optional($mostCopiedLeader)->followers) }} followers</p>
                    </article>
                    <article class="traders-panel rounded-2xl p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Lowest Drawdown</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($lowestDrawdownLeader)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-amber-300">{{ number_format((float) optional($lowestDrawdownLeader)->max_drawdown, 1) }}% max DD</p>
                    </article>
                </div>

                <div class="traders-panel flex flex-col gap-4 rounded-[28px] p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-[0.24em] text-yellow-300">Live Discovery</p>
                            <h2 class="mt-2 text-2xl font-black text-white tracking-tight sm:text-3xl">Transparent Strategies, Ranked With Context</h2>
                        </div>
                        <p class="text-sm text-slate-400">{{ $traders->total() }} traders matched your screen.</p>
                    </div>

                    @if ($activeFilters->isNotEmpty())
                        <div class="flex flex-wrap items-center gap-2">
                            @foreach ($activeFilters as $label => $value)
                                <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1 text-[11px] font-semibold text-slate-300">
                                    {{ $label }}: <span class="text-white">{{ $value }}</span>
                                </span>
                            @endforeach
                            <a href="{{ route('traders.index') }}"
                                class="rounded-full border border-amber-400/25 bg-amber-400/10 px-3 py-1 text-[11px] font-semibold text-amber-200 transition hover:border-amber-300/35 hover:bg-amber-300/15">
                                Clear filters
                            </a>
                        </div>
                    @endif
                </div>

                <div class="grid gap-6 xl:grid-cols-2">
                    @forelse ($traders as $trader)
                        <x-public.trader-card :trader="$trader" :watchlisted="in_array($trader->id, $watchlistIds, true)" />
                    @empty
                        <div class="traders-panel col-span-full rounded-[30px] p-10 text-center">
                            <h3 class="text-2xl font-black text-white">No traders matched this screen.</h3>
                            <p class="mt-3 text-sm text-slate-400">Widen your filters and run another search.</p>
                        </div>
                    @endforelse
                </div>

                <div class="traders-panel overflow-x-auto rounded-2xl px-3 py-4 sm:px-5">
                    {{ $traders->links() }}
                </div>

                <div class="grid gap-6 xl:grid-cols-3">
                    <div class="traders-panel rounded-[28px] p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-yellow-400">Featured</h3>
                            <span class="text-[11px] font-semibold text-slate-500">{{ $featured->count() }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach ($featured as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}"
                                    class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5 transition hover:border-white/20 hover:bg-white/[0.05]">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-white">{{ $entry->name }}</p>
                                        <p class="text-xs text-slate-500">{{ ucfirst($entry->risk_level ?: 'medium') }} risk</p>
                                    </div>
                                    <p class="text-xs font-black text-emerald-300">+{{ number_format((float) $entry->monthly_roi, 1) }}%</p>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="traders-panel rounded-[28px] p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-yellow-300">Trending</h3>
                            <span class="text-[11px] font-semibold text-slate-500">{{ $trending->count() }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach ($trending as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}"
                                    class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5 transition hover:border-white/20 hover:bg-white/[0.05]">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-white">{{ $entry->name }}</p>
                                        <p class="text-xs text-slate-500">{{ number_format((int) $entry->followers) }} followers</p>
                                    </div>
                                    <p class="text-xs font-black text-yellow-300">{{ number_format((float) $entry->win_rate, 1) }}% WR</p>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="traders-panel rounded-[28px] p-5">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-sm font-black uppercase tracking-[0.2em] text-amber-300">Recently Added</h3>
                            <span class="text-[11px] font-semibold text-slate-500">{{ $recent->count() }}</span>
                        </div>
                        <div class="space-y-3">
                            @foreach ($recent as $entry)
                                <a href="{{ route('traders.show', $entry->slug ?: $entry->id) }}"
                                    class="flex items-center justify-between rounded-xl border border-white/10 bg-white/[0.02] px-3 py-2.5 transition hover:border-white/20 hover:bg-white/[0.05]">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-white">{{ $entry->name }}</p>
                                        <p class="text-xs text-slate-500">{{ ucfirst($entry->strategy_type ?: 'Discretionary') }}</p>
                                    </div>
                                    <p class="text-xs font-black text-amber-300">{{ number_format((float) $entry->max_drawdown, 1) }}% DD</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
