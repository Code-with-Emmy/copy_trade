@extends('layouts.admin-dasht')

@section('content')
    @php
        $accountCollection = collect($accounts ?? []);
        $masterCount = $accountCollection->count();
        $deployedCount = $accountCollection->where('deployment_status', 'Deployed')->count();
        $expiredCount = $accountCollection->filter(function ($item) {
            return now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($item['end_date']));
        })->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-slate-300">Managed Accounts</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">Managed <span class="gold-text">Accounts</span></h1>
            <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                Control provider accounts, review deployment state, and renew expired masters from a dedicated managed-account workspace.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Master Accounts</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($masterCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Configured provider accounts</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deployed</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($deployedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Accounts actively deployed</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Expired</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($expiredCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Accounts needing renewal</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        @include('admin.subscription.master.statistics')

        <div class="dashboard-glass p-4 sm:p-6">
            @if ($accounts and count($accounts) < 1)
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h5 class="card-title">No Master Trading Account</h5>
                            <p>Add a master account</p>
                            <a href="{{ route('create.master') }}" type="button" class="text-white btn btn-primary" data-toggle="modal" data-target="#masterModal">
                                Add Account
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <p>Add a master account</p>
                            <a href="{{ route('create.master') }}" type="button" class="text-white btn btn-primary" data-toggle="modal" data-target="#masterModal">
                                Add Account
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <h1 class="font-weight-bold d-md-block d-none">Your Master(Provider) Accounts</h1>
                                <h2 class="font-weight-bold d-md-none d-block">Your Master(Provider) Accounts</h2>
                                <p class="text-primary font-weight-bold">
                                    NOTE: Your master account will be deleted after 10 days of expiration if it is not renewed.
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Account ID</th>
                                                <th>Account Password</th>
                                                <th>Account Type</th>
                                                <th>Account Name</th>
                                                <th>Server</th>
                                                <th>Deployment status</th>
                                                <th>Started at</th>
                                                <th>Expiring at</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($accounts as $item)
                                                <tr>
                                                    <td>{{ $item['login'] }}</td>
                                                    <td>{{ $item['password'] }}</td>
                                                    <td>{{ $item['account_type'] }}</td>
                                                    <td>{{ $item['account_name'] }}</td>
                                                    <td>{{ $item['server'] }}</td>
                                                    <td>
                                                        @if ($item['deployment_status'] == 'Deployed')
                                                            <h2 class="badge badge-success">{{ $item['deployment_status'] }}</h2>
                                                        @else
                                                            <h2 class="badge badge-warning">{{ $item['deployment_status'] }}</h2>
                                                        @endif
                                                    </td>
                                                    <td><span>{{ \Carbon\Carbon::parse($item['start_date'])->toDayDateTimeString() }}</span></td>
                                                    <td>{{ \Carbon\Carbon::parse($item['end_date'])->toDayDateTimeString() }}</td>
                                                    <td>
                                                        @if (now()->greaterThanOrEqualTo(\Carbon\Carbon::parse($item['end_date'])))
                                                            <a href="#" class="btn btn-info btn-sm m-1" data-toggle="modal" data-target="#renewModal{{ $item['id'] }}">Renew</a>
                                                        @endif
                                                        <button type="button" data-toggle="modal" data-target="#strategyModal{{ $item['id'] }}" class="btn btn-secondary btn-sm m-1">
                                                            <span>Update Strategy</span>
                                                        </button>
                                                        <button type="button" data-toggle="modal" data-target="#deleteModal{{ $item['id'] }}" class="btn btn-danger btn-sm m-1">
                                                            <i class="fa fa-trash"></i>
                                                            <span> Delete</span>
                                                        </button>
                                                        @include('admin.subscription.master.delete-master')
                                                        @include('admin.subscription.master.renew-master')
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">No Data Available</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @include('admin.subscription.master.create-master')
        </div>
    </div>
@endsection
