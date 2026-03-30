@extends('layouts.dasht')

@section('content')
<div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(34,211,238,0.12),_transparent_30%),linear-gradient(180deg,_#020617_0%,_#020617_38%,_#08111f_100%)] pb-16">
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        @if(session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-5 py-4 text-sm text-emerald-100">{{ session('success') }}</div>
        @endif

        <div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
            <div class="rounded-[32px] border border-white/10 bg-slate-950/70 p-6 shadow-2xl shadow-slate-950/50 backdrop-blur-xl">
                <p class="text-xs uppercase tracking-[0.25em] text-cyan-300">Wallet Architecture</p>
                <h1 class="mt-2 text-3xl font-semibold text-white">Funding, ledger, and reconciliation</h1>
                <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-1">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Available Balance</p>
                        <p class="mt-3 text-3xl font-semibold text-white">{{ auth()->user()->currency }}{{ number_format((float) $wallet->available_balance, 2) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Reserved Balance</p>
                        <p class="mt-3 text-3xl font-semibold text-cyan-300">{{ auth()->user()->currency }}{{ number_format((float) $wallet->reserved_balance, 2) }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('wallet.deposit') }}" class="mt-6 space-y-4">
                    @csrf
                    <p class="text-xs uppercase tracking-[0.2em] text-slate-500">Initiate Deposit</p>
                    <input type="number" name="amount" min="10" step="0.01" placeholder="Amount" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-cyan-400/40 focus:outline-none">
                    <select name="gateway" class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white focus:border-cyan-400/40 focus:outline-none">
                        <option value="manual">Manual / Admin review</option>
                        <option value="paystack">Paystack</option>
                        <option value="stripe">Stripe</option>
                        <option value="flutterwave">Flutterwave</option>
                        <option value="crypto">Crypto</option>
                    </select>
                    <button type="submit" class="w-full rounded-2xl bg-gradient-to-r from-cyan-400 via-sky-400 to-emerald-400 px-4 py-3 text-sm font-semibold text-slate-950 transition hover:brightness-110">Create Deposit Reference</button>
                </form>

                <div class="mt-6 rounded-2xl border border-amber-400/20 bg-amber-400/10 p-4 text-sm leading-7 text-amber-50">
                    Withdrawals, fee deductions, and subscription allocations should all pass through the same ledger stream for audit, statement export, and future payment reconciliation.
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-[32px] border border-white/10 bg-slate-950/70 p-6 shadow-2xl shadow-slate-950/50 backdrop-blur-xl">
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-300">Transactions</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Recent funding events</h2>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/10 text-sm text-slate-300">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-[0.25em] text-slate-500">
                                    <th class="pb-3">Reference</th>
                                    <th class="pb-3">Type</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($wallet->transactions as $transaction)
                                    <tr>
                                        <td class="py-3 text-white">{{ $transaction->reference }}</td>
                                        <td class="py-3 uppercase">{{ str_replace('_', ' ', $transaction->type) }}</td>
                                        <td class="py-3">{{ ucfirst($transaction->status) }}</td>
                                        <td class="py-3 text-right">{{ auth()->user()->currency }}{{ number_format((float) $transaction->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-slate-500">No platform transactions recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-[32px] border border-white/10 bg-slate-950/70 p-6 shadow-2xl shadow-slate-950/50 backdrop-blur-xl">
                    <p class="text-xs uppercase tracking-[0.25em] text-cyan-300">Ledger</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white">Balance-changing entries</h2>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full divide-y divide-white/10 text-sm text-slate-300">
                            <thead>
                                <tr class="text-left text-xs uppercase tracking-[0.25em] text-slate-500">
                                    <th class="pb-3">Entry</th>
                                    <th class="pb-3">Direction</th>
                                    <th class="pb-3">Before</th>
                                    <th class="pb-3">After</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($wallet->ledgers as $ledger)
                                    <tr>
                                        <td class="py-3 text-white">{{ strtoupper($ledger->entry_type) }}</td>
                                        <td class="py-3">{{ ucfirst($ledger->direction) }}</td>
                                        <td class="py-3">{{ auth()->user()->currency }}{{ number_format((float) $ledger->balance_before, 2) }}</td>
                                        <td class="py-3">{{ auth()->user()->currency }}{{ number_format((float) $ledger->balance_after, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-slate-500">No wallet ledger entries yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
