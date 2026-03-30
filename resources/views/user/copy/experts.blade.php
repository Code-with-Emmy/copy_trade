@extends('layouts.dasht')
@section('title', 'Social Copy Marketplace')
@section('content')
    <div x-data="{
            copyModal: { open: false, id: null, name: '', minAllocation: 0, copyRatio: 1, riskPreference: 'balanced', maxDrawdown: 10 },
            openCopyModal(payload) { this.copyModal = { open: true, ...payload }; },
            currency(value) { return '{{ auth()->user()->currency ?? '$' }}' + Number(value || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }
        }" class="page-content-stack animate-fadeIn">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('copy.dashboard') }}" class="hover:text-yellow-500 transition-colors">Social Copy</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Marketplace</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Social <span class="gold-text">Intelligence</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Discover and synchronize with high-performance
                    institutional capital managers.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('copy.dashboard') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                    Command Center
                </a>
            </div>
        </div>

        @if(session('success'))
            <div
                class="rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-5 py-4 text-xs font-bold text-emerald-400 uppercase tracking-widest">
                <div class="flex items-center">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-3"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div
                class="rounded-2xl border border-rose-400/25 bg-rose-400/10 px-5 py-4 text-xs font-bold text-rose-400 uppercase tracking-widest">
                <div class="flex items-center">
                    <i data-lucide="alert-circle" class="w-4 h-4 mr-3"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Search & Filter Board -->
        <div class="dashboard-glass border-white/5 p-6 sm:p-8 relative overflow-hidden group">
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all duration-1000">
            </div>

            <form method="GET" action="{{ route('copy.experts') }}" class="relative space-y-6 sm:space-y-8">
                <div class="grid gap-5 sm:gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Strategy
                            Search</label>
                        <div class="relative group">
                            <i data-lucide="search"
                                class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:gold-text"></i>
                            <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                                placeholder="Name or Protocol..."
                                class="w-full bg-black/50 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-sm text-white placeholder:text-slate-700 focus:border-yellow-500/50 focus:ring-0 transition-all">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Performance
                            Tier</label>
                        <select name="sort"
                            class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:border-yellow-500/50 focus:ring-0 transition-all">
                            <option value="top_returns" @selected(($filters['sort'] ?? 'top_returns') === 'top_returns')>Alpha
                                Performance</option>
                            <option value="trending" @selected(($filters['sort'] ?? '') === 'trending')>Trending Vectors
                            </option>
                            <option value="most_copied" @selected(($filters['sort'] ?? '') === 'most_copied')>Capital Density
                            </option>
                            <option value="lowest_risk" @selected(($filters['sort'] ?? '') === 'lowest_risk')>Risk Mitigation
                            </option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Risk
                            Profile</label>
                        <select name="risk_level"
                            class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:border-yellow-500/50 focus:ring-0 transition-all">
                            <option value="">All Tiers</option>
                            <option value="low" @selected(($filters['risk_level'] ?? '') === 'low')>Conservative</option>
                            <option value="balanced" @selected(($filters['risk_level'] ?? '') === 'medium')>Balanced</option>
                            <option value="high" @selected(($filters['risk_level'] ?? '') === 'high')>Aggressive</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-3">
                        <button type="submit"
                            class="flex-1 h-12 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-yellow-500/10">
                            Synchronize Filters
                        </button>
                        <a href="{{ route('copy.experts') }}"
                            class="px-5 h-12 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all">
                            <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Leaderboard / Featured -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:gap-8">
            <div class="xl:col-span-2 space-y-6 sm:space-y-8">
                <h2 class="text-xs font-black text-white uppercase tracking-[0.2em] ml-1">Alpha Managers</h2>
                <div class="grid gap-5 sm:gap-6 md:grid-cols-2">
                    @foreach(collect($sections['featured'])->take(2) as $trader)
                        <div
                            class="dashboard-glass border-white/5 p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                            <div
                                class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                            </div>

                            <div class="flex items-start justify-between mb-8">
                                <div class="relative">
                                    <div
                                        class="h-16 w-16 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-colors">
                                        @if($trader->photo)
                                            <img src="{{ asset('storage/' . $trader->photo) }}"
                                                class="h-full w-full rounded-[14px] object-cover">
                                        @else
                                            <span
                                                class="text-xl font-black gold-text italic tracking-tighter">{{ strtoupper(substr($trader->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    @if($trader->verification_status === 'verified')
                                        <div
                                            class="absolute -bottom-1 -right-1 h-6 w-6 bg-emerald-500 rounded-lg flex items-center justify-center border-4 border-[#0a0a0a] shadow-lg">
                                            <i data-lucide="check" class="w-3 h-3 text-black"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span
                                        class="block text-[10px] font-black text-emerald-400 uppercase tracking-widest">+{{ number_format((float) $trader->monthly_roi, 2) }}%</span>
                                    <span class="text-[9px] font-bold text-slate-500 uppercase">Monthly ROI</span>
                                </div>
                            </div>

                            <h3
                                class="text-xl font-black text-white mb-2 italic tracking-tight uppercase underline decoration-yellow-500/30 underline-offset-4">
                                {{ $trader->name }}</h3>
                            <p class="text-xs text-slate-400 font-medium mb-6 line-clamp-2 leading-relaxed">
                                {{ $trader->bio ?: $trader->description }}</p>

                            <div class="grid grid-cols-2 gap-4 mb-8">
                                <div class="bg-white/[0.02] border border-white/5 rounded-xl p-3">
                                    <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">AUM
                                        Managed</span>
                                    <span
                                        class="text-white font-black font-mono text-xs">${{ number_format((float) $trader->aum, 0) }}</span>
                                </div>
                                <div class="bg-white/[0.02] border border-white/5 rounded-xl p-3">
                                    <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Risk
                                        Tier</span>
                                    <span
                                        class="text-yellow-500 font-black text-[9px] uppercase">{{ $trader->risk_level }}</span>
                                </div>
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('copy.show', $trader->slug ?: $trader->id) }}"
                                    class="flex-1 py-3 text-center rounded-xl bg-white/5 border border-white/10 text-[9px] font-black text-slate-300 uppercase tracking-widest hover:bg-white/10 transition-all">Details</a>
                                <button
                                    @click="openCopyModal({ id: {{ $trader->id }}, name: @js($trader->name), minAllocation: {{ max((float) ($trader->price ?? 0), (float) ($trader->minimum_allocation ?? 100)) }}, copyRatio: 1, riskPreference: 'balanced', maxDrawdown: {{ max(5, (float) ($trader->max_drawdown ?? 15)) }} })"
                                    class="flex-1 py-3 gold-gradient-bg rounded-xl text-black font-black text-[9px] uppercase tracking-widest hover:scale-105 transition-all">Synchronize</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-6 sm:space-y-8">
                <h2 class="text-xs font-black text-white uppercase tracking-[0.2em] ml-1">Ranked Matrix</h2>
                <div class="dashboard-glass border-white/5 p-6 overflow-hidden">
                    <div class="space-y-6">
                        @foreach(collect($leaderboards['top_roi'])->take(5) as $index => $trader)
                            <div class="flex items-center justify-between group cursor-pointer"
                                onclick="window.location='{{ route('copy.show', $trader->slug ?: $trader->id) }}'">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-white/5 flex items-center justify-center text-[10px] font-black text-slate-500 group-hover:gold-text group-hover:bg-yellow-500/10 transition-all">
                                        0{{ $index + 1 }}</div>
                                    <div>
                                        <div
                                            class="text-xs font-black text-white uppercase group-hover:gold-text transition-colors">
                                            {{ $trader->name }}</div>
                                        <div class="text-[9px] text-slate-600 font-bold uppercase tracking-tighter">
                                            {{ $trader->strategy_type ?: 'Proprietary Algorithm' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-black text-emerald-400 font-mono">
                                        {{ number_format((float) $trader->monthly_roi, 2) }}%</div>
                                    <div class="text-[9px] text-slate-700 font-black uppercase tracking-widest">30D ROI</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('copy.dashboard') }}"
                        class="mt-8 block text-center py-4 rounded-xl border border-white/5 text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-white hover:border-white/10 transition-all">View
                        Extended Matrix</a>
                </div>
            </div>
        </div>

        <!-- Marketplace Grid -->
        <div class="space-y-6 sm:space-y-8 mt-8 sm:mt-12">
            <div class="flex items-center justify-between border-b border-white/5 pb-6">
                <h2 class="text-xl font-black text-white italic tracking-tight uppercase">Strategy <span
                        class="gold-text">Marketplace</span></h2>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $traders->total() }} Nodes
                    Available</p>
            </div>

            @if($traders->count())
                <div class="grid gap-5 sm:gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($traders as $trader)
                        @include('user.copy.partials.trader-card', ['trader' => $trader, 'watchlistIds' => $sections['watchlist_ids']])
                    @endforeach
                </div>

                <div class="pt-10">
                    {{ $traders->links() }}
                </div>
            @else
                <div class="dashboard-glass border-white/5 p-20 text-center">
                    <i data-lucide="alert-triangle" class="w-16 h-16 text-slate-700 mx-auto mb-6"></i>
                    <h3 class="text-lg font-black text-white uppercase tracking-widest">No Matches Detected</h3>
                    <p class="text-slate-500 text-sm font-medium mt-2">Adjust your search parameters to discover other
                        high-performance managers.</p>
                </div>
            @endif
        </div>

        @include('user.copy.partials.copy-modal')
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endsection
