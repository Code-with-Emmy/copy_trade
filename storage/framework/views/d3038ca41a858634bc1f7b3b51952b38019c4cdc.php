<?php if(session()->has('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-transition.opacity class="w-full" data-inline-flash="success">
        <div class="dashboard-glass border border-emerald-500/20 bg-emerald-500/5 rounded-2xl px-5 py-4 relative overflow-hidden">
            <div class="absolute inset-y-0 left-0 w-1 bg-emerald-500"></div>
            <div class="flex items-start gap-3 pr-8">
                <div class="h-9 w-9 rounded-xl bg-emerald-500/10 border border-emerald-500/25 flex items-center justify-center flex-shrink-0">
                    <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.22em]">Success</p>
                    <p class="text-sm text-slate-200 mt-1 leading-relaxed"><?php echo e(session('success')); ?></p>
                </div>
            </div>
            <button type="button" @click="show = false"
                class="absolute top-3 right-3 h-7 w-7 rounded-lg border border-white/10 bg-white/5 text-slate-400 hover:text-white hover:bg-white/10 transition-all">
                <span class="sr-only">Close</span>
                <i data-lucide="x" class="w-4 h-4 mx-auto"></i>
            </button>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/components/success-alert.blade.php ENDPATH**/ ?>