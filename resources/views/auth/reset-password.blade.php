@extends('layouts.public')

@section('title', 'Reset Password')

@section('content')
    <section class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="glass rounded-[36px] p-8 sm:p-10">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-300">Reset password</p>
            <h1 class="mt-3 font-display text-4xl font-bold text-white">Create a new secure password.</h1>
            <p class="mt-5 max-w-2xl text-base leading-8 text-slate-300">Use a password you do not reuse elsewhere. Password reset links expire for security.</p>

            <form method="POST" action="{{ route('password.update') }}" class="mt-8 space-y-5">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label for="email" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="password" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">New password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                    </div>
                    <div>
                        <label for="password_confirmation" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Confirm password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Reset password</button>
            </form>

            <div class="mt-8 text-sm">
                <a href="{{ route('login') }}" class="font-semibold text-white hover:text-emerald-300">Back to sign in</a>
            </div>
        </div>
    </section>
@endsection
