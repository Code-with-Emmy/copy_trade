@extends('layouts.admin-dasht')

@section('content')
    @php
        $processedDeposits = $deposits->where('status', 'Processed');
        $pendingDeposits = $deposits->where('status', '!=', 'Processed');
        $totalVolume = (float) $deposits->sum('amount');
        $processedVolume = (float) $processedDeposits->sum('amount');
        $largestDeposit = (float) $deposits->max('amount');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Funding Operations</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Deposit <span class="gold-text">Control</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Review incoming client funding, validate evidence, and move approved deposits through the treasury queue from one consistent control surface.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="layout-grid" class="mr-2 h-4 w-4"></i>
                    Dashboard
                </a>
                <a href="{{ route('admin.withdrawals.index') }}"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="arrow-up-right" class="mr-2 h-4 w-4"></i>
                    Withdrawals
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Deposit Volume</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ $settings->currency }}{{ number_format($totalVolume, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ number_format($deposits->count()) }} requests logged</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Processed Funding</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ $settings->currency }}{{ number_format($processedVolume, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-emerald-400">{{ number_format($processedDeposits->count()) }} completed deposits</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Pending Review</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($pendingDeposits->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-yellow-400">Awaiting confirmation or processing</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Largest Ticket</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ $settings->currency }}{{ number_format($largestDeposit, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Highest single funding request</p>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-white/5 bg-white/[0.02] p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Deposit Queue</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Full list of funding requests, payment modes, and review actions</p>
                </div>
                <div class="rounded-2xl border border-white/5 bg-black/30 px-4 py-3 text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Live Snapshot</p>
                    <p class="mt-1 text-sm font-bold text-white">{{ number_format($pendingDeposits->count()) }} pending / {{ number_format($processedDeposits->count()) }} processed</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 text-sm">
                    <thead class="bg-black/20">
                        <tr class="text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Method</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Created</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($deposits as $deposit)
                            <tr class="transition-colors hover:bg-white/[0.03]">
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-1">
                                        <p class="font-bold text-white">{{ data_get($deposit, 'duser.name', 'Deleted User') }}</p>
                                        <p class="text-xs text-slate-400">{{ data_get($deposit, 'duser.email', 'No email available') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top font-black text-white">
                                    {{ $settings->currency }}{{ number_format((float) $deposit->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 align-top text-slate-300">{{ $deposit->payment_mode }}</td>
                                <td class="px-6 py-4 align-top text-slate-300">
                                    {{ blank($deposit->signals) ? 'Deposit Payment' : 'Signal Payment' }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $deposit->status === 'Processed' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                        {{ $deposit->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top text-slate-400">
                                    {{ optional($deposit->created_at)->toDayDateTimeString() }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <a href="{{ route('viewdepositimage', $deposit->id) }}"
                                            class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                            View
                                        </a>
                                        @if ($deposit->status !== 'Processed')
                                            <a href="{{ route('pdeposit', $deposit->id) }}"
                                                class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-emerald-300 transition-all hover:bg-emerald-500/20">
                                                Process
                                            </a>
                                        @endif
                                        <a href="{{ route('deldeposit', $deposit->id) }}"
                                            class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20"
                                            onclick="return confirm('Delete this deposit request?')">
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/5">
                                            <i data-lucide="landmark" class="h-6 w-6 text-slate-500"></i>
                                        </div>
                                        <p class="mt-4 text-sm font-bold text-white">No deposit requests found.</p>
                                        <p class="mt-2 text-xs text-slate-500">New funding requests will appear here once clients submit deposit evidence.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
