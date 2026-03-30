@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <a href="{{ route('admin.trades.index') }}" class="transition-colors hover:text-yellow-500">Trades</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Edit Trade #{{ $trade->id }}</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Trade <span class="gold-text">Editor</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Update trade configuration, capital allocation, leverage, and trade lifecycle fields without leaving the admin desk.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.trades.index') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                    Back to Trades
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4">
                <p class="text-xs font-black uppercase tracking-widest text-rose-300">Please fix the highlighted errors</p>
                <ul class="mt-3 space-y-2 text-sm text-rose-100">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-8 xl:col-span-2">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Update Trade Details</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Adjust market, direction, allocation, and execution status</p>
                </div>

                <form method="POST" action="{{ route('admin.trades.update', $trade->id) }}" class="mt-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Asset</span>
                            <input type="text" id="assets" name="assets" value="{{ old('assets', $trade->assets) }}" required
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Symbol</span>
                            <input type="text" id="symbol" name="symbol" value="{{ old('symbol', $trade->symbol) }}" placeholder="BTC/USD"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all placeholder:text-slate-600 focus:border-yellow-500/40">
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Trade Type</span>
                            <select id="type" name="type" required
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                                <option value="">Select type</option>
                                <option value="Buy" @selected(old('type', $trade->type) === 'Buy')>Buy</option>
                                <option value="Sell" @selected(old('type', $trade->type) === 'Sell')>Sell</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Amount ($)</span>
                            <input type="number" id="amount" name="amount" value="{{ old('amount', $trade->amount) }}" step="0.01" min="0" required
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Leverage</span>
                            <input type="number" id="leverage" name="leverage" value="{{ old('leverage', $trade->leverage) }}" min="1" max="1000"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                            <span class="mt-2 block text-xs text-slate-500">Leave empty for spot or non-leveraged entries.</span>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Profit / Loss ($)</span>
                            <input type="number" id="profit_earned" name="profit_earned" value="{{ old('profit_earned', $trade->profit_earned) }}" step="0.01"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                            <span class="mt-2 block text-xs text-slate-500">Use negative values to record losses.</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Status</span>
                            <select id="active" name="active" required
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                                <option value="yes" @selected(old('active', $trade->active) === 'yes')>Active</option>
                                <option value="expired" @selected(old('active', $trade->active) === 'expired')>Expired</option>
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Expiry Date</span>
                            <input type="datetime-local" id="expire_date" name="expire_date"
                                value="{{ old('expire_date', $trade->expire_date ? \Carbon\Carbon::parse($trade->expire_date)->format('Y-m-d\TH:i') : '') }}"
                                class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3 border-t border-white/5 pt-6">
                        <a href="{{ route('admin.trades.index') }}"
                            class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                            Cancel
                        </a>
                        <button type="submit"
                            class="rounded-2xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black transition-all hover:scale-[1.02]">
                            Save Trade
                        </button>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Trade Owner</p>
                    <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ data_get($trade, 'user.name', 'Deleted User') }}</h2>
                    <p class="mt-2 text-sm text-slate-400">{{ data_get($trade, 'user.email', 'No email available') }}</p>
                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Created</span>
                            <span class="font-bold text-white">{{ optional($trade->created_at)->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Current Status</span>
                            <span class="font-bold {{ $trade->active === 'yes' ? 'text-yellow-400' : 'text-slate-300' }}">{{ $trade->active === 'yes' ? 'Active' : ucfirst((string) $trade->active) }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-500">Current PnL</span>
                            <span class="font-bold {{ (float) $trade->profit_earned >= 0 ? 'text-emerald-400' : 'text-rose-300' }}">${{ number_format((float) ($trade->profit_earned ?? 0), 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Editing Guidance</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-400">
                        <p>Use the asset and symbol fields to keep reporting consistent across the admin ledger.</p>
                        <p>Only mark a trade expired when the underlying position should stop appearing as active in the dashboard.</p>
                        <p>Profit and loss updates should match whatever will be reflected in user-facing performance reporting.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
