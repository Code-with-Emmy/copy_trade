<?php
    $admin = Auth::guard('admin')->user();
    $adminName = trim((string) data_get($admin, 'name', 'Admin User'));
    $adminRole = strtoupper((string) data_get($admin, 'type', 'ADMIN'));
    $adminConsoleValue = (float) \App\Models\Deposit::query()->where('status', 'Processed')->sum('amount');
    $adminPendingValue = (float) \App\Models\Withdrawal::query()->where('status', 'Pending')->sum('to_deduct');
?>

<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm lg:hidden"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>

<aside
    class="sidebar fixed inset-y-0 left-0 z-[70] w-72 border-r border-white/10 bg-gradient-to-b from-[#040507] via-[#05080d] to-black transform lg:translate-x-0 transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
    <div class="flex h-full flex-col">
        <div class="h-[78px] flex items-center justify-between px-6 border-b border-white/5 bg-black/30 backdrop-blur-md">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center">
                <img src="<?php echo e(asset('storage/' . $settings->logo)); ?>" alt="<?php echo e($settings->site_name); ?>" class="h-9 w-auto object-contain">
            </a>
            <button @click="sidebarOpen = false"
                class="lg:hidden h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <div class="px-5 py-6">
            <div class="dashboard-glass p-5 border-white/10 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-500/5 blur-2xl group-hover:bg-yellow-500/10 transition-all"></div>

                <div class="flex items-center space-x-3 mb-5 relative">
                    <div class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 shadow-xl">
                        <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($adminName)); ?>&background=000&color=f0b90a&bold=true"
                            alt="<?php echo e($adminName); ?>" class="h-full w-full rounded-[14px] object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-black text-white truncate uppercase tracking-tight"><?php echo e($adminName); ?></p>
                        <div class="flex items-center mt-1">
                            <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest"><?php echo e($adminRole); ?></span>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 relative">
                    <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em]">Treasury Volume</div>
                    <div class="text-2xl font-black gold-text tracking-tighter">
                        <?php echo e(data_get($settings, 'currency', '$')); ?><?php echo e(number_format($adminConsoleValue, 2)); ?>

                    </div>
                    <div class="text-[9px] font-black uppercase tracking-widest text-slate-500">
                        <?php echo e(data_get($settings, 'currency', '$')); ?><?php echo e(number_format($adminPendingValue, 2)); ?> pending payouts
                    </div>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto pb-16 pt-2 no-scrollbar">
            <div class="px-5">
                <div class="sidebar-section-label">Operations</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i data-lucide="layout-grid"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.users.index', 'manageusers', 'viewuser', 'admin.users.show', 'loginactivity', 'user.wallet', 'user.plans', 'user.investments') ? 'active' : ''); ?>">
                        <i data-lucide="users"></i>
                        <span>Users</span>
                    </a>
                    <a href="<?php echo e(route('admin.deposits.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.deposits.index', 'mdeposits', 'viewdepositimage', 'pdeposit', 'editamount') ? 'active' : ''); ?>">
                        <i data-lucide="landmark"></i>
                        <span>Deposits</span>
                    </a>
                    <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.withdrawals.index', 'mwithdrawals', 'processwithdraw', 'pwithdrawal') ? 'active' : ''); ?>">
                        <i data-lucide="arrow-up-right"></i>
                        <span>Withdrawals</span>
                    </a>
                    <a href="<?php echo e(route('admin.kyc.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.kyc.index', 'kyc', 'viewkyc') ? 'active' : ''); ?>">
                        <i data-lucide="shield-check"></i>
                        <span>KYC</span>
                    </a>
                </div>
            </div>

            <div class="px-5 mt-3">
                <div class="sidebar-section-label">Trading</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.copy.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.copy.*', 'copytrading', 'newcopytrading', 'editcopytrading', 'activecopytrading') ? 'active' : ''); ?>">
                        <i data-lucide="copy"></i>
                        <span>Copy Trading</span>
                    </a>
                    <a href="<?php echo e(route('admin.trades.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.trades.*') ? 'active' : ''); ?>">
                        <i data-lucide="trending-up"></i>
                        <span>Trades</span>
                    </a>
                    <a href="<?php echo e(route('admin.bots.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.bots.*') ? 'active' : ''); ?>">
                        <i data-lucide="bot"></i>
                        <span>Trading Bots</span>
                    </a>
                    <a href="<?php echo e(route('admin.plans.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.plans.*', 'plans', 'newplan', 'editplan', 'activeinvestments', 'investments') ? 'active' : ''); ?>">
                        <i data-lucide="briefcase"></i>
                        <span>Plans</span>
                    </a>
                    <a href="<?php echo e(route('signals')); ?>" class="sidebar-link <?php echo e(request()->routeIs('signals', 'newsignal', 'editsignal', 'activesignals', 'signal.settings', 'signal.subs', 'msignals') ? 'active' : ''); ?>">
                        <i data-lucide="activity"></i>
                        <span>Signals</span>
                    </a>
                    <a href="<?php echo e(route('msubtrade')); ?>" class="sidebar-link <?php echo e(request()->routeIs('msubtrade', 'tsettings', 'tacnts', 'tra.pay') ? 'active' : ''); ?>">
                        <i data-lucide="link"></i>
                        <span>Managed Accounts</span>
                    </a>
                    <a href="<?php echo e(route('admin.user-plans.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.user-plans.*') ? 'active' : ''); ?>">
                        <i data-lucide="folders"></i>
                        <span>User Plans</span>
                    </a>
                </div>
            </div>

            <div class="px-5 mt-3">
                <div class="sidebar-section-label">CRM</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('leads')); ?>" class="sidebar-link <?php echo e(request()->routeIs('leads', 'leadsassign', 'customer') ? 'active' : ''); ?>">
                        <i data-lucide="user-plus"></i>
                        <span>Leads</span>
                    </a>
                    <a href="<?php echo e(route('emailservices')); ?>" class="sidebar-link <?php echo e(request()->routeIs('emailservices') ? 'active' : ''); ?>">
                        <i data-lucide="mail"></i>
                        <span>Email Services</span>
                    </a>
                    <a href="<?php echo e(route('task')); ?>" class="sidebar-link <?php echo e(request()->routeIs('task', 'mtask', 'viewtask') ? 'active' : ''); ?>">
                        <i data-lucide="list-checks"></i>
                        <span>Task Desk</span>
                    </a>
                    <a href="<?php echo e(route('calendar')); ?>" class="sidebar-link <?php echo e(request()->routeIs('calendar') ? 'active' : ''); ?>">
                        <i data-lucide="calendar-days"></i>
                        <span>Calendar</span>
                    </a>
                </div>
            </div>

            <div class="px-5 mt-3">
                <div class="sidebar-section-label">Content</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.content.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.content.index', 'frontpage') ? 'active' : ''); ?>">
                        <i data-lucide="panel-top"></i>
                        <span>Frontend Content</span>
                    </a>
                    <a href="<?php echo e(route('categories')); ?>" class="sidebar-link <?php echo e(request()->routeIs('categories', 'courses', 'lessons', 'less.nocourse') ? 'active' : ''); ?>">
                        <i data-lucide="graduation-cap"></i>
                        <span>Membership</span>
                    </a>
                    <a href="<?php echo e(route('aboutonlinetrade')); ?>" class="sidebar-link <?php echo e(request()->routeIs('aboutonlinetrade') ? 'active' : ''); ?>">
                        <i data-lucide="file-text"></i>
                        <span>About Section</span>
                    </a>
                </div>
            </div>

            <div class="px-5 mt-3">
                <div class="sidebar-section-label">System</div>
                <div class="space-y-1">
                    <a href="<?php echo e(route('admin.notifications')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.notifications', 'admin.notifications.*') ? 'active' : ''); ?>">
                        <i data-lucide="bell"></i>
                        <span>Notifications</span>
                    </a>
                    <a href="<?php echo e(route('admin.settings.payments')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.settings.payments', 'paymentview') ? 'active' : ''); ?>">
                        <i data-lucide="wallet"></i>
                        <span>Payment Settings</span>
                    </a>
                    <a href="<?php echo e(route('admin.settings.platform')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.settings.platform', 'appsettingshow', 'settings') ? 'active' : ''); ?>">
                        <i data-lucide="sliders-horizontal"></i>
                        <span>Platform Settings</span>
                    </a>
                    <a href="<?php echo e(route('refsetshow')); ?>" class="sidebar-link <?php echo e(request()->routeIs('refsetshow') ? 'active' : ''); ?>">
                        <i data-lucide="gift"></i>
                        <span>Referral Settings</span>
                    </a>
                    <a href="<?php echo e(route('managecryptoasset')); ?>" class="sidebar-link <?php echo e(request()->routeIs('managecryptoasset') ? 'active' : ''); ?>">
                        <i data-lucide="coins"></i>
                        <span>Crypto Assets</span>
                    </a>
                    <a href="<?php echo e(route('ipaddress')); ?>" class="sidebar-link <?php echo e(request()->routeIs('allipaddress', 'ipaddress') ? 'active' : ''); ?>">
                        <i data-lucide="shield"></i>
                        <span>IP Controls</span>
                    </a>
                    <a href="<?php echo e(route('admin.team.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.team.index', 'madmin', 'addmanager') ? 'active' : ''); ?>">
                        <i data-lucide="users-round"></i>
                        <span>Admin Team</span>
                    </a>
                    <a href="<?php echo e(route('admin.profile')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.profile', 'adminprofile', 'admin.password') ? 'active' : ''); ?>">
                        <i data-lucide="settings-2"></i>
                        <span>Account Settings</span>
                    </a>
                    <a href="<?php echo e(route('clearcache')); ?>" class="sidebar-link <?php echo e(request()->routeIs('clearcache') ? 'active' : ''); ?>">
                        <i data-lucide="trash-2"></i>
                        <span>Clear Cache</span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="px-5 py-6 border-t border-white/5 bg-black/30 backdrop-blur-md">
            <form method="POST" action="<?php echo e(route('adminlogout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit"
                    class="flex items-center w-full px-5 py-3.5 rounded-2xl bg-white/[0.03] hover:bg-rose-500/10 border border-white/5 text-slate-400 hover:text-rose-400 transition-all group">
                    <i data-lucide="power" class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform"></i>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
<?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/admin/sidebar.blade.php ENDPATH**/ ?>