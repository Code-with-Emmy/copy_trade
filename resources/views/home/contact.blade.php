@extends('layouts.public')

@section('meta_description', 'Contact the ' . $settings->site_name . ' team for platform, compliance, and investor support enquiries.')

@section('content')
    <section class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-[.95fr,1.05fr]">
            <div class="glass rounded-[36px] p-8 sm:p-10">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-emerald-300">Contact</p>
                <h1 class="mt-3 font-display text-4xl font-bold text-white sm:text-5xl">Talk to a team that understands investor trust.</h1>
                <p class="mt-5 text-base leading-8 text-slate-300">
                    Use this channel for product questions, partnership enquiries, verification matters, or investor support. Messages route to the platform operations team.
                </p>

                <div class="mt-8 space-y-4">
                    <div class="rounded-[24px] border border-white/5 bg-slate-950/50 p-5">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Support</p>
                        <p class="mt-2 text-lg font-semibold text-white">{{ $settings->contact_email ?? 'support@example.com' }}</p>
                    </div>
                    <div class="rounded-[24px] border border-white/5 bg-slate-950/50 p-5">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Response expectation</p>
                        <p class="mt-2 text-lg font-semibold text-white">Within 1 business day</p>
                    </div>
                    <div class="rounded-[24px] border border-white/5 bg-slate-950/50 p-5">
                        <p class="text-xs uppercase tracking-[0.18em] text-slate-500">Coverage</p>
                        <p class="mt-2 text-lg font-semibold text-white">Platform operations · trader verification · account support</p>
                    </div>
                </div>
            </div>

            <div class="glass rounded-[36px] p-8 sm:p-10">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="name" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Full name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                        </div>
                        <div>
                            <label for="email" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Subject</label>
                        <input id="subject" type="text" name="subject" value="{{ old('subject') }}" required class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">
                    </div>
                    <div>
                        <label for="message" class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">Message</label>
                        <textarea id="message" name="message" rows="7" required class="mt-2 w-full rounded-2xl border border-white/10 bg-slate-950/60 px-4 py-3 text-sm text-white focus:border-sky-400 focus:outline-none">{{ old('message') }}</textarea>
                    </div>
                    <div class="rounded-[24px] border border-amber-400/20 bg-amber-400/10 p-4 text-sm leading-7 text-amber-100/80">
                        Do not send passwords, seed phrases, or sensitive banking secrets through this form. Account-specific action requests may require verification inside the secured dashboard.
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3.5 text-sm font-semibold text-slate-950 transition hover:bg-emerald-300">Send message</button>
                </form>
            </div>
        </div>
    </section>
@endsection
