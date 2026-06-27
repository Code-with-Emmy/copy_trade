
<?php $__env->startSection('title', 'Profile Details'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-fadeIn" x-data="{ activeTab: 'per' }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Profile</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Profile <span class="gold-text">Interface</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Update your account information and security settings.
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-white/5 border border-white/10 text-slate-400">
                    <i data-lucide="shield" class="w-4 h-4 mr-2 text-yellow-500"></i>
                    <span class="text-[10px] font-black uppercase tracking-widest">Account Secure</span>
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
            <!-- Profile Panel -->
            <div class="lg:col-span-8 space-y-6 xl:space-y-8">
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <!-- Identity Banner -->
                    <div class="h-32 bg-gradient-to-r from-yellow-500/20 to-amber-600/20 relative overflow-hidden">
                        <div class="absolute inset-0 bg-pattern opacity-10"></div>
                    </div>

                    <div class="px-5 sm:px-8 pb-8 sm:pb-10 -mt-12 relative">
                        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 sm:gap-6">
                            <div class="flex items-end space-x-4 sm:space-x-6">
                                <div
                                    class="h-32 w-32 rounded-3xl bg-black border-4 border-[#0f172a] overflow-hidden shadow-2xl relative group">
                                    <img src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->name); ?>"
                                        class="h-full w-full object-cover">
                                    <div
                                        class="absolute inset-0 bg-black/60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all cursor-pointer">
                                        <i data-lucide="camera" class="w-6 h-6 gold-text"></i>
                                    </div>
                                </div>
                                <div class="pb-2">
                                    <h2 class="text-2xl font-black text-white uppercase tracking-tight">
                                        <?php echo e(Auth::user()->name); ?>

                                    </h2>
                                    <div
                                        class="flex items-center space-x-2 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                                        <i data-lucide="mail" class="w-3 h-3"></i>
                                        <span><?php echo e(Auth::user()->email); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center p-1 bg-black/40 border border-white/10 rounded-xl">
                                <button @click="activeTab = 'per'"
                                    :class="activeTab === 'per' ? 'bg-white text-black shadow-xl' : 'text-slate-500 hover:text-white'"
                                    class="px-5 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                    Information
                                </button>
                                <button @click="activeTab = 'pas'"
                                    :class="activeTab === 'pas' ? 'bg-white text-black shadow-xl' : 'text-slate-500 hover:text-white'"
                                    class="px-5 py-2 rounded-lg text-[9px] font-black uppercase tracking-widest transition-all">
                                    Security
                                </button>
                            </div>
                        </div>

                        <!-- Forms -->
                        <div class="mt-10 sm:mt-12">
                            <div x-show="activeTab === 'per'" x-transition.opacity>
                                <div class="p-5 sm:p-6 rounded-2xl bg-white/[0.02] border border-white/5 mb-6 sm:mb-8">
                                    <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed">
                                        <i data-lucide="info" class="w-3 h-3 inline-block mr-2 text-yellow-500"></i>
                                        Any changes to your profile may take a few moments to update and may require review.
                                    </p>
                                </div>
                                <?php echo $__env->make('profile.update-profile-information-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>

                            <div x-show="activeTab === 'pas'" x-transition.opacity>
                                <div class="p-5 sm:p-6 rounded-2xl bg-white/[0.02] border border-white/5 mb-6 sm:mb-8">
                                    <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed">
                                        <i data-lucide="shield" class="w-3 h-3 inline-block mr-2 text-rose-500"></i>
                                        Security notice: Changing your password will secure your account across all devices.
                                    </p>
                                </div>
                                <?php echo $__env->make('profile.update-password-form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Ledger -->
                <div class="dashboard-glass border-white/5 p-6 sm:p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xs font-black text-white uppercase tracking-widest">Recent Logins</h3>
                        <span class="text-[9px] font-black text-slate-500 uppercase">Live</span>
                    </div>

                    <div class="space-y-4">
                        <div
                            class="flex items-center justify-between p-4 rounded-xl bg-white/[0.02] border border-white/5 group hover:border-white/10 transition-all">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="h-10 w-10 rounded-lg bg-black border border-white/10 flex items-center justify-center">
                                    <i data-lucide="log-in" class="w-4 h-4 text-emerald-400"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-white uppercase">Login Recorded</div>
                                    <div class="text-[9px] font-bold text-slate-600 uppercase">IP Address:
                                        <?php echo e(request()->ip()); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[9px] font-black text-slate-500 uppercase">
                                    <?php echo e(\Carbon\Carbon::now()->format('H:i')); ?> UTC
                                </div>
                                <div class="text-[8px] font-bold text-emerald-500 uppercase">Successful</div>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between p-4 rounded-xl bg-white/[0.02] border border-white/5 group hover:border-white/10 transition-all">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="h-10 w-10 rounded-lg bg-black border border-white/10 flex items-center justify-center">
                                    <i data-lucide="refresh-cw" class="w-4 h-4 text-blue-400"></i>
                                </div>
                                <div>
                                    <div class="text-[10px] font-black text-white uppercase">Profile Updated</div>
                                    <div class="text-[9px] font-bold text-slate-600 uppercase">Information saved
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-[9px] font-black text-slate-500 uppercase">
                                    <?php echo e(Auth::user()->updated_at->format('H:i')); ?> UTC
                                </div>
                                <div class="text-[8px] font-bold text-blue-400 uppercase">Success</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Intelligence -->
            <div class="lg:col-span-4 space-y-5 sm:space-y-6">
                <div class="dashboard-glass border-white/5 p-6 sm:p-8 overflow-hidden relative group">
                    <div
                        class="absolute -right-10 -bottom-10 w-32 h-32 bg-yellow-500/5 blur-3xl group-hover:bg-yellow-500/10 transition-all">
                    </div>
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-8 border-b border-white/5 pb-4">
                        Security Overview</h3>

                    <div class="space-y-6 sm:space-y-8">
                        <div class="flex items-center justify-between">
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Security Level
                            </div>
                            <div class="text-[10px] font-black gold-text uppercase">High</div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Two-Factor Auth
                            </div>
                            <?php if(Auth::user()->two_factor_secret): ?>
                                <div class="text-[10px] font-black text-emerald-400 uppercase">Enabled</div>
                            <?php else: ?>
                                <div class="text-[10px] font-black text-rose-500 uppercase">Disabled</div>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Account Status</div>
                            <div class="text-[10px] font-black text-emerald-400 uppercase">Verified</div>
                        </div>
                    </div>

                    <div class="mt-10 p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10">
                        <h4 class="text-[10px] font-black text-yellow-500 uppercase mb-2">Security Tip</h4>
                        <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Keep your profile
                            information up to date to ensure fast withdrawals and account support.</p>
                    </div>
                </div>

                <div class="dashboard-glass border-white/5 p-6 sm:p-8 overflow-hidden relative group">
                    <div class="flex items-center space-x-4 mb-6 relative">
                        <div class="h-10 w-10 rounded-xl bg-black border border-white/10 flex items-center justify-center">
                            <i data-lucide="help-circle" class="w-5 h-5 gold-text"></i>
                        </div>
                        <h4 class="text-xs font-black text-white uppercase tracking-tight">Access Issues?</h4>
                    </div>
                    <p class="text-[9px] text-slate-500 font-medium uppercase leading-relaxed mb-6">If you notice
                        any suspicious changes to your account, please change your password and contact support immediately.
                    </p>
                    <a href="<?php echo e(route('support')); ?>"
                        class="block w-full text-center py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-slate-300 uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
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

<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/profile.blade.php ENDPATH**/ ?>