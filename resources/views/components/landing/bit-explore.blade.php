@props(['traders' => collect()])

<section id="explore" class="py-24 bg-[#0f0f0f]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-16 lg:grid-cols-2">

            <div class="reveal">
                <h2 class="font-display text-4xl font-bold text-white mb-6 lg:text-5xl leading-[1.1]">
                    Explore top-performing <br class="hidden lg:block">leaders <span
                        class="text-[#f0b90a]">today.</span>
                </h2>
                <p class="text-lg text-slate-400 leading-relaxed mb-10 max-w-lg">
                    Filter traders by style, region, asset, and risk appetite. Compare live stats and let automation
                    replicate every move in seconds.
                </p>

                <a href="{{ route('traders.index') }}"
                    class="inline-flex items-center justify-center px-10 py-4 text-sm font-bold text-black transition-all bg-[#f0b90a] rounded-lg hover:bg-[#c99408] shadow-[0_12px_24px_rgba(240,185,10,0.18)]">
                    Browse Leaderboard
                </a>
            </div>

            <div class="reveal" style="transition-delay: 200ms">
                <div class="relative overflow-hidden rounded-[32px] border border-white/10 shadow-glow aspect-video">
                    {{-- Using a project asset (gallery 1) as placeholder for the video mockup --}}
                    <img src="{{ asset('img/blockit/in-gallery-image-1.jpg') }}" alt="Leaderboard preview"
                        class="w-full h-full object-cover">

                    {{-- Play overlay for aesthetic --}}
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40">
                        <div
                            class="w-20 h-20 rounded-full bg-[#f0b90a]/90 flex items-center justify-center pl-1 shadow-2xl animate-pulse">
                            <svg class="w-10 h-10 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>