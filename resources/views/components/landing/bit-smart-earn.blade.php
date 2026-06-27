<section class="py-24 bg-black">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-20 reveal">
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">
                {{ $settings->site_name ?? config('app.name') }}: Follow, Automate, Earn.
            </h2>
            <p class="mt-4 text-slate-400">
                Mirror seasoned traders with the safeguards you need
            </p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-2 lg:max-w-5xl lg:mx-auto">
            @php
                $earnItems = [
                    [
                        'title' => 'Flexible Allocation Controls',
                        'copy' => 'Distribute capital across multiple traders with one slider to maintain a balanced and diversified portfolio.'
                    ],
                    [
                        'title' => 'Instant Trade Replication',
                        'copy' => 'Execute entries and exits the moment your lead trader acts, ensuring you capture every pip of performance.'
                    ],
                    [
                        'title' => 'Strategy Performance Insights',
                        'copy' => 'Visualize Sharpe, win rate, and average holding time instantly to make data-driven following decisions.'
                    ],
                    [
                        'title' => 'Risk Caps & Circuit Breakers',
                        'copy' => 'Set trailing drawdown alerts and auto-pause under turbulence to protect your principal capital.'
                    ]
                ];
            @endphp

            @foreach ($earnItems as $idx => $item)
                <div class="reveal flex gap-6 p-8 rounded-2xl bg-[#0f0f0f] border border-white/5 transition-all hover:bg-[#151515] hover:border-[#f0b90a]/20"
                    style="transition-delay: {{ $idx * 100 }}ms">
                    <div
                        class="flex-shrink-0 w-8 h-8 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 mt-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-white mb-2">{{ $item['title'] }}</h4>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            {{ $item['copy'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>