@props([
    'leaderboards' => [],
    'stats' => [],
])

<section id="analytics" class="mx-auto mt-28 max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Section header --}}
    <div class="text-center max-w-3xl mx-auto mb-12 reveal">
        <span class="inline-block mb-3 text-xs font-semibold uppercase tracking-[0.25em] text-amber-400">Analytics Platform</span>
        <h2 class="font-display text-3xl font-bold text-white sm:text-4xl leading-tight">
            Institutional-grade visibility into<br class="hidden sm:block"> your copy performance.
        </h2>
        <p class="mt-5 text-base text-slate-400 leading-relaxed">
            Portfolio growth, allocation concentration, and risk exposure — surfaced in a single, clean experience.
        </p>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.05fr,.95fr] items-start">

        {{-- LEFT: Chart panel --}}
        <div class="glass-bright rounded-[32px] p-7 sm:p-8 reveal">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Portfolio Performance</p>
                    <p class="mt-1 text-2xl font-bold text-white">$129,850 <span class="text-sm font-medium text-emerald-400">+29.85%</span></p>
                </div>
                <div class="flex gap-2">
                    @foreach (['1M', '3M', '6M', '1Y'] as $period)
                        <button class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $period === '6M' ? 'bg-emerald-400/20 text-emerald-300 border border-emerald-400/25' : 'text-slate-400 hover:text-white' }}">
                            {{ $period }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Chart --}}
            <div class="h-52 w-full rounded-2xl border border-white/8 bg-slate-950/50 p-4">
                <canvas id="landing-performance-chart"></canvas>
            </div>

            {{-- Leaderboard panels --}}
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl border border-white/8 bg-slate-950/60 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        Top ROI
                    </p>
                    @php $topRoi = collect(data_get($leaderboards, 'top_roi', []))->take(3); @endphp
                    @if ($topRoi->isNotEmpty())
                        @foreach ($topRoi as $trader)
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="truncate text-slate-300">{{ $trader->name }}</span>
                                <span class="font-bold text-emerald-300">+{{ number_format((float) $trader->monthly_roi, 1) }}%</span>
                            </div>
                        @endforeach
                    @else
                        @foreach ([['Crypto Alpha','34.2'],['FX Expert','22.8'],['SwingMaster','18.5']] as $tr)
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="text-slate-300">{{ $tr[0] }}</span>
                                <span class="font-bold text-emerald-300">+{{ $tr[1] }}%</span>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="rounded-2xl border border-white/8 bg-slate-950/60 p-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                        Most Copied
                    </p>
                    @php $mostCopied = collect(data_get($leaderboards, 'most_copied', []))->take(3); @endphp
                    @if ($mostCopied->isNotEmpty())
                        @foreach ($mostCopied as $trader)
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="truncate text-slate-300">{{ $trader->name }}</span>
                                <span class="font-bold text-sky-300">{{ number_format((int) $trader->followers) }}</span>
                            </div>
                        @endforeach
                    @else
                        @foreach ([['TrendBreaker','1,840'],['AlgoBot Pro','1,220'],['Velocity Fx','980']] as $tr)
                            <div class="mt-3 flex items-center justify-between text-sm">
                                <span class="text-slate-300">{{ $tr[0] }}</span>
                                <span class="font-bold text-sky-300">{{ $tr[1] }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- RIGHT: Screenshot gallery --}}
        <div class="space-y-5 reveal" style="transition-delay:.12s">
            {{-- Primary screenshot --}}
            <div class="glass-bright overflow-hidden rounded-[28px] p-1">
                <img src="{{ asset('storage/photos/Web-Design03.jpg') }}" alt="Trading dashboard analytics view"
                    class="w-full rounded-[24px] object-cover max-h-64 object-top"
                    loading="lazy"
                    onerror="this.onerror=null;this.src='{{ asset('img/in-theramanuel-8-background.webp') }}'">
            </div>

            {{-- Feature highlights grid --}}
            <div class="grid grid-cols-2 gap-5">
                @php
                    $features = [
                        ['img/blockit/in-feature-image-1.jpg','Real-time trade feed'],
                        ['img/blockit/in-feature-image-2.jpg','Risk dashboard'],
                    ];
                @endphp
                @foreach ($features as $feat)
                    <div class="glass overflow-hidden rounded-[24px] p-1">
                        <img src="{{ asset($feat[0]) }}" alt="{{ $feat[1] }}"
                            class="w-full h-36 rounded-[20px] object-cover"
                            loading="lazy">
                        <p class="px-3 py-2 text-xs font-medium text-slate-400">{{ $feat[1] }}</p>
                    </div>
                @endforeach
            </div>

            {{-- Feature bullet points --}}
            <div class="glass rounded-[24px] p-5">
                @foreach (['Transparent strategy performance history','Drawdown & risk level labels for every trader','Real-time copy execution with audit trail','Allocation controls and cost transparency'] as $bullet)
                    <div class="flex items-start gap-3 {{ !$loop->first ? 'mt-3.5' : '' }}">
                        <svg class="h-4 w-4 mt-0.5 text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-slate-300">{{ $bullet }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

@once
    @push('scripts')
        <script>
            const performanceChart = document.getElementById('landing-performance-chart');
            if (performanceChart) {
                new Chart(performanceChart, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Portfolio Value',
                            data: [100000, 105800, 103200, 112900, 121400, 129850],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16,185,129,.12)',
                            fill: true,
                            tension: 0.45,
                            pointRadius: 4,
                            pointBackgroundColor: '#10b981',
                            pointBorderColor: '#06101d',
                            pointBorderWidth: 2,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false }, tooltip: {
                            backgroundColor: 'rgba(13,23,38,.95)',
                            borderColor: 'rgba(16,185,129,.25)',
                            borderWidth: 1,
                            titleColor: '#94a3b8',
                            bodyColor: '#ffffff',
                            padding: 10,
                        }},
                        scales: {
                            x: { ticks: { color: '#64748b', font: { size: 10 } }, grid: { color: 'rgba(148,163,184,.06)', drawBorder: false } },
                            y: { ticks: { color: '#64748b', font: { size: 10 }, callback: v => '$' + (v/1000).toFixed(0) + 'k' }, grid: { color: 'rgba(148,163,184,.06)', drawBorder: false } },
                        },
                    },
                });
            }
        </script>
    @endpush
@endonce
