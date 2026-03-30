@php
    $visibleUsers = $users->getCollection();
    $activeVisibleUsers = $visibleUsers->where('status', 'active')->count();
    $inactiveVisibleUsers = $visibleUsers->count() - $activeVisibleUsers;
    $newestVisibleUser = $visibleUsers->sortByDesc('created_at')->first();
@endphp

<div x-data="{ openAddUser: false, openRoi: false, openTopup: false }" @keydown.escape.window="openAddUser = false; openRoi = false; openTopup = false">
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <span class="admin-page-kicker">Investor Operations</span>
                <h1 class="title1 mb-0">Manage <span class="gold-text">Users</span></h1>
                <p class="admin-page-subtitle">Review onboarding, search investor records, trigger bulk account actions, and move directly into user-level management from one control surface.</p>
            </div>
            <div class="admin-page-actions">
                <a class="btn btn-outline-light btn-sm" href="{{ route('emailservices') }}">
                    <i class="fas fa-envelope mr-2"></i>
                    Email Services
                </a>
                <button class="btn btn-primary btn-sm" type="button" @click="openAddUser = true">
                    <i class="fas fa-user-plus mr-2"></i>
                    New User
                </button>
            </div>
        </section>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-[1.3fr_1fr_1fr_1fr]">
            <div class="dashboard-glass overflow-hidden">
                <div class="flex h-full flex-col justify-between bg-[radial-gradient(circle_at_top_right,_rgba(240,185,10,0.18),_transparent_35%),linear-gradient(135deg,_rgba(8,11,18,0.98),_rgba(15,23,42,0.92))] p-6 sm:p-7">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Registry Overview</p>
                        <h2 class="mt-4 text-3xl font-black tracking-tight text-white">{{ number_format($users->total()) }}</h2>
                        <p class="mt-3 max-w-md text-sm font-medium leading-7 text-slate-400">
                            User registry across the current query. Use the console below to search, sort, and apply account actions in batches.
                        </p>
                    </div>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-3">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Visible</p>
                            <p class="mt-2 text-lg font-black text-white">{{ $visibleUsers->count() }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-3">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Selected</p>
                            <p class="mt-2 text-lg font-black gold-text">{{ count($checkrecord) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active in View</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-white">{{ $activeVisibleUsers }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Accounts already marked active in the visible result window.</p>
            </div>

            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Inactive in View</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-white">{{ $inactiveVisibleUsers }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Records still pending activation or currently disabled.</p>
            </div>

            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Latest Signup</p>
                <h2 class="mt-4 text-xl font-black tracking-tight text-white">{{ $newestVisibleUser?->name ?? 'N/A' }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">
                    {{ $newestVisibleUser?->created_at?->diffForHumans() ?? 'No records in current result set.' }}
                </p>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="border-b border-white/5 px-6 py-5 sm:px-7">
                <div class="flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">
                    <div class="grid flex-1 grid-cols-1 gap-4 lg:grid-cols-[minmax(0,1.5fr)_180px_180px_180px]">
                        <div>
                            <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-slate-500">Search Registry</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input
                                    wire:model.debounce.500ms="searchvalue"
                                    class="form-control pl-11"
                                    type="search"
                                    placeholder="Search by name, username, or email"
                                    aria-label="Search users" />
                            </div>
                        </div>

                        <div>
                            <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-slate-500">Rows</label>
                            <select wire:model="pagenum" class="form-control">
                                <option>10</option>
                                <option>20</option>
                                <option>50</option>
                                <option>100</option>
                                <option>200</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-slate-500">Sort By</label>
                            <select wire:model="orderby" class="form-control">
                                <option value="id">ID</option>
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="created_at">Sign up date</option>
                            </select>
                        </div>

                        <div>
                            <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-slate-500">Direction</label>
                            <select wire:model="orderdirection" class="form-control">
                                <option value="desc">Descending</option>
                                <option value="asc">Ascending</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3 xl:justify-end">
                        @if ($checkrecord)
                            <select wire:model="action" class="form-control" style="max-width: 180px;">
                                <option value="Delete">Delete</option>
                                <option value="Clear">Clear Account</option>
                            </select>
                            <button class="btn btn-danger btn-sm" wire:click="delsystemuser" type="button">
                                Apply Action
                            </button>
                            <button class="btn btn-info btn-sm" type="button" @click="openRoi = true">
                                Add ROI
                            </button>
                            <button class="btn btn-secondary btn-sm" type="button" @click="openTopup = true">
                                Credit / Debit
                            </button>
                        @else
                            <button class="btn btn-primary btn-sm" type="button" @click="openAddUser = true">
                                New User
                            </button>
                            <a class="btn btn-info btn-sm" href="{{ route('emailservices') }}">
                                Send Message
                            </a>
                        @endif
                    </div>
                </div>

                @if ($checkrecord)
                    <div class="mt-5 flex flex-wrap items-center gap-3 rounded-2xl border border-white/5 bg-white/5 px-4 py-3">
                        <span class="inline-flex items-center rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-emerald-300">
                            {{ count($checkrecord) }} selected
                        </span>
                        <p class="mb-0 text-xs font-medium text-slate-400">Bulk controls are unlocked for the selected user set.</p>
                    </div>
                @endif
            </div>

            <div class="overflow-x-auto px-2 pb-2 sm:px-4">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="w-[60px]">
                                <input type="checkbox" wire:model="selectPage" />
                            </th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="userslisttbl">
                        @forelse ($users as $user)
                            @php
                                $initials = collect(explode(' ', trim((string) $user->name)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                                    ->implode('');
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    <input type="checkbox" wire:model="checkrecord" value="{{ $user->id }}" />
                                </td>
                                <td class="align-middle">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/5 bg-white/5 text-xs font-black uppercase tracking-widest text-white">
                                            {{ $initials ?: 'NA' }}
                                        </div>
                                        <div>
                                            <p class="mb-1 font-black text-white">{{ $user->name }}</p>
                                            <p class="mb-0 text-[11px] font-semibold uppercase tracking-[0.18em] text-slate-500">
                                                {{ $user->username ?: 'No username' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="space-y-1">
                                        <p class="mb-0 font-semibold text-slate-200">{{ $user->email }}</p>
                                        <p class="mb-0 text-xs text-slate-500">{{ $user->phone ?: 'No phone provided' }}</p>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if ($user->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">{{ ucfirst((string) $user->status) }}</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="space-y-1">
                                        <p class="mb-0 font-semibold text-slate-200">{{ $user->created_at?->format('M d, Y') }}</p>
                                        <p class="mb-0 text-xs text-slate-500">{{ $user->created_at?->diffForHumans() }}</p>
                                    </div>
                                </td>
                                <td class="align-middle text-right">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('viewuser', $user->id) }}" role="button">
                                        Manage User
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-5 text-center text-slate-400">No users matched the current filters.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/5 px-6 py-5 sm:px-7">
                {!! $users->links() !!}
            </div>
        </div>
    </div>

    <div x-cloak x-show="openAddUser" class="fixed inset-0 z-[140] flex items-center justify-center bg-black/75 px-4 py-6 backdrop-blur-sm">
        <div class="absolute inset-0" @click="openAddUser = false"></div>
        <div class="relative w-full max-w-2xl rounded-[28px] border border-white/10 bg-[#0b1220] shadow-2xl shadow-black/70">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5 sm:px-8">
                <div>
                    <h3 class="mb-1 text-xl font-black tracking-tight text-white">Create New User</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Provision a new investor account directly from the admin dashboard</p>
                </div>
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400 transition-all hover:bg-white/10 hover:text-white" @click="openAddUser = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <form wire:submit.prevent="saveUser" class="space-y-5">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label>Username</label>
                            <input type="text" id="usernameinput" class="form-control" wire:model.defer="username" required>
                            @error('username') <div class="mt-2 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" class="form-control" wire:model.defer="email" required>
                            @error('email') <div class="mt-2 text-xs text-danger">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label>Full Name</label>
                        <input type="text" class="form-control" wire:model.defer="fullname" required>
                        @error('fullname') <div class="mt-2 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label>Temporary Password</label>
                        <input type="text" class="form-control" wire:model.defer="password" required>
                        @error('password') <div class="mt-2 text-xs text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex flex-wrap justify-end gap-3">
                        <button type="button" class="btn btn-outline-light btn-sm" @click="openAddUser = false">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Create User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-cloak x-show="openRoi" class="fixed inset-0 z-[140] flex items-center justify-center bg-black/75 px-4 py-6 backdrop-blur-sm">
        <div class="absolute inset-0" @click="openRoi = false"></div>
        <div class="relative w-full max-w-2xl rounded-[28px] border border-white/10 bg-[#0b1220] shadow-2xl shadow-black/70">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5 sm:px-8">
                <div>
                    <h3 class="mb-1 text-xl font-black tracking-tight text-white">Add ROI History</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Apply ROI entries across the selected user set</p>
                </div>
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400 transition-all hover:bg-white/10 hover:text-white" @click="openRoi = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <form wire:submit.prevent="addRoi" class="space-y-5">
                    <div>
                        <label>Select Investment Plan</label>
                        <select class="form-control" wire:model.defer="plan" required>
                            <option value="">Choose a plan</option>
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label>Date</label>
                        <input type="date" wire:model.defer="datecreated" class="form-control" required>
                    </div>

                    <div class="rounded-2xl border border-white/5 bg-white/5 px-4 py-4 text-xs font-medium leading-6 text-slate-400">
                        The system calculates ROI from each selected user’s active investment amount and the plan increment settings.
                    </div>

                    <div class="flex flex-wrap justify-end gap-3">
                        <button type="button" class="btn btn-outline-light btn-sm" @click="openRoi = false">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Apply ROI</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-cloak x-show="openTopup" class="fixed inset-0 z-[140] flex items-center justify-center bg-black/75 px-4 py-6 backdrop-blur-sm">
        <div class="absolute inset-0" @click="openTopup = false"></div>
        <div class="relative w-full max-w-2xl rounded-[28px] border border-white/10 bg-[#0b1220] shadow-2xl shadow-black/70">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5 sm:px-8">
                <div>
                    <h3 class="mb-1 text-xl font-black tracking-tight text-white">Credit / Debit Accounts</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Move funds or bonus values across the selected accounts</p>
                </div>
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400 transition-all hover:bg-white/10 hover:text-white" @click="openTopup = false">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-6 sm:px-8">
                <form wire:submit.prevent="topup" class="space-y-5">
                    <div>
                        <label>Amount</label>
                        <input class="form-control" placeholder="Enter amount" type="number" step="any" wire:model.defer="topamount" required>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label>Target Column</label>
                            <select class="form-control" wire:model.defer="topcolumn" required>
                                <option value="" disabled>Select column</option>
                                <option value="Bonus">Bonus</option>
                                <option value="balance">Account Balance</option>
                            </select>
                        </div>

                        <div>
                            <label>Action Type</label>
                            <select class="form-control" wire:model.defer="toptype" required>
                                <option value="">Select type</option>
                                <option value="Credit">Credit</option>
                                <option value="Debit">Debit</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-end gap-3">
                        <button type="button" class="btn btn-outline-light btn-sm" @click="openTopup = false">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-sm">Save Action</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
