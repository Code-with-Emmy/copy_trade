@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-5">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-500 transition-colors">Admin</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <a href="{{ route('admin.copy.index') }}" class="hover:text-yellow-500 transition-colors">Copy Trading</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Add Expert</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Create <span class="gold-text">Expert Trader</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Add a new lead trader to the marketplace with clear performance data, pricing, verification state, and risk controls.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.copy.active-trades') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="activity" class="w-4 h-4 mr-2"></i>
                    Active Trades
                </a>
                <a href="{{ route('admin.copy.index') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Back to Board
                </a>
            </div>
        </div>

        @if ($errors->any())
            <div class="rounded-2xl border border-rose-400/20 bg-rose-500/10 px-5 py-4">
                <p class="text-[10px] font-black uppercase tracking-[0.22em] text-rose-300 mb-2">Please fix the highlighted fields</p>
                <ul class="space-y-1 text-sm text-rose-100">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-[minmax(0,1.4fr)_380px] gap-8">
            <div class="dashboard-glass overflow-hidden">
                <div class="px-8 py-7 border-b border-white/5 bg-white/[0.02]">
                    <h2 class="text-xl font-black text-white tracking-tight">Expert Profile Setup</h2>
                    <p class="text-sm text-slate-400 mt-1">Complete the minimum required trading details and enrich the public profile with premium marketplace metadata.</p>
                </div>

                <form action="{{ route('admin.copy.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
                    @csrf

                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Identity</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Marketplace-facing</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-[180px_minmax(0,1fr)] gap-6 items-start">
                            <div>
                                <label for="photo" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Profile Photo</label>
                                <div id="photo-preview"
                                    class="h-40 w-40 rounded-[28px] border border-dashed border-white/10 bg-white/[0.03] flex items-center justify-center overflow-hidden">
                                    <div class="text-center px-5">
                                        <i data-lucide="camera" class="w-8 h-8 text-slate-600 mx-auto mb-2"></i>
                                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Preview</p>
                                    </div>
                                </div>
                                <input id="photo" name="photo" type="file" accept="image/*"
                                    class="mt-4 block w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-slate-300 file:mr-4 file:rounded-xl file:border-0 file:bg-yellow-500 file:px-4 file:py-2 file:text-xs file:font-black file:uppercase file:tracking-widest file:text-black hover:file:bg-yellow-400"
                                    onchange="previewPhoto(event)">
                                <p class="mt-2 text-xs text-slate-500">Accepted: JPG, PNG, GIF up to 2MB.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Expert Name</label>
                                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="e.g. Alexandra Chen">
                                </div>

                                <div>
                                    <label for="tag" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Public Tag</label>
                                    <input id="tag" name="tag" type="text" value="{{ old('tag') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Crypto Macro Specialist">
                                </div>

                                <div>
                                    <label for="strategy_type" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Strategy Type</label>
                                    <input id="strategy_type" name="strategy_type" type="text" value="{{ old('strategy_type') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Trend Following">
                                </div>

                                <div>
                                    <label for="trading_style" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Trading Style</label>
                                    <input id="trading_style" name="trading_style" type="text" value="{{ old('trading_style') }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Swing Trading">
                                </div>

                                <div>
                                    <label for="risk_level" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Risk Level</label>
                                    <select id="risk_level" name="risk_level"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="">Select risk level</option>
                                        @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'very high' => 'Very High'] as $value => $label)
                                            <option value="{{ $value }}" @selected(old('risk_level') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="verification_status" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Verification</label>
                                    <select id="verification_status" name="verification_status"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="pending" @selected(old('verification_status', 'pending') === 'pending')>Pending</option>
                                        <option value="verified" @selected(old('verification_status') === 'verified')>Verified</option>
                                        <option value="rejected" @selected(old('verification_status') === 'rejected')>Rejected</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Marketplace Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Short overview of the trader's edge, discipline, and market focus.">{{ old('description') }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="bio" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Extended Bio</label>
                                    <textarea id="bio" name="bio" rows="3"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                        placeholder="Optional premium profile bio for public trader pages.">{{ old('bio') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Performance Metrics</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Required for ranking</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            <div>
                                <label for="rating" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Rating</label>
                                <select id="rating" name="rating" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="">Select rating</option>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" @selected((int) old('rating') === $i)>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label for="win_rate" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Win Rate (%)</label>
                                <input id="win_rate" name="win_rate" type="number" min="0" max="100" required value="{{ old('win_rate') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="74">
                            </div>

                            <div>
                                <label for="followers" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Followers</label>
                                <input id="followers" name="followers" type="number" min="0" value="{{ old('followers', 0) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="1280">
                            </div>

                            <div>
                                <label for="total_profit" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Total Profit (%)</label>
                                <input id="total_profit" name="total_profit" type="number" step="0.01" min="0" required value="{{ old('total_profit') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="124.60">
                            </div>

                            <div>
                                <label for="monthly_roi" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Monthly ROI (%)</label>
                                <input id="monthly_roi" name="monthly_roi" type="number" step="0.01" value="{{ old('monthly_roi') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="12.40">
                            </div>

                            <div>
                                <label for="yearly_roi" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Yearly ROI (%)</label>
                                <input id="yearly_roi" name="yearly_roi" type="number" step="0.01" value="{{ old('yearly_roi') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="88.30">
                            </div>

                            <div>
                                <label for="max_drawdown" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Max Drawdown (%)</label>
                                <input id="max_drawdown" name="max_drawdown" type="number" step="0.01" min="0" value="{{ old('max_drawdown') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="8.20">
                            </div>

                            <div>
                                <label for="equity" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Current Equity ($)</label>
                                <input id="equity" name="equity" type="number" step="0.01" min="0" required value="{{ old('equity') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="50000">
                            </div>

                            <div>
                                <label for="aum" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">AUM ($)</label>
                                <input id="aum" name="aum" type="number" step="0.01" min="0" value="{{ old('aum') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="840000">
                            </div>

                            <div>
                                <label for="total_trades" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Total Trades</label>
                                <input id="total_trades" name="total_trades" type="number" min="0" required value="{{ old('total_trades') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="1640">
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Commercial Settings</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Copy subscription controls</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            <div>
                                <label for="price" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Entry Price ($)</label>
                                <input id="price" name="price" type="number" step="0.01" min="1" required value="{{ old('price') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="150">
                            </div>

                            <div>
                                <label for="minimum_allocation" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Minimum Allocation ($)</label>
                                <input id="minimum_allocation" name="minimum_allocation" type="number" step="0.01" min="0" value="{{ old('minimum_allocation') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="250">
                            </div>

                            <div>
                                <label for="maximum_allocation" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Maximum Allocation ($)</label>
                                <input id="maximum_allocation" name="maximum_allocation" type="number" step="0.01" min="0" value="{{ old('maximum_allocation') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="10000">
                            </div>

                            <div>
                                <label for="management_fee_percent" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Management Fee (%)</label>
                                <input id="management_fee_percent" name="management_fee_percent" type="number" step="0.01" min="0" max="100" value="{{ old('management_fee_percent') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="2.50">
                            </div>

                            <div>
                                <label for="performance_fee_percent" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Performance Fee (%)</label>
                                <input id="performance_fee_percent" name="performance_fee_percent" type="number" step="0.01" min="0" max="100" value="{{ old('performance_fee_percent') }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10"
                                    placeholder="15">
                            </div>

                            <div>
                                <label for="status" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Status</label>
                                <select id="status" name="status" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                                    <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <label class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-4 cursor-pointer">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured'))
                                class="h-4 w-4 rounded border-white/20 bg-black text-yellow-500 focus:ring-yellow-500/30">
                            <div>
                                <span class="block text-sm font-bold text-white">Feature this trader on the marketplace</span>
                                <span class="block text-xs text-slate-500 mt-1">Featured experts appear first in discovery and homepage sections.</span>
                            </div>
                        </label>
                    </section>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-7 py-4 rounded-2xl gold-gradient-bg text-black font-black text-[11px] uppercase tracking-[0.22em] shadow-xl shadow-yellow-500/10 hover:scale-[1.02] transition-all">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                            Create Expert Trader
                        </button>
                        <a href="{{ route('admin.copy.index') }}"
                            class="inline-flex items-center justify-center px-7 py-4 rounded-2xl bg-white/5 border border-white/10 text-slate-300 font-black text-[11px] uppercase tracking-[0.22em] hover:bg-white/10 transition-all">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <div class="space-y-6">
                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Publishing Checklist</h3>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex gap-3">
                            <i data-lucide="badge-check" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Use a real profile image and clear display name to improve investor trust and conversion.</p>
                        </div>
                        <div class="flex gap-3">
                            <i data-lucide="shield-check" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Set verification status accurately. Verified traders are surfaced more prominently.</p>
                        </div>
                        <div class="flex gap-3">
                            <i data-lucide="bar-chart-3" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Performance metrics should match the public profile and risk disclosures shown to investors.</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Suggested Defaults</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Balanced retail profile</p>
                            <p class="text-sm text-white font-semibold">Minimum allocation: $250</p>
                            <p class="text-xs text-slate-500 mt-1">Use for mainstream forex and crypto swing traders.</p>
                        </div>
                        <div class="rounded-2xl border border-white/5 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Pro audience profile</p>
                            <p class="text-sm text-white font-semibold">Performance fee: 10% to 20%</p>
                            <p class="text-xs text-slate-500 mt-1">Higher-fee traders should show stable ROI and controlled drawdown.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewPhoto(event) {
            const input = event.target;
            const preview = document.getElementById('photo-preview');

            if (!input.files || !input.files[0]) {
                preview.innerHTML = `
                    <div class="text-center px-5">
                        <i data-lucide="camera" class="w-8 h-8 text-slate-600 mx-auto mb-2"></i>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Preview</p>
                    </div>
                `;
                lucide.createIcons();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Photo preview" class="h-full w-full object-cover">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection
