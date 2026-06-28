<?php $__env->startSection('title', 'Investment Plans'); ?>

<?php $__env->startSection('content'); ?>
    <?php
        $activePlansCount = $activePlansCount ?? $plans->where('is_active', true)->count();
        $featuredPlansCount = $featuredPlansCount ?? $plans->where('is_featured', true)->count();
        $averageRoi = $averageRoi ?? (float) $plans->avg('roi_percentage');
    ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Investment Products</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Plan <span class="gold-text">Library</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Manage the investment products shown to clients, adjust pricing windows, and control which offers are active or featured.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="<?php echo e(route('admin.plans.categories')); ?>"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="layers-3" class="mr-2 h-4 w-4"></i>
                    Categories
                </a>
                <a href="<?php echo e(route('admin.plans.create')); ?>"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    Add Plan
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Plans</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white"><?php echo e(number_format($plans->count())); ?></h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Published investment products</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active Offers</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text"><?php echo e(number_format($activePlansCount)); ?></h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-emerald-400">Visible for new subscriptions</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Featured Plans</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white"><?php echo e(number_format($featuredPlansCount)); ?></h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Promoted on the frontend</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Average ROI</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white"><?php echo e(number_format($averageRoi, 2)); ?>%</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Across current plan catalog</p>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-white/5 bg-white/[0.02] p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Plan Inventory</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Pricing windows, ROI cadence, publication status, and quick actions</p>
                </div>
                <div class="rounded-2xl border border-white/5 bg-black/30 px-4 py-3 text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Featured Coverage</p>
                    <p class="mt-1 text-sm font-bold text-white"><?php echo e($plans->count() > 0 ? number_format(($featuredPlansCount / $plans->count()) * 100, 0) : 0); ?>% of catalog highlighted</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 text-sm">
                    <thead class="bg-black/20">
                        <tr class="text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <th class="px-6 py-4">Plan</th>
                            <th class="px-6 py-4">Category</th>
                            <th class="px-6 py-4">Price Range</th>
                            <th class="px-6 py-4">ROI</th>
                            <th class="px-6 py-4">Duration</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Featured</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition-colors hover:bg-white/[0.03]">
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center gap-3">
                                        <?php if($plan->icon): ?>
                                            <img src="<?php echo e(asset('storage/' . $plan->icon)); ?>" alt="<?php echo e($plan->name); ?>" class="h-11 w-11 rounded-2xl border border-white/10 object-cover">
                                        <?php else: ?>
                                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                                                <i data-lucide="briefcase" class="h-5 w-5 text-slate-500"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <p class="font-bold text-white"><?php echo e($plan->name); ?></p>
                                            <p class="text-xs text-slate-400"><?php echo e($plan->roi_interval); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top text-slate-300"><?php echo e(optional($plan->category)->name ?? 'No Category'); ?></td>
                                <td class="px-6 py-4 align-top text-slate-300">
                                    <?php echo e($settings->currency); ?><?php echo e(number_format((float) $plan->min_amount, 2)); ?>

                                    <span class="text-slate-600">to</span>
                                    <?php echo e($settings->currency); ?><?php echo e(number_format((float) $plan->max_amount, 2)); ?>

                                </td>
                                <td class="px-6 py-4 align-top font-black text-white"><?php echo e(number_format((float) $plan->roi_percentage, 2)); ?>%</td>
                                <td class="px-6 py-4 align-top text-slate-300"><?php echo e($plan->duration); ?> <?php echo e($plan->duration_unit); ?></td>
                                <td class="px-6 py-4 align-top">
                                    <form action="<?php echo e(route('admin.plans.toggle', $plan)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit"
                                            class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest <?php echo e($plan->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-300'); ?>">
                                            <?php echo e($plan->is_active ? 'Active' : 'Inactive'); ?>

                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest <?php echo e($plan->is_featured ? 'bg-yellow-500/10 text-yellow-400' : 'bg-white/5 text-slate-400'); ?>">
                                        <?php echo e($plan->is_featured ? 'Featured' : 'Standard'); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <a href="<?php echo e(route('admin.plans.edit', $plan)); ?>"
                                            class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                            Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.plans.destroy', $plan)); ?>" method="POST" onsubmit="return confirm('Delete this plan?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/5">
                                            <i data-lucide="briefcase" class="h-6 w-6 text-slate-500"></i>
                                        </div>
                                        <p class="mt-4 text-sm font-bold text-white">No investment plans created yet.</p>
                                        <p class="mt-2 text-xs text-slate-500">Create the first plan to start offering managed investment products to users.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/admin/plans/index.blade.php ENDPATH**/ ?>