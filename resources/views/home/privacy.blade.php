@extends('layouts.public')

@section('meta_description', 'Review how ' . $settings->site_name . ' handles privacy, user data, and platform communications.')

@section('content')
    <section class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[36px] p-8 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-300">Privacy Policy</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-white sm:text-5xl">Data handling and platform privacy.</h1>
            <div class="prose prose-invert mt-8 max-w-none prose-p:text-slate-300 prose-headings:text-white prose-strong:text-white">
                {!! optional($terms)->description ?: '<p>We use personal data to operate accounts, process security workflows, communicate required notices, and maintain platform integrity. Personal data is handled with access controls and is not sold as an advertising dataset.</p><p>Where compliance, anti-fraud, or regulatory obligations apply, certain data may be processed or retained for those purposes.</p>' !!}
            </div>
        </div>
    </section>
@endsection
