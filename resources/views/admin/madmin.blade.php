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
        $managerCount = $admins->count();
        $blockedCount = $admins->where('acnt_type_active', 'blocked')->count();
        $superAdminCount = $admins->where('type', 'Super Admin')->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Managers</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Manager <span class="gold-text">Directory</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Review admin accounts, manage access state, reset passwords, and update contact details from a single control surface.
                </p>
            </div>
            <div>
                <a href="{{ url('admin/dashboard/addadmin') }}" class="btn btn-primary">Add Manager</a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Managers</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($managerCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Back-office seats on the platform</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Super Admins</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($superAdminCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Highest permission tier accounts</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Blocked</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($blockedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Managers with access paused</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass p-4 sm:p-6">
            <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>USER ID</th>
                                        <th>FIRSTNAME</th>
                                        <th>LASTNAME</th>
                                        <th>EMAIL</th>
                                        <th>PHONE</th>
                                        <th>TYPE</th>
                                        <th>STATUS</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->firstName }}</td>
                                            <td>{{ $admin->lastName }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->phone }}</td>
                                            <td>{{ $admin->type }}</td>
                                            <td>{{ $admin->acnt_type_active }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-secondary btn-sm dropdown-toggle" href="#"
                                                        role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Actions
                                                    </a>
                                                    <div class="dropdown-menu " aria-labelledby="dropdownMenuLink">

                                                        @if ($admin->acnt_type_active == null || $admin->acnt_type_active == 'blocked')
                                                            <a class="m-1 btn btn-primary btn-sm"
                                                                href="{{ url('admin/dashboard/unblock') }}/{{ $admin->id }}">Unblock</a>
                                                        @else
                                                            <a class="m-1 btn btn-danger btn-sm"
                                                                href="{{ url('admin/dashboard/ublock') }}/{{ $admin->id }}">Block</a>
                                                        @endif
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#resetpswdModal{{ $admin->id }}"
                                                            class="m-1 btn btn-warning btn-sm">Reset Password</a>

                                                        <a href="#" data-toggle="modal"
                                                            data-target="#deleteModal{{ $admin->id }}"
                                                            class="m-1 btn btn-danger btn-sm">Delete</a>
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#edituser{{ $admin->id }}"
                                                            class="m-1 btn btn-secondary btn-sm">Edit</a>
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#sendmailModal{{ $admin->id }}"
                                                            class="m-1 btn btn-info btn-sm">Send Email</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>


                                        <!-- Reset user password Modal -->
                                        <div id="resetpswdModal{{ $admin->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header  ">

                                                        <h4 class="modal-title ">Reset Password</strong></h4>
                                                        <button type="button" class="close "
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body  p-3">
                                                        <p class="">Are you sure you want to reset password for
                                                            {{ $admin->firstName }} to <span
                                                                class="text-primary font-weight-bolder">admin01236</span>
                                                        </p>
                                                        <a class="btn btn-danger"
                                                            href="{{ url('admin/dashboard/resetadpwd') }}/{{ $admin->id }}">Reset
                                                            Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Reset user password Modal -->

                                        <!-- Delete user Modal -->
                                        <div id="deleteModal{{ $admin->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header ">

                                                        <h4 class="modal-title ">Delete Manager</strong></h4>
                                                        <button type="button" class="close "
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body  p-3">
                                                        <p class="">Are you sure you want to delete
                                                            {{ $admin->firstName }}</p>
                                                        <a class="btn btn-danger"
                                                            href="{{ url('admin/dashboard/deleletadmin') }}/{{ $admin->id }}">Yes
                                                            i'm sure</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Delete user Modal -->

                                        <!-- Edit user Modal -->
                                        <div id="edituser{{ $admin->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header ">

                                                        <h4 class="modal-title ">Edit user details.</strong></h4>
                                                        <button type="button" class="close "
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body ">
                                                        <form style="padding:3px;" role="form" method="post"
                                                            action="{{ route('editadmin') }}">
                                                            <h5 class=" ">Firstname</h5>
                                                            <input style="padding:5px;" class="form-control  "
                                                                value="{{ $admin->firstName }}" type="text"
                                                                name="fname" required><br />
                                                            <h5 class=" ">Lastname</h5>
                                                            <input style="padding:5px;" class="form-control  "
                                                                value="{{ $admin->lastName }}" type="text"
                                                                name="l_name" required><br />
                                                            <h5 class=" ">Email</h5>
                                                            <input style="padding:5px;" class="form-control  "
                                                                value="{{ $admin->email }}" type="email"
                                                                name="email" required><br />
                                                            <h5 class=" ">Phone Number</h5>
                                                            <input style="padding:5px;" class="form-control  "
                                                                value="{{ $admin->phone }}" type="text"
                                                                name="phone" required>
                                                            <br>
                                                            <h5 class=" ">Type</h5>
                                                            <select class="form-control  " name="type">
                                                                <option>{{ $admin->type }}</option>
                                                                <option>Super Admin</option>
                                                                <option>Admin</option>
                                                                <option>Conversion Agent</option>
                                                            </select><br>
                                                            <input type="hidden" name="_token"
                                                                value="{{ csrf_token() }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $admin->id }}">
                                                            <input type="submit" class="btn btn-info"
                                                                value="Update account">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /Edit user Modal -->
                                        <!-- send a single user email Modal-->
                                        <div id="sendmailModal{{ $admin->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header ">
                                                        <h4 class="modal-title ">Send Email Message</h4>
                                                        <button type="button" class="close "
                                                            data-dismiss="modal">&times;</button>
                                                    </div>

                                                    <div class="modal-body ">
                                                        <p class="">This message will be sent to
                                                            {{ $admin->firstName }} {{ $admin->lastName }} </p>
                                                        <form role="form" method="post"
                                                            action="{{ route('sendmailtoadmin') }}">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ $admin->id }}">
                                                            <div class="form-group">
                                                                <input type="text" name="subject"
                                                                    class="form-control  "
                                                                    placeholder="Enter Email Subject">
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea class="form-control  " name="message " row="3" placeholder="Type your message here" required></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="hidden" name="_token"
                                                                    value="{{ csrf_token() }}">
                                                                <input type="submit" class="btn btn-primary"
                                                                    value="Send">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
            </div>
        </div>
    @endsection
