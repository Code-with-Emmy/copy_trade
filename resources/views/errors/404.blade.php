@extends('layouts.public')

@section('title', 'Page Not Found')
@section('meta_description', 'The page you requested could not be found on ' . ($settings->site_name ?? config('app.name')))

@section('content')
    <section class="min-h-[80vh] flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl">

            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#f0b90a]/10 border border-[#f0b90a]/20 mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f0b90a] animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#f0b90a]">Not Found</span>
                </div>
                <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-2">We can't find that page.</h1>
                <p class="text-slate-400 max-w-2xl mx-auto">The link may be broken, expired, or the page has been removed. Try returning home or create an account to get started.</p>
            </div>

            <div class="glass-bright rounded-[40px] p-1 sm:p-2 max-w-4xl mx-auto overflow-hidden shadow-2xl">
                <div class="bg-black/40 rounded-[38px] p-8 sm:p-12 grid gap-6 md:grid-cols-2 items-center">

                    <div>
                        <div class="text-7xl font-extrabold text-[#f0b90a] leading-none">404</div>
                        <div class="mt-4">
                            <h2 class="text-2xl font-bold text-white">Page Not Found</h2>
                            <p class="text-slate-400 mt-3">We couldn't locate the page you were looking for. If you typed the address manually, please double-check it.</p>

                            <div class="mt-6 flex flex-col sm:flex-row items-center gap-4">
                                <a href="{{ url('/') }}" class="h-14 inline-flex items-center justify-center px-6 rounded-2xl bg-[#f0b90a] text-black font-extrabold">Back to Home</a>
                                <a href="{{ route('register') }}" class="h-14 inline-flex items-center justify-center px-6 rounded-2xl border border-white/10 text-white">Create Account</a>
                            </div>

                            <p class="text-[12px] text-slate-500 mt-4">If this problem persists, contact <a href="mailto:{{ $settings->support_email ?? 'support@' . (parse_url(config('app.url', ''), PHP_URL_HOST) ?? 'example.com') }}" class="text-[#f0b90a]">support</a> and include the URL and timestamp.</p>
                        </div>
                    </div>

                    <div class="text-center md:text-right">
                        <img src="{{ asset('images/Copy-Trading.png') }}" alt="Illustration" class="mx-auto md:ml-auto rounded-lg border border-white/6 max-w-[320px]">
                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message', __("The page you're looking for doesn't exist, or was loaded incorrectly."))
