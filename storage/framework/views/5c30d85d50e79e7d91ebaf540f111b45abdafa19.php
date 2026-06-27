<?php $__env->startSection('title', 'Trading Bots'); ?>
<?php $__env->startSection('content'); ?>

    <div class="space-y-12 animate-fadeIn" x-data="botCluster()">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Trading Bots</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">AI Trading <span class="gold-text">Bots</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Turn on smart trading bots to grow your money 24/7 automatically.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('user.bots.dashboard')); ?>"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="cpu" class="w-4 h-4 mr-2"></i>
                    My Active Bots
                </a>
            </div>
        </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.success-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <?php if($userInvestments->count() > 0): ?>
            <!-- Active Node Synchronizations -->
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <h2 class="text-xs font-black text-white uppercase tracking-[0.2em]">Running Bots</h2>
                    <div class="flex-1 h-px bg-white/5"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php $__currentLoopData = $userInvestments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="dashboard-glass border-white/5 p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                            <div
                                class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                            </div>

                            <div class="flex items-center justify-between mb-8 relative z-10">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="h-14 w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 shadow-xl group-hover:border-yellow-500/30 transition-all">
                                        <?php if($investment->bot->image): ?>
                                            <img src="<?php echo e(asset('storage/' . $investment->bot->image)); ?>"
                                                class="h-full w-full rounded-[14px] object-cover">
                                        <?php else: ?>
                                            <i data-lucide="bot" class="w-7 h-7 gold-text"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-black text-white uppercase tracking-tight">
                                            <?php echo e($investment->bot->name); ?></h4>
                                        <div class="flex items-center mt-1">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                            <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Active
                                                Relay</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[9px] font-black text-slate-600 uppercase mb-1">P/L</div>
                                    <div class="text-sm font-black text-emerald-400 font-mono">
                                        +<?php echo e(auth()->user()->currency); ?><?php echo e(number_format($investment->total_profit, 2)); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6 relative z-10 mb-8 pb-8 border-b border-white/5">
                                <div>
                                    <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Invested</span>
                                    <span class="text-xs font-black text-white font-mono"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($investment->investment_amount, 2)); ?></span>
                                </div>
                                <div class="text-right">
                                    <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Current Value</span>
                                    <span class="text-xs font-black text-white font-mono"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($investment->current_balance, 2)); ?></span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between relative z-10">
                                <div class="flex items-center space-x-2">
                                    <i data-lucide="clock" class="w-3 h-3 text-slate-600"></i>
                                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest"><?php echo e($investment->days_remaining); ?> Days Left</span>
                                </div>
                                <a href="<?php echo e(route('user.bots.show', $investment->bot)); ?>" 
                                   class="text-[9px] font-black gold-text uppercase tracking-widest hover:text-white transition-colors">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Available Algorithmic Nodes -->
        <div class="space-y-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-white/5 pb-8">
                <div>
                    <h2 class="text-xl font-black text-white tracking-tight uppercase">Available <span
                            class="gold-text">Bots</span></h2>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">Select a trading 
                        bot to start growing your money.</p>
                </div>

                <div class="flex items-center space-x-2 bg-white/5 p-1 rounded-xl border border-white/10 overflow-x-auto no-scrollbar">
                    <button @click="selectedFilter = 'all'" :class="selectedFilter === 'all' ? 'bg-yellow-500 text-black' : 'text-slate-500 hover:text-white hover:bg-white/5'"
                            class="px-4 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all">All Bots</button>
                    <?php $__currentLoopData = ['forex', 'crypto', 'stocks', 'commodities']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button @click="selectedFilter = '<?php echo e($cat); ?>'" :class="selectedFilter === '<?php echo e($cat); ?>' ? 'bg-white/10 text-white' : 'text-slate-500 hover:text-white hover:bg-white/5'"
                                class="px-4 py-2 rounded-lg font-black text-[9px] uppercase tracking-widest transition-all whitespace-nowrap"><?php echo e(strtoupper($cat)); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php $__currentLoopData = $bots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="dashboard-glass border-white/5 overflow-hidden group hover:border-yellow-500/20 transition-all flex flex-col h-full bot-node"
                         data-category="<?php echo e($bot->bot_type); ?>" x-show="selectedFilter === 'all' || selectedFilter === '<?php echo e($bot->bot_type); ?>'">
                        
                        <!-- Header Stats -->
                        <div class="px-8 py-5 bg-white/[0.02] border-b border-white/5 flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-yellow-500 shadow-[0_0_8px_#f0b90a]"></span>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Bot Profit Rate: <?php echo e($bot->success_rate); ?>%</span>
                            </div>
                            <div class="text-[9px] font-black gold-text uppercase tracking-widest"><?php echo e(strtoupper($bot->bot_type)); ?> Bot</div>
                        </div>

                        <div class="p-8 space-y-8 flex-1">
                            <div class="flex items-start space-x-5">
                                <div class="h-16 w-16 rounded-[22px] bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-all shadow-2xl overflow-hidden">
                                    <?php if($bot->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $bot->image)); ?>" class="h-full w-full object-cover rounded-[20px]">
                                    <?php else: ?>
                                        <i data-lucide="cpu" class="w-8 h-8 gold-text"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xl font-black text-white tracking-tight uppercase truncate"><?php echo e($bot->name); ?></h3>
                                    <div class="flex items-center mt-1 space-x-3">
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Active Time: 99.9%</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Speed: 2ms</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-[11px] text-slate-500 font-bold uppercase leading-relaxed tracking-tight h-16 overflow-hidden line-clamp-4">
                                <?php echo e($bot->description); ?>

                            </p>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-2xl bg-black border border-white/5 hover:bg-white/[0.03] transition-colors">
                                    <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Yield Range</span>
                                    <span class="text-xs font-black text-emerald-400"><?php echo e($bot->daily_profit_range); ?> Daily</span>
                                </div>
                                <div class="p-4 rounded-2xl bg-black border border-white/5 hover:bg-white/[0.03] transition-colors">
                                    <span class="text-xs font-black text-white"><?php echo e($bot->duration_days); ?> Days</span>
                                </div>
                            </div>

                            <div class="space-y-3 pt-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Min Investment</span>
                                    <span class="text-[10px] font-black text-white font-mono"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($bot->min_investment)); ?></span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest">Max Investment</span>
                                    <span class="text-[10px] font-black text-white font-mono"><?php echo e(auth()->user()->currency); ?><?php echo e(number_format($bot->max_investment)); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-black/40 border-t border-white/5">
                            <a href="<?php echo e(route('user.bots.show', $bot)); ?>"
                                class="w-full h-14 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.3em] flex items-center justify-center space-x-3 shadow-xl shadow-yellow-500/10 hover:scale-[1.03] transform transition-all active:scale-95">
                                <span>Start Bot</span>
                                <i data-lucide="zap" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php if($bots->count() === 0): ?>
                <div class="dashboard-glass border-white/5 py-24 text-center">
                    <i data-lucide="cpu" class="w-16 h-16 text-slate-800 mx-auto mb-6"></i>
                    <h3 class="text-xl font-black text-white uppercase tracking-widest">No Available Modules</h3>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2 max-w-md mx-auto leading-relaxed">The bot cluster is currently at capacity. Check back shortly for open slots.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        document.addEventListener('alpine:init', () => {
             Alpine.data('botCluster', () => ({
                selectedFilter: 'all',
                init() {
                    lucide.createIcons();
                }
             }));
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/bot/index.blade.php ENDPATH**/ ?>