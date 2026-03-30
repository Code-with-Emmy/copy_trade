@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <span class="admin-page-kicker">Operations Desk</span>
                <h1 class="title1 mb-0">Assign work with <span class="gold-text">clarity</span></h1>
                <p class="admin-page-subtitle">Create actionable internal tasks, give them a real owner, and define exactly what success looks like across support, compliance, treasury, and growth operations.</p>
            </div>
            <div class="admin-page-actions">
                <a href="{{ route('mtask') }}" class="btn btn-outline-light btn-sm">Task Board</a>
                <a href="{{ route('viewtask') }}" class="btn btn-primary btn-sm">Assigned To Me</a>
            </div>
        </section>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">All Tasks</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format(data_get($taskStats, 'total', 0)) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Open and completed operational tickets</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">In Queue</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ number_format(data_get($taskStats, 'pending', 0)) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Assignments still awaiting delivery</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Closed Out</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-emerald-400">{{ number_format(data_get($taskStats, 'completed', 0)) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Work items marked complete</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deadline Watch</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format(data_get($taskStats, 'due_soon', 0)) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Items approaching their due date</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-8 xl:col-span-2">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Create Assignment</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Define the owner, timeline, and exact execution brief</p>
                </div>

                <form method="POST" action="{{ route('addtask') }}" class="mt-6 space-y-6">
                    @csrf
                    <input type="hidden" name="id" value="{{ Auth('admin')->user()->id }}">

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Task Title</span>
                        <input id="tasktitle" type="text" name="tasktitle" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" placeholder="Approve high-value withdrawals before 4PM cutoff" required>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Execution Brief</span>
                        <textarea id="note" name="note" rows="6" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" placeholder="State the outcome, checks to perform, dependencies, escalation path, and what should be delivered when the task is complete." required></textarea>
                        <p class="mt-3 text-xs text-slate-500">Write the note so the assignee can act without needing follow-up clarification.</p>
                    </label>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Owner</span>
                            <select id="delegation" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" name="delegation" required>
                                @foreach ($admin as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Starts</span>
                            <input id="start_date" type="date" name="start_date" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" required>
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Deadline</span>
                            <input id="end_date" type="date" name="end_date" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" required>
                        </label>
                    </div>

                    <label class="block">
                        <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Priority Level</span>
                        <select id="priority" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40" name="priority" required>
                            <option>Immediately</option>
                            <option>High</option>
                            <option>Medium</option>
                            <option>Low</option>
                        </select>
                    </label>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="rounded-2xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black transition-all hover:scale-[1.02]">
                            Create Task
                        </button>
                        <a href="{{ route('mtask') }}" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                            Review Task Board
                        </a>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Good Task Prompts</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-400">
                        <p>Use this page for KYC review queues, urgent withdrawal checks, trader onboarding follow-up, support escalations, or content updates that need one accountable owner.</p>
                        <p>The best assignments state the decision to make, the records to inspect, and the expected output before the deadline.</p>
                    </div>
                </div>

                <div class="dashboard-glass p-6 sm:p-7">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Assignment Standard</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-400">
                        <p>Assign one clear owner, not a group.</p>
                        <p>Use the deadline to define delivery, and priority to signal urgency.</p>
                        <p>Write notes that another admin could execute without asking what you meant.</p>
                        <p>Move to the task board after creation to monitor progress and close completed work fast.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
