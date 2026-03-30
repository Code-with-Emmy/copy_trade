@extends('layouts.admin-dasht')
@section('title', 'Notifications')

@section('content')
    @php
        $notificationItems = collect(method_exists($notifications ?? null, 'items') ? $notifications->items() : ($notifications ?? []));
        $unreadNotifications = $unreadNotifications ?? $notificationItems->where('is_read', false);
        $readNotifications = $readNotifications ?? $notificationItems->where('is_read', true);
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Notifications</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Admin <span class="gold-text">Inbox</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Track platform alerts, operator notices, and admin-level events from a single notification stream.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.markallasread') }}"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="check-check" class="mr-2 h-4 w-4"></i>
                    Mark All Read
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Notifications</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($notifications->total()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Paginated admin inbox items</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Unread on Page</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ number_format($unreadNotifications->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-yellow-400">Requires review or acknowledgement</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Read on Page</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($readNotifications->count()) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Already actioned or archived mentally</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Newest Alert</p>
                <h2 class="mt-4 text-base font-black tracking-tight text-white">{{ optional($notifications->first())->created_at?->diffForHumans() ?? 'No alerts yet' }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Latest notification timestamp</p>
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($notifications as $notification)
                @php
                    $type = strtolower((string) $notification->type);
                    $typeClasses = match ($type) {
                        'warning' => 'bg-yellow-500/10 text-yellow-400',
                        'success' => 'bg-emerald-500/10 text-emerald-400',
                        'danger' => 'bg-rose-500/10 text-rose-300',
                        default => 'bg-sky-500/10 text-sky-300',
                    };
                    $icon = match ($type) {
                        'warning' => 'triangle-alert',
                        'success' => 'badge-check',
                        'danger' => 'octagon-alert',
                        default => 'bell',
                    };
                @endphp

                <div class="dashboard-glass p-6 sm:p-7 {{ $notification->is_read ? '' : 'border-yellow-500/20 bg-yellow-500/[0.03]' }}">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="flex gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-white/10 bg-black/30">
                                <i data-lucide="{{ $icon }}" class="h-5 w-5 {{ $notification->is_read ? 'text-slate-500' : 'gold-text' }}"></i>
                            </div>
                            <div class="space-y-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="text-lg font-black tracking-tight text-white">{{ $notification->title }}</h2>
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest {{ $typeClasses }}">
                                        {{ ucfirst($notification->type) }}
                                    </span>
                                    @if (! $notification->is_read)
                                        <span class="inline-flex rounded-full bg-white/5 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-yellow-400">
                                            Unread
                                        </span>
                                    @endif
                                </div>
                                <p class="max-w-4xl text-sm leading-7 text-slate-300">{{ $notification->message }}</p>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                                    {{ optional($notification->created_at)->toDayDateTimeString() }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 lg:justify-end">
                            @if (! $notification->is_read)
                                <a href="{{ route('admin.markasread', $notification->id) }}"
                                    class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-emerald-300 transition-all hover:bg-emerald-500/20">
                                    Mark Read
                                </a>
                            @endif
                            <a href="{{ route('admin.deletenotification', $notification->id) }}"
                                onclick="return confirm('Delete this notification?')"
                                class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="dashboard-glass px-6 py-16 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/5">
                        <i data-lucide="bell-off" class="h-7 w-7 text-slate-500"></i>
                    </div>
                    <p class="mt-5 text-lg font-black tracking-tight text-white">No notifications available.</p>
                    <p class="mt-2 text-sm text-slate-500">Admin alerts, funding notices, and workflow messages will appear here.</p>
                </div>
            @endforelse
        </div>

        @if ($notifications->hasPages())
            <div class="dashboard-glass px-6 py-5">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection
