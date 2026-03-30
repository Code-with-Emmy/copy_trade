@extends('layouts.admin-dasht')

@php
    $totalDeposits = (float) data_get($total_deposited->first(), 'count', 0);
    $pendingDeposits = (float) data_get($pending_deposited->first(), 'count', 0);
    $totalWithdrawals = (float) data_get($total_withdrawn->first(), 'count', 0);
    $pendingWithdrawals = (float) data_get($pending_withdrawn->first(), 'count', 0);
    $currency = data_get($settings ?? null, 'currency', '$');
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <span class="hover:text-yellow-500 transition-colors">Admin</span>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Platform Command Center</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Operations <span class="gold-text">Dashboard</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Monitor treasury flow, platform growth, verification pressure, and admin workload from one premium control surface.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.deposits.index') }}"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="landmark" class="w-4 h-4 mr-2"></i>
                    Review Deposits
                </a>
                <a href="{{ route('task') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="list-checks" class="w-4 h-4 mr-2"></i>
                    Task Desk
                </a>
            </div>
        </div>

        @if($unverifiedusers > 0)
            <div class="rounded-2xl border border-yellow-500/20 bg-yellow-500/10 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-11 w-11 rounded-2xl bg-yellow-500/10 flex items-center justify-center shrink-0">
                        <i data-lucide="shield-alert" class="w-5 h-5 text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-yellow-400 uppercase tracking-widest">Verification Queue Active</p>
                        <p class="text-[10px] text-yellow-400/70 font-bold uppercase tracking-wider mt-0.5">{{ number_format($unverifiedusers) }} accounts are waiting for verification review.</p>
                    </div>
                </div>
                <a href="{{ route('admin.kyc.index') }}"
                    class="h-10 px-5 rounded-xl bg-yellow-500 text-black font-black text-[10px] uppercase tracking-widest hover:bg-yellow-400 transition-all flex items-center justify-center space-x-2">
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    <span>Open KYC Queue</span>
                </a>
            </div>
        @endif

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 hover:bg-emerald-500/10 hover:border-emerald-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-emerald-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="users" class="w-6 h-6 text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Users</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Manage Accounts</p>
                </div>
            </a>

            <a href="{{ route('admin.deposits.index') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-blue-500/5 border border-blue-500/10 hover:bg-blue-500/10 hover:border-blue-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="landmark" class="w-6 h-6 text-blue-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Deposits</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Funding Queue</p>
                </div>
            </a>

            <a href="{{ route('admin.withdrawals.index') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-rose-500/5 border border-rose-500/10 hover:bg-rose-500/10 hover:border-rose-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-rose-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="arrow-up-right" class="w-6 h-6 text-rose-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-widest">Withdrawals</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Payout Queue</p>
                </div>
            </a>

            <a href="{{ route('admin.copy.index') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-purple-500/5 border border-purple-500/10 hover:bg-purple-500/10 hover:border-purple-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="copy" class="w-6 h-6 text-purple-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-purple-400 uppercase tracking-widest">Copy Desk</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Lead Traders</p>
                </div>
            </a>

            <a href="{{ route('admin.notifications') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-yellow-500/5 border border-yellow-500/10 hover:bg-yellow-500/10 hover:border-yellow-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-yellow-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="bell" class="w-6 h-6 text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-yellow-400 uppercase tracking-widest">Alerts</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Admin Notices</p>
                </div>
            </a>

            <a href="{{ route('task') }}"
                class="flex flex-col items-center text-center p-5 rounded-2xl bg-orange-500/5 border border-orange-500/10 hover:bg-orange-500/10 hover:border-orange-500/40 transition-all group space-y-3">
                <div class="h-12 w-12 rounded-xl bg-orange-500/10 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i data-lucide="list-checks" class="w-6 h-6 text-orange-400"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest">Tasks</p>
                    <p class="text-[9px] text-slate-600 font-bold uppercase">Internal Work</p>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Processed Deposits</span>
                <div class="text-3xl font-black gold-text tracking-tighter mb-2">{{ $currency }}{{ number_format($totalDeposits, 2) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="arrow-down-left" class="w-3 h-3 mr-2 gold-text"></i>
                    Treasury Inflow
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Processed Withdrawals</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ $currency }}{{ number_format($totalWithdrawals, 2) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="arrow-up-right" class="w-3 h-3 mr-2 gold-text"></i>
                    Settled Payouts
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Platform Users</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($user_count) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="users-2" class="w-3 h-3 mr-2 gold-text"></i>
                    {{ number_format($activeusers) }} Active / {{ number_format($blockeusers) }} Blocked
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Admin Workload</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($pendingTasks) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="briefcase" class="w-3 h-3 mr-2 gold-text"></i>
                    {{ number_format($taskCount) }} Tasks / {{ number_format($adminCount) }} Admins
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 xl:gap-8">
            <div class="xl:col-span-2 dashboard-glass p-6 sm:p-8 space-y-6 sm:space-y-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Treasury Activity Map</h3>
                        <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-1">Funding, withdrawals, and transaction volume snapshot</p>
                    </div>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Live Metrics</span>
                </div>
                <div class="h-[400px] w-full bg-black/40 rounded-3xl p-4 sm:p-6 border border-white/5">
                    <canvas id="treasuryChart"></canvas>
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 space-y-6 sm:space-y-8">
                <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Operations Snapshot</h3>
                <div class="space-y-4 pt-4 border-t border-white/5">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending Deposits</span>
                        <span class="text-[10px] font-black text-white font-mono">{{ $currency }}{{ number_format($pendingDeposits, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pending Withdrawals</span>
                        <span class="text-[10px] font-black text-white font-mono">{{ $currency }}{{ number_format($pendingWithdrawals, 2) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Investment Plans</span>
                        <span class="text-[10px] font-black text-white font-mono">{{ number_format($plans) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Unverified Users</span>
                        <span class="text-[10px] font-black text-white font-mono">{{ number_format($unverifiedusers) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Transaction Volume</span>
                        <span class="text-[10px] font-black text-white font-mono">{{ $currency }}{{ number_format($chart_trans, 2) }}</span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <a href="{{ route('admin.settings.platform') }}" class="rounded-2xl border border-white/5 bg-black/30 px-4 py-4 hover:border-yellow-500/20 hover:bg-white/[0.02] transition-all">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Platform</p>
                        <p class="mt-2 text-sm font-bold text-white">Settings</p>
                    </a>
                    <a href="{{ route('admin.settings.payments') }}" class="rounded-2xl border border-white/5 bg-black/30 px-4 py-4 hover:border-yellow-500/20 hover:bg-white/[0.02] transition-all">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Payments</p>
                        <p class="mt-2 text-sm font-bold text-white">Gateways</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 dashboard-glass p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="text-xl font-black text-white italic tracking-tight uppercase">Recent <span class="gold-text">Deposits</span></h2>
                    <a href="{{ route('admin.deposits.index') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-white transition-colors">Open Deposits</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentDeposits as $deposit)
                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/5 bg-black/30 px-5 py-4">
                            <div>
                                <p class="text-sm font-bold text-white">{{ data_get($deposit, 'duser.name', 'Deleted User') }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $deposit->payment_mode }} · {{ $deposit->created_at?->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-white">{{ $currency }}{{ number_format((float) $deposit->amount, 2) }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest {{ $deposit->status === 'Processed' ? 'text-emerald-400' : 'text-yellow-400' }}">{{ $deposit->status }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-8 text-center text-[10px] font-black uppercase tracking-widest text-slate-500">No recent deposits found.</div>
                    @endforelse
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between border-b border-white/5 pb-4">
                    <h2 class="text-xl font-black text-white italic tracking-tight uppercase">Admin <span class="gold-text">Queue</span></h2>
                    <a href="{{ route('task') }}" class="text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-white transition-colors">Open Task Desk</a>
                </div>

                <div class="space-y-4">
                    @forelse($recentTasks as $task)
                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-4">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $task->title }}</p>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ data_get($task, 'tuser.name', 'Unassigned') }}</p>
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $task->status === 'Completed' ? 'text-emerald-400' : 'text-yellow-400' }}">{{ $task->status }}</span>
                            </div>
                            <p class="mt-3 text-xs text-slate-400 leading-relaxed">{{ \Illuminate\Support\Str::limit($task->note, 90) }}</p>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-8 text-center text-[10px] font-black uppercase tracking-widest text-slate-500">No recent tasks found.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <div class="dashboard-glass overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div class="flex items-center space-x-4">
                        <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                            <i data-lucide="receipt-text" class="w-5 h-5 gold-text"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black uppercase tracking-tight">Withdrawal Queue</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Latest payout requests</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.withdrawals.index') }}"
                        class="h-10 px-6 rounded-xl border border-white/5 text-[9px] font-black text-slate-400 uppercase tracking-widest hover:text-white hover:border-white/10 transition-all flex items-center">
                        View All
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 border-b border-white/5">
                                <th class="px-8 py-5">Client</th>
                                <th class="px-8 py-5">Method</th>
                                <th class="px-8 py-5">Amount</th>
                                <th class="px-8 py-5 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentWithdrawals as $withdrawal)
                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-5">
                                        <div class="text-sm font-bold text-white">{{ data_get($withdrawal, 'duser.name', 'Deleted User') }}</div>
                                        <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $withdrawal->created_at?->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-[11px] font-black text-slate-300 uppercase">{{ $withdrawal->payment_mode }}</td>
                                    <td class="px-8 py-5 text-[11px] font-black text-white font-mono">{{ $currency }}{{ number_format((float) $withdrawal->amount, 2) }}</td>
                                    <td class="px-8 py-5 text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full {{ $withdrawal->status === 'Processed' ? 'bg-emerald-500/10 border border-emerald-500/20 text-emerald-500' : 'bg-yellow-500/10 border border-yellow-500/20 text-yellow-400' }} text-[9px] font-black uppercase tracking-widest">
                                            {{ $withdrawal->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-16 text-center text-[10px] font-black uppercase tracking-widest text-slate-500">No recent withdrawals found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="dashboard-glass border-white/10 p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center">
                        <i data-lucide="zap" class="w-4 h-4 mr-3 gold-text"></i> Admin Modules
                    </h3>
                    <div class="flex items-center h-6 px-3 rounded-full bg-yellow-500/10 border border-yellow-500/20">
                        <span class="text-[8px] font-black gold-text uppercase tracking-widest">Operational</span>
                    </div>
                </div>

                <div class="space-y-4">
                    @php
                        $modules = [
                            ['name' => 'Copy Trading', 'route' => route('admin.copy.index'), 'copy' => 'Lead trader marketplace and copied accounts', 'color' => 'text-purple-400'],
                            ['name' => 'Plans', 'route' => route('admin.plans.index'), 'copy' => 'Investment products, pricing, and lifecycle', 'color' => 'text-yellow-400'],
                            ['name' => 'Bots', 'route' => route('admin.bots.index'), 'copy' => 'Automated strategies and bot analytics', 'color' => 'text-emerald-400'],
                            ['name' => 'Content', 'route' => route('admin.content.index'), 'copy' => 'Homepage, FAQs, testimonials, and trust pages', 'color' => 'text-blue-400'],
                        ];
                    @endphp

                    @foreach($modules as $module)
                        <a href="{{ $module['route'] }}"
                            class="flex items-center justify-between group cursor-pointer hover:bg-white/[0.02] -mx-4 px-4 py-3 rounded-xl transition-all border border-transparent hover:border-white/5">
                            <div>
                                <div class="text-[11px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">
                                    {{ $module['name'] }}
                                </div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">
                                    {{ $module['copy'] }}
                                </div>
                            </div>
                            <i data-lucide="arrow-up-right" class="w-4 h-4 {{ $module['color'] }}"></i>
                        </a>
                    @endforeach
                </div>

                <a href="{{ route('admin.settings.platform') }}"
                    class="mt-8 h-12 w-full flex items-center justify-center rounded-xl bg-white/5 border border-white/5 text-[9px] font-black text-slate-500 uppercase tracking-widest hover:text-white hover:border-white/20 transition-all">
                    Open Platform Settings
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const chartEl = document.getElementById('treasuryChart');
            if (!chartEl) return;

            new Chart(chartEl, {
                type: 'bar',
                data: {
                    labels: ['Processed Deposits', 'Pending Deposits', 'Processed Withdrawals', 'Pending Withdrawals', 'Transactions'],
                    datasets: [{
                        label: 'Amount',
                        data: [
                            {{ json_encode($chart_pdepsoit) }},
                            {{ json_encode($chart_pendepsoit) }},
                            {{ json_encode($chart_pwithdraw) }},
                            {{ json_encode($chart_pendwithdraw) }},
                            {{ json_encode($chart_trans) }}
                        ],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(250, 204, 21, 0.8)',
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(244, 114, 182, 0.8)',
                            'rgba(240, 185, 10, 0.8)'
                        ],
                        borderRadius: 12,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                color: '#cbd5e1'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#64748b',
                                font: {
                                    weight: '700'
                                }
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.03)'
                            }
                        },
                        y: {
                            ticks: {
                                color: '#64748b',
                                font: {
                                    weight: '700'
                                }
                            },
                            grid: {
                                color: 'rgba(255,255,255,0.05)'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
