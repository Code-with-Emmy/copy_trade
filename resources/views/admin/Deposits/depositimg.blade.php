<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <span class="admin-page-kicker">Deposits</span>
                <h1 class="title1 mb-0">View Deposit <span class="gold-text">Proof</span></h1>
                <p class="admin-page-subtitle">
                    Review the uploaded screenshot or payment reference attached to this funding request.
                </p>
            </div>
            <div class="admin-page-actions">
                <a class="btn btn-primary btn-sm" href="{{ route('mdeposits') }}">
                    <i class="fa fa-arrow-left mr-2"></i>
                    Back
                </a>
            </div>
        </section>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Depositor</p>
                <h2 class="mt-4 text-xl font-black tracking-tight text-white">{{ data_get($deposit, 'duser.name', 'Unknown User') }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ data_get($deposit, 'duser.email', 'No email') }}</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Amount</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ $settings->currency }}{{ number_format((float) $deposit->amount, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $deposit->payment_mode }}</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Proof Type</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ ucfirst($proofMeta['kind'] ?? 'unknown') }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $proofMeta['label'] ?? 'No proof attached' }}</p>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8">
            @if (($proofMeta['kind'] ?? null) === 'image')
                <div class="rounded-3xl border border-white/10 bg-black/20 p-4">
                    <img src="{{ $proofMeta['url'] }}" alt="Proof of Payment" class="mx-auto max-h-[70vh] w-auto rounded-2xl border border-white/10 object-contain" />
                </div>
            @elseif (($proofMeta['kind'] ?? null) === 'file')
                <div class="rounded-3xl border border-white/10 bg-black/20 p-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                        <i data-lucide="file-text" class="h-6 w-6 gold-text"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">Proof uploaded as a file.</p>
                    <p class="mt-2 text-sm text-slate-400">{{ $proofMeta['label'] }}</p>
                    <a href="{{ $proofMeta['url'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black">
                        Open File
                    </a>
                </div>
            @elseif (($proofMeta['kind'] ?? null) === 'remote')
                <div class="rounded-3xl border border-white/10 bg-black/20 p-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                        <i data-lucide="link" class="h-6 w-6 gold-text"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">Proof stored as a remote link.</p>
                    <a href="{{ $proofMeta['url'] }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black">
                        Open Link
                    </a>
                </div>
            @elseif (($proofMeta['kind'] ?? null) === 'reference')
                <div class="rounded-3xl border border-white/10 bg-black/20 p-8 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                        <i data-lucide="receipt-text" class="h-6 w-6 gold-text"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">No image screenshot was attached.</p>
                    <p class="mt-2 text-sm text-slate-400">
                        This deposit stores a payment reference instead of an uploaded screenshot.
                    </p>
                    <div class="mt-5 rounded-2xl border border-white/10 bg-black/30 px-5 py-4 text-sm font-mono text-white">
                        {{ $proofMeta['label'] }}
                    </div>
                </div>
            @else
                <div class="rounded-3xl border border-rose-500/20 bg-rose-500/10 p-8 text-center text-rose-100">
                    No deposit proof is available for this record.
                </div>
            @endif
        </div>
    </div>
@endsection
