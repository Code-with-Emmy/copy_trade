@extends('layouts.dasht')
@section('title', 'Execution Log')
@section('content')

    <div class="page-content-stack animate-fadeIn" x-data="{ activeFilter: 'all' }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Market Execution Log</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Strategy <span
                        class="gold-text">Performance</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Detailed audit trail of algorithmic market operations.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="activity" class="w-4 h-4 mr-2 text-emerald-500 animate-pulse"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Real-time Stream Active</span>
                </div>
            </div>
        </div>

        <!-- Performance Pulse -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
            <div class="dashboard-glass p-5 sm:p-6 border-white/5 group">
                <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Total Cycles</div>
                <div class="text-3xl font-black text-white italic tracking-tighter">{{ $t_history->total() }}</div>
            </div>
            <div class="dashboard-glass p-5 sm:p-6 border-white/5 group">
                <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Win Delta</div>
                <div class="text-3xl font-black text-emerald-400 italic tracking-tighter">
                    {{ $t_history->where('type', 'WIN')->count() }}</div>
            </div>
            <div class="dashboard-glass p-5 sm:p-6 border-white/5 group">
                <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Loss Delta</div>
                <div class="text-3xl font-black text-rose-500 italic tracking-tighter">
                    {{ $t_history->where('type', 'LOSE')->count() }}</div>
            </div>
            <div class="dashboard-glass p-5 sm:p-6 border-white/5 group">
                <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Win Rate</div>
                <div class="text-3xl font-black gold-text italic tracking-tighter">
                    {{ $t_history->total() > 0 ? number_format(($t_history->where('type', 'WIN')->count() / $t_history->total()) * 100, 1) : 0 }}%
                </div>
            </div>
        </div>

        <!-- Execution Filters -->
        <div class="flex flex-wrap items-center gap-3">
            <button @click="activeFilter = 'all'"
                :class="activeFilter === 'all' ? 'bg-white text-black shadow-white/10' : 'bg-white/5 text-slate-400 hover:text-white'"
                class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl">
                All Cycles
            </button>
            <button @click="activeFilter = 'WIN'"
                :class="activeFilter === 'WIN' ? 'bg-emerald-500 text-black shadow-emerald-500/10' : 'bg-emerald-500/5 text-emerald-500 hover:bg-emerald-500/10'"
                class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl">
                Successful
            </button>
            <button @click="activeFilter = 'LOSE'"
                :class="activeFilter === 'LOSE' ? 'bg-rose-500 text-black shadow-rose-500/10' : 'bg-rose-500/5 text-rose-500 hover:bg-rose-500/10'"
                class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl">
                Retracted
            </button>
            <button @click="activeFilter = 'Buy'"
                :class="activeFilter === 'Buy' ? 'bg-blue-500 text-black shadow-blue-500/10' : 'bg-blue-500/5 text-blue-500 hover:bg-blue-500/10'"
                class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl">
                Active Long
            </button>
            <button @click="activeFilter = 'Sell'"
                :class="activeFilter === 'Sell' ? 'bg-orange-500 text-black shadow-orange-500/10' : 'bg-orange-500/5 text-orange-500 hover:bg-orange-500/10'"
                class="px-6 py-2.5 rounded-full text-[10px] font-black uppercase tracking-widest transition-all shadow-xl">
                Active Short
            </button>
        </div>

        <!-- Execution Feed -->
        <div class="space-y-3 sm:space-y-4">
            @forelse ($t_history as $history)
                <div x-show="activeFilter === 'all' || activeFilter === '{{ $history->type }}'" x-transition.opacity
                    class="dashboard-glass border-white/5 hover:border-white/10 p-4 sm:p-5 group transition-all relative overflow-hidden">

                    @if($history->type == 'WIN')
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500"></div>
                    @elseif($history->type == 'LOSE')
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500"></div>
                    @else
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-blue-500"></div>
                    @endif

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-5 sm:gap-6">
                        <div class="flex items-center space-x-4 sm:space-x-6">
                            <div
                                class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0">
                                @if($history->type == 'WIN')
                                    <i data-lucide="trending-up" class="w-6 h-6 text-emerald-400"></i>
                                @elseif($history->type == 'LOSE')
                                    <i data-lucide="trending-down" class="w-6 h-6 text-rose-400"></i>
                                @else
                                    <i data-lucide="zap" class="w-6 h-6 gold-text"></i>
                                @endif
                            </div>

                            <div>
                                <div class="flex items-center space-x-3 mb-1">
                                    <h3 class="text-sm font-black text-white uppercase tracking-wider">{{ $history->plan }}</h3>
                                    <span
                                        class="text-[9px] font-black px-2 py-0.5 rounded-full bg-white/5 text-slate-400 border border-white/10 uppercase tracking-tighter">
                                        {{ $history->type }}
                                    </span>
                                </div>
                                <div
                                    class="flex items-center space-x-4 text-[10px] font-bold text-slate-500 uppercase tracking-tighter">
                                    <span>{{ $history->created_at->format('d M, Y \a\t H:i') }}</span>
                                    <span class="h-1 w-1 rounded-full bg-slate-700"></span>
                                    <span>Ref: #EXEC-{{ $history->id }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-6 sm:space-x-10">
                            @if($history->leverage)
                                <div class="text-center">
                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-1">Leverage</div>
                                    <div class="text-xs font-black text-white font-mono">1:{{ $history->leverage }}</div>
                                </div>
                            @endif

                            <div class="text-right min-w-[120px]">
                                <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-1">Outcome</div>
                                <div
                                    class="text-lg font-black font-mono {{ $history->type == 'WIN' ? 'text-emerald-400' : ($history->type == 'LOSE' ? 'text-rose-400' : 'text-white') }}">
                                    {{ $history->type == 'WIN' ? '+' : ($history->type == 'LOSE' ? '-' : '') }}{{ Auth::user()->currency }}{{ number_format($history->amount, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-glass border-white/5 p-20 text-center">
                    <i data-lucide="terminal" class="w-12 h-12 text-slate-700 mx-auto mb-6"></i>
                    <h3 class="text-sm font-black text-slate-500 uppercase tracking-widest">No Execution Data Found</h3>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($t_history->hasPages())
            <div class="pt-10">
                {{ $t_history->links('vendor.pagination.tailwind-custom') }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endpush
