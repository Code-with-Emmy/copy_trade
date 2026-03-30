@extends('layouts.admin-dasht')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <section class="admin-page-header">
                    <div>
                        <span class="admin-page-kicker">My Work Queue</span>
                        <h1 class="title1 mb-0">Assigned tasks</h1>
                        <p class="admin-page-subtitle">This page shows the internal tasks assigned to the current admin so they can track open work, due dates, and completion status.</p>
                    </div>
                    <div class="admin-page-actions">
                        <a href="{{ route('task') }}" class="btn btn-outline-light btn-sm">Create Task</a>
                        <a href="{{ route('mtask') }}" class="btn btn-primary btn-sm">All Tasks</a>
                    </div>
                </section>

                <x-danger-alert />
                <x-success-alert />

                <div class="row mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <article class="card h-100">
                            <div class="card-body">
                                <p class="admin-page-kicker mb-3">Assigned</p>
                                <h3 class="mb-0 text-white">{{ number_format(data_get($taskStats, 'total', 0)) }}</h3>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <article class="card h-100">
                            <div class="card-body">
                                <p class="admin-page-kicker mb-3">Pending</p>
                                <h3 class="mb-0 text-white">{{ number_format(data_get($taskStats, 'pending', 0)) }}</h3>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <article class="card h-100">
                            <div class="card-body">
                                <p class="admin-page-kicker mb-3">Completed</p>
                                <h3 class="mb-0 text-success">{{ number_format(data_get($taskStats, 'completed', 0)) }}</h3>
                            </div>
                        </article>
                    </div>
                    <div class="col-sm-6 col-xl-3">
                        <article class="card h-100">
                            <div class="card-body">
                                <p class="admin-page-kicker mb-3">Due Soon</p>
                                <h3 class="mb-0 text-warning">{{ number_format(data_get($taskStats, 'due_soon', 0)) }}</h3>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="card shadow">
                    <div class="card-header">
                        <h3 class="mb-1 text-white">My active task queue</h3>
                        <p class="mb-0 text-muted">Mark pending tasks as completed once the requested action has been delivered.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Assigned To</th>
                                        <th>Note</th>
                                        <th>Window</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tasks as $task)
                                        @php
                                            $assignee = trim((string) data_get($task, 'tuser.name', 'Unassigned'));
                                        @endphp
                                        <tr>
                                            <td><strong>{{ $task->title }}</strong></td>
                                            <td>{{ $assignee }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($task->note, 100) }}</td>
                                            <td>
                                                <div>{{ optional($task->start_date)->format('M d, Y') }}</div>
                                                <div class="text-muted small">to {{ optional($task->end_date)->format('M d, Y') }}</div>
                                            </td>
                                            <td>
                                                @if ($task->status === 'Pending')
                                                    <span class="badge badge-danger">{{ $task->status }}</span>
                                                @else
                                                    <span class="badge badge-success">{{ $task->status }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $task->created_at->toDayDateTimeString() }}</td>
                                            <td>
                                                @if ($task->status === 'Pending')
                                                    <a href="{{ route('markdone', $task->id) }}" class="btn btn-primary btn-sm m-1">Mark as Done</a>
                                                @else
                                                    <span class="btn btn-success btn-sm m-1 disabled">Completed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">No tasks are currently assigned to you.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
