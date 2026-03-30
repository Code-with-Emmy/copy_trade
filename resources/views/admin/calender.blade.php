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
        <section class="admin-page-header">
            <div>
                <span class="admin-page-kicker">Calendar</span>
                <h1 class="title1 mb-0">Operations calendar</h1>
                <p class="admin-page-subtitle">Monitor scheduled activity, internal deadlines, and operational reminders from the same admin dashboard language as the rest of the console.</p>
            </div>
            <div class="admin-page-actions">
                <a href="{{ route('task') }}" class="btn btn-outline-light btn-sm">Task Desk</a>
                <a href="{{ route('mtask') }}" class="btn btn-primary btn-sm">All Tasks</a>
            </div>
        </section>

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

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">View</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Shared Calendar</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Embedded team-facing schedule feed</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Primary Use</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">Deadlines</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Track reviews, renewals, and admin follow-up</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Source</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Live Widget</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Dynamic calendar embed for operations</p>
            </div>
        </div>

        <div class="dashboard-glass p-4 sm:p-6">
            <script src="//localendar.com/public/Victory33404?current_only=Y&include=Y&dynamic=Y"></script>
        </div>
    </div>
@endsection
