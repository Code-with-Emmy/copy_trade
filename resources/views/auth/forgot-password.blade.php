@extends('layouts.public')

@section('title', 'Credential Recovery')
@section('meta_description', 'Recover access to your ' . ($settings->site_name ?? config('app.name')) . ' account. Enter your registered email to receive a secure reset link.')

@section('content')
    <section class="min-h-[70vh] flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl">

            <div class="reveal">
                <div class="glass-bright rounded-[40px] p-8 sm:p-12 relative overflow-hidden">
                    {{-- Subtle glow --}}
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#f0b90a]/10 blur-[80px] rounded-full"></div>

                    <div class="relative z-10 text-center">
                        <div
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#f0b90a]/10 border border-[#f0b90a]/20 mb-6">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#f0b90a] animate-pulse"></span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-[#f0b90a]">Protocol
                                Recovery</span>
                        </div>

                        <h1 class="font-display text-4xl font-bold text-white mb-4">
                            Restore <span class="text-[#f0b90a]">Control</span>.
                        </h1>
                        <p class="text-slate-400 mb-10 max-w-md mx-auto">
                            Submit your registered email address to receive a cryptographically secure reset authorization
                            link.
                        </p>

                        <form action="{{ route('password.email') }}" method="POST" class="space-y-6 text-left">
                            @csrf

                            <div class="space-y-2">
                                <label for="email"
                                    class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Registered
                                    Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                    placeholder="john@example.com"
                                    class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                @error('email')<p class="text-[10px] text-rose-500 mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <input type="hidden" name="subStep" value="1">

                            <button type="submit"
                                class="w-full h-14 bg-[#f0b90a] hover:bg-[#c99408] text-black font-bold rounded-2xl transition-all flex items-center justify-center gap-2 group shadow-lg shadow-[#f0b90a]/10">
                                <span>Transmit Reset Link</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>

                        <div class="mt-10 pt-8 border-t border-white/5 flex flex-wrap justify-center gap-x-12 gap-y-4">
                            <div class="text-center sm:text-left">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-1">Remembered?
                                </p>
                                <a href="{{ route('login') }}"
                                    class="text-[#f0b90a] font-bold text-sm hover:underline">Secure Login →</a>
                            </div>
                            <div class="text-center sm:text-left">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500 mb-1">New User?
                                </p>
                                <a href="{{ route('register') }}"
                                    class="text-white font-bold text-sm hover:underline">Register Account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection