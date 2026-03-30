@extends('layouts.admin-dasht')

@section('content')
    @php
        $text = 'light';
        $bg = 'dark';
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Crypto Operations</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Crypto <span class="gold-text">Assets</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Control exchange availability, fee policy, and supported digital assets used in the platform’s crypto workflow.
                </p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Feature Status</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight {{ $moresettings->use_crypto_feature == 'true' ? 'text-emerald-400' : 'text-rose-300' }}">
                    {{ $moresettings->use_crypto_feature == 'true' ? 'Enabled' : 'Disabled' }}
                </h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">User-facing crypto swap access</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Exchange Fee</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format((float) $moresettings->fee, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Configured swap fee</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Currency Rate</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format((float) $moresettings->currency_rate, 2) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $settings->s_currency }}/USD conversion</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-8 xl:col-span-1">
                <div class="border-b border-white/5 pb-5">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Exchange Controls</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Feature toggle and pricing rules</p>
                </div>

                <div class="mt-6 space-y-6">
                    <div>
                        <p class="mb-3 text-[10px] font-black uppercase tracking-widest text-slate-500">Use This Feature</p>
                        <div class="flex gap-3">
                            <label class="flex flex-1 items-center justify-center rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm font-bold text-white">
                                <input type="radio" name="crypto" id="cryptoyes" value="true" class="mr-2">
                                On
                            </label>
                            <label class="flex flex-1 items-center justify-center rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm font-bold text-white">
                                <input type="radio" name="crypto" id="cryptono" value="false" class="mr-2">
                                Off
                            </label>
                        </div>
                        <p class="mt-3 text-xs text-slate-500">Users cannot access this service while it is disabled.</p>
                    </div>

                    <form action="{{ route('exchangefee') }}" method="post" class="space-y-4">
                        @csrf
                        <label class="block">
                            <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">Exchange Fee</span>
                            <input type="text" name="fee" value="{{ $moresettings->fee }}" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                        </label>

                        @if ($settings->currency != '$')
                            <label class="block">
                                <span class="mb-2 block text-[10px] font-black uppercase tracking-widest text-slate-500">{{ $settings->s_currency }}/USD Rate</span>
                                <input type="number" name="rate" value="{{ $moresettings->currency_rate }}" step=".01" class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-sm text-white outline-none transition-all focus:border-yellow-500/40">
                                <span class="mt-2 block text-xs text-slate-500">Used to calculate crypto values in your selected base currency.</span>
                            </label>
                        @endif

                        <button type="submit" class="rounded-2xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black transition-all hover:scale-[1.02]">
                            Save Controls
                        </button>
                    </form>
                </div>
            </div>

            <div class="dashboard-glass overflow-hidden xl:col-span-2">
                <div class="border-b border-white/5 bg-white/[0.02] p-6">
                    <h2 class="text-lg font-black uppercase tracking-tight text-white">Supported Assets</h2>
                    <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">Enable or disable exchange assets with care if users still hold balances</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/5 text-sm">
                        <thead class="bg-black/20">
                            <tr class="text-left text-[10px] font-black uppercase tracking-widest text-slate-500">
                                <th class="px-6 py-4">Asset Name</th>
                                <th class="px-6 py-4">Symbol</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Option</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @include('admin.Settings.Crypto.assets')
                        </tbody>
                    </table>
                </div>
                <div class="border-t border-white/5 p-6 text-xs text-slate-500">
                    Ensure no user still holds a positive asset balance before disabling a supported asset.
                </div>
            </div>
        </div>
    </div>

    @if ($moresettings->use_crypto_feature == 'true')
        <script>document.getElementById("cryptoyes").checked = true;</script>
    @else
        <script>document.getElementById("cryptono").checked = true;</script>
    @endif

    <script>
        $('#cryptoyes').on('click', function() {
            let uurl = "{{ url('admin/dashboard/useexchange') }}/true";
            $.ajax({
                url: uurl,
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Success',
                            message: response.success,
                        }, {
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            placement: { from: "top", align: "right" },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
                        });
                    }
                },
                error: function(error) { console.log(error); },
            });
        });

        $('#cryptono').on('click', function() {
            let uurl = "{{ url('admin/dashboard/useexchange') }}/false";
            $.ajax({
                url: uurl,
                type: 'GET',
                success: function(response) {
                    if (response.status === 200) {
                        $.notify({
                            icon: 'flaticon-alarm-1',
                            title: 'Success',
                            message: response.success,
                        }, {
                            type: 'success',
                            allow_dismiss: true,
                            newest_on_top: false,
                            placement: { from: "top", align: "right" },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: { enter: 'animated fadeInDown', exit: 'animated fadeOutUp' },
                        });
                    }
                },
                error: function(error) { console.log(error); },
            });
        });
    </script>
@endsection
