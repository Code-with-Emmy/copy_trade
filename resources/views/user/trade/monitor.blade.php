@extends('layouts.dasht')
@section('title', $title)
@section('content')

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="tradeMonitor()" x-cloak>
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('trade.index') }}" class="hover:text-yellow-500 transition-colors">Markets</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Signal Audit Monitor</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Signal <span class="gold-text">Audit</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Real-time telemetry and node synchronization monitoring.</p>
            </div>

            <div class="flex items-center space-x-3">
                @if ($instrument)
                    <a href="{{ route('trade.single', $instrument->id) }}"
                        class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white transition-all">
                        <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                        <span class="text-[10px] font-black uppercase tracking-widest">Back to Terminal</span>
                    </a>
                @endif
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <!-- Intelligence Hub Header -->
        <div class="dashboard-glass p-8 border-white/5 group relative overflow-hidden">
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 relative">
                <div class="flex items-center space-x-6">
                    <div
                        class="h-20 w-20 rounded-3xl bg-black border border-white/10 p-3 flex items-center justify-center shadow-2xl group-hover:border-yellow-500/30 transition-all">
                        @if ($instrument && $instrument->logo)
                            <img src="{{ $instrument->logo }}" alt="{{ $trade->assets }}" class="w-full h-full object-contain">
                        @else
                            <span class="text-2xl font-black gold-text">{{ substr($trade->assets, 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-3xl font-black text-white tracking-tight uppercase">{{ $trade->type }}
                            {{ $trade->assets }}</h2>
                        <div class="flex items-center space-x-3 mt-1">
                            <span
                                class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">ID:
                                {{ substr($trade->id, 0, 12) }}</span>
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Active Link</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-row lg:flex-col items-end gap-6 lg:gap-1">
                    @php
                        $isSuccess = ($trade->profit_earned ?? 0) >= 0;
                    @endphp
                    @if ($trade->active === 'yes')
                        <div
                            class="px-4 py-1.5 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-[10px] font-black gold-text uppercase tracking-widest  animate-pulse">
                            Node Running
                        </div>
                    @else
                        <div
                            class="px-4 py-1.5 rounded-full {{ $isSuccess ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-rose-500/10 border-rose-500/20 text-rose-400' }} text-[10px] font-black uppercase tracking-widest">
                            {{ $isSuccess ? 'Signal Success' : 'Signal Terminated' }}
                        </div>
                    @endif

                    <div class="text-3xl font-black text-white  tracking-tighter">
                        {{ Auth::user()->currency }}{{ number_format($trade->amount, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            <!-- Telemetry Analysis -->
            <div class="xl:col-span-8 space-y-8">
                <!-- Live Synchronization Status -->
                @if ($trade->active === 'yes' && $trade->expire_date)
                    <div class="dashboard-glass p-8 border-white/5 relative overflow-hidden group">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="zap" class="w-5 h-5 gold-text animate-pulse"></i>
                                <span class="text-xs font-black text-white uppercase tracking-widest">Live Synchronicity
                                    Telemetry</span>
                            </div>
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">
                                Time to Termination: <span class="gold-text ml-2" x-text="timeLeft"></span>
                            </div>
                        </div>

                        @php
                            $start = \Carbon\Carbon::parse($trade->activated_at ?? $trade->created_at);
                            $end = \Carbon\Carbon::parse($trade->expire_date);
                            $now = \Carbon\Carbon::now();
                            $total = $start->diffInMinutes($end);
                            $elapsed = $start->diffInMinutes($now);
                            $progress = $total > 0 ? min(($elapsed / $total) * 100, 100) : 0;
                        @endphp

                        <div class="space-y-6">
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span
                                            class="text-[10px] font-black uppercase tracking-widest py-1 px-2 rounded-lg bg-white/5 border border-white/10 gold-text">
                                            Deployment Pattern: {{ number_format($progress, 1) }}%
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                            Established {{ $start->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2.5 mb-4 text-xs flex rounded-full bg-white/5 border border-white/5 relative">
                                    <div style="width:{{ $progress }}%"
                                        class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center gold-gradient-bg animate-progress-reveal rounded-full relative overflow-hidden">
                                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-8">
                                <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group-hover:border-yellow-500/10 transition-all">
                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2">Duration</div>
                                    <div class="text-sm font-black text-white">{{ $trade->inv_duration ?? 'N/A' }}</div>
                                </div>
                                <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group-hover:border-yellow-500/10 transition-all">
                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2">Unrealized P/L</div>
                                    @php
                                        $pnl = $trade->profit_earned ?? 0;
                                        $isProfit = $pnl >= 0;
                                    @endphp
                                    <div class="text-sm font-black {{ $isProfit ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $isProfit ? '+' : '' }}{{ Auth::user()->currency }}{{ number_format(abs($pnl), 2) }}
                                    </div>
                                </div>
                                <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group-hover:border-yellow-500/10 transition-all">
                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2">ROE Map</div>
                                    @php
                                        $roe = $trade->amount > 0 ? ($pnl / $trade->amount) * 100 : 0;
                                    @endphp
                                    <div class="text-sm font-black {{ $roe >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $roe >= 0 ? '+' : '' }}{{ number_format($roe, 2) }}%
                                    </div>
                                </div>
                                <div class="bg-black/30 p-5 rounded-2xl border border-white/5 text-center group-hover:border-yellow-500/10 transition-all">
                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mb-2">Leverage Vector</div>
                                    <div class="text-sm font-black text-white">1:{{ $trade->leverage ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Operational Metrics Ledger -->
                <div class="dashboard-glass p-8 border-white/5">
                    <div class="flex items-center space-x-3 mb-8">
                        <i data-lucide="clipboard-list" class="w-5 h-5 gold-text"></i>
                        <span class="text-xs font-black text-white uppercase tracking-widest">Execution Configuration Ledger</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                        @foreach([
                            ['label' => 'Asset Identifier', 'value' => $trade->assets, 'icon' => 'tag'],
                            ['label' => 'Execution Protocol', 'value' => $trade->type . ' Position', 'icon' => 'mouse-pointer-2', 'color' => $trade->type === 'Buy' ? 'text-emerald-400' : 'text-rose-400'],
                            ['label' => 'Deployed Capital', 'value' => Auth::user()->currency . number_format($trade->amount, 2), 'icon' => 'database'],
                            ['label' => 'Leverage Multiplier', 'value' => '1:' . ($trade->leverage ?? 'N/A'), 'icon' => 'layers'],
                            ['label' => 'Established Date', 'value' => \Carbon\Carbon::parse($trade->created_at)->format('M d, Y H:i'), 'icon' => 'calendar'],
                            ['label' => 'TTL Barrier', 'value' => $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('M d, Y H:i') : 'N/A', 'icon' => 'clock']
                        ] as $item)
                        <div class="flex items-center justify-between py-4 border-b border-white/5 hover:bg-white/[0.01] transition-all px-2 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="{{ $item['icon'] }}" class="w-4 h-4 text-slate-600"></i>
                                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-xs font-black {{ $item['color'] ?? 'text-white' }}  tracking-tight">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                        
                        @if($trade->active === 'expired')
                            <div class="flex items-center justify-between py-4 border-b border-rose-500/20 bg-rose-500/5 px-4 rounded-xl md:col-span-2">
                                <div class="flex items-center space-x-3">
                                    <i data-lucide="terminal" class="w-4 h-4 text-rose-400"></i>
                                    <span class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Final Audit Yield</span>
                                </div>
                                <span class="text-sm font-black {{ $isSuccess ? 'text-emerald-400' : 'text-rose-400' }}  tracking-tighter">
                                    {{ $isSuccess ? '+' : '' }}{{ Auth::user()->currency }}{{ number_format(abs($trade->profit_earned ?? 0), 2) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Signal Artifacts Table -->
                @if($relatedTrades->count() > 0)
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <div class="p-6 border-b border-white/5 bg-white/[0.01]">
                        <span class="text-xs font-black text-white uppercase tracking-widest">Related Signal Artifacts</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-white/5">
                                @foreach($relatedTrades as $relatedTrade)
                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-lg bg-black border border-white/5 flex items-center justify-center">
                                                <i data-lucide="{{ $relatedTrade->type === 'Buy' ? 'arrow-up-right' : 'arrow-down-right' }}" 
                                                   class="w-4 h-4 {{ $relatedTrade->type === 'Buy' ? 'text-emerald-400' : 'text-rose-400' }}"></i>
                                            </div>
                                            <div>
                                                <div class="text-[10px] font-bold text-white uppercase tracking-tight">{{ $relatedTrade->type }} {{ $relatedTrade->assets }}</div>
                                                <div class="text-[8px] font-black text-slate-600 uppercase tracking-widest">{{ \Carbon\Carbon::parse($relatedTrade->created_at)->format('M d, H:i') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 font-mono text-xs text-slate-400">
                                        {{ Auth::user()->currency }}{{ number_format($relatedTrade->amount, 2) }}
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-tighter {{ $relatedTrade->active === 'yes' ? 'bg-yellow-500/10 text-yellow-500' : 'bg-white/5 text-slate-500' }}">
                                            {{ $relatedTrade->active === 'yes' ? 'Active' : 'Archived' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Command Sidebar -->
            <div class="xl:col-span-4 space-y-8">
                <!-- Cluster Performance Analytics -->
                <div class="dashboard-glass p-8 border-white/5 relative overflow-hidden group">
                    <div class="absolute -right-4 -top-4 w-12 h-12 bg-white/5 blur-xl group-hover:bg-yellow-500/5 transition-all"></div>
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-8">Performance Cluster</h3>
                    
                    <div class="space-y-6">
                        @foreach([
                            ['label' => 'Total Cluster Nodes', 'value' => $stats->total_trades ?? 0, 'icon' => 'cpu'],
                            ['label' => 'Active Operations', 'value' => $stats->active_trades ?? 0, 'icon' => 'zap', 'color' => 'gold-text'],
                            ['label' => 'Successful Signal Resolves', 'value' => $stats->completed_trades ?? 0, 'icon' => 'check-circle'],
                            ['label' => 'Gross Deployment', 'value' => Auth::user()->currency . number_format($stats->total_invested ?? 0, 2), 'icon' => 'database']
                        ] as $stat)
                        <div class="flex justify-between items-center group/item">
                            <div class="flex items-center space-x-3">
                                <i data-lucide="{{ $stat['icon'] }}" class="w-4 h-4 text-slate-600 group-hover/item:text-yellow-500/50 transition-colors"></i>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ $stat['label'] }}</span>
                            </div>
                            <span class="text-xs font-black {{ $stat['color'] ?? 'text-white' }}  tracking-tighter">{{ $stat['value'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Strategic Command Actions -->
                <div class="dashboard-glass p-8 border-white/10">
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] mb-8">Available Commands</h3>
                    <div class="space-y-4">
                        @if($instrument)
                        <a href="{{ route('trade.single', $instrument->id) }}" 
                            class="flex items-center justify-between w-full h-14 px-6 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest hover:scale-[1.03] transition-all group">
                            <span>Execute New {{ $trade->assets }} Node</span>
                            <i data-lucide="plus-square" class="w-4 h-4"></i>
                        </a>
                        @endif

                        <a href="{{ route('trade.index') }}" 
                            class="flex items-center justify-between w-full h-14 px-6 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                            <span>Matrix Navigation</span>
                            <i data-lucide="grid" class="w-4 h-4 opacity-30"></i>
                        </a>

                        <a href="{{ route('tradinghistory') }}" 
                            class="flex items-center justify-between w-full h-14 px-6 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                            <span>Full Data Repository</span>
                            <i data-lucide="database" class="w-4 h-4 opacity-30"></i>
                        </a>
                    </div>
                </div>

                <!-- Security Advisory -->
                <div class="p-8 rounded-3xl bg-yellow-500/5 border border-yellow-500/10 flex items-start space-x-4 group">
                    <i data-lucide="shield-alert" class="w-5 h-5 gold-text mt-1 group-hover:scale-110 transition-all"></i>
                    <div>
                        <h4 class="text-[10px] font-black text-white uppercase tracking-widest mb-2">Institutional Grade Shielding</h4>
                        <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed tracking-tighter grayscale group-hover:grayscale-0 transition-all">
                            Node synchronization utilizes end-to-end encryption. All execution artifacts are logged on our distributed ledger for immutable auditing.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function tradeMonitor() {
            return {
                isActive: @json($trade->active === 'yes'),
                tradeData: @json($trade),
                timeLeft: 'Initializing...',

                init() {
                    this.updateTimeLeft();
                    if (this.isActive) {
                        setInterval(() => {
                            this.updateTimeLeft();
                        }, 1000);
                    }

                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                },

                updateTimeLeft() {
                    if (!this.tradeData.expire_date) {
                        this.timeLeft = 'UNLIMITED';
                        return;
                    }

                    const now = new Date();
                    const expireDate = new Date(this.tradeData.expire_date);
                    const diffMs = expireDate - now;

                    if (diffMs <= 0) {
                        this.timeLeft = 'TERMINATED';
                        this.isActive = false;
                        return;
                    }

                    const diffSecs = Math.floor(diffMs / 1000);
                    const diffMins = Math.floor(diffSecs / 60);
                    const diffHours = Math.floor(diffMins / 60);
                    const diffDays = Math.floor(diffHours / 24);

                    let timeStr = '';
                    if (diffDays > 0) {
                        timeStr = `${diffDays}D ${diffHours % 24}H ${diffMins % 60}M`;
                    } else if (diffHours > 0) {
                        timeStr = `${diffHours}H ${diffMins % 60}M ${diffSecs % 60}S`;
                    } else {
                        timeStr = `${diffMins}M ${diffSecs % 60}S`;
                    }

                    this.timeLeft = timeStr;
                }
            }
        }
    </script>
@endsection
