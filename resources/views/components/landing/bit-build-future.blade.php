<section class="py-24 bg-[#0f0f0f]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-4xl mx-auto reveal mb-16">
            <h2 class="font-display text-4xl font-bold text-white text-center">
                Allocate and copy with control
            </h2>
        </div>

        <div class="grid gap-16 lg:grid-cols-2 lg:items-center" x-data="{ capital: 50000 }">

            {{-- Form Side --}}
            <div class="reveal">
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-6">How much capital do you want to
                            allocate?</label>
                        <input type="range" min="1000" max="250000" step="1000" x-model="capital"
                            class="w-full h-2 bg-slate-800 rounded-lg appearance-none cursor-pointer accent-[#f0b90a]">
                        <div class="mt-8 flex items-center justify-between">
                            <span class="text-4xl font-bold text-white"
                                x-text="'$' + parseInt(capital).toLocaleString()"></span>
                            <a href="{{ route('register') }}"
                                class="px-8 py-4 bg-[#f0b90a] text-black font-bold rounded-lg hover:bg-[#c99408] transition-all shadow-[0_12px_24px_rgba(240,185,10,0.18)]">
                                Start Copying
                            </a>
                        </div>
                    </div>

                    <div class="p-8 rounded-2xl bg-black border border-white/5 space-y-8">
                        <p class="text-slate-400">Configure allocation per trader, schedule balance sync, and protect
                            your equity with automated guardrails.</p>

                        <div class="relative space-y-12">
                            {{-- Line --}}
                            <div class="absolute top-0 left-2.5 w-0.5 h-full bg-slate-800 -z-0"></div>

                            <div class="relative z-10 flex gap-6">
                                <span
                                    class="flex-shrink-0 w-5 h-5 rounded-full bg-[#f0b90a] border-4 border-black ring-4 ring-transparent transition group-hover:ring-[#f0b90a]/20"></span>
                                <div>
                                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-1">Week 1</h4>
                                    <p class="text-sm text-slate-400">Mirror top trader entries</p>
                                </div>
                            </div>

                            <div class="relative z-10 flex gap-6">
                                <span
                                    class="flex-shrink-0 w-5 h-5 rounded-full bg-[#f0b90a] border-4 border-black"></span>
                                <div>
                                    <h4 class="font-bold text-white uppercase tracking-wider text-xs mb-1">90 Days</h4>
                                    <p class="text-sm text-slate-400">Review performance, rebalance followers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart Side --}}
            <div class="reveal" style="transition-delay: 200ms">
                <div
                    class="relative p-10 rounded-[32px] bg-black border border-white/10 shadow-glow group overflow-hidden">
                    {{-- SVG Chart --}}
                    <div class="relative">
                        <svg viewBox="0 0 300 200" class="w-full text-emerald-400">
                            <defs>
                                <linearGradient id="chartGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                                    <stop offset="0%" style="stop-color:#4dd4ac;stop-opacity:0.6" />
                                    <stop offset="100%" style="stop-color:#4dd4ac;stop-opacity:0" />
                                </linearGradient>
                            </defs>
                            <path d="M 10 150 L 50 120 L 90 135 L 130 90 L 170 105 L 210 60 L 250 45 L 290 15"
                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path
                                d="M 10 150 L 50 120 L 90 135 L 130 90 L 170 105 L 210 60 L 250 45 L 290 15 L 290 180 L 10 180 Z"
                                fill="url(#chartGradient)" />
                        </svg>

                        <div class="absolute top-0 right-0 p-6 text-right">
                            <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 mb-2">Projected
                                Return</h3>
                            <p class="text-5xl font-bold text-white tracking-tighter"
                                x-text="'$' + (parseInt(capital) * 16.2).toLocaleString().split('.')[0]"></p>
                            <p class="text-emerald-400 font-medium mt-1">+1,620% Projected</p>
                        </div>
                    </div>

                    <div class="absolute bottom-6 left-10 flex gap-6">
                        @foreach (['High Risk', 'Balanced', 'Safe'] as $mode)
                            <span
                                class="text-[10px] font-bold uppercase tracking-widest text-slate-600 transition hover:text-[#f0b90a] cursor-pointer">{{ $mode }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>