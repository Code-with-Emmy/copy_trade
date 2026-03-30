@extends('layouts.admin-dasht')
@section('content')
    @php
        $leadCount = $users->count();
        $assignedCount = $users->filter(function ($user) {
            return !empty(optional($user->tuser)->firstName);
        })->count();
        $activeCount = $users->where('status', 'active')->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Lead Desk</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Lead <span class="gold-text">Management</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Leads are new users without deposits. Assign them, import them, and track activation from the same dashboard language as the user-facing shell.
                </p>
            </div>
            <div>
                <a href="#" data-toggle="modal" data-target="#assignModal" class="btn btn-primary">Assign Lead</a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Leads</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($leadCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Users waiting for first deposit</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Assigned</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($assignedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Leads already routed to a manager</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($activeCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Lead accounts currently active</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass p-5 sm:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Import Pipeline</p>
                    <p class="mt-2 text-sm text-slate-400">
                        Upload an Excel lead sheet or <a href="{{ route('downlddoc') }}" class="font-semibold text-yellow-400">download the sample document</a>.
                    </p>
                </div>
                <form action="{{ route('fileImport') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    @csrf
                    <div class="form-group mb-0">
                        <input name="file" class="form-control" type="file" required>
                    </div>
                    <div>
                        <button class="btn btn-primary" type="submit">Upload Leads</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="p-4 sm:p-6">
                <div class="table-responsive" data-example-id="hoverable-table">
                                    <table id="ShipTable" class="table table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Date registered</th>
                                                <th>Assigned To</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $list)
                                                <tr>
                                                    <td>{{ $list->name }}</td>
                                                    <td>{{ $list->email }}</td>
                                                    <td>{{ $list->phone }}</td>
                                                    <td>
                                                        @if ($list->status == 'active')
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $list->created_at->toDayDateTimeString() }}
                                                    </td>
                                                    <td>
                                                        @if ($list->tuser->firstName)
                                                            {{ $list->tuser->firstName }} {{ $list->tuser->lastName }}
                                                        @else
                                                            <span class="text-info">Not assigned yet</span>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <a class="m-1 btn btn-info btn-sm text-white" data-toggle="modal"
                                                            data-target="#editModal{{ $list->id }}">Edit Status</a>
                                                    </td>
                                                </tr>

                                                @include('admin.partials.user-status-modal', ['list' => $list])
                                            @endforeach
                                        </tbody>
                                    </table>
                </div>
            </div>

            <div id="assignModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <h4 class="modal-title ">Assign users to admin for follow up</h4>
                            <button type="button" class="close " data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body ">
                            <form role="form" method="post" action="{{ route('assignuser') }}">
                                @csrf
                                <div class="form-group">
                                    <h5 class="">Select User to Assign</h5>
                                    <select name="user_name" class="form-control select2" style="width:100%">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }} ">{{ $user->name }} {{ $user->l_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <h5 class="">Select Admin to assign this user to.</h5>
                                    <select name="admin" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($admin as $user)
                                            <option value="{{ $user->id }}">{{ $user->firstName }} {{ $user->lastName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" class="btn btn-info" value="Assign">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $('.select2').select2();
            </script>
        </div>
    @endsection
