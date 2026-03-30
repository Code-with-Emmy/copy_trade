<section class="py-24 bg-black">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16 reveal">
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl">
                What our copiers say
            </h2>
        </div>

        <div class="grid gap-8 sm:grid-cols-3">
            @php
                $testimonials = [
                    [
                        'quote' => '"Following top FX strategists with built-in risk controls helped me grow consistently without screen-watching 24/7."',
                        'author' => 'Sarah Johnson · Miami'
                    ],
                    [
                        'quote' => '"The copy ratios and capital protection tools keep my portfolio balanced even during volatility. Love the transparency."',
                        'author' => 'Michael Chen · Singapore'
                    ],
                    [
                        'quote' => '"Smart alerts let me pause and resume strategies instantly. I feel safe mirroring specialists in markets I don\'t know."',
                        'author' => 'Emma Rodriguez · Madrid'
                    ]
                ];
            @endphp

            @foreach ($testimonials as $idx => $t)
                <div class="reveal p-8 rounded-2xl bg-[#0f0f0f] border border-white/5 transition-all hover:-translate-y-2"
                    style="transition-delay: {{ $idx * 150 }}ms">
                    <p class="text-lg leading-relaxed text-slate-300 italic mb-8">
                        {{ $t['quote'] }}
                    </p>
                    <h4 class="font-bold text-sm uppercase tracking-widest text-[#f0b90a]">
                        {{ $t['author'] }}
                    </h4>
                </div>
            @endforeach
        </div>

    </div>
</section>