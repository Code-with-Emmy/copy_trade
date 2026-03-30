<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
    $bg = 'light';
} else {
    $text = 'light';
    $bg = 'dark';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div>
            <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                <i data-lucide="chevron-right" class="h-3 w-3"></i>
                <span class="text-slate-300">IP Controls</span>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-white">IP <span class="gold-text">Blacklist</span></h1>
            <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                Restrict abusive origins, maintain perimeter controls, and review blocked access attempts from the security dashboard.
            </p>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Security Action</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Blacklist IP</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Stop access from a hostile origin</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Purpose</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">Abuse Control</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Block repeated attacks or unwanted traffic</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">List Type</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">Dynamic</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Blacklist entries load in real time</p>
            </div>
        </div>

        <div class="dashboard-glass p-6 sm:p-8">
            <div class="row">
                <div class="mb-3 col-md-8 offset-md-2">
                    <form method="post" action="javascript:void(0)" id="ipform">
                        @csrf
                        <div class="form-group">
                            <h6 class="">IP Address</h6>
                            <input type="text" name="ipaddress" id="ipaddress" class="form-control">
                            <small class="">This IP Address wont be able to access your website.</small>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="px-5 btn btn-primary btn-lg" value="Blacklist">
                        </div>
                    </form>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">IP-address</th>
                                    <th scope="col">Date blacklisted</th>
                                    <th scope="col">Option</th>
                                </tr>
                            </thead>
                            <tbody id="showipaddress"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let textinput = document.getElementById('ipaddress');
            getallips();

            function getallips() {
                let url = "{{ route('allipaddress') }}";
                fetch(url)
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(response) {
                        if (response.status === 200) {
                            document.getElementById('showipaddress').innerHTML = response.data;
                        }
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            }

            function deleteip(id) {
                let url = "{{ url('admin/dashboard/delete-ip') }}" + '/' + id;
                fetch(url)
                    .then(function(res) {
                        return res.json();
                    })
                    .then(function(response) {
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
                            getallips();
                        }
                    })
                    .catch(function(err) {
                        console.log(err);
                    });
            }

            $('#ipform').on('submit', function() {
                $.ajax({
                    url: "{{ route('addipaddress') }}",
                    type: 'POST',
                    data: $('#ipform').serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            textinput.value = "";
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
                            getallips();
                        }
                    },
                    error: function(error) {
                        console.log(error);
                    },
                });
            });
        </script>
    @endsection
