<section id="copy-steps" class="py-24 bg-black">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-20 reveal">
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">
                How Copy Trading Works
            </h2>
            <p class="mt-4 text-slate-400">
                Get started with copy trading in just a few simple steps.
            </p>
        </div>

        <div class="grid gap-12 sm:grid-cols-3 md:gap-16">
            @php
                $steps = [
                    [
                        'num' => '1',
                        'title' => 'Browse Strategies',
                        'copy' => 'Explore our marketplace of trading strategies. Filter by performance, risk, asset class, and more to find the right fit.'
                    ],
                    [
                        'num' => '2',
                        'title' => 'Select & Subscribe',
                        'copy' => 'Choose the strategies you want to follow, set your risk parameters, and allocate capital to each provider.'
                    ],
                    [
                        'num' => '3',
                        'title' => 'Automated Trading',
                        'copy' => 'Trades are executed automatically in your account based on provider activity, adjusted to your settings and allocations.'
                    ]
                ];
            @endphp

            @foreach ($steps as $idx => $s)
                <div class="reveal relative text-center" style="transition-delay: {{ $idx * 150 }}ms">
                    <div
                        class="mb-8 inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-900 border-4 border-slate-800 text-3xl font-bold text-[#f0b90a] shadow-lg">
                        {{ $s['num'] }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-4">{{ $s['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-slate-400">
                        {{ $s['copy'] }}
                    </p>

                    {{-- Connector arrows for desktop --}}
                    @if ($idx < 2)
                        <div class="absolute top-8 left-1/2 w-full hidden sm:block h-px bg-slate-800 translate-x-8 -z-10"></div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
</section>