<div x-show="copyModal.open" x-cloak
    class="fixed inset-0 z-[1200] flex items-center justify-center bg-black/80 p-6 backdrop-blur-md">
    <!-- Modal Backdrop -->
    <div x-show="copyModal.open" x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="absolute inset-0 bg-black/60"></div>

    <!-- Modal Content -->
    <div @click.away="copyModal.open = false" x-show="copyModal.open"
        x-transition:enter="transition-all ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-10"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition-all ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-10"
        class="relative w-full max-w-xl bg-[#0a0a0a] border border-white/10 rounded-[32px] overflow-hidden shadow-2xl">

        <div class="absolute -right-20 -top-20 w-64 h-64 bg-yellow-500/5 blur-[100px] pointer-events-none"></div>

        <div class="p-10">
            <div class="flex items-start justify-between mb-10">
                <div>
                    <span class="text-[9px] font-black text-yellow-500 uppercase tracking-[0.2em] mb-2 block">Module
                        Calibration</span>
                    <h3 class="text-2xl font-black text-white uppercase italic tracking-tight" x-text="copyModal.name">
                    </h3>
                </div>
                <button @click="copyModal.open = false"
                    class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('copy.start') }}" class="space-y-8">
                @csrf
                <input type="hidden" name="expert_id" :value="copyModal.id">

                <div class="space-y-6">
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Capitol
                            Allocation ({{ auth()->user()->currency }})</label>
                        <div
                            class="bg-black/50 border border-white/10 rounded-2xl p-2 focus-within:border-yellow-500/50 transition-all">
                            <input type="number" name="amount" min="1" step="0.01" :value="copyModal.minAllocation"
                                class="w-full bg-transparent border-none text-white font-black font-mono text-xl py-2 px-4 focus:ring-0"
                                placeholder="0.00">
                        </div>
                        <div class="flex justify-between px-1">
                            <span class="text-[9px] font-bold text-slate-600 uppercase">Min Barrier: <span
                                    x-text="currency(copyModal.minAllocation)"></span></span>
                            <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-tighter italic">Live
                                Node Sync Active</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Copy
                                Factor</label>
                            <div
                                class="bg-black/50 border border-white/10 rounded-2xl p-2 focus-within:border-yellow-500/50 transition-all">
                                <input type="number" name="copy_ratio" min="0.1" max="5" step="0.1"
                                    :value="copyModal.copyRatio"
                                    class="w-full bg-transparent border-none text-white font-black font-mono text-lg py-2 px-4 focus:ring-0 text-center">
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">D/D
                                Guard %</label>
                            <div
                                class="bg-black/50 border border-white/10 rounded-2xl p-2 focus-within:border-yellow-500/50 transition-all">
                                <input type="number" name="max_drawdown_guard" min="1" max="100" step="0.5"
                                    :value="copyModal.maxDrawdown"
                                    class="w-full bg-transparent border-none text-white font-black font-mono text-lg py-2 px-4 focus:ring-0 text-center">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Execution
                            Logic</label>
                        <select name="risk_preference" x-model="copyModal.riskPreference"
                            class="w-full bg-black/50 border border-white/10 rounded-2xl py-4 px-6 text-sm text-white focus:border-yellow-500/50 focus:ring-0 transition-all appearance-none cursor-pointer">
                            <option value="conservative">Conservative (Low Volatility)</option>
                            <option value="balanced">Balanced (Optimal Stability)</option>
                            <option value="aggressive">Aggressive (Maximum Yield)</option>
                        </select>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-yellow-500/5 border border-yellow-500/10 flex items-start space-x-3">
                    <i data-lucide="shield-alert" class="w-4 h-4 gold-text flex-shrink-0 mt-0.5"></i>
                    <p class="text-[10px] text-slate-500 font-medium leading-relaxed italic uppercase tracking-tighter">
                        Synchronization requires clear capitol liquidity. System will execute trades proportionally
                        based on assigned copy factor and risk guardrails.
                    </p>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" @click="copyModal.open = false"
                        class="flex-1 py-4 rounded-2xl bg-white/5 border border-white/10 text-white font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">Abort</button>
                    <button type="submit"
                        class="flex-2 flex-[2] py-4 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/20 hover:scale-[1.02] transform transition-all active:scale-95">Initialize
                        Synchronization</button>
                </div>
            </form>
        </div>
    </div>
</div>