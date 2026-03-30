<?php $__env->startSection('title', 'My Dashboard'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">

        
        <?php if(Auth::user()->account_verify !== 'Verified'): ?>
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-4 sm:px-6 py-4 rounded-2xl bg-yellow-500/10 border border-yellow-500/20">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-yellow-400 uppercase tracking-widest">Identity Verification Required
                        </p>
                        <p class="text-[10px] text-yellow-400/70 font-bold uppercase tracking-wider mt-0.5">Complete
                            verification to access all features of your account</p>
                    </div>
                </div>
                <a href="<?php echo e(route('account.verify')); ?>"
                    class="flex-shrink-0 h-10 px-5 sm:px-6 rounded-xl bg-yellow-500 text-black font-black text-[10px] uppercase tracking-widest hover:bg-yellow-400 transition-all flex items-center justify-center space-x-2">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    <span>Verify Now</span>
                </a>
            </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">

            
            <a href="<?php echo e(route('deposits')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 hover:bg-emerald-500/10 hover:border-emerald-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Deposit</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Add Funds</p>
                </div>
            </a>

            
            <a href="<?php echo e(route('withdrawalsdeposits')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-rose-500/5 border border-rose-500/10 hover:bg-rose-500/10 hover:border-rose-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-rose-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Withdraw</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Cash Out</p>
                </div>
            </a>

            
            <a href="<?php echo e(route('myplans.default')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-yellow-500/5 border border-yellow-500/10 hover:bg-yellow-500/10 hover:border-yellow-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-yellow-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-yellow-400 uppercase tracking-widest">Invest</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">View Plans</p>
                </div>
            </a>

            
            <a href="<?php echo e(route('copy.dashboard')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-purple-500/5 border border-purple-500/10 hover:bg-purple-500/10 hover:border-purple-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-purple-400 uppercase tracking-widest">Copy Trade</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Auto Trade</p>
                </div>
            </a>

            
            <a href="<?php echo e(route('connect_wallet')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-blue-500/5 border border-blue-500/10 hover:bg-blue-500/10 hover:border-blue-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Wallet</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Connect</p>
                </div>
            </a>

            
            <a href="<?php echo e(route('referuser')); ?>"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-orange-500/5 border border-orange-500/10 hover:bg-orange-500/10 hover:border-orange-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-orange-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest">Refer</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Earn Bonus</p>
                </div>
            </a>

        </div>

        <!-- Premium Stats Banner -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Wallet Balance -->
            <div
                class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/30 transition-all cursor-default">
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Wallet Balance /
                            <?php echo e(Auth::user()->currency); ?></span>
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500 opacity-60"></i>
                    </div>
                    <div>
                        <h2
                            class="text-4xl font-black tracking-tighter gold-text mb-2 animate-in slide-in-from-left duration-700">
                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2)); ?>

                        </h2>
                        <div class="flex items-center space-x-2">
                            <div class="h-1 w-1 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Available to
                                trade</span>
                        </div>
                    </div>
                </div>
                <!-- Background abstraction -->
                <div
                    class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 group-hover:scale-110 transition-all duration-700">
                    <i data-lucide="wallet" class="w-32 h-32"></i>
                </div>
            </div>

            <!-- Total Profit -->
            <div
                class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/30 transition-all cursor-default">
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Profit</span>
                        <i data-lucide="bar-chart-3" class="w-4 h-4 gold-text opacity-60"></i>
                    </div>
                    <div>
                        <h2
                            class="text-4xl font-black tracking-tighter text-white mb-2 animate-in slide-in-from-left duration-700 delay-100">
                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->roi, 2)); ?>

                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-[9px] font-black text-emerald-400 uppercase tracking-widest">Your total
                                earnings</span>
                        </div>
                    </div>
                </div>
                <div
                    class="absolute -right-8 -bottom-8 opacity-5 group-hover:opacity-10 group-hover:rotate-12 transition-all duration-700">
                    <i data-lucide="activity" class="w-32 h-32 gold-text"></i>
                </div>
            </div>

            <!-- Active Bots -->
            <div
                class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/30 transition-all cursor-default">
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Active Bots</span>
                        <i data-lucide="cpu" class="w-4 h-4 text-purple-500 opacity-60"></i>
                    </div>
                    <div>
                        <h2
                            class="text-4xl font-black tracking-tighter text-white mb-2 animate-in slide-in-from-left duration-700 delay-200">
                            <?php echo e(count($plans)); ?>

                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Running
                                trades</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-all duration-700">
                    <i data-lucide="layers" class="w-32 h-32 text-purple-600"></i>
                </div>
            </div>

            <!-- Referral Reward -->
            <div
                class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/30 transition-all cursor-default lg:col-span-1">
                <div class="relative z-10 flex flex-col justify-between h-full">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Referral
                            Reward</span>
                        <i data-lucide="users" class="w-4 h-4 text-blue-500 opacity-60"></i>
                    </div>
                    <div>
                        <h2
                            class="text-4xl font-black tracking-tighter text-white mb-2 animate-in slide-in-from-left duration-700 delay-300">
                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->ref_bonus, 2)); ?>

                        </h2>
                        <div class="flex items-center space-x-2">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Bonus from
                                friends</span>
                        </div>
                    </div>
                </div>
                <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-all duration-700">
                    <i data-lucide="share-2" class="w-32 h-32 text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- Main Terminal Area -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Core Visualizer (Large) -->
            <div class="xl:col-span-2 space-y-8">
                <div class="market-glass overflow-hidden border-white/5 bg-black/40">
                    <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                        <div class="flex items-center space-x-4">
                            <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                                <i data-lucide="layout" class="w-5 h-5 gold-text"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black uppercase tracking-tight">Market Prices</h3>
                                <div class="flex items-center mt-1">
                                    <div class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest">Real-time
                                        market data active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-[600px] w-full bg-black/60 relative">
                        <div id="tradingview_dashboard" class="h-full w-full"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                        <script type="text/javascript">
                            new TradingView.widget({
                                "autosize": true,
                                "symbol": "BINANCE:BTCUSDT",
                                "interval": "30",
                                "timezone": "Etc/UTC",
                                "theme": "dark",
                                "style": "2",
                                "locale": "en",
                                "toolbar_bg": "rgba(0, 0, 0, 0.9)",
                                "enable_publishing": false,
                                "hide_side_toolbar": false,
                                "allow_symbol_change": true,
                                "container_id": "tradingview_dashboard"
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- Sidebar Components -->
            <div class="space-y-8">
                <!-- Asset Frequency / Watchlist -->
                <div class="dashboard-glass border-white/10 p-8">
                    <div class="flex items-center justify-between mb-10">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center">
                            <i data-lucide="eye" class="w-4 h-4 mr-3 gold-text"></i> Market Watch
                        </h3>
                        <div class="flex items-center h-6 px-3 rounded-full bg-yellow-500/10 border border-yellow-500/20">
                            <span
                                class="text-[8px] font-black gold-text uppercase tracking-widest animate-pulse">Live</span>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <?php
                            $assets = [
                                ['name' => 'Bitcoin', 'symbol' => 'BTC', 'price' => '$64,281', 'change' => '+2.4%', 'up' => true],
                                ['name' => 'Ethereum', 'symbol' => 'ETH', 'price' => '$3,492', 'change' => '+1.1%', 'up' => true],
                                ['name' => 'Solana', 'symbol' => 'SOL', 'price' => '$145.8', 'change' => '-0.8%', 'up' => false],
                                ['name' => 'Gold', 'symbol' => 'XAU', 'price' => '$2,164', 'change' => '+0.4%', 'up' => true],
                            ];
                        ?>
                        <?php $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div
                                class="flex items-center justify-between group cursor-pointer hover:bg-white/[0.02] -mx-4 px-4 py-2 rounded-xl transition-all">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-black border border-white/10 flex items-center justify-center font-black text-[10px] group-hover:border-yellow-500/30 transition-all">
                                        <?php echo e($asset['symbol']); ?>

                                    </div>
                                    <div>
                                        <div
                                            class="text-[11px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">
                                            <?php echo e($asset['name']); ?>

                                        </div>
                                        <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest">
                                            <?php echo e($asset['symbol']); ?>/USD
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-mono font-black text-white leading-none"><?php echo e($asset['price']); ?>

                                    </div>
                                    <div
                                        class="text-[9px] font-black mt-1 <?php echo e($asset['up'] ? 'text-emerald-400' : 'text-rose-400'); ?> uppercase tracking-widest">
                                        <?php echo e($asset['change']); ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <a href="<?php echo e(route('trade.index')); ?>"
                        class="mt-8 h-12 w-full flex items-center justify-center rounded-xl bg-white/5 border border-white/5 text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-white hover:border-white/20 transition-all">
                        View All Markets
                    </a>
                </div>

                <!-- Protocol Promotion -->
                <div
                    class="market-glass p-10 gold-gradient text-black relative group overflow-hidden cursor-pointer shadow-2xl shadow-yellow-500/20">
                    <i data-lucide="zap"
                        class="absolute -right-4 -bottom-4 w-32 h-32 opacity-10 group-hover:scale-110 transition-transform"></i>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-black tracking-tighter mb-4 uppercase leading-tight">Trading
                            <br>Signals
                        </h3>
                        <p class="text-xs font-bold opacity-70 mb-8 leading-relaxed uppercase tracking-widest max-w-[80%]">
                            Access real-time signals from top professional traders worldwide.
                        </p>
                        <div class="flex items-center text-[10px] font-black uppercase tracking-[0.2em] group/btn">
                            Get Signals <i data-lucide="arrow-right"
                                class="w-4 h-4 ml-3 group-hover/btn:translate-x-2 transition-transform"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Execution History -->
        <div class="market-glass overflow-hidden border-white/5">
            <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                <div class="flex items-center space-x-4">
                    <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                        <i data-lucide="history" class="w-5 h-5 gold-text"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black uppercase tracking-tight">Recent History</h3>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Summary of your
                            recent activities</p>
                    </div>
                </div>
                <a href="<?php echo e(route('accounthistory')); ?>"
                    class="h-10 px-6 rounded-xl border border-white/5 text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-white hover:border-white/10 transition-all flex items-center">
                    View All History
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 border-b border-white/5">
                            <th class="px-10 py-6">ID</th>
                            <th class="px-8 py-6">Investment</th>
                            <th class="px-8 py-6">Profit/Loss</th>
                            <th class="px-8 py-6">Date</th>
                            <th class="px-10 py-6 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php $__empty_1 = true; $__currentLoopData = $t_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-10 py-6 font-mono text-[10px] text-slate-400 uppercase">
                                    #X<?php echo e(rand(100, 999)); ?><?php echo e($history->id); ?>

                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center space-x-4">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-black border border-white/10 flex items-center justify-center group-hover:border-yellow-500/30 transition-all">
                                            <i data-lucide="<?php echo e($history->type == 'LOSE' ? 'trending-down' : 'trending-up'); ?>"
                                                class="w-4 h-4 <?php echo e($history->type == 'LOSE' ? 'text-rose-500' : 'gold-text'); ?>"></i>
                                        </div>
                                        <span class="text-xs font-black text-white uppercase tracking-tighter">
                                            <?php echo e($history->plan ?: 'Profit'); ?>

                                        </span>
                                    </div>
                                </td>
                                <td
                                    class="px-8 py-6 text-xs font-mono font-black <?php echo e($history->type == 'LOSE' ? 'text-rose-400' : 'text-emerald-400'); ?>">
                                    <?php echo e($history->type == 'LOSE' ? '-' : '+'); ?><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($history->amount, 2)); ?>

                                </td>
                                <td class="px-8 py-6 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                    <?php echo e($history->created_at->format('M d, Y')); ?><br>
                                    <span class="opacity-50 font-bold"><?php echo e($history->created_at->format('H:i:s')); ?></span>
                                </td>
                                <td class="px-10 py-6 text-right">
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[9px] font-black text-emerald-500 uppercase tracking-widest">
                                        Settled
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-10 py-20 text-center">
                                    <i data-lucide="database-zap" class="w-8 h-8 text-slate-800 mx-auto mb-4"></i>
                                    <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest leading-relaxed">
                                        No recent activity found in your account.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/user/dashboard.blade.php ENDPATH**/ ?>