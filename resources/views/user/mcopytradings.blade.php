@extends('layouts.dasht')
@section('title', $title)

@section('scripts')
    @parent
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <div class="space-y-10 animate-fadeIn">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Legacy Alpha Marketplace</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Signal <span class="gold-text">Marketplace</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Follow top-performing traders and automatically replicate
                    their winning strategies.</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="layout-dashboard" class="w-4 h-4 mr-2"></i>
                    Command Center
                </a>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div
                    class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                </div>
                <div class="flex items-center space-x-5 mb-4">
                    <div
                        class="h-12 w-12 rounded-xl bg-yellow-500/10 border border-yellow-500/20 flex items-center justify-center">
                        <i data-lucide="users" class="w-6 h-6 gold-text"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Global
                            Nodes</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">{{ count($copytradings) }}
                            Verified</div>
                    </div>
                </div>
                <div class="flex items-center text-[9px] font-bold text-emerald-400 uppercase tracking-widest">
                    <i data-lucide="check-circle" class="w-3 h-3 mr-2"></i>
                    Active & Synchronized
                </div>
            </div>

            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div
                    class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                </div>
                <div class="flex items-center space-x-5 mb-4">
                    <div
                        class="h-12 w-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                        <i data-lucide="trending-up" class="w-6 h-6 text-emerald-500"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Alpha
                            Yield</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">87% Avg</div>
                    </div>
                </div>
                <div class="flex items-center text-[9px] font-bold text-emerald-400 uppercase tracking-widest">
                    <i data-lucide="activity" class="w-3 h-3 mr-2"></i>
                    High-Consistency Yield
                </div>
            </div>

            <div class="dashboard-glass p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div
                    class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                </div>
                <div class="flex items-center space-x-5 mb-4">
                    <div class="h-12 w-12 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center">
                        <i data-lucide="shield" class="w-6 h-6 text-slate-400"></i>
                    </div>
                    <div>
                        <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest">Entry
                            Threshold</span>
                        <div class="text-2xl font-black text-white italic tracking-tighter">{{ $settings->currency }}50.00
                        </div>
                    </div>
                </div>
                <div class="flex items-center text-[9px] font-bold text-slate-500 uppercase tracking-widest">
                    <i data-lucide="lock" class="w-3 h-3 mr-2 gold-text"></i>
                    Low Barriers to Entry
                </div>
            </div>
        </div>

        <!-- Alerts -->
        <div class="space-y-4">
            @if(session('success'))
                <div
                    class="p-6 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 text-[11px] font-black text-emerald-400 uppercase tracking-widest italic animate-pulse">
                    <i data-lucide="check" class="w-4 h-4 inline mr-2 mb-0.5"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div
                    class="p-6 rounded-2xl bg-rose-500/5 border border-rose-500/10 text-[11px] font-black text-rose-400 uppercase tracking-widest italic">
                    <i data-lucide="alert-triangle" class="w-4 h-4 inline mr-2 mb-0.5"></i>
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <!-- Traders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($copytradings as $copytrading)
                <div
                    class="dashboard-glass border-white/5 p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all flex flex-col h-full">
                    <div
                        class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
                    </div>

                    <div class="flex items-start justify-between mb-8">
                        <div class="flex items-center space-x-5">
                            <div class="relative">
                                <div
                                    class="h-20 w-20 rounded-[24px] bg-black border border-white/10 p-1 group-hover:border-yellow-500/30 transition-all shadow-2xl">
                                    @if($copytrading->photo)
                                        <img src="{{ asset('storage/' . $copytrading->photo) }}"
                                            class="h-full w-full rounded-[20px] object-cover">
                                    @else
                                        <div class="h-full w-full flex items-center justify-center">
                                            <span
                                                class="text-2xl font-black gold-text italic tracking-tighter">{{ strtoupper(substr($copytrading->name, 0, 1)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <!-- Verified Shield -->
                                <div
                                    class="absolute -bottom-1 -right-1 h-7 w-7 bg-emerald-500 rounded-lg flex items-center justify-center border-4 border-[#0a0a0a] shadow-lg">
                                    <i data-lucide="check" class="w-3 h-3 text-black"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    class="px-2 py-0.5 rounded-md bg-yellow-500/10 border border-yellow-500/20 text-[8px] font-black gold-text uppercase tracking-widest mb-2 inline-block italic">{{ $copytrading->tag ?: 'PRO' }}</span>
                                <h3
                                    class="text-xl font-black text-white italic tracking-tighter uppercase group-hover:gold-text transition-colors">
                                    {{ $copytrading->name }}</h3>
                                <div class="flex items-center mt-1 space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star"
                                            class="w-2.5 h-2.5 {{ $i <= $copytrading->rating ? 'gold-text fill-yellow-500' : 'text-slate-700' }}"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-8">
                        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
                            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Sub
                                Nodes</span>
                            <div class="text-xl font-black italic tracking-tighter text-white font-mono">
                                {{ number_format($copytrading->followers) }}
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
                            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">ROE
                                Map</span>
                            <div class="text-xl font-black italic tracking-tighter text-emerald-400 font-mono">
                                +{{ $copytrading->equity }}%
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
                            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Entry
                                barrier</span>
                            <div class="text-lg font-black italic tracking-tighter text-white font-mono">
                                {{ $settings->currency }}{{ number_format($copytrading->price) }}
                            </div>
                        </div>
                        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
                            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Signal
                                Cap</span>
                            <div class="text-lg font-black italic tracking-tighter text-emerald-400 font-mono">
                                {{ $settings->currency }}{{ number_format($copytrading->total_profit) }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-6 border-t border-white/5">
                        @if(in_array($copytrading->id, $userCopyTrades))
                            <form method="post" action="{{ route('cancelcopytrade') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full py-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 text-[9px] font-black uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                                    Termination Protocol
                                </button>
                            </form>
                        @else
                            <button
                                onclick="openInvestModal({{ $copytrading->id }}, '{{ $copytrading->name }}', {{ $copytrading->price }})"
                                class="w-full py-4 gold-gradient-bg rounded-xl text-black font-black text-[9px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-105 transition-all">
                                Synchronize Node
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        function openInvestModal(expertId, expertName, minAmount) {
            Swal.fire({
                title: `<div class='text-white font-black italic uppercase tracking-tight text-2xl mb-2'>SYNC NODAL PROTOCOL</div>`,
                html: `
                    <div class="text-left space-y-6 p-2">
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest leading-relaxed">Configuring synchronization barrier for <span class='gold-text italic'>${expertName}</span>. Allocation will be deployed proportionally to market signals.</p>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Capital Deployment (${minAmount} Min)</label>
                            <div class="bg-black/50 border border-white/10 rounded-2xl p-2 focus-within:border-yellow-500/50 transition-all">
                                 <input type="number" 
                                       id="investAmount" 
                                       class="w-full bg-transparent border-none text-white font-black font-mono text-xl py-2 px-4 focus:ring-0" 
                                       placeholder="0.00"
                                       min="${minAmount}"
                                       step="0.01"
                                       value="${minAmount}">
                            </div>
                        </div>
                        <div class="p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10 text-[9px] text-slate-500 font-medium leading-relaxed italic uppercase tracking-tighter">
                            <i data-lucide="shield-alert" class="w-3 h-3 gold-text inline mr-1 mb-0.5"></i>
                            Alpha copying utilizes high-frequency relay vectors. Past yield does not guarantee forward returns. Deploy responsible capitol only.
                        </div>
                    </div>
                `,
                background: '#0a0a0a',
                showCancelButton: true,
                confirmButtonText: 'INITIALIZE SYNC',
                cancelButtonText: 'ABORT',
                buttonsStyling: false,
                customClass: {
                    popup: 'rounded-[32px] border border-white/10 shadow-2xl',
                    confirmButton: 'flex-1 py-4 px-8 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest mx-2 hover:scale-105 transition-all',
                    cancelButton: 'flex-1 py-4 px-8 bg-white/5 border border-white/10 rounded-xl text-white font-black text-[10px] uppercase tracking-widest mx-2 hover:bg-white/10 transition-all'
                },
                preConfirm: () => {
                    const amount = document.getElementById('investAmount').value;
                    if (!amount || amount < minAmount) {
                        Swal.showValidationMessage(`Barrier failure: Minimum capital deployment required is $${minAmount}`);
                        return false;
                    }
                    return { expertId, amount };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("joincopytrade") }}';

                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    const expertIdInput = document.createElement('input');
                    expertIdInput.type = 'hidden';
                    expertIdInput.name = 'expert_id';
                    expertIdInput.value = result.value.expertId;
                    form.appendChild(expertIdInput);

                    const amountInput = document.createElement('input');
                    amountInput.type = 'hidden';
                    amountInput.name = 'amount';
                    amountInput.value = result.value.amount;
                    form.appendChild(amountInput);

                    document.body.appendChild(form);
                    form.submit();
                }
            });

            // Re-init icons for Swal
            setTimeout(() => lucide.createIcons(), 100);
        }

        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>

    <style>
        .swal2-container {
            z-index: 9999 !important;
        }
    </style>
@endsection