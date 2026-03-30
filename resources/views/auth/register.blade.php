@php
    $captcha = strtoupper(substr(md5(rand()), 0, 6));
@endphp

@extends('layouts.public')

@section('title', 'Establish Account')
@section('meta_description', 'Begin your journey with BitCloven. Join a global network of elite traders and mirror high-performance strategies.')

@section('content')
    <section class="min-h-[90vh] flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-6xl">

            <div class="text-center mb-12 reveal">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#f0b90a]/10 border border-[#f0b90a]/20 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f0b90a] animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#f0b90a]">Open Architecture</span>
                </div>
                <h1 class="font-display text-4xl lg:text-5xl font-bold text-white mb-4">
                    Join the <span class="text-[#f0b90a]">elite</span> network.
                </h1>
                <p class="text-slate-400 max-w-2xl mx-auto">
                    Configure your investor environment and start mirroring world-class performance in minutes.
                </p>
            </div>

            <div class="glass-bright rounded-[40px] p-1 sm:p-2 max-w-4xl mx-auto overflow-hidden shadow-2xl reveal"
                style="transition-delay: 100ms">
                <div class="bg-black/40 rounded-[38px] p-8 sm:p-12">

                    <form action="{{ route('register') }}" method="POST" class="space-y-8">
                        @csrf

                        {{-- Identity Grid --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="name"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Full
                                    Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                    placeholder="John Doe"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('name')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label for="username"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Username</label>
                                <input id="username" type="text" name="username" value="{{ old('username') }}" required
                                    placeholder="johndoe_fx"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('username')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Contact Grid --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="email"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Email
                                    Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    placeholder="john@example.com"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('email')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label for="phone"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Contact
                                    Number</label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                                    placeholder="+1 234 567 890"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('phone')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Region --}}
                        <div class="space-y-2">
                            <label for="country"
                                class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Residential
                                Region</label>
                            <div class="relative">
                                <select id="country" name="country" required
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white appearance-none focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                    <option value="" class="bg-slate-900">Select Geography</option>
                                    @include('auth.countries')
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('country')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Credentials Grid --}}
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label for="password"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Security
                                    Key</label>
                                <input id="password" type="password" name="password" required placeholder="••••••••"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('password')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Verify
                                    Key</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    placeholder="••••••••"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                            </div>
                        </div>

                        {{-- Verification Layer --}}
                        <div class="p-6 rounded-3xl bg-black/50 border border-white/5">
                            @if ($settings->captcha == 'true')
                                <div class="space-y-3">
                                    <label class="text-xs font-bold uppercase tracking-widest text-[#f0b90a]">Automated Risk
                                        Check</label>
                                    <div class="scale-90 origin-left">
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                    </div>
                                    @error('g-recaptcha-response')<p class="text-[10px] text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @else
                                <div class="grid gap-6 sm:grid-cols-[200px,1fr] items-center">
                                    <div
                                        class="h-14 flex items-center justify-center rounded-2xl bg-[#f0b90a]/10 border-2 border-dashed border-[#f0b90a]/30 font-display text-3xl font-bold tracking-[0.3em] text-[#f0b90a] select-none italic">
                                        {{ $captcha }}
                                    </div>
                                    <div class="space-y-2">
                                        <label for="captcha"
                                            class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Internal
                                            Validation Code</label>
                                        <input id="captcha" type="text" name="captcha" required autocomplete="off"
                                            placeholder="Type the code"
                                            class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-3.5 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                        <input type="hidden" name="captcha_confirmation" value="{{ $captcha }}">
                                        @error('captcha')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Agreement --}}
                        <label
                            class="flex items-start gap-4 p-5 rounded-3xl bg-[#f0b90a]/5 border border-[#f0b90a]/10 cursor-pointer group">
                            <div class="relative flex items-center mt-1">
                                <input type="checkbox" name="terms" value="1" required
                                    class="peer appearance-none w-5 h-5 bg-black/40 border border-white/10 rounded-lg checked:border-[#f0b90a] checked:bg-[#f0b90a] transition-all cursor-pointer">
                                <svg class="absolute w-3.5 h-3.5 text-black left-0.5 pointer-events-none hidden peer-checked:block"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-slate-400 leading-relaxed">
                                By establishing this account, I confirm my agreement to the <a href="{{ route('terms') }}"
                                    class="text-[#f0b90a] font-bold hover:underline">Investment Terms</a> and acknowledge
                                the <a href="{{ route('privacy') }}" class="text-[#f0b90a] font-bold hover:underline">Data
                                    Protection Policy</a>.
                            </span>
                        </label>

                        @if (Session::has('ref_by'))
                            <input type="hidden" name="ref_by" value="{{ session('ref_by') }}">
                        @endif

                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <button type="submit"
                                class="w-full sm:flex-1 h-16 bg-[#f0b90a] hover:bg-[#c99408] text-black font-extrabold text-lg rounded-2xl transition-all shadow-xl shadow-[#f0b90a]/10 flex items-center justify-center gap-2 group">
                                <span>Initialize Workspace</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                            <div class="text-center sm:text-left">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-1">Already
                                    registered?</p>
                                <a href="{{ route('login') }}"
                                    class="text-[#f0b90a] font-bold text-sm hover:underline">Secure Login →</a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </section>
@endsection