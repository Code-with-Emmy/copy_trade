<div>
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <span class="admin-page-kicker">Managed Accounts</span>
                <h1 class="title1 mb-0">Fund Trading <span class="gold-text">Wallet</span></h1>
                <p class="admin-page-subtitle">Create an operator-side funding request, confirm the crypto destination, and complete wallet settlement without leaving the admin workflow.</p>
            </div>
            <div class="admin-page-actions">
                <a href="{{ route('tsettings') }}" class="btn btn-outline-light btn-sm">
                    <i class="fa fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
        </section>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Payment Asset</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $method ?: 'USDT' }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Treasury settlement asset configured for this funding run.</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Requested Amount</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">${{ $amount ?: '0.00' }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Current amount being prepared for the wallet funding flow.</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Flow State</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $toPay ? 'Awaiting Confirmation' : 'Draft Request' }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Switches to confirmation once the operator advances the payment request.</p>
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-lg-8 offset-lg-2">
                <div class="card p-4 p-md-5">
                    @if (!$toPay)
                        <div class="mb-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Funding Request</p>
                            <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Create Payment</h3>
                        </div>

                        <form wire:submit.prevent='setToPay'>
                            <div class="form-group">
                                <label>Enter Amount ($)</label>
                                <input type="number" wire:model.defer='amount' class="form-control" required>
                            </div>

                            <div class="my-4">
                                <label class="mb-3">Payment Method</label>
                                <div class="rounded-3xl border border-white/5 bg-white/5 p-4">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div class="rounded-2xl border border-warning bg-light p-3 text-center shadow-sm">
                                            <img src="{{ asset('dash/tether-usdt-logo.png') }}" alt="USDT" style="width: 25px;">
                                            <h5 class="mb-0 mt-2">Tether (USDT)</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">Continue to Payment</button>
                            </div>
                        </form>
                    @endif

                    @if ($toPay)
                        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4" style="gap:.75rem;">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Payment Confirmation</p>
                                <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Complete Settlement</h3>
                            </div>
                            <button type="button" class="btn btn-warning btn-sm" wire:click='unSetToPay'>Back</button>
                        </div>

                        <form wire:submit.prevent='completePayment'>
                            <div class="form-group rounded-3xl border border-white/5 bg-white/5 p-4">
                                <p class="mb-2 text-sm text-slate-300">
                                    Please send ${{ $amount }} of {{ $method }} to the wallet address below.
                                </p>
                                <h2 class="mb-0 text-2xl font-black tracking-tight text-white">{{ $walletAddress }}</h2>
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">Complete Payment</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
