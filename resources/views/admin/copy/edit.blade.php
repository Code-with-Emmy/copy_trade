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
                    <span class="text-slate-300">Edit Expert</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight">Edit <span class="gold-text">Expert Trader</span></h1>
                <p class="text-slate-400 text-sm mt-2 max-w-2xl font-medium">
                    Update the trader’s public identity, performance metrics, and marketplace visibility without breaking active subscription records.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.copy.statistics') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">
                    <i data-lucide="bar-chart-3" class="w-4 h-4 mr-2"></i>
                    Statistics
                </a>
                <a href="{{ route('admin.copy.index') }}"
                    class="inline-flex items-center px-5 py-3 rounded-xl gold-gradient-bg text-black font-black text-[10px] uppercase tracking-widest shadow-xl shadow-yellow-500/10 hover:scale-[1.05] transition-all">
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
                    <h2 class="text-xl font-black text-white tracking-tight">Expert Trader Configuration</h2>
                    <p class="text-sm text-slate-400 mt-1">Editing {{ $expert->name }}. Existing subscriptions remain intact while marketplace-facing data is updated.</p>
                </div>

                <form action="{{ route('admin.copy.update', $expert->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
                    @csrf
                    @method('PUT')

                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Identity</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Public profile layer</span>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-[180px_minmax(0,1fr)] gap-6 items-start">
                            <div>
                                <label for="photo" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Profile Photo</label>
                                <div id="photo-preview"
                                    class="h-40 w-40 rounded-[28px] border border-dashed border-white/10 bg-white/[0.03] flex items-center justify-center overflow-hidden">
                                    @if ($expert->photo)
                                        <img src="{{ asset('storage/' . $expert->photo) }}" alt="{{ $expert->name }}" class="h-full w-full object-cover">
                                    @else
                                        <div class="text-center px-5">
                                            <i data-lucide="camera" class="w-8 h-8 text-slate-600 mx-auto mb-2"></i>
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Preview</p>
                                        </div>
                                    @endif
                                </div>
                                <input id="photo" name="photo" type="file" accept="image/*"
                                    class="mt-4 block w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-slate-300 file:mr-4 file:rounded-xl file:border-0 file:bg-yellow-500 file:px-4 file:py-2 file:text-xs file:font-black file:uppercase file:tracking-widest file:text-black hover:file:bg-yellow-400"
                                    onchange="previewPhoto(event)">
                                <p class="mt-2 text-xs text-slate-500">Leave empty to keep the existing image.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="md:col-span-2">
                                    <label for="name" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Expert Name</label>
                                    <input id="name" name="name" type="text" required value="{{ old('name', $expert->name) }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>

                                <div>
                                    <label for="tag" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Public Tag</label>
                                    <input id="tag" name="tag" type="text" value="{{ old('tag', $expert->tag) }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>

                                <div>
                                    <label for="strategy_type" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Strategy Type</label>
                                    <input id="strategy_type" name="strategy_type" type="text" value="{{ old('strategy_type', $expert->strategy_type) }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>

                                <div>
                                    <label for="trading_style" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Trading Style</label>
                                    <input id="trading_style" name="trading_style" type="text" value="{{ old('trading_style', $expert->trading_style) }}"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                </div>

                                <div>
                                    <label for="risk_level" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Risk Level</label>
                                    <select id="risk_level" name="risk_level"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        @foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'very high' => 'Very High'] as $value => $label)
                                            <option value="{{ $value }}" @selected(old('risk_level', $expert->risk_level) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="verification_status" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Verification</label>
                                    <select id="verification_status" name="verification_status"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                        <option value="pending" @selected(old('verification_status', $expert->verification_status) === 'pending')>Pending</option>
                                        <option value="verified" @selected(old('verification_status', $expert->verification_status) === 'verified')>Verified</option>
                                        <option value="rejected" @selected(old('verification_status', $expert->verification_status) === 'rejected')>Rejected</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="description" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">{{ old('description', $expert->description) }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="bio" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Extended Bio</label>
                                    <textarea id="bio" name="bio" rows="3"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white placeholder:text-slate-600 focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">{{ old('bio', $expert->bio) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400">Metrics & Commercials</h3>
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Discovery and pricing inputs</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
                            <div>
                                <label for="rating" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Rating</label>
                                <select id="rating" name="rating" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}" @selected((int) old('rating', $expert->rating) === $i)>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label for="win_rate" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Win Rate (%)</label>
                                <input id="win_rate" name="win_rate" type="number" min="0" max="100" required value="{{ old('win_rate', $expert->win_rate) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="followers" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Followers</label>
                                <input id="followers" name="followers" type="number" min="0" value="{{ old('followers', $expert->followers) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="total_profit" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Total Profit (%)</label>
                                <input id="total_profit" name="total_profit" type="number" step="0.01" min="0" required value="{{ old('total_profit', $expert->total_profit) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="monthly_roi" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Monthly ROI (%)</label>
                                <input id="monthly_roi" name="monthly_roi" type="number" step="0.01" value="{{ old('monthly_roi', $expert->monthly_roi) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="yearly_roi" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Yearly ROI (%)</label>
                                <input id="yearly_roi" name="yearly_roi" type="number" step="0.01" value="{{ old('yearly_roi', $expert->yearly_roi) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="max_drawdown" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Max Drawdown (%)</label>
                                <input id="max_drawdown" name="max_drawdown" type="number" step="0.01" min="0" value="{{ old('max_drawdown', $expert->max_drawdown) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="equity" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Current Equity ($)</label>
                                <input id="equity" name="equity" type="number" step="0.01" min="0" required value="{{ old('equity', $expert->equity) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="aum" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">AUM ($)</label>
                                <input id="aum" name="aum" type="number" step="0.01" min="0" value="{{ old('aum', $expert->aum) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="total_trades" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Total Trades</label>
                                <input id="total_trades" name="total_trades" type="number" min="0" required value="{{ old('total_trades', $expert->total_trades) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="price" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Entry Price ($)</label>
                                <input id="price" name="price" type="number" step="0.01" min="1" required value="{{ old('price', $expert->price) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="minimum_allocation" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Minimum Allocation ($)</label>
                                <input id="minimum_allocation" name="minimum_allocation" type="number" step="0.01" min="0" value="{{ old('minimum_allocation', $expert->minimum_allocation) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="maximum_allocation" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Maximum Allocation ($)</label>
                                <input id="maximum_allocation" name="maximum_allocation" type="number" step="0.01" min="0" value="{{ old('maximum_allocation', $expert->maximum_allocation) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="management_fee_percent" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Management Fee (%)</label>
                                <input id="management_fee_percent" name="management_fee_percent" type="number" step="0.01" min="0" max="100" value="{{ old('management_fee_percent', $expert->management_fee_percent) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="performance_fee_percent" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Performance Fee (%)</label>
                                <input id="performance_fee_percent" name="performance_fee_percent" type="number" step="0.01" min="0" max="100" value="{{ old('performance_fee_percent', $expert->performance_fee_percent) }}"
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                            </div>
                            <div>
                                <label for="status" class="block text-[11px] font-black uppercase tracking-[0.22em] text-slate-400 mb-3">Status</label>
                                <select id="status" name="status" required
                                    class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-4 text-sm text-white focus:border-yellow-500/40 focus:outline-none focus:ring-2 focus:ring-yellow-500/10">
                                    <option value="active" @selected(old('status', $expert->status) === 'active')>Active</option>
                                    <option value="inactive" @selected(old('status', $expert->status) === 'inactive')>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <label class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] px-4 py-4 cursor-pointer">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $expert->is_featured))
                                class="h-4 w-4 rounded border-white/20 bg-black text-yellow-500 focus:ring-yellow-500/30">
                            <div>
                                <span class="block text-sm font-bold text-white">Feature this trader</span>
                                <span class="block text-xs text-slate-500 mt-1">Featured experts appear in discovery priority blocks and premium landing sections.</span>
                            </div>
                        </label>
                    </section>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 pt-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center px-7 py-4 rounded-2xl gold-gradient-bg text-black font-black text-[11px] uppercase tracking-[0.22em] shadow-xl shadow-yellow-500/10 hover:scale-[1.02] transition-all">
                            <i data-lucide="save" class="w-4 h-4 mr-2"></i>
                            Save Expert Trader
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
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Current Snapshot</h3>
                    <div class="space-y-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Expert name</p>
                            <p class="text-sm font-semibold text-white">{{ $expert->name }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Status</p>
                            <p class="text-sm font-semibold text-white">{{ ucfirst((string) $expert->status) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Followers</p>
                            <p class="text-sm font-semibold text-white">{{ number_format((int) $expert->followers) }}</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.02] px-4 py-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">Active subscriptions</p>
                            <p class="text-sm font-semibold text-white">{{ number_format((int) ($expert->active_copiers_count ?? 0)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="dashboard-glass p-7">
                    <h3 class="text-[11px] font-black uppercase tracking-[0.26em] text-slate-400 mb-5">Operational Notes</h3>
                    <div class="space-y-4 text-sm text-slate-300">
                        <div class="flex gap-3">
                            <i data-lucide="shield-check" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Do not deactivate traders with live subscriptions unless you want them hidden from new discovery.</p>
                        </div>
                        <div class="flex gap-3">
                            <i data-lucide="line-chart" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Keep ROI, drawdown, and fee fields aligned with your public disclosures and investor trust messaging.</p>
                        </div>
                        <div class="flex gap-3">
                            <i data-lucide="sparkles" class="w-4 h-4 gold-text mt-0.5"></i>
                            <p>Featured placement should be reserved for traders with reliable analytics and clean risk profiles.</p>
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
