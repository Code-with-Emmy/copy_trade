@extends('layouts.dasht')
@section('title', $title)
@section('content')
    @php
        $isCryptoMethod = $payment_mode->methodtype === 'crypto';
        $walletAddress = trim((string) data_get($payment_mode, 'wallet_address', ''));
        $walletNetwork = trim((string) data_get($payment_mode, 'network', ''));
        $bankName = trim((string) data_get($payment_mode, 'bankname', ''));
        $accountName = trim((string) data_get($payment_mode, 'account_name', ''));
        $accountNumber = trim((string) data_get($payment_mode, 'account_number', ''));
        $swiftCode = trim((string) data_get($payment_mode, 'swift_code', ''));
        $hasCurrencyDetails = filled($bankName) || filled($accountName) || filled($accountNumber) || filled($swiftCode);
    @endphp

    <div class="page-content-stack animate-fadeIn" x-data="paymentHandler()">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('deposits') }}" class="hover:text-yellow-500 transition-colors">Funding</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Authorization</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Node <span class="gold-text">Liquidation</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Transmit capital through the <span class="text-white font-bold">{{ $payment_mode->name }}</span> secure gateway.</p>
            </div>

            <div class="flex items-center space-x-3">
                <div class="flex items-center px-4 py-2 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400 mr-2"></i>
                    <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Auth Protocol Active</span>
                </div>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />
        <x-error-alert />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Payment Main Panel -->
            <div class="lg:col-span-8 space-y-8">
                <div class="dashboard-glass border-white/5 overflow-hidden">
                    <!-- Instruction Ledger -->
                    <div class="bg-white/[0.02] border-b border-white/5 p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                        <div class="flex items-center space-x-5">
                            <div class="h-14 w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center shadow-2xl">
                                <i data-lucide="{{ str_contains(strtolower($payment_mode->name), 'card') ? 'credit-card' : 'zap' }}" class="w-7 h-7 gold-text"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-white uppercase tracking-tight">Transmission Details</h3>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Channel: {{ $payment_mode->name }}</p>
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/10 rounded-2xl p-4 flex flex-col items-center min-w-[160px]">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Required Quantum</span>
                            <span class="text-2xl font-black gold-text">{{ Auth::user()->currency }}{{ number_format($amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="p-8 md:p-10">
                         <form method="POST" enctype="multipart/form-data" action="{{ route('savedeposit') }}" class="space-y-10" id="paymentForm" @submit="submitting = true">
                            @csrf
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="paymethd_method" value="{{ $payment_mode->name }}">
                            <input type="hidden" name="payment_attempt_token" value="{{ $paymentAttemptToken }}">
                            @if($asset)
                                <input type="hidden" name="asset" value="{{ $asset }}">
                            @endif

                            @if($payment_mode->name == 'Credit Card' && $settings->credit_card_provider == 'Stripe')
                                <!-- Stripe Integration -->
                                <div class="space-y-6">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Secure Card Nexus</label>
                                    <div class="bg-black/50 border border-white/10 rounded-2xl p-6">
                                        <div id="card-element" class="p-4 bg-white/5 rounded-xl border border-white/5"></div>
                                        <div id="card-errors" role="alert" class="mt-4 text-[10px] font-bold text-rose-500 uppercase tracking-wider"></div>
                                    </div>
                                    <p class="text-[9px] text-slate-600 font-bold uppercase italic leading-relaxed">
                                        Encryption provided by Stripe Global Node. BitCloven does not store primary authentication keys.
                                    </p>
                                </div>
                                
                                <button type="button" id="card-button" data-secret="{{ $intent }}"
                                    class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.4em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                                    <i data-lucide="lock" class="w-5 h-5"></i>
                                    <span id="card-button-text">Finalize Protocol</span>
                                </button>
                            @else
                                <!-- Manual Deposit Integration -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                    <div class="space-y-8">
                                        <div class="space-y-4">
                                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">
                                                {{ $isCryptoMethod ? 'Relay Address' : 'Transfer Details' }}
                                            </h4>

                                            @if($isCryptoMethod)
                                                @if(filled($walletAddress))
                                                    <div class="space-y-4">
                                                        <div class="relative group">
                                                            <input type="text" value="{{ $walletAddress }}" readonly
                                                                class="w-full bg-black/50 border border-white/10 rounded-xl py-4 pl-4 pr-12 text-sm font-mono text-white focus:outline-none">
                                                            <button type="button" @click="copyToClipboard('{{ $walletAddress }}')"
                                                                class="absolute right-2 top-1/2 -translate-y-1/2 p-2 bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                                                                <i data-lucide="copy" class="w-4 h-4 gold-text" x-show="!copied"></i>
                                                                <i data-lucide="check" class="w-4 h-4 text-emerald-500" x-show="copied"></i>
                                                            </button>
                                                        </div>

                                                        @if(filled($walletNetwork))
                                                            <div class="rounded-xl border border-white/10 bg-black/30 px-4 py-4">
                                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Network</p>
                                                                <p class="mt-2 text-sm font-bold text-white">{{ $walletNetwork }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                                                        Wallet address is not configured for this payment method yet. Contact support or choose another funding channel.
                                                    </div>
                                                @endif
                                            @else
                                                @if($hasCurrencyDetails)
                                                    <div class="space-y-4">
                                                        @if(filled($bankName))
                                                            <div class="rounded-xl border border-white/10 bg-black/30 px-4 py-4">
                                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Bank Name</p>
                                                                <p class="mt-2 text-sm font-bold text-white">{{ $bankName }}</p>
                                                            </div>
                                                        @endif
                                                        @if(filled($accountName))
                                                            <div class="rounded-xl border border-white/10 bg-black/30 px-4 py-4">
                                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Account Name</p>
                                                                <p class="mt-2 text-sm font-bold text-white">{{ $accountName }}</p>
                                                            </div>
                                                        @endif
                                                        @if(filled($accountNumber))
                                                            <div class="relative rounded-xl border border-white/10 bg-black/30 px-4 py-4 pr-14">
                                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Account Number</p>
                                                                <p class="mt-2 text-sm font-bold text-white font-mono">{{ $accountNumber }}</p>
                                                                <button type="button" @click="copyToClipboard('{{ $accountNumber }}')"
                                                                    class="absolute right-3 top-1/2 -translate-y-1/2 p-2 bg-white/5 hover:bg-white/10 rounded-lg transition-all">
                                                                    <i data-lucide="copy" class="w-4 h-4 gold-text" x-show="!copied"></i>
                                                                    <i data-lucide="check" class="w-4 h-4 text-emerald-500" x-show="copied"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                        @if(filled($swiftCode))
                                                            <div class="rounded-xl border border-white/10 bg-black/30 px-4 py-4">
                                                                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Swift / Routing Code</p>
                                                                <p class="mt-2 text-sm font-bold text-white font-mono">{{ $swiftCode }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                                                        Bank transfer details are not configured for this payment method yet. Contact support or choose another funding channel.
                                                    </div>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="space-y-4">
                                            <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Identity Capture (Proof)</h4>
                                            <div class="relative">
                                                <input type="file" id="proof" name="proof" accept="image/*" required class="hidden" @change="handleFileUpload($event)">
                                                <label for="proof" class="block w-full border-2 border-dashed border-white/10 rounded-2xl p-8 text-center cursor-pointer hover:border-yellow-500/30 hover:bg-yellow-500/[0.02] transition-all group">
                                                    <div class="space-y-3">
                                                        <div class="h-12 w-12 rounded-full bg-white/5 border border-white/10 flex items-center justify-center mx-auto group-hover:scale-110 transition-transform">
                                                            <i data-lucide="upload-cloud" class="w-6 h-6 text-slate-500"></i>
                                                        </div>
                                                        <div x-show="!fileName">
                                                            <p class="text-[10px] font-black text-white uppercase tracking-widest">Upload Ledger Proof</p>
                                                            <p class="text-[9px] text-slate-600 font-bold uppercase">PNG, JPG, PDF</p>
                                                        </div>
                                                        <div x-show="fileName" class="space-y-2">
                                                            <p class="text-[10px] font-black text-emerald-400 uppercase truncate" x-text="fileName"></p>
                                                            <button type="button" @click.stop="removeFile()" class="text-[9px] font-black text-rose-500 uppercase hover:underline">Revoke</button>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        @if($isCryptoMethod && filled($walletAddress))
                                            <div class="dashboard-glass p-4 border-white/10 bg-white">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode($walletAddress) }}"
                                                    alt="Protocol Matrix" class="w-40 h-40">
                                            </div>
                                            <p class="text-[9px] text-slate-600 font-black uppercase tracking-widest text-center">Scan Node Signature</p>
                                        @else
                                            <div class="dashboard-glass border-white/10 p-6 text-center">
                                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-black/30">
                                                    <i data-lucide="{{ $isCryptoMethod ? 'wallet' : 'building-2' }}" class="h-6 w-6 gold-text"></i>
                                                </div>
                                                <p class="mt-4 text-[10px] font-black text-white uppercase tracking-widest">
                                                    {{ $isCryptoMethod ? 'Manual Crypto Transfer' : 'Bank Transfer Instructions' }}
                                                </p>
                                                <p class="mt-2 text-[9px] text-slate-500 font-bold uppercase leading-relaxed">
                                                    {{ $isCryptoMethod ? 'Send funds to the wallet details shown and upload your proof after broadcast.' : 'Send the exact amount to the account details shown and upload your transfer receipt.' }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" :disabled="!fileName || submitting"
                                    class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.4em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3 disabled:opacity-50 disabled:grayscale">
                                    <i data-lucide="send" class="w-5 h-5"></i>
                                    <span x-text="submitting ? 'PROCESSING REQUEST...' : 'Broadcast Proof to Network'"></span>
                                </button>
                            @endif
                         </form>
                    </div>
                </div>
            </div>

            <!-- Side Intelligence -->
            <div class="lg:col-span-4 space-y-6">
                <div class="dashboard-glass border-white/5 p-8 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 w-32 h-32 bg-yellow-500/5 blur-3xl"></div>
                    <h3 class="text-xs font-black text-white uppercase tracking-widest mb-8 border-b border-white/5 pb-4">
                        Settlement Guide</h3>

                    <ul class="space-y-8">
                        <li class="flex items-start space-x-4">
                            <div class="h-8 w-8 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 text-[10px] font-black gold-text">
                                01
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Quantum precision</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Ensure the transmission amount matches the required quantum exactly to avoid node sync delays.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div class="h-8 w-8 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 text-[10px] font-black gold-text">
                                02
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Block evidence</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Capture a high-fidelity image of the transaction signature (TxID) for fast manual verification.</p>
                            </div>
                        </li>
                        <li class="flex items-start space-x-4">
                            <div class="h-8 w-8 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 text-[10px] font-black gold-text">
                                03
                            </div>
                            <div>
                                <h4 class="text-[10px] font-black text-slate-300 uppercase mb-1">Network TTL</h4>
                                <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed">Transactions are typically verified within 120-300 seconds of network broadcast.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="dashboard-glass border-white/5 p-8 bg-gradient-to-br from-yellow-500/5 to-transparent flex flex-col items-center text-center">
                    <div class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center mb-6">
                        <i data-lucide="headphones" class="w-6 h-6 gold-text"></i>
                    </div>
                    <h4 class="text-xs font-black text-white uppercase tracking-tight mb-2">Sync Assistance?</h4>
                    <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-6">If protocol fails to sync after 15 minutes, please relay your node ID to the support desk.</p>
                    <a href="{{ route('support') }}" class="w-full py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-slate-300 uppercase tracking-widest hover:bg-white/10 transition-all">Support Relay</a>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        @if($payment_mode->name == 'Credit Card' && $settings->credit_card_provider == 'Stripe')
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var stripe = Stripe("{{ $settings->s_p_k }}");
                    var elements = stripe.elements();
                    var style = {
                        base: {
                            color: "#fff",
                            fontFamily: '"Inter", sans-serif',
                            fontSmoothing: "antialiased",
                            fontSize: "14px",
                            "::placeholder": { color: "#4b5563" }
                        },
                        invalid: { color: "#f43f5e", iconColor: "#f43f5e" }
                    };
                    var card = elements.create("card", { style: style });
                    card.mount("#card-element");

                    var cardButton = document.getElementById('card-button');
                    var cardErrors = document.getElementById('card-errors');
                    var buttonText = document.getElementById('card-button-text');
                    var clientSecret = cardButton.dataset.secret;

                    card.on('change', function(event) {
                        if (event.error) {
                            cardErrors.textContent = event.error.message;
                        } else {
                            cardErrors.textContent = '';
                        }
                    });

                    cardButton.addEventListener('click', function(ev) {
                        ev.preventDefault();
                        cardButton.disabled = true;
                        buttonText.textContent = "DECRYPTING...";

                        stripe.confirmCardPayment(clientSecret, {
                            payment_method: {
                                card: card,
                                billing_details: { name: "{{ Auth::user()->name }}" }
                            }
                        }).then(function(result) {
                            if (result.error) {
                                cardErrors.textContent = result.error.message;
                                cardButton.disabled = false;
                                buttonText.textContent = "RETRY PROTOCOL";
                            } else {
                                if (result.paymentIntent.status === 'succeeded') {
                                    buttonText.textContent = "SYNCING LEDGER...";
                                    fetch("{{ route('submit-stripe-payment') }}", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json",
                                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                        },
                                        body: JSON.stringify({
                                            amount: "{{ $amount }}",
                                            payment_intent_id: result.paymentIntent.id,
                                            payment_attempt_token: "{{ $paymentAttemptToken }}"
                                        })
                                    }).then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                title: 'Deposit Submitted',
                                                text: 'Your deposit has been submitted and is pending verification.',
                                                icon: 'success',
                                                background: '#090b10',
                                                color: '#e2e8f0',
                                                confirmButtonColor: '#f0b90a'
                                            }).then(() => { window.location.href = "{{ route('deposits') }}"; });
                                            return;
                                        }

                                        cardErrors.textContent = data.error || 'Global node rejection.';
                                        cardButton.disabled = false;
                                        buttonText.textContent = "RETRY PROTOCOL";
                                    })
                                    .catch(() => {
                                        cardErrors.textContent = 'Unable to confirm this payment right now. Please retry.';
                                        cardButton.disabled = false;
                                        buttonText.textContent = "RETRY PROTOCOL";
                                    });
                                }
                            }
                        });
                    });
                });
            </script>
        @endif
    @endsection

    <script>
        function paymentHandler() {
            return {
                copied: false,
                fileName: '',
                submitting: false,
                copyToClipboard(text) {
                    navigator.clipboard.writeText(text).then(() => {
                        this.copied = true;
                        setTimeout(() => { this.copied = false; }, 2000);
                    });
                },
                handleFileUpload(event) {
                    const file = event.target.files[0];
                    if (file) { this.fileName = file.name; }
                },
                removeFile() {
                    document.getElementById('proof').value = '';
                    this.fileName = '';
                }
            }
        }
        document.addEventListener('DOMContentLoaded', () => { lucide.createIcons(); });
    </script>

@endsection
