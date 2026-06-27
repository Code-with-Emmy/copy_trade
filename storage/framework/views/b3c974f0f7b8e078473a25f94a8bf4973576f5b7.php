<?php $__env->startSection('title', 'Social Copy Command Center'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-content-stack animate-fadeIn" x-data="{ allocationChart: null, growthChart: null }">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
        <div>
            <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Console</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-300">Social Copy Command Center</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Copy <span class="gold-text">Command Center</span></h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Monitor and manage your high-frequency social allocations.</p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
             <a href="<?php echo e(route('copy.experts')); ?>"
                     class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                Discover Traders
            </a>
            <a href="<?php echo e(route('accounthistory')); ?>"
                     class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                <i data-lucide="history" class="w-4 h-4 mr-2"></i>
                Audit Logs
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-5 py-4 text-xs font-bold text-emerald-400 uppercase tracking-widest">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="rounded-2xl border border-rose-400/25 bg-rose-400/10 px-5 py-4 text-xs font-bold text-rose-400 uppercase tracking-widest">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Portfolio Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
        <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Portfolio NAV</span>
            <div class="text-3xl font-black text-white italic tracking-tighter mb-2"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($portfolio['portfolio_value'], 2)); ?></div>
            <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                <i data-lucide="activity" class="w-3 h-3 mr-2 gold-text"></i>
                Consolidated Balance
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Allocated Capitol</span>
            <div class="text-3xl font-black gold-text italic tracking-tighter mb-2"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($portfolio['allocated_capital'], 2)); ?></div>
            <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                <i data-lucide="lock" class="w-3 h-3 mr-2 gold-text"></i>
                Deployed Resources
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Realized Yield</span>
            <div class="text-3xl font-black italic tracking-tighter mb-2 <?php echo e($portfolio['realized_pl'] >= 0 ? 'text-emerald-400' : 'text-rose-400'); ?>">
                <?php echo e($portfolio['realized_pl'] >= 0 ? '+' : '-'); ?><?php echo e(auth()->user()->currency); ?><?php echo e(number_format(abs($portfolio['realized_pl']), 2)); ?>

            </div>
            <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                <i data-lucide="check-circle" class="w-3 h-3 mr-2 gold-text"></i>
                Closed Performance
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
            <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
            <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Floating P/L</span>
            <div class="text-3xl font-black italic tracking-tighter mb-2 <?php echo e($portfolio['unrealized_pl'] >= 0 ? 'text-emerald-400' : 'text-rose-400'); ?>">
                 <?php echo e($portfolio['unrealized_pl'] >= 0 ? '+' : '-'); ?><?php echo e(auth()->user()->currency); ?><?php echo e(number_format(abs($portfolio['unrealized_pl']), 2)); ?>

            </div>
            <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                <i data-lucide="trending-up" class="w-3 h-3 mr-2 gold-text animate-pulse"></i>
                Open Exposure
            </div>
        </div>
    </div>

    <!-- Analytics Section -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:gap-8">
        <div class="xl:col-span-2 dashboard-glass p-6 sm:p-8 space-y-6 sm:space-y-8">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Alpha Growth Map</h3>
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-1">Portfolio performance over time</p>
                </div>
            </div>
            <div class="h-[400px] w-full bg-black/40 rounded-3xl p-4 sm:p-6 border border-white/5">
                <canvas id="growthChart"></canvas>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8 space-y-6 sm:space-y-8">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Asset Distribution</h3>
            <div class="h-[300px] w-full relative">
                <canvas id="allocationChart"></canvas>
            </div>
            <div class="space-y-4 pt-4 border-t border-white/5">
                <?php $__empty_1 = true; $__currentLoopData = $portfolio['risk_exposure']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $risk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center space-x-3">
                            <div class="h-2 w-2 rounded-full <?php echo e($risk['label'] == 'Aggressive' ? 'bg-rose-500' : ($risk['label'] == 'Balanced' ? 'bg-yellow-500' : 'bg-emerald-500')); ?>"></div>
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($risk['label']); ?> Allocation</span>
                        </div>
                        <span class="text-[10px] font-black text-white font-mono"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($risk['value'], 2)); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-6">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest italic leading-relaxed">No risk data detected. Activate a subscription to initialize tracking.</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Active Subscriptions Management -->
    <div class="space-y-8">
        <div class="flex items-center justify-between border-b border-white/5 pb-6">
             <h2 class="text-xl font-black text-white italic tracking-tight uppercase">Live <span class="gold-text">Allocations</span></h2>
             <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest"><?php echo e($portfolio['active_subscriptions']->count()); ?> Synchronized Nodes</span>
        </div>

        <?php if($portfolio['active_subscriptions']->count()): ?>
            <div class="grid gap-8 xl:grid-cols-2">
                <?php $__currentLoopData = $portfolio['active_subscriptions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="dashboard-glass border-white/5 overflow-hidden group">
                        <div class="p-8 border-b border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
                            <div class="flex items-center space-x-5">
                                <div class="h-14 w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-colors">
                                    <?php if($subscription->trader && $subscription->trader->photo): ?>
                                        <img src="<?php echo e(asset('storage/' . $subscription->trader->photo)); ?>" class="h-full w-full rounded-[14px] object-cover">
                                    <?php else: ?>
                                        <span class="text-xl font-black gold-text italic tracking-tighter"><?php echo e(strtoupper(substr($subscription->name, 0, 1))); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="text-lg font-black text-white uppercase italic tracking-tight"><?php echo e($subscription->name); ?></h4>
                                    <div class="flex items-center mt-1">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Active Node Relay</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col items-start sm:items-end space-y-1">
                                <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.2em]">Reference Matrix</span>
                                <span class="text-xs font-black text-white font-mono uppercase tracking-tighter">#REF-<?php echo e($subscription->subscription_reference); ?></span>
                            </div>
                        </div>

                        <div class="p-8 grid gap-8 lg:grid-cols-2">
                            <form method="POST" action="<?php echo e(route('copy.subscriptions.update', $subscription->id)); ?>" class="space-y-6">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PUT'); ?>
                                
                                <div class="grid gap-4">
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Capitol Allocation (<?php echo e(auth()->user()->currency); ?>)</label>
                                        <input type="number" step="0.01" min="1" name="amount" value="<?php echo e($subscription->allocation_amount); ?>" 
                                               class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white font-mono focus:border-yellow-500/50 focus:ring-0 transition-all">
                                    </div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-2">
                                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Copy Ratio</label>
                                            <input type="number" step="0.1" min="0.1" max="5" name="copy_ratio" value="<?php echo e($subscription->copy_ratio); ?>" 
                                                   class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white font-mono focus:border-yellow-500/50 focus:ring-0 transition-all">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">D/D Guard %</label>
                                            <input type="number" step="0.5" min="1" max="100" name="max_drawdown_guard" value="<?php echo e($subscription->max_drawdown_guard); ?>" 
                                                   class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white font-mono focus:border-yellow-500/50 focus:ring-0 transition-all">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Execution Mode</label>
                                        <select name="risk_preference" class="w-full bg-black/50 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:border-yellow-500/50 focus:ring-0 transition-all">
                                            <?php $__currentLoopData = ['conservative', 'balanced', 'aggressive']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preference): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($preference); ?>" <?php if($subscription->risk_preference === $preference): echo 'selected'; endif; ?>><?php echo e(ucfirst($preference)); ?> Mode</option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="w-full py-4 bg-white/5 border border-white/10 rounded-xl text-white font-black text-[9px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                    Update Deployment Configuration
                                </button>
                            </form>

                            <div class="space-y-8 flex flex-col justify-between">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-black/40 border border-white/5 rounded-2xl p-4 flex flex-col justify-center">
                                        <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Current P/L</span>
                                        <div class="text-xl font-black italic tracking-tighter <?php echo e(($subscription->current_balance - $subscription->allocation_amount) >= 0 ? 'text-emerald-400' : 'text-rose-400'); ?>">
                                            <?php echo e(auth()->user()->currency); ?><?php echo e(number_format($subscription->current_balance - $subscription->allocation_amount, 2)); ?>

                                        </div>
                                    </div>
                                    <div class="bg-black/40 border border-white/5 rounded-2xl p-4 flex flex-col justify-center">
                                        <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Maturity Age</span>
                                        <div class="text-xl font-black italic tracking-tighter text-white">
                                            <?php echo e(optional($subscription->started_at)->diffInDays() ?? 0); ?>D
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <form method="POST" action="<?php echo e(route('copy.pause', $subscription->id)); ?>" class="flex-1">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full py-3 rounded-xl bg-orange-500/10 border border-orange-500/20 text-orange-500 text-[9px] font-black uppercase tracking-widest hover:bg-orange-500 hover:text-white transition-all">Pause Sync</button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('copy.resume', $subscription->id)); ?>" class="flex-1">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">Resume Sync</button>
                                    </form>
                                    <form method="POST" action="<?php echo e(route('copy.stop', $subscription->id)); ?>" class="w-full">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 text-[9px] font-black uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">Terminate Subscription</button>
                                    </form>
                                </div>

                                <div class="p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10 text-[9px] text-slate-500 font-medium leading-relaxed italic">
                                    <i data-lucide="info" class="w-3 h-3 gold-text inline mr-1 mb-0.5"></i>
                                    Updating allocation values will immediately recalibrate the copy-ratio for upcoming trade executions on this node.
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="dashboard-glass border-white/5 py-20 text-center">
                <i data-lucide="users-2" class="w-16 h-16 text-slate-700 mx-auto mb-6"></i>
                <h3 class="text-lg font-black text-white uppercase tracking-widest">No Active Synchronizations</h3>
                <p class="text-slate-500 text-sm font-medium mt-2 max-w-lg mx-auto leading-relaxed">Discover elite strategy managers in the marketplace and allocate capital to activate real-time trade copying across your decentralized portfolio.</p>
                <a href="<?php echo e(route('copy.experts')); ?>" class="mt-8 inline-flex items-center px-8 py-4 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-105 transition-all">Initialize First Sync</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Position Matrix -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <div class="dashboard-glass overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div>
                     <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Open Position Matrix</h3>
                     <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-1">Live market exposure from copied trades</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[9px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5 bg-white/[0.02]">
                            <th class="px-8 py-4">Node / Source</th>
                            <th class="px-6 py-4">Symbol</th>
                            <th class="px-6 py-4">Vector</th>
                            <th class="px-8 py-4 text-right">Floating P/L</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php $__empty_1 = true; $__currentLoopData = $portfolio['active_positions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-4">
                                    <span class="text-xs font-black text-white uppercase"><?php echo e(optional($trade->subscription)->name ?: 'EXTERNAL'); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-black text-slate-300 font-mono"><?php echo e($trade->symbol); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase <?php echo e($trade->direction == 'BUY' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-400'); ?>">
                                        <?php echo e($trade->direction); ?>

                                    </span>
                                </td>
                                <td class="px-8 py-4 text-right font-black font-mono text-xs <?php echo e($trade->profit_loss >= 0 ? 'text-emerald-400' : 'text-rose-400'); ?>">
                                    <?php echo e(auth()->user()->currency); ?><?php echo e(number_format((float) $trade->profit_loss, 2)); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center italic text-slate-600 text-xs font-bold uppercase tracking-widest opacity-30">No open market positions discovered.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-glass p-8 space-y-8">
            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Historical Performance Yield</h3>
            <div class="h-[300px] w-full bg-black/40 rounded-3xl p-6 border border-white/5">
                <canvas id="profitChart"></canvas>
            </div>
            <div class="p-4 rounded-xl bg-emerald-500/5 border border-emerald-500/10 text-[9px] text-slate-500 font-medium leading-relaxed italic">
                <i data-lucide="terminal" class="w-3 h-3 text-emerald-500 inline mr-1 mb-0.5"></i>
                Performance metrics are calculated based on closed subscription cycles and historical trade logs matched against your node reference.
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textColor = '#94a3b8';
            const gridColor = 'rgba(255, 255, 255, 0.05)';
            const accentGold = '#f0b90a';
            const accentEmerald = '#10b981';

            // Growth Chart
            new Chart(document.getElementById('growthChart'), {
                type: 'line',
                data: {
                    labels: <?php echo json_encode(collect($portfolio['growth_chart'])->pluck('label'), 15, 512) ?>,
                    datasets: [{
                        label: 'Portfolio Value',
                        data: <?php echo json_encode(collect($portfolio['growth_chart'])->pluck('value'), 15, 512) ?>,
                        borderColor: accentGold,
                        backgroundColor: 'rgba(240, 185, 10, 0.05)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: accentGold,
                        pointBorderColor: '#000',
                        pointBorderWidth: 2,
                        pointRadius: 4,
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

            // Allocation Chart
            new Chart(document.getElementById('allocationChart'), {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode(collect($portfolio['allocation_chart'])->pluck('label'), 15, 512) ?>,
                    datasets: [{
                        data: <?php echo json_encode(collect($portfolio['allocation_chart'])->pluck('value'), 15, 512) ?>,
                        backgroundColor: [accentGold, '#d4a017', '#10b981', '#fb7185', '#818cf8', '#6366f1'],
                        borderWidth: 10,
                        borderColor: '#0a0a0a',
                        hoverOffset: 15
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { display: false } }
                }
            });

            // Profit Chart
            new Chart(document.getElementById('profitChart'), {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(collect($portfolio['profit_by_month'])->pluck('label'), 15, 512) ?>,
                    datasets: [{
                        label: 'Monthly Yield',
                        data: <?php echo json_encode(collect($portfolio['profit_by_month'])->pluck('value'), 15, 512) ?>,
                        backgroundColor: accentEmerald,
                        borderRadius: 8,
                        barThickness: 20
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

            lucide.createIcons();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/copy/dashboard.blade.php ENDPATH**/ ?>