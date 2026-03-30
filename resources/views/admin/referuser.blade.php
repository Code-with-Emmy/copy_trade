<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">User Intake</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Add <span class="gold-text">User</span></h1>
                <p class="mt-1 max-w-2xl text-sm font-medium text-slate-400">
                    Create a new member account directly from admin and place them into the {{ $settings->site_name }} ecosystem with the same dashboard language.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Mode</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Manual Signup</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Create one user account instantly</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Profile</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">Identity Ready</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Username, email, and phone are captured</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Security</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Credential Setup</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Password is assigned during creation</p>
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

        <div class="dashboard-glass mx-auto w-full max-w-4xl p-6 sm:p-8">
            <form method="POST" action="{{ url('admin/dashboard/saveuser') }}" class="space-y-5">
                {{ csrf_field() }}
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="f_name">Username</label>
                                    <input type="text" class="mr-2 form-control" name="username"
                                        placeholder="Enter Unique Username" required>
                                    @if ($errors->has('username'))
                                        <small class="text-danger">{{ $errors->first('username') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <h4 class="">FullName</h4>
                                <div>
                                    <input id="name" type="text" class="form-control  " name="name"
                                        value="{{ old('name') }}" required>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
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
                            <i class="fa fa-btn fa-user"></i> Save User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endsection
