@extends('layouts.dasht')
@section('title', $title)

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-cloak>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('user.bots.index') }}" class="hover:text-yellow-500 transition-colors">Bot Trading</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">{{ $bot->name }}</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">{{ $bot->name }} <span class="gold-text">Intelligence</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">{{ $bot->description }}</p>
            </div>

            <div class="flex items-center gap-3">
                <span class="inline-flex items-center px-4 py-2 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-300 text-[10px] font-black uppercase tracking-[0.2em]">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 mr-2"></span>
                    Active Bot
                </span>
            </div>
        </div>

        <x-success-alert />
        <x-danger-alert />
        <x-error-alert />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-10">
            <div class="lg:col-span-8 space-y-6">
                <section class="dashboard-glass border-white/10 p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-yellow-500/10 blur-3xl"></div>
                    <div class="relative">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Success Rate</p>
                                <p class="text-2xl font-black text-white mt-2">{{ number_format($botStats['success_rate'], 1) }}%</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Trades</p>
                                <p class="text-2xl font-black text-white mt-2">{{ number_format($botStats['total_trades']) }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Profit</p>
                                <p class="text-2xl font-black text-emerald-400 mt-2">{{ Auth::user()->currency }}{{ number_format($botStats['total_profit'], 2) }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Expected Return</p>
                                <p class="text-2xl font-black gold-text mt-2">{{ number_format($botStats['expected_return'], 1) }}%</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="dashboard-glass border-white/10 p-6 sm:p-8 space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                            <i data-lucide="brain-circuit" class="w-5 h-5 gold-text"></i>
                        </div>
                        <div>
                            <h2 class="text-sm font-black uppercase tracking-widest text-white">Strategy Intelligence</h2>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Transparent strategy metadata</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Strategy Type</p>
                            <p class="text-sm font-semibold text-slate-200">{{ $bot->strategy ?? 'Advanced AI Trading' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Trading Frequency</p>
                            <p class="text-sm font-semibold text-slate-200">{{ $bot->trading_frequency ?? 'Multiple times daily' }}</p>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] p-5">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Strategy Description</p>
                        <p class="text-sm leading-relaxed text-slate-300">{{ $bot->strategy_description ?? 'Advanced machine learning algorithms analyze market behavior and execute probability-based entries and exits in real time.' }}</p>
                    </div>
                </section>

                <section class="dashboard-glass border-white/10 overflow-hidden">
                    <div class="px-6 sm:px-8 py-5 border-b border-white/10 bg-white/[0.02]">
                        <h2 class="text-sm font-black uppercase tracking-widest text-white">Recent Trade Activity</h2>
                    </div>

                    @if ($recentTrades && $recentTrades->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-black/30 text-[10px] font-black uppercase tracking-widest text-slate-500">
                                    <tr>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4">Type</th>
                                        <th class="px-6 py-4">Amount</th>
                                        <th class="px-6 py-4">Result</th>
                                        <th class="px-6 py-4">P/L</th>
                                        <th class="px-6 py-4">%</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach ($recentTrades as $trade)
                                        <tr class="hover:bg-white/[0.02] transition-colors">
                                            <td class="px-6 py-4 text-sm text-slate-300">{{ $trade->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-widest {{ $trade->trade_type == 'BUY' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-300 border border-rose-500/20' }}">
                                                    {{ $trade->trade_type }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-semibold text-white">{{ Auth::user()->currency }}{{ number_format($trade->amount, 2) }}</td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-[10px] font-black uppercase tracking-widest {{ $trade->result == 'profit' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-300 border border-rose-500/20' }}">
                                                    {{ ucfirst($trade->result) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-bold {{ $trade->profit_loss >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ $trade->profit_loss >= 0 ? '+' : '' }}{{ Auth::user()->currency }}{{ number_format($trade->profit_loss, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-sm font-bold {{ $trade->profit_loss >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                {{ number_format($trade->profit_percentage, 1) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="px-6 sm:px-8 py-14 text-center">
                            <div class="mx-auto h-14 w-14 rounded-2xl border border-white/10 bg-white/5 flex items-center justify-center mb-4">
                                <i data-lucide="activity" class="w-6 h-6 text-slate-500"></i>
                            </div>
                            <p class="text-sm font-semibold text-slate-300">No recent trades yet.</p>
                            <p class="text-xs uppercase tracking-widest font-bold text-slate-500 mt-2">Trade history appears after your first execution cycle.</p>
                        </div>
                    @endif
                </section>
            </div>

            <aside class="lg:col-span-4 space-y-6">
                <section class="dashboard-glass border-white/10 p-6 sm:p-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white mb-6">Investment Terminal</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Minimum</span>
                            <span class="font-semibold text-white">{{ Auth::user()->currency }}{{ number_format($bot->min_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Maximum</span>
                            <span class="font-semibold text-white">{{ Auth::user()->currency }}{{ number_format($bot->max_investment, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Expected ROI</span>
                            <span class="font-semibold text-emerald-400">{{ number_format($bot->expected_return, 1) }}%</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-500">Risk Level</span>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest
                                {{ $bot->risk_level == 'low' ? 'bg-emerald-500/10 text-emerald-300 border border-emerald-500/20' :
                                   ($bot->risk_level == 'medium' ? 'bg-amber-500/10 text-amber-300 border border-amber-500/20' :
                                    'bg-rose-500/10 text-rose-300 border border-rose-500/20') }}">
                                {{ ucfirst($bot->risk_level) }}
                            </span>
                        </div>
                    </div>

                    @if ($userInvestment)
                        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-5 mb-5">
                            <h4 class="text-xs font-black uppercase tracking-widest text-white mb-4">Your Active Position</h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500">Amount Invested</span>
                                    <span class="font-semibold text-white">{{ Auth::user()->currency }}{{ number_format($userInvestment->investment_amount, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500">Current Profit</span>
                                    <span class="font-semibold {{ $userInvestment->current_profit >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $userInvestment->current_profit >= 0 ? '+' : '' }}{{ Auth::user()->currency }}{{ number_format($userInvestment->current_profit, 2) }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-500">Current Value</span>
                                    <span class="font-semibold text-white">{{ Auth::user()->currency }}{{ number_format($userInvestment->current_balance, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <form id="cancelInvestmentForm" action="{{ route('user.bots.cancel', ['investment' => $userInvestment->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full h-12 rounded-xl border border-rose-500/30 bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 transition-all font-black text-[10px] uppercase tracking-[0.2em] flex items-center justify-center">
                                <i data-lucide="x-circle" class="w-4 h-4 mr-2"></i>
                                Cancel Investment
                            </button>
                        </form>
                    @else
                        <form action="{{ route('user.bots.invest', $bot) }}" method="POST" class="space-y-5"
                            x-data="{ amount: {{ $bot->min_investment }}, autoReinvest: false }" x-cloak>
                            @csrf

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Investment Amount</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs font-black">{{ Auth::user()->currency }}</span>
                                    <input type="number" name="amount" x-model="amount" min="{{ $bot->min_investment }}"
                                        max="{{ $bot->max_investment }}" step="0.01" required
                                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-white/10 bg-white/[0.03] text-white focus:outline-none focus:border-yellow-500/40 transition-all">
                                </div>
                                <div class="flex justify-between mt-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                    <span>Min {{ Auth::user()->currency }}{{ number_format($bot->min_investment, 2) }}</span>
                                    <span>Max {{ Auth::user()->currency }}{{ number_format($bot->max_investment, 2) }}</span>
                                </div>
                            </div>

                            <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-4">
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="auto_reinvest" x-model="autoReinvest"
                                        class="h-4 w-4 rounded border-white/20 bg-black text-yellow-500 focus:ring-yellow-500/40">
                                    <span class="text-sm font-semibold text-slate-200">Auto-reinvest profits</span>
                                </label>

                                <div x-show="autoReinvest" x-transition class="mt-4">
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Reinvestment Percentage</label>
                                    <input type="number" name="reinvest_percentage" min="0" max="100" value="50"
                                        class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/[0.03] text-white focus:outline-none focus:border-yellow-500/40 transition-all">
                                    <p class="text-[10px] text-slate-500 mt-2">Percentage of realized profits to automatically reinvest.</p>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full h-12 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.22em] hover:scale-[1.01] transition-all">
                                Start Investment
                            </button>
                        </form>
                    @endif
                </section>

                <section class="dashboard-glass border-white/10 p-6 sm:p-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-white mb-4 flex items-center">
                        <i data-lucide="shield-alert" class="w-4 h-4 mr-2 text-amber-400"></i>
                        Risk Disclosure
                    </h3>
                    <div class="space-y-3 text-sm text-slate-400">
                        <p>Automated trading can generate both profit and loss.</p>
                        <p>Historical returns are not guarantees of future performance.</p>
                        <p>Only deploy capital aligned with your risk tolerance.</p>
                        <p>Monitor active positions and adjust exposure as needed.</p>
                    </div>
                </section>
            </aside>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                lucide.createIcons();

                const cancelForm = document.getElementById('cancelInvestmentForm');
                if (!cancelForm) return;

                cancelForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Cancel This Investment?',
                        text: 'This will stop the active bot position and process your balance according to current value.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Cancel',
                        cancelButtonText: 'Keep Position',
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#475569',
                        background: '#090b10',
                        color: '#e2e8f0'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            cancelForm.submit();
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
