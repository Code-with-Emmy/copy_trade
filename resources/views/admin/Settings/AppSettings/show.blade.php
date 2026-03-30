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
                    <span class="text-slate-300">Platform Settings</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">App <span class="gold-text">Settings</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Control modules, website information, email settings, preferences, and display configuration from one operating surface.
                </p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        @if (count($errors) > 0)
            <div class="rounded-2xl border border-rose-500/20 bg-rose-500/10 px-5 py-4 text-sm text-rose-100">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Application</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $settings->site_name }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Live platform identity</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Currency</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ $settings->currency }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Primary monetary unit</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Theme</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ $settings->website_theme }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Current site display mode</p>
            </div>
        </div>

        <div class="dashboard-glass p-4 sm:p-6">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a href="#module" class="nav-link" data-toggle="tab">Module</a>
                </li>
                <li class="nav-item">
                    <a href="#info" class="nav-link active" data-toggle="tab">Website Information</a>
                </li>
                <li class="nav-item">
                    <a href="#pref" class="nav-link" data-toggle="tab">Preference</a>
                </li>
                <li class="nav-item">
                    <a href="#email" class="nav-link" data-toggle="tab">Email / Login / Captcha</a>
                </li>
                <li class="nav-item">
                    <a href="#display" class="nav-link" data-toggle="tab">Theme / Display</a>
                </li>
            </ul>

            <div class="tab-content pt-5">
                <div class="tab-pane fade" id="module">
                    <livewire:admin.software-module />
                </div>
                <div class="tab-pane fade show active" id="info">
                    @include('admin.Settings.AppSettings.webinfo')
                </div>
                <div class="tab-pane fade" id="pref">
                    @include('admin.Settings.AppSettings.webpreference')
                </div>
                <div class="tab-pane fade" id="email">
                    @include('admin.Settings.AppSettings.email')
                </div>
                <div class="tab-pane fade" id="display">
                    @include('admin.Settings.AppSettings.theme')
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.select2').select2();
        document.getElementById("themeForm").addEventListener('submit', function () {
            document.getElementById("themeBtn").disabled = true;
            document.getElementById("loadingTheme").classList.remove("d-none");
        });

        function changecurr() {
            var e = document.getElementById("select_c");
            var selected = e.options[e.selectedIndex].id;
            document.getElementById("s_c").value = selected;
        }

        $('#updatepreference').on('submit', function () {
            $.ajax({
                url: "{{ route('updatepreference') }}",
                type: 'POST',
                data: $('#updatepreference').serialize(),
                success: function (response) {
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
                error: function (error) { console.log(error); },
            });
        });

        let sendmail = document.querySelector('#sendmailserver');
        let smtp = document.querySelector('#smtpserver');
        let smtptext = document.querySelectorAll('.smtp');
        sendmail.addEventListener('click', sortform);
        smtp.addEventListener('click', sortform);

        if (smtp.checked) {
            smtptext.forEach(smtps => {
                smtps.classList.remove('d-none');
                smtps.setAttribute('required', '');
            });
        }

        function sortform() {
            if (sendmail.checked) {
                smtptext.forEach(element => {
                    element.classList.add('d-none');
                    element.removeAttribute('required', '');
                });
            }
            if (smtp.checked) {
                smtptext.forEach(smtps => {
                    smtps.classList.remove('d-none');
                    smtps.setAttribute('required', '');
                });
            }
        }

        $('#emailform').on('submit', function () {
            $.ajax({
                url: "{{ route('updateemailpreference') }}",
                type: 'POST',
                data: $('#emailform').serialize(),
                success: function (response) {
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
                error: function (error) { console.log(error); },
            });
        });
    </script>
@endsection
