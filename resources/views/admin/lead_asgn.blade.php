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
        $assignedCount = $usersAssigned->count();
        $convertedCount = $usersAssigned->where('cstatus', 'Customer')->count();
        $activeCount = $usersAssigned->where('status', 'active')->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Assigned Leads</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">My <span class="gold-text">Assigned Members</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Review the leads routed to you, move them to customer status, and update outreach notes without leaving the dashboard pattern.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Assigned</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($assignedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Members currently routed to your queue</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Converted</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($convertedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Leads already turned into customers</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active Accounts</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($activeCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Assigned members marked active</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

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
                                        <th>Assigned To</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($usersAssigned as $list)
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
                                            <td>{{ $list->tuser->firstName }} {{ $list->tuser->lastName }}</td>
                                            <td>
                                                @if ($list->cstatus == 'Customer')
                                                    <a class="btn btn-success btn-sm m-1">Converted</a>
                                                @else
                                                    <a href="{{ url('admin/dashboard/convert') }}/{{ $list->id }}"
                                                        class="btn btn-primary btn-sm m-1">Convert</a>
                                                @endif

                                                <a class="btn btn-info btn-sm m-1" data-toggle="modal"
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
