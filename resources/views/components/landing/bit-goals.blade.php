<section class="py-24 bg-[#0f0f0f]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid items-center gap-16 lg:grid-cols-2">
            
            <div class="reveal">
                <h2 class="font-display text-3xl font-bold text-white sm:text-4xl lg:text-5xl leading-tight">
                    Copy toward your <br class="hidden lg:block">wealth goals.
                </h2>
                <p class="mt-6 text-lg text-slate-300 leading-relaxed">
                    Blend multiple strategies, allocate capital automatically, and rebalance with one tap. Set target returns, max drawdowns, and diversification rules that match your risk profile.
                </p>

                <ul class="mt-10 space-y-5">
                    @foreach ([
                        'Auto-stop copy when max loss limits trigger',
                        'Allocate by percentage or fixed amount per trader',
                        'Clone portfolios across forex, crypto, indices, and stocks',
                        'Weekly insights from your followed strategists'
                    ] as $list)
                        <li class="flex items-center gap-4 text-white font-medium group">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-[#f0b90a] flex items-center justify-center text-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            <span class="transition-colors group-hover:text-[#f0b90a]">{{ $list }}</span>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-12">
                    <a href="{{ route('login') }}" class="group inline-flex items-center gap-2 text-[#f0b90a] font-bold text-lg hover:translate-x-1 transition-transform">
                        View top-performing copy portfolios
                        <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                    </a>
                </div>
            </div>

            <div class="reveal order-first lg:order-last" style="transition-delay: 200ms">
                <div class="relative">
                    <img src="{{ asset('img/blockit/in-card-image-2.png') }}" alt="Wealth goals" class="mx-auto max-w-[400px] drop-shadow-2xl animate-floaty">
                    
                    {{-- Decorative glow --}}
                    <div class="absolute inset-0 bg-gradient-to-tr from-[#f0b90a]/10 to-transparent blur-3xl -z-10 rounded-full"></div>
                </div>
            </div>

        </div>

    </div>
</section>
