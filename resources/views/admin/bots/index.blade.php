@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Automation Desk</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Trading <span class="gold-text">Bots</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Manage strategy bots, monitor investor participation, and trigger platform-wide trade generation without leaving the admin control surface.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button id="bulkTradeBtn" type="button"
                    class="flex items-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-3 text-[10px] font-black uppercase tracking-widest text-emerald-300 transition-all hover:bg-emerald-500/20"
                    onclick="generateBulkTrades()">
                    <i data-lucide="line-chart" class="mr-2 h-4 w-4"></i>
                    Generate Trades
                </button>
                <a href="{{ route('admin.bots.create') }}"
                    class="flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]">
                    <i data-lucide="plus" class="mr-2 h-4 w-4"></i>
                    Add Bot
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-xs font-black uppercase tracking-widest text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Bots</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">{{ number_format($stats['total_bots']) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Configured bot profiles</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Active Bots</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter gold-text">{{ number_format($stats['active_bots']) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Ready for live allocation</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Investments</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-white">${{ number_format((float) $stats['total_investments'], 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Capital assigned to bots</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Total Profits</p>
                <h2 class="mt-4 text-3xl font-black tracking-tighter text-emerald-400">${{ number_format((float) $stats['total_profits'], 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Aggregate bot return</p>
            </div>
        </div>

        <div class="dashboard-glass overflow-hidden">
            <div class="flex flex-col gap-4 border-b border-white/5 bg-white/[0.02] p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Bot Inventory</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Market scope, pricing window, investor adoption, and lifecycle status</p>
                </div>
                <div class="rounded-2xl border border-white/5 bg-black/30 px-4 py-3 text-right">
                    <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Catalog Size</p>
                    <p class="mt-1 text-sm font-bold text-white">{{ number_format($bots->total()) }} bots listed</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/5 text-sm">
                    <thead class="bg-black/20">
                        <tr class="text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <th class="px-6 py-4">Bot</th>
                            <th class="px-6 py-4">Market</th>
                            <th class="px-6 py-4">Investment Range</th>
                            <th class="px-6 py-4">Success Rate</th>
                            <th class="px-6 py-4">Investors</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($bots as $bot)
                            <tr class="transition-colors hover:bg-white/[0.03]">
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center gap-4">
                                        @if($bot->image)
                                            <img src="{{ asset('storage/' . $bot->image) }}" alt="{{ $bot->name }}" class="h-12 w-12 rounded-2xl border border-white/10 object-cover">
                                        @else
                                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-white/10 bg-white/5">
                                                <i data-lucide="bot" class="h-5 w-5 text-slate-500"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-white">{{ $bot->name }}</p>
                                            <p class="text-xs text-slate-400">{{ strlen($bot->description) > 58 ? substr($bot->description, 0, 58) . '...' : $bot->description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full bg-sky-500/10 px-3 py-1 text-[10px] font-black uppercase tracking-widest text-sky-300">
                                        {{ ucfirst($bot->bot_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top text-slate-300">
                                    ${{ number_format((float) $bot->min_investment, 0) }} to ${{ number_format((float) $bot->max_investment, 0) }}
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-24 overflow-hidden rounded-full bg-white/5">
                                            <div class="h-full rounded-full bg-emerald-400" style="width: {{ (float) $bot->success_rate }}%"></div>
                                        </div>
                                        <span class="text-sm font-black text-white">{{ $bot->success_rate }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top font-black text-white">{{ number_format((int) ($bot->user_investments_count ?? 0)) }}</td>
                                <td class="px-6 py-4 align-top">
                                    <span class="inline-flex rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-widest
                                        {{ $bot->status === 'active' ? 'bg-emerald-500/10 text-emerald-400' : ($bot->status === 'inactive' ? 'bg-white/5 text-slate-400' : 'bg-yellow-500/10 text-yellow-400') }}">
                                        {{ ucfirst($bot->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-wrap justify-end gap-2">
                                        <a href="{{ route('admin.bots.show', $bot) }}"
                                            class="rounded-xl border border-sky-500/20 bg-sky-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-sky-300 transition-all hover:bg-sky-500/20">
                                            View
                                        </a>
                                        <a href="{{ route('admin.bots.edit', $bot) }}"
                                            class="rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-slate-300 transition-all hover:bg-white/10">
                                            Edit
                                        </a>
                                        <button type="button"
                                            class="rounded-xl border border-rose-500/20 bg-rose-500/10 px-3 py-2 text-[10px] font-black uppercase tracking-widest text-rose-300 transition-all hover:bg-rose-500/20"
                                            onclick="confirmDelete({{ $bot->id }})">
                                            Delete
                                        </button>
                                        <form id="delete-form-{{ $bot->id }}" action="{{ route('admin.bots.destroy', $bot) }}" method="POST" class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <div class="mx-auto max-w-sm">
                                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-white/5">
                                            <i data-lucide="bot" class="h-7 w-7 text-slate-500"></i>
                                        </div>
                                        <p class="mt-5 text-lg font-black tracking-tight text-white">No trading bots found.</p>
                                        <p class="mt-2 text-sm text-slate-500">Create your first bot to start offering automated strategy products.</p>
                                        <a href="{{ route('admin.bots.create') }}" class="mt-5 inline-flex rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black">
                                            Create Bot
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bots->hasPages())
                <div class="border-t border-white/5 px-6 py-5">
                    {{ $bots->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ asset('dash/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        function confirmDelete(botId) {
            swal({
                title: 'Delete this bot?',
                text: 'This will permanently remove the trading bot and its associated data.',
                type: 'warning',
                buttons: {
                    confirm: {
                        text: 'Delete Bot',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((confirmed) => {
                if (confirmed) {
                    document.getElementById('delete-form-' + botId).submit();
                }
            });
        }

        function generateBulkTrades() {
            const btn = document.getElementById('bulkTradeBtn');
            const original = btn.innerHTML;

            swal({
                title: 'Generate bulk bot trades?',
                text: 'This will generate 20 trades for each active bot investment.',
                type: 'info',
                buttons: {
                    confirm: {
                        text: 'Generate',
                        className: 'btn btn-success'
                    },
                    cancel: {
                        visible: true,
                        className: 'btn btn-danger'
                    }
                }
            }).then((confirmed) => {
                if (!confirmed) {
                    return;
                }

                btn.innerHTML = 'Generating...';
                btn.disabled = true;

                fetch('/cron/bulk-bot-trades/20', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    btn.innerHTML = original;
                    btn.disabled = false;

                    if (data.success) {
                        swal({
                            title: 'Trades generated',
                            text: `Generated ${data.total_trades_created} trades across ${data.investments_processed} bot investments.`,
                            type: 'success',
                            buttons: {
                                confirm: {
                                    className: 'btn btn-success'
                                }
                            }
                        }).then(() => window.location.reload());
                        return;
                    }

                    swal({
                        title: 'Generation failed',
                        text: data.message || 'Unable to generate trades.',
                        type: 'error',
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }
                    });
                })
                .catch(() => {
                    btn.innerHTML = original;
                    btn.disabled = false;

                    swal({
                        title: 'Network error',
                        text: 'An error occurred while generating trades.',
                        type: 'error',
                        buttons: {
                            confirm: {
                                className: 'btn btn-danger'
                            }
                        }
                    });
                });
            });
        }
    </script>
@endsection
