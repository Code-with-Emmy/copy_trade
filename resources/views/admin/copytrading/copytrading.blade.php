@extends('layouts.admin-dasht')

@section('content')
    @php
        $averagePrice = (float) $copytradings->avg('price');
        $totalFollowers = (float) $copytradings->sum('followers');
        $bestProfit = (float) $copytradings->max('total_profit');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Copy Desk</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Copy <span class="gold-text">Trading</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Manage lead trader offers, pricing, proof metrics, and expert cards from the same dashboard system used across the platform.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('activecopytrading') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="radio" class="mr-2 h-4 w-4"></i>
                    Active Followers
                </a>
                <a href="{{ route('newcopytrading') }}"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    New Expert
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Expert Profiles</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($copytradings->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Published trader cards</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Average Entry Fee</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ $settings->currency }}{{ number_format($averagePrice, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Mean subscription pricing</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Audience Reach</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($totalFollowers) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Combined expert followers</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Top Profit Proof</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ $settings->currency }}{{ number_format($bestProfit, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Highest expert reported result</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($copytradings as $copytrading)
                <article class="dashboard-glass overflow-hidden border-white/5">
                    <div class="border-b border-white/5 bg-white/[0.02] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $copytrading->photo) }}" alt="{{ $copytrading->name }}" class="h-14 w-14 rounded-2xl border border-white/10 object-cover">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Lead Trader</p>
                                    <h2 class="mt-1 text-xl font-black tracking-tight text-white">{{ $copytrading->name }}</h2>
                                </div>
                            </div>
                            @if ($copytrading->tag)
                                <span class="inline-flex rounded-full bg-yellow-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-yellow-400">
                                    {{ $copytrading->tag }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6 p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Price</p>
                                <p class="mt-2 text-lg font-black gold-text">{{ $settings->currency }}{{ number_format((float) $copytrading->price, 2) }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Followers</p>
                                <p class="mt-2 text-lg font-black text-white">{{ number_format((float) $copytrading->followers) }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Profit</p>
                                <p class="mt-2 text-lg font-black text-emerald-400">{{ $settings->currency }}{{ number_format((float) $copytrading->total_profit, 2) }}</p>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Active Days</p>
                                <p class="mt-2 text-lg font-black text-white">{{ number_format((float) $copytrading->active_days) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Equity</span>
                            <span class="text-sm font-black text-white">{{ number_format((float) $copytrading->equity, 2) }}%</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Rating</span>
                            <div class="flex items-center gap-1 text-yellow-400">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" class="h-4 w-4 {{ $i <= (int) $copytrading->rating ? 'fill-yellow-400 text-yellow-400' : 'text-slate-700' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('editcopytrading', $copytrading->id) }}"
                                class="flex-1 rounded-xl border border-sky-500/20 bg-sky-500/10 px-4 py-3 text-center text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                Edit Expert
                            </a>
                            <a href="{{ url('admin/dashboard/trashcopytrading/' . $copytrading->id) }}"
                                onclick="return confirm('Delete this copy trading expert?')"
                                class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20">
                                Delete
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="dashboard-glass px-6 py-16 text-center md:col-span-2 xl:col-span-3">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/5">
                        <i data-lucide="copy" class="h-7 w-7 text-slate-500"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">No copy trading experts configured.</p>
                    <p class="mt-2 text-sm text-slate-500">Create the first expert profile to publish a copy trading offer.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
