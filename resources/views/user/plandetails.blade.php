@extends('layouts.dasht')
@section('title', $title)
@section('content')

<div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="{ showCancelModal: false }">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <a href="{{ route('myplans', 'All') }}" class="hover:text-yellow-500 transition-colors">Portfolios</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-300">{{ $plan->uplan->name }} Manifest</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Portfolio <span
                    class="gold-text">Intelligence</span></h1>
        </div>

        <div class="flex items-center space-x-3">
            <a href="{{ route('myplans', 'All') }}"
                class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                Back to Portfolios
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="space-y-4">
        <x-danger-alert />
        <x-success-alert />
    </div>

    <!-- Main Performance Card -->
    <div class="dashboard-glass border-white/5 overflow-hidden group">
        <div class="p-10 border-b border-white/5 relative bg-gradient-to-br from-yellow-500/[0.02] to-transparent">
            <div
                class="absolute -right-20 -top-20 w-80 h-80 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all duration-1000">
            </div>

            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 relative">
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-16 w-16 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-all">
                            <div class="h-full w-full rounded-[14px] bg-white/[0.02] flex items-center justify-center">
                                <i data-lucide="briefcase" class="w-8 h-8 gold-text"></i>
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center space-x-3 mb-1">
                                <h2 class="text-3xl font-black text-white  tracking-tighter uppercase">
                                    {{ $plan->uplan->name }}
                                </h2>
                                @if ($plan->active == 'yes')
                                    <span
                                        class="px-3 py-1 rounded-md bg-emerald-500/10 border border-emerald-500/20 text-[8px] font-black text-emerald-400 uppercase tracking-widest animate-pulse">Operational</span>
                                @elseif($plan->active == 'expired')
                                    <span
                                        class="px-3 py-1 rounded-md bg-rose-500/10 border border-rose-500/20 text-[8px] font-black text-rose-400 uppercase tracking-widest">Decommissioned</span>
                                @else
                                    <span
                                        class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[8px] font-black text-slate-500 uppercase tracking-widest">Standby</span>
                                @endif
                            </div>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                                Protocol:
                                {{ $plan->uplan->increment_type == 'Fixed' ? Auth::user()->currency : '' }}{{ $plan->uplan->increment_amount }}{{ $plan->uplan->increment_type == 'Percentage' ? '%' : '' }}
                                {{ $plan->uplan->increment_interval }} Yield for {{ $plan->uplan->expiration }} cycle
                            </p>
                        </div>
                    </div>
                </div>

                @if ($settings->should_cancel_plan && $plan->active == 'yes')
                    <button @click="showCancelModal = true"
                        class="px-8 py-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 font-black text-[10px] uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all shadow-xl hover:shadow-rose-500/20">
                        Deactivate Protocol
                    </button>
                @endif
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-white/5 bg-black/20">
            <div class="p-10 text-center group hover:bg-white/[0.02] transition-colors">
                <span class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3">Capital
                    Commitment</span>
                <div class="text-3xl font-black text-white  tracking-tighter">
                    {{ Auth::user()->currency }}{{ number_format($plan->amount, 2) }}
                </div>
            </div>
            <div class="p-10 text-center group hover:bg-white/[0.02] transition-colors">
                <span class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3">Alpha Yield
                    Recaptured</span>
                <div class="text-3xl font-black text-emerald-400  tracking-tighter">
                    +{{ Auth::user()->currency }}{{ number_format($plan->profit_earned, 2) }}
                </div>
            </div>
            <div class="p-10 text-center group hover:bg-white/[0.02] transition-colors">
                <span class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-3">Net Realized
                    Equity</span>
                <div class="text-3xl font-black gold-text  tracking-tighter">
                    @if ($settings->return_capital)
                        {{ Auth::user()->currency }}{{ number_format($plan->amount + $plan->profit_earned, 2) }}
                    @else
                        {{ Auth::user()->currency }}{{ number_format($plan->profit_earned, 2) }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Temporal Vector Analysis -->
        <div class="dashboard-glass p-8 space-y-8 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none"></div>
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] flex items-center">
                <i data-lucide="clock" class="w-4 h-4 gold-text mr-3"></i>
                Temporal Vector Analysis
            </h3>

            <div class="space-y-6">
                <div
                    class="flex items-center justify-between p-5 rounded-2xl bg-white/[0.02] border border-white/5 group hover:border-yellow-500/20 transition-all">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-10 w-10 rounded-xl bg-black flex items-center justify-center border border-white/10">
                            <i data-lucide="hourglass" class="w-5 h-5 gold-text"></i>
                        </div>
                        <div>
                            <span
                                class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Maturity
                                Window</span>
                            <span
                                class="text-xs font-black text-white uppercase  tracking-tight">{{ $plan->uplan->expiration }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between p-5 rounded-2xl bg-white/[0.02] border border-white/5 group hover:border-emerald-500/20 transition-all">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-10 w-10 rounded-xl bg-black flex items-center justify-center border border-white/10">
                            <i data-lucide="zap" class="w-5 h-5 text-emerald-500"></i>
                        </div>
                        <div>
                            <span
                                class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Inception
                                Timestamp</span>
                            <span
                                class="text-xs font-black text-white uppercase  tracking-tight">{{ $plan->created_at->addHour()->toDayDateTimeString() }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between p-5 rounded-2xl bg-white/[0.02] border border-white/5 group hover:border-rose-500/20 transition-all">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-10 w-10 rounded-xl bg-black flex items-center justify-center border border-white/10">
                            <i data-lucide="shield-off" class="w-5 h-5 text-rose-500"></i>
                        </div>
                        <div>
                            <span
                                class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Expiration
                                Manifest</span>
                            <span
                                class="text-xs font-black text-white uppercase  tracking-tight">{{ \Carbon\Carbon::parse($plan->expire_date)->addHour()->toDayDateTimeString() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alpha Yield Matrix -->
        <div class="dashboard-glass p-8 space-y-8 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none"></div>
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] flex items-center">
                <i data-lucide="activity" class="w-4 h-4 gold-text mr-3"></i>
                Alpha Yield Matrix
            </h3>

            <div class="space-y-6">
                <div class="flex items-center justify-between p-5 rounded-2xl bg-white/[0.02] border border-white/5">
                    <div class="flex items-center space-x-4">
                        <div
                            class="h-10 w-10 rounded-xl bg-black flex items-center justify-center border border-white/10">
                            <i data-lucide="refresh-cw" class="w-5 h-5 gold-text"></i>
                        </div>
                        <div>
                            <span
                                class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Oscillation
                                Interval</span>
                            <span
                                class="text-xs font-black text-white uppercase  tracking-tight">{{ $plan->uplan->increment_interval }}</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="p-6 rounded-2xl bg-black/40 border border-white/5 text-center">
                        <span
                            class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-2 text-center">Lower
                            Alpha Floor</span>
                        <span
                            class="text-2xl font-black text-emerald-400  tracking-tighter">{{ $plan->uplan->minr }}%</span>
                    </div>
                    <div class="p-6 rounded-2xl bg-black/40 border border-white/5 text-center">
                        <span
                            class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-2 text-center">Upper
                            Alpha Ceiling</span>
                        <span
                            class="text-2xl font-black gold-text  tracking-tighter">{{ $plan->uplan->maxr }}%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Yield Event Manifest -->
    <div class="dashboard-glass overflow-hidden">
        <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] flex items-center">
                <i data-lucide="list" class="w-4 h-4 gold-text mr-3"></i>
                Yield Event Manifest
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="text-[9px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5 bg-black/20">
                        <th class="px-8 py-5">Event Identifier</th>
                        <th class="px-8 py-5">Timestamp</th>
                        <th class="px-8 py-5 text-right">Yield Delta</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($transactions as $history)
                        <tr class="group hover:bg-white/[0.02] transition-colors">
                            <td class="px-8 py-5 flex items-center space-x-3">
                                <div class="h-6 w-6 rounded-md bg-emerald-500/10 flex items-center justify-center">
                                    <i data-lucide="trending-up" class="w-3 h-3 text-emerald-500"></i>
                                </div>
                                <span class="text-[10px] font-black text-white uppercase tracking-tight">Yield
                                    Reinjection #{{ $history->id }}</span>
                            </td>
                            <td class="px-8 py-5 text-xs font-black text-slate-400 uppercase  tracking-tighter">
                                {{ $history->created_at->addHour()->format('M d, Y / H:i:s') }}
                            </td>
                            <td class="px-8 py-5 text-right font-mono text-sm font-black  text-emerald-400">
                                +{{ Auth::user()->currency }}{{ number_format($history->amount, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-8 py-20 text-center opacity-30">
                                <i data-lucide="inbox" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No Yield Events
                                    Logged in Current Cycle</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($transactions->hasPages())
            <div
                class="p-8 border-t border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-black/40">
                <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest">
                    Captured Relays <span class="text-white">{{ $transactions->firstItem() ?? 0 }}</span> - <span
                        class="text-white">{{ $transactions->lastItem() ?? 0 }}</span> Over <span
                        class="text-white">{{ $transactions->total() }}</span> Events
                </div>
                <div class="flex items-center space-x-2">
                    {{ $transactions->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Deactivation Modal -->
    <div x-show="showCancelModal" x-cloak
        class="fixed inset-0 z-[1200] flex items-center justify-center bg-black/80 p-6 backdrop-blur-md">
        <div @click.away="showCancelModal = false" x-show="showCancelModal"
            x-transition:enter="transition-all ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-10"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="relative w-full max-w-lg bg-[#0a0a0a] border border-white/10 rounded-[32px] overflow-hidden shadow-2xl p-10 text-center">

            <div class="absolute -right-20 -top-20 w-64 h-64 bg-rose-500/5 blur-[100px] pointer-events-none"></div>

            <div
                class="h-20 w-20 rounded-[24px] bg-rose-500/10 border border-rose-500/20 flex items-center justify-center mx-auto mb-8">
                <i data-lucide="alert-triangle"
                    class="w-10 h-10 text-rose-500 shadow-[0_0_20px_rgba(244,63,94,0.3)]"></i>
            </div>

            <h3 class="text-2xl font-black text-white  uppercase tracking-tight mb-4">Protocol Termination</h3>
            <p class="text-[11px] text-slate-500 font-bold uppercase tracking-widest leading-relaxed mb-10">
                You are about to initiate the deactivation protocol for <span
                    class="text-white font-black  underline gold-text decoration-yellow-500/30">{{ $plan->uplan->name }}</span>.
                This action is irreversible within the current cycle.
            </p>

            <div class="grid grid-cols-2 gap-4">
                <button @click="showCancelModal = false"
                    class="py-4 rounded-xl bg-white/5 border border-white/10 text-white font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">Abort</button>
                <a href="{{ route('cancelplan', $plan->id) }}"
                    class="py-4 rounded-xl bg-rose-500 text-white font-black text-[10px] uppercase tracking-widest shadow-xl shadow-rose-500/20 hover:bg-rose-600 transition-all text-center">Confirm
                    Termination</a>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    </script>
@endsection