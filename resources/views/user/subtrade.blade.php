@php
    $sub_link = 'https://trade.mql5.com/trade';
@endphp
@extends('layouts.dasht')
@section('title', 'Copy Trading')
@section('content')

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="{ showModal: false, showCancelModal: false }">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Copy Trading</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Copy <span class="gold-text">Trading</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Connect your trading account to our system.</p>
            </div>

            <div class="flex items-center space-x-3">
                <button @click="showModal = true"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Connect Account
                </button>
            </div>
        </div>

        <!-- Alert Messages -->
        <x-danger-alert />
        <x-success-alert />

        <!-- Intro Card -->
        <div class="dashboard-glass border-white/5 p-8 md:p-10 relative overflow-hidden group">
            <div
                class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none group-hover:bg-yellow-500/10 transition-all duration-1000">
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-10 relative">
                <div class="max-w-2xl">
                    <div
                        class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-yellow-500 text-[10px] font-black uppercase tracking-widest mb-6">
                        <i data-lucide="award" class="w-3.5 h-3.5 mr-2"></i>
                        Professional Service
                    </div>
                    <h2 class="text-3xl font-black text-white mb-4 tracking-tight">Automated Trading <span
                            class="gold-text">System</span></h2>
                    <p class="text-slate-400 text-sm font-medium leading-relaxed mb-8">
                        Don’t have time to trade or learn how to trade? Our Account Management Service is the premier
                        profitable trading option. We manage your infrastructure in the decentralized market with a simple
                        subscription model.
                    </p>
                    <div class="flex items-center space-x-8">
                        <div class="flex items-center space-x-3">
                            <div
                                class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/5">
                                <i data-lucide="shield-check" class="w-5 h-5 gold-text"></i>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-white uppercase tracking-tighter">Safe &
                                    Secure</span>
                                <span
                                    class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Professional
                                    System</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div
                                class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center border border-white/5">
                                <i data-lucide="zap" class="w-5 h-5 text-purple-400"></i>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black text-white uppercase tracking-tighter">Fast
                                    Execution</span>
                                <span class="block text-[9px] font-bold text-slate-500 uppercase tracking-tighter">Direct
                                    Connection</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-72 bg-black/40 rounded-3xl p-8 border border-white/5 text-center">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Support Help</h4>
                    <div
                        class="text-lg font-black text-white mb-2 select-all cursor-pointer hover:gold-text transition-colors">
                        {{ $settings->contact_email }}
                    </div>
                    <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest leading-relaxed">Contact our
                        support team for any custom help with your account.</p>
                </div>
            </div>
        </div>

        <!-- Active Managed Accounts -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-black text-white uppercase tracking-[0.2em] ml-1">Connected Accounts</h3>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ count($subscriptions) }}
                    Accounts Active</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @forelse ($subscriptions as $sub)
                    <div
                        class="dashboard-glass border-white/5 p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center">
                                <i data-lucide="server" class="w-6 h-6 gold-text"></i>
                            </div>
                            <div class="text-right">
                                <span
                                    class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Status</span>
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter {{ $sub->status == 'Active' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-yellow-500/10 text-yellow-500' }}">
                                    {{ $sub->status }}
                                </span>
                            </div>
                        </div>

                        <h4 class="text-xl font-black text-white mb-6 font-mono tracking-tighter">{{ $sub->mt4_id }} <span
                                class="text-slate-600">/</span> <span class="text-slate-400">{{ $sub->account_type }}</span>
                        </h4>

                        <div class="space-y-4 mb-10">
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-black text-slate-500 uppercase tracking-widest">Trading Platform</span>
                                <span class="font-bold text-slate-300">{{ $sub->server }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-black text-slate-500 uppercase tracking-widest">Leverage</span>
                                <span class="font-bold text-white">{{ $sub->leverage }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-black text-slate-500 uppercase tracking-widest">Base Currency</span>
                                <span class="font-bold text-white">{{ $sub->currency }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[10px]">
                                <span class="font-black text-slate-500 uppercase tracking-widest">Subscription Cycle</span>
                                <span class="font-bold text-white">{{ $sub->duration }}</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <button onclick="deletemt4()"
                                class="flex-1 py-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-[10px] font-black text-rose-500 uppercase tracking-widest hover:bg-rose-500 hover:text-white transition-all">
                                Disconnect Account
                            </button>
                            @php
                                $remindAt = \Carbon\Carbon::parse($sub->reminded_at);
                            @endphp
                            @if (($sub->status != 'Pending' && now()->isSameDay($remindAt)) || $sub->status == 'Expired')
                                <a href="{{ route('renewsub', $sub->id) }}"
                                    class="flex-1 py-3 text-center rounded-xl gold-gradient-bg text-[10px] font-black text-black uppercase tracking-widest hover:scale-105 transition-all">
                                    Renew Account
                                </a>
                            @endif
                        </div>

                        <div
                            class="mt-6 pt-6 border-t border-white/5 flex flex-col space-y-2 opacity-40 text-[9px] font-bold text-slate-500 uppercase">
                            <div class="flex items-center">
                                <i data-lucide="clock" class="w-3 h-3 mr-2"></i>
                                Expires:
                                {{ !empty($sub->end_date) ? \Carbon\Carbon::parse($sub->end_date)->format('M d, Y') : 'Pending Connection' }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center opacity-30 select-none">
                        <i data-lucide="monitor-off" class="w-16 h-16 mx-auto mb-6"></i>
                        <p class="text-[10px] font-black uppercase tracking-widest">No connected accounts
                            found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Web Terminal Integration -->
        <div class="dashboard-glass border-white/5 overflow-hidden">
            <div class="p-8 border-b border-white/5 flex items-center justify-between">
                <div>
                    <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Live Trading Overview</h3>
                    <p class="text-[10px] text-slate-500 uppercase font-black tracking-tighter mt-1">Real-time data from
                        global markets</p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Live Stream
                        Active</span>
                </div>
            </div>
            <div class="relative bg-black h-[70vh]">
                <iframe src="{{ $sub_link }}" name="WebTrader" title="{{ $title }}" frameborder="0"
                    class="absolute inset-0 w-full h-full grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-700"></iframe>
            </div>
        </div>
    </div>

    <!-- Implementation Modal -->
    <div x-show="showModal" x-transition.opacity
        class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-black/95 backdrop-blur-md">
        <div @click.away="showModal = false"
            class="bg-[#0a0a0a] border border-white/10 rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl relative">
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none"></div>

            <div class="p-10">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">Connect <span
                            class="gold-text">Account</span></h3>
                    <button @click="showModal = false" class="text-slate-500 hover:text-white transition-colors">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                @include('user.modals')
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });

        function deletemt4() {
            Swal.fire({
                title: "Action Disabled",
                text: "To disconnect your account, please contact our support team at {{ $settings->contact_email }}",
                icon: "error",
                background: '#0a0a0a',
                color: '#fff',
                confirmButtonColor: '#f0b90a'
            });
        }
    </script>
@endsection