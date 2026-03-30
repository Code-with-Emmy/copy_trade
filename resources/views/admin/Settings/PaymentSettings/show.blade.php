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
                    <span class="text-slate-300">Payments Stack</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Payment <span class="gold-text">Settings</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Configure funding methods, gateway keys, settlement preferences, and transfer behaviour from a single treasury configuration surface.
                </p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deposit Mode</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ ucfirst((string) $settings->deposit_option) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current funding workflow</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Withdrawal Mode</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ ucfirst((string) $settings->withdrawal_option) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current payout workflow</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Card Processor</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ (string) $settings->credit_card_provider }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Primary checkout provider</p>
            </div>
        </div>

        <div class="dashboard-glass p-4 sm:p-6">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="#dep" class="nav-link active" data-toggle="tab">Payment Methods</a>
                </li>
                <li class="nav-item">
                    <a href="#with" class="nav-link" data-toggle="tab">Payment Preference</a>
                </li>
                <li class="nav-item">
                    <a href="#coin" class="nav-link" data-toggle="tab">Coinpayment</a>
                </li>
                <li class="nav-item">
                    <a href="#gate" class="nav-link" data-toggle="tab">Gateways</a>
                </li>
                <li class="nav-item">
                    <a href="#trans" class="nav-link" data-toggle="tab">Transfer</a>
                </li>
            </ul>

            <div class="tab-content pt-5">
                <div class="tab-pane fade show active" id="dep">
                    @include('admin.Settings.PaymentSettings.deposit')
                </div>
                <div class="tab-pane fade" id="with">
                    @include('admin.Settings.PaymentSettings.withdrawal')
                </div>
                <div class="tab-pane fade" id="coin">
                    @include('admin.Settings.PaymentSettings.coinpayment')
                </div>
                <div class="tab-pane fade" id="gate">
                    @include('admin.Settings.PaymentSettings.gateway')
                </div>
                <div class="tab-pane fade" id="trans">
                    @include('admin.Settings.PaymentSettings.transfers')
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#paypreform').on('submit', function() {
            $.ajax({
                url: "{{ route('paypreference') }}",
                type: 'POST',
                data: $('#paypreform').serialize(),
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
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });

        $('#coinpayform').on('submit', function() {
            $.ajax({
                url: "{{ route('updatecpd') }}",
                type: 'POST',
                data: $('#coinpayform').serialize(),
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
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });

        $('#gatewayform').on('submit', function() {
            $.ajax({
                url: "{{ route('updategateway') }}",
                type: 'POST',
                data: $('#gatewayform').serialize(),
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
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });

        $('#trasfer').on('submit', function() {
            $.ajax({
                url: "{{ route('updatetransfer') }}",
                type: 'POST',
                data: $('#trasfer').serialize(),
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
                            placement: {
                                from: "top",
                                align: "right"
                            },
                            offset: 20,
                            spacing: 10,
                            z_index: 1031,
                            delay: 5000,
                            timer: 1000,
                            animate: {
                                enter: 'animated fadeInDown',
                                exit: 'animated fadeOutUp'
                            },
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                },
            });
        });
    </script>
@endsection
