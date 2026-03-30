@extends('layouts.dasht')
@section('title', 'Trading Bots')
@section('content')

    <div class="space-y-12 animate-in fade-in slide-in-from-bottom-8 duration-1000">

        <!-- Hero Section -->
        <div class="relative overflow-hidden rounded-[32px] bg-black border border-white/5 py-24 px-12 group">
            <!-- Background accents -->
            <div
                class="absolute -right-24 -top-24 w-96 h-96 bg-yellow-500/10 blur-[120px] rounded-full group-hover:bg-yellow-500/20 transition-all duration-1000">
            </div>
            <div class="absolute -left-24 -bottom-24 w-96 h-96 bg-white/5 blur-[120px] rounded-full"></div>

            <div class="relative z-10 max-w-3xl">
                <div
                    class="inline-flex items-center px-4 py-1.5 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-[10px] font-black gold-text uppercase tracking-[0.2em] mb-8">
                    <i data-lucide="cpu" class="w-3.5 h-3.5 mr-2 animate-pulse"></i>
                    Smart System Active
                </div>

                <h1 class="text-5xl lg:text-7xl font-black tracking-tighter uppercase leading-none mb-8">
                    Smart <br>
                    <span class="gold-text">Trading Bots</span>
                </h1>

                <p class="text-slate-400 text-lg font-medium leading-relaxed mb-10">
                    Turn on smart trading bots to grow your money across different markets.
                    Our system monitors thousands of points to find the best trades
                    for you automatically with high accuracy.
                </p>

                <div class="flex flex-wrap gap-6">
                    <a href="{{ route('user.bots.index') }}"
                        class="h-14 px-10 rounded-2xl gold-gradient text-black font-black uppercase tracking-[0.2em] flex items-center text-xs shadow-2xl shadow-yellow-500/30 hover:scale-[1.05] transform transition-all active:scale-95 group">
                        Get Started
                        <i data-lucide="arrow-right"
                            class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <div class="flex items-center space-x-4 bg-white/5 px-8 rounded-2xl border border-white/10">
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Always
                                Online</span>
                            <span class="text-xs font-black text-white uppercase tracking-widest">99.98%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="dashboard-glass p-10 group hover:border-yellow-500/30 transition-all">
                <div
                    class="h-14 w-14 rounded-2xl bg-white/5 flex items-center justify-center mb-8 group-hover:bg-yellow-500/10 transition-colors">
                    <i data-lucide="zap" class="w-6 h-6 gold-text"></i>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-4">Fast Trading</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Your trades are processed instantly across major global markets for maximum profit.
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="dashboard-glass p-10 group hover:border-yellow-500/30 transition-all">
                <div
                    class="h-14 w-14 rounded-2xl bg-white/5 flex items-center justify-center mb-8 group-hover:bg-yellow-500/10 transition-colors">
                    <i data-lucide="shield-check" class="w-6 h-6 text-emerald-400"></i>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-4">Auto Protection</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    Smart safety guards automatically protect your money and pause trades if markets get too risky.
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="dashboard-glass p-10 group hover:border-yellow-500/30 transition-all">
                <div
                    class="h-14 w-14 rounded-2xl bg-white/5 flex items-center justify-center mb-8 group-hover:bg-yellow-500/10 transition-colors">
                    <i data-lucide="refresh-cw" class="w-6 h-6 text-blue-400"></i>
                </div>
                <h3 class="text-xl font-black uppercase tracking-tight mb-4">Smart Strategy</h3>
                <p class="text-slate-500 text-sm font-medium leading-relaxed">
                    The bot automatically adjusts your trades based on market trends to maximize profit.
                </p>
            </div>
        </div>

        <!-- Data Visualization Area -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-10">
            <!-- Left: Stats & Status -->
            <div class="space-y-8">
                <div class="dashboard-glass p-8 border-white/10">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-8">System Performance
                    </h4>
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Reliability</span>
                                <span class="text-xs font-black gold-text">98%</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full gold-gradient w-[98%] rounded-full shadow-[0_0_10px_#f0b90a]"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Scalability</span>
                                <span class="text-xs font-black text-emerald-400">Excellent</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-emerald-500 w-[100%] rounded-full shadow-[0_0_10px_#10b981]"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Speed</span>
                                <span class="text-xs font-black text-blue-400">0.02ms</span>
                            </div>
                            <div class="h-1.5 w-full bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full bg-blue-500 w-[10%] rounded-full shadow-[0_0_10px_#3b82f6]"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terminal Quote -->
                <div class="bg-yellow-500 p-10 rounded-[32px] text-black relative overflow-hidden group">
                    <i data-lucide="quote"
                        class="absolute -right-4 -top-4 w-24 h-24 opacity-10 group-hover:scale-110 transition-transform"></i>
                    <div class="relative z-10">
                        <p class="text-xl font-black uppercase tracking-tighter leading-tight mb-6">
                            "The best way to trade is automatically. We build tools that manage your money efficiently."
                        </p>
                        <div class="flex items-center">
                            <div class="h-0.5 w-8 bg-black/30 mr-3"></div>
                            <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Trading Team</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Animated Illustration / Graphic Area -->
            <div
                class="xl:col-span-2 dashboard-glass p-0 relative overflow-hidden flex items-center justify-center bg-black/40">
                <!-- Grid pattern -->
                <div class="absolute inset-0 opacity-10"
                    style="background-image: linear-gradient(#ffffff 1px, transparent 1px), linear-gradient(90deg, #ffffff 1px, transparent 1px); background-size: 40px 40px;">
                </div>

                <div class="relative z-10 flex flex-col items-center text-center p-12 lg:p-24">
                    <div class="mb-12 relative animate-float">
                        <!-- Icon Layering for depth -->
                        <div
                            class="h-32 w-32 rounded-3xl gold-gradient shadow-2xl shadow-yellow-500/40 flex items-center justify-center relative z-20">
                            <i data-lucide="cpu" class="w-16 h-16 text-black"></i>
                        </div>
                        <div
                            class="absolute -inset-4 h-40 w-40 border border-yellow-500/20 rounded-[40px] animate-pulse z-10">
                        </div>
                        <div
                            class="absolute -inset-12 h-56 w-56 border border-yellow-500/5 rounded-[60px] animate-pulse delay-700">
                        </div>
                    </div>

                    <h4 class="text-3xl font-black uppercase tracking-tighter mb-6">Smart System Active</h4>
                    <p class="text-slate-500 text-sm font-medium max-w-md mx-auto leading-relaxed mb-10">
                        You are ready to get started. Choose a bot to begin earning automatically.
                    </p>

                    <a href="{{ route('user.bots.index') }}"
                        class="h-14 px-12 rounded-2xl bg-white text-black font-black uppercase tracking-[0.2em] flex items-center text-[10px] hover:bg-yellow-500 transition-colors shadow-2xl shadow-white/5">
                        Choose Your Bot
                    </a>
                </div>
            </div>
        </div>

        <!-- How It Works Step-by-Step -->
        <div class="pt-12">
            <h2 class="text-3xl font-black uppercase tracking-tighter mb-12 text-center">How to <span
                    class="gold-text">Start</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @php
                    $steps = [
                        ['icon' => 'activity', 'title' => 'Speed', 'desc' => 'Select how fast to trade'],
                        ['icon' => 'wallet', 'title' => 'Amount', 'desc' => 'Choose how much to invest'],
                        ['icon' => 'cpu', 'title' => 'Market', 'desc' => 'Choose your trading pair'],
                        ['icon' => 'play', 'title' => 'Start', 'desc' => 'Power on your bot']
                    ];
                @endphp
                @foreach($steps as $index => $step)
                    <div class="relative group">
                        <div
                            class="dashboard-glass p-8 flex flex-col items-center text-center group-hover:border-yellow-500/30 transition-all">
                            <div class="text-[10px] font-black text-slate-700 uppercase tracking-widest mb-4">Phase
                                0{{ $index + 1 }}</div>
                            <div
                                class="h-12 w-12 rounded-xl bg-white/5 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                                <i data-lucide="{{ $step['icon'] }}"
                                    class="w-5 h-5 {{ $index % 2 == 0 ? 'gold-text' : 'text-white' }}"></i>
                            </div>
                            <h4 class="text-sm font-black uppercase tracking-widest mb-2">{{ $step['title'] }}</h4>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-relaxed">
                                {{ $step['desc'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
    </script>
@endpush