@extends('layouts.dasht')
@section('title', 'Trading Analytics')
@section('content')

    <div class="space-y-12 animate-fadeIn">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('user.bots.index') }}" class="hover:text-yellow-500 transition-colors uppercase">Trading
                        Bots</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Analytics</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Bot <span class="gold-text">Analytics</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Monitor real-time performance and profit data
                    for your active bots.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('user.bots.index') }}"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Start New Bot
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <!-- Performance Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="dashboard-glass p-6 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-500/5 blur-2xl group-hover:bg-yellow-500/10 transition-all">
                </div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Total
                    Invested</span>
                <div class="text-2xl font-black text-white tracking-tighter">
                    {{ auth()->user()->currency }}{{ number_format($stats['total_invested'], 2) }}</div>
                <div class="mt-4 flex items-center text-[8px] font-black text-slate-600 uppercase">
                    <i data-lucide="shield" class="w-3 h-3 mr-1 text-yellow-500"></i>
                    Invested Amount
                </div>
            </div>

            <div class="dashboard-glass p-6 relative overflow-hidden group hover:border-emerald-500/20 transition-all">
                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/5 blur-2xl group-hover:bg-emerald-500/10 transition-all">
                </div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Total Value</span>
                <div class="text-2xl font-black text-emerald-400 tracking-tighter">
                    {{ auth()->user()->currency }}{{ number_format($stats['current_balance'], 2) }}</div>
                <div class="mt-4 flex items-center text-[8px] font-black text-emerald-500 uppercase">
                    <i data-lucide="activity" class="w-3 h-3 mr-1"></i>
                    Live Profit Evaluation
                </div>
            </div>

            <div class="dashboard-glass p-6 relative overflow-hidden group hover:border-emerald-500/20 transition-all">
                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-500/5 blur-2xl group-hover:bg-emerald-500/10 transition-all">
                </div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Total Profit</span>
                <div class="text-2xl font-black text-emerald-400 tracking-tighter">
                    +{{ auth()->user()->currency }}{{ number_format($stats['total_profit'], 2) }}</div>
                <div class="mt-4 flex items-center text-[8px] font-black text-emerald-500 uppercase">
                    <i data-lucide="trending-up" class="w-3 h-3 mr-1"></i>
                    Total Earnings
                </div>
            </div>

            <div class="dashboard-glass p-6 relative overflow-hidden group hover:border-rose-500/20 transition-all">
                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-rose-500/5 blur-2xl group-hover:bg-rose-500/10 transition-all">
                </div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Total Loss</span>
                <div class="text-2xl font-black text-rose-400 tracking-tighter">
                    -{{ auth()->user()->currency }}{{ number_format($stats['total_loss'], 2) }}</div>
                <div class="mt-4 flex items-center text-[8px] font-black text-rose-500 uppercase">
                    <i data-lucide="trending-down" class="w-3 h-3 mr-1"></i>
                    Estimated Loss
                </div>
            </div>

            <div class="dashboard-glass p-6 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div
                    class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-500/5 blur-2xl group-hover:bg-yellow-500/10 transition-all">
                </div>
                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3 block">Running Bots</span>
                <div class="text-2xl font-black text-white tracking-tighter">{{ $stats['active_bots'] }}</div>
                <div class="mt-4 flex items-center text-[8px] font-black text-slate-600 uppercase">
                    <i data-lucide="cpu" class="w-3 h-3 mr-1 gold-text"></i>
                    Online Bots
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Active Node Ledger -->
            <div class="lg:col-span-8 space-y-8">
                <div class="dashboard-glass border-white/5 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black text-white uppercase tracking-widest">Active Investment List</h3>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Real-time stats</span>
                    </div>

                    @if($investments->count() > 0)
                        <div class="space-y-4">
                            @foreach($investments as $investment)
                                <div
                                    class="p-6 rounded-2xl bg-white/[0.02] border border-white/5 hover:border-white/10 transition-all group">
                                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                        <div class="flex items-center space-x-5">
                                            <div
                                                class="h-14 w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-all shadow-xl">
                                                @if($investment->bot->image)
                                                    <img src="{{ asset('storage/' . $investment->bot->image) }}"
                                                        class="h-full w-full rounded-[14px] object-cover">
                                                @else
                                                    <i data-lucide="bot" class="w-7 h-7 gold-text"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="text-xs font-black text-white uppercase tracking-tight">
                                                    {{ $investment->bot->name }}</h4>
                                                <div class="flex items-center mt-1">
                                                    @if($investment->status == 'active')
                                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                                        <span
                                                            class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Running</span>
                                                    @else
                                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-600 mr-2"></span>
                                                        <span
                                                            class="text-[9px] font-black text-slate-600 uppercase tracking-widest">{{ $investment->status }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-8">
                                            <div>
                                                <span
                                                    class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Investment</span>
                                                <span
                                                    class="text-xs font-black text-white font-mono">{{ auth()->user()->currency }}{{ number_format($investment->investment_amount, 2) }}</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Total
                                                    Value</span>
                                                <span
                                                    class="text-xs font-black text-white font-mono">{{ auth()->user()->currency }}{{ number_format($investment->current_balance ?? $investment->investment_amount, 2) }}</span>
                                            </div>
                                            <div class="hidden md:block">
                                                <span
                                                    class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Profit %</span>
                                @php
                                    $pnl = ($investment->current_balance ?? $investment->investment_amount) - $investment->investment_amount;
                                    $roi = $investment->investment_amount > 0 ? ($pnl / $investment->investment_amount) * 100 : 0;
                                @endphp
                                                <span
                                                    class="text-xs font-black font-mono {{ $pnl >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                    {{ $pnl >= 0 ? '+' : '' }}{{ number_format($roi, 1) }}%
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center space-x-3">
                                            <a href="{{ route('user.bots.show', $investment->bot) }}"
                                                class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:border-white/20 transition-all">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <a href="{{ route('user.bots.history', $investment) }}"
                                                class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:border-white/20 transition-all">
                                                <i data-lucide="history" class="w-4 h-4"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-20 text-center border-2 border-dashed border-white/5 rounded-3xl">
                            <i data-lucide="bot" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
                            <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">No Active Nodes Detected
                            </h4>
                            <p class="text-[10px] text-slate-600 font-bold uppercase mt-2">Deploy your first algorithmic relay
                                to begin yield generation.</p>
                            <a href="{{ route('user.bots.index') }}"
                                class="inline-block mt-8 text-[10px] font-black gold-text uppercase tracking-[0.2em] border-b border-yellow-500/50 pb-1 hover:text-white hover:border-white transition-all">Initial
                                Boot Sequence</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Terminal Intelligence -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Recent Transmission Log -->
                <div class="dashboard-glass border-white/5 p-8 relative overflow-hidden group">
                    <div
                        class="absolute -right-10 -bottom-10 w-32 h-32 bg-yellow-500/5 blur-3xl group-hover:bg-yellow-500/10 transition-all">
                    </div>
                    <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-4">
                        <h3 class="text-xs font-black text-white uppercase tracking-widest">Global Node Feed</h3>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Real-time</span>
                    </div>

                    @if($recentTrades->count() > 0)
                        <div class="space-y-6">
                            @foreach($recentTrades->take(6) as $trade)
                                <div class="flex items-start justify-between group">
                                    <div class="flex items-start space-x-3">
                                        <div
                                            class="mt-1 h-1.5 w-1.5 rounded-full {{ $trade->profit_loss >= 0 ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}">
                                        </div>
                                        <div>
                                            <div
                                                class="text-[10px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">
                                                {{ $trade->userBotInvestment->bot->name ?? 'Algorithmic Execution' }}
                                            </div>
                                            <div class="text-[8px] font-bold text-slate-600 uppercase tracking-widest mt-0.5">
                                                {{ $trade->opened_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div
                                            class="text-[10px] font-black font-mono {{ $trade->profit_loss >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                            {{ $trade->profit_loss >= 0 ? '+' : '-' }}{{ number_format($trade->profit_loss, 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i data-lucide="radio" class="w-8 h-8 text-slate-800 mx-auto mb-4"></i>
                            <p class="text-[9px] font-black text-slate-600 uppercase tracking-widest italic">Scanning
                                Frequency...</p>
                        </div>
                    @endif

                    <div class="mt-10 p-5 rounded-2xl bg-white/[0.02] border border-white/5">
                        <div class="flex items-center space-x-3 mb-3">
                            <i data-lucide="info" class="w-3 h-3 gold-text"></i>
                            <h4 class="text-[9px] font-black text-slate-500 uppercase">System Intelligence</h4>
                        </div>
                        <p class="text-[8px] text-slate-600 font-bold uppercase leading-relaxed italic">
                            All algorithmic nodes operate on sub-millisecond response latency. Throughput is verified via
                            decentralized ledger synchronization.
                        </p>
                    </div>
                </div>

                <!-- Control Console -->
                <div class="dashboard-glass border-white/5 p-8 overflow-hidden relative group">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center">
                            <i data-lucide="terminal" class="w-5 h-5 gold-text"></i>
                        </div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Quick Commands</h4>
                    </div>
                    <div class="space-y-3">
                        <a href="{{ route('user.bots.index') }}"
                            class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-yellow-500/30 hover:bg-yellow-500/[0.02] transition-all group/btn">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="plus" class="w-4 h-4 text-slate-500 group-hover/btn:gold-text"></i>
                                <span
                                    class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/btn:text-white">Deploy
                                    Node</span>
                            </div>
                            <i data-lucide="chevron-right"
                                class="w-3 h-3 text-slate-700 group-hover/btn:text-yellow-500"></i>
                        </a>
                        <a href="{{ route('deposits') }}"
                            class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-yellow-500/30 hover:bg-yellow-500/[0.02] transition-all group/btn">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="arrow-up" class="w-4 h-4 text-slate-500 group-hover/btn:gold-text"></i>
                                <span
                                    class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/btn:text-white">Fuel
                                    Account</span>
                            </div>
                            <i data-lucide="chevron-right"
                                class="w-3 h-3 text-slate-700 group-hover/btn:text-yellow-500"></i>
                        </a>
                        <a href="{{ route('withdrawalsdeposits') }}"
                            class="flex items-center justify-between p-4 rounded-xl bg-white/[0.03] border border-white/5 hover:border-yellow-500/30 hover:bg-yellow-500/[0.02] transition-all group/btn">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="arrow-down" class="w-4 h-4 text-slate-500 group-hover/btn:gold-text"></i>
                                <span
                                    class="text-[9px] font-black text-slate-400 uppercase tracking-widest group-hover/btn:text-white">Liquidate
                                    Asset</span>
                            </div>
                            <i data-lucide="chevron-right"
                                class="w-3 h-3 text-slate-700 group-hover/btn:text-yellow-500"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endpush