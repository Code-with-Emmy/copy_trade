@extends('layouts.admin-dasht')

@section('title', 'Admin Profile')

@php
    $admin = Auth('admin')->user();
    $firstName = trim((string) data_get($admin, 'firstName', ''));
    $lastName = trim((string) data_get($admin, 'lastName', ''));
    $fullName = trim($firstName . ' ' . $lastName) ?: trim((string) data_get($admin, 'name', 'Administrator'));
    $nameParts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY) ?: ['A'];
    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
    $email = (string) data_get($admin, 'email', 'No email configured');
    $phone = (string) data_get($admin, 'phone', '');
    $role = (string) data_get($admin, 'type', 'Admin');
    $twoFactor = (string) data_get($admin, 'enable_2fa', 'disabled');
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Account Settings</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Admin <span class="gold-text">Profile</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Update operator identity, contact details, and authentication preferences from a single control surface.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.password') }}"
                    class="inline-flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="shield-check" class="mr-2 h-4 w-4"></i>
                    Security
                </a>
                <span
                    class="inline-flex items-center rounded-xl border border-yellow-500/20 bg-yellow-500/10 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-yellow-300">
                    <i data-lucide="badge-check" class="mr-2 h-4 w-4"></i>
                    {{ strtoupper($role) }}
                </span>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass overflow-hidden">
            <div class="flex flex-col gap-6 border-b border-white/5 bg-white/[0.02] p-6 sm:p-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center gap-5">
                    <div class="flex h-20 w-20 items-center justify-center rounded-[28px] gold-gradient-bg text-2xl font-black tracking-[0.18em] text-black shadow-xl shadow-yellow-500/20">
                        {{ $initials }}
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Operator Identity</p>
                        <h2 class="mt-2 text-2xl font-black tracking-tight text-white">{{ $fullName }}</h2>
                        <p class="mt-2 text-sm text-slate-400">{{ $email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Role</p>
                        <p class="mt-2 text-sm font-bold text-white">{{ $role }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-4">
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">2FA Status</p>
                        <p class="mt-2 text-sm font-bold {{ $twoFactor === 'enabled' ? 'text-emerald-400' : 'text-slate-300' }}">
                            {{ ucfirst($twoFactor) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 p-6 sm:p-8 xl:grid-cols-[minmax(0,1.45fr)_360px]">
                <div class="dashboard-glass p-6 sm:p-8">
                    <div class="mb-6">
                        <h3 class="text-lg font-black tracking-tight text-white">Profile Settings</h3>
                        <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Keep operator details current for alerts, reviews, and account recovery.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('upadprofile') }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label for="name" class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">First Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $firstName ?: $fullName) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>

                            <div>
                                <label for="lname" class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Last Name</label>
                                <input id="lname" type="text" name="lname" value="{{ old('lname', $lastName) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <div>
                                <label class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Email Address</label>
                                <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-4 text-sm text-slate-300">
                                    {{ $email }}
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Phone Number</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone', $phone) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                        </div>

                        <div>
                            <label for="token" class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Two-Factor Preference</label>
                            <select id="token" name="token"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                <option value="enabled" @selected($twoFactor === 'enabled')>Enabled</option>
                                <option value="disabled" @selected($twoFactor !== 'enabled')>Disabled</option>
                            </select>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-white/5 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <p class="text-sm text-slate-500">
                                Email is controlled at account creation level. This screen updates your operator profile metadata and 2FA preference.
                            </p>
                            <button type="submit"
                                class="inline-flex items-center justify-center rounded-2xl gold-gradient-bg px-6 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.02]">
                                Save Profile
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-6">
                    <div class="dashboard-glass p-6 sm:p-7">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-400">Account Snapshot</h3>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Email</p>
                                <p class="mt-2 text-sm font-semibold text-white break-all">{{ $email }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Phone</p>
                                <p class="mt-2 text-sm font-semibold text-white">{{ $phone ?: 'Not added' }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Last Updated</p>
                                <p class="mt-2 text-sm font-semibold text-white">{{ optional($admin->updated_at)->format('M d, Y h:i A') ?: 'Unavailable' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="dashboard-glass p-6 sm:p-7">
                        <h3 class="text-[11px] font-black uppercase tracking-[0.22em] text-slate-400">Security Actions</h3>
                        <div class="mt-5 space-y-3">
                            <a href="{{ route('admin.password') }}"
                                class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 text-sm font-semibold text-white transition-all hover:bg-white/[0.04]">
                                Change password
                                <i data-lucide="arrow-right" class="h-4 w-4 text-slate-500"></i>
                            </a>
                            <div class="rounded-2xl border border-yellow-500/20 bg-yellow-500/10 px-4 py-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-yellow-300">Current 2FA Mode</p>
                                <p class="mt-2 text-sm font-semibold text-white">
                                    {{ $twoFactor === 'enabled' ? 'Additional verification is active.' : 'Two-factor verification is currently disabled.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
