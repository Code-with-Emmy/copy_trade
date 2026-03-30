@extends('layouts.dasht')
@section('title', 'Social Alpha Portfolio')
@section('content')

    <div class="space-y-12 animate-fadeIn">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('mcopytradings') }}" class="hover:text-yellow-500 transition-colors uppercase">Alpha Experts</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Synchronized Portfolio</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Social <span class="gold-text">Synchronized Portfolio</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Replicating institutional-grade trading strategies through verified expert nodes.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('mcopytradings') }}"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="search" class="w-4 h-4 mr-2"></i>
                    Discover Experts
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <!-- Portfolio Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center">
                        <i data-lucide="layers" class="w-5 h-5 gold-text"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Active Relays</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">{{ $stats['active_copies'] }}</div>
                    </div>
                </div>
            </div>

            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-blue-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/5 blur-[50px] pointer-events-none group-hover:bg-blue-500/10 transition-all"></div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                        <i data-lucide="shield" class="w-5 h-5 text-blue-400"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Committed Asset</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">{{ auth()->user()->currency }}{{ number_format($stats['total_invested'], 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-emerald-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-500/5 blur-[50px] pointer-events-none group-hover:bg-emerald-500/10 transition-all"></div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-5 h-5 text-emerald-400"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Aggregate Yield</span>
                        <div class="text-2xl font-black text-emerald-400 italic tracking-tighter">+{{ auth()->user()->currency }}{{ number_format($stats['total_profit'], 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <div class="flex items-center space-x-4 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <i data-lucide="gauge" class="w-5 h-5 text-slate-400"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Efficiency Rating</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">{{ number_format($stats['success_rate'], 1) }}%</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expert Relays Ledger -->
        <div class="dashboard-glass border-white/5 p-8">
            <div class="flex items-center justify-between mb-8 border-b border-white/5 pb-6">
                <h3 class="text-xs font-black text-white uppercase tracking-widest">Synchronized Expert Ledger</h3>
                <div class="flex items-center space-x-2">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">Matrix Synchronized</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5">
                            <th class="px-6 py-4">Expert Node</th>
                            <th class="px-6 py-4">Committed Assets</th>
                            <th class="px-6 py-4">Current Value</th>
                            <th class="px-6 py-4">Yield (P/L)</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($copyTrades as $trade)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-6 py-6">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center mr-4 group-hover:border-yellow-500/30 transition-all">
                                            @if($trade->expert && $trade->expert->image)
                                                <img src="{{ asset('storage/' . $trade->expert->image) }}" class="h-full w-full rounded-lg object-cover">
                                            @else
                                                <i data-lucide="user" class="w-5 h-5 gold-text"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white group-hover:gold-text transition-colors capitalize">{{ $trade->name }}</div>
                                            <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mt-0.5 italic">{{ $trade->tag ?? 'Expert Trader' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 font-mono text-sm text-white italic">
                                    {{ auth()->user()->currency }}{{ number_format($trade->price, 2) }}
                                </td>
                                <td class="px-6 py-6 font-mono text-sm text-white italic">
                                    {{ auth()->user()->currency }}{{ number_format($trade->current_balance ?? $trade->price, 2) }}
                                </td>
                                <td class="px-6 py-6">
                                    @php
                                        $pnl = ($trade->current_balance ?? $trade->price) - $trade->price;
                                    @endphp
                                    <span class="text-sm font-black font-mono {{ $pnl >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $pnl >= 0 ? '+' : '' }}{{ auth()->user()->currency }}{{ number_format($pnl, 2) }}
                                    </span>
                                    <div class="text-[9px] font-bold text-slate-600 uppercase tracking-widest mt-0.5">
                                        {{ number_format($trade->profit_percentage ?? 0, 2) }}% ROI
                                    </div>
                                </td>
                                <td class="px-6 py-6">
                                    @if($trade->active == 'yes')
                                        <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[9px] font-black uppercase tracking-tighter">Synchronized</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-slate-500/10 text-slate-500 text-[9px] font-black uppercase tracking-tighter">Terminated</span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button class="h-9 w-9 flex items-center justify-center rounded-lg bg-white/5 border border-white/10 text-slate-400 hover:text-white hover:border-white/20 transition-all">
                                            <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                                        </button>
                                        @if($trade->active == 'yes')
                                            <form action="{{ route('user.copy-trading.stop', $trade->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="h-9 w-9 flex items-center justify-center rounded-lg bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-all" title="Terminate Projection">
                                                    <i data-lucide="power" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="max-w-xs mx-auto">
                                        <i data-lucide="users" class="w-12 h-12 text-slate-800 mx-auto mb-4"></i>
                                        <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">No Active Projections</h4>
                                        <p class="text-[10px] text-slate-600 font-bold uppercase mt-2">Discover elite trading experts and synchronize your capital with their strategies.</p>
                                        <a href="{{ route('mcopytradings') }}" class="inline-block mt-8 text-[10px] font-black gold-text uppercase tracking-[0.2em] border-b border-yellow-500/50 pb-1 hover:text-white hover:border-white transition-all">Discover Alpha</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
