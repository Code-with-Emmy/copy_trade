<?php $__env->startSection('title', 'Identity Registry'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000"
        x-data="{ showDetailedProtocol: false, showStatusModal: <?php echo e(in_array(Auth::user()->account_verify, ['Verified', 'Under review']) ? 'true' : 'false'); ?> }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Verification Status</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Account <span
                        class="gold-text">Verification</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Verify your identity to unlock all features of your
                    account.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="shield" class="w-4 h-4 mr-2 text-yellow-500"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Identity Verification</span>
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

        <!-- Main Verification Gateway -->
        <div class="max-w-4xl mx-auto">
            <div class="dashboard-glass border-white/5 overflow-hidden relative group">
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-yellow-500/[0.03] blur-[100px] group-hover:bg-yellow-500/[0.05] transition-all duration-1000">
                </div>

                <div class="p-10 md:p-16 text-center relative z-10">
                    <!-- Protocol Icon -->
                    <div
                        class="h-24 w-24 rounded-[32px] bg-black border border-white/10 shadow-2xl flex items-center justify-center mx-auto mb-10 relative">
                        <div class="absolute inset-0 bg-yellow-500/5 blur-xl animate-pulse"></div>
                        <i data-lucide="fingerprint" class="w-12 h-12 gold-text"></i>
                    </div>

                    <?php if(Auth::user()->account_verify == 'Verified'): ?>
                        <h2 class="text-3xl font-black text-white uppercase italic tracking-tight mb-4">Identity <span
                                class="text-emerald-400">Verified</span></h2>
                        <p
                            class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mb-12 max-w-sm mx-auto leading-relaxed">
                            Your identity has been successfully verified.
                        </p>

                        <div
                            class="inline-flex items-center space-x-3 px-8 py-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-black text-[10px] uppercase tracking-[0.3em]">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            <span>Full Account Access Enabled</span>
                        </div>
                    <?php elseif(Auth::user()->account_verify == 'Under review'): ?>
                        <h2 class="text-3xl font-black text-white uppercase italic tracking-tight mb-4">Verification <span
                                class="text-yellow-500">Pending</span></h2>
                        <p
                            class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mb-12 max-w-sm mx-auto leading-relaxed">
                            Our team is currently reviewing your identity documents. This typically takes
                            2-6 hours.
                        </p>

                        <div
                            class="inline-flex items-center space-x-3 px-8 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-400 font-black text-[10px] uppercase tracking-[0.3em] animate-pulse">
                            <i data-lucide="refresh-cw" class="w-4 h-4 animate-spin text-yellow-500"></i>
                            <span>Reviewing Documents...</span>
                        </div>
                    <?php else: ?>
                        <h2 class="text-3xl font-black text-white uppercase italic tracking-tight mb-4">Account <span
                                class="gold-text">Verification</span></h2>
                        <p
                            class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mb-12 max-w-md mx-auto leading-relaxed">
                            To comply with regulations, please verify your identity to continue using the platform.
                        </p>

                        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                            <a href="<?php echo e(route('kycform')); ?>"
                                class="h-16 px-10 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.05] transform transition-all flex items-center justify-center space-x-3">
                                <span>Start Verification</span>
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>

                            <button @click="showDetailedProtocol = !showDetailedProtocol"
                                class="h-16 px-10 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-xs uppercase tracking-[0.3em] hover:bg-white/10 transition-all">
                                View Requirements
                            </button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Footer Stats -->
                <div class="bg-black/40 border-t border-white/5 px-10 py-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-5 h-5 text-emerald-400"></i>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-600 uppercase">Encryption</div>
                            <div class="text-[10px] font-black text-white uppercase">AES-256 GCM</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center">
                            <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-600 uppercase">Latency</div>
                            <div class="text-[10px] font-black text-white uppercase">2-6 Std Hours</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center">
                            <i data-lucide="globe" class="w-5 h-5 text-yellow-500"></i>
                        </div>
                        <div>
                            <div class="text-[9px] font-black text-slate-600 uppercase">Compliance</div>
                            <div class="text-[10px] font-black text-white uppercase">Global Grade</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Protocol Info -->
            <div x-show="showDetailedProtocol" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="mt-10 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="dashboard-glass border-white/5 p-8">
                        <h4 class="text-[10px] font-black text-yellow-500 uppercase tracking-widest mb-4">Verification
                            Process
                        </h4>
                        <p class="text-[11px] text-slate-500 font-bold uppercase leading-relaxed">Identity verification
                            ensures that your withdrawals are secure and prevents unauthorized access to your account.</p>
                    </div>
                    <div class="dashboard-glass border-white/5 p-8">
                        <h4 class="text-[10px] font-black text-blue-400 uppercase tracking-widest mb-4">Required Documents
                        </h4>
                        <ul class="space-y-2 text-[10px] font-bold text-slate-400 uppercase">
                            <li class="flex items-center"><i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i>
                                Government Issued ID Card</li>
                            <li class="flex items-center"><i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i>
                                International Passport</li>
                            <li class="flex items-center"><i data-lucide="check" class="w-3 h-3 mr-2 text-emerald-500"></i>
                                Driver's License</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Section -->
        <div class="max-w-4xl mx-auto mt-20">
            <div class="flex items-center justify-between p-8 rounded-3xl bg-white/[0.02] border border-white/5">
                <div class="flex items-center space-x-6">
                    <div class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center">
                        <i data-lucide="help-circle" class="w-6 h-6 gold-text"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-white uppercase tracking-wider mb-1">Assistance Required?</h4>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Contact support if you
                            need help with verification.</p>
                    </div>
                </div>
                <a href="<?php echo e(route('support')); ?>"
                    class="px-8 py-3 rounded-xl bg-white/5 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">Support
                    Desk</a>
            </div>
        </div>

        <!-- Verification Status Modal -->
        <div x-show="showStatusModal" x-cloak x-transition.opacity
            class="fixed inset-0 z-[120] bg-black/80 backdrop-blur-sm flex items-center justify-center p-4 sm:p-6">
            <div @click.away="showStatusModal = false" x-show="showStatusModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-6"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="w-full max-w-lg rounded-3xl border border-white/10 bg-[#090b10] shadow-2xl shadow-black/70 overflow-hidden">
                <div class="px-6 sm:px-8 py-6 border-b border-white/5 flex items-center justify-between">
                    <h3 class="text-xs font-black uppercase tracking-[0.22em] text-slate-300">Verification Status</h3>
                    <button type="button" @click="showStatusModal = false"
                        class="h-8 w-8 rounded-lg border border-white/10 bg-white/5 text-slate-400 hover:text-white transition-all">
                        <i data-lucide="x" class="w-4 h-4 mx-auto"></i>
                    </button>
                </div>

                <div class="px-6 sm:px-8 py-8 text-center">
                    <?php if(Auth::user()->account_verify == 'Verified'): ?>
                        <div
                            class="h-16 w-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="shield-check" class="w-8 h-8 text-emerald-400"></i>
                        </div>
                        <h4 class="text-2xl font-black text-white uppercase tracking-tight mb-2">Verification Complete</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Your KYC verification was approved. All account features are unlocked.
                        </p>
                    <?php elseif(Auth::user()->account_verify == 'Under review'): ?>
                        <div
                            class="h-16 w-16 rounded-2xl bg-yellow-500/10 border border-yellow-500/30 flex items-center justify-center mx-auto mb-5">
                            <i data-lucide="clock-3" class="w-8 h-8 text-yellow-400"></i>
                        </div>
                        <h4 class="text-2xl font-black text-white uppercase tracking-tight mb-2">Verification Pending</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            Your submitted documents are under review. You will be notified once the review is complete.
                        </p>
                    <?php endif; ?>
                </div>

                <div class="px-6 sm:px-8 pb-8 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <button type="button" @click="showStatusModal = false"
                        class="h-12 rounded-xl border border-white/10 bg-white/5 text-slate-300 text-[10px] font-black uppercase tracking-[0.2em] hover:bg-white/10 transition-all">
                        Close
                    </button>
                    <a href="<?php echo e(route('dashboard')); ?>"
                        class="h-12 rounded-xl gold-gradient-bg text-black text-[10px] font-black uppercase tracking-[0.2em] flex items-center justify-center hover:scale-[1.01] transition-all">
                        Back To Dashboard
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

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/verify.blade.php ENDPATH**/ ?>