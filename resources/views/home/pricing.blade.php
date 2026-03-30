@extends('layouts.public')

@section('title', 'Pricing')
@section('meta_description', 'Compare investor tiers, platform benefits, and support access on ' . $settings->site_name . '.')

@push('head')
    <style>
        .pricing-shell {
            background:
                radial-gradient(circle at 8% 0%, rgba(240, 185, 10, .09), transparent 28%),
                radial-gradient(circle at 92% 4%, rgba(56, 189, 248, .08), transparent 26%),
                linear-gradient(180deg, rgba(2, 6, 23, .92), rgba(2, 6, 23, 0));
        }

        .pricing-panel {
            border: 1px solid rgba(255, 255, 255, .09);
            background: linear-gradient(145deg, rgba(12, 19, 32, .96), rgba(8, 13, 23, .94));
            box-shadow: 0 22px 65px -32px rgba(2, 6, 23, .95);
        }

        .pricing-strip img {
            height: 22px;
            width: auto;
            opacity: .78;
            filter: grayscale(100%) brightness(1.8) contrast(.85);
        }
    </style>
@endpush

@section('content')
    @php
        $planCollection = collect($plans)->take(3)->values();
        $comparisonRows = [
            ['label' => 'Trader marketplace access', 'values' => ['Public screen', 'Full filters', 'Priority discovery']],
            ['label' => 'Portfolio analytics', 'values' => ['Core metrics', 'Advanced charts', 'Institutional reporting']],
            ['label' => 'Copy allocation controls', 'values' => ['Basic', 'Advanced', 'Advanced + concierge']],
            ['label' => 'Support model', 'values' => ['Email', 'Priority email', 'Dedicated relationship desk']],
            ['label' => 'Compliance and reporting', 'values' => ['Standard', 'Enhanced', 'Enhanced + export priority']],
        ];
    @endphp

    <section class="pricing-shell mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8 lg:pb-24">
        <div class="pricing-panel relative overflow-hidden rounded-[36px] p-6 sm:p-8 lg:p-10">
            <img src="{{ asset('images/hero.png') }}" alt="Platform dashboard preview"
                class="pointer-events-none absolute right-0 top-0 hidden h-full w-[44%] object-cover opacity-20 lg:block">
            <div class="pointer-events-none absolute -left-14 top-10 h-44 w-44 rounded-full bg-yellow-400/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-10 bottom-0 h-44 w-44 rounded-full bg-sky-400/10 blur-3xl"></div>

            <div class="relative grid gap-8 lg:grid-cols-[1.05fr,.95fr] lg:items-end">
                <div class="max-w-3xl">
                    <p class="text-[11px] font-black uppercase tracking-[0.24em] text-yellow-400">Pricing</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight text-white sm:text-5xl">
                        Investor access structured for scale, clarity, and trust.
                    </h1>
                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-300 sm:text-base">
                        Platform plans cover discovery depth, analytics access, support levels, and reporting controls.
                        Trader-specific performance and management fees still remain transparent inside each profile and copy flow.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 px-6 py-3 text-sm font-semibold text-black transition hover:brightness-110">
                            Create Investor Account
                        </a>
                        <a href="{{ route('traders.index') }}"
                            class="inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-semibold text-slate-100 transition hover:border-white/30 hover:bg-white/5">
                            Explore Traders
                        </a>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Plans</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format($planCollection->count()) }}</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Investor Fit</p>
                        <p class="mt-2 text-sm font-bold text-white">Retail to desk-level</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-black/25 px-4 py-4">
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Fee Visibility</p>
                        <p class="mt-2 text-sm font-bold text-emerald-300">Profile-level disclosure</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="pricing-strip mt-5 rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 sm:px-6">
            <p class="mb-3 text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Trusted infrastructure references</p>
            <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                <img src="{{ asset('images/bybit.svg') }}" alt="Bybit">
                <img src="{{ asset('images/allianz.svg') }}" alt="Allianz">
                <img src="{{ asset('images/square.svg') }}" alt="Square">
                <img src="{{ asset('images/morgan.png') }}" alt="Morgan">
                <img src="{{ asset('images/ml.png') }}" alt="Merrill Lynch">
            </div>
        </div>

        <div class="mt-8 grid gap-6 xl:grid-cols-3">
            @forelse ($planCollection as $index => $plan)
                <article class="pricing-panel relative overflow-hidden rounded-[32px] p-7 {{ $index === 1 ? 'ring-1 ring-yellow-400/35' : '' }}">
                    <div class="pointer-events-none absolute -right-10 -top-10 h-28 w-28 rounded-full {{ $index === 1 ? 'bg-yellow-400/12' : 'bg-white/5' }} blur-3xl"></div>

                    <div class="relative">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">{{ $plan->type ?: 'Investor tier' }}</p>
                                <h2 class="mt-3 text-3xl font-black tracking-tight text-white">{{ $plan->name }}</h2>
                            </div>
                            @if (!empty($plan->badge_text))
                                <span class="rounded-full border border-yellow-400/20 bg-yellow-400/10 px-3 py-1 text-[10px] font-black uppercase tracking-[0.18em] text-yellow-200">
                                    {{ $plan->badge_text }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-6 rounded-[24px] border border-white/10 bg-black/25 p-5">
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">Allocation range</p>
                            <p class="mt-3 text-3xl font-black text-white">
                                ${{ number_format((float) $plan->min_price, 0) }}
                                <span class="text-lg text-slate-500">to</span>
                                ${{ number_format((float) $plan->max_price, 0) }}
                            </p>
                            <p class="mt-3 text-sm font-semibold text-emerald-300">
                                {{ number_format((float) $plan->min_return, 1) }}% - {{ number_format((float) $plan->max_return, 1) }}% projected ROI band
                            </p>
                        </div>

                        <div class="mt-6 text-sm leading-7 text-slate-300">
                            {!! $plan->description ?: 'Portfolio access, investor support, and reporting depth scale with plan tier.' !!}
                        </div>

                        <div class="mt-6 space-y-3">
                            @foreach ([
                                'Advanced trader discovery',
                                'Risk-aware copy controls',
                                'Transaction and wallet visibility',
                                'Compliance-first investor messaging',
                            ] as $feature)
                                <div class="flex items-center gap-3 text-sm text-slate-300">
                                    <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-emerald-400/10 text-emerald-300">•</span>
                                    <span>{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 flex flex-col gap-3">
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-yellow-400 to-amber-500 px-5 py-3 text-sm font-semibold text-black transition hover:brightness-110">
                                Choose {{ $plan->name }}
                            </a>
                            <a href="{{ route('traders.index') }}"
                                class="inline-flex items-center justify-center rounded-full border border-white/15 px-5 py-3 text-sm font-semibold text-slate-100 transition hover:border-white/30 hover:bg-white/5">
                                Review Traders First
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="pricing-panel col-span-full rounded-[32px] p-10 text-center text-slate-400">
                    Pricing plans are being configured by the platform team.
                </div>
            @endforelse
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-[1.1fr,.9fr]">
            <section class="pricing-panel rounded-[32px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-sky-300">Plan Comparison</p>
                <h2 class="mt-3 text-2xl font-black tracking-tight text-white sm:text-3xl">What changes as you move up the stack.</h2>

                <div class="mt-6 overflow-x-auto rounded-[24px] border border-white/10">
                    <table class="min-w-[720px] divide-y divide-white/10 text-sm sm:min-w-full">
                        <thead class="bg-black/35 text-left text-[10px] font-black uppercase tracking-[0.18em] text-slate-500">
                            <tr>
                                <th class="px-5 py-4">Capability</th>
                                @foreach ($planCollection as $plan)
                                    <th class="px-5 py-4">{{ $plan->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10 bg-white/[0.02] text-slate-300">
                            @foreach ($comparisonRows as $row)
                                <tr>
                                    <td class="px-5 py-4 font-semibold text-white">{{ $row['label'] }}</td>
                                    @foreach ($row['values'] as $value)
                                        <td class="px-5 py-4">{{ $value }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="pricing-panel rounded-[32px] p-6 sm:p-8">
                <p class="text-[11px] font-black uppercase tracking-[0.24em] text-emerald-300">Included With Every Tier</p>
                <h2 class="mt-3 text-2xl font-black tracking-tight text-white">Baseline trust features should not be optional.</h2>

                <div class="mt-6 grid gap-4">
                    @foreach ([
                        'Trader discovery and public profile analytics',
                        'Wallet balance visibility and transaction records',
                        'Subscription guardrails and fee disclosure',
                        'In-app notifications and alert infrastructure',
                        'Portfolio P/L monitoring and allocation views',
                        'Compliance and legal trust pages',
                    ] as $feature)
                        <div class="rounded-[22px] border border-white/10 bg-black/25 px-4 py-4 text-sm text-slate-300">
                            {{ $feature }}
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 rounded-[24px] border border-amber-400/20 bg-amber-400/10 p-4 text-sm leading-7 text-amber-100/85">
                    Copied performance depends on market conditions, slippage, execution timing, and the selected trader’s live behavior. Review all fees and risk controls before allocating capital.
                </div>
            </section>
        </div>

        <section class="pricing-panel mt-8 rounded-[32px] p-6 sm:p-8">
            <div class="grid gap-8 lg:grid-cols-[.9fr,1.1fr]">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-[0.24em] text-sky-300">Pricing FAQ</p>
                    <h2 class="mt-3 text-2xl font-black tracking-tight text-white sm:text-3xl">
                        Questions before upgrading or allocating more capital.
                    </h2>
                    <p class="mt-4 text-sm leading-7 text-slate-400">
                        These answers are designed to set expectations clearly before an investor moves into a paid access tier.
                    </p>
                </div>
                <x-public.faq-accordion :items="collect($faqs)" />
            </div>
        </section>
    </section>
@endsection
