<?php
    $adminUser = Auth::guard('admin')->user();
    $depositSummary = isset($total_deposited)
        ? (float) (data_get($total_deposited->first(), 'count', 0) ?? 0)
        : (float) \App\Models\Deposit::query()->where('status', 'Processed')->sum('amount');
    $pendingWithdrawalSummary = isset($pending_withdrawn)
        ? (float) (data_get($pending_withdrawn->first(), 'count', 0) ?? 0)
        : (float) \App\Models\Withdrawal::query()->where('status', 'Pending')->sum('amount');
    $adminName = trim((string) data_get($adminUser, 'name', 'Admin User'));
    $adminEmail = (string) data_get($adminUser, 'email', '');
    $pendingKycCount = \App\Models\User::query()->where('account_verify', '!=', 'yes')->count();
    $adminNotifications = \App\Models\Notification::query()
        ->where('admin_id', data_get($adminUser, 'id'))
        ->latest('id')
        ->take(5)
        ->get();
    $adminUnreadCount = \App\Models\Notification::query()
        ->where('admin_id', data_get($adminUser, 'id'))
        ->where(function ($query) {
            if (\Illuminate\Support\Facades\Schema::hasColumn('notifications', 'is_read')) {
                $query->where('is_read', 0);
            } elseif (\Illuminate\Support\Facades\Schema::hasColumn('notifications', 'read_at')) {
                $query->whereNull('read_at');
            }
        })
        ->count();
?>

