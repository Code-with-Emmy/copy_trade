@props(['stats' => []])

<section class="py-24 bg-black border-y border-white/5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        <div class="text-center mb-16 reveal">
            <h2 class="font-display text-4xl font-bold text-white leading-tight">
                See our <span class="text-[#f0b90a] italic font-semibold">numbers</span>
            </h2>
        </div>

        <div class="grid gap-12 text-center sm:grid-cols-3">

            {{-- Users --}}
            <div class="reveal">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <span class="text-6xl font-bold text-white tracking-tighter">
                        @php $uCount = data_get($stats, 'active_investors', 10); @endphp
                        {{ $uCount >= 1000 ? number_format($uCount / 1000, 0) . 'k' : $uCount }}
                    </span>
                    <span class="text-5xl font-bold text-[#f0b90a]">+</span>
                </div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Users</p>
            </div>

            {{-- Paid out --}}
            <div class="reveal" style="transition-delay: 150ms">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <span class="text-6xl font-bold text-white tracking-tighter">
                        @php $payout = data_get($stats, 'total_payout', 1); @endphp
                        ${{ $payout >= 1000000 ? number_format($payout / 1000000, 0) . 'm' : number_format($payout / 1000, 0) . 'k' }}
                    </span>
                    <span class="text-5xl font-bold text-[#f0b90a]">+</span>
                </div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Paid out to users</p>
            </div>

            {{-- Countries --}}
            <div class="reveal" style="transition-delay: 300ms">
                <div class="flex items-center justify-center gap-4 mb-2">
                    <span class="text-6xl font-bold text-white tracking-tighter">50</span>
                    <img src="{{ asset('img/blockit/in-client-logo-1.svg') }}" alt="Countries"
                        class="h-10 w-auto object-contain grayscale brightness-200">
                </div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Countries</p>
            </div>

        </div>

    </div>
</section>