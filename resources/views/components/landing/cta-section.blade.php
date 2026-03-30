<section id="cta" class="mx-auto mt-28 max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">
    <div class="relative overflow-hidden rounded-[36px] border border-white/10">
        {{-- Background image --}}
        <img src="{{ asset('img/in-theramanuel-12-background.jpg') }}" alt="" aria-hidden="true"
            class="absolute inset-0 h-full w-full object-cover opacity-20" loading="lazy">

        {{-- Gradient overlay --}}
        <div class="absolute inset-0 bg-gradient-to-br from-ink/98 via-ink/80 to-emerald-950/30"></div>

        {{-- CTA background glow --}}
        <div class="pointer-events-none absolute inset-0 bg-cta-glow"></div>

        {{-- Decorative grid dots --}}
        <div class="pointer-events-none absolute inset-0 dot-grid opacity-30"></div>

        {{-- Decorative blobs --}}
        <img src="{{ asset('img/in-theramanuel-4-decor-1.svg') }}" alt="" aria-hidden="true"
            class="pointer-events-none absolute -right-6 top-6 h-36 w-36 opacity-20 animate-floaty-slow">

        <div class="relative px-8 py-16 sm:px-12 sm:py-20 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-[1.1fr,.9fr] lg:items-center">

                {{-- Left: Copy --}}
                <div>
                    <div
                        class="inline-flex items-center gap-2 rounded-full border border-emerald-400/25 bg-emerald-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.22em] text-emerald-300 mb-6">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-300"></span>
                        </span>
                        Start today — free account
                    </div>
                    <h2 class="font-display text-4xl font-bold text-white sm:text-5xl leading-tight">
                        Start Copy Trading Today.<br>
                        <span class="text-shimmer">Your Portfolio Awaits.</span>
                    </h2>
                    <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300">
                        Create your investor profile in minutes. Review verified trader analytics, allocate with full
                        risk visibility, and grow your portfolio — backed by a platform built for serious investors.
                    </p>

                    {{-- Micro-trust indicators --}}
                    <div class="mt-8 flex flex-wrap gap-6">
                        @foreach (['No hidden fees', 'Risk-labelled profiles', 'Cancel anytime'] as $trust)
                            <div class="flex items-center gap-2 text-sm text-slate-300">
                                <svg class="h-4 w-4 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $trust }}
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right: CTAs --}}
                <div class="flex flex-col items-start gap-4 lg:items-end">
                    <a href="{{ route('register') }}"
                        class="group inline-flex items-center gap-3 rounded-full bg-emerald-400 px-8 py-4.5 text-base font-bold text-slate-950 shadow-glow transition duration-200 hover:translate-y-[-2px] hover:bg-emerald-300 hover:shadow-glow-lg w-full justify-center sm:w-auto">
                        Create Your Free Account
                        <svg class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none"
                            stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="{{ route('traders.index') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-white/20 px-8 py-4.5 text-base font-semibold text-white transition hover:border-white/35 hover:bg-white/8 w-full justify-center sm:w-auto">
                        Browse Traders First
                    </a>
                    <p class="text-xs text-slate-500 text-center lg:text-right">No credit card required. Open in 2
                        minutes.</p>
                </div>
            </div>
        </div>
    </div>
</section>