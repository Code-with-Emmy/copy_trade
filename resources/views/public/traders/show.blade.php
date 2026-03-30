@extends('layouts.public')

@php
    $trader = data_get($profile, 'trader');
    $performance = data_get($profile, 'performance', []);
    $scores = data_get($profile, 'scores', []);
    $charts = data_get($profile, 'charts', []);
    $monthlyTable = collect(data_get($profile, 'monthly_table', []))->take(10);
    $recentTrades = collect(data_get($profile, 'recent_trades', []));
    $markets = collect(explode(',', (string) ($trader->markets_traded ?: $trader->preferred_instruments ?: 'Forex,Crypto,Indices')))
        ->map(fn ($item) => trim($item))
        ->filter()
        ->take(6);
    $avatar = $trader->photo
        ? asset('storage/' . $trader->photo)
        : asset('img/in-theramanuel-4-avatar-' . (($trader->getKey() % 4) + 1) . '.png');
@endphp

@section('meta_description', $trader->name . ' profile with verified copy trading performance, drawdown, win rate, and monthly analytics.')

@push('head')
    <style>
        .profile-shell {
            background:
                radial-gradient(circle at 8% 0%, rgba(240, 185, 10, .08), transparent 28%),
                radial-gradient(circle at 92% 2%, rgba(56, 189, 248, .08), transparent 28%);
        }

        .profile-panel {
            border: 1px solid rgba(255, 255, 255, .1);
            background: linear-gradient(145deg, rgba(12, 19, 32, .95), rgba(8, 13, 23, .94));
            box-shadow: 0 20px 65px -34px rgba(2, 6, 23, .95);
        }

        .profile-strip img {
            height: 22px;
            width: auto;
            opacity: .78;
            filter: grayscale(100%) brightness(1.8) contrast(.85);
        }
    </style>
@endpush

