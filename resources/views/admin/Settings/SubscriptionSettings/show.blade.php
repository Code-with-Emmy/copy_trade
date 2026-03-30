@extends('layouts.admin-dasht')

@section('content')
    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <section class="admin-page-header">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Subscription Settings</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">MT4 <span class="gold-text">Subscription Settings</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Maintain the recurring subscription price points used for monthly, quarterly, and yearly MT4 account access.
                </p>
            </div>
        </section>

        <x-danger-alert />
        <x-success-alert />

        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Monthly Fee</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-white">{{ $settings->monthlyfee }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Baseline recurring access fee billed every month.</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Quarterly Fee</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight gold-text">{{ $settings->quarterlyfee }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Three-month subscription pricing used for bundled access.</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Yearly Fee</p>
                <h2 class="mt-4 text-3xl font-black tracking-tight text-white">{{ $settings->yearlyfee }}</h2>
                <p class="mt-2 text-xs font-medium text-slate-400">Annual plan amount currently exposed across the platform.</p>
            </div>
        </div>

        <div class="row mb-0">
            <div class="col-lg-8 offset-lg-2">
                <div class="card p-4 p-md-5 shadow-lg">
                    <div class="mb-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Pricing Controls</p>
                        <h3 class="mt-2 text-2xl font-black tracking-tight text-white">Update Subscription Fees</h3>
                    </div>

                    <form method="post" action="javascript:void(0)" id="subform">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <h4>Monthly Subscription Fee</h4>
                            <input type="text" name="monthlyfee" class="form-control" value="{{ $settings->monthlyfee }}">
                        </div>

                        <div class="form-group">
                            <h4>Quarterly Subscription Fee</h4>
                            <input type="text" name="quaterlyfee" class="form-control" value="{{ $settings->quarterlyfee }}">
                        </div>

                        <div class="form-group">
                            <h4>Yearly Subscription Fee</h4>
                            <input type="text" name="yearlyfee" class="form-control" value="{{ $settings->yearlyfee }}">
                        </div>

                        <div class="form-group mb-0">
                            <input type="submit" class="btn btn-primary btn-lg px-5" value="Save">
                            <input type="hidden" name="id" value="1">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#subform').on('submit', function() {
            $.ajax({
                url: "{{ route('updatesubfee') }}",
                type: 'POST',
                data: $('#subform').serialize(),
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
