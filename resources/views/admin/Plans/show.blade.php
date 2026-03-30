@extends('layouts.admin-dasht')

@php
    $currency = data_get($settings, 'currency', '$');
@endphp

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-500 transition-colors">Admin</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('admin.plans.index') }}" class="hover:text-yellow-500 transition-colors">Plans</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">{{ $plan->name }}</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Investment Plan <span class="gold-text">Overview</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Inspect pricing, return profile, categories, feature stack, and enrolled investors for this plan.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.plans.edit', $plan) }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="pencil" class="w-4 h-4 mr-2"></i>
                    Edit Plan
                </a>
                <a href="{{ route('admin.plans.index') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Plans
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 sm:gap-6">
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Investment Range</span>
                <div class="text-2xl font-black text-white tracking-tighter mb-2">{{ $currency }}{{ number_format((float) $plan->min_price, 2) }} - {{ $currency }}{{ number_format((float) $plan->max_price, 2) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">minimum to maximum capital</div>
            </div>
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Return Range</span>
                <div class="text-2xl font-black text-emerald-400 tracking-tighter mb-2">{{ number_format((float) $plan->min_return, 2) }}% - {{ number_format((float) $plan->max_return, 2) }}%</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ ucfirst((string) $plan->profit_calculation) }} calculation</div>
            </div>
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Duration</span>
                <div class="text-2xl font-black text-white tracking-tighter mb-2">{{ $plan->duration }} {{ ucfirst((string) $plan->duration_type) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ ucfirst((string) $plan->payout_interval) }} payouts</div>
            </div>
            <div class="dashboard-glass p-6 sm:p-8">
                <span class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-4">Enrolled Investors</span>
                <div class="text-2xl font-black text-white tracking-tighter mb-2">{{ number_format($userPlans->total()) }}</div>
                <div class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $plan->active ? 'plan active' : 'plan inactive' }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.4fr)_380px] gap-8">
            <div class="space-y-8">
                <div class="dashboard-glass p-8">
                    <h2 class="text-lg font-black text-white uppercase tracking-tight mb-5">Plan Summary</h2>
                    <p class="text-sm text-slate-300 leading-7">{{ $plan->description ?: 'No extended description has been provided for this plan yet.' }}</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mt-8">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Categories</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($plan->categories as $category)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-slate-300">{{ $category->name }}</span>
                                @empty
                                    <span class="text-sm text-slate-500">No categories assigned.</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-5 py-5">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Commercial Flags</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full {{ $plan->featured ? 'bg-yellow-500/10 border-yellow-500/20 text-yellow-400' : 'bg-white/5 border-white/10 text-slate-400' }} border text-[10px] font-black uppercase tracking-widest">
                                    {{ $plan->featured ? 'Featured' : 'Standard' }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full {{ $plan->allow_compounding ? 'bg-emerald-500/10 border-emerald-500/20 text-emerald-400' : 'bg-white/5 border-white/10 text-slate-400' }} border text-[10px] font-black uppercase tracking-widest">
                                    {{ $plan->allow_compounding ? 'Compounding' : 'Simple only' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h2 class="text-lg font-black text-white uppercase tracking-tight">Plan Features</h2>
                    </div>
                    <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse ($plan->planFeatures as $feature)
                            <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4 flex items-start gap-3">
                                <i data-lucide="{{ $feature->included ? 'check-circle-2' : 'minus-circle' }}" class="w-5 h-5 {{ $feature->included ? 'text-emerald-400' : 'text-slate-500' }} mt-0.5"></i>
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $feature->feature }}</p>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-2">{{ $feature->included ? 'Included' : 'Not included' }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-6 text-sm text-slate-400">
                                No plan features have been configured yet.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="dashboard-glass overflow-hidden">
                    <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                        <h2 class="text-lg font-black text-white uppercase tracking-tight">Investor Enrollments</h2>
                    </div>
                    @if ($userPlans->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-600 border-b border-white/5">
                                        <th class="px-8 py-5">Investor</th>
                                        <th class="px-8 py-5">Amount</th>
                                        <th class="px-8 py-5">Profit</th>
                                        <th class="px-8 py-5">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    @foreach ($userPlans as $userPlan)
                                        <tr class="hover:bg-white/[0.02] transition-colors">
                                            <td class="px-8 py-5">
                                                <p class="text-sm font-semibold text-white">{{ data_get($userPlan, 'user.name', 'Unknown user') }}</p>
                                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mt-1">{{ data_get($userPlan, 'user.email', 'No email') }}</p>
                                            </td>
                                            <td class="px-8 py-5 text-sm font-black text-white">{{ $currency }}{{ number_format((float) ($userPlan->amount ?? $userPlan->invested_amount ?? 0), 2) }}</td>
                                            <td class="px-8 py-5 text-sm font-black text-emerald-400">{{ $currency }}{{ number_format((float) ($userPlan->total_profit ?? 0), 2) }}</td>
                                            <td class="px-8 py-5">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full border bg-white/5 border-white/10 text-[10px] font-black uppercase tracking-widest text-slate-300">
                                                    {{ ucfirst((string) ($userPlan->active ?? 'unknown')) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-8 py-5 border-t border-white/5">
                            {{ $userPlans->links() }}
                        </div>
                    @else
                        <div class="p-8 text-sm text-slate-400">No investors are enrolled in this plan yet.</div>
                    @endif
                </div>
            </div>

            <div class="space-y-8">
                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Quick Stats</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Slug</p>
                            <p class="text-sm font-semibold text-white">{{ $plan->slug }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Return Type</p>
                            <p class="text-sm font-semibold text-white">{{ ucfirst((string) $plan->return_type) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Color Scheme</p>
                            <p class="text-sm font-semibold text-white">{{ $plan->color_scheme ?: 'Default' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
