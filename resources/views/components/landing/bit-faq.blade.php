<section id="faq" class="py-24 bg-[#0f0f0f]">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">

        <div class="text-center mb-16 reveal">
            <h2 class="font-display text-4xl font-bold text-white">
                Copy Trading <span class="text-[#f0b90a]">FAQs</span>
            </h2>
        </div>

        <div class="space-y-4 reveal" x-data="{ active: 0 }">
            @php
                $faqs = [
                    [
                        'q' => 'What is copy trading?',
                        'a' => 'Copy trading lets you automatically mirror the trades of lead traders. It can help you learn or earn passively, but it still carries risk—the copied strategy can generate losses as well as gains.'
                    ],
                    [
                        'q' => 'How does BitCloven copy work?',
                        'a' => 'After selecting a trader and setting your copy-trading preferences, the platform instantly mirrors eligible trades within your parameters. Missed trades show in your timeline, and Autocopy stays active until you pause it or the trader stops.'
                    ],
                    [
                        'q' => 'How much does it cost to copy another trader?',
                        'a' => 'Choose between Relative to Leader or Fixed Amount allocations. Fixed allocations start at just $10, while Relative to Leader depends on the minimum available position for the instrument you copy.'
                    ],
                    [
                        'q' => 'Can I customize my copy trading settings?',
                        'a' => 'Yes. You can adjust risk level, allocation, stop loss, and take profit to fit your plan. Your trades can still follow the lead trader’s settings, but you retain full control.'
                    ],
                    [
                        'q' => 'What should I look for when choosing a trader to copy?',
                        'a' => 'Review performance history, risk score, drawdown, and strategy consistency. Make sure their approach matches your risk appetite and that their portfolio is diversified the way you expect.'
                    ],
                    [
                        'q' => 'Can I copy more than one trader at a time?',
                        'a' => 'Yes. You can run multiple Autocopy allocations simultaneously. They continue operating until you pause them, the trader stops, or you run out of funds.'
                    ],
                    [
                        'q' => 'Which markets can I trade through copy trading?',
                        'a' => 'Copy trading provides access to 4000+ instruments across stocks, CFDs, forex, crypto, commodities, ETFs, indices, and more—mirroring the same range that lead traders use.'
                    ]
                ];
            @endphp

            @foreach ($faqs as $idx => $f)
                <div class="glass-bright rounded-xl overflow-hidden border border-white/5 transition-all duration-300"
                    :class="active === {{ $idx }} ? 'border-[#f0b90a]/30 ring-1 ring-[#f0b90a]/20' : ''">
                    <button type="button" class="w-full flex items-center justify-between p-6 text-left focus:outline-none"
                        @click="active = active === {{ $idx }} ? null : {{ $idx }}">
                        <span class="text-lg font-bold text-white pr-8">{{ $f['q'] }}</span>
                        <span class="flex-shrink-0 text-[#f0b90a] transition-transform duration-300"
                            :class="active === {{ $idx }} ? 'rotate-180' : ''">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </span>
                    </button>
                    <div x-cloak x-show="active === {{ $idx }}" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-[500px]"
                        class="px-6 pb-6 text-slate-400 leading-relaxed overflow-hidden">
                        {{ $f['a'] }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>