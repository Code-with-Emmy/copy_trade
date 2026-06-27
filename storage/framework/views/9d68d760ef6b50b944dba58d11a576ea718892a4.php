
<?php $__env->startSection('title', 'Settlement Authorization'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000"
        x-data="{ showConfirmModal: false, amount: '', confirmArmed: false }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="<?php echo e(route('withdrawalsdeposits')); ?>" class="hover:text-yellow-500 transition-colors">Off-Ramp</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Authorization</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Finalize <span class="gold-text">Extraction</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Verify destination parameters and authorize the liquidity
                    release. </p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="shield-check" class="w-4 h-4 mr-2 text-emerald-500"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">End-to-End Encrypted</span>
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
            <!-- Authorization Form -->
            <div class="lg:col-span-8">
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <div class="px-5 sm:px-8 py-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div
                                class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center">
                                <i data-lucide="<?php echo e($payment_mode == 'Bitcoin' ? 'bitcoin' : ($payment_mode == 'Ethereum' ? 'zap' : ($payment_mode == 'USDT' ? 'circle-dollar-sign' : 'building-bank'))); ?>"
                                    class="w-5 h-5 gold-text"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-black text-white uppercase tracking-widest"><?php echo e($payment_mode); ?>

                                    Protocol</h3>
                                <p class="text-[9px] text-slate-500 font-bold uppercase">Settlement Channel Active</p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="<?php echo e(route('completewithdrawal')); ?>"
                        class="p-6 sm:p-8 xl:p-10 space-y-7 sm:space-y-8" id="withdrawalForm" x-ref="withdrawalForm"
                        @submit="if (!confirmArmed) { $event.preventDefault(); showConfirmModal = true; }">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="method" value="<?php echo e($payment_mode); ?>">

                        <div class="space-y-4">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Extraction
                                Quantum</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none text-slate-500 text-lg font-black">
                                    <?php echo e(Auth::user()->currency); ?></div>
                                <input type="number" name="amount" required min="1" x-model="amount"
                                    class="w-full bg-black/40 border border-white/10 rounded-2xl py-6 pl-14 pr-6 text-2xl font-black text-white focus:outline-none focus:border-yellow-500/50 transition-all placeholder:text-slate-700"
                                    placeholder="0.00">
                            </div>
                            <div class="flex items-center justify-between px-1">
                                <p class="text-[9px] font-black text-slate-600 uppercase">Available Liquidity</p>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider">
                                    <?php echo e(Auth::user()->currency); ?><?php echo e(number_format(Auth::user()->account_bal, 2)); ?></p>
                            </div>
                        </div>

                        <?php if(Auth::user()->sendotpemail == 'Yes'): ?>
                            <div class="space-y-4 rounded-2xl border border-amber-500/20 bg-amber-500/5 p-5 sm:p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <label class="text-[10px] font-black text-amber-300 uppercase tracking-widest ml-1">One-Time
                                            Authorization Code</label>
                                        <p class="text-[9px] text-slate-500 font-bold uppercase mt-2">Request the OTP to your registered
                                            email and enter it before authorizing withdrawal.</p>
                                    </div>
                                    <a href="<?php echo e(route('getotp')); ?>"
                                        class="shrink-0 h-10 px-4 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-slate-200 uppercase tracking-widest hover:bg-white/10 transition-all flex items-center">
                                        Send OTP
                                    </a>
                                </div>
                                <input type="text" name="otpcode" required
                                    class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white text-xs font-black uppercase tracking-[0.2em] focus:outline-none focus:border-yellow-500/30"
                                    placeholder="ENTER OTP CODE">
                            </div>
                        <?php endif; ?>

                        <?php if($payment_mode == "Bank Transfer"): ?>
                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 rounded-2xl bg-white/[0.02] border border-white/5">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Bank
                                        Identifier</label>
                                    <input type="text" name="bank_name" required
                                        class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white text-xs font-bold uppercase tracking-wider focus:outline-none focus:border-yellow-500/30">
                                </div>
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Beneficiary
                                        Name</label>
                                    <input type="text" name="account_name" required
                                        class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white text-xs font-bold uppercase tracking-wider focus:outline-none focus:border-yellow-500/30">
                                </div>
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Account/IBAN</label>
                                    <input type="text" name="account_no" required
                                        class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white text-xs font-bold uppercase tracking-wider focus:outline-none focus:border-yellow-500/30 font-mono">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">SWIFT /
                                        BIC</label>
                                    <input type="text" name="swift_code" required
                                        class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white text-xs font-bold uppercase tracking-wider focus:outline-none focus:border-yellow-500/30 font-mono">
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="space-y-4">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Destination
                                    <?php echo e($payment_mode); ?> Address</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                        <i data-lucide="link" class="w-4 h-4 text-slate-600"></i>
                                    </div>
                                    <input type="text" name="details" required
                                        class="w-full bg-black/40 border border-white/10 rounded-2xl py-5 pl-14 pr-6 text-sm font-mono text-white focus:outline-none focus:border-yellow-500/50 transition-all"
                                        placeholder="ENTER VALID ADDRESS FOR SETTLEMENT...">
                                </div>
                                <p class="text-[9px] text-rose-500/80 font-black uppercase tracking-widest italic ml-1">
                                    CRITICAL: VERIFY ADDRESS ACCURACY. INCORRECT PATHWAYS RESULT IN IRREVERSIBLE LOSS.</p>
                            </div>
                        <?php endif; ?>

                        <button type="submit"
                            class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.4em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3 mt-10">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                            <span>AUTHORIZE RELEASE</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Settlement Intel -->
            <div class="lg:col-span-4 space-y-5 sm:space-y-6">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-yellow-500/5 blur-3xl"></div>
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-8 border-b border-white/5 pb-4">
                        Settlement Policy</h3>

                    <ul class="space-y-6">
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-full bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                            </div>
                            <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Transactions are
                                processed through regional liquidity nodes for maximum speed.</p>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-full bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                            </div>
                            <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Standard protocol fee
                                of <span class="text-white"> <?php echo e(Auth::user()->currency); ?>5</span> is applied to each
                                extraction block.</p>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div
                                class="h-6 w-6 rounded-full bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                                <i data-lucide="check" class="w-3 h-3 text-emerald-500"></i>
                            </div>
                            <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Institutional
                                verification may be required for extractions exceeding $50,000.</p>
                        </li>
                    </ul>
                </div>

                <div class="dashboard-glass border-white/5 p-6 sm:p-8 text-center group">
                    <i data-lucide="lock"
                        class="w-8 h-8 gold-text mx-auto mb-4 group-hover:scale-110 transition-transform"></i>
                    <h4 class="text-[10px] font-black text-white uppercase tracking-widest mb-2">Immutable Verification</h4>
                    <p class="text-[9px] text-slate-600 font-bold uppercase leading-relaxed">Every extraction is recorded on
                        the private ledger for compliance auditing.</p>
                </div>
            </div>
        </div>

        <!-- Confirmation Overlay -->
        <div x-show="showConfirmModal" x-transition.opacity x-cloak @keydown.escape.window="showConfirmModal = false"
            class="fixed inset-0 z-50 flex items-center justify-center p-6 sm:p-0 bg-black/90 backdrop-blur-sm">
            <div @click.away="showConfirmModal = false"
                class="bg-black border border-white/10 rounded-3xl p-10 max-w-md w-full text-center relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-yellow-500/[0.02] pointer-events-none"></div>

                <div
                    class="h-20 w-20 rounded-full bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center mx-auto mb-8">
                    <i data-lucide="alert-triangle" class="w-10 h-10 gold-text"></i>
                </div>

                <h2 class="text-2xl font-black text-white mb-4 uppercase tracking-tight">Final <span
                        class="gold-text">Verification</span></h2>
                <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-10">
                    Confirm intentional extraction of <span class="text-white"><?php echo e(Auth::user()->currency); ?></span><span
                        class="text-white" x-text="amount"></span> to the authenticated destination address.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    <button @click="showConfirmModal = false"
                        class="h-14 rounded-xl bg-white/5 border border-white/10 text-slate-400 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                        Abort
                    </button>
                    <button @click="confirmArmed = true; showConfirmModal = false; $nextTick(() => $refs.withdrawalForm.requestSubmit());"
                        class="h-14 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/20">
                        Authorize
                    </button>
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

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/withdraw.blade.php ENDPATH**/ ?>