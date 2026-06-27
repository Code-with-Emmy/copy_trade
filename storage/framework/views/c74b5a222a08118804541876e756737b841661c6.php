<?php $__env->startSection('title', 'Deposit'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000"
        x-data="{ amount: 0, setAmount(val) { this.amount = val; $refs.amountInput.focus(); } }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Add Money</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Deposit</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Deposit <span class="gold-text">Funds</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Add funds to your trading account.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400 mr-2"></i>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Secure
                        Connection</span>
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-10">
            <!-- Deposit Panel -->
            <div class="lg:col-span-8 space-y-6 xl:space-y-8">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 xl:p-10 relative overflow-hidden">
                    <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none">
                    </div>

                    <form method="POST" action="<?php echo e(route('newdeposit')); ?>" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="asset" value="BT">

                        <!-- Amount Selection -->
                        <div class="space-y-6">
                            <div class="flex items-center justify-between gap-4">
                                <label class="text-[10px] font-black text-slate-500 tracking-[0.12em] ml-1">
                                    Amount</label>
                                <span class="text-[10px] font-bold text-slate-600 tracking-[0.08em]">Available in
                                    <?php echo e(Auth::user()->currency); ?></span>
                            </div>

                            <div class="relative group rounded-2xl border border-white/10 focus-within:border-yellow-500/50 focus-within:ring-4 focus-within:ring-yellow-500/5 transition-all bg-black/50 overflow-hidden">
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xl font-black gold-text select-none pointer-events-none">
                                    <?php echo e(Auth::user()->currency); ?></div>
                                <input type="number" name="amount" x-model="amount" x-ref="amountInput" inputmode="decimal" autocomplete="off"
                                    class="w-full block bg-transparent border-0 py-5 pl-16 pr-44 text-2xl leading-[1.05] font-black text-white placeholder:text-slate-500 focus:outline-none focus:ring-0 transition-all appearance-none font-mono min-h-[72px]"
                                    placeholder="0.00" required step="0.01">
                            </div>

                            <!-- Quick Selectors -->
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                                <?php $__currentLoopData = [500, 1000, 5000, 10000]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qAmount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" @click="setAmount(<?php echo e($qAmount); ?>)"
                                        class="py-3 rounded-xl bg-white/5 border border-white/5 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:bg-white/10 hover:text-white hover:border-white/20 transition-all active:scale-95">
                                        <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($qAmount)); ?>

                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Method Selection -->
                        <div class="space-y-6">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Payment Method</label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <?php $__empty_1 = true; $__currentLoopData = $dmethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <label class="relative cursor-pointer group">
                                        <input type="radio" name="payment_method" value="<?php echo e($method->name); ?>"
                                            class="peer sr-only" <?php echo e($index == 0 ? 'checked' : ''); ?>>
                                        <div
                                            class="p-5 rounded-2xl bg-white/5 border border-white/5 peer-checked:border-yellow-500/50 peer-checked:bg-yellow-500/5 hover:bg-white/10 transition-all flex items-center space-x-4">
                                            <div
                                                class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                                                <i data-lucide="credit-card" class="w-5 h-5 gold-text"></i>
                                            </div>
                                            <div>
                                                <div class="text-xs font-black text-white uppercase tracking-wider">
                                                    <?php echo e($method->name); ?></div>
                                                <div class="text-[9px] font-bold text-slate-500 uppercase tracking-tighter">
                                                    Instant Processing</div>
                                            </div>
                                            <div class="ml-auto opacity-0 peer-checked:opacity-100 transition-opacity">
                                                <i data-lucide="check-circle-2" class="w-5 h-5 text-yellow-500"></i>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div
                                        class="col-span-full p-6 text-center text-slate-500 text-xs font-bold uppercase border border-dashed border-white/10 rounded-2xl">
                                        No payment methods available. Please contact support.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Submit -->
                        <button type="submit"
                            class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                            <i data-lucide="zap" class="w-5 h-5"></i>
                            <span>Deposit Funds</span>
                        </button>
                    </form>
                </div>

                <!-- Recent Deposits Mini-Table -->
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <div class="px-5 sm:px-8 py-5 border-b border-white/5 flex items-center justify-between gap-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Recent Deposits</h3>
                        <a href="<?php echo e(route('accounthistory')); ?>"
                            class="text-[9px] font-black text-yellow-500 uppercase tracking-widest hover:underline">View
                            All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-white/5 text-[9px] font-black text-slate-500 uppercase tracking-tighter">
                                <tr>
                                    <th class="px-5 sm:px-8 py-4">Transaction ID</th>
                                    <th class="px-4 sm:px-6 py-4 text-center">Amount</th>
                                    <th class="px-4 sm:px-6 py-4 text-center">Method</th>
                                    <th class="px-5 sm:px-6 py-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                <?php $__empty_1 = true; $__currentLoopData = $deposits->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="text-xs font-bold group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-5 sm:px-8 py-4 text-slate-400">#DEP-<?php echo e($deposit->id); ?></td>
                                        <td class="px-4 sm:px-6 py-4 text-center text-white">
                                            <?php echo e(Auth::user()->currency); ?><?php echo e(number_format($deposit->amount, 2)); ?></td>
                                        <td class="px-4 sm:px-6 py-4 text-center text-slate-500"><?php echo e($deposit->payment_mode); ?></td>
                                        <td class="px-5 sm:px-8 py-4 text-right">
                                            <?php if($deposit->status == 'Processed'): ?>
                                                <span class="text-emerald-400 text-[10px] uppercase">Completed</span>
                                            <?php else: ?>
                                                <span class="text-yellow-500 text-[10px] uppercase">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                            <td colspan="4"
                                                class="px-5 sm:px-8 py-10 text-center text-slate-600 text-[10px] uppercase font-black">
                                                No recent deposits found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Compliance & Info -->
            <div class="lg:col-span-4 space-y-5 sm:space-y-6">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 relative overflow-hidden group">
                    <div
                        class="absolute right-0 top-0 h-1 w-full bg-gradient-to-r from-transparent via-yellow-500/50 to-transparent">
                    </div>
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-6 flex items-center">
                        <i data-lucide="shield-alert" class="w-4 h-4 text-yellow-500 mr-2"></i>
                        Deposit Rules
                    </h3>
                    <ul class="space-y-6">
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center flex-shrink-0 text-[10px] font-black">
                                01</div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Processing Time</h4>
                                <p class="text-[9px] text-slate-500 font-medium leading-relaxed uppercase">Deposits usually process within a few minutes. Larger amounts may require manual review.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px] font-black">
                                02</div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Network Fees</h4>
                                <p class="text-[9px] text-slate-500 font-medium leading-relaxed uppercase">Network fees may apply based on the payment method used.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center flex-shrink-0 text-[10px] font-black">
                                03</div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Withdrawal Policy</h4>
                                <p class="text-[9px] text-slate-500 font-medium leading-relaxed uppercase">Deposited funds must be used for trading before they can be withdrawn.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="dashboard-glass border-white/5 p-6 sm:p-8 bg-gradient-to-br from-yellow-500/5 to-transparent">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                            <i data-lucide="headphones" class="w-5 h-5 gold-text"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-white uppercase tracking-tight">Need Help?</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-tighter">Support is online
                            </p>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 font-medium mb-6 leading-relaxed uppercase">If your deposit is missing after 15 minutes, please contact support.</p>
                    <a href="<?php echo e(route('support')); ?>"
                        class="flex items-center justify-center w-full py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-yellow-500 uppercase tracking-widest hover:bg-white/10 transition-all">
                        Contact Support
                    </a>
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

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/deposits.blade.php ENDPATH**/ ?>