@extends('layouts.public')

@section('title', 'Sign In')
@section('meta_description', 'Sign in to BitCloven to manage your copy trading subscriptions and monitor portfolio analytics.')

@section('content')
    <section class="min-h-[80vh] flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl grid gap-12 lg:grid-cols-2 items-center">
            
            {{-- Content Column --}}
            <div class="hidden lg:block reveal">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#f0b90a]/10 border border-[#f0b90a]/20 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f0b90a] animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-[#f0b90a]">Secure Access</span>
                </div>
                <h1 class="font-display text-5xl font-bold text-white leading-tight mb-6">
                    Return to your <br>
                    <span class="text-[#f0b90a]">strategic</span> command.
                </h1>
                <p class="text-lg text-slate-400 leading-relaxed mb-8 max-w-md">
                    Monitor your mirrored strategies, manage risk parameters, and track real-time performance from your premium investor dashboard.
                </p>
                
                <div class="space-y-4">
                    @foreach ([
                        'Real-time strategy replication monitoring',
                        'Advanced risk guard and equity protection',
                        'Transparent trader performance analytics',
                    ] as $item)
                        <div class="flex items-center gap-3 text-slate-300">
                            <div class="w-5 h-5 rounded-full bg-[#f0b90a]/10 border border-[#f0b90a]/20 flex items-center justify-center">
                                <svg class="w-3 h-3 text-[#f0b90a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">{{ $item }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Form Column --}}
            <div class="reveal" style="transition-delay: 200ms">
                <div class="glass-bright rounded-[32px] p-8 sm:p-12 relative overflow-hidden">
                    {{-- Subtle glow --}}
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-[#f0b90a]/10 blur-[80px] rounded-full"></div>
                    
                    <div class="relative z-10">
                        <div class="mb-10 lg:hidden">
                            <h2 class="text-3xl font-bold text-white mb-2">Sign In</h2>
                            <p class="text-slate-400">Secure access to your BitCloven account</p>
                        </div>

                        <form action="{{ route('login') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            @if (session('status'))
                                <div class="px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="space-y-2">
                                <label for="email" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Identity</label>
                                <div class="relative">
                                    <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus 
                                           placeholder="Email or Username"
                                           class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between items-center ml-1">
                                    <label for="password" class="text-xs font-bold uppercase tracking-widest text-slate-500">Credential</label>
                                    <a href="{{ route('password.request') }}" class="text-[10px] font-bold uppercase tracking-widest text-[#f0b90a] hover:text-white transition-colors">Recover?</a>
                                </div>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required 
                                           placeholder="••••••••"
                                           class="w-full bg-black/40 border border-white/5 rounded-2xl px-5 py-4 text-white placeholder:text-slate-600 focus:outline-none focus:border-[#f0b90a]/50 focus:ring-1 focus:ring-[#f0b90a]/30 transition-all">
                                </div>
                            </div>

                            <div class="flex items-center justify-between py-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <div class="relative flex items-center">
                                        <input type="checkbox" name="remember" class="peer appearance-none w-5 h-5 bg-black/40 border border-white/10 rounded-lg checked:border-[#f0b90a] checked:bg-[#f0b90a] transition-all cursor-pointer">
                                        <svg class="absolute w-3.5 h-3.5 text-black left-0.5 pointer-events-none hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-400 group-hover:text-slate-200 transition-colors uppercase tracking-widest">Persist Session</span>
                                </label>
                            </div>

                            <button type="submit" class="w-full h-14 bg-[#f0b90a] hover:bg-[#c99408] text-black font-bold rounded-2xl transition-all flex items-center justify-center gap-2 group shadow-lg shadow-[#f0b90a]/10">
                                <span>Authenticate Access</span>
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </form>

                        <div class="mt-8 pt-8 border-t border-white/5 flex flex-col items-center gap-4">
                            <p class="text-slate-500 text-xs font-medium uppercase tracking-widest">New to the platform?</p>
                            <a href="{{ route('register') }}" class="text-[#f0b90a] font-bold text-sm hover:underline">Establish Account →</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
