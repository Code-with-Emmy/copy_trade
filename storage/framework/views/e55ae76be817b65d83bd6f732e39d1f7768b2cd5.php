
<?php $__env->startSection('title', 'Markets'); ?>
<?php $__env->startSection('content'); ?>

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000" x-data="tradingMarkets()" x-cloak>
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center space-x-2 text-slate-500 text-xs font-bold uppercase tracking-widest mb-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-yellow-500 transition-colors">Dashboard</a>
                    <i data-lucide="chevron-right" class="w-3 h-3"></i>
                    <span class="text-slate-300">Live Markets</span>
                </div>
                <h1 class="text-3xl font-black text-white tracking-tight"><span class="gold-text">Markets</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Real-time prices from international markets.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                <div class="relative group">
                    <input type="text" x-model="searchQuery" placeholder="SEARCH SYMBOL..."
                        class="w-full sm:w-64 h-12 bg-white/5 border border-white/10 rounded-xl pl-12 pr-4 text-[10px] font-black uppercase tracking-widest text-white placeholder:text-slate-600 focus:outline-none focus:border-yellow-500/50 transition-all">
                    <i data-lucide="search"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:text-yellow-500 transition-colors"></i>
                </div>

                <div class="h-12 px-6 rounded-xl bg-white/5 border border-white/10 flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-[9px] font-black text-slate-600 uppercase">Assets</span>
                        <span class="text-[10px] font-black text-white" x-text="totalMarkets"></span>
                    </div>
                    <div class="w-px h-4 bg-white/10"></div>
                    <div class="flex items-center space-x-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest">Live Data</span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('danger-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.success-alert','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('success-alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

        <!-- Asset Class Selectors -->
        <div class="dashboard-glass border-white/5 p-2 overflow-x-auto no-scrollbar">
            <div class="flex items-center space-x-2 min-w-max">
                <button @click="selectedType = 'all'" :class="selectedType === 'all' ? 'bg-yellow-500 text-black shadow-lg shadow-yellow-500/10' :
                                'text-slate-500 hover:text-white hover:bg-white/5'"
                    class="h-12 px-6 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all flex items-center space-x-3">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span>All Assets</span>
                </button>

                <?php $__currentLoopData = ['crypto' => 'Cryptocurrency', 'stock' => 'Stocks', 'forex' => 'Forex', 'commodity' => 'Commodities', 'bond' => 'Bonds']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button @click="selectedType = '<?php echo e($type); ?>'" :class="selectedType === '<?php echo e($type); ?>' ? 'bg-white/10 text-white border-white/10' :
                                            'text-slate-500 hover:text-slate-300 hover:bg-white/5'"
                        class="h-12 px-6 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all border border-transparent flex items-center space-x-3">
                        <i data-lucide="<?php echo e($type === 'crypto' ? 'bitcoin' : ($type === 'stock' ? 'trending-up' : ($type === 'forex' ? 'globe' : ($type === 'commodity' ? 'zap' : 'landmark')))); ?>"
                            class="w-4 h-4"></i>
                        <span><?php echo e($label); ?></span>
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- Market Grid -->
        <div class="space-y-12">
            <!-- Loading State -->
            <div x-show="loading" class="flex flex-col items-center justify-center py-20 space-y-6">
                <div
                    class="h-16 w-16 rounded-3xl bg-black border border-white/10 flex items-center justify-center relative">
                    <div class="absolute inset-0 bg-yellow-500/5 blur-xl animate-pulse"></div>
                    <i data-lucide="refresh-cw" class="w-8 h-8 gold-text animate-spin"></i>
                </div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em]">Loading Market Data...</p>
            </div>

            <!-- Empty State -->
            <div x-show="!loading && filteredMarkets.length === 0"
                class="dashboard-glass border-white/5 py-24 text-center">
                <i data-lucide="search-x" class="w-16 h-16 text-slate-800 mx-auto mb-6"></i>
                <h3 class="text-xl font-black text-white uppercase tracking-widest">No Results Found</h3>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-2">No assets matching your search
                    were found.</p>
                <button @click="searchQuery = ''; selectedType = 'all'"
                    class="mt-8 px-8 py-3 rounded-xl bg-white/5 border border-white/10 text-slate-300 font-black text-[10px] uppercase tracking-widest hover:bg-white/10 transition-all">Reset
                    Search</button>
            </div>

            <!-- Market List -->
            <template x-for="(typeGroup, type) in groupedMarkets" :key="type">
                <div x-show="(selectedType === 'all' || selectedType === type) && typeGroup.length > 0" class="space-y-6">
                    <!-- Category Header -->
                    <div class="flex items-center space-x-4 px-2">
                        <div class="h-8 w-8 rounded-lg bg-black border border-white/10 flex items-center justify-center">
                            <i :data-lucide="getTypeIcon(type)" class="w-4 h-4 gold-text"></i>
                        </div>
                        <h2 class="text-xs font-black text-white uppercase tracking-[0.2em]"
                            x-text="getTypeDisplayName(type)"></h2>
                        <div class="flex-1 h-px bg-white/5"></div>
                    </div>

                    <div class="dashboard-glass border-white/5 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="text-[9px] font-black uppercase tracking-widest text-slate-500 border-b border-white/5 bg-white/[0.01]">
                                        <th class="px-8 py-5">Asset</th>
                                        <th class="px-6 py-5">Price</th>
                                        <th class="px-6 py-5">24H Change</th>
                                        <th class="px-6 py-5 hidden md:table-cell">24H Volume</th>
                                        <th class="px-8 py-5 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <template x-for="instrument in typeGroup" :key="instrument.id">
                                        <tr class="group hover:bg-white/[0.02] transition-colors">
                                            <td class="px-8 py-6">
                                                <div class="flex items-center space-x-4">
                                                    <div
                                                        class="h-12 w-12 rounded-xl bg-black border border-white/5 p-2 flex items-center justify-center group-hover:border-yellow-500/20 transition-all">
                                                        <template x-if="instrument.logo">
                                                            <img :src="instrument.logo" :alt="instrument.name"
                                                                class="w-full h-full object-contain">
                                                        </template>
                                                        <template x-if="!instrument.logo">
                                                            <span class="text-xs font-black gold-text"
                                                                x-text="instrument.symbol.substring(0, 2)"></span>
                                                        </template>
                                                    </div>
                                                    <div>
                                                        <div class="text-xs font-black text-white uppercase tracking-tight"
                                                            x-text="instrument.name"></div>
                                                        <div class="text-[9px] font-bold text-slate-600 uppercase tracking-widest"
                                                            x-text="instrument.symbol"></div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-6">
                                                <div class="text-xs font-black text-white font-mono"
                                                    x-text="formatPrice(instrument.price)"></div>
                                            </td>

                                            <td class="px-6 py-6">
                                                <div class="flex flex-col items-start gap-1">
                                                    <span :class="instrument.percent_change_24h >= 0 ? 'text-emerald-400' :
                                                                    'text-rose-400'"
                                                        class="text-[10px] font-black font-mono flex items-center space-x-1">
                                                        <i :data-lucide="instrument.percent_change_24h >= 0 ? 'trending-up' :
                                                                    'trending-down'" class="w-3 h-3"></i>
                                                        <span
                                                            x-text="formatPercentage(instrument.percent_change_24h)"></span>
                                                    </span>
                                                    <span class="text-[9px] font-bold text-slate-600 font-mono"
                                                        x-text="formatChange(instrument.change)"></span>
                                                </div>
                                            </td>

                                            <td class="px-6 py-6 hidden md:table-cell">
                                                <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest"
                                                    x-text="formatVolume(instrument.volume)"></div>
                                            </td>

                                            <td class="px-8 py-6 text-right">
                                                <a :href="`<?php echo e(route('trade.single', '')); ?>/${instrument.id}`"
                                                    class="inline-flex items-center px-6 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white font-black text-[9px] uppercase tracking-widest hover:gold-gradient-bg hover:text-black hover:border-transparent transition-all group/btn">
                                                    <span>Trade</span>
                                                    <i data-lucide="arrow-right"
                                                        class="w-3 h-3 ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function tradingMarkets() {
            return {
                instruments: <?php echo json_encode($instruments ?? [], 15, 512) ?>,
                selectedType: 'all',
                searchQuery: '',
                loading: false,

                get totalMarkets() {
                    return this.instruments.length;
                },

                get filteredMarkets() {
                    let filtered = this.instruments;

                    if (this.searchQuery) {
                        const query = this.searchQuery.toLowerCase();
                        filtered = filtered.filter(instrument =>
                            instrument.name.toLowerCase().includes(query) ||
                            instrument.symbol.toLowerCase().includes(query)
                        );
                    }

                    if (this.selectedType !== 'all') {
                        filtered = filtered.filter(instrument => instrument.type === this.selectedType);
                    }

                    return filtered;
                },

                get groupedMarkets() {
                    const grouped = {};
                    this.filteredMarkets.forEach(instrument => {
                        if (!grouped[instrument.type]) {
                            grouped[instrument.type] = [];
                        }
                        grouped[instrument.type].push(instrument);
                    });

                    Object.keys(grouped).forEach(type => {
                        grouped[type].sort((a, b) => (parseFloat(b.volume) || 0) - (parseFloat(a.volume) ||
                            0));
                    });

                    return grouped;
                },

                getTypeIcon(type) {
                    const icons = {
                        'crypto': 'bitcoin',
                        'stock': 'trending-up',
                        'forex': 'globe',
                        'commodity': 'zap',
                        'bond': 'landmark'
                    };
                    return icons[type] || 'layer-group';
                },

                getTypeDisplayName(type) {
                    const names = {
                        'crypto': 'Cryptocurrencies',
                        'stock': 'Stocks',
                        'forex': 'Forex',
                        'commodity': 'Commodities',
                        'bond': 'Bonds'
                    };
                    return names[type] || type;
                },

                formatPrice(price) {
                    if (!price) return 'INF';
                    const num = parseFloat(price);
                    if (num >= 1) {
                        return '$' + num.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    } else {
                        return '$' + num.toFixed(6);
                    }
                },

                formatPercentage(percent) {
                    if (!percent) return '0.00%';
                    const num = parseFloat(percent);
                    return (num >= 0 ? '+' : '') + num.toFixed(2) + '%';
                },

                formatChange(change) {
                    if (!change) return '$0.00';
                    const num = parseFloat(change);
                    return (num >= 0 ? '+' : '-') + '$' + Math.abs(num).toFixed(2);
                },

                formatVolume(volume) {
                    if (!volume) return 'N/R';
                    const num = parseFloat(volume);
                    if (num >= 1e9) return (num / 1e9).toFixed(1) + 'B';
                    if (num >= 1e6) return (num / 1e6).toFixed(1) + 'M';
                    if (num >= 1e3) return (num / 1e3).toFixed(1) + 'K';
                    return num.toLocaleString();
                },

                init() {
                    this.$nextTick(() => {
                        lucide.createIcons();
                    });
                }
            }
        }

        document.addEventListener('alpine:updated', () => {
            lucide.createIcons();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dasht', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\hp\Downloads\CopyTrader\resources\views/user/trade/trade.blade.php ENDPATH**/ ?>