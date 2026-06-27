
<?php $__env->startSection('title', 'Withdrawal'); ?>
<?php $__env->startSection('content'); ?>

<div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="{ selectedMethod: '' }">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
        <div>
            <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-300">Withdrawal</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Withdraw <span class="gold-text">Funds</span></h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Withdraw your funds to an external account or wallet.</p>
        </div>

        <div class="flex items-center space-x-3">
             <div class="flex items-center px-4 py-2 rounded-xl bg-slate-500/5 border border-white/10 text-slate-400">
                <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                <span class="text-[10px] font-black uppercase tracking-widest">Avg. Processing: 2.4 Hours</span>
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
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.error-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('error-alert'); ?>
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

    <?php if(Auth::user()->withdrawal_code === 'on'): ?>
        <!-- Specialized Security Lock -->
        <div class="max-w-3xl mx-auto">
            <div class="dashboard-glass border-rose-500/20 p-6 sm:p-10 relative overflow-hidden text-center">
                <div class="absolute inset-0 bg-rose-500/[0.02] pointer-events-none"></div>
                <div class="h-20 w-20 rounded-full bg-rose-500/10 border border-rose-500/20 flex items-center justify-center mx-auto mb-8 animate-pulse">
                    <i data-lucide="lock" class="w-10 h-10 text-rose-500"></i>
                </div>
                
                <h2 class="text-2xl font-black text-white mb-4 uppercase tracking-tight">Account <span class="text-rose-500">Locked</span></h2>
                <p class="text-slate-400 text-sm font-medium mb-10 max-w-md mx-auto leading-relaxed">
                    For your security, a verification code is required to withdraw funds.
                </p>

                <form action="<?php echo e(route('userwithdrawal')); ?>" method="post" class="space-y-6 max-w-sm mx-auto">
                    <?php echo csrf_field(); ?>
                    <div class="relative group">
                        <input type="text" name="withdrawal_code" required
                               class="w-full bg-black/50 border border-white/10 rounded-2xl py-5 px-6 text-center text-xl font-black text-white focus:outline-none focus:border-yellow-500/50 transition-all font-mono tracking-[0.5em]"
                               placeholder="CODE-XXXX">
                    </div>
                    
                    <button type="submit" class="w-full h-14 rounded-xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] flex items-center justify-center space-x-2 shadow-2xl shadow-yellow-500/20">
                        <i data-lucide="shield-check" class="w-4 h-4"></i>
                        <span>Unlock Account</span>
                    </button>
                    
                    <a href="<?php echo e(route('support')); ?>" class="block text-[10px] font-black text-slate-500 uppercase tracking-widest hover:text-yellow-500 transition-colors pt-4">
                        Request Verification Code
                    </a>
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-10">
            <!-- Withdraw Funds -->
            <div class="lg:col-span-8 space-y-6 xl:space-y-8">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 xl:p-10">
                    <form method="POST" action="<?php echo e(route('withdrawamount')); ?>" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        
                        <div class="space-y-6">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Withdrawal Method</label>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php $__empty_1 = true; $__currentLoopData = $wmethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="method" value="<?php echo e($method->name); ?>" class="peer sr-only" x-model="selectedMethod" required>
                                        <div class="p-5 sm:p-6 rounded-2xl bg-white/5 border border-white/5 peer-checked:border-yellow-500/50 peer-checked:bg-yellow-500/10 hover:bg-white/10 transition-all flex items-center space-x-4">
                                            <div class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i data-lucide="<?php echo e(str_contains(strtolower($method->name), 'bitcoin') ? 'bitcoin' : (str_contains(strtolower($method->name), 'bank') ? 'building-bank' : 'credit-card')); ?>" class="w-6 h-6 gold-text"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs font-black text-white uppercase tracking-wider"><?php echo e($method->name); ?></div>
                                                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Secure Withdrawal</div>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="col-span-full p-10 text-center border-2 border-dashed border-white/5 rounded-2xl">
                                        <p class="text-slate-500 text-xs font-black uppercase tracking-widest">No withdrawal methods available.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Proceed Button -->
                        <button type="submit" x-show="selectedMethod" x-transition.opacity
                                class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                            <i data-lucide="arrow-right-circle" class="w-5 h-5"></i>
                            <span>Continue</span>
                        </button>
                    </form>
                </div>

                <!-- History Table -->
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <div class="px-5 sm:px-8 py-5 border-b border-white/5 bg-white/5">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Withdrawal History</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-black/20 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                                <tr>
                                    <th class="px-5 sm:px-8 py-4">Transaction ID</th>
                                    <th class="px-4 sm:px-6 py-4 text-center">Amount</th>
                                    <th class="px-4 sm:px-6 py-4 text-center">Method</th>
                                    <th class="px-5 sm:px-8 py-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="text-xs font-bold group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 sm:px-8 py-5 text-slate-400 flex items-center">
                                            <div class="w-2 h-2 rounded-full mr-3 <?php echo e($withdrawal->status == 'Processed' ? 'bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]' : 'bg-yellow-500'); ?>"></div>
                                            #TX-<?php echo e(str_pad($withdrawal->id, 6, '0', STR_PAD_LEFT)); ?>

                                        </td>
                                        <td class="px-4 sm:px-6 py-5 text-center text-white"><?php echo e(Auth::user()->currency); ?><?php echo e(number_format($withdrawal->amount, 2)); ?></td>
                                        <td class="px-4 sm:px-6 py-5 text-center">
                                            <span class="px-2 py-1 rounded-md bg-white/5 text-slate-400 text-[9px] uppercase tracking-tighter border border-white/5"><?php echo e($withdrawal->payment_mode); ?></span>
                                        </td>
                                        <td class="px-5 sm:px-8 py-5 text-right">
                                            <?php if($withdrawal->status == 'Processed'): ?>
                                                <span class="text-emerald-400 text-[10px] font-black uppercase tracking-widest">Completed</span>
                                            <?php elseif($withdrawal->status == 'Rejected'): ?>
                                                <span class="text-rose-400 text-[10px] font-black uppercase tracking-widest">Rejected</span>
                                            <?php else: ?>
                                                <span class="text-yellow-500 text-[10px] font-black uppercase tracking-widest">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-5 sm:px-8 py-16 text-center text-slate-600 text-[10px] uppercase font-black">No withdrawals found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Side Intel -->
            <div class="lg:col-span-4 space-y-5 sm:space-y-6">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8">
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6">Withdrawal Policy</h3>
                    <div class="space-y-6">
                        <div class="p-4 rounded-xl bg-blue-500/5 border border-blue-500/10">
                            <h4 class="text-[10px] font-black text-blue-400 uppercase mb-2">Pending Investments</h4>
                            <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Ensure all active investments are completed before withdrawing your full balance.</p>
                        </div>
                        <div class="p-4 rounded-xl bg-purple-500/5 border border-purple-500/10">
                            <h4 class="text-[10px] font-black text-purple-400 uppercase mb-2">Minimum Balance</h4>
                            <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">We recommend keeping a small balance in your account to keep it active.</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass border-white/5 p-6 sm:p-8 overflow-hidden relative group">
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px]"></div>
                    <div class="flex items-center space-x-4 mb-6 relative">
                        <div class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center">
                            <i data-lucide="help-circle" class="w-5 h-5 gold-text"></i>
                        </div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Need Support?</h4>
                    </div>
                    <p class="text-[9px] text-slate-500 font-medium uppercase leading-relaxed mb-6">Our support team is available 24/7 to help you with your withdrawals.</p>
                    <a href="<?php echo e(route('support')); ?>" class="block w-full text-center py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-slate-300 uppercase tracking-widest hover:bg-yellow-500 hover:text-black transition-all">
                        Contact Support
                    </a>
                </div>
            </div>
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

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/withdrawals.blade.php ENDPATH**/ ?>