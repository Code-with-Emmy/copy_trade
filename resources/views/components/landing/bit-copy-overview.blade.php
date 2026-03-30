<section id="copy-features" class="py-28 bg-[#0f0f0f]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid items-center gap-16 lg:grid-cols-[1.1fr,1.4fr]">

            {{-- Left Intro --}}
            <div class="reveal">
                <span
                    class="inline-block px-4 py-1.5 rounded-full border border-[#f0b90a]/30 bg-[#f0b90a]/10 text-[10px] font-bold uppercase tracking-[0.2em] text-[#f0b90a] mb-6">BitCloven
                    COPY</span>
                <h2 class="font-display text-4xl font-bold text-white mb-6 lg:text-5xl leading-[1.1]">
                    Smart Strategy<br>Replication
                </h2>
                <p class="text-lg text-slate-400 leading-relaxed mb-6">
                    Replicate successful trading strategies from top-performing traders. Diversify your portfolio and
                    maximize profits with our intelligent copy-trading platform.
                </p>
                <p class="text-slate-500 leading-relaxed mb-10">
                    Our copy trading platform delivers innovative features to help you optimize your investment strategy
                    and maximize returns.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="#copy-steps"
                        class="px-8 py-3.5 bg-[#f0b90a] text-black font-bold rounded-lg hover:bg-[#c99408] transition-all">
                        How It Works
                    </a>
                    <a href="#faq"
                        class="px-8 py-3.5 border-2 border-[#c99408] text-[#c99408] font-bold rounded-lg hover:bg-[#c99408] hover:text-black transition-all">
                        FAQs
                    </a>
                </div>
            </div>

            {{-- Right Feature Grid --}}
            <div class="grid gap-6 sm:grid-cols-2">
                @php
                    $features = [
                        [
                            'title' => 'Copy 400+ Strategies',
                            'copy' => 'Access hundreds of strategies for more than 1000 instruments across seven asset classes.'
                        ],
                        [
                            'title' => 'Select Top Performers',
                            'copy' => 'Use advanced reporting tools to rank strategies by performance and choose the providers.'
                        ],
                        [
                            'title' => 'Stay Protected',
                            'copy' => 'Sophisticated calculations keep your exposure at an optimal level, maintaining allocations.'
                        ],
                        [
                            'title' => 'Combine Methods',
                            'copy' => 'Blend copying with manual and automated trading inside one platform for full flexibility.'
                        ]
                    ];
                @endphp

                @foreach ($features as $idx => $f)
                    <div class="reveal glass-bright p-8 rounded-2xl border border-white/5 bg-black transition-all hover:-translate-y-2 hover:border-[#f0b90a]/20"
                        style="transition-delay: {{ $idx * 150 }}ms">
                        <h3 class="text-xl font-bold text-white mb-3 tracking-tight">{{ $f['title'] }}</h3>
                        <p class="text-sm leading-relaxed text-slate-400">
                            {{ $f['copy'] }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>

    </div>
</section>