@extends('layouts.admin-dasht')
@section('title', 'Plan Categories')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <a href="{{ route('admin.plans.index') }}" class="transition-colors hover:text-yellow-500">Plans</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Categories</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Plan <span class="gold-text">Categories</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Organize investment products into clear groups and keep plan structure aligned across the admin dashboard.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.plans.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Plans
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Categories</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($categories->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current investment groupings</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Assigned Plans</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($categories->sum('plans_count')) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Plans mapped to categories</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Unused</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($categories->where('plans_count', 0)->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Empty categories safe to clean up</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-8 xl:col-span-1">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Add Category</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Create a new plan grouping</p>
                </div>

                <form action="{{ route('admin.plans.categories.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description (Optional)</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Add Category</button>
                </form>
            </div>

            <div class="dashboard-glass overflow-hidden xl:col-span-2">
                <div class="card-header d-flex justify-content-between align-items-center px-4 py-4 sm:px-6">
                    <h4 class="card-title mb-0">Plan Categories</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Plans</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description ?: 'No description' }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $category->plans_count }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editCategoryModal{{ $category->id }}">
                                                <i class="fa fa-edit"></i> Edit
                                            </button>

                                            @if($category->plans_count == 0)
                                                <form action="{{ route('admin.plans.categories.destroy', $category) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">Edit Category</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.plans.categories.update', $category) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="edit_name{{ $category->id }}">Category Name</label>
                                                            <input type="text" class="form-control" id="edit_name{{ $category->id }}" name="name" value="{{ $category->name }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit_description{{ $category->id }}">Description</label>
                                                            <textarea class="form-control" id="edit_description{{ $category->id }}" name="description" rows="3">{{ $category->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
