@extends('layouts.public')

@section('meta_description', 'Answers to common investor questions about copy trading, platform risk, and account workflows.')

@section('content')
    <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[.9fr,1.1fr]">
            <div class="glass rounded-[36px] p-8 sm:p-10">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-300">Frequently asked questions</p>
                <h1 class="mt-3 font-display text-4xl font-bold text-white sm:text-5xl">Questions investors ask before they allocate.</h1>
                <p class="mt-5 text-base leading-8 text-slate-300">
                    We surface answers around trader verification, risk, funding, withdrawals, and portfolio visibility because credibility comes from clarity.
                </p>
            </div>

            <x-public.faq-accordion :items="collect($faqs)" />
        </div>
    </section>
@endsection