<div class="main-header">
    <header class="top-nav px-8 lg:px-12 flex items-center justify-between sticky top-0 z-[50]">
        <div class="flex items-center lg:hidden">
            <button @click="sidebarOpen = true"
                class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white/50 hover:text-white transition-all active:scale-95 shadow-lg">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
            <img src="<?php echo e(asset('storage/' . $settings->logo)); ?>" alt="<?php echo e($settings->site_name); ?>" class="h-6 ml-4 opacity-80">
        </div>

        <div class="flex items-center space-x-6 lg:space-x-8 ml-auto">
            <div class="hidden xl:flex items-center space-x-10">
                <div class="flex items-center space-x-4 bg-white/[0.02] px-6 py-2.5 rounded-2xl border border-white/5">
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Treasury Inflow</span>
                    <span class="text-xs font-black text-emerald-400 font-mono">
                        <?php echo e(data_get($settings, 'currency', '$')); ?><?php echo e(number_format($depositSummary, 0)); ?>

                    </span>
                </div>
                <div class="flex items-center space-x-4 bg-white/[0.02] px-6 py-2.5 rounded-2xl border border-white/5">
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">KYC Queue</span>
                    <span class="text-xs font-black text-yellow-400 font-mono">
                        <?php echo e(number_format($pendingKycCount)); ?> pending
                    </span>
                </div>
            </div>

            <?php echo $__env->make('partials.theme-toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white/60 hover:text-white hover:border-yellow-500/30 transition-all relative group/bell">
                    <i data-lucide="bell" class="w-5 h-5 group-hover/bell:scale-110 transition-transform"></i>
                    <?php if($adminUnreadCount > 0): ?>
                        <span class="absolute top-2.5 right-2.5 h-2 w-2 rounded-full bg-yellow-500 shadow-[0_0_10px_#f0b90a]"></span>
                    <?php endif; ?>
                </button>

                <div x-show="open" @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-4 w-80 bg-[#0d0d0d] border border-white/10 rounded-2xl overflow-hidden z-[100] shadow-2xl shadow-black/80"
                    x-cloak>
                    <div class="p-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Notifications</h3>
                        <span class="text-[10px] font-black gold-text uppercase tracking-widest"><?php echo e($adminUnreadCount); ?> Pending</span>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto no-scrollbar">
                        <?php $__empty_1 = true; $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <a href="<?php echo e(route('admin.notifications.show', $notification->id)); ?>"
                                class="block p-6 border-b border-white/5 hover:bg-white/[0.03] transition-colors <?php echo e(!data_get($notification, 'is_read', false) ? 'bg-yellow-500/[0.02]' : ''); ?>">
                                <div class="flex items-center space-x-4">
                                    <div class="h-9 w-9 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="<?php echo e(str_contains(strtolower((string) $notification->type), 'withdraw') ? 'arrow-up-right' : (str_contains(strtolower((string) $notification->type), 'deposit') ? 'landmark' : 'bell')); ?>"
                                            class="w-4 h-4 <?php echo e(str_contains(strtolower((string) $notification->type), 'withdraw') ? 'text-yellow-500' : 'text-emerald-500'); ?>"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] font-bold text-slate-300 leading-relaxed uppercase tracking-tight line-clamp-2">
                                            <?php echo e($notification->title ?? $notification->message); ?>

                                        </p>
                                        <span class="text-[9px] text-slate-600 font-black uppercase tracking-widest mt-2 block">
                                            <?php echo e($notification->created_at?->diffForHumans()); ?>

                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-12 text-center">
                                <i data-lucide="bell-off" class="w-10 h-10 text-slate-800 mx-auto mb-4"></i>
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest leading-relaxed">No new admin notifications.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <a href="<?php echo e(route('admin.notifications')); ?>"
                        class="block p-5 bg-white/[0.02] text-center text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-white hover:bg-white/[0.05] transition-all border-t border-white/5">
                        View All Notifications
                    </a>
                </div>
            </div>

            <a href="<?php echo e(route('admin.deposits.index')); ?>"
                class="hidden sm:flex items-center h-12 px-8 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.2em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.05] transform transition-all active:scale-95 group">
                <i data-lucide="arrow-down-left" class="w-4 h-4 mr-2 group-hover:scale-125 transition-transform"></i>
                Open Deposits
            </a>

            <div class="relative" x-data="{ profileOpen: false }">
                <button @click="profileOpen = !profileOpen"
                    class="h-12 pl-1 pr-3 flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.02] hover:border-yellow-500/40 transition-all flex-shrink-0 shadow-lg">
                    <span class="h-10 w-10 flex items-center justify-center rounded-xl overflow-hidden border border-white/10">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($adminName)); ?>&background=111&color=f0b90a&bold=true&size=48"
                            alt="<?php echo e($adminName); ?>" class="h-full w-full object-cover">
                    </span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform" :class="profileOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-cloak x-show="profileOpen" @click.away="profileOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-4 w-64 rounded-2xl border border-white/10 bg-[#0d0d0d] shadow-2xl shadow-black/80 overflow-hidden z-[100]">
                    <div class="px-4 py-4 border-b border-white/5">
                        <p class="text-sm font-bold text-white truncate"><?php echo e($adminName); ?></p>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mt-1 truncate"><?php echo e($adminEmail); ?></p>
                    </div>

                    <div class="p-2 space-y-1">
                        <a href="<?php echo e(route('admin.profile')); ?>"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                            <i data-lucide="user" class="w-4 h-4"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="<?php echo e(route('admin.password')); ?>"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>Security</span>
                        </a>
                        <a href="<?php echo e(route('admin.notifications')); ?>"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                            <i data-lucide="bell" class="w-4 h-4"></i>
                            <span>Notifications</span>
                        </a>
                        <form method="POST" action="<?php echo e(route('adminlogout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-rose-300 hover:bg-rose-500/10 hover:text-rose-200 transition-all">
                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<div class="fixed bottom-0 left-0 right-0 z-[100] lg:hidden">
    <div class="mx-4 mb-6 dashboard-glass bg-black/60 border-white/10 p-2 overflow-visible">
        <div class="flex items-center justify-around relative">
            <a href="<?php echo e(route('admin.dashboard')); ?>"
                class="flex flex-col items-center p-3 <?php echo e(request()->routeIs('admin.dashboard') ? 'gold-text' : 'text-slate-500'); ?>">
                <i data-lucide="layout-grid" class="w-6 h-6"></i>
            </a>
            <a href="<?php echo e(route('admin.users.index')); ?>"
                class="flex flex-col items-center p-3 <?php echo e(request()->routeIs('admin.users.index', 'manageusers') ? 'gold-text' : 'text-slate-500'); ?>">
                <i data-lucide="users" class="w-6 h-6"></i>
            </a>

            <div class="relative -top-8">
                <button @click="fabOpen = !fabOpen"
                    class="h-14 w-14 rounded-full gold-gradient-bg border-4 border-[#000] flex items-center justify-center shadow-2xl shadow-yellow-500/40 transform transition-all active:scale-90">
                    <i data-lucide="zap" class="w-6 h-6 text-black" :class="fabOpen ? 'rotate-45' : ''"></i>
                </button>
                <div x-show="fabOpen" @click.away="fabOpen = false"
                    class="absolute bottom-20 left-1/2 -translate-x-1/2 w-56 dashboard-glass p-2 space-y-1 animate-slideUp"
                    x-cloak>
                    <a href="<?php echo e(route('admin.deposits.index')); ?>" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
                        <i data-lucide="landmark" class="w-4 h-4 gold-text"></i>
                        <span class="text-xs font-bold">Deposits</span>
                    </a>
                    <a href="<?php echo e(route('admin.kyc.index')); ?>" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
                        <i data-lucide="shield-check" class="w-4 h-4 text-yellow-400"></i>
                        <span class="text-xs font-bold">KYC Queue</span>
                    </a>
                    <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
                        <i data-lucide="arrow-up-right" class="w-4 h-4 text-emerald-400"></i>
                        <span class="text-xs font-bold">Withdrawals</span>
                    </a>
                    <a href="<?php echo e(route('admin.copy.index')); ?>" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
                        <i data-lucide="copy" class="w-4 h-4 text-purple-400"></i>
                        <span class="text-xs font-bold">Copy Trading</span>
                    </a>
                </div>
            </div>

            <a href="<?php echo e(route('admin.notifications')); ?>"
                class="flex flex-col items-center p-3 <?php echo e(request()->routeIs('admin.notifications', 'admin.notifications.*') ? 'gold-text' : 'text-slate-500'); ?>">
                <i data-lucide="bell" class="w-6 h-6"></i>
            </a>
            <div class="flex flex-col items-center p-3">
                <?php echo $__env->make('partials.theme-toggle', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
            <a href="<?php echo e(route('admin.profile')); ?>"
                class="flex flex-col items-center p-3 <?php echo e(request()->routeIs('admin.profile', 'adminprofile', 'admin.password') ? 'gold-text' : 'text-slate-500'); ?>">
                <i data-lucide="user" class="w-6 h-6"></i>
            </a>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/admin/topmenu.blade.php ENDPATH**/ ?>