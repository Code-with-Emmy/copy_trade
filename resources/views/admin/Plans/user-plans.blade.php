@extends('layouts.admin-dasht')
@section('title', 'User Investment Plans')

@section('styles')
<link href="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    @php
        $pageCollection = collect($userPlans->items());
        $totalPlans = $userPlans->total();
        $activePlans = $pageCollection->where('status', 'active')->count();
        $capitalSnapshot = $pageCollection->sum('amount');
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">User Plans</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">User <span class="gold-text">Investment Plans</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Monitor plan subscriptions, filter user portfolios, and review lifecycle state from the same premium dashboard shell.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-primary">
                    <i class="fa fa-list"></i> Manage Plans
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Records</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($totalPlans) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Paginated user plan results</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active On Page</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($activePlans) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current active plans in this view</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Capital Snapshot</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $settings->currency }}{{ number_format((float) $capitalSnapshot, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Investment amount on the current page</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center px-4 py-4 sm:px-6">
                <h4 class="card-title mb-0">User Investment Plans</h4>
            </div>
            <div class="card-body p-4 sm:p-6">
                <form action="{{ route('admin.user-plans.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status">Filter by Status</label>
                                <select name="status" id="status" class="form-control" onchange="this.form.submit()">
                                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="user_id">Filter by User ID</label>
                                <input type="number" class="form-control" id="user_id" name="user_id" value="{{ request('user_id') }}" placeholder="Enter User ID">
                            </div>
                        </div>
                        <div class="col-md-4 align-self-end">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a href="{{ route('admin.user-plans.index') }}" class="btn btn-secondary">Reset</a>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="data-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>ROI</th>
                                <th>Total Paid</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPlans as $userPlan)
                                <tr>
                                    <td>{{ $userPlan->id }}</td>
                                    <td>
                                        @php $planUser = $userPlan->duser; @endphp
                                        @if($planUser)
                                            <a href="{{ route('viewuser', $planUser->id) }}" target="_blank">
                                                {{ $planUser->name }}
                                            </a>
                                        @else
                                            <span class="text-danger">User not found</span>
                                        @endif
                                    </td>
                                    <td>@php $planObj = $userPlan->dplan; @endphp{{ $planObj ? $planObj->name : 'N/A' }}</td>
                                    <td>{{ $settings->currency }}{{ number_format((float)$userPlan->amount, 2) }}</td>
                                    <td>{{ $planObj ? ($planObj->returns ?? '0%') : 'N/A' }}</td>
                                    <td>{{ $settings->currency }}{{ number_format($userPlan->total_paid_amount, 2) }}</td>
                                    <td>
                                        @if($userPlan->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($userPlan->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif($userPlan->status == 'completed')
                                            <span class="badge bg-info">Completed</span>
                                        @elseif($userPlan->status == 'cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>{{ $userPlan->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.user-plans.show', $userPlan) }}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i> Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $userPlans->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/admin/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#data-table').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 50,
            "searching": false,
            "paging": false,
            "info": false
        });
    });
</script>
@endsection
