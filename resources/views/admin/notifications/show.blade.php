@extends('layouts.admin-dasht')
@section('title', 'Notification Details')

@php
    // Helper function to safely get user name
    function safeGetUserName($user) {
        if (!$user) {
            return 'N/A';
        }

        if(is_object($user)) {
            return $user->name;
        } elseif(is_numeric($user)) {
            $userObj = \App\Models\User::find($user);
            return $userObj ? $userObj->name : 'User #' . $user;
        }

        return 'N/A';
    }
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <a href="{{ route('admin.notifications') }}" class="transition-colors hover:text-yellow-500">Notifications</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Details</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Notification <span class="gold-text">Details</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Review the notification body, delivery type, read state, and any linked operational record.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Type</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ ucfirst($notification->type) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Alert severity classification</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Status</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ $notification->is_read ? 'Read' : 'Unread' }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current notification state</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Created</p>
                <h2 class="mt-4 text-lg font-black tracking-tight text-white">{{ $notification->created_at->format('M d, Y') }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $notification->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center px-4 py-4 sm:px-6">
                <h5 class="mb-0">{{ $notification->title }}</h5>
                <span class="badge badge-{{ $notification->type === 'warning' ? 'warning' : ($notification->type === 'success' ? 'success' : ($notification->type === 'danger' ? 'danger' : 'info')) }}">
                    {{ ucfirst($notification->type) }}
                </span>
            </div>
            <div class="card-body p-4 sm:p-6">
                <div class="mb-4">
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>User:</strong>
                                @php
                                    $userId = null;
                                    $userName = 'N/A';

                                    if($notification->user) {
                                        if(is_object($notification->user)) {
                                            $userId = $notification->user->id;
                                            $userName = $notification->user->name;
                                        } elseif(is_numeric($notification->user)) {
                                            $userId = $notification->user;
                                            $userObj = \App\Models\User::find($userId);
                                            $userName = $userObj ? $userObj->name : 'User #' . $userId;
                                        }
                                    }
                                @endphp

                                @if($userId)
                                    <a href="{{ route('admin.users.show', $userId) }}">{{ $userName }}</a>
                                @else
                                    N/A
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Message:</strong></p>
                            <div class="p-3 bg-light rounded">
                                {{ $notification->message }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Date:</strong> {{ $notification->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <div class="col-md-6 text-md-right">
                        <p><strong>Status:</strong> {{ $notification->is_read ? 'Read' : 'Unread' }}</p>
                    </div>
                </div>

                @if($notification->source_id && $notification->source_type)
                    <hr>
                    <div class="mt-3">
                        <h6>Related Information</h6>
                        @php
                            $sourceModel = null;
                            try {
                                if (class_exists($notification->source_type)) {
                                    $sourceModel = $notification->source_type::find($notification->source_id);
                                }
                            } catch (\Exception $e) {
                                // Model not found or error
                            }
                        @endphp

                        @if($sourceModel)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @if($notification->source_type == 'App\\Models\\Deposit')
                                            <tr>
                                                <th>User</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amount</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Mode</th>
                                                <td>{{ $sourceModel->payment_mode }}</td>
                                            </tr>
                                            <tr>
                                                <th>Action</th>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-primary">View Deposit</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\Withdrawal')
                                            <tr>
                                                <th>User</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amount</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Payment Mode</th>
                                                <td>{{ $sourceModel->payment_mode }}</td>
                                            </tr>
                                            <tr>
                                                <th>Action</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View Withdrawal</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\User_plans')
                                            <tr>
                                                <th>User</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amount</th>
                                                <td>{{ $sourceModel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $sourceModel->active ? 'Active' : 'Inactive' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Asset</th>
                                                <td>{{ $sourceModel->assets }}</td>
                                            </tr>
                                            <tr>
                                                <th>Action</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View Plan</a>
                                                </td>
                                            </tr>
                                        @elseif($notification->source_type == 'App\\Models\\UserBotInvestment')
                                            <tr>
                                                <th>User</th>
                                                <td>{{ safeGetUserName($sourceModel->user) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Amount</th>
                                                <td>{{ $sourceModel->investment_amount }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>{{ $sourceModel->status }}</td>
                                            </tr>
                                            <tr>
                                                <th>Current Balance</th>
                                                <td>{{ $sourceModel->current_balance }}</td>
                                            </tr>
                                            <tr>
                                                <th>Action</th>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View Bot Investment</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="2">No detailed information available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>No related information available.</p>
                        @endif
                    </div>
                @endif

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <a href="{{ route('admin.notifications') }}" class="btn btn-secondary">Back to Notifications</a>

                    <form action="{{ route('admin.notifications.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this notification?')">Delete</button>
                    </form>
            </div>
        </div>
    </div>
@endsection