@section('content')
    @php
        $activeCopiers = (int) data_get($profile, 'active_copiers', 0);
        $watchlisted = (bool) data_get($profile, 'watchlisted', false);
        $recommendedProfile = $trader->recommended_investor_profile ?: data_get($performance, 'recommended_investor_profile', 'Balanced Growth');
        $leaderboardTopRoi = collect(data_get($leaderboards, 'top_roi', []))->first();
        $leaderboardMostCopied = collect(data_get($leaderboards, 'most_copied', []))->first();
        $leaderboardLowestDrawdown = collect(data_get($leaderboards, 'lowest_drawdown', []))->first();
    @endphp

    <section class="profile-shell mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
        <div class="profile-panel relative overflow-hidden rounded-[36px] p-6 sm:p-8 lg:p-10">
            <img src="{{ asset('images/Copy-Trading.png') }}" alt="Trader analytics dashboard"
                class="pointer-events-none absolute right-0 top-0 hidden h-full w-[42%] object-cover opacity-20 lg:block">
            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-yellow-500/15 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-10 -bottom-10 h-40 w-40 rounded-full bg-emerald-500/15 blur-3xl"></div>

            <div class="relative">
                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-400">
                    <a href="{{ route('home') }}" class="transition hover:text-white">Home</a>
                    <span>/</span>
                    <a href="{{ route('traders.index') }}" class="transition hover:text-white">Traders</a>
                    <span>/</span>
                    <span class="max-w-[10rem] truncate text-white sm:max-w-none">{{ $trader->name }}</span>
                </div>

                <div class="mt-6 grid gap-8 lg:grid-cols-[1.2fr,0.8fr]">
                    <div>
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:gap-5">
                            <img src="{{ $avatar }}" alt="{{ $trader->name }}"
                                class="h-16 w-16 rounded-2xl border border-white/10 object-cover shadow-[0_0_0_1px_rgba(15,23,42,.65)] sm:h-20 sm:w-20 sm:rounded-[24px]">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-2.5">
                                    <h1 class="text-2xl font-black tracking-tight text-white sm:text-4xl">{{ $trader->name }}</h1>
                                    <x-public.verified-badge :status="$trader->verification_status ?: 'pending'" />
                                    <x-public.risk-badge :level="data_get($profile, 'risk_label', 'medium')" />
                                </div>
                                <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-300">
                                    {{ $trader->bio ?: $trader->description ?: 'Systematic execution across diversified markets with transparent performance and monitored drawdown behaviour.' }}
                                </p>
                                <div class="mt-4 flex flex-wrap gap-2">
                                    @foreach ($markets as $market)
                                        <span class="rounded-full border border-white/10 bg-white/[0.03] px-3 py-1 text-[11px] text-slate-300">{{ $market }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mt-7 grid grid-cols-2 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3.5">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Monthly ROI</p>
                                @php $monthlyRoi = (float) data_get($performance, 'monthly_roi', 0); @endphp
                                <p class="mt-2 text-xl font-black {{ $monthlyRoi >= 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                    {{ $monthlyRoi >= 0 ? '+' : '' }}{{ number_format($monthlyRoi, 1) }}%
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3.5">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Annual ROI</p>
                                @php $yearlyRoi = (float) data_get($performance, 'yearly_roi', 0); @endphp
                                <p class="mt-2 text-xl font-black {{ $yearlyRoi >= 0 ? 'text-white' : 'text-rose-300' }}">
                                    {{ $yearlyRoi >= 0 ? '+' : '' }}{{ number_format($yearlyRoi, 1) }}%
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3.5">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Max Drawdown</p>
                                <p class="mt-2 text-xl font-black text-amber-300">{{ number_format((float) data_get($performance, 'max_drawdown', 0), 1) }}%</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-3.5">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Followers</p>
                                <p class="mt-2 text-xl font-black text-white">{{ number_format((int) data_get($performance, 'followers', 0)) }}</p>
                            </div>
                        </div>
                    </div>

                    <aside class="rounded-[28px] border border-white/10 bg-[#0a111c]/85 p-5 sm:p-6">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-yellow-400">Copy This Trader</p>
                        <h2 class="mt-3 text-2xl font-black tracking-tight text-white">Allocation Summary</h2>
                        <div class="mt-5 space-y-3 text-sm text-slate-300">
                            <div class="flex items-center justify-between">
                                <span>Minimum allocation</span>
                                <span class="font-semibold text-white">${{ number_format((float) ($trader->minimum_allocation ?: $trader->price ?: 100), 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Management fee</span>
                                <span class="font-semibold text-white">{{ number_format((float) ($trader->management_fee_percent ?: 0), 1) }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Performance fee</span>
                                <span class="font-semibold text-white">{{ number_format((float) ($trader->performance_fee_percent ?: 0), 1) }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>AUM</span>
                                <span class="font-semibold text-white">${{ number_format((float) data_get($performance, 'aum', 0), 0) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span>Active copiers</span>
                                <span class="font-semibold text-white">{{ number_format($activeCopiers) }}</span>
                            </div>
                        </div>
                        <div class="mt-6 space-y-3">
                            <a href="{{ auth()->check() ? route('copy.show', $trader->slug ?: $trader->id) : route('register') }}"
                                class="block rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 px-5 py-3 text-center text-sm font-semibold text-black transition hover:brightness-110">
                                {{ auth()->check() ? 'Open Subscription Flow' : 'Create Investor Account' }}
                            </a>
                            <a href="{{ route('pricing') }}"
                                class="block rounded-full border border-white/15 px-5 py-3 text-center text-sm font-semibold text-slate-100 transition hover:border-white/30 hover:bg-white/5">
                                View Platform Fees
                            </a>
                        </div>
                        @auth
                            <div class="mt-4 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-xs text-slate-300">
                                {{ $watchlisted ? 'This trader is already in your watchlist.' : 'Add this trader to your watchlist from the marketplace to monitor performance changes.' }}
                            </div>
                        @endauth
                        <div class="mt-6 rounded-2xl border border-rose-400/20 bg-rose-400/10 px-4 py-3 text-xs leading-6 text-rose-100/80">
                            Historical performance does not guarantee future results. Assess allocation suitability and risk before copying.
                        </div>
                    </aside>
                </div>
            </div>
        </div>

        <div class="profile-strip mt-5 rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 sm:px-6">
            <p class="mb-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Infrastructure and market trust references</p>
            <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                <img src="{{ asset('images/bybit.svg') }}" alt="Bybit">
                <img src="{{ asset('images/allianz.svg') }}" alt="Allianz">
                <img src="{{ asset('images/square.svg') }}" alt="Square">
                <img src="{{ asset('images/morgan.png') }}" alt="Morgan">
                <img src="{{ asset('images/ml.png') }}" alt="Merrill Lynch">
            </div>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[1.1fr,.9fr]">
            <div class="profile-panel rounded-[30px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-emerald-300">Performance Charts</p>
                <h2 class="mt-2 text-2xl font-black tracking-tight text-white">Returns, Equity Curve, and Drawdown History</h2>

                <div class="mt-7 space-y-7">
                    <div class="h-72 rounded-[24px] border border-white/10 bg-black/35 p-4">
                        <canvas id="returnsChart"></canvas>
                    </div>
                    <div class="grid gap-5 xl:grid-cols-2">
                        <div class="h-64 rounded-[24px] border border-white/10 bg-black/35 p-4">
                            <canvas id="equityChart"></canvas>
                        </div>
                        <div class="h-64 rounded-[24px] border border-white/10 bg-black/35 p-4">
                            <canvas id="drawdownChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="profile-panel rounded-[30px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-sky-300">Risk Intelligence</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Risk and Consistency Overview</h3>

                <div class="mt-6 space-y-4">
                    @foreach ([
                        ['label' => 'Consistency score', 'value' => (int) data_get($scores, 'consistency', 0)],
                        ['label' => 'Volatility score', 'value' => (int) data_get($scores, 'volatility', 0)],
                        ['label' => 'Confidence score', 'value' => (int) data_get($scores, 'confidence', 0)],
                        ['label' => 'Capital preservation', 'value' => (int) data_get($scores, 'capital_preservation', 0)],
                    ] as $score)
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-300">{{ $score['label'] }}</span>
                                <span class="font-semibold text-white">{{ $score['value'] }}/100</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-white/5">
                                <div class="h-2 rounded-full bg-gradient-to-r from-sky-400 to-emerald-300" style="width: {{ min(100, max(0, $score['value'])) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-7 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Win Rate</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format((float) data_get($performance, 'win_rate', 0), 1) }}%</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Avg Trade Duration</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format((int) data_get($performance, 'avg_trade_duration_hours', 0)) }}h</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Profit Factor</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format((float) data_get($performance, 'profit_factor', 0), 2) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Investor Profile</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $recommendedProfile }}</p>
                    </div>
                </div>

                <div class="mt-7 rounded-2xl border border-amber-400/20 bg-amber-400/10 p-4">
                    <p class="text-sm font-semibold text-amber-200">Risk Explanation</p>
                    <p class="mt-2 text-sm leading-7 text-amber-100/80">
                        This score blends realized drawdown behaviour, volatility tendencies, and performance consistency.
                        Use it as a screening input, not a guarantee of future return stability.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8 grid gap-8 xl:grid-cols-[1fr,1fr]">
            <div class="profile-panel rounded-[30px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-yellow-300">Profile Intelligence</p>
                <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Execution profile and capital context</h3>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Trading style</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $trader->trading_style ?: $trader->strategy_type ?: 'Systematic multi-asset' }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Preferred instruments</p>
                        <p class="mt-2 text-sm font-semibold text-white">{{ $trader->preferred_instruments ?: $markets->implode(', ') }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Sharpe-like ratio</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format((float) data_get($performance, 'sharpe_ratio', 0), 2) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Watchlist status</p>
                        <p class="mt-2 text-sm font-semibold {{ $watchlisted ? 'text-yellow-200' : 'text-slate-200' }}">
                            {{ $watchlisted ? 'Tracked by you' : 'Not watchlisted yet' }}
                        </p>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-3">
                    <article class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Top ROI Board</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($leaderboardTopRoi)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-emerald-300">Marketplace leader</p>
                    </article>
                    <article class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Most Copied</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($leaderboardMostCopied)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-yellow-300">Follower momentum</p>
                    </article>
                    <article class="rounded-2xl border border-white/10 bg-black/25 p-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">Lowest Drawdown</p>
                        <p class="mt-2 truncate text-base font-black text-white">{{ optional($leaderboardLowestDrawdown)->name ?: 'N/A' }}</p>
                        <p class="mt-1 text-xs font-semibold text-amber-300">Capital protection leader</p>
                    </article>
                </div>
            </div>

            <div class="profile-panel rounded-[30px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-sky-300">Monthly Breakdown</p>
                <div class="mt-6 overflow-x-auto rounded-[24px] border border-white/10">
                    <table class="min-w-[560px] divide-y divide-white/10 text-sm sm:min-w-full">
                        <thead class="bg-black/35 text-left text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-5 py-4">Period</th>
                                <th class="px-5 py-4">Return</th>
                                <th class="px-5 py-4">Drawdown</th>
                                <th class="px-5 py-4">Trades</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10 bg-white/[0.02] text-slate-300">
                            @forelse ($monthlyTable as $row)
                                @php $rowReturn = (float) data_get($row, 'return_percentage', 0); @endphp
                                <tr>
                                    <td class="px-5 py-4 font-semibold text-white">{{ data_get($row, 'period', '-') }}</td>
                                    <td class="px-5 py-4 {{ $rowReturn >= 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                        {{ $rowReturn >= 0 ? '+' : '' }}{{ number_format($rowReturn, 1) }}%
                                    </td>
                                    <td class="px-5 py-4 text-amber-300">{{ number_format((float) data_get($row, 'drawdown_percentage', 0), 1) }}%</td>
                                    <td class="px-5 py-4">{{ number_format((int) data_get($row, 'trades_count', 0)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-8 text-center text-sm text-slate-400">No monthly performance data available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="profile-panel rounded-[30px] p-6 sm:p-8 xl:col-span-2">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-emerald-300">Recent Trade History</p>
                <div class="mt-6 space-y-3">
                    @forelse ($recentTrades as $trade)
                        <div class="rounded-2xl border border-white/10 bg-black/30 px-5 py-4">
                            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:gap-4">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-white">{{ $trade->symbol ?: 'N/A' }}</p>
                                    <p class="text-[11px] uppercase tracking-[0.18em] text-slate-500">
                                        {{ strtoupper($trade->direction ?: 'N/A') }} · {{ $trade->status ?: 'Pending' }}
                                    </p>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="font-semibold {{ (float) ($trade->profit_loss ?? 0) >= 0 ? 'text-emerald-300' : 'text-rose-300' }}">
                                        {{ (float) ($trade->profit_loss ?? 0) >= 0 ? '+' : '' }}${{ number_format((float) ($trade->profit_loss ?? 0), 2) }}
                                    </p>
                                    <p class="text-xs text-slate-500">{{ optional($trade->opened_at)->format('d M Y') ?: 'Pending' }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-white/10 bg-black/30 px-5 py-8 text-center text-sm text-slate-400">
                            Trade history will appear once copied trade records are available for this trader.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const chartLabels = @json(collect(data_get($charts, 'labels', []))->values());
        const returnsData = @json(collect(data_get($charts, 'returns', []))->values());
        const equityData = @json(collect(data_get($charts, 'equity_curve', []))->values());
        const drawdownData = @json(collect(data_get($charts, 'drawdown', []))->values());

        const returnsChart = document.getElementById('returnsChart');
        const equityChart = document.getElementById('equityChart');
        const drawdownChart = document.getElementById('drawdownChart');

        if (returnsChart) {
            new Chart(returnsChart, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Monthly return',
                        data: returnsData,
                        backgroundColor: 'rgba(16, 185, 129, 0.55)',
                        borderRadius: 12,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                color: 'rgba(148,163,184,.08)'
                            }
                        },
                    }
                }
            });
        }

        if (equityChart) {
            new Chart(equityChart, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: equityData,
                        borderColor: '#38bdf8',
                        backgroundColor: 'rgba(56, 189, 248, 0.15)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 0,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                color: 'rgba(148,163,184,.08)'
                            }
                        },
                    }
                }
            });
        }

        if (drawdownChart) {
            new Chart(drawdownChart, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: drawdownData,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.15)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 0,
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            ticks: {
                                color: '#64748b'
                            },
                            grid: {
                                color: 'rgba(148,163,184,.08)'
                            }
                        },
                    }
                }
            });
        }
    </script>
@endpush
