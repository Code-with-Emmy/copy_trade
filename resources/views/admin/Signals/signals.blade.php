@extends('layouts.admin-dasht')

@section('content')
    @php
        $averagePrice = (float) $signals->avg('price');
        $highestPrice = (float) $signals->max('price');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Signal Desk</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Trade <span class="gold-text">Signals</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Manage published signals, pricing tiers, and performance tags from the same premium command surface used across the admin area.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('activesignals') }}"
                    class="flex items-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                    <i data-lucide="activity" class="mr-2 h-4 w-4"></i>
                    Active Subscriptions
                </a>
                <a href="{{ route('newsignal') }}"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    New Signal
                </a>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Published Signals</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($signals->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current sellable signal products</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Average Price</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ $settings->currency }}{{ number_format($averagePrice, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Mean signal entry price</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Highest Tier</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ $settings->currency }}{{ number_format($highestPrice, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Most premium package</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Growth Tags</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($signals->whereNotNull('tag')->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Signals carrying bonus or promo tags</p>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($signals as $signal)
                <article class="dashboard-glass overflow-hidden border-white/5">
                    <div class="border-b border-white/5 bg-white/[0.02] p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Signal Product</p>
                                <h2 class="mt-2 text-2xl font-black tracking-tight text-white">{{ $signal->name }}</h2>
                            </div>
                            @if ($signal->tag)
                                <span class="inline-flex rounded-full bg-emerald-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-400">
                                    {{ $signal->tag }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6 p-6">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Entry Price</p>
                            <p class="mt-2 text-3xl font-black tracking-tighter gold-text">{{ $settings->currency }}{{ number_format((float) $signal->price, 2) }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Increment</p>
                                <p class="mt-2 text-lg font-black text-white">{{ number_format((float) $signal->increment_amount, 2) }}%</p>
                            </div>
                            <div class="rounded-2xl border border-white/5 bg-black/30 p-4">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Status</p>
                                <p class="mt-2 text-lg font-black text-emerald-400">Live</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('editsignal', $signal->id) }}"
                                class="flex-1 rounded-xl border border-sky-500/20 bg-sky-500/10 px-4 py-3 text-center text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                Edit Signal
                            </a>
                            <a href="{{ url('admin/dashboard/trashsignal/' . $signal->id) }}"
                                onclick="return confirm('Delete this signal?')"
                                class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20">
                                Delete
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="dashboard-glass px-6 py-16 text-center md:col-span-2 xl:col-span-3">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/5">
                        <i data-lucide="activity" class="h-7 w-7 text-slate-500"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">No signals created yet.</p>
                    <p class="mt-2 text-sm text-slate-500">Create the first signal product to start selling managed trade calls.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
