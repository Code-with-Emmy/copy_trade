<?php
if (Auth('admin')->User()->dashboard_style == 'light') {
    $text = 'dark';
} else {
    $text = 'light';
}
?>
@extends('layouts.admin-dasht')
@section('content')
    @php
        $agentCount = $agents->count();
        $referralVolume = $agents->sum('total_refered');
        $candidateCount = $users->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Agents</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Referral <span class="gold-text">Agents</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Manage agent profiles, track referred client volume, and add new referral operators from the updated admin dashboard flow.
                </p>
            </div>
            <div>
                <a href="#" data-toggle="modal" data-target="#addagentModal" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Agent
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Agents</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($agentCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Active referral operators</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Referrals</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($referralVolume) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Combined clients referred</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Candidates</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($candidateCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Users available to promote as agents</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass p-4 sm:p-6">
            <div class="bs-example widget-shadow table-responsive" data-example-id="hoverable-table">
                <table id="ShipTable" class="table table-hover ">
                                <thead>
                                    <tr>
                                        <th>Agent name</th>
                                        <th>Clients referred</th>
                                        <th>Option(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agents as $agent)
                                        <tr>
                                            <td>{{ $agent->duser->name }}</td>
                                            <td>{{ $agent->total_refered }}</td>
                                            <!--<td>{{ $agent->total_activated }}</td>
                                       <td>{{ $agent->earnings }}</td>-->
                                            <td>
                                                {{-- <a class="btn btn-{{$text}}" href="{{url('admin/dashboard/viewagent')}}/{{$agent->agent}}" title="View agent clients">
												<i class="fa fa-eye"></i>
												</a>  --}}

                                                <a class="btn "
                                                    href="{{ url('admin/dashboard/delagent') }}/{{ $agent->id }}"
                                                    style="color:red;" title="Remove agent clients">
                                                    <i class="fa fa-times"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                </table>
            </div>
        </div>

        <div id="addagentModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header  ">
                        <h4 class="modal-title "><strong>Add agent.</strong></h4>
                        <button type="button" class="close " data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body ">
                        <form style="padding:3px;" role="form" method="post"
                            action="{{ action('App\Http\Controllers\Admin\LogicController@addagent') }}">
                            <select class="form-control" name="user">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select><br>
                            <input class="form-control" placeholder="Increment referred users"
                                type="number" min="0" name="referred_users" value="0"><br />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
