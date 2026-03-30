@extends('layouts.admin-dasht')

@php
    $currency = data_get($settings, 'currency', '$');
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
                    <span class="text-slate-300">Statistics</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Copy Trading <span class="gold-text">Analytics</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Review expert supply, copied capital, follower demand, and live subscription behavior across the copy marketplace.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.copy.active-trades') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="activity" class="w-4 h-4 mr-2"></i>
                    Active Trades
                </a>
                <a href="{{ route('admin.copy.index') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Board
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Expert Supply</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($stats['total_experts']) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ number_format($stats['active_experts']) }} active, {{ number_format($stats['verified_experts']) }} verified
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Live Copy Accounts</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($stats['active_copy_trades']) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ number_format($stats['paused_copy_trades']) }} paused, {{ number_format($stats['total_users_copying']) }} unique investors
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Active Capital</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ $currency }}{{ number_format((float) $stats['total_invested'], 2) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ number_format($stats['total_copy_trades']) }} lifetime subscription records
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Net P/L & Fees</span>
                <div class="text-3xl font-black {{ (float) $stats['total_profit'] >= 0 ? 'text-emerald-400' : 'text-rose-400' }} tracking-tighter mb-2">
                    {{ (float) $stats['total_profit'] >= 0 ? '+' : '-' }}{{ $currency }}{{ number_format(abs((float) $stats['total_profit']), 2) }}
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ $currency }}{{ number_format((float) $stats['platform_fees'], 2) }} platform fees booked
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.5fr)_360px] gap-8">
            <div class="space-y-8">
                <div class="dashboard-glass overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h2 class="text-lg font-black text-white uppercase tracking-tight">Top Performing Experts</h2>
                        <p class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-500 mt-1">Ranked by monthly ROI, lifetime profit, and active copier demand</p>
                    </div>

                    @if ($topExperts->isNotEmpty())
                        <div class="divide-y divide-white/5">
                            @foreach ($topExperts as $index => $expert)
                                <div class="px-8 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-white/[0.02] transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="h-11 w-11 rounded-2xl bg-black border border-white/10 flex items-center justify-center text-sm font-black gold-text">
                                            {{ $index + 1 }}
                                        </div>
                                        @if ($expert->photo)
                                            <img src="{{ asset('storage/' . $expert->photo) }}" alt="{{ $expert->name }}" class="h-12 w-12 rounded-2xl object-cover border border-white/10">
                                        @else
                                            <div class="h-12 w-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center text-white font-black">
                                                {{ strtoupper(substr($expert->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-bold text-white">{{ $expert->name }}</p>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                                {{ $expert->strategy_type ?: ($expert->tag ?: 'Expert trader') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-8 text-left md:text-right">
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Monthly ROI</p>
                                            <p class="text-sm font-black text-emerald-400">+{{ number_format((float) ($expert->monthly_roi ?? 0), 2) }}%</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Lifetime Profit</p>
                                            <p class="text-sm font-black text-white">+{{ number_format((float) $expert->total_profit, 2) }}%</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Active Copiers</p>
                                            <p class="text-sm font-black text-white">{{ number_format((int) $expert->active_copiers_count) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-16 text-center">
                            <i data-lucide="bar-chart-3" class="w-14 h-14 text-slate-700 mx-auto mb-5"></i>
                            <p class="text-slate-400">No expert performance data is available yet.</p>
                        </div>
                    @endif
                </div>

                <div class="dashboard-glass overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h2 class="text-lg font-black text-white uppercase tracking-tight">Recent Marketplace Activity</h2>
                        <p class="text-[10px] font-black uppercase tracking-[0.22em] text-slate-500 mt-1">Latest investor subscriptions and copy allocation events</p>
                    </div>

                    @if ($recentActivity->isNotEmpty())
                        <div class="divide-y divide-white/5">
                            @foreach ($recentActivity as $activity)
                                @php
                                    $investor = $activity->investor;
                                    $trader = $activity->trader;
                                    $allocation = (float) ($activity->allocation_amount ?: $activity->price);
                                @endphp
                                <div class="px-8 py-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-white/[0.02] transition-colors">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $investor->name ?? 'Unknown investor' }}</p>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                            {{ $activity->status === 'active' ? 'Copying' : ucfirst((string) $activity->status) }}
                                            {{ $trader->name ?? ($activity->name ?: 'Unknown trader') }}
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6 text-left md:text-right">
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Allocation</p>
                                            <p class="text-sm font-black text-white">{{ $currency }}{{ number_format($allocation, 2) }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mb-1">Opened</p>
                                            <p class="text-sm font-black text-white">{{ optional($activity->created_at)->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-16 text-center">
                            <i data-lucide="activity" class="w-14 h-14 text-slate-700 mx-auto mb-5"></i>
                            <p class="text-slate-400">No copy trading activity has been recorded yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Popularity Board</h3>
                    <div class="space-y-4">
                        @forelse ($popularExperts as $expert)
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $expert->name }}</p>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                            {{ number_format((int) $expert->followers) }} followers
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-black text-white">{{ number_format((int) $expert->active_copiers_count) }}</p>
                                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">active copiers</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-5 text-sm text-slate-400">
                                No popularity ranking available yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Operator Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.copy.create') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            Add expert trader
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        <a href="{{ route('admin.copy.index') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            Expert management board
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        <a href="{{ route('admin.copy.active-trades') }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            View active subscriptions
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
