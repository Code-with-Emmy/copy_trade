<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Global Asset Markets | {{ $settings->site_name ?? config('app.name') }} Institutional</title>
	<link rel="stylesheet" href="{{ asset('styles.css') }}">
	<link rel="icon" href="{{ asset('storage/' . $settings->favicon) }}" type="image/x-icon">
	<script src="https://cdn.tailwindcss.com"></script>
	<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
	<script src="https://unpkg.com/lucide@latest"></script>

	<style>
		:root {
			--bg-dark: #000000;
			--accent-gold: #f0b90a;
			--glass-bg: rgba(255, 255, 255, 0.03);
			--glass-border: rgba(255, 255, 255, 0.1);
		}

		body {
			background-color: var(--bg-dark);
			color: #ffffff;
			font-family: 'Inter', -apple-system, sans-serif;
		}

		.market-glass {
			background: var(--glass-bg);
			backdrop-filter: blur(12px);
			border: 1px solid var(--glass-border);
			border-radius: 24px;
		}

		.gold-text {
			color: var(--accent-gold);
		}

		.gold-gradient {
			background: linear-gradient(135deg, #f0b90a, #d4a017);
		}

		.animate-float {
			animation: float 6s ease-in-out infinite;
		}

		@keyframes float {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-10px);
			}
		}

		/* Nav hover effect */
		.nav-link-premium {
			position: relative;
			transition: color 0.3s ease;
		}

		.nav-link-premium::after {
			content: '';
			position: absolute;
			bottom: -4px;
			left: 0;
			width: 0;
			height: 2px;
			background: var(--accent-gold);
			transition: width 0.3s ease;
		}

		.nav-link-premium:hover::after {
			width: 100%;
		}

		.custom-scrollbar::-webkit-scrollbar {
			width: 4px;
		}

		.custom-scrollbar::-webkit-scrollbar-track {
			background: transparent;
		}

		.custom-scrollbar::-webkit-scrollbar-thumb {
			background: rgba(255, 255, 255, 0.1);
			border-radius: 10px;
		}
	</style>
</head>

