@extends('layouts.dasht')
@section('title', 'Transaction History')
@section('content')

    <div class="space-y-10 animate-fadeIn" x-data="{ activeTab: 'deposits' }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Financial History</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Transaction <span class="gold-text">History</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">A complete record of all your deposits, withdrawals, and other transactions.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Download History</span>
                </div>
            </div>
        </div>

        <!-- Tab Selection -->
        <div class="flex items-center p-1.5 bg-white/5 border border-white/10 rounded-2xl w-full sm:w-fit">
            <button @click="activeTab = 'deposits'"
                :class="activeTab === 'deposits' ? 'bg-yellow-500 text-black shadow-lg shadow-yellow-500/10' : 'text-slate-400 hover:text-white'"
                class="flex-1 sm:flex-none px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Deposits
            </button>
            <button @click="activeTab = 'withdrawals'"
                :class="activeTab === 'withdrawals' ? 'bg-yellow-500 text-black shadow-lg shadow-yellow-500/10' : 'text-slate-400 hover:text-white'"
                class="flex-1 sm:flex-none px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Withdrawals
            </button>
            <button @click="activeTab = 'others'"
                :class="activeTab === 'others' ? 'bg-yellow-500 text-black shadow-lg shadow-yellow-500/10' : 'text-slate-400 hover:text-white'"
                class="flex-1 sm:flex-none px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                Other
            </button>
        </div>

        <!-- Ledger Content -->
        <div class="dashboard-glass border-white/5 overflow-hidden">

            <!-- Deposits Ledger -->
            <div x-show="activeTab === 'deposits'" x-transition.opacity>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                            <tr>
                                <th class="px-8 py-5">Transaction ID</th>
                                <th class="px-6 py-5">Amount</th>
                                <th class="px-6 py-5 text-center">Method</th>
                                <th class="px-6 py-5 text-center">Date & Time</th>
                                <th class="px-8 py-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse ($deposits as $deposit)
                                <tr class="text-xs font-bold group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-5 text-white">#DEP-{{ str_pad($deposit->id, 6, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-6 py-5 text-emerald-400 font-mono">
                                        +{{ Auth::user()->currency }}{{ number_format($deposit->amount, 2) }}</td>
                                    <td class="px-6 py-5 text-center">
                                        <span
                                            class="px-2 py-1 rounded-md bg-white/5 text-slate-500 text-[9px] uppercase tracking-tighter border border-white/5">{{ $deposit->payment_mode }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-center text-slate-500 font-mono text-[10px] uppercase">
                                        {{ \Carbon\Carbon::parse($deposit->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        @if($deposit->status == 'Processed')
                                            <span
                                                class="text-emerald-400 text-[9px] font-black uppercase tracking-widest">Completed</span>
                                        @else
                                            <span class="text-yellow-500 text-[9px] font-black uppercase tracking-widest">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="text-slate-600 text-[10px] uppercase font-black">No deposits found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Withdrawals Ledger -->
            <div x-show="activeTab === 'withdrawals'" x-transition.opacity>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                            <tr>
                                <th class="px-8 py-5">Transaction ID</th>
                                <th class="px-6 py-5">Amount</th>
                                <th class="px-6 py-5 text-center">Fee</th>
                                <th class="px-6 py-5 text-center">Date & Time</th>
                                <th class="px-8 py-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse ($withdrawals as $withdrawal)
                                <tr class="text-xs font-bold group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-5 text-white">#WIT-{{ str_pad($withdrawal->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-5 text-rose-400 font-mono">
                                        -{{ Auth::user()->currency }}{{ number_format($withdrawal->amount, 2) }}</td>
                                    <td class="px-6 py-5 text-center text-slate-500 font-mono">
                                        {{ Auth::user()->currency }}{{ number_format($withdrawal->to_deduct - $withdrawal->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-center text-slate-500 font-mono text-[10px] uppercase">
                                        {{ \Carbon\Carbon::parse($withdrawal->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        @if($withdrawal->status == 'Processed')
                                            <span
                                                class="text-emerald-400 text-[9px] font-black uppercase tracking-widest">Completed</span>
                                        @elseif($withdrawal->status == 'Rejected')
                                            <span
                                                class="text-rose-400 text-[9px] font-black uppercase tracking-widest">Rejected</span>
                                        @else
                                            <span
                                                class="text-yellow-500 text-[9px] font-black uppercase tracking-widest">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="text-slate-600 text-[10px] uppercase font-black">No withdrawals found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Others Ledger -->
            <div x-show="activeTab === 'others'" x-transition.opacity>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                            <tr>
                                <th class="px-8 py-5">Type</th>
                                <th class="px-6 py-5">Amount</th>
                                <th class="px-6 py-5 text-center">Reference</th>
                                <th class="px-6 py-5 text-center">Date & Time</th>
                                <th class="px-8 py-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse ($t_history as $history)
                                <tr class="text-xs font-bold group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-5 text-white flex items-center">
                                        <div class="w-2 h-2 rounded-full mr-3 bg-blue-500"></div>
                                        {{ $history->type }}
                                    </td>
                                    <td
                                        class="px-6 py-5 font-mono {{ str_contains(strtolower($history->type), 'profit') ? 'text-emerald-400' : 'text-slate-400' }}">
                                        {{ Auth::user()->currency }}{{ number_format($history->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <span
                                            class="text-slate-500 text-[10px] font-bold uppercase tracking-tighter">{{ $history->plan ?? 'INTERNAL' }}</span>
                                    </td>
                                    <td class="px-6 py-5 text-center text-slate-500 font-mono text-[10px] uppercase">
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <span
                                            class="text-emerald-400 text-[9px] font-black uppercase tracking-widest">Completed</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-20 text-center">
                                        <div class="text-slate-600 text-[10px] uppercase font-black">No other transactions found.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
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