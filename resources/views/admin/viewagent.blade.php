<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    @php
        $clientCount = $ag_r->count();
        $activeCount = $ag_r->where('status', 'active')->count();
        $balanceTotal = $ag_r->sum('account_bal');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <a href="{{ url('admin/dashboard/agents') }}" class="transition-colors hover:text-yellow-500">Agents</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-slate-300">{{ $agent->name }}</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">Agent Client <span class="gold-text">Portfolio</span></h1>
            <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                View the clients tied to {{ $agent->name }}, their plan allocation, current status, and visible account balances.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Clients</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($clientCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Members under this agent</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($activeCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Clients currently marked active</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Account Base</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format((float) $balanceTotal, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Combined client balance snapshot</p>
            </div>
        </div>

        @if (Session::has('message'))
            <div class="rounded-2xl border border-sky-500/20 bg-sky-500/10 px-5 py-4 text-sm text-sky-100">
                <i class="fa fa-info-circle"></i> {{ Session::get('message') }}
            </div>
        @endif

        @if (count($errors) > 0)
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                @foreach ($errors->all() as $error)
                    <div><i class="fa fa-warning"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="dashboard-glass p-4 sm:p-6">
            <div class="table-responsive" data-example-id="hoverable-table">
                            <table class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>Client name</th>
                                        <th>Client Inv. plan</th>
                                        <th>Client status</th>
                                        <th>Earnings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ag_r as $client)
                                        <tr>
                                            <td>{{ $client->name }}</td>
                                            @if (isset($client->dplan->name))
                                                <td>{{ $client->dplan->name }}</td>
                                            @else
                                                <td>NULL</td>
                                            @endif
                                            <td>{{ $client->status }}</td>
                                            <td>{{ $client->account_bal }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
            </div>
        </div>
    @endsection
