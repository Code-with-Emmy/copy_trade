@extends('layouts.admin-dasht')

@php
    $totalExperts = $experts->total();
    $activeExperts = $experts->getCollection()->where('status', 'active')->count();
    $verifiedExperts = $experts->getCollection()->where('verification_status', 'verified')->count();
    $featuredExperts = $experts->getCollection()->where('is_featured', true)->count();
    $totalFollowers = (int) $experts->getCollection()->sum('followers');
    $averageWinRate = round((float) $experts->getCollection()->avg('win_rate'), 1);
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-500 transition-colors">Admin</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Copy Trading Desk</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Expert Trader <span class="gold-text">Management</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Manage the lead traders displayed on the copy marketplace, monitor performance quality, and control trader availability.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.copy.statistics') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 mr-2"></i>
                    Statistics
                </a>
                <a href="{{ route('admin.copy.active-trades') }}"
                    class="flex items-center px-6 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="activity" class="w-4 h-4 mr-2"></i>
                    Active Trades
                </a>
                <a href="{{ route('admin.copy.create') }}"
                    class="flex items-center px-6 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="plus-circle" class="w-4 h-4 mr-2"></i>
                    Add Expert
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-emerald-400/25 bg-emerald-400/10 px-5 py-4 text-xs font-bold text-emerald-400 uppercase tracking-widest">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="rounded-2xl border border-rose-400/25 bg-rose-400/10 px-5 py-4 text-xs font-bold text-rose-400 uppercase tracking-widest">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Total Experts</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($totalExperts) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="users-2" class="w-3 h-3 mr-2 gold-text"></i>
                    {{ number_format($activeExperts) }} currently active
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Verified & Featured</span>
                <div class="text-3xl font-black gold-text tracking-tighter mb-2">{{ number_format($verifiedExperts) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="badge-check" class="w-3 h-3 mr-2 gold-text"></i>
                    {{ number_format($featuredExperts) }} featured on marketplace
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Audience Reach</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($totalFollowers) }}</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="radio" class="w-3 h-3 mr-2 gold-text"></i>
                    combined marketplace followers
                </div>
            </div>

            <div class="dashboard-glass p-6 sm:p-8 relative overflow-hidden group hover:border-yellow-500/20 transition-all">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-yellow-500/5 blur-[50px] pointer-events-none group-hover:bg-yellow-500/10 transition-all"></div>
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Average Win Rate</span>
                <div class="text-3xl font-black text-white tracking-tighter mb-2">{{ number_format($averageWinRate, 1) }}%</div>
                <div class="flex items-center text-[10px] font-bold text-slate-400 uppercase">
                    <i data-lucide="target" class="w-3 h-3 mr-2 gold-text"></i>
                    across visible expert profiles
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 dashboard-glass overflow-hidden">
                <div class="p-8 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div>
                        <h3 class="text-lg font-black uppercase tracking-tight">Expert Trader Board</h3>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Performance, status, pricing, and copy activity</p>
                    </div>
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ number_format($experts->count()) }} loaded</span>
                </div>

                @if($experts->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 border-b border-white/5">
                                    <th class="px-8 py-5">Expert</th>
                                    <th class="px-8 py-5">Performance</th>
                                    <th class="px-8 py-5">Followers</th>
                                    <th class="px-8 py-5">Min Allocation</th>
                                    <th class="px-8 py-5">Status</th>
                                    <th class="px-8 py-5 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @foreach($experts as $expert)
                                    @php
                                        $avatar = $expert->photo ? asset('storage/' . $expert->photo) : null;
                                        $riskLevel = ucfirst((string) ($expert->risk_level ?: 'Medium'));
                                        $roiValue = $expert->monthly_roi ?? $expert->total_profit ?? 0;
                                    @endphp
                                    <tr class="group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-8 py-6">
                                            <div class="flex items-center space-x-4">
                                                @if($avatar)
                                                    <img src="{{ $avatar }}" class="w-12 h-12 rounded-2xl object-cover border border-white/10"
                                                        alt="{{ $expert->name }}">
                                                @else
                                                    <div class="w-12 h-12 rounded-2xl bg-black border border-white/10 flex items-center justify-center text-white font-black">
                                                        {{ strtoupper(substr($expert->name, 0, 1)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="flex items-center gap-2 flex-wrap">
                                                        <p class="text-sm font-bold text-white">{{ $expert->name }}</p>
                                                        @if($expert->verification_status === 'verified')
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[9px] font-black text-emerald-400 uppercase tracking-widest">
                                                                Verified
                                                            </span>
                                                        @endif
                                                        @if($expert->is_featured)
                                                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-yellow-500/10 border border-yellow-500/20 text-[9px] font-black text-yellow-400 uppercase tracking-widest">
                                                                Featured
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">
                                                        {{ $expert->tag ?: ($expert->strategy_type ?: 'Expert Trader') }}
                                                    </p>
                                                    <div class="flex items-center gap-3 mt-2 flex-wrap">
                                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ number_format((float) $expert->win_rate, 0) }}% win</span>
                                                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $riskLevel }} risk</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="space-y-2">
                                                <div class="text-sm font-black {{ (float) $roiValue >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                                    {{ (float) $roiValue >= 0 ? '+' : '' }}{{ number_format((float) $roiValue, 2) }}%
                                                </div>
                                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                                                    {{ number_format((float) ($expert->total_trades ?? 0)) }} trades
                                                </div>
                                                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                                    ${{ number_format((float) ($expert->aum ?? $expert->equity ?? 0), 2) }} AUM / equity
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-sm font-black text-white">{{ number_format((int) ($expert->followers ?? 0)) }}</div>
                                            <div class="text-[10px] font-black uppercase tracking-widest text-emerald-400 mt-1">
                                                {{ number_format((int) ($expert->active_copiers_count ?? 0)) }} active
                                            </div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-sm font-black text-white">${{ number_format((float) ($expert->price ?? $expert->minimum_allocation ?? 0), 2) }}</div>
                                            <div class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">minimum copy amount</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            @if($expert->status === 'active')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-[9px] font-black text-emerald-400 uppercase tracking-widest">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-500/10 border border-rose-500/20 text-[9px] font-black text-rose-400 uppercase tracking-widest">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.copy.edit', $expert->id) }}"
                                                    class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:text-white hover:border-yellow-500/30 transition-all"
                                                    title="Edit expert">
                                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                                </a>

                                                @if(($expert->active_copiers_count ?? 0) == 0)
                                                    <button type="button" onclick="deleteExpert({{ $expert->id }})"
                                                        class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 hover:bg-rose-500 hover:text-white transition-all"
                                                        title="Delete expert">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                @else
                                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-white/5 border border-white/10 text-slate-600 cursor-not-allowed"
                                                        title="Cannot delete expert with active copiers">
                                                        <i data-lucide="lock" class="w-4 h-4"></i>
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-8 py-5 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">
                            Showing {{ $experts->firstItem() ?? 0 }}-{{ $experts->lastItem() ?? 0 }} of {{ $experts->total() }} experts
                        </p>
                        <div>
                            {{ $experts->links() }}
                        </div>
                    </div>
                @else
                    <div class="py-20 text-center">
                        <i data-lucide="users-2" class="w-16 h-16 text-slate-700 mx-auto mb-6"></i>
                        <h3 class="text-lg font-black text-white uppercase tracking-widest">No Expert Traders Yet</h3>
                        <p class="text-slate-500 text-sm font-medium mt-2 max-w-lg mx-auto leading-relaxed">Create your first expert trader profile to activate the copy marketplace and start onboarding lead strategies.</p>
                        <a href="{{ route('admin.copy.create') }}"
                            class="mt-8 inline-flex items-center px-8 py-4 gold-gradient-bg rounded-xl text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-105 transition-all">
                            Add First Expert
                        </a>
                    </div>
                @endif
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass border-white/10 p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center">
                            <i data-lucide="sparkles" class="w-4 h-4 mr-3 gold-text"></i> Marketplace Controls
                        </h3>
                        <div class="flex items-center h-6 px-3 rounded-full bg-yellow-500/10 border border-yellow-500/20">
                            <span class="text-[8px] font-black gold-text uppercase tracking-widest">Premium</span>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <a href="{{ route('admin.copy.create') }}"
                            class="flex items-center justify-between group cursor-pointer hover:bg-white/[0.02] -mx-4 px-4 py-3 rounded-xl transition-all border border-transparent hover:border-white/5">
                            <div>
                                <div class="text-[11px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">Add Expert Profile</div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">Create a new trader listing</div>
                            </div>
                            <i data-lucide="plus-circle" class="w-4 h-4 text-emerald-400"></i>
                        </a>

                        <a href="{{ route('admin.copy.statistics') }}"
                            class="flex items-center justify-between group cursor-pointer hover:bg-white/[0.02] -mx-4 px-4 py-3 rounded-xl transition-all border border-transparent hover:border-white/5">
                            <div>
                                <div class="text-[11px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">Performance Statistics</div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">System-level copy metrics</div>
                            </div>
                            <i data-lucide="bar-chart-3" class="w-4 h-4 text-blue-400"></i>
                        </a>

                        <a href="{{ route('admin.copy.active-trades') }}"
                            class="flex items-center justify-between group cursor-pointer hover:bg-white/[0.02] -mx-4 px-4 py-3 rounded-xl transition-all border border-transparent hover:border-white/5">
                            <div>
                                <div class="text-[11px] font-black text-white uppercase tracking-tight group-hover:gold-text transition-colors">Active Copy Trades</div>
                                <div class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-1">Live subscriber positions</div>
                            </div>
                            <i data-lucide="activity" class="w-4 h-4 text-purple-400"></i>
                        </a>
                    </div>
                </div>

                <div class="dashboard-glass border-white/10 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] flex items-center">
                            <i data-lucide="scan-eye" class="w-4 h-4 mr-3 gold-text"></i> Quality Checks
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-4">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Verification Coverage</p>
                            <p class="mt-2 text-2xl font-black text-white">{{ number_format($verifiedExperts) }}</p>
                            <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">verified profiles on this page</p>
                        </div>

                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-4">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Featured Supply</p>
                            <p class="mt-2 text-2xl font-black text-white">{{ number_format($featuredExperts) }}</p>
                            <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">featured traders in current result set</p>
                        </div>

                        <div class="rounded-2xl border border-white/5 bg-black/30 px-5 py-4">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Active Availability</p>
                            <p class="mt-2 text-2xl font-black text-emerald-400">{{ number_format($activeExperts) }}</p>
                            <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">profiles open to copy subscriptions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteExpert(expertId) {
            Swal.fire({
                title: 'Delete Expert Trader?',
                text: 'This action cannot be undone. The expert trader will be permanently removed.',
                icon: 'warning',
                background: '#090b10',
                color: '#e2e8f0',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'rounded-3xl border border-white/10',
                    confirmButton: 'rounded-xl font-black uppercase tracking-wider px-6 py-3',
                    cancelButton: 'rounded-xl font-black uppercase tracking-wider px-6 py-3'
                }
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `${@json(url('/admin/copy'))}/${expertId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = @json(csrf_token());
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            });
        }
    </script>
@endpush
