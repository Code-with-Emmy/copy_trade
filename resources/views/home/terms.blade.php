@extends('layouts.public')

@section('meta_description', 'Review the terms governing access to the ' . $settings->site_name . ' copy trading platform.')

@section('content')
    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[36px] p-8 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-300">Terms of Service</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-white sm:text-5xl">Platform terms, responsibilities, and service limits.</h1>
            <div class="prose prose-invert mt-8 max-w-none prose-p:text-slate-300 prose-headings:text-white prose-strong:text-white">
                {!! optional($terms)->useterms ?: '<p>By using this platform, users agree to provide accurate account information, comply with applicable laws, and avoid misuse of market, payment, or promotional systems.</p><p>Copy trading involves risk and platform availability, execution quality, or data accuracy cannot eliminate the possibility of loss.</p>' !!}
            </div>
        </div>
    </section>
@endsection
