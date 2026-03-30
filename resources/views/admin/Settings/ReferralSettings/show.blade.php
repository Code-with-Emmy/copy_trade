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
                    <span class="text-slate-300">Referral Engine</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Referral <span class="gold-text">Settings</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Control referral rewards and platform bonus logic from one unified incentives control panel.
                </p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Referral Bonus</p>
                <p class="mt-4 text-sm font-medium text-slate-300">Set the direct reward rules users earn when they onboard new investors.</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Other Bonuses</p>
                <p class="mt-4 text-sm font-medium text-slate-300">Adjust additional growth or promotional incentives applied across the platform.</p>
            </div>
        </div>

        <div class="dashboard-glass p-4 sm:p-6">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="#dep" class="nav-link active" data-toggle="tab">Referral Bonus</a>
                </li>
                <li class="nav-item">
                    <a href="#with" class="nav-link" data-toggle="tab">Other Bonus(s)</a>
                </li>
            </ul>

            <div class="tab-content pt-5">
                <div class="tab-pane fade show active" id="dep">
                    @include('admin.Settings.ReferralSettings.referral')
                </div>
                <div class="tab-pane fade" id="with">
                    @include('admin.Settings.ReferralSettings.other-bonus')
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#refform').on('submit', function() {
            $.ajax({
                url: "{{ route('updaterefbonus') }}",
                type: 'POST',
                data: $('#refform').serialize(),
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

        $('#bonusform').on('submit', function() {
            $.ajax({
                url: "{{ route('otherbonus') }}",
                type: 'POST',
                data: $('#bonusform').serialize(),
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
