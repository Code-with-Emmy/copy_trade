@extends('layouts.admin-dasht')
@section('title', 'Send Message to User')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-slate-300">Notifications</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">Send <span class="gold-text">Message</span></h1>
            <p class="mt-1 max-w-2xl text-sm font-medium text-slate-400">
                Deliver an in-app message to any user from the same premium admin communication surface.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Audience</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($users->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Selectable user recipients</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Delivery</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">In-App</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Messages appear in the user dashboard</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Priority</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Typed Alerts</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Info, warning, success, or important</p>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-100">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="dashboard-glass mx-auto w-full max-w-4xl p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.send.message') }}" class="space-y-5">
                @csrf
                <div class="form-group">
                    <label>Select User</label>
                    <select name="user_id" class="form-control" required>
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Message Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label>Message Type</label>
                    <select name="type" class="form-control">
                        <option value="info">Information</option>
                        <option value="warning">Warning</option>
                        <option value="success">Success</option>
                        <option value="danger">Important</option>
                    </select>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </div>
            </form>
        </div>
    </div>
@endsection
