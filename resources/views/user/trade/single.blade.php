@extends('layouts.dasht')
@section('title', 'Trade ' . $instrument->name)
@section('content')

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="tradingSingle()" x-cloak>
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('trade.index') }}" class="hover:text-yellow-500 transition-colors">Markets</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Terminal Access</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Market <span class="gold-text">Terminal</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Precision node synchronization with institutional
                    liquidity.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('trade.index') }}"
                    class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Back to Matrix</span>
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <!-- Trading Interface Matrix -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            <!-- Left Command Center: Chart & Stats -->
            <div class="xl:col-span-8 space-y-8">
                <!-- Instrument Intelligence Header -->
                <div class="dashboard-glass p-8 border-white/5 overflow-hidden group relative">
                    <div class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                    
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 relative">
                        <div class="flex items-center space-x-6">
                            <div class="h-20 w-20 rounded-3xl bg-black border border-white/10 p-3 flex items-center justify-center shadow-2xl group-hover:border-yellow-500/30 transition-all">
                                @if($instrument->logo)
                                    <img src="{{ $instrument->logo }}" alt="{{ $instrument->name }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-2xl font-black gold-text">{{ substr($instrument->symbol, 0, 2) }}</span>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-3xl font-black text-white tracking-tight uppercase">{{ $instrument->name }}</h2>
                                <div class="flex items-center space-x-3 mt-1">
                                    <span class="text-xs font-black text-slate-500 uppercase tracking-[0.2em]">{{ $instrument->symbol }}</span>
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Live Sync</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col items-end gap-3 md:gap-1">
                            <div class="text-4xl font-black text-white  tracking-tighter">
                                ${{ number_format($instrument->price, $instrument->price >= 1 ? 2 : 6) }}
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center {{ $instrument->percent_change_24h >= 0 ? 'text-emerald-400' : 'text-rose-400' }} text-sm font-black">
                                    <i data-lucide="{{ $instrument->percent_change_24h >= 0 ? 'trending-up' : 'trending-down' }}" class="w-4 h-4 mr-1"></i>
                                    {{ number_format($instrument->percent_change_24h, 2) }}%
                                </span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                    24H Delta: {{ $instrument->change >= 0 ? '+' : '' }}${{ number_format($instrument->change, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- High-Resolution Signal Chart -->
                <div class="dashboard-glass p-1 border-white/5 overflow-hidden">
                    <div class="p-6 border-b border-white/5 bg-white/[0.01] flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <i data-lucide="bar-chart-2" class="w-4 h-4 gold-text"></i>
                            <span class="text-xs font-black text-white uppercase tracking-widest">Temporal Price Matrix</span>
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Precision Level: Institutional</span>
                        </div>
                    </div>
                    <div class="h-[600px] w-full bg-black/40">
                        <div class="tradingview-widget-container h-full">
                            <div id="tradingview_chart" class="h-full"></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                            {
                                "height": 600,
                                "symbol": "{{ $instrument->symbol }}",
                                "interval": "D",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "1",
                                "locale": "en",
                                "toolbar_bg": "#f1f3f6",
                                "enable_publishing": false,
                                "allow_symbol_change": true,
                                "container_id": "tradingview_chart"
                            }
                            </script>
                        </div>
                    </div>
                </div>

                <!-- Node Statistics Ledger -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach([
                        ['label' => '24H Ceiling', 'value' => '$' . number_format($instrument->high ?? 0, $instrument->price >= 1 ? 2 : 6), 'icon' => 'arrow-up'],
                        ['label' => '24H Floor', 'value' => '$' . number_format($instrument->low ?? 0, $instrument->price >= 1 ? 2 : 6), 'icon' => 'arrow-down'],
                        ['label' => 'Cluster Vol', 'value' => $instrument->volume >= 1e9 ? '$' . number_format($instrument->volume / 1e9, 1) . 'B' : ($instrument->volume >= 1e6 ? '$' . number_format($instrument->volume / 1e6, 1) . 'M' : '$' . number_format($instrument->volume ?? 0)), 'icon' => 'activity'],
                        ['label' => 'Network Cap', 'value' => $instrument->market_cap >= 1e9 ? '$' . number_format($instrument->market_cap / 1e9, 1) . 'B' : ($instrument->market_cap >= 1e6 ? '$' . number_format($instrument->market_cap / 1e6, 1) . 'M' : '$' . number_format($instrument->market_cap ?? 0)), 'icon' => 'globe']
                    ] as $stat)
                        <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                            <div class="absolute -right-4 -top-4 w-12 h-12 bg-white/5 blur-xl group-hover:bg-yellow-500/5 transition-all"></div>
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 flex items-center">
                                <i data-lucide="{{ $stat['icon'] }}" class="w-3 h-3 mr-2 opacity-30"></i>
                                {{ $stat['label'] }}
                            </div>
                            <div class="text-base font-black text-white  tracking-tighter">{{ $stat['value'] }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Signal History Ledger -->
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <div class="flex items-center p-1 bg-black/40 border-b border-white/5">
                        <button @click="activeTab = 'open'"
                            :class="activeTab === 'open' ? 'bg-white/10 text-white shadow-xl' : 'text-slate-500 hover:text-white'"
                            class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center">
                            <i data-lucide="zap" class="w-4 h-4 mr-2" :class="activeTab === 'open' ? 'gold-text' : ''"></i>
                            Live Projections ({{ $openTrades->count() }})
                        </button>
                        <button @click="activeTab = 'closed'"
                            :class="activeTab === 'closed' ? 'bg-white/10 text-white shadow-xl' : 'text-slate-500 hover:text-white'"
                            class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center">
                            <i data-lucide="history" class="w-4 h-4 mr-2"></i>
                            Historical Audit ({{ $closedTrades->count() }})
                        </button>
                    </div>

                    <div class="p-8">
                        <!-- Open Signals -->
                        <div x-show="activeTab === 'open'" x-transition.opacity>
                            @if($openTrades->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($openTrades as $trade)
                                        <div class="dashboard-glass border-white/5 p-6 hover:border-yellow-500/20 transition-all group">
                                            <div class="flex items-start justify-between mb-6">
                                                <div class="flex items-center space-x-4">
                                                    <div class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center group-hover:border-yellow-500/30 transition-all">
                                                        <i data-lucide="{{ $trade->type === 'Buy' ? 'trending-up' : 'trending-down' }}" 
                                                           class="w-5 h-5 {{ $trade->type === 'Buy' ? 'text-emerald-400' : 'text-rose-400' }}"></i>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs font-black text-white uppercase tracking-tight">{{ $trade->type }} POSITION</div>
                                                        <div class="text-[9px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">ID: {{ substr($trade->id, 0, 8) }}</div>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-lg font-black text-white  tracking-tighter">{{ Auth::user()->currency }}{{ number_format($trade->amount, 2) }}</div>
                                                    <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest mt-0.5">{{ \Carbon\Carbon::parse($trade->created_at)->diffForHumans() }}</div>
                                                </div>
                                            </div>

                                            <div class="space-y-4">
                                                <div class="bg-black/30 rounded-xl p-4 border border-white/5">
                                                    <div class="flex justify-between items-center mb-2">
                                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Synchronization Progress</span>
                                                        <span class="text-[9px] font-black gold-text uppercase tracking-widest  animate-pulse">Running</span>
                                                    </div>
                                                    <div class="w-full bg-white/5 rounded-full h-1 overflow-hidden">
                                                        <div class="gold-gradient-bg h-full animate-progress-reveal rounded-full" style="width: 65%"></div>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="p-3 rounded-xl bg-white/[0.02] border border-white/5 text-center">
                                                        <div class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Leverage</div>
                                                        <div class="text-xs font-black text-white">1:{{ $trade->leverage ?? 'N/A' }}</div>
                                                    </div>
                                                    <div class="p-3 rounded-xl bg-white/[0.02] border border-white/5 text-center">
                                                        <div class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Unrealized P/L</div>
                                                        <div class="text-xs font-black {{ ($trade->profit_earned ?? 0) >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                            {{ ($trade->profit_earned ?? 0) >= 0 ? '+' : '' }}{{Auth::user()->currency}}{{ number_format($trade->profit_earned ?? 0, 2) }}
                                                        </div>
                                                    </div>
                                                </div>

                                                <a href="{{ route('trade.monitor', $trade->id) }}" 
                                                    class="block w-full py-3 rounded-xl bg-white/5 border border-white/10 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:bg-white/10 hover:text-white transition-all">
                                                    Monitor Signal Node
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="py-20 text-center">
                                    <div class="h-16 w-16 rounded-3xl bg-black border border-white/5 flex items-center justify-center mx-auto mb-6">
                                        <i data-lucide="zap-off" class="w-8 h-8 text-slate-800"></i>
                                    </div>
                                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">No Active Projections Found</h4>
                                    <p class="text-[10px] text-slate-600 font-bold uppercase mt-2">Initialize a new signal projection using the command panel on the right.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Closed Signals -->
                        <div x-show="activeTab === 'closed'" x-transition.opacity>
                            @if($closedTrades->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left">
                                        <thead>
                                            <tr class="text-[9px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5">
                                                <th class="px-6 py-4">Position</th>
                                                <th class="px-6 py-4">Executed Value</th>
                                                <th class="px-6 py-4">Final Yield</th>
                                                <th class="px-6 py-4">Status</th>
                                                <th class="px-6 py-4 text-right">Artifacts</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-white/5">
                                            @foreach($closedTrades as $trade)
                                                @php
                                                    $pnl = $trade->profit_earned ?? 0;
                                                    $isWin = $pnl > 0;
                                                @endphp
                                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                                    <td class="px-6 py-5">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="h-8 w-8 rounded-lg bg-black border border-white/5 flex items-center justify-center">
                                                                <i data-lucide="{{ $trade->type === 'Buy' ? 'arrow-up-right' : 'arrow-down-right' }}" 
                                                                   class="w-4 h-4 {{ $trade->type === 'Buy' ? 'text-emerald-400' : 'text-rose-400' }}"></i>
                                                            </div>
                                                            <div class="text-[11px] font-bold text-white uppercase tracking-tight">{{ $trade->type }} {{ $trade->assets }}</div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-5 font-mono text-xs text-slate-300">
                                                        {{ Auth::user()->currency }}{{ number_format($trade->amount, 2) }}
                                                    </td>
                                                    <td class="px-6 py-5">
                                                        <div class="text-xs font-black {{ $isWin ? 'text-emerald-400' : 'text-rose-400' }}">
                                                            {{ $isWin ? '+' : '' }}{{ Auth::user()->currency }}{{ number_format($pnl, 2) }}
                                                        </div>
                                                        <div class="text-[8px] font-bold text-slate-600 uppercase tracking-widest mt-0.5">
                                                            ROI: {{ number_format(($pnl / ($trade->amount ?: 1)) * 100, 2) }}%
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-5">
                                                        <span class="px-2 py-0.5 rounded bg-white/5 text-[8px] font-black uppercase tracking-tighter text-slate-400 border border-white/5">Terminated</span>
                                                    </td>
                                                    <td class="px-6 py-5 text-right">
                                                        <a href="{{ route('trade.monitor', $trade->id) }}" class="text-[10px] font-black gold-text uppercase tracking-widest hover:text-white transition-all">Audit</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="py-20 text-center">
                                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest">Audit Registry Empty</h4>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Command Center: Order Panel -->
            <div class="xl:col-span-4">
                <div class="dashboard-glass border-white/10 overflow-hidden sticky top-32">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-xs font-black text-white uppercase tracking-[0.3em]">Signal Configuration</h3>
                    </div>

                    <div class="p-8 space-y-8">
                        <!-- Order Type Selection -->
                        <div class="flex p-1 bg-black/40 border border-white/10 rounded-2xl">
                            <button @click="orderType = 'Buy'"
                                :class="orderType === 'Buy' ? 'bg-emerald-500 text-black shadow-xl' : 'text-slate-500 hover:text-white'"
                                class="flex-1 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                Protocol Long
                            </button>
                            <button @click="orderType = 'Sell'"
                                :class="orderType === 'Sell' ? 'bg-rose-500 text-white shadow-xl' : 'text-slate-500 hover:text-white'"
                                class="flex-1 py-4 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                Protocol Short
                            </button>
                        </div>

                        <!-- Order Form Intelligence -->
                        <form action="{{ route('joinplan') }}" method="POST" class="space-y-6" @submit.prevent="submitOrder">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $instrument->id }}">
                            <input type="hidden" name="symbol" value="{{ $instrument->symbol }}">
                            <input type="hidden" name="asset" value="{{ $instrument->name }}">
                            <input type="hidden" name="instrument_price" value="{{ $instrument->price }}">
                            <input type="hidden" name="order_type" x-model="orderType">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3">Execution Layer</label>
                                    <div class="relative">
                                        <select x-model="tradeType" name="trade_type" 
                                            class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-[11px] font-bold text-white uppercase focus:border-yellow-500/50 focus:outline-none transition-all appearance-none cursor-pointer">
                                            <option value="market">Immediate Execution (Market)</option>
                                            <option value="limit">Conditional Projection (Limit)</option>
                                            <option value="stop">Safety Override (Stop)</option>
                                        </select>
                                        <i data-lucide="chevron-down" class="absolute right-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600 pointer-events-none"></i>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3">Leverage</label>
                                        <div class="relative">
                                            <select name="leverage" id="leverage" required
                                                class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-xs font-bold text-white focus:border-yellow-500/50 focus:outline-none transition-all appearance-none cursor-pointer">
                                                <option value="10">1:10</option>
                                                <option value="20">1:20</option>
                                                <option value="50">1:50</option>
                                                <option value="100">1:100</option>
                                            </select>
                                            <i data-lucide="shield" class="absolute right-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600 pointer-events-none"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3">TTL</label>
                                        <div class="relative">
                                            <select name="expire" id="expire" required
                                                class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-[10px] font-bold text-white uppercase focus:border-yellow-500/50 focus:outline-none transition-all appearance-none cursor-pointer">
                                                <option value="15 Minutes">15M</option>
                                                <option value="60 Minutes">1H</option>
                                                <option value="4 Hours">4H</option>
                                                <option value="1 Days">24H</option>
                                                <option value="7 Days">7D</option>
                                            </select>
                                            <i data-lucide="clock" class="absolute right-6 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="tradeType !== 'market'" x-transition.opacity>
                                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3">Target Value ($)</label>
                                    <input type="number" x-model="price" name="price" step="any"
                                        class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-xs font-black text-white focus:border-yellow-500/50 focus:outline-none transition-all font-mono">
                                </div>

                                <div>
                                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-3">Deployment Assets ($)</label>
                                    <div class="relative">
                                        <input type="number" x-model="amount" name="amount" step="0.01" required placeholder="0.00"
                                            class="w-full h-14 bg-white/5 border border-white/10 rounded-2xl px-6 text-xs font-black text-white focus:border-yellow-500/50 focus:outline-none transition-all font-mono  placeholder:text-slate-800">
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center space-x-2">
                                            <button type="button" @click="setQuickAmount(100)" class="px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-[8px] font-black text-slate-400 uppercase tracking-widest transition-all">Max</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Real-time Projection Intelligence -->
                            <div class="p-6 rounded-2xl bg-black/40 border border-white/10 space-y-3 relative overflow-hidden group">
                                <div class="absolute -right-4 -top-4 w-12 h-12 bg-emerald-500/5 blur-xl group-hover:bg-emerald-500/10 transition-all pointer-events-none"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Computed Units</span>
                                    <span class="text-xs font-black text-white  tracking-tighter" x-text="formatUnits()"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Operational Power</span>
                                    <span class="text-xs font-black text-emerald-400  tracking-tighter" x-text="'$' + (amount ? (amount * (document.getElementById('leverage')?.value || 1)).toLocaleString() : '0.00')"></span>
                                </div>
                                <div class="pt-2 mt-2 border-t border-white/5 flex justify-between items-center">
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Vault Balance</span>
                                    <span class="text-xs font-black text-white  tracking-tighter">${{ number_format(Auth::user()->account_bal, 2) }}</span>
                                </div>
                            </div>

                            <button type="submit" :disabled="!amount || amount <= 0 || loading"
                                :class="orderType === 'Buy' ? 'bg-emerald-500 text-black shadow-emerald-500/20' : 'bg-rose-500 text-white shadow-rose-500/20'"
                                class="w-full h-16 rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-2xl hover:scale-[1.02] transform transition-all active:scale-[0.98] disabled:opacity-50 disabled:grayscale disabled:hover:scale-100 flex items-center justify-center space-x-3">
                                <template x-if="loading">
                                    <i data-lucide="refresh-cw" class="w-5 h-5 animate-spin"></i>
                                </template>
                                <span x-text="loading ? 'CALIBRATING...' : 'INITIALIZE ' + orderType.toUpperCase() + ' NODE'"></span>
                            </button>
                        </form>

                        <div class="flex items-center space-x-3 p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10">
                            <i data-lucide="shield-check" class="w-4 h-4 gold-text"></i>
                            <p class="text-[8px] font-black text-slate-500 uppercase leading-relaxed tracking-widest">Encrypted execution active. Positions are synchronized with Global Tier 1 liquidity clusters.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function tradingSingle() {
            return {
                instrument: @json($instrument),
                orderType: 'Buy',
                tradeType: 'market',
                amount: '',
                price: @json($instrument->price),
                loading: false,
                activeTab: 'open',

                formatAmount() {
                    if (!this.amount) return '$0.00';
                    const amount = parseFloat(this.amount);
                    return '$' + amount.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                },

                formatUnits() {
                    if (!this.amount) return '0.00000000';
                    const amount = parseFloat(this.amount);
                    const price = this.tradeType === 'market' ? this.instrument.price : (this.price || this.instrument.price);
                    const units = amount / parseFloat(price);
                    return units.toLocaleString('en-US', {
                        minimumFractionDigits: 8,
                        maximumFractionDigits: 8
                    });
                },

                setQuickAmount(percentage) {
                    const balance = {{ Auth::user()->account_bal ?? 0 }};
                    this.amount = (balance * percentage / 100).toFixed(2);
                },

                submitOrder() {
                    if (!this.amount || this.amount <= 0) {
                        Swal.fire({
                            title: 'Input Required',
                            text: 'Specify deployment assets for synchronization.',
                            icon: 'warning',
                            background: '#0a0a0a',
                            color: '#fff',
                            confirmButtonColor: '#f0b90a'
                        });
                        return;
                    }

                    const leverage = document.getElementById('leverage').value;
                    const expire = document.getElementById('expire').value;

                    Swal.fire({
                        title: 'Confirm Node Initialization',
                        html: `
                            <div class="text-left space-y-4 p-4 dashboard-glass border-white/5 text-slate-300">
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] uppercase font-black tracking-widest">Protocol</span>
                                    <span class="text-xs font-bold text-white uppercase">${this.orderType}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] uppercase font-black tracking-widest">Assets</span>
                                    <span class="text-xs font-bold text-white">${this.formatAmount()}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] uppercase font-black tracking-widest">Leverage</span>
                                    <span class="text-xs font-bold text-white">1:${leverage}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] uppercase font-black tracking-widest">TTL</span>
                                    <span class="text-xs font-bold text-white uppercase">${expire}</span>
                                </div>
                            </div>
                        `,
                        background: '#0a0a0a',
                        showCancelButton: true,
                        confirmButtonColor: this.orderType === 'Buy' ? '#10B981' : '#EF4444',
                        cancelButtonColor: '#333',
                        confirmButtonText: 'EXECUTE COMMAND',
                        cancelButtonText: 'ABORT'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.loading = true;
                            Swal.fire({
                                title: 'Synchronizing...',
                                text: 'Deploying signal protocol to cluster nodes.',
                                background: '#0a0a0a',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                }
                            });
                            this.$el.closest('form').submit();
                        }
                    });
                },
                init() {
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                }
            }
        }
    </script>
@endsection
