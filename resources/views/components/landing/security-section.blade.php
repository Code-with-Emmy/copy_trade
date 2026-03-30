@php
    $items = [
        [
            'title' => 'Encrypted Infrastructure',
            'copy' => 'Bank-grade TLS encryption protects every transaction. Hardened boundaries, access controls, and audit trails keep your account operations secure.',
            'icon' => 'img/in-theramanuel-16-icon-1.png',
            'accent' => 'text-emerald-300',
            'bg' => 'bg-emerald-400/10',
        ],
        [
            'title' => 'Verified Trader Profiles',
            'copy' => 'Every featured trader is labelled with verification status, risk level, and historical performance records — nothing hidden.',
            'icon' => 'img/in-theramanuel-16-icon-2.png',
            'accent' => 'text-sky-300',
            'bg' => 'bg-sky-400/10',
        ],
        [
            'title' => 'Transparent Analytics',
            'copy' => 'ROI, drawdown, and copy activity are surfaced in the product — so you can audit a trader\'s history before allocating a single dollar.',
            'icon' => 'img/in-theramanuel-16-icon-3.png',
            'accent' => 'text-violet-300',
            'bg' => 'bg-violet-400/10',
        ],
        [
            'title' => 'Risk Management Tools',
            'copy' => 'Drawdown guardrails, allocation limits, and live warnings actively reduce blind risk concentration in your portfolio.',
            'icon' => 'img/in-theramanuel-16-icon-4.png',
            'accent' => 'text-amber-300',
            'bg' => 'bg-amber-400/10',
        ],
    ];

    $trustBadges = [
        ['SSL Secured', 'img/in-theramanuel-6-icon-1.png'],
        ['KYC Verified', 'img/in-theramanuel-6-icon-2.png'],
        ['Risk Rated', 'img/in-theramanuel-6-icon-3.png'],
        ['Auditable', 'img/in-theramanuel-6-icon-4.png'],
    ];
@endphp

<section id="security" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Section header --}}
    <div class="text-center max-w-3xl mx-auto mb-12 reveal">
        <span class="inline-block mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-sky-400">Security &
            Trust</span>
        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
            Built to communicate credibility<br class="hidden sm:block"> before conversion.
        </h2>
        <p class="mt-5 text-base text-slate-400 leading-relaxed">
            Every layer of the platform is designed for investor confidence: transparent data, risk-aware communication,
            and compliance-first architecture.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[.9fr,1.1fr] items-start">

        {{-- LEFT: Main image card --}}
        <div class="glass-bright overflow-hidden rounded-[32px] reveal">
            <img src="{{ asset('img/in-theramanuel-8-background.webp') }}" alt="Platform security infrastructure"
                class="h-72 w-full object-cover" loading="lazy">
            <div class="p-6 sm:p-8">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-400 mb-3">Investor-first design</p>
                <p class="text-sm leading-7 text-slate-400">
                    We surface risk narratives, fee structures, and drawdown data at every decision point — so investors
                    enter positions with full context.
                </p>

                {{-- Trust badges --}}
                <div class="mt-6 grid grid-cols-2 gap-3">
                    @foreach ($trustBadges as $badge)
                        <div class="flex items-center gap-3 rounded-2xl border border-white/8 bg-white/[0.03] p-3">
                            <img src="{{ asset($badge[1]) }}" alt="{{ $badge[0] }}" class="h-8 w-8 object-contain"
                                loading="lazy">
                            <span class="text-sm font-semibold text-slate-200">{{ $badge[0] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- RIGHT: Security feature cards --}}
        <div class="grid gap-4 sm:grid-cols-2 reveal" style="transition-delay:.1s">
            @foreach ($items as $item)
                <article
                    class="glass group rounded-3xl p-6 transition duration-300 hover:-translate-y-1 hover:border-white/20">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl {{ $item['bg'] }} mb-4">
                        <img src="{{ asset($item['icon']) }}" alt="{{ $item['title'] }}" class="h-6 w-6 object-contain"
                            loading="lazy">
                    </div>
                    <h3 class="text-base font-bold {{ $item['accent'] }}">{{ $item['title'] }}</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-400">{{ $item['copy'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>