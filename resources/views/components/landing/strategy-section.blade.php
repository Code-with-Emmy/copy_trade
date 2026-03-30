{{--
Strategy Section — mirrors BitCloven's "Smart Strategy Replication" left-text / right-feature-list.
Shows a large hero image left with 4 strategy bullet cards on the right.
--}}

@php
    $strategies = [
        [
            'num' => '01',
            'title' => 'Copy 400+ Strategies',
            'copy' => 'Access hundreds of strategies across 1000+ instruments in seven asset classes — providing diverse opportunities for every trading style.',
            'icon' => 'img/in-theramanuel-16-icon-1.png',
            'color' => 'text-emerald-300',
        ],
        [
            'num' => '02',
            'title' => 'Select Top Performers',
            'copy' => 'Use advanced reporting tools to rank traders by performance and choose the providers that fit your goals and risk tolerance.',
            'icon' => 'img/in-theramanuel-16-icon-2.png',
            'color' => 'text-sky-300',
        ],
        [
            'num' => '03',
            'title' => 'Stay Protected',
            'copy' => 'Sophisticated guardrail calculations keep your exposure at an optimal level, maintaining allocations aligned with your account balance.',
            'icon' => 'img/in-theramanuel-16-icon-3.png',
            'color' => 'text-amber-300',
        ],
        [
            'num' => '04',
            'title' => 'Combine With Other Methods',
            'copy' => 'Blend copying with manual and automated trading inside one platform, tailoring execution to your preferred approach.',
            'icon' => 'img/in-theramanuel-16-icon-4.png',
            'color' => 'text-violet-300',
        ],
    ];
@endphp

<section id="strategy" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-10 lg:grid-cols-[1fr,1fr] lg:items-center">

        {{-- LEFT — Visual panel --}}
        <div class="relative reveal">
            {{-- Glow blob --}}
            <div class="pointer-events-none absolute inset-0 -m-8 rounded-[50%] bg-emerald-400/6 blur-[80px]"></div>

            <div class="glass-bright relative overflow-hidden rounded-[32px] p-5 sm:p-6">
                {{-- Header bar --}}
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse-glow"></span>
                        <span class="text-xs font-semibold text-slate-400 uppercase tracking-[0.18em]">Live Strategy
                            Feed</span>
                    </div>
                    <span
                        class="rounded-full border border-emerald-400/25 bg-emerald-400/10 px-2.5 py-1 text-xs font-bold text-emerald-300">+29.4%
                        today</span>
                </div>

                {{-- Main illustration / hero image --}}
                <img src="{{ asset('img/in-slide-img-1.svg') }}" alt="Smart strategy replication dashboard"
                    class="w-full rounded-[20px]" loading="lazy">

                {{-- Mini metric strip --}}
                <div class="mt-4 grid grid-cols-3 gap-3">
                    @foreach ([['Strategies', '400+', 'text-emerald-300'], ['Asset Classes', '7', 'text-sky-300'], ['Win Rate', '74%', 'text-amber-300']] as $m)
                        <div class="rounded-2xl border border-white/8 bg-slate-950/70 p-3 text-center">
                            <p class="text-[10px] uppercase tracking-[0.18em] text-slate-500">{{ $m[0] }}</p>
                            <p class="mt-1.5 text-lg font-bold {{ $m[2] }}">{{ $m[1] }}</p>
                        </div>
                    @endforeach
                </div>

                {{-- Floating card: allocation --}}
                <div class="absolute -bottom-4 -right-4 hidden w-48 rounded-2xl border border-white/10 bg-slate-950/92 p-3.5 shadow-panel xl:block animate-floaty"
                    style="animation-delay:.3s">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                        </svg>
                        <span class="text-[10px] uppercase tracking-[0.18em] text-slate-500">Allocation</span>
                    </div>
                    <p class="text-sm font-bold text-white">$12,400 copied</p>
                    <p class="text-xs text-emerald-300 mt-0.5">↑ 3.2% this week</p>
                </div>
            </div>
        </div>

        {{-- RIGHT — Text + strategy list --}}
        <div class="reveal" style="transition-delay:.1s">
            <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.28em] text-sky-400">Strategy
                Replication</span>
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
                Smart Strategy<br>Replication.
            </h2>
            <p class="mt-4 text-base text-slate-400 leading-relaxed">
                Copy toward your wealth goals with precision tools that automate allocation, protect capital, and
                surface transparent performance across every trade you mirror.
            </p>

            <a href="{{ route('register') }}"
                class="mt-6 inline-flex items-center gap-2 rounded-full bg-emerald-400 px-6 py-3 text-sm font-bold text-slate-950 shadow-glow transition hover:translate-y-[-1px] hover:bg-emerald-300">
                Start Copying
                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>

            {{-- Strategy bullet cards --}}
            <div class="mt-8 space-y-4">
                @foreach ($strategies as $s)
                    <div class="flex items-start gap-4 glass rounded-2xl p-4 transition duration-200 hover:border-white/20">
                        <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white/5">
                            <img src="{{ asset($s['icon']) }}" alt="{{ $s['title'] }}" class="h-5 w-5 object-contain"
                                loading="lazy">
                        </div>
                        <div>
                            <p class="text-sm font-bold {{ $s['color'] }}">
                                <span class="text-slate-600 mr-1.5">{{ $s['num'] }}</span>{{ $s['title'] }}
                            </p>
                            <p class="mt-1.5 text-xs leading-6 text-slate-400">{{ $s['copy'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>