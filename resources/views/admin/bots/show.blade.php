@extends('layouts.admin-dasht')

@section('content')
    @php
        $tradingPairs = $bot->trading_pairs;
        if (is_string($tradingPairs)) {
            $tradingPairs = json_decode($tradingPairs, true) ?: [];
        } elseif (!is_array($tradingPairs)) {
            $tradingPairs = [];
        }

        $statusLabel = ucfirst((string) $bot->status);
        $statusClass = match ($bot->status) {
            'active' => 'badge-success',
            'inactive' => 'badge-secondary',
            default => 'badge-warning',
        };
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <a href="{{ route('admin.bots.index') }}" class="transition-colors hover:text-yellow-500">Trading Bots</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">{{ $bot->name }}</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">{{ $bot->name }} <span class="gold-text">Overview</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Monitor performance, activation status, capital thresholds, and recent trade output for this automated strategy.
                </p>
            </div>
            <div class="admin-page-actions">
                <a href="{{ route('admin.bots.index') }}" class="btn btn-outline-light btn-sm">Back to Bots</a>
                <a href="{{ route('admin.bots.edit', $bot) }}" class="btn btn-secondary btn-sm">Edit Bot</a>
                <a href="{{ route('admin.bots.analytics', $bot) }}" class="btn btn-info btn-sm">Analytics</a>
                <form action="{{ route('admin.bots.toggle-status', $bot) }}" method="POST" class="d-inline-block">
                    @csrf
                    <button type="submit" class="btn btn-{{ $bot->status === 'active' ? 'warning' : 'primary' }} btn-sm">
                        {{ $bot->status === 'active' ? 'Pause Bot' : 'Activate Bot' }}
                    </button>
                </form>
            </div>
        </section>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[360px_minmax(0,1fr)]">
            <div class="dashboard-glass overflow-hidden">
                <div class="relative flex h-44 items-end justify-center overflow-hidden bg-[radial-gradient(circle_at_top_right,_rgba(240,185,10,0.28),_transparent_38%),linear-gradient(135deg,_rgba(8,11,18,0.98),_rgba(15,23,42,0.92))] p-6">
                    @if ($bot->image)
                        <img src="{{ asset('storage/' . $bot->image) }}" alt="{{ $bot->name }}" class="h-28 w-28 rounded-full border border-white/10 object-cover shadow-2xl shadow-black/40">
                    @else
                        <div class="flex h-28 w-28 items-center justify-center rounded-full border border-white/10 bg-white/5 text-4xl text-yellow-400 shadow-2xl shadow-black/40">
                            <i class="fas fa-robot"></i>
                        </div>
                    @endif
                </div>

                <div class="p-6 text-center sm:p-7">
                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                    <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $bot->name }}</h2>
                    <p class="mt-2 text-sm font-medium text-slate-400">{{ ucfirst((string) $bot->bot_type) }} trading bot</p>
                    <p class="mt-4 text-sm leading-7 text-slate-300">{{ $bot->description ?: 'No bot description has been added yet.' }}</p>

                    <div class="mt-6 grid grid-cols-3 gap-3 text-left">
                        <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Investors</p>
                            <p class="mt-3 text-xl font-black text-white">{{ $bot->user_investments_count ?? 0 }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Success</p>
                            <p class="mt-3 text-xl font-black gold-text">{{ $bot->success_rate }}%</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Duration</p>
                            <p class="mt-3 text-xl font-black text-white">{{ $bot->duration_days }}</p>
                        </div>
                    </div>

                    @if (count($tradingPairs) > 0)
                        <div class="mt-6 border-t border-white/5 pt-6 text-left">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Trading Pairs</p>
                            <div class="mt-4 flex flex-wrap gap-2">
                                @foreach ($tradingPairs as $pair)
                                    <span class="badge badge-info">{{ $pair }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-5">
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2 2xl:grid-cols-4">
                    <div class="dashboard-glass p-6">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Earned</p>
                        <h3 class="mt-4 text-3xl font-black tracking-tight text-white">${{ number_format($bot->total_earned, 2) }}</h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">Cumulative profit generated by this bot.</p>
                    </div>
                    <div class="dashboard-glass p-6">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Users</p>
                        <h3 class="mt-4 text-3xl font-black tracking-tight text-white">{{ $bot->total_users }}</h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">Accounts currently subscribed or invested.</p>
                    </div>
                    <div class="dashboard-glass p-6">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Profit Range</p>
                        <h3 class="mt-4 text-3xl font-black tracking-tight gold-text">{{ $bot->daily_profit_min }}%-{{ $bot->daily_profit_max }}%</h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">Projected daily operating performance window.</p>
                    </div>
                    <div class="dashboard-glass p-6">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Last Trade</p>
                        <h3 class="mt-4 text-3xl font-black tracking-tight text-white">
                            @if ($bot->last_trade)
                                {{ $bot->last_trade->diffForHumans() }}
                            @else
                                Never
                            @endif
                        </h3>
                        <p class="mt-2 text-xs font-medium text-slate-400">Latest execution activity recorded for this bot.</p>
                    </div>
                </div>

                <div class="dashboard-glass p-6 sm:p-7">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Configuration</p>
                            <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Bot Parameters</h3>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">Operational Profile</span>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 lg:grid-cols-2">
                        <div class="rounded-3xl border border-white/5 bg-white/5 p-5">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Market Type</span>
                                    <span class="text-sm font-semibold text-white">{{ ucfirst((string) $bot->bot_type) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Min Investment</span>
                                    <span class="text-sm font-semibold text-white">${{ number_format($bot->min_investment, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Max Investment</span>
                                    <span class="text-sm font-semibold text-white">${{ number_format($bot->max_investment, 2) }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Success Rate</span>
                                    <span class="text-sm font-semibold gold-text">{{ $bot->success_rate }}%</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Duration</span>
                                    <span class="text-sm font-semibold text-white">{{ $bot->duration_days }} days</span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-white/5 bg-white/5 p-5">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Status</span>
                                    <span class="badge {{ $statusClass }}">{{ $statusLabel }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Daily Profit Min</span>
                                    <span class="text-sm font-semibold text-white">{{ $bot->daily_profit_min }}%</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Daily Profit Max</span>
                                    <span class="text-sm font-semibold text-white">{{ $bot->daily_profit_max }}%</span>
                                </div>
                                <div class="flex items-center justify-between gap-4 border-b border-white/5 pb-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Created</span>
                                    <span class="text-sm font-semibold text-white">{{ $bot->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between gap-4">
                                    <span class="text-[11px] font-black uppercase tracking-[0.18em] text-slate-500">Updated</span>
                                    <span class="text-sm font-semibold text-white">{{ $bot->updated_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (count($recentTrades) > 0)
            <div class="dashboard-glass overflow-hidden">
                <div class="flex flex-col gap-2 border-b border-white/5 px-6 py-5 sm:flex-row sm:items-end sm:justify-between sm:px-7">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Trade Feed</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Recent Trading Activity</h3>
                    </div>
                    <p class="text-xs font-medium text-slate-400">Latest execution outcomes for subscribed user bot investments.</p>
                </div>

                <div class="overflow-x-auto px-2 pb-2 sm:px-4">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Investment</th>
                                <th>Pair</th>
                                <th>Result</th>
                                <th>Profit/Loss</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentTrades as $trade)
                                <tr>
                                    <td>{{ $trade->userBotInvestment->user->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($trade->userBotInvestment->investment_amount, 2) }}</td>
                                    <td>{{ $trade->trading_pair }}</td>
                                    <td>
                                        @if ($trade->result === 'profit')
                                            <span class="badge badge-success">Profit</span>
                                        @else
                                            <span class="badge badge-danger">Loss</span>
                                        @endif
                                    </td>
                                    <td class="{{ $trade->result === 'profit' ? 'text-success' : 'text-danger' }}">
                                        ${{ number_format($trade->profit_loss, 2) }}
                                    </td>
                                    <td>{{ $trade->created_at->format('M d, Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