<body class="antialiased selection:bg-yellow-500/30">

	<!-- Premium Header -->
	<header
		class="fixed top-0 left-0 right-0 z-[100] bg-black/60 backdrop-blur-xl border-b border-white/5 h-20 flex items-center">
		<div class="container mx-auto px-6 flex items-center justify-between">
			<a href="{{ route('home') }}" class="flex items-center space-x-3">
				<img src="{{ asset('storage/' . $settings->logo)}}" alt="{{ $settings->site_name ?? config('app.name') }}" class="h-9 w-auto">
			</a>

			<nav class="hidden lg:flex items-center space-x-10">
				<a href="{{ route('home') }}"
					class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-white nav-link-premium">Home</a>
				<a href="{{ route('markets') }}"
					class="text-[11px] font-black uppercase tracking-[0.2em] gold-text nav-link-premium">Markets</a>
				<a href="{{ route('about') }}"
					class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-white nav-link-premium">Company</a>
				<a href="{{ route('education') }}"
					class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-white nav-link-premium">Academy</a>
			</nav>

			<div class="flex items-center space-x-6">
				<a href="{{ route('login') }}"
					class="text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-white transition-colors">Sign
					In</a>
				<a href="{{ route('register') }}"
					class="h-11 px-8 rounded-full gold-gradient text-black text-[11px] font-black uppercase tracking-[0.2em] flex items-center shadow-2xl shadow-yellow-500/20 hover:scale-105 transition-transform">
					Initialize Account
				</a>
			</div>
		</div>
	</header>

	<main class="pt-32 pb-24">
		<div class="container mx-auto px-6">

			<!-- Hero Stats / Market Overview -->
			<div
				class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-20 animate-in fade-in slide-in-from-bottom-8 duration-700">
				<div class="lg:col-span-2 space-y-4">
					<h1 class="text-5xl lg:text-7xl font-black italic tracking-tighter uppercase leading-none">
						Real-time <br>
						<span class="gold-text">Global Assets</span>
					</h1>
					<p class="text-slate-500 text-lg max-w-xl font-medium leading-relaxed">
						Access institutional-grade liquidity across 1,500+ instruments including Forex, Crypto, Indices,
						and Equity Markets.
					</p>
				</div>

				<div class="market-glass p-8 flex flex-col justify-between border-yellow-500/20">
					<div class="flex items-center justify-between mb-8">
						<span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">BTC
							Dominance</span>
						<span class="text-xs font-black text-emerald-400 uppercase tracking-widest">Live Node</span>
					</div>
					<div>
						<div class="text-4xl font-black italic tracking-tighter gold-text mb-2">52.4%</div>
						<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-relaxed">
							Primary digital asset liquidity concentration across institutional hubs.
						</p>
					</div>
				</div>
			</div>

			<!-- Market Explorer Section -->
			<div x-data="marketExplorer()" class="space-y-10">

				<!-- Asset Class Filter -->
				<div class="flex items-center space-x-4 overflow-x-auto pb-4 no-scrollbar">
					<template x-for="category in categories" :key="category.id">
						<button @click="activeCategory = category.id"
							:class="activeCategory === category.id ? 'gold-gradient text-black' : 'bg-white/5 text-slate-400 border-white/5 hover:border-white/10'"
							class="h-12 px-8 rounded-2xl border text-[10px] font-black uppercase tracking-[0.2em] whitespace-nowrap transition-all flex items-center">
							<i :data-lucide="category.icon" class="w-4 h-4 mr-2" x-init="lucide.createIcons()"></i>
							<span x-text="category.name"></span>
						</button>
					</template>
				</div>

				<!-- Market Data Table Card -->
				<div class="market-glass overflow-hidden border-white/5">
					<div
						class="p-8 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-6">
						<div class="flex items-center space-x-4">
							<div class="h-10 w-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
								<i data-lucide="line-chart" class="w-5 h-5 gold-text"></i>
							</div>
							<div>
								<h3 class="text-xl font-bold italic uppercase tracking-tight">Active Instruments</h3>
								<p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">
									Frequency: Real-time UDP Stream</p>
							</div>
						</div>

						<div class="relative group">
							<i data-lucide="search"
								class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 group-focus-within:gold-text transition-colors"></i>
							<input x-model="searchQuery" type="text" placeholder="Search symbol or name..."
								class="bg-black/40 border border-white/10 rounded-xl h-12 pl-12 pr-6 text-sm focus:outline-none focus:border-yellow-500/50 w-full md:w-80 transition-all font-bold placeholder:text-slate-700">
						</div>
					</div>

					<div class="overflow-x-auto">
						<table class="w-full text-left">
							<thead>
								<tr
									class="text-[10px] font-black uppercase tracking-widest text-slate-600 border-b border-white/5">
									<th class="px-10 py-6">Instrument</th>
									<th class="px-8 py-6">Price Access</th>
									<th class="px-8 py-6 text-center">Efficiency (24H)</th>
									<th class="px-8 py-6">Liquidity Pool</th>
									<th class="px-10 py-6 text-right">Operation</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-white/5">
								<template x-for="instrument in filteredInstruments()" :key="instrument.symbol">
									<tr class="group hover:bg-white/[0.02] transition-colors">
										<td class="px-10 py-6">
											<div class="flex items-center space-x-4">
												<div
													class="h-12 w-12 rounded-xl bg-black border border-white/10 flex items-center justify-center flex-shrink-0 group-hover:border-yellow-500/30 transition-all shadow-xl font-black text-xs">
													<span x-text="instrument.symbol"></span>
												</div>
												<div>
													<div class="text-sm font-black text-white uppercase tracking-tight"
														x-text="instrument.name"></div>
													<div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest"
														x-text="instrument.symbol + '/USD'"></div>
												</div>
											</div>
										</td>
										<td class="px-8 py-6">
											<div class="text-sm font-mono font-black"
												x-text="'$' + instrument.price.toLocaleString(undefined, {minimumFractionDigits: 2})">
											</div>
											<div class="flex items-center mt-1">
												<div class="h-1 w-1 rounded-full bg-emerald-500 mr-2 animate-pulse">
												</div>
												<span
													class="text-[9px] text-emerald-500 font-black uppercase tracking-widest">Latency:
													4ms</span>
											</div>
										</td>
										<td class="px-8 py-6 text-center">
											<div :class="instrument.change > 0 ? 'text-emerald-400 bg-emerald-500/10' : 'text-rose-400 bg-rose-500/10'"
												class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black tracking-tighter">
												<i :data-lucide="instrument.change > 0 ? 'trending-up' : 'trending-down'"
													class="w-3 h-3 mr-1.5" x-init="lucide.createIcons()"></i>
												<span
													x-text="(instrument.change > 0 ? '+' : '') + instrument.change + '%'"></span>
											</div>
										</td>
										<td class="px-8 py-6">
											<div class="w-32 h-1.5 bg-white/5 rounded-full overflow-hidden">
												<div class="h-full gold-gradient rounded-full"
													:style="'width: ' + instrument.volume_percent + '%'"></div>
											</div>
											<div
												class="flex items-center justify-between mt-2 text-[9px] font-black text-slate-600 uppercase tracking-widest">
												<span x-text="'Vol: $' + instrument.volume_short"></span>
												<span x-text="instrument.volume_percent + '% CAP'"></span>
											</div>
										</td>
										<td class="px-10 py-6 text-right">
											<a href="{{ route('register') }}"
												class="inline-flex items-center text-[10px] font-black uppercase tracking-[0.2em] gold-text hover:underline group-hover:translate-x-1 transition-all">
												Sync Edge <i data-lucide="arrow-right" class="w-3 h-3 ml-2"></i>
											</a>
										</td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>

					<!-- Footer / CTA inside table -->
					<div class="p-12 bg-white/[0.02] text-center">
						<div class="max-w-xl mx-auto space-y-6">
							<h4 class="text-2xl font-black italic uppercase tracking-tighter">Enterprise Data
								Availability</h4>
							<p class="text-slate-500 text-sm font-medium">
								Access our full universe of 4,000+ assets with ultra-low latency execution and deep
								liquidity routing.
							</p>
							<a href="{{ route('register') }}"
								class="inline-flex h-14 px-12 rounded-2xl gold-gradient text-black font-black uppercase tracking-[0.2em] items-center text-xs shadow-xl shadow-yellow-500/20 hover:scale-105 transition-all">
								Start Institutional Exposure
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>

	<!-- Detailed Footer -->
	<footer class="bg-black border-t border-white/5 py-24">
		<div class="container mx-auto px-6">
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-20">
				<div class="space-y-8">
					<img src="{{ asset('storage/' . $settings->logo)}}" alt="{{ $settings->site_name ?? config('app.name') }}" class="h-8 opacity-80">
					<p class="text-slate-500 text-sm font-medium leading-relaxed">
						Redefining social asset management through institutional-grade technology and transparent
						execution.
					</p>
					<div class="flex items-center space-x-4">
						<div
							class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all cursor-pointer">
							<i data-lucide="twitter" class="w-5 h-5"></i>
						</div>
						<div
							class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all cursor-pointer">
							<i data-lucide="linkedin" class="w-5 h-5"></i>
						</div>
						<div
							class="h-10 w-10 rounded-xl bg-white/5 flex items-center justify-center text-slate-400 hover:text-white hover:bg-white/10 transition-all cursor-pointer">
							<i data-lucide="github" class="w-5 h-5"></i>
						</div>
					</div>
				</div>

				<div>
					<h5 class="text-[10px] font-black uppercase tracking-[0.3em] text-white mb-8 italic">Ecosystem</h5>
					<ul class="space-y-4">
						<li><a href="{{ route('markets') }}"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Terminals</a>
						</li>
						<li><a href="#"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Social
								Copy</a></li>
						<li><a href="#"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Algo
								Nodes</a></li>
					</ul>
				</div>

				<div>
					<h5 class="text-[10px] font-black uppercase tracking-[0.3em] text-white mb-8 italic">Compliance</h5>
					<ul class="space-y-4">
						<li><a href="{{ route('terms') }}"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Service
								Terms</a></li>
						<li><a href="{{ route('privacy') }}"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Privacy
								Protcol</a></li>
						<li><a href="#"
								class="text-slate-500 hover:text-yellow-500 text-xs font-bold uppercase tracking-widest transition-colors">Risk
								Disclosure</a></li>
					</ul>
				</div>

				<div class="market-glass p-8 border-yellow-500/10">
					<h5 class="text-[10px] font-black uppercase tracking-[0.3em] gold-text mb-4 italic">Operational
						Status</h5>
					<div class="flex items-center justify-between mb-4">
						<span class="text-xs font-bold text-slate-400">System</span>
						<div class="flex items-center">
							<div class="h-2 w-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
							<span
								class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">Active</span>
						</div>
					</div>
					<div class="flex items-center justify-between">
						<span class="text-xs font-bold text-slate-400">Latency</span>
						<span class="text-[10px] font-black text-white uppercase tracking-widest">4.02ms</span>
					</div>
				</div>
			</div>

			<div class="pt-8 border-t border-white/5 flex flex-col md:flex-row items-center justify-between gap-6">
				<p class="text-slate-600 text-[10px] font-black uppercase tracking-widest">
					&copy; {{ date('Y') }} {{ $settings->site_name ?? config('app.name') }} Institutional Group. Distributed Data Infrastructure.
				</p>
				<div class="flex items-center space-x-8">
					<span class="text-slate-600 text-[10px] font-black uppercase tracking-widest">Global HQ:
						Singapore</span>
					<span class="text-slate-600 text-[10px] font-black uppercase tracking-widest">Reg No:
						2026-X830</span>
				</div>
			</div>
		</div>
	</footer>

	<script>
		function marketExplorer() {
			return {
				activeCategory: 'crypto',
				searchQuery: '',
				categories: [
					{ id: 'crypto', name: 'Digital Assets', icon: 'bitcoin' },
					{ id: 'forex', name: 'Currencies', icon: 'globe' },
					{ id: 'stocks', name: 'Equity Markets', icon: 'landmark' },
					{ id: 'indices', name: 'Global Indices', icon: 'bar-chart-2' }
				],
				instruments: [
					{ symbol: 'BTC', name: 'Bitcoin', price: 64281.02, change: 2.45, category: 'crypto', volume_short: '1.2B', volume_percent: 85 },
					{ symbol: 'ETH', name: 'Ethereum', price: 3492.11, change: 1.12, category: 'crypto', volume_short: '840M', volume_percent: 72 },
					{ symbol: 'SOL', name: 'Solana', price: 145.82, change: -0.85, category: 'crypto', volume_short: '310M', volume_percent: 64 },
					{ symbol: 'EUR/USD', name: 'Euro / US Dollar', price: 1.0842, change: 0.15, category: 'forex', volume_short: '9.4B', volume_percent: 92 },
					{ symbol: 'GBP/USD', name: 'British Pound', price: 1.2645, change: -0.22, category: 'forex', volume_short: '4.1B', volume_percent: 88 },
					{ symbol: 'TSLA', name: 'Tesla Inc.', price: 175.22, change: 3.14, category: 'stocks', volume_short: '215M', volume_percent: 78 },
					{ symbol: 'NVDA', name: 'NVIDIA Corp.', price: 875.28, change: 4.56, category: 'stocks', volume_short: '510M', volume_percent: 94 },
					{ symbol: 'SPX', name: 'S&P 500 Index', price: 5123.44, change: 0.82, category: 'indices', volume_short: '12B', volume_percent: 90 },
					{ symbol: 'NAS', name: 'Nasdaq 100', price: 18234.11, change: 1.25, category: 'indices', volume_short: '8.4B', volume_percent: 86 }
				],
				filteredInstruments() {
					return this.instruments.filter(i => {
						const matchesCategory = i.category === this.activeCategory;
						const matchesSearch = i.symbol.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
							i.name.toLowerCase().includes(this.searchQuery.toLowerCase());
						return matchesCategory && matchesSearch;
					});
				}
			}
		}

		document.addEventListener('alpine:init', () => {
			lucide.createIcons();
		});
	</script>
</body>

</html>