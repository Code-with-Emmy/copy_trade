@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Trade Operations</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">User Trade <span class="gold-text">Control</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Track open positions, review trade allocation, and audit investor activity across the platform from one operations surface.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="layout-grid" class="mr-2 h-4 w-4"></i>
                    Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Trades</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($stats['total'] ?? 0) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">All trade records</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active Trades</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ number_format($stats['active'] ?? 0) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-emerald-400">Open positions still running</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Completed Trades</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($stats['expired'] ?? 0) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Expired or settled positions</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Trade Volume</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">${{ number_format((float) ($stats['total_volume'] ?? 0), 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Total capital allocated</p>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8">
            <div class="flex flex-col gap-2 border-b border-white/5 pb-5">
                <h2 class="text-lg font-black uppercase tracking-tight text-white">Filter Trade Book</h2>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Search by investor, status, instrument, or position type</p>
            </div>

            <form method="GET" action="{{ route('admin.trades.index') }}" class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-5">
                <label class="block">
                    <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Search User</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email"
                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all placeholder:text-slate-600 focus:border-yellow-500/40">
                </label>

                <label class="block">
                    <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Status</span>
                    <select name="status"
                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        <option value="">All statuses</option>
                        <option value="yes" @selected(request('status') === 'yes')>Active</option>
                        <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Trade Type</span>
                    <select name="type"
                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        <option value="">All types</option>
                        <option value="Buy" @selected(request('type') === 'Buy')>Buy</option>
                        <option value="Sell" @selected(request('type') === 'Sell')>Sell</option>
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Asset</span>
                    <input type="text" name="asset" value="{{ request('asset') }}" placeholder="BTC, EURUSD, Gold"
                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all placeholder:text-slate-600 focus:border-yellow-500/40">
                </label>

                <div class="flex items-end gap-3">
                    <button type="submit"
                        class="flex-1 rounded-2xl gold-gradient-bg px-4 py-3 text-[10px] font-black uppercase tracking-widest text-black transition-all hover:scale-[1.02]">
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.trades.index') }}"
                        class="rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-white/5 bg-white/[0.02] p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Trade Ledger</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">{{ number_format($trades->total()) }} records matched the current filter set</p>
                </div>
                <div class="rounded-2xl border border-white/5 bg-black/30 px-4 py-3 text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Page Summary</p>
                    <p class="mt-1 text-sm font-bold text-white">{{ number_format($trades->count()) }} trades on this page</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 text-sm">
                    <thead class="bg-black/20">
                        <tr class="text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <th class="px-6 py-4">Investor</th>
                            <th class="px-6 py-4">Asset</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Amount</th>
                            <th class="px-6 py-4">Leverage</th>
                            <th class="px-6 py-4">PnL</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Opened</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse ($trades as $trade)
                            <tr class="transition-colors hover:bg-white/[0.03]">
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-1">
                                        <p class="font-bold text-white">{{ data_get($trade, 'user.name', 'Deleted User') }}</p>
                                        <p class="text-xs text-slate-400">{{ data_get($trade, 'user.email', 'No email available') }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-1">
                                        <p class="font-bold text-white">{{ $trade->assets ?: 'N/A' }}</p>
                                        <p class="text-xs text-slate-400">{{ $trade->symbol ?: 'No symbol' }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $trade->type === 'Buy' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-rose-500/10 text-rose-300' }}">
                                        {{ $trade->type ?: 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top font-black text-white">${{ number_format((float) $trade->amount, 2) }}</td>
                                <td class="px-6 py-4 align-top text-slate-300">{{ $trade->leverage ? $trade->leverage . 'x' : 'Spot' }}</td>
                                <td class="px-6 py-4 align-top font-black {{ (float) $trade->profit_earned >= 0 ? 'text-emerald-400' : 'text-rose-300' }}">
                                    ${{ number_format((float) ($trade->profit_earned ?? 0), 2) }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $trade->active === 'yes' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-white/5 text-slate-400' }}">
                                        {{ $trade->active === 'yes' ? 'Active' : ucfirst((string) $trade->active) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top text-slate-400">
                                    {{ optional($trade->created_at)->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <a href="{{ route('admin.trades.edit', $trade->id) }}"
                                            class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/5">
                                            <i data-lucide="trending-up" class="h-6 w-6 text-slate-500"></i>
                                        </div>
                                        <p class="mt-4 text-sm font-bold text-white">No trades matched the current filters.</p>
                                        <p class="mt-2 text-xs text-slate-500">Clear the filters or wait for new trading activity to populate the ledger.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($trades->hasPages())
                <div class="border-t border-white/5 px-6 py-5">
                    {{ $trades->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
