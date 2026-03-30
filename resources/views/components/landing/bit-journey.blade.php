<section id="features" class="py-24 bg-black">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-16 reveal">
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">
                Start copying high-performance traders.
            </h2>
            <p class="mt-4 text-slate-400 leading-relaxed">
                Our social trading network gives you transparent analytics, automated execution, and flexible capital
                controls so you can follow the pros with confidence.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-3">
            @php
                $journeyItems = [
                    [
                        'title' => 'Real-time Leaderboard',
                        'copy' => 'Track verified trader performance with live win rates, drawdowns, and risk scores in a live-ranked marketplace.',
                    ],
                    [
                        'title' => 'Dynamic Risk Guard',
                        'copy' => 'Set equity stops, copy ratios, and asset filters to protect your capital automatically — no manual intervention needed.',
                    ],
                    [
                        'title' => 'Community Signals',
                        'copy' => 'Join live discussions, strategy rooms, and trader AMAs to learn the rationale behind every move Made by experts.',
                    ]
                ];
            @endphp

            @foreach ($journeyItems as $idx => $item)
                <div class="reveal glass-bright rounded-2xl p-8 border border-white/5 bg-[#0f0f0f] transition-all duration-300 hover:-translate-y-2 hover:border-[#f0b90a]/30"
                    style="transition-delay: {{ $idx * 150 }}ms">
                    <div class="w-12 h-12 mb-6 rounded-xl bg-[#f0b90a]/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#f0b90a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($idx == 0)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            @elseif($idx == 1) <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                                </path>
                            @endif
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $item['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-slate-400">
                        {{ $item['copy'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>