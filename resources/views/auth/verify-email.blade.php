@extends('layouts.public')

@section('title', 'Verify Your Email')
@section('meta_description', 'Verify your email address to finish setting up your account.')

@section('content')
    <section class="min-h-[80vh] flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl">
            <div class="glass-bright rounded-[40px] p-1 sm:p-2 shadow-2xl">
                <div class="bg-black/40 rounded-[38px] p-8 sm:p-12">
                    <div class="text-center mb-10">
                        <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4">Verify Your Email</h1>
                        <p class="text-slate-400 max-w-2xl mx-auto">
                            Check your inbox for a verification link and click it to finish setting up your account.
                        </p>
                    </div>


                    <div class="mb-8 rounded-3xl border border-white/10 bg-white/5 p-6">
                        <h2 class="text-lg font-semibold text-white mb-3">What to do next</h2>
                        <p class="text-sm text-slate-400 mb-4">
                            Open your email and click the verification link we just sent. Once verified, you can sign in and use the platform.
                        </p>
                        <ul class="space-y-3 text-sm text-slate-300">
                            <li>1. Open your inbox</li>
                            <li>2. Find the email from us</li>
                            <li>3. Click the verification button</li>
                        </ul>
                    </div>

                    <div class="space-y-4">
                        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
                            @csrf
                            <button type="submit"
                                class="w-full rounded-2xl bg-[#f0b90a] px-6 py-4 text-black font-bold transition hover:bg-[#d09d0a]">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full rounded-2xl border border-white/10 bg-white/5 px-6 py-4 text-slate-200 transition hover:border-white/20 hover:bg-white/10">
                                Sign Out
                            </button>
                        </form>
                    </div>

                    <div class="mt-8 rounded-3xl border border-white/10 bg-slate-900/70 p-5 text-sm text-slate-400">
                        <p class="font-semibold text-slate-100 mb-2">Need help?</p>
                        <p>Check your spam folder if you don’t see the email yet. Wait a few minutes, then tap “Resend Verification Email.”</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
