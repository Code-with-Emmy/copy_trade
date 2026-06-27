@extends('layouts.dasht')
@section('title', 'Trader Profile - ' . $profile['trader']->name)
@section('content')
    @php
        $trader = $profile['trader'];
        $metric = $profile['metric'];
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="{ openCopy: false }">
        <!-- Header & Profile Card -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('copy.experts') }}" class="hover:text-yellow-500 transition-colors">Marketplace</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Terminal Node-{{ substr(md5($trader->id), 0, 8) }}</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Signal <span class="gold-text">Intelligence</span>
                </h1>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('copy.experts') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Marketplace
                </a>
            </div>
        </div>

        <!-- Main Profile Board -->
        <div class="dashboard-glass border-white/5 overflow-hidden group">
            <div class="p-10 border-b border-white/5 relative">
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all duration-1000">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-[auto_1fr_350px] gap-12 relative">
                    <!-- Avatar -->
                    <div class="relative mx-auto lg:mx-0">
                        <div
                            class="h-32 w-32 rounded-[32px] bg-black border border-white/10 p-1 group-hover:border-yellow-500/30 transition-all">
                            @if($trader->photo)
                                <img src="{{ asset('storage/' . $trader->photo) }}"
                                    class="h-full w-full rounded-[28px] object-cover">
                            @else
                                <div class="h-full w-full flex items-center justify-center">
                                    <span
                                        class="text-4xl font-black gold-text  tracking-tighter">{{ strtoupper(substr($trader->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        @if($trader->verification_status === 'verified')
                            <div
                                class="absolute -bottom-2 -right-2 h-10 w-10 bg-emerald-500 rounded-xl flex items-center justify-center border-8 border-[#0a0a0a] shadow-2xl">
                                <i data-lucide="check" class="w-4 h-4 text-black"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Identity -->
                    <div class="space-y-6 text-center lg:text-left">
                        <div>
                            <div class="flex flex-wrap justify-center lg:justify-start gap-3 mb-4">
                                <span
                                    class="px-3 py-1 rounded-md bg-yellow-500/10 border border-yellow-500/20 text-[9px] font-black gold-text uppercase tracking-widest">{{ $trader->strategy_type ?: 'Proprietary Protocol' }}</span>
                                <span
                                    class="px-3 py-1 rounded-md bg-white/5 border border-white/10 text-[9px] font-black text-slate-300 uppercase tracking-widest">{{ ucfirst($profile['risk_label']) }}
                                    Risk Tier</span>
                            </div>
                            <h2 class="text-4xl font-black text-white  tracking-tighter uppercase">{{ $trader->name }}
                            </h2>
                        </div>
                        <p class="text-sm text-slate-400 font-medium leading-loose max-w-2xl">
                            "{{ $trader->bio ?: $trader->description }}"</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                            <div class="flex items-center text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                <i data-lucide="zap" class="w-3 h-3 mr-2 gold-text"></i>
                                {{ $trader->trading_style ?: 'High-Frequency' }}
                            </div>
                            <div class="flex items-center text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                <i data-lucide="globe" class="w-3 h-3 mr-2 gold-text"></i>
                                {{ $trader->markets_traded ?: 'Global Markets' }}
                            </div>
                        </div>
                    </div>

                    <!-- Controls -->
                    <div class="dashboard-glass bg-black/40 border-white/5 p-8 space-y-8">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <span
                                    class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Entry
                                    Barrier</span>
                                <span
                                    class="text-xl font-black text-white  tracking-tighter">{{ auth()->user()->currency }}{{ number_format(max((float) $trader->price, (float) ($trader->minimum_allocation ?: 0)), 2) }}</span>
                            </div>
                            <div>
                                <span
                                    class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Protocol
                                    Fee</span>
                                <span
                                    class="text-xl font-black gold-text  tracking-tighter">{{ number_format((float) $trader->performance_fee_percent, 2) }}%</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <button @click="openCopy = true"
                                class="w-full py-4 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/20 hover:scale-105 transition-all">Initialize
                                Sync</button>
                            <form method="POST" action="{{ route('copy.watchlist.toggle', $trader->id) }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-4 rounded-xl bg-white/5 border border-white/10 text-[9px] font-black text-slate-300 uppercase tracking-widest hover:bg-white/10 transition-all">
                                    {{ $profile['watchlisted'] ? 'Remove from Watchlist' : 'Add to Watchlist' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metric Grid -->
            <div class="grid grid-cols-2 md:grid-cols-5 divide-x divide-white/5 bg-black/20">
                <div class="p-8 text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 group-hover:text-slate-400 transition-colors">Nodes
                        Active</span>
                    <div class="text-2xl font-black text-white  tracking-tighter">
                        {{ number_format($profile['performance']['followers']) }}</div>
                </div>
                <div class="p-8 text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 group-hover:text-slate-400 transition-colors">30D
                        Matrix</span>
                    <div class="text-2xl font-black text-emerald-400  tracking-tighter">
                        +{{ number_format($profile['performance']['monthly_roi'], 2) }}%</div>
                </div>
                <div class="p-8 text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 group-hover:text-slate-400 transition-colors">Annualized</span>
                    <div class="text-2xl font-black gold-text  tracking-tighter">
                        {{ number_format($profile['performance']['yearly_roi'], 2) }}%</div>
                </div>
                <div class="p-8 text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 group-hover:text-slate-400 transition-colors">Equity
                        AUM</span>
                    <div class="text-2xl font-black text-white  tracking-tighter">
                        ${{ number_format($profile['performance']['aum'], 0) }}</div>
                </div>
                <div class="p-8 text-center group">
                    <span
                        class="block text-[10px] font-black text-slate-600 uppercase tracking-widest mb-2 group-hover:text-slate-400 transition-colors">Consistency</span>
                    <div class="text-2xl font-black text-white  tracking-tighter">
                        {{ number_format($profile['performance']['win_rate'], 1) }}%</div>
                </div>
            </div>
        </div>

        <!-- Analytics Board -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 dashboard-glass p-8 space-y-8">
                <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Alpha Performance Matrix</h3>
                <div class="h-[400px] w-full bg-black/40 rounded-3xl p-6 border border-white/5">
                    <canvas id="returnsChart"></canvas>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-white/5">
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Resource Allocation
                            Vectors</h4>
                        <div class="space-y-4">
                            @foreach($profile['scores'] as $label => $score)
                                <div>
                                    <div class="flex justify-between items-end mb-2">
                                        <span
                                            class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ ucwords(str_replace('_', ' ', $label)) }}</span>
                                        <span class="text-xs font-black gold-text">{{ $score }}%</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                        <div class="h-full gold-gradient-bg shadow-[0_0_10px_rgba(240,185,10,0.3)]"
                                            style="width: {{ $score }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="space-y-6">
                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Equity Divergence Map
                        </h4>
                        <div class="h-40 w-full bg-black/40 rounded-2xl p-4 border border-white/5">
                            <canvas id="equityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass p-8 space-y-8">
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Risk Exposure Report</h3>
                    <div class="h-40 w-full bg-black/40 rounded-2xl p-4 border border-white/5">
                        <canvas id="drawdownChart"></canvas>
                    </div>
                    <div class="space-y-4 pt-4">
                        <div
                            class="p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10 text-[10px] text-slate-500 font-medium leading-loose">
                            Strategic profile calibrated for <span
                                class="text-white font-black uppercase">{{ $metric->recommended_investor_profile }}</span>.
                            Node demonstrates an average execution maturity of
                            {{ $profile['performance']['avg_trade_duration_hours'] }} hours per cycle.
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-8 space-y-8">
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Recent Signal Manifest</h3>
                    <div class="space-y-4">
                        @forelse($profile['recent_trades'] as $trade)
                            <div
                                class="flex items-center justify-between p-4 rounded-xl bg-white/[0.02] border border-white/5 group hover:border-yellow-500/20 transition-all">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="h-8 w-8 rounded-lg bg-black flex items-center justify-center border border-white/10 text-[9px] font-black  gold-text">
                                        {{ $trade->symbol }}</div>
                                    <div>
                                        <div class="text-[10px] font-black text-white uppercase">{{ $trade->direction }} Vector
                                        </div>
                                        <div class="text-[9px] text-slate-600 font-bold uppercase">
                                            {{ optional($trade->opened_at)->diffForHumans() ?: 'REALTIME' }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div
                                        class="text-xs font-black  {{ $trade->profit_loss >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ auth()->user()->currency }}{{ number_format((float) $trade->profit_loss, 2) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12 opacity-20">
                                <i data-lucide="activity" class="w-12 h-12 text-slate-700 mx-auto mb-4"></i>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">No Active Signals
                                    Detected</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Historical Performance Matrix -->
        <div class="dashboard-glass overflow-hidden">
            <div class="p-8 border-b border-white/5">
                <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Performance Maturity Matrix</h3>
                <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-1">12-Month Performance Cycle
                    Data</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="text-[9px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5 bg-white/[0.02]">
                            <th class="px-8 py-5">Temporal Period</th>
                            <th class="px-8 py-5">Alpha Yield %</th>
                            <th class="px-8 py-5">Max Divergence</th>
                            <th class="px-8 py-5 text-right">Successful Signals</th>
                            <th class="px-8 py-5 text-right">Failed Signals</th>
                            <th class="px-8 py-5 text-right">Total Executions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($profile['monthly_table'] as $row)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-5 text-xs font-black text-white">{{ $row['period'] }}</td>
                                <td
                                    class="px-8 py-5 text-xs font-black  {{ $row['return_percentage'] >= 0 ? 'text-emerald-400' : 'text-rose-400' }} font-mono">
                                    {{ $row['return_percentage'] >= 0 ? '+' : '' }}{{ number_format($row['return_percentage'], 2) }}%
                                </td>
                                <td class="px-8 py-5 text-xs font-black text-rose-400 font-mono">
                                    {{ number_format($row['drawdown_percentage'], 2) }}%</td>
                                <td class="px-8 py-5 text-xs font-black text-emerald-400 font-mono text-right">
                                    {{ $row['wins'] }}</td>
                                <td class="px-8 py-5 text-xs font-black text-rose-400 font-mono text-right">{{ $row['losses'] }}
                                </td>
                                <td class="px-8 py-5 text-xs font-black text-white font-mono text-right">
                                    {{ $row['trades_count'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @include('user.copy.partials.copy-modal')
    </div>
@endsection

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const labels = @json($profile['charts']['labels']);
            const returns = @json($profile['charts']['returns']);
            const equity = @json($profile['charts']['equity_curve']);
            const drawdown = @json($profile['charts']['drawdown']);

            const textColor = '#94a3b8';
            const gridColor = 'rgba(255, 255, 255, 0.05)';
            const accentGold = '#f0b90a';
            const accentEmerald = '#10b981';
            const accentRose = '#fb7185';

            // Alpha Yield Chart
            new Chart(document.getElementById('returnsChart'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Signal Yield %',
                        data: returns,
                        borderColor: accentGold,
                        backgroundColor: 'rgba(240, 185, 10, 0.05)',
                        borderWidth: 4,
                        tension: 0.45,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { ticks: { color: textColor, font: { weight: 'bold', size: 10 } }, grid: { display: false } },
                        y: { ticks: { color: textColor, font: { weight: 'bold', size: 10 } }, grid: { color: gridColor } }
                    }
                }
            });

            // Equity Map
            new Chart(document.getElementById('equityChart'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        data: equity,
                        borderColor: accentEmerald,
                        borderWidth: 2,
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });

            // Drawdown Profile
            new Chart(document.getElementById('drawdownChart'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        data: drawdown,
                        backgroundColor: accentRose,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { x: { display: false }, y: { display: false } }
                }
            });

            lucide.createIcons();
        });
    </script>
@endsection