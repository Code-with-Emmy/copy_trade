@extends('layouts.dasht')
@section('title', 'Notifications')

@section('content')
<div x-data="{
  showSuccessAlert: {{ session('success') ? 'true' : 'false' }},
  showErrorAlert: {{ session('error') ? 'true' : 'false' }},
  filterStatus: 'all',
  searchTerm: ''
}" class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">

  <!-- Header Section -->
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
      <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
        <a href="{{ route('dashboard') }}" class="hover:text-yellow-500 transition-colors">Dashboard</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-300">Notifications</span>
      </div>
      <h1 class="text-3xl font-black text-white tracking-tight">Your <span class="gold-text">Inbox</span></h1>
      <p class="text-slate-400 text-sm mt-1 font-medium">Messages about your account and trades.</p>
    </div>

    <div class="flex items-center space-x-3">
      <div class="flex items-center px-4 py-2 rounded-xl bg-yellow-500/5 border border-yellow-500/10">
        <i data-lucide="bell" class="w-4 h-4 gold-text mr-2"></i>
        <span class="text-[10px] font-black gold-text uppercase tracking-widest">{{ $notifications->total() }}
          Notifications</span>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  <div class="space-y-4">
    <template x-if="showSuccessAlert">
      <div class="p-6 rounded-2xl bg-emerald-500/5 border border-emerald-500/10 flex items-center justify-between">
        <div class="flex items-center text-[11px] font-black text-emerald-400 uppercase tracking-widest">
          <i data-lucide="check" class="w-4 h-4 mr-3"></i>
          {{ session('success') }}
        </div>
        <button @click="showSuccessAlert = false" class="text-slate-500 hover:text-white transition-colors">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
      </div>
    </template>
    <template x-if="showErrorAlert">
      <div class="p-6 rounded-2xl bg-rose-500/5 border border-rose-500/10 flex items-center justify-between">
        <div class="flex items-center text-[11px] font-black text-rose-400 uppercase tracking-widest">
          <i data-lucide="alert-triangle" class="w-4 h-4 mr-3"></i>
          {{ session('error') }}
        </div>
        <button @click="showErrorAlert = false" class="text-slate-500 hover:text-white transition-colors">
          <i data-lucide="x" class="w-4 h-4"></i>
        </button>
      </div>
    </template>
  </div>

  <!-- Interface Controls -->
  @if(count($notifications) > 0)
    <div
      class="dashboard-glass border-white/5 p-5 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-6 md:gap-8">
      <div class="flex items-center space-x-2 overflow-x-auto no-scrollbar pb-2 md:pb-0">
        <button @click="filterStatus = 'all'"
          class="flex-shrink-0 px-4 md:px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
          :class="filterStatus === 'all' ? 'gold-gradient-bg text-black' : 'bg-white/5 text-slate-500 hover:text-white'">
          All
        </button>
        <button @click="filterStatus = 'unread'"
          class="flex-shrink-0 px-4 md:px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
          :class="filterStatus === 'unread' ? 'gold-gradient-bg text-black' : 'bg-white/5 text-slate-500 hover:text-white'">
          Unread
        </button>
        <button @click="filterStatus = 'read'"
          class="flex-shrink-0 px-4 md:px-6 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all"
          :class="filterStatus === 'read' ? 'gold-gradient-bg text-black' : 'bg-white/5 text-slate-500 hover:text-white'">
          Read
        </button>
      </div>

      <div class="relative w-full md:w-80 group">
        <i data-lucide="search"
          class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-600 transition-colors group-focus-within:gold-text"></i>
        <input type="text" x-model="searchTerm" placeholder="SEARCH..."
          class="w-full bg-black/50 border border-white/10 rounded-xl py-3 pl-12 pr-4 text-[10px] font-black text-white uppercase tracking-widest placeholder:text-slate-700 focus:border-yellow-500/50 focus:ring-0 transition-all">
      </div>
    </div>
  @endif

  <!-- Main Manifest Container -->
  <div class="dashboard-glass border-white/5 overflow-hidden">
    @if(count($notifications) > 0)
      <div class="divide-y divide-white/5">
        @foreach($notifications as $notification)
          <div
            x-show="(filterStatus === 'all' || (filterStatus === 'unread' && {{ $notification->is_read ? 'false' : 'true' }}) || (filterStatus === 'read' && {{ $notification->is_read ? 'true' : 'false' }})) &&
                                                         (searchTerm === '' || '{{ strtolower($notification->title) }}'.includes(searchTerm.toLowerCase()) || '{{ strtolower($notification->message) }}'.includes(searchTerm.toLowerCase()))"
            class="group p-5 md:p-8 transition-all hover:bg-white/[0.02] relative overflow-hidden">

            <!-- Glow Effect -->
            @if(!$notification->is_read)
              <div class="absolute inset-0 bg-yellow-500/[0.02] pointer-events-none"></div>
              <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-500 shadow-[0_0_15px_rgba(240,185,10,0.5)]"></div>
            @endif

            <div class="flex flex-col md:flex-row gap-6 md:gap-8 relative">
              <!-- Icon Base -->
              <div class="flex-shrink-0 flex items-start">
                <div
                  class="h-12 w-12 md:h-14 md:w-14 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 group-hover:border-yellow-500/30 transition-all shadow-xl">
                  <div class="h-full w-full rounded-[14px] bg-white/[0.02] flex items-center justify-center">
                    <i data-lucide="{{ $notification->type === 'warning' ? 'alert-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'alert-octagon' : 'info')) }}"
                      class="w-5 h-5 md:w-6 md:h-6 {{ $notification->type === 'warning' ? 'text-yellow-500' : ($notification->type === 'success' ? 'text-emerald-500' : ($notification->type === 'danger' ? 'text-rose-500' : 'text-blue-500')) }}"></i>
                  </div>
                </div>
              </div>

              <!-- Content Core -->
              <div class="flex-grow space-y-2">
                <div class="flex flex-wrap items-center gap-2 md:gap-3">
                  <h3
                    class="text-sm font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">
                    {{ $notification->title }}
                  </h3>
                  @if(!$notification->is_read)
                    <span
                      class="px-2 py-0.5 rounded-md bg-yellow-500/10 border border-yellow-500/20 text-[7px] font-black gold-text uppercase tracking-[0.2em] animate-pulse">New</span>
                  @endif
                </div>
                <p class="text-xs text-slate-400 font-medium leading-loose max-w-4xl">{{ $notification->message }}</p>

                <div class="flex flex-wrap items-center gap-4 md:gap-6 pt-2">
                  <div class="flex items-center text-[9px] font-black text-slate-600 uppercase tracking-widest">
                    <i data-lucide="clock" class="w-3 h-3 mr-2"></i>
                    {{ $notification->created_at->diffForHumans() }}
                  </div>
                  <div
                    class="flex items-center text-[9px] font-black uppercase tracking-widest {{ $notification->type === 'warning' ? 'text-yellow-500' : ($notification->type === 'success' ? 'text-emerald-500' : ($notification->type === 'danger' ? 'text-rose-500' : 'text-blue-500')) }}">
                    <i data-lucide="activity" class="w-3 h-3 mr-2"></i>
                    {{ $notification->type }}
                  </div>
                </div>
              </div>

              <!-- Controls -->
              <div class="flex items-center gap-3 md:ml-auto md:self-center">
                @if(!$notification->is_read)
                  <form method="POST" action="{{ route('notifications.mark-read') }}">
                    @csrf
                    <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                    <button type="submit"
                      class="p-2.5 md:p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 hover:bg-emerald-500 hover:text-white transition-all shadow-lg hover:shadow-emerald-500/20">
                      <i data-lucide="check" class="w-4 h-4"></i>
                    </button>
                  </form>
                @endif
                <a href="{{ route('notifications.show', $notification->id) }}"
                  class="p-2.5 md:p-3 rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all hover:bg-white/10">
                  <i data-lucide="eye" class="w-4 h-4"></i>
                </a>
                <form method="POST" action="{{ route('notifications.delete') }}" class="inline">
                  @csrf
                  @method('DELETE')
                  <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                  <button type="submit" onclick="return confirm('DELETE THIS NOTIFICATION?')"
                    class="p-2.5 md:p-3 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-500 hover:bg-rose-500 hover:text-white transition-all hover:shadow-rose-500/20">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination Matrix -->
      <div
        class="p-5 md:p-8 border-t border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-black/40">
        <div class="text-[9px] font-black text-slate-600 uppercase tracking-widest text-center md:text-left">
          Showing <span class="text-white">{{ $notifications->firstItem() ?? 0 }}</span> - <span
            class="text-white">{{ $notifications->lastItem() ?? 0 }}</span> of <span
            class="text-white">{{ $notifications->total() }}</span> Notifications
        </div>
        <div class="flex items-center justify-center md:justify-end">
          {{ $notifications->onEachSide(1)->links('pagination::tailwind') }}
        </div>
      </div>
    @else
      <div class="p-20 text-center opacity-30">
        <i data-lucide="bell-off" class="w-16 h-16 text-slate-700 mx-auto mb-6"></i>
        <h3 class="text-lg font-black text-white uppercase tracking-widest">No Notifications</h3>
        <p class="text-slate-500 text-[10px] font-black uppercase tracking-tighter mt-2">Your inbox is currently empty.
        </p>
        <a href="{{ route('dashboard') }}"
          class="mt-10 inline-flex items-center px-8 py-4 bg-white/5 border border-white/10 rounded-xl text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">GO
          BACK</a>
      </div>
    @endif
  </div>
</div>

@section('scripts')
  @parent
  <script>
    document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
  </script>
@endsection