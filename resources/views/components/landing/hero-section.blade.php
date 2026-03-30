@props([
    'stats'   => [],
    'traders' => collect(),
])

@php
    $heroTraders = collect($traders)->take(3)->values();
    $trustItems  = [
        ['label' => 'Active Users',       'value' => number_format((int) data_get($stats, 'active_investors', 0)) ?: '4,800+'],
        ['label' => 'Avg Monthly Return', 'value' => '+' . number_format((float) data_get($stats, 'average_monthly_returns', 0), 1) . '%'],
        ['label' => 'Countries',          'value' => '50+'],
    ];
@endphp

<section id="hero" class="relative overflow-hidden" style="min-height:92vh;display:flex;align-items:center;">
    {{-- Dot grid --}}
    <div class="pointer-events-none absolute inset-0 dot-grid opacity-35"></div>

    {{-- Atmospheric glows --}}
    <div class="pointer-events-none absolute -left-40 top-20  h-[500px] w-[500px] rounded-full bg-emerald-400/10 blur-[120px]"></div>
    <div class="pointer-events-none absolute -right-20 -top-10 h-96 w-96 rounded-full bg-sky-400/10 blur-[90px]"></div>
    <div class="pointer-events-none absolute right-1/3 bottom-10 h-72 w-72 rounded-full bg-emerald-500/6 blur-[80px]"></div>

    <div class="relative mx-auto grid w-full max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:items-center lg:gap-16 lg:px-8 lg:py-28">

        {{-- ╔═══════════════════ LEFT ═══════════════════╗ --}}
        <div class="max-w-2xl">

            {{-- Live badge --}}
            <div class="mb-8 inline-flex items-center gap-2.5 rounded-full border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.22em] text-emerald-300 backdrop-blur-sm">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-70"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                </span>
                Live Copy Trading
            </div>

            {{-- BitCloven-style headline --}}
            <h1 class="font-display font-bold leading-[1.1] tracking-tight text-white" style="font-size:clamp(2.4rem,5vw,3.6rem)">
                Mirror elite traders<br>and grow smarter.
            </h1>

            <p class="mt-6 text-lg leading-8 text-slate-400 max-w-xl">
                Copy proven strategies in real time, manage risk with precision tools, and unlock diversified returns — without trading alone.
            </p>

            {{-- CTAs --}}
            <div class="mt-9 flex flex-wrap gap-4">
                <a href="{{ route('register') }}"
                    class="group inline-flex items-center gap-2.5 rounded-full bg-emerald-400 px-7 py-4 text-sm font-bold text-slate-950 shadow-glow transition duration-200 hover:translate-y-[-2px] hover:bg-emerald-300 hover:shadow-glow-lg">
                    Get Started
                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
                <a href="#features"
                    class="inline-flex items-center gap-2 rounded-full border border-white/15 px-7 py-4 text-sm font-semibold text-slate-200 backdrop-blur-sm transition hover:border-white/30 hover:bg-white/5">
                    Learn More
                </a>
            </div>

            {{-- Investors & Partners label --}}
            <div class="mt-10 flex items-center gap-5">
                <div class="flex -space-x-2.5">
                    @foreach (['blockit/in-testimoni-1.png','blockit/in-testimoni-2.png','blockit/in-testimoni-3.png'] as $av)
                        <img src="{{ asset('img/' . $av) }}" alt="Investor avatar"
                            class="h-9 w-9 rounded-full border-2 border-ink object-cover"
                            loading="lazy">
                    @endforeach
                    <div class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-ink bg-white/8 text-xs font-bold text-white">+</div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Investors &amp; Partners</p>
                    <p class="text-xs text-slate-500">4,800+ accounts worldwide</p>
                </div>
            </div>

            {{-- Stats strip --}}
            <div class="mt-8 grid grid-cols-3 rounded-2xl border border-white/8 bg-white/[0.03] backdrop-blur-sm divide-x divide-white/8">
                @foreach ($trustItems as $item)
                    <div class="px-4 py-4 text-center">
                        <p class="text-[10px] uppercase tracking-[0.18em] text-slate-500">{{ $item['label'] }}</p>
                        <p class="mt-1.5 text-xl font-bold text-white">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- ╔═══════════════════ RIGHT ═══════════════════╗ --}}
        <div class="relative">
            {{-- Ambient glow --}}
            <div class="pointer-events-none absolute inset-0 -m-6 rounded-[40px] bg-emerald-400/5 blur-[60px]"></div>

            {{-- Main card --}}
            <div class="glass-bright relative overflow-hidden rounded-[32px] p-4 shadow-glow sm:p-5">
                {{-- Dashboard top bar --}}
                <div class="mb-4 flex items-center justify-between rounded-2xl bg-slate-950/60 px-4 py-2.5">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse-glow"></span>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-[0.16em]">Portfolio Overview</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        <span class="text-[11px] font-semibold text-emerald-300">Live</span>
                    </div>
                </div>

                {{-- Hero SVG illustration --}}
                <img src="{{ asset('img/in-slide-img-1.svg') }}"
                    alt="{{ config('app.name') }} copy trading platform dashboard"
                    class="w-full rounded-[24px]"
                    loading="eager"
                    fetchpriority="high">

                {{-- Trader mini-cards --}}
                @if ($heroTraders->isNotEmpty())
                    <div class="mt-4 grid gap-3 grid-cols-3">
                        @foreach ($heroTraders as $t)
                            @php $avIdx = ($t->getKey() % 4) + 1; @endphp
                            <a href="{{ route('traders.show', $t->slug ?: $t->id) }}" class="block rounded-2xl border border-white/8 bg-slate-950/70 p-3 hover:border-white/18 transition">
                                <div class="flex items-center gap-1.5 mb-1.5">
                                    <img src="{{ $t->photo ? asset('storage/'.$t->photo) : asset('img/in-theramanuel-4-avatar-'.$avIdx.'.png') }}"
                                        alt="{{ $t->name }}" class="h-5 w-5 rounded-lg object-cover">
                                    <p class="truncate text-[11px] font-semibold text-white">{{ $t->name }}</p>
                                </div>
                                <p class="text-sm font-bold text-emerald-300">+{{ number_format((float)$t->monthly_roi, 1) }}%</p>
                                <p class="text-[10px] text-slate-500">monthly</p>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="mt-4 grid gap-3 grid-cols-3">
                        @foreach ([['Alex M.','42.1%'],['Sarah K.','28.7%'],['James R.','19.2%']] as $st)
                            <div class="rounded-2xl border border-white/8 bg-slate-950/70 p-3">
                                <p class="text-[11px] font-semibold text-white truncate">{{ $st[0] }}</p>
                                <p class="mt-1.5 text-sm font-bold text-emerald-300">+{{ $st[1] }}</p>
                                <p class="text-[10px] text-slate-500">monthly</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Floating pill: Risk Guard --}}
            <div class="absolute -left-10 top-12 hidden w-54 animate-floaty rounded-2xl border border-white/10 bg-slate-950/92 p-4 shadow-card xl:block">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-400/15">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">Risk Guard</p>
                        <p class="text-xs text-slate-400">Drawdown alert active</p>
                    </div>
                </div>
            </div>

            {{-- Floating pill: Trade copied --}}
            <div class="absolute -bottom-7 right-2 hidden w-56 animate-floaty rounded-2xl border border-white/10 bg-slate-950/92 p-4 shadow-card xl:block" style="animation-delay:.6s">
                <div class="flex items-center gap-2 mb-2">
                    <span class="flex h-2 w-2 rounded-full bg-sky-400 animate-pulse-glow"></span>
                    <p class="text-[10px] uppercase tracking-[0.16em] text-slate-500">Auto executed</p>
                </div>
                <p class="text-sm font-bold text-white">Trade copied instantly</p>
                <div class="mt-1.5 flex items-center justify-between">
                    <span class="text-xs text-slate-400">BTC/USD · Long</span>
                    <span class="text-xs font-bold text-emerald-300">+2.4%</span>
                </div>
            </div>
        </div>
    </div>
</section>
