@props(['faqs' => collect()])

@php
    $items = collect($faqs)->isNotEmpty()
        ? collect($faqs)->values()->take(7)->map(fn($faq) => ['q' => $faq->question, 'a' => $faq->answer])
        : collect([
            [
                'q' => 'What is copy trading?',
                'a' => 'Copy trading lets you automatically mirror the trades of expert lead traders. It can help you learn or earn passively — but it still carries risk. The copied strategy can generate losses as well as gains.'
            ],
            [
                'q' => 'How does copy trading work?',
                'a' => 'After selecting a trader and setting your copy-trading preferences, the platform instantly mirrors eligible trades within your parameters. Missed trades show in your timeline, and autocopy stays active until you pause it or the trader stops.'
            ],
            [
                'q' => 'How much do I need to start?',
                'a' => 'Choose between Relative to Trader or Fixed Amount allocations. Fixed allocations start at just $10, while Relative to Trader depends on the minimum available position for the instrument you copy.'
            ],
            [
                'q' => 'Can I customise my risk settings?',
                'a' => 'Yes. You can adjust risk level, allocation cap, stop loss, and take profit to fit your plan. Your trades can still follow the lead trader\'s settings, but you retain full control at all times.'
            ],
            [
                'q' => 'How do I choose the right trader?',
                'a' => 'Review performance history, risk score, drawdown, and strategy consistency. Make sure their approach matches your risk appetite and that their portfolio is diversified the way you expect.'
            ],
            [
                'q' => 'Can I copy multiple traders at once?',
                'a' => 'Yes. You can run multiple copy allocations simultaneously. They continue operating until you pause them, the trader stops, or you run out of allocated funds.'
            ],
            [
                'q' => 'What assets can I copy across?',
                'a' => 'Copy trading provides access to instruments across forex, crypto, stocks, commodities, ETFs, indices, and more — mirroring the same range that lead traders use.'
            ],
        ]);
@endphp

<section id="faq" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-10 lg:grid-cols-[.9fr,1.1fr] lg:items-start">

        {{-- LEFT — sticky header --}}
        <div class="lg:sticky lg:top-28 reveal">
            <span class="inline-block mb-3 text-xs font-bold uppercase tracking-[0.28em] text-sky-400">FAQ</span>
            <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
                Copy Trading FAQs
            </h2>
            <p class="mt-5 text-sm leading-7 text-slate-400">
                Everything you need to know before allocating capital. Clear answers on risk, allocation, and platform
                operations.
            </p>
            <div class="mt-8 flex flex-col gap-3">
                <a href="{{ route('faq') }}"
                    class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-5 py-4 text-sm font-semibold text-slate-200 transition hover:border-white/18 hover:bg-white/5">
                    <svg class="h-5 w-5 text-sky-400" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                    </svg>
                    Full Help Center
                </a>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-5 py-4 text-sm font-semibold text-slate-200 transition hover:border-white/18 hover:bg-white/5">
                    <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>

        {{-- RIGHT — accordion --}}
        <div class="space-y-3 reveal" style="transition-delay:.1s" x-data="{ active: 0 }">
            @foreach ($items as $idx => $item)
                <article class="glass rounded-2xl overflow-hidden transition duration-300"
                    :class="active === {{ $idx }} ? 'border-emerald-400/25 shadow-glow' : 'border-white/8 hover:border-white/15'">
                    <button type="button" class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left"
                        @click="active = active === {{ $idx }} ? null : {{ $idx }}">
                        <span class="text-sm font-semibold text-white leading-snug">{{ $item['q'] }}</span>
                        <span
                            class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full border border-white/10 transition"
                            :class="active === {{ $idx }} ? 'bg-emerald-400/15 border-emerald-400/25 text-emerald-300' : 'text-slate-400'">
                            <svg class="h-3.5 w-3.5 transition duration-200" :class="{ 'rotate-45': active === {{ $idx }} }"
                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                    </button>
                    <div x-cloak x-show="active === {{ $idx }}" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="border-t border-white/6 px-6 pb-6 pt-4 text-sm leading-7 text-slate-400">
                        {{ $item['a'] }}
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>