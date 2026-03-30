<?php $__env->startSection('title', 'Investment Strategies'); ?>
<?php $__env->startSection('content'); ?>

<div class="space-y-10 animate-fadeIn" x-data="{ selectedPlanId: null }">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Console</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-300">Investment Plans</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Strategy <span class="gold-text">Marketplace</span></h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Deploy capitol into high-performance institutional algorithms.</p>
        </div>

        <div class="flex items-center space-x-4">
            <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10">
                <span class="h-2 w-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Market Status: Aggressive</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
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

    <!-- Investment Plans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="dashboard-glass border-white/5 hover:border-yellow-500/20 transition-all group relative overflow-hidden flex flex-col h-full"
                 :class="selectedPlanId === <?php echo e($plan->id); ?> ? 'border-yellow-500/50 shadow-[0_0_30px_rgba(240,185,10,0.1)]' : ''">
                
                <!-- Strategy Background Glow -->
                <div class="absolute -right-16 -top-16 w-48 h-48 bg-yellow-500/5 blur-[80px] pointer-events-none group-hover:bg-yellow-500/10 transition-all duration-700"></div>

                <!-- ROI Badge -->
                <div class="absolute top-6 right-6">
                    <div class="px-3 py-1.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center space-x-2">
                        <i data-lucide="trending-up" class="w-3.5 h-3.5 text-emerald-400"></i>
                        <span class="text-[10px] font-black text-emerald-400 uppercase tracking-tighter">+<?php echo e($plan->increment_amount); ?>% <?php echo e($plan->increment_interval); ?></span>
                    </div>
                </div>

                <!-- Plan Content -->
                <div class="p-8 flex-1">
                    <div class="h-14 w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center mb-6 group-hover:border-yellow-500/30 transition-colors">
                        <i data-lucide="shield-check" class="w-7 h-7 gold-text"></i>
                    </div>

                    <h3 class="text-2xl font-black text-white mb-2"><?php echo e($plan->name); ?></h3>
                    <p class="text-slate-400 text-xs font-medium mb-8 leading-relaxed">
                        Advanced algorithmic execution model focused on <?php echo e(strtolower($plan->name)); ?> market dynamics and volatility harvesting.
                    </p>

                    <!-- Features List -->
                    <div class="space-y-4 mb-10">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Entry Barrier</span>
                            <span class="text-white font-black"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->min_price, 2)); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Limit Cap</span>
                            <span class="text-white font-black"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($plan->max_price, 2)); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Duration Cycle</span>
                            <span class="text-white font-black"><?php echo e($plan->expiration); ?></span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-bold uppercase tracking-widest">Risk Guard</span>
                            <span class="text-emerald-400 font-black">Active - Tier 1</span>
                        </div>
                    </div>

                    <!-- Investment Modal Part -->
                    <form method="post" action="<?php echo e(route('joininvestmentplan')); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div x-data="{ amount: <?php echo e($plan->min_price); ?> }">
                            <div class="relative group">
                                <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-2 block ml-1">Allocation Amount (<?php echo e(Auth::user()->currency); ?>)</label>
                                <div class="bg-black/50 border border-white/10 rounded-xl p-1 focus-within:border-yellow-500/50 transition-all">
                                    <input type="number" name="iamount" x-model="amount" 
                                           min="<?php echo e($plan->min_price); ?>" max="<?php echo e($plan->max_price); ?>"
                                           @focus="selectedPlanId = <?php echo e($plan->id); ?>"
                                           class="w-full bg-transparent border-none text-white font-black font-mono text-lg py-3 px-4 focus:ring-0 placeholder:text-slate-700" 
                                           placeholder="0.00">
                                </div>
                                <div class="flex justify-between mt-2 px-1 text-[9px] font-bold text-slate-600 uppercase tracking-tighter">
                                    <span>Min: <?php echo e(number_format($plan->min_price)); ?></span>
                                    <span>Max: <?php echo e(number_format($plan->max_price)); ?></span>
                                </div>
                            </div>
                            
                            <input type="hidden" name="duration" value="<?php echo e($plan->expiration); ?>">
                            <input type="hidden" name="id" value="<?php echo e($plan->id); ?>">

                            <button type="submit" 
                                    class="w-full mt-6 h-14 rounded-xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-2">
                                <i data-lucide="zap" class="w-4 h-4"></i>
                                <span>Initialize Allocation</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer Stats -->
                <div class="bg-black/40 px-8 py-4 border-t border-white/5 flex items-center justify-between text-[10px] font-black tracking-widest text-slate-500">
                    <span class="uppercase">Hedge Grade</span>
                    <div class="flex items-center space-x-1">
                        <?php $__currentLoopData = range(1,5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="h-1 w-3 rounded-full <?php echo e($i <= 4 ? 'bg-yellow-500' : 'bg-white/10'); ?>"></div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full dashboard-glass p-20 text-center border-white/5">
                <i data-lucide="package-search" class="w-16 h-16 text-slate-600 mx-auto mb-6"></i>
                <h3 class="text-xl font-black text-white mb-2 uppercase tracking-wide">Strategies Offline</h3>
                <p class="text-slate-400 text-sm font-medium">Investment modules are currently undergoing maintenance. Check back shortly.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Strategy Comparison Guide -->
    <div class="dashboard-glass p-8 border-white/5 relative overflow-hidden group">
        <div class="absolute right-0 top-0 bottom-0 w-1/3 bg-gradient-to-l from-yellow-500/5 to-transparent pointer-events-none"></div>
        
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10">
            <div class="max-w-xl">
                <div class="flex items-center space-x-2 text-yellow-500 text-[10px] font-black uppercase tracking-widest mb-4">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Allocation Guide</span>
                </div>
                <h2 class="text-3xl font-black text-white mb-4 italic tracking-tight underline decoration-yellow-500 decoration-4 underline-offset-8">Risk <span class="gold-text">Mitigation</span> Protocol</h2>
                <p class="text-slate-400 text-sm font-medium leading-relaxed">
                    Our multi-node execution architecture ensures your capital is protected by institutional-grade liquidity filters. Diversification across multiple strategies is recommended for optimal yield stability.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-6 flex-shrink-0">
                <div class="p-4 rounded-xl bg-white/5 border border-white/10 group-hover:border-white/20 transition-all">
                    <i data-lucide="shield" class="w-6 h-6 text-emerald-400 mb-3"></i>
                    <h4 class="text-[10px] font-black text-white uppercase mb-1">Total Coverage</h4>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-tighter">Zero-Loss Buffer</p>
                </div>
                <div class="p-4 rounded-xl bg-white/5 border border-white/10 group-hover:border-white/20 transition-all">
                    <i data-lucide="clock" class="w-6 h-6 text-blue-400 mb-3"></i>
                    <h4 class="text-[10px] font-black text-white uppercase mb-1">Instant Exit</h4>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-tighter">Cycle Maturity</p>
                </div>
                <div class="p-4 rounded-xl bg-white/5 border border-white/10 group-hover:border-white/20 transition-all">
                    <i data-lucide="globe" class="w-6 h-6 text-purple-400 mb-3"></i>
                    <h4 class="text-[10px] font-black text-white uppercase mb-1">Global Node</h4>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-tighter">24/7 Deployment</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/user/mplans.blade.php ENDPATH**/ ?>