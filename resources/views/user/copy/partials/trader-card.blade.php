<div
    class="dashboard-glass border-white/5 p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all flex flex-col h-full">
    <div
        class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all">
    </div>

    <div class="flex items-start justify-between mb-8">
        <div class="flex items-center space-x-5">
            <div class="relative">
                <div
                    class="h-16 w-16 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-colors shadow-xl">
                    @if($trader->photo)
                        <img src="{{ asset('storage/' . $trader->photo) }}" alt="{{ $trader->name }}"
                            class="h-full w-full rounded-[14px] object-cover">
                    @else
                        <span
                            class="text-xl font-black gold-text  tracking-tighter">{{ strtoupper(substr($trader->name, 0, 1)) }}</span>
                    @endif
                </div>
                @if($trader->verification_status === 'verified')
                    <div
                        class="absolute -bottom-1 -right-1 h-6 w-6 bg-emerald-500 rounded-lg flex items-center justify-center border-4 border-[#0a0a0a] shadow-lg">
                        <i data-lucide="check" class="w-3 h-3 text-black"></i>
                    </div>
                @endif
            </div>
            <div>
                <h3
                    class="text-lg font-black text-white uppercase  tracking-tight group-hover:gold-text transition-colors">
                    {{ $trader->name }}</h3>
                <div class="flex items-center mt-1">
                    <span
                        class="text-[9px] font-black text-slate-500 uppercase tracking-widest">{{ $trader->strategy_type ?: 'Proprietary Protocol' }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('copy.watchlist.toggle', $trader->id) }}">
            @csrf
            <button type="submit"
                class="h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all {{ in_array($trader->id, $watchlistIds ?? [], true) ? 'gold-text border-yellow-500/30' : '' }}">
                <i data-lucide="bookmark" class="w-4 h-4"></i>
            </button>
        </form>
    </div>

    <!-- Performance Matrix -->
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">30D Return</span>
            <div class="text-xl font-black  tracking-tighter text-emerald-400 font-mono">
                +{{ number_format((float) $trader->monthly_roi, 2) }}%
            </div>
        </div>
        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Risk Factor</span>
            <div
                class="text-xl font-black  tracking-tighter {{ $trader->risk_level == 'low' ? 'text-emerald-400' : 'text-yellow-500' }} uppercase">
                {{ $trader->risk_level ?: 'B1' }}
            </div>
        </div>
        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Max Drawdown</span>
            <div class="text-lg font-black  tracking-tighter text-rose-400 font-mono">
                {{ number_format((float) $trader->max_drawdown, 2) }}%
            </div>
        </div>
        <div class="bg-black/40 border border-white/5 rounded-2xl p-4">
            <span class="block text-[8px] font-black text-slate-600 uppercase tracking-widest mb-1">Win
                Probability</span>
            <div class="text-lg font-black  tracking-tighter text-white font-mono">
                {{ number_format((float) $trader->win_rate, 1) }}%
            </div>
        </div>
    </div>

    <div class="bg-yellow-500/5 border border-yellow-500/10 rounded-xl p-4 mb-8">
        <span class="block text-[8px] font-black text-slate-500 uppercase tracking-widest mb-2">Market Exposure</span>
        <p class="text-[10px] text-slate-400 font-medium leading-relaxed">
            {{ $trader->markets_traded ?: 'Global FX, Cross-Chain Crypto, Indices' }}</p>
    </div>

    <!-- Action Bar -->
    <div class="mt-auto pt-6 border-t border-white/5 flex gap-3">
        <a href="{{ route('copy.show', $trader->slug ?: $trader->id) }}"
            class="flex-1 py-3 text-center rounded-xl bg-white/5 border border-white/10 text-[9px] font-black text-slate-300 uppercase tracking-widest hover:bg-white/10 transition-all">Matrix</a>
        <button type="button"
            @click="openCopyModal({ id: {{ $trader->id }}, name: @js($trader->name), minAllocation: {{ max((float) ($trader->price ?? 0), (float) ($trader->minimum_allocation ?? 100)) }}, copyRatio: 1, riskPreference: 'balanced', maxDrawdown: {{ max(5, (float) ($trader->max_drawdown ?? 15)) }} })"
            class="flex-1 py-3 gold-gradient-bg rounded-xl text-black font-black text-[9px] uppercase tracking-widest hover:scale-105 transition-all">Synchronize</button>
    </div>
</div>