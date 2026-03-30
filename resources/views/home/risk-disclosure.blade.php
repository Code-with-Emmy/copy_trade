@extends('layouts.public')

@section('meta_description', 'Read the core market, execution, and copy trading risks associated with using ' . $settings->site_name . '.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[36px] p-8 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-rose-300">Risk Disclosure</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-white sm:text-5xl">Copy trading can amplify both upside and downside.</h1>
            <p class="mt-6 max-w-4xl text-base leading-8 text-slate-300">
                Investors should understand that historical returns, copied trade feeds, and risk scores are informative tools, not guarantees. A trader with strong past results can still experience sharp losses, performance decay, or behavior changes.
            </p>

            <div class="mt-10 grid gap-5 lg:grid-cols-2">
                @foreach ([
                    ['title' => 'Market risk', 'copy' => 'Asset prices can move quickly and irrationally. Losses may occur due to macro events, volatility shocks, or liquidity stress.'],
                    ['title' => 'Execution risk', 'copy' => 'Copied performance can differ from a lead trader because of slippage, pricing gaps, latency, partial fills, or platform-side timing differences.'],
                    ['title' => 'Trader behaviour risk', 'copy' => 'A trader may change strategy, leverage, position concentration, or holding period over time. Past habits do not bind future actions.'],
                    ['title' => 'Allocation risk', 'copy' => 'Over-allocating to a single trader or risk style can magnify drawdowns and impair capital preservation.'],
                    ['title' => 'Operational risk', 'copy' => 'Downtime, data delays, third-party service outages, or payment processing problems may interrupt platform operations.'],
                    ['title' => 'Regulatory and suitability risk', 'copy' => 'Certain products, jurisdictions, or investor categories may require additional due diligence, disclosure, or restrictions.'],
                ] as $item)
                    <div class="rounded-[28px] border border-white/5 bg-slate-950/50 p-6">
                        <h2 class="text-xl font-semibold text-white">{{ $item['title'] }}</h2>
                        <p class="mt-3 text-sm leading-7 text-slate-400">{{ $item['copy'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 rounded-[28px] border border-amber-400/20 bg-amber-400/10 p-6">
                <p class="text-sm font-semibold text-amber-200">Investor reminder</p>
                <p class="mt-3 text-sm leading-7 text-amber-100/80">
                    Only allocate capital you can afford to lose, diversify across strategies where appropriate, and review wallet balances, fees, and active subscription exposure regularly. If a product flow makes risk difficult to understand, pause before funding it.
                </p>
            </div>
        </div>
    </section>
@endsection
