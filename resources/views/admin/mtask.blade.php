@extends('layouts.admin-dasht')

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <section class="admin-page-header">
                    <div>
                        <span class="admin-page-kicker">Task Board</span>
                        <h1 class="title1 mb-0">Manage all internal tasks</h1>
                        <p class="admin-page-subtitle">Track assignment ownership, due dates, urgency, and completion status across internal operations from one admin board.</p>
                    </div>
                    <div class="admin-page-actions">
                        <a href="{{ route('task') }}" class="btn btn-primary btn-sm">Create Task</a>
                        <a href="{{ route('viewtask') }}" class="btn btn-outline-light btn-sm">My Tasks</a>
                    </div>
                </section>

                <x-danger-alert />
                <x-success-alert />

                <div class="row mb-4">
                    <div class="col-sm-6 col-xl-3">
                        <article class="card h-100">
                            <div class="card-body">
                                <p class="admin-page-kicker mb-3">Total</p>
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
                    <div class="card-header d-flex flex-wrap justify-content-between align-items-end" style="gap:1rem;">
                        <div>
                            <h3 class="mb-1 text-white">Task Queue</h3>
                            <p class="mb-0 text-muted">Review status, edit pending tasks, or remove outdated assignments.</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" data-example-id="hoverable-table">
                            <table id="ShipTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Task</th>
                                        <th>Assigned To</th>
                                        <th>Window</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tasks as $task)
                                        @php
                                            $assignee = trim((string) data_get($task, 'tuser.name', 'Unassigned'));
                                            $priority = strtolower((string) $task->priority);
                                            $priorityClass = match ($priority) {
                                                'immediately', 'high' => 'badge badge-danger',
                                                'medium' => 'badge badge-warning',
                                                default => 'badge badge-info',
                                            };
                                        @endphp
                                        <tr>
                                            <td>
                                                <strong>{{ $task->title }}</strong>
                                                <div class="text-muted small mt-1">{{ \Illuminate\Support\Str::limit($task->note, 72) }}</div>
                                            </td>
                                            <td>{{ $assignee }}</td>
                                            <td>
                                                <div>{{ optional($task->start_date)->format('M d, Y') }}</div>
                                                <div class="text-muted small">to {{ optional($task->end_date)->format('M d, Y') }}</div>
                                            </td>
                                            <td><span class="{{ $priorityClass }}">{{ $task->priority }}</span></td>
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
                                                    <button class="btn btn-success btn-sm m-1 text-white" data-toggle="modal"
                                                        data-target="#edittaskModal{{ $task->id }}">Edit</button>
                                                @endif
                                                <a href="{{ route('deltask', $task->id) }}" class="btn btn-danger btn-sm m-1"
                                                    onclick="return confirm('Delete this task?')">Delete</a>
                                            </td>
                                        </tr>

                                        <div id="edittaskModal{{ $task->id }}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Edit task</h4>
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('updatetask') }}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>Task title</label>
                                                                <input type="text" name="tasktitle" value="{{ $task->title }}" class="form-control" required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Note</label>
                                                                <textarea name="note" rows="5" class="form-control" required>{{ $task->note }}</textarea>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Task delegation</label>
                                                                <select class="form-control" name="delegation" required>
                                                                    <option value="{{ $task->designation }}">{{ $assignee }}</option>
                                                                    @foreach ($admin as $user)
                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label>From</label>
                                                                    <input type="date" name="start_date" value="{{ optional($task->start_date)->format('Y-m-d') }}" class="form-control" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label>To</label>
                                                                    <input type="date" name="end_date" value="{{ optional($task->end_date)->format('Y-m-d') }}" class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Priority</label>
                                                                <select class="form-control" name="priority" required>
                                                                    <option value="{{ $task->priority }}">{{ $task->priority }}</option>
                                                                    <option>Immediately</option>
                                                                    <option>High</option>
                                                                    <option>Medium</option>
                                                                    <option>Low</option>
                                                                </select>
                                                            </div>

                                                            <input type="hidden" name="id" value="{{ $task->id }}">
                                                            <button type="submit" class="btn btn-primary">Apply Change</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">No tasks have been created yet.</td>
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
