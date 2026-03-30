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
        $memberCount = $users->count();
        $activeCount = $users->where('status', 'active')->count();
        $fundedBalance = $users->sum('account_bal');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Member Follow-up</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Customer <span class="gold-text">Pipeline</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Track funded members, monitor follow-up pressure, and update customer status from one operating surface.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Members</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($memberCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Users in the follow-up queue</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active Status</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($activeCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Accounts currently marked active</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Balance Base</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">${{ number_format((float) $fundedBalance, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Visible customer account balances</p>
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
                            <table id="ShipTable" class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Balance</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Inv. plan</th>
                                        <th>Status</th>
                                        <th>Date registered</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $list)
                                        <tr>
                                            <th scope="row">{{ $list->id }}</th>
                                            <td>${{ $list->account_bal }}</td>
                                            <td>{{ $list->name }}</td>
                                            <td>{{ $list->l_name }}</td>
                                            <td>{{ $list->email }}</td>
                                            <td>{{ $list->phone_number }}</td>
                                            @if (isset($list->dplan->name))
                                                <td>{{ $list->dplan->name }}</td>
                                            @else
                                                <td>NULL</td>
                                            @endif
                                            <td>{{ $list->status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->created_at)->toDayDateTimeString() }}</td>
                                            <td>
                                                <a class="m-1 btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#editModal{{ $list->id }}">Edit Status</a>
                                            </td>
                                        </tr>

                                        @include('admin.partials.user-status-modal', ['list' => $list])
                                        <!-- /send all users email Modal -->
                                    @endforeach
                                </tbody>
                            </table>
            </div>
        </div>
    @endsection
