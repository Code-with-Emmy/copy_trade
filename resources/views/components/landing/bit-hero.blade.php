@props(['stats' => []])

<section class="relative pt-32 pb-20 overflow-hidden bg-black lg:pt-48 lg:pb-32">
    {{-- Background elements for premium feel --}}
    <div class="pointer-events-none absolute inset-0">
        <div
            class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#f0b90a]/10 blur-[120px] rounded-full -translate-y-1/2 translate-x-1/2">
        </div>
        <div
            class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-emerald-500/5 blur-[100px] rounded-full translate-y-1/2 -translate-x-1/2">
        </div>
    </div>

    <div class="container relative mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-16">

            {{-- Left Content --}}
            <div class="reveal">
                <h1 class="font-display text-4xl font-bold leading-[1.1] text-white sm:text-5xl lg:text-6xl">
                    Mirror elite traders and <span class="text-[#f0b90a]">grow smarter.</span>
                </h1>
                <p class="mt-6 text-lg leading-relaxed text-slate-400 max-w-xl">
                    Copy proven strategies in real time, manage risk with precision tools, and unlock diversified
                    returns without trading alone.
                </p>

                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center justify-center px-8 py-4 text-sm font-bold text-black transition-all bg-[#f0b90a] rounded-lg hover:bg-[#c99408] hover:-translate-y-1 shadow-[0_12px_24px_rgba(240,185,10,0.18)]">
                        Get Started
                    </a>
                    <a href="#features"
                        class="inline-flex items-center justify-center px-8 py-4 text-sm font-bold text-[#f0b90a] transition-all bg-transparent border-2 border-[#f0b90a] rounded-lg hover:bg-[#f0b90a] hover:text-black">
                        Learn More
                    </a>
                </div>

                <div class="mt-16 sm:mt-24">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500 mb-6">Investors and Partners
                    </p>
                    <div
                        class="flex flex-wrap items-center gap-8 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                        {{-- Using existing client logos --}}
                        @foreach (range(1, 5) as $i)
                            <img src="{{ asset('img/blockit/in-client-logo-' . $i . '.svg') }}" alt="Partner"
                                class="h-6 w-auto">
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Right Mockup --}}
            <div class="relative reveal" style="transition-delay: 200ms">
                <div class="relative mx-auto w-full max-w-[440px] perspective-1000">
                    <div
                        class="relative overflow-hidden rounded-[40px] border-[12px] border-slate-900 bg-slate-900 shadow-2xl rotate-y-[-12deg] hover:rotate-y-[-5deg] transition-transform duration-700">
                        {{-- Dashboard preview image --}}
                        <img src="{{ asset('img/blockit/in-content-10-image.png') }}" alt="Investment app preview"
                            class="w-full">

                        {{-- Absolute positioned floating cards for extra depth (optional) --}}
                        <div
                            class="absolute top-1/4 -right-8 glass p-4 rounded-2xl border border-white/10 shadow-xl animate-floaty hidden xl:block">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-wider">Equity Growth</p>
                                    <p class="text-sm font-bold text-white">+24.8%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Background glow behind phone --}}
                <div
                    class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[120%] bg-gradient-to-tr from-[#f0b90a]/20 to-transparent blur-[100px] rounded-full">
                </div>
            </div>

        </div>
    </div>
</section>