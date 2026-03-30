@extends('layouts.admin-dasht')

@php
    $currency = data_get($settings, 'currency', '$');
    $totalAllocated = (float) $activeTrades->sum(fn ($trade) => $trade->allocation_amount ?: $trade->price);
    $totalProfit = (float) $activeTrades->sum('total_profit');
    $avgReturn = (float) $activeTrades->avg('profit_percentage');
    $avgWinRate = (float) $activeTrades->avg(function ($trade) {
        return data_get($trade, 'trader.win_rate', 0);
    });
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-500 transition-colors">Admin</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('admin.copy.index') }}" class="hover:text-yellow-500 transition-colors">Copy Trading</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Active Trades</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Active Copy <span class="gold-text">Allocations</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Monitor investor capital currently linked to expert traders, live profit movement, and any subscriptions that need intervention.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.copy.statistics') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 mr-2"></i>
                    Statistics
                </a>
                <a href="{{ route('admin.copy.create') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Add Expert
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Active Positions</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($activeTrades->count()) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">live subscriptions currently copying</div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Allocated Capital</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ $currency }}{{ number_format($totalAllocated, 2) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">capital tied to active experts</div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Total Open P/L</span>
                <div class="text-3xl font-black tracking-tighter mb-2 {{ $totalProfit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $totalProfit >= 0 ? '+' : '-' }}{{ $currency }}{{ number_format(abs($totalProfit), 2) }}
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">aggregate unrealized platform result</div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Average Return</span>
                <div class="text-3xl font-black tracking-tighter mb-2 {{ $avgReturn >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $avgReturn >= 0 ? '+' : '' }}{{ number_format($avgReturn, 2) }}%
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">trailing profit percentage across active copy accounts</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.5fr)_360px] gap-8">
            <div class="dashboard-glass overflow-hidden">
                <div class="p-8 border-b border-white/5 bg-white/[0.02] flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-white uppercase tracking-tight">Live Copy Trading Book</h2>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-[0.24em] mt-1">Investor, trader, balance, return, and operational state</p>
                    </div>
                    <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                        {{ number_format($activeTrades->count()) }} open positions
                    </div>
                </div>

                @if ($activeTrades->isNotEmpty())
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 border-b border-white/5">
                                    <th class="px-8 py-5">Investor</th>
                                    <th class="px-8 py-5">Trader</th>
                                    <th class="px-8 py-5">Allocation</th>
                                    <th class="px-8 py-5">Performance</th>
                                    <th class="px-8 py-5">Lifecycle</th>
                                    <th class="px-8 py-5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach ($activeTrades as $trade)
                                    @php
                                        $investor = $trade->investor ?: $trade->user;
                                        $trader = $trade->trader ?: $trade->expert;
                                        $startedAt = $trade->started_at ?: $trade->created_at;
                                        $allocation = (float) ($trade->allocation_amount ?: $trade->price);
                                        $balance = (float) ($trade->current_balance ?: ($allocation + $trade->total_profit));
                                        $return = (float) ($trade->profit_percentage ?? 0);
                                        $traderAvatar = $trader && $trader->photo ? asset('storage/' . $trader->photo) : null;
                                    @endphp
                                    <tr class="hover:bg-white/[0.02] transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                <div class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white font-black">
                                                    {{ strtoupper(substr($investor->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-white">{{ $investor->name ?? 'Unknown investor' }}</p>
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">{{ $investor->email ?? 'No email' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center gap-4">
                                                @if ($traderAvatar)
                                                    <img src="{{ $traderAvatar }}" alt="{{ $trader->name }}" class="h-12 w-12 rounded-2xl object-cover border border-white/10">
                                                @else
                                                    <div class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center text-white font-black">
                                                        {{ strtoupper(substr($trader->name ?? 'T', 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <p class="text-sm font-bold text-white">{{ $trader->name ?? ($trade->name ?: 'Unknown trader') }}</p>
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                                        {{ $trader->strategy_type ?? $trade->tag ?? 'Copy strategy' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="text-sm font-black text-white">{{ $currency }}{{ number_format($allocation, 2) }}</p>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">Current balance {{ $currency }}{{ number_format($balance, 2) }}</p>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="text-sm font-black {{ $trade->total_profit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $trade->total_profit >= 0 ? '+' : '-' }}{{ $currency }}{{ number_format(abs((float) $trade->total_profit), 2) }}
                                            </p>
                                            <p class="text-[10px] font-black uppercase tracking-widest mt-1 {{ $return >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $return >= 0 ? '+' : '' }}{{ number_format($return, 2) }}% return
                                            </p>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="text-sm font-bold text-white">{{ optional($startedAt)->diffForHumans() ?? 'Recently opened' }}</p>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                                Opened {{ optional($startedAt)->format('M d, Y') ?? 'Unknown' }}
                                            </p>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex flex-col gap-2">
                                                <span class="inline-flex w-fit items-center px-3 py-1 rounded-full {{ $trade->status === 'active' || $trade->active === 'yes' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' }} border text-[9px] font-black uppercase tracking-widest">
                                                    {{ $trade->status ?: ucfirst((string) $trade->active) }}
                                                </span>
                                                <span class="inline-flex w-fit items-center px-3 py-1 rounded-full {{ data_get($trader, 'status') === 'active' ? 'bg-blue-500/10 border-blue-500/20 text-blue-400' : 'bg-rose-500/10 border-rose-500/20 text-rose-400' }} border text-[9px] font-black uppercase tracking-widest">
                                                    Trader {{ data_get($trader, 'status', 'unknown') }}
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="lg:hidden p-5 space-y-4">
                        @foreach ($activeTrades as $trade)
                            @php
                                $investor = $trade->investor ?: $trade->user;
                                $trader = $trade->trader ?: $trade->expert;
                                $startedAt = $trade->started_at ?: $trade->created_at;
                                $allocation = (float) ($trade->allocation_amount ?: $trade->price);
                                $return = (float) ($trade->profit_percentage ?? 0);
                            @endphp
                            <div class="rounded-3xl border border-white/10 bg-white/[0.02] p-5 space-y-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $investor->name ?? 'Unknown investor' }}</p>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">{{ $investor->email ?? 'No email' }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full {{ $trade->status === 'active' || $trade->active === 'yes' ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' }} border text-[9px] font-black uppercase tracking-widest">
                                        {{ $trade->status ?: ucfirst((string) $trade->active) }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Trader</p>
                                        <p class="text-white font-semibold">{{ $trader->name ?? ($trade->name ?: 'Unknown trader') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Allocation</p>
                                        <p class="text-white font-semibold">{{ $currency }}{{ number_format($allocation, 2) }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Open P/L</p>
                                        <p class="font-semibold {{ $trade->total_profit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                            {{ $trade->total_profit >= 0 ? '+' : '-' }}{{ $currency }}{{ number_format(abs((float) $trade->total_profit), 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1">Return</p>
                                        <p class="font-semibold {{ $return >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                            {{ $return >= 0 ? '+' : '' }}{{ number_format($return, 2) }}%
                                        </p>
                                    </div>
                                </div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                                    Started {{ optional($startedAt)->format('M d, Y') ?? 'Unknown' }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-20 text-center">
                        <i data-lucide="activity" class="w-16 h-16 text-slate-700 mx-auto mb-6"></i>
                        <h3 class="text-lg font-black text-white uppercase tracking-widest">No Active Copy Trades</h3>
                        <p class="text-slate-500 text-sm font-medium mt-2 max-w-lg mx-auto leading-relaxed">There are no live subscriptions copying trader activity right now. Once users subscribe, open allocations will appear here.</p>
                        <a href="{{ route('admin.copy.index') }}"
                            class="mt-8 inline-flex items-center px-8 py-4 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-105 transition-all">
                            Back to Expert Board
                        </a>
                    </div>
                @endif
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Operations Snapshot</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Average trader win rate</p>
                            <p class="text-2xl font-black text-white">{{ number_format($avgWinRate, 1) }}%</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Profitable positions</p>
                            <p class="text-2xl font-black text-emerald-400">{{ number_format($activeTrades->where('total_profit', '>', 0)->count()) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Paused or stale records</p>
                            <p class="text-2xl font-black text-yellow-400">{{ number_format($activeTrades->where('status', '!=', 'active')->count()) }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Operator Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.copy.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            Expert management board
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        <a href="{{ route('admin.copy.statistics') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            Performance statistics
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        <a href="{{ route('admin.copy.create') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            Add new expert trader
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
