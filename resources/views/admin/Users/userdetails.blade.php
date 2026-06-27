@extends('layouts.admin-dasht')

@php
    $userCurrency = $user->currency ?: 'USD';
    $accountStatus = $user->status ?: 'pending';
    $isBlocked = in_array($accountStatus, ['blocked', 'banned', 'disabled'], true);
    $signalName = data_get($user, 'signals') ?: data_get($user, 'user_signal');
    $planUpgradeName = data_get($user, 'user_plan_upgade');
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-5">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-500 transition-colors">Admin</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('admin.users.index') }}" class="hover:text-yellow-500 transition-colors">Users</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">{{ $user->name }}</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Investor <span class="gold-text">Control Center</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Review balances, account security, trading settings, notices, and operator actions for this client from one screen.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('loginactivity', $user->id) }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="history" class="w-4 h-4 mr-2"></i>
                    Login Activity
                </a>
                <a href="{{ route('showusers', $user->id) }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="gift" class="w-4 h-4 mr-2"></i>
                    Referrals
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.04] transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Users
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Account Balance</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ $userCurrency }}{{ number_format((float) $user->account_bal, 2) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">live wallet balance</div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Recorded Profit</span>
                <div class="text-3xl font-black {{ (float) $user->roi >= 0 ? 'text-emerald-400' : 'text-rose-400' }} tracking-tighter mb-2">
                    {{ (float) $user->roi >= 0 ? '+' : '' }}{{ $userCurrency }}{{ number_format((float) $user->roi, 2) }}
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">admin-managed ROI balance</div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Plans & Copying</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($stats['plan_count'] + $stats['copy_count']) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ number_format($stats['plan_count']) }} plans, {{ number_format($stats['copy_count']) }} copy subscriptions
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Account Status</span>
                <div class="mb-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full border text-[10px] font-black uppercase tracking-widest {{ $isBlocked ? 'bg-rose-500/10 border-rose-500/20 text-rose-400' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' }}">
                        {{ ucfirst($accountStatus) }}
                    </span>
                </div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                    {{ $user->email_verified_at ? 'email verified' : 'email pending' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.45fr)_390px] gap-8">
            <div class="space-y-8">
                <div class="dashboard-glass overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02] flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex items-center gap-5">
                            <div class="h-20 w-20 rounded-[28px] bg-black border border-white/10 flex items-center justify-center text-2xl font-black gold-text">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-white tracking-tight">{{ $user->name }}</h2>
                                <p class="text-sm text-slate-400 mt-1">{{ $user->email }}</p>
                                <div class="flex flex-wrap items-center gap-2 mt-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border {{ $isBlocked ? 'bg-rose-500/10 border-rose-500/20 text-rose-400' : 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' }} text-[9px] font-black uppercase tracking-widest">
                                        {{ ucfirst($accountStatus) }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border {{ $user->email_verified_at ? 'bg-blue-500/10 border-blue-500/20 text-blue-400' : 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' }} text-[9px] font-black uppercase tracking-widest">
                                        {{ $user->email_verified_at ? 'Verified Email' : 'Pending Email' }}
                                    </span>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full border bg-white/5 border-white/10 text-slate-300 text-[9px] font-black uppercase tracking-widest">
                                        {{ $userCurrency }} account
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            @if ($isBlocked)
                                <a href="{{ url('admin/dashboard/uunblock/' . $user->id) }}"
                                    class="inline-flex items-center px-5 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 font-black text-[10px] uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all">
                                    Enable Account
                                </a>
                            @else
                                <a href="{{ url('admin/dashboard/uublock/' . $user->id) }}"
                                    class="inline-flex items-center px-5 py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 font-black text-[10px] uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                                    Ban Account
                                </a>
                            @endif

                            <button type="button" onclick="confirmDangerAction('{{ url('admin/dashboard/resetpswd/' . $user->id) }}', 'Reset password to user01236?')"
                                class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                Reset Password
                            </button>
                        </div>
                    </div>

                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Username</p>
                            <p class="text-sm font-semibold text-white">{{ $user->username ?: 'Not set' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Phone</p>
                            <p class="text-sm font-semibold text-white">{{ $user->phone ?: 'Not added' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Country</p>
                            <p class="text-sm font-semibold text-white">{{ $user->country ?: 'Not added' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Registered</p>
                            <p class="text-sm font-semibold text-white">{{ optional($user->created_at)->format('M d, Y h:i A') ?: 'Unknown' }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Withdrawal Trade Gate</p>
                            <p class="text-sm font-semibold text-white">{{ (int) ($user->numberoftrades ?? 0) }} trades</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Risk Profile</p>
                            <p class="text-sm font-semibold text-white">{{ $user->investor_profile ?: 'Not set' }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Wallet Controls</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Funding & adjustments</span>
                        </div>

                        <form method="POST" action="{{ route('topup') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Amount</label>
                                    <input type="number" step="0.01" name="amount" required
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Action</label>
                                    <select name="t_type" required
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="Credit">Credit</option>
                                        <option value="Debit">Debit</option>
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Bucket</label>
                                    <select name="type" required
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="balance">Account Balance</option>
                                        <option value="Bonus">Bonus</option>
                                        <option value="Profit">Profit</option>
                                        <option value="Ref_Bonus">Referral Bonus</option>
                                        <option value="Deposit">Deposit</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Plan Label</label>
                                    <input type="text" name="user_pln" value="{{ $planUpgradeName }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Optional for deposit records">
                                </div>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.22em] shadow-xl shadow-yellow-500/10 hover:scale-[1.02] transition-all">
                                Submit Wallet Action
                            </button>
                        </form>
                    </div>

                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Communication</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Email & dashboard notices</span>
                        </div>

                        <form method="POST" action="{{ route('sendmailtooneuser') }}" class="space-y-4 mb-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Email Subject</label>
                                <input type="text" name="subject" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Email Message</label>
                                <textarea name="message" rows="4" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-[0.22em] hover:bg-white/10 transition-all">
                                Send Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('notifyuser') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Dashboard Notice</label>
                                    <select name="notifystatus"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Current State</label>
                                    <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-slate-300">
                                        {{ data_get($user->getAttributes(), 'notify_status', 'off') }}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Notice Message</label>
                                <textarea name="notify" rows="3" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"></textarea>
                            </div>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-[0.22em] hover:bg-white/10 transition-all">
                                Update Dashboard Notice
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Profile & Access</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Identity management</span>
                        </div>

                        <form method="POST" action="{{ route('edituser') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="s_currency" id="selected-currency-code" value="{{ $userCurrency }}">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Full Name</label>
                                    <input type="text" name="name" required value="{{ $user->name }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Username</label>
                                    <input type="text" name="username" required value="{{ $user->username }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Email</label>
                                    <input type="email" name="email" required value="{{ $user->email }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Phone</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Country</label>
                                    <input type="text" name="country" value="{{ $user->country }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Currency</label>
                                    <select name="currency" id="user-currency-select"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="{{ $userCurrency }}">{{ $userCurrency }}</option>
                                        @foreach ($currencies as $code => $currencySymbol)
                                            <option value="{{ html_entity_decode($currencySymbol) }}" data-code="{{ $code }}">
                                                {{ $code }} ({{ html_entity_decode($currencySymbol) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Referral Link</label>
                                <input type="text" name="ref_link" value="{{ $user->ref_link }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>

                            <button type="submit"
                                class="inline-flex items-center justify-center px-6 py-4 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.22em] shadow-xl shadow-yellow-500/10 hover:scale-[1.02] transition-all">
                                Save Profile
                            </button>
                        </form>
                    </div>

                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Risk Gates & Notices</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Controls that affect withdrawals and upgrades</span>
                        </div>

                        <div class="space-y-5">
                            <form method="POST" action="{{ route('numberoftrades') }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Required trades before withdrawal</label>
                                <div class="flex gap-3">
                                    <input type="number" name="numberoftrades" value="{{ $user->numberoftrades ?? 0 }}"
                                        class="flex-1 rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                        Save
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('withdrawalcode') }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Withdrawal code</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <select name="withdrawal_code"
                                        class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                    <input type="text" name="user_withdrawalcode" value="{{ data_get($user, 'user_withdrawalcode') }}"
                                        class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Enter code">
                                </div>
                                <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                    Update Withdrawal Code
                                </button>
                            </form>

                            <form method="POST" action="{{ route('tradingprogress') }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Signal strength (%)</label>
                                <div class="flex gap-3">
                                    <input type="number" name="progress" value="{{ data_get($user, 'progress', 0) }}"
                                        class="flex-1 rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                        Update
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('usertax') }}" class="space-y-3">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500">Tax controls</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <select name="taxtype"
                                        class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                    <input type="number" step="0.01" name="taxamount" value="{{ $user->taxamount ?? 0 }}"
                                        class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Amount">
                                </div>
                                <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                    Update Tax Settings
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Upgrade Prompts</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Control user-facing plan and signal upgrade banners</span>
                        </div>

                        <form method="POST" action="{{ route('upgradeplanstatus') }}" class="space-y-4 mb-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Plan Upgrade Status</label>
                                    <select name="planstatus"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Plan</label>
                                    <select name="user_plan"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->name }}" @selected($planUpgradeName === $plan->name)>{{ $plan->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                Update Plan Upgrade
                            </button>
                        </form>

                        <form method="POST" action="{{ route('upgradesignalstatus') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Signal Upgrade Status</label>
                                    <select name="signal_status"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="on">On</option>
                                        <option value="off">Off</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Signal</label>
                                    <select name="user_signal"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        @foreach ($signals as $signal)
                                            <option value="{{ $signal->name }}" @selected($signalName === $signal->name)>{{ $signal->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                Update Signal Upgrade
                            </button>
                        </form>
                    </div>

                    <div class="dashboard-glass p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Manual Trading Tools</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Operator-only portfolio actions</span>
                        </div>

                        <form method="POST" action="{{ route('addhistory') }}" class="space-y-4 mb-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <input type="number" step="0.01" name="amount" required placeholder="Trade amount"
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                <select name="plan" required
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="EURUSD">EURUSD</option>
                                    <option value="BTCUSD">BTCUSD</option>
                                    <option value="ETHUSD">ETHUSD</option>
                                    <option value="GOLD">GOLD</option>
                                    <option value="SPX500USD">SPX500USD</option>
                                </select>
                                <select name="leverage" required
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    @foreach ([10,20,30,40,50,60,70,80,90,100] as $leverage)
                                        <option value="{{ $leverage }}">1:{{ $leverage }}</option>
                                    @endforeach
                                </select>
                                <select name="expire" required
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="1 Minutes">1 Minute</option>
                                        <option value="5 Minutes">5 Minutes</option>
                                        <option value="15 Minutes">15 Minutes</option>
                                        <option value="30 Minutes">30 Minutes</option>
                                        <option value="60 Minutes">1 Hour</option>
                                        <option value="1 Days">1 Day</option>
                                </select>
                                <select name="type" required
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="WIN">Profit</option>
                                    <option value="LOSE">Loss</option>
                                </select>
                                <select name="tradetype" required
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="Buy">Buy</option>
                                    <option value="Sell">Sell</option>
                                </select>
                            </div>
                            <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                Execute Manual Trade
                            </button>
                        </form>

                        <form method="POST" action="{{ route('addplanhistory') }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <select name="plan"
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    @foreach ($pl as $plns)
                                        <option value="{{ $plns->name }}">{{ $plns->name }}</option>
                                    @endforeach
                                </select>
                                <input type="number" step="0.01" name="amount" placeholder="Amount"
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                <select name="type"
                                    class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="Bonus">Bonus</option>
                                    <option value="ROI">ROI</option>
                                </select>
                            </div>
                            <button type="submit" class="px-5 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                                Add Plan History
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Exposure Snapshot</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Deposits processed</p>
                            <p class="text-2xl font-black text-white">{{ $userCurrency }}{{ number_format($stats['deposits_total'], 2) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Withdrawals processed</p>
                            <p class="text-2xl font-black text-white">{{ $userCurrency }}{{ number_format($stats['withdrawals_total'], 2) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Bot investments</p>
                            <p class="text-2xl font-black text-white">{{ number_format($stats['bot_count']) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Recorded activity events</p>
                            <p class="text-2xl font-black text-white">{{ number_format($stats['activity_count']) }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Funding Timeline</h3>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Latest cash movement</span>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Recent Deposits</p>
                            <div class="space-y-3">
                                @forelse ($recentDeposits as $deposit)
                                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-sm font-semibold text-white">{{ $userCurrency }}{{ number_format((float) data_get($deposit, 'amount', 0), 2) }}</p>
                                            <span class="inline-flex items-center rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[9px] font-black uppercase tracking-widest text-emerald-400">
                                                {{ data_get($deposit, 'status', 'pending') }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-500">
                                            {{ data_get($deposit, 'payment_mode', 'Payment record') }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-6 text-sm text-slate-400">
                                        No recent deposits found for this user.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-3">Recent Withdrawals</p>
                            <div class="space-y-3">
                                @forelse ($recentWithdrawals as $withdrawal)
                                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-sm font-semibold text-white">{{ $userCurrency }}{{ number_format((float) data_get($withdrawal, 'amount', 0), 2) }}</p>
                                            <span class="inline-flex items-center rounded-full border border-yellow-500/20 bg-yellow-500/10 px-3 py-1 text-[9px] font-black uppercase tracking-widest text-yellow-300">
                                                {{ data_get($withdrawal, 'status', 'pending') }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-500">
                                            {{ data_get($withdrawal, 'payment_mode', 'Withdrawal record') }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-6 text-sm text-slate-400">
                                        No recent withdrawals found for this user.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Quick Links</h3>
                    <div class="space-y-3">
                        <a href="{{ route('user.investments', $user->id) }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            View user plans
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        <a href="{{ route('user.plans', $user->id) }}"
                            class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white hover:bg-white/[0.04] transition-all">
                            View user trades
                            <i data-lucide="arrow-right" class="w-4 h-4 text-slate-500"></i>
                        </a>
                        @if (!$user->email_verified_at)
                            <a href="{{ url('admin/dashboard/email-verify/' . $user->id) }}"
                                class="flex items-center justify-between rounded-2xl border border-blue-500/20 bg-blue-500/10 px-4 py-4 text-sm font-semibold text-blue-300 hover:bg-blue-500/15 transition-all">
                                Verify user email
                                <i data-lucide="shield-check" class="w-4 h-4"></i>
                            </a>
                        @endif
                        <button type="button" onclick="confirmDangerAction('{{ url('admin/dashboard/clearacct/' . $user->id) }}', 'Clear this account balance, profit, bonus, and referral balance?')"
                            class="w-full flex items-center justify-between rounded-2xl border border-yellow-500/20 bg-yellow-500/10 px-4 py-4 text-sm font-semibold text-yellow-300 hover:bg-yellow-500/15 transition-all">
                            Clear account balances
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="confirmDangerAction('{{ url('admin/dashboard/switchuser/' . $user->id) }}', 'Log in as this user?')"
                            class="w-full flex items-center justify-between rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm font-semibold text-emerald-300 hover:bg-emerald-500/15 transition-all">
                            Log in as user
                            <i data-lucide="log-in" class="w-4 h-4"></i>
                        </button>
                        <button type="button" onclick="confirmDangerAction('{{ url('admin/dashboard/delsystemuser/' . $user->id) }}', 'Delete this user and all linked records? This cannot be undone.')"
                            class="w-full flex items-center justify-between rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-4 text-sm font-semibold text-rose-300 hover:bg-rose-500/15 transition-all">
                            Delete user
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Recent Activity</h3>
                    <div class="space-y-3">
                        @forelse ($recentActivities as $activity)
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                <p class="text-sm font-semibold text-white">{{ data_get($activity, 'activity', 'Activity event') }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-2">
                                    {{ optional($activity->created_at)->diffForHumans() ?? 'Recently' }}
                                </p>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-6 text-sm text-slate-400">
                                No recent activity found for this user.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('user-currency-select')?.addEventListener('change', function(event) {
            const code = event.target.options[event.target.selectedIndex]?.dataset?.code || event.target.value;
            const hidden = document.getElementById('selected-currency-code');
            if (hidden) {
                hidden.value = code;
            }
        });

        function confirmDangerAction(url, message) {
            Swal.fire({
                title: 'Confirm action',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f0b90a',
                cancelButtonColor: '#1f2937',
                confirmButtonText: 'Proceed',
                background: '#0b0f19',
                color: '#ffffff',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection
