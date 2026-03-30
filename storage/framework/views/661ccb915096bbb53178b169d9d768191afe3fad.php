<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-sm text-slate-400">
            Showing
            <span class="font-semibold text-white"><?php echo e($paginator->firstItem()); ?></span>
            to
            <span class="font-semibold text-white"><?php echo e($paginator->lastItem()); ?></span>
            of
            <span class="font-semibold text-white"><?php echo e($paginator->total()); ?></span>
            results
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <?php if($paginator->onFirstPage()): ?>
                <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                    Previous
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    Previous
                </a>
            <?php endif; ?>

            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_string($element)): ?>
                    <span class="inline-flex items-center px-2 text-sm text-slate-500"><?php echo e($element); ?></span>
                <?php endif; ?>

                <?php if(is_array($element)): ?>
                    <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($page == $paginator->currentPage()): ?>
                            <span aria-current="page" class="inline-flex min-w-[42px] items-center justify-center rounded-2xl bg-gradient-to-r from-cyan-400 via-sky-400 to-emerald-400 px-3 py-2 text-sm font-semibold text-slate-950">
                                <?php echo e($page); ?>

                            </span>
                        <?php else: ?>
                            <a href="<?php echo e($url); ?>" class="inline-flex min-w-[42px] items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-3 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                                <?php echo e($page); ?>

                            </a>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-semibold text-white transition hover:bg-white/10">
                    Next
                </a>
            <?php else: ?>
                <span class="inline-flex items-center rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm text-slate-500">
                    Next
                </span>
            <?php endif; ?>
        </div>
    </nav>
<?php endif; ?>
<?php /**PATH /Users/aierthinc/Desktop/CopyTrader/resources/views/vendor/pagination/fintech.blade.php ENDPATH**/ ?>