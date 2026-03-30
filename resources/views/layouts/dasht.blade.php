<!DOCTYPE html>
<html lang="en" class="dark">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{$title}} | {{ $settings->site_name }}</title>

  {{-- BitCloven Core Assets --}}
  <link rel="stylesheet" href="{{ asset('styles.css') }}">
  <link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/x-icon">

  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root {
      --bg-dark: #000000;
      --accent-gold: #f0b90a;
      --glass-bg: rgba(255, 255, 255, 0.03);
      --glass-border: rgba(255, 255, 255, 0.1);
    }

    body {
      background-color: var(--bg-dark);
      font-family: 'Inter', -apple-system, sans-serif;
      color: #ffffff;
      overflow-x: hidden;
    }

    .dashboard-glass {
      background: var(--glass-bg);
      backdrop-filter: blur(12px);
      border: 1px solid var(--glass-border);
      border-radius: 20px;
    }

    .gold-text {
      color: var(--accent-gold);
    }

    .gold-gradient-bg {
      background: linear-gradient(135deg, #f0b90a, #d4a017);
    }

    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 0.7rem;
      padding: 0.8rem 1rem;
      margin: 0.2rem 0;
      border-radius: 14px;
      color: #94a3b8;
      transition: all 0.2s ease;
      font-size: 0.875rem;
      line-height: 1.25rem;
    }

    .sidebar-link:hover {
      background: rgba(255, 255, 255, 0.05);
      color: #ffffff;
    }

    .sidebar-link.active {
      background: rgba(240, 185, 10, 0.1);
      color: var(--accent-gold);
    }

    .sidebar-link i {
      width: 18px;
      height: 18px;
      margin-right: 0;
      opacity: 0.9;
    }

    .sidebar-section-label {
      margin: 1.1rem 0 0.55rem;
      padding: 0 0.5rem;
      font-size: 0.625rem;
      font-weight: 800;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #64748b;
    }

    .top-nav {
      background: rgba(0, 0, 0, 0.8);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid var(--glass-border);
      height: 70px;
    }

    .page-shell {
      width: 100%;
      max-width: 1520px;
      margin: 0 auto;
    }

    .page-content-stack {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    @media (min-width: 1024px) {
      .page-content-stack {
        gap: 2.5rem;
      }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
      width: 6px;
    }

    ::-webkit-scrollbar-track {
      background: #000;
    }

    ::-webkit-scrollbar-thumb {
      background: #333;
      border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #444;
    }

    [x-cloak] {
      display: none !important;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .animate-slideUp {
      animation: slideUp 0.3s ease-out forwards;
    }

    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
  @stack('head')
  <style>
    /* Premium Hover Effects */
    .sidebar-link:hover i {
      transform: translateX(4px);
      transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .gold-glow {
      box-shadow: 0 0 20px rgba(240, 185, 10, 0.15);
    }

    /* Better Alignment for Sidebar Icons */
    .sidebar-link i {
      flex-shrink: 0;
    }

    /* Content Transition */
    .page-wrapper {
      transition: all 0.3s ease;
    }

    /* Translator */
    .gtranslate_wrapper {
      width: 100%;
      min-height: 34px;
      display: flex;
      align-items: center;
      overflow: visible;
    }


    .translator-label {
      font-size: 0.58rem;
      font-weight: 800;
      letter-spacing: 0.18em;
      text-transform: uppercase;
      color: #64748b;
    }
  </style>
</head>

<body class="antialiased" x-data="{ sidebarOpen: false, fabOpen: false, cryptoData: { btc: 0, eth: 0 } }" x-init="
        fetch('https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum&vs_currencies=usd')
            .then(r => r.json())
            .then(data => {
                cryptoData.btc = data.bitcoin.usd;
                cryptoData.eth = data.ethereum.usd;
            }).catch(() => {});
      ">

  <!-- Mobile Sidebar Backdrop -->
  <div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 z-[60] bg-black/60 backdrop-blur-sm lg:hidden"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

  <!-- Sidebar Container -->
  <aside
    class="fixed inset-y-0 left-0 z-[70] w-72 border-r border-white/10 bg-gradient-to-b from-[#040507] via-[#05080d] to-black transform lg:translate-x-0 transition-transform duration-300 ease-in-out"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    <div class="flex flex-col h-full">
      <!-- Sidebar Header / Logo -->
      <div class="h-[78px] flex items-center justify-between px-6 border-b border-white/5 bg-black/30 backdrop-blur-md">
        <a href="{{ route('home') }}" class="flex items-center">
          <img src="{{ asset('storage/' . $settings->logo)}}" alt="BitCloven" class="h-9 w-auto object-contain">
        </a>
        <button @click="sidebarOpen = false"
          class="lg:hidden h-10 w-10 flex items-center justify-center rounded-xl bg-white/5 border border-white/10 text-slate-500 hover:text-white transition-all">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <!-- Profile Overview (Mini) -->
      <div class="px-5 py-6">
        <div
          class="dashboard-glass p-5 border-white/10 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
          <div
            class="absolute -right-4 -top-4 w-16 h-16 bg-yellow-500/5 blur-2xl group-hover:bg-yellow-500/10 transition-all">
          </div>

          <div class="flex items-center space-x-3 mb-5 relative">
            <div
              class="h-12 w-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center p-0.5 shadow-xl">
              <img
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=000&color=f0b90a&bold=true"
                alt="{{ Auth::user()->name }}" class="h-full w-full rounded-[14px] object-cover">
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs font-black text-white truncate uppercase tracking-tight">{{ Auth::user()->name }}</p>
              <div class="flex items-center mt-1">
                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Active Account</span>
              </div>
            </div>
          </div>

          <div class="space-y-1.5 relative">
            <div class="text-[9px] text-slate-500 uppercase font-black tracking-[0.2em]">Total Balance</div>
            <div class="text-2xl font-black gold-text tracking-tighter">
              {{ Auth::user()->currency }}{{ number_format(Auth::user()->account_bal, 2) }}
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation Links -->
      <nav class="flex-1 overflow-y-auto pb-16 pt-1 no-scrollbar">
        <div class="px-5">
          <div class="sidebar-section-label">Portfolio</div>
          <div class="space-y-1">
            <a href="{{ route('dashboard') }}"
              class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <i data-lucide="layout-grid"></i>
              <span>Dashboard</span>
            </a>

            <a href="{{ route('myplans.default') }}"
              class="sidebar-link {{ request()->routeIs('myplans*') ? 'active' : '' }}">
              <i data-lucide="briefcase"></i>
              <span>My Portfolio</span>
            </a>

            <a href="{{ route('trade.index') }}"
              class="sidebar-link {{ request()->routeIs('trade.*') ? 'active' : '' }}">
              <i data-lucide="trending-up"></i>
              <span>Markets</span>
            </a>

            <a href="{{ route('copy.dashboard') }}"
              class="sidebar-link {{ request()->routeIs('copy.*') ? 'active' : '' }}">
              <i data-lucide="users-2"></i>
              <span>Copy Trading</span>
            </a>

            <a href="{{ route('user.bots.index') }}"
              class="sidebar-link {{ request()->routeIs('user.bots.*') ? 'active' : '' }}">
              <i data-lucide="bot"></i>
              <span>Trading Bots</span>
            </a>
          </div>
        </div>

        <div class="px-5 mt-3">
          <div class="sidebar-section-label">Finances</div>
          <div class="space-y-1">
            <a href="{{ route('deposits') }}" class="sidebar-link {{ request()->routeIs('deposits') ? 'active' : '' }}">
              <i data-lucide="plus-circle"></i>
              <span>Funding</span>
            </a>

            <a href="{{ route('withdrawalsdeposits') }}"
              class="sidebar-link {{ request()->routeIs('withdrawalsdeposits') ? 'active' : '' }}">
              <i data-lucide="arrow-up-right"></i>
              <span>Withdraw</span>
            </a>

            <a href="{{ route('accounthistory') }}"
              class="sidebar-link {{ request()->routeIs('accounthistory') ? 'active' : '' }}">
              <i data-lucide="history"></i>
              <span>Statement</span>
            </a>
          </div>
        </div>

        <div class="px-5 mt-3">
          <div class="sidebar-section-label">System</div>
          <div class="space-y-1">
            <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
              <i data-lucide="settings-2"></i>
              <span>Account Settings</span>
            </a>

            <a href="{{ route('account.verify') }}"
              class="sidebar-link {{ request()->routeIs('account.verify') ? 'active' : '' }}">
              <i data-lucide="shield-check"></i>
              <span>Verification</span>
            </a>

            <a href="{{ route('referuser') }}"
              class="sidebar-link {{ request()->routeIs('referuser') ? 'active' : '' }}">
              <i data-lucide="user-plus"></i>
              <span>Referral</span>
            </a>

            <a href="{{ route('support') }}" class="sidebar-link {{ request()->routeIs('support') ? 'active' : '' }}">
              <i data-lucide="headphones"></i>
              <span>Support Desk</span>
            </a>
          </div>
        </div>
      </nav>

      <!-- Language -->
      <div class="">
        <div class="gtranslate_wrapper"></div>
      </div>
    </div>

    <!-- Bottom Floating Profile (Desktop) -->
    <div class="px-5 py-6 border-t border-white/5 bg-black/30 backdrop-blur-md">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="flex items-center w-full px-5 py-3.5 rounded-2xl bg-white/[0.03] hover:bg-rose-500/10 border border-white/5 text-slate-400 hover:text-rose-400 transition-all group">
          <i data-lucide="power" class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform"></i>
          <span class="text-[10px] font-black uppercase tracking-[0.2em]">Logout</span>
        </button>
      </form>
    </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <div class="lg:ml-72 flex flex-col min-h-screen">

    <!-- Top Nav -->
    <header class="top-nav px-8 lg:px-12 flex items-center justify-between sticky top-0 z-[50]">
      <div class="flex items-center lg:hidden">
        <button @click="sidebarOpen = true"
          class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white/50 hover:text-white transition-all active:scale-95 shadow-lg">
          <i data-lucide="menu" class="w-6 h-6"></i>
        </button>
        <img src="{{ asset('storage/' . $settings->logo)}}" alt="BitCloven" class="h-6 ml-4 opacity-80">
      </div>

      <div class="flex items-center space-x-6 lg:space-x-8 ml-auto">

        <!-- Market Ticker (Desktop) -->
        <div class="hidden xl:flex items-center space-x-10">
          <div
            class="flex items-center space-x-4 bg-white/[0.02] px-6 py-2.5 rounded-2xl border border-white/5 hover:border-white/10 transition-all">
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">BTC Price</span>
            <span class="text-xs font-black text-emerald-400 font-mono"
              x-text="'$' + (cryptoData.btc ? cryptoData.btc.toLocaleString() : '...')"></span>
          </div>
          <div
            class="flex items-center space-x-4 bg-white/[0.02] px-6 py-2.5 rounded-2xl border border-white/5 hover:border-white/10 transition-all">
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">ETH Price</span>
            <span class="text-xs font-black text-emerald-400 font-mono"
              x-text="'$' + (cryptoData.eth ? cryptoData.eth.toLocaleString() : '...')"></span>
          </div>
        </div>

        <!-- Functional Notification Bell -->
        <div class="relative" x-data="{ open: false }">
          @php
            $notifications = \App\Models\Notification::where('user_id', Auth::id())->orderBy('id', 'desc')->take(5)->get();
            $unreadCount = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', 0)->count();
          @endphp
          <button @click="open = !open"
            class="h-12 w-12 flex items-center justify-center rounded-2xl bg-white/5 border border-white/10 text-white/60 hover:text-white hover:border-yellow-500/30 transition-all relative group/bell">
            <i data-lucide="bell" class="w-5 h-5 group-hover/bell:scale-110 transition-transform"></i>
            @if($unreadCount > 0)
              <span
                class="absolute top-2.5 right-2.5 h-2 w-2 rounded-full bg-yellow-500 shadow-[0_0_10px_#f0b90a] unread-count-badge-dot"></span>
            @endif
          </button>

          <!-- Dropdown -->
          <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="absolute right-0 mt-4 w-80 bg-[#0d0d0d] border border-white/10 rounded-2xl overflow-hidden z-[100] shadow-2xl shadow-black/80"
            x-cloak>

            <div class="p-6 border-b border-white/5 bg-white/[0.02] flex items-center justify-between">
              <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Notifications</h3>
              <span
                class="text-[10px] font-black gold-text uppercase tracking-widest unread-count-badge">{{ $unreadCount }}
                Pending</span>
            </div>

            <div class="max-h-[400px] overflow-y-auto no-scrollbar">
              @forelse($notifications as $notification)
                <div @click="markAsRead({{ $notification->id }}, $el)"
                  class="p-6 border-b border-white/5 hover:bg-white/[0.03] transition-colors cursor-pointer group {{ !$notification->is_read ? 'bg-yellow-500/[0.02]' : '' }}">
                  <div class="flex items-center space-x-4">
                    <div
                      class="h-9 w-9 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-yellow-500/30 transition-all">
                      <i data-lucide="{{ $notification->type === 'warning' ? 'alert-triangle' : ($notification->type === 'success' ? 'check-circle' : ($notification->type === 'danger' ? 'alert-octagon' : 'info')) }}"
                        class="w-4 h-4 {{ $notification->type === 'warning' ? 'text-yellow-500' : ($notification->type === 'success' ? 'text-emerald-500' : ($notification->type === 'danger' ? 'text-rose-500' : 'text-blue-500')) }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p
                        class="text-[11px] font-bold text-slate-300 leading-relaxed uppercase tracking-tight line-clamp-2">
                        {{ $notification->message }}
                      </p>
                      <span class="text-[9px] text-slate-600 font-black uppercase tracking-widest mt-2 block">
                        {{ $notification->created_at->diffForHumans() }}
                      </span>
                    </div>
                    @if(!$notification->is_read)
                      <div class="h-1.5 w-1.5 rounded-full bg-yellow-500 mt-1 unread-indicator"></div>
                    @endif
                  </div>
                </div>
              @empty
                <div class="p-12 text-center">
                  <i data-lucide="bell-off" class="w-10 h-10 text-slate-800 mx-auto mb-4"></i>
                  <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest leading-relaxed">No new
                    notifications.<br>You're all caught up!</p>
                </div>
              @endforelse
            </div>

            <a href="{{ route('notifications') }}"
              class="block p-5 bg-white/[0.02] text-center text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] hover:text-white hover:bg-white/[0.05] transition-all border-t border-white/5">
              View All Notifications
            </a>
          </div>
        </div>

        <!-- Terminal Access Button -->
        <a href="{{ route('mplans') }}"
          class="hidden sm:flex items-center h-12 px-8 rounded-2xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-[0.2em] shadow-2xl shadow-yellow-500/20 hover:scale-[1.05] transform transition-all active:scale-95 group">
          <i data-lucide="zap" class="w-4 h-4 mr-2 group-hover:scale-125 transition-transform"></i>
          Deposit
        </a>

        <!-- Profile Menu -->
        <div class="relative" x-data="{ profileOpen: false }">
          <button @click="profileOpen = !profileOpen"
            class="h-12 pl-1 pr-3 flex items-center gap-2 rounded-2xl border border-white/10 bg-white/[0.02] hover:border-yellow-500/40 transition-all flex-shrink-0 shadow-lg">
            <span class="h-10 w-10 flex items-center justify-center rounded-xl overflow-hidden border border-white/10">
              <img
                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=111&color=f0b90a&bold=true&size=48"
                alt="{{ Auth::user()->name }}" class="h-full w-full object-cover">
            </span>
            <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform"
              :class="profileOpen ? 'rotate-180' : ''"></i>
          </button>

          <div x-cloak x-show="profileOpen" @click.away="profileOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            class="absolute right-0 mt-4 w-64 rounded-2xl border border-white/10 bg-[#0d0d0d] shadow-2xl shadow-black/80 overflow-hidden z-[100]">
            <div class="px-4 py-4 border-b border-white/5">
              <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
              <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mt-1 truncate">
                {{ Auth::user()->email }}
              </p>
            </div>

            <div class="p-2 space-y-1">
              <a href="{{ route('profile') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                <i data-lucide="user" class="w-4 h-4"></i>
                <span>My Profile</span>
              </a>
              <a href="{{ route('accounthistory') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                <i data-lucide="history" class="w-4 h-4"></i>
                <span>Account Statement</span>
              </a>
              <a href="{{ route('support') }}"
                class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-300 hover:bg-white/5 hover:text-white transition-all">
                <i data-lucide="headphones" class="w-4 h-4"></i>
                <span>Support</span>
              </a>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                  class="w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-rose-300 hover:bg-rose-500/10 hover:text-rose-200 transition-all">
                  <i data-lucide="log-out" class="w-4 h-4"></i>
                  <span>Logout</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Page Content -->
    <main class="flex-1 p-4 sm:p-6 lg:p-10 pb-32 lg:pb-10">
      <div class="page-shell">
        @yield('content')
      </div>
    </main>

    <!-- Desktop Footer -->
    <footer
      class="hidden lg:flex p-10 border-t border-white/5 text-slate-500 text-[11px] tracking-wide font-medium items-center justify-between">
      <p>&copy; {{ date('Y') }} {{ $settings->site_name }}. Institutional Grade Asset Management.</p>
      <div class="flex items-center space-x-8">
        <a href="{{ route('terms') }}" class="hover:text-white transition-colors uppercase">Terms</a>
        <a href="{{ route('privacy') }}" class="hover:text-white transition-colors uppercase">Privacy</a>
        <div class="flex items-center">
          <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
          System Status: Operational
        </div>
      </div>
    </footer>
  </div>

  <!-- Mobile Bottom Navigation (Glass) -->
  <div class="fixed bottom-0 left-0 right-0 z-[100] lg:hidden">
    <div class="mx-4 mb-6 dashboard-glass bg-black/60 border-white/10 p-2 overflow-visible">
      <div class="flex items-center justify-around relative">
        <a href="{{ route('dashboard') }}"
          class="flex flex-col items-center p-3 {{ request()->routeIs('dashboard') ? 'gold-text' : 'text-slate-500' }}">
          <i data-lucide="layout-grid" class="w-6 h-6"></i>
        </a>
        <a href="{{ route('trade.index') }}"
          class="flex flex-col items-center p-3 {{ request()->routeIs('trade.*') ? 'gold-text' : 'text-slate-500' }}">
          <i data-lucide="trending-up" class="w-6 h-6"></i>
        </a>

        <!-- Center Action Button -->
        <div class="relative -top-8">
          <button @click="fabOpen = !fabOpen"
            class="h-14 w-14 rounded-full gold-gradient-bg border-4 border-[#000] flex items-center justify-center shadow-2xl shadow-yellow-500/40 transform transition-all active:scale-90">
            <i data-lucide="zap" class="w-6 h-6 text-black" :class="fabOpen ? 'rotate-45' : ''"></i>
          </button>
          <!-- FAB Menu -->
          <div x-show="fabOpen" @click.away="fabOpen = false"
            class="absolute bottom-20 left-1/2 -translate-x-1/2 w-48 dashboard-glass p-2 space-y-1 animate-slideUp"
            x-cloak>
            <a href="{{ route('deposits') }}"
              class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
              <i data-lucide="plus-circle" class="w-4 h-4 gold-text"></i>
              <span class="text-xs font-bold">Deposit</span>
            </a>
            <a href="{{ route('withdrawalsdeposits') }}"
              class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
              <i data-lucide="arrow-up-right" class="w-4 h-4 text-emerald-400"></i>
              <span class="text-xs font-bold">Withdraw</span>
            </a>
            <a href="{{ route('copy.dashboard') }}"
              class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/5 transition-all">
              <i data-lucide="users-2" class="w-4 h-4 text-purple-400"></i>
              <span class="text-xs font-bold">Copy Trade</span>
            </a>
          </div>
        </div>

        <a href="{{ route('myplans.default') }}"
          class="flex flex-col items-center p-3 {{ request()->routeIs('myplans*') ? 'gold-text' : 'text-slate-500' }}">
          <i data-lucide="briefcase" class="w-6 h-6"></i>
        </a>
        <a href="{{ route('profile') }}"
          class="flex flex-col items-center p-3 {{ request()->routeIs('profile') ? 'gold-text' : 'text-slate-500' }}">
          <i data-lucide="user" class="w-6 h-6"></i>
        </a>
      </div>
    </div>
  </div>

  @stack('scripts')
  @yield('scripts')
  <script>
    lucide.createIcons();

    const firePremiumAlert = (title, text, icon = 'info') => {
      if (!text) return;
      Swal.fire({
        title,
        text,
        icon,
        background: '#090b10',
        color: '#e2e8f0',
        backdrop: 'rgba(2,6,23,0.8)',
        confirmButtonColor: '#f0b90a',
        customClass: {
          popup: 'rounded-3xl border border-white/10',
          confirmButton: 'rounded-xl font-black uppercase tracking-wider px-6 py-3'
        }
      });
    };

    const flashAlerts = [
      { key: 'success', title: 'Success', text: @json(session('success')), icon: 'success' },
      { key: 'error', title: 'Error', text: @json(session('error')), icon: 'error' },
      { key: 'message', title: 'Notice', text: @json(session('message')), icon: 'warning' },
      { key: 'info', title: 'Information', text: @json(session('info')), icon: 'info' }
    ];

    flashAlerts.forEach((alert) => {
      const hasInlineFlash = document.querySelector(`[data-inline-flash="${alert.key}"]`);
      if (!hasInlineFlash) {
        firePremiumAlert(alert.title, alert.text, alert.icon);
      }
    });

    function markAsRead(id, element) {
      fetch("{{ route('notifications.mark-read') }}", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ notification_id: id })
      })
        .then(response => {
          if (response.ok) {
            element.classList.remove('bg-yellow-500/[0.02]');
            const indicator = element.querySelector('.unread-indicator');
            if (indicator) indicator.remove();

            // Update badge and dot
            const counter = document.querySelector('.unread-count-badge');
            const dot = document.querySelector('.unread-count-badge-dot');

            if (counter) {
              let count = parseInt(counter.innerText);
              if (count > 0) {
                counter.innerText = count - 1;
                if (count - 1 === 0) {
                  counter.remove();
                  if (dot) dot.remove();
                }
              }
            } else if (dot) {
              // If there's no text counter but there is a dot, we might hide it 
              // after clicking one, but usually it's better to keep it if we don't know the count.
              // However, for the 5 shown in dropdown, we can't be sure.
              // Let's just remove the dot if we know there were unreads.
            }
          }
        });
    }
  </script>
  @include('layouts.lang')
  @include('layouts.livechat')
</body>

</html>
