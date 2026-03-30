<?php $__env->startSection('title', 'My Portfolio'); ?>
<?php $__env->startSection('content'); ?>

    <div class="space-y-10 animate-fadeIn" x-data="{ selectedFilter: 'All' }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Portfolio</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Asset <span class="gold-text">Portfolio</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Monitoring <?php echo e($numOfPlan); ?> investment
                    plans.</p>
            </div>

            <div class="flex items-center space-x-4">
                <div class="relative group">
                    <select x-model="selectedFilter"
                        @change="window.location.href = '<?php echo e(url('/dashboard/sort-plans')); ?>/' + selectedFilter"
                        class="bg-white/5 border border-white/10 text-white text-xs font-bold py-3 pl-4 pr-10 rounded-xl appearance-none focus:outline-none focus:border-yellow-500/50 transition-all cursor-pointer">
                        <option value="All" <?php echo e(request()->segment(3) == 'All' ? 'selected' : ''); ?>>All Assets</option>
                        <option value="yes" <?php echo e(request()->segment(3) == 'yes' ? 'selected' : ''); ?>>Active Only</option>
                        <option value="expired" <?php echo e(request()->segment(3) == 'expired' ? 'selected' : ''); ?>>Settled Plans
                        </option>
                    </select>
                    <i data-lucide="filter"
                        class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 pointer-events-none group-hover:text-yellow-500 transition-colors"></i>
                </div>

                <a href="<?php echo e(route('mplans')); ?>"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-xs uppercase tracking-widest shadow-xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95">
                    <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
                    Buy a Plan
                </a>
            </div>
        </div>

        <!-- Portfolio Pulse Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-700">
                    <i data-lucide="briefcase" class="w-24 h-24 text-white"></i>
                </div>
                <div class="flex items-center space-x-3 text-slate-500 mb-4">
                    <div class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                        <i data-lucide="layers" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Total Plans</span>
                </div>
                <div class="text-3xl font-black text-white"><?php echo e($numOfPlan); ?></div>
                <div class="mt-2 flex items-center text-[10px] font-bold text-slate-500">
                    <span class="text-emerald-400 mr-1">+<?php echo e($plans->where('active', 'yes')->count()); ?></span> Active
                    plans
                </div>
            </div>

            <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-700">
                    <i data-lucide="trending-up" class="w-24 h-24 text-white"></i>
                </div>
                <div class="flex items-center space-x-3 text-slate-500 mb-4">
                    <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-400">
                        <i data-lucide="activity" class="w-4 h-4"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest">Total Invested</span>
                </div>
                <div class="text-3xl font-black text-white">
                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plans->where('active', 'yes')->sum('amount'), 2)); ?>

                </div>
                Invested in <span class="text-white mx-1"><?php echo e($plans->where('active', 'yes')->count()); ?></span>
                plans
            </div>
        </div>

        <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-700">
                <i data-lucide="award" class="w-24 h-24 text-white"></i>
            </div>
            <div class="flex items-center space-x-3 text-slate-500 mb-4">
                <div class="p-2 rounded-lg bg-yellow-500/10 text-yellow-500">
                    <i data-lucide="zap" class="w-4 h-4"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest">Total Profit</span>
            </div>
            <div class="text-3xl font-black gold-text">
                <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->roi, 2)); ?>

            </div>
            Total profit earned
        </div>
    </div>

    <div class="dashboard-glass p-6 border-white/5 relative overflow-hidden group">
        <div class="absolute -right-4 -top-4 opacity-[0.03] group-hover:opacity-[0.07] transition-opacity duration-700">
            <i data-lucide="clock" class="w-24 h-24 text-white"></i>
        </div>
        <div class="flex items-center space-x-3 text-slate-500 mb-4">
            <div class="p-2 rounded-lg bg-rose-500/10 text-rose-400">
                <i data-lucide="calendar" class="w-4 h-4"></i>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest">Completed Plans</span>
        </div>
        <div class="text-3xl font-black text-white"><?php echo e($plans->where('active', 'expired')->count()); ?></div>
        Money unlocked from <span class="text-white mx-1"><?php echo e($plans->where('active', 'expired')->count()); ?></span> plans
    </div>
    </div>
    </div>

    <!-- Active Portfolios -->
    <div class="space-y-6">
        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="dashboard-glass border-white/5 hover:border-white/10 transition-all group overflow-hidden">
                <div class="p-6 md:p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-8">
                        <!-- Strategy Identity -->
                        <div class="flex items-center space-x-6 min-w-0 flex-1">
                            <div
                                class="h-16 w-16 rounded-2xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-yellow-500/30 transition-colors">
                                <i data-lucide="bar-chart-3" class="w-8 h-8 gold-text"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center space-x-3 mb-1">
                                    <h3 class="text-xl font-black text-white truncate"><?php echo e($plan->uplan->name); ?></h3>
                                    <?php if($plan->active == 'yes'): ?>
                                        <span
                                            class="flex items-center px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 text-[10px] font-black uppercase tracking-tighter">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="flex items-center px-2 py-0.5 rounded-full bg-slate-500/10 text-slate-400 text-[10px] font-black uppercase tracking-tighter">
                                            Completed
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center space-x-4 text-xs font-bold text-slate-500">
                                    <div class="flex items-center">
                                        <span class="text-slate-600 mr-1.5 uppercase tracking-tighter">Amount:</span>
                                        <span
                                            class="text-slate-300"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->amount, 2)); ?></span>
                                    </div>
                                    <div class="h-1 w-1 rounded-full bg-slate-700"></div>
                                    <div class="flex items-center">
                                        <span class="text-slate-600 mr-1.5 uppercase tracking-tighter">Expected Profit:</span>
                                        <span class="text-emerald-400">+<?php echo e($plan->uplan->increment_amount); ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Growth Visualization -->
                        <div class="flex items-center space-x-8 lg:px-8 lg:border-l lg:border-r border-white/5">
                            <?php
                                $startDate = $plan->created_at;
                                $endDate = \Carbon\Carbon::parse($plan->expire_date);
                                $currentDate = now();
                                $totalDays = $startDate->diffInDays($endDate);
                                $elapsedDays = $startDate->diffInDays($currentDate);
                                $progress = $totalDays > 0 ? min(($elapsedDays / $totalDays) * 100, 100) : 0;
                            ?>
                            <div class="hidden sm:block">
                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-2">Progress</div>
                                <div class="w-48 h-2 bg-white/5 rounded-full overflow-hidden border border-white/5">
                                    <div class="h-full gold-gradient-bg shadow-[0_0_15px_rgba(240,185,10,0.3)] transition-all duration-1000"
                                        style="width: <?php echo e($progress); ?>%"></div>
                                </div>
                                <div class="flex justify-between mt-2 text-[9px] font-black text-slate-600 uppercase">
                                    <span><?php echo e(number_format($progress, 1)); ?>% Completed</span>
                                    <span><?php echo e($currentDate->diffInDays($endDate, false) > 0 ? $currentDate->diffInDays($endDate) . ' Days Left' : 'Completed'); ?></span>
                                </div>
                            </div>

                            <div class="text-center min-w-[100px]">
                                <div class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-1.5">Earned
                                    Profit</div>
                                <div class="text-lg font-black text-emerald-400 font-mono">
                                    +<?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->amount * ($plan->uplan->increment_amount / 100) * ($progress / 100), 2)); ?>

                                </div>
                                <div class="text-[9px] font-bold text-slate-600 uppercase tracking-tighter">Current
                                    profit</div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="flex items-center space-x-3">
                            <a href="<?php echo e(route('plandetails', $plan->id)); ?>"
                                class="h-12 px-6 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 font-bold text-xs uppercase tracking-widest hover:bg-white/10 hover:text-white transition-all whitespace-nowrap">
                                Details
                            </a>
                            <?php if($plan->active == 'yes'): ?>
                                <button
                                    class="h-12 w-12 rounded-xl gold-gradient-bg flex items-center justify-center text-black hover:scale-105 transition-all shadow-lg shadow-yellow-500/10">
                                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Expanded Timeline Info -->
                <div
                    class="bg-black/40 px-8 py-3 flex items-center justify-between border-t border-white/5 text-[10px] font-bold text-slate-500">
                    <div class="flex items-center space-x-6">
                        <div class="flex items-center">
                            <i data-lucide="calendar-plus" class="w-3.5 h-3.5 mr-2 text-slate-600"></i>
                            Purchased: <?php echo e($plan->created_at->format('M d, Y')); ?>

                        </div>
                        <div class="flex items-center">
                            <i data-lucide="calendar-check" class="w-3.5 h-3.5 mr-2 text-slate-600"></i>
                            Ends on: <?php echo e(\Carbon\Carbon::parse($plan->expire_date)->format('M d, Y')); ?>

                        </div>
                        <div class="flex items-center">
                            <i data-lucide="hash" class="w-3.5 h-3.5 mr-2 text-slate-600"></i>
                            ID: #BIT-<?php echo e(str_pad($plan->id, 5, '0', STR_PAD_LEFT)); ?>

                        </div>
                    </div>
                    <div class="hidden sm:flex items-center text-slate-400">
                        Status: <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mx-2 animate-pulse"></span> Active
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <!-- Empty State -->
            <div class="dashboard-glass border-white/5 p-20 text-center">
                <div
                    class="h-24 w-24 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-8 border border-white/10">
                    <i data-lucide="layers" class="w-12 h-12 text-slate-500"></i>
                </div>
                <h2 class="text-2xl font-black text-white mb-3">No Active Plans</h2>
                <p class="text-slate-400 max-w-sm mx-auto mb-10 text-sm font-medium">You haven't purchased any investment plans
                    yet. Start investing to grow your money.</p>
                <a href="<?php echo e(route('mplans')); ?>"
                    class="inline-flex items-center px-10 py-4 rounded-xl gold-gradient-bg text-black font-black text-xs uppercase tracking-widest shadow-2xl shadow-yellow-500/30 hover:scale-105 transform transition-all">
                    Buy a Plan
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($plans->hasPages()): ?>
        <div class="flex justify-center pt-10">
            <?php echo e($plans->links('vendor.pagination.tailwind-custom')); ?>

        </div>
    <?php endif; ?>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/user/myplans.blade.php ENDPATH**/ ?>