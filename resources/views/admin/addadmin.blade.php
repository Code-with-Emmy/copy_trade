@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Managers</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Add <span class="gold-text">Manager</span></h1>
                <p class="mt-1 max-w-2xl text-sm font-medium text-slate-400">
                    Provision a new admin, operations manager, or conversion agent with the same premium command-center workflow.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Account Type</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Admin Seat</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Create a privileged back-office login</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Security</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">Password Protected</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Initial credentials are required</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Workflow</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Role Assignment</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Set the manager type before saving</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass mx-auto w-full max-w-4xl p-6 sm:p-8">
            <form method="POST" action="{{ url('admin/dashboard/saveadmin') }}" class="space-y-5">
                {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <h4 class="">First Name</h4>
                                <div>
                                    <input id="name" type="text" class="form-control  " name="fname"
                                        value="{{ old('fname') }}" required>
                                    @if ($errors->has('fname'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fname') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('l_name') ? ' has-error' : '' }}">
                                <h4 class="">Last Name</h4>
                                <div>
                                    <input id="name" type="text" class="form-control  " name="l_name"
                                        value="{{ old('l_name') }}" required>
                                    @if ($errors->has('l_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('l_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4 class="">E-Mail Address</h4>

                                <div>
                                    <input id="email" type="email" class="form-control  " name="email"
                                        value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <h4 class="">Phone number</h4>
                                <div>
                                    <input id="phone" type="number" class="form-control  " name="phone"
                                        value="{{ old('phone') }}" required>

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="">Type</h4>
                                <select class="form-control  " name="type">
                                    <option>Super Admin</option>
                                    <option>Admin</option>
                                    <option>Conversion Agent</option>
                                </select><br>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <h4 class="">Password</h4>
                                <div>
                                    <input id="password" type="password" class="form-control  " name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <h4 class="">Confirm Password</h4>
                                <div>
                                    <input id="password-confirm" type="password" class="form-control  "
                                        name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                <div class="form-group mb-0">
                    <div>
                        <button type="submit" class="px-5 btn btn-primary btn-lg">
                            <i class="fa fa-plus"></i> Save Manager
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection
