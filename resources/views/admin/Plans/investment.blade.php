@extends('layouts.admin-dasht')
@section('content')
    <div class="main-panel">
        <div class="content ">
            <div class="page-inner">
                <div class="mt-2 mb-4">
                    <h1 class="title1 ">Active Clients Trades</h1>
                </div>
                <x-danger-alert />
                <x-success-alert />
                <div class="col-12 card shadow p-4 ">
                    <div class="table-responsive" data-example-id="hoverable-table">
                        <table id="ShipTable" class="table table-hover ">
                            <thead>
                                <tr>
                                    <th>Client name</th>
                                    <th>Assets</th>
                                    <th>Amount Invested</th>
                                    <th>Duration</th>
                                    <th>ROI</th>
                                    <th>Start Date</th>
                                    <th>Expiration Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr>

                                        <td>{{ $plan->puser->name ?? 'User deleted' }}</td>
                                        <td>{{ $plan->assets }}</td>
                                        <td>{{ $plan->puser->currency ?? '' }}{{ number_format($plan->amount) }}</td>
                                        <td>{{ $plan->inv_duration }}</td>
                                        <td>
                                            {{ $plan->puser->currency ?? '' }}{{ $plan->profit_earned ? $plan->profit_earned : '0' }}
                                        </td>
                                        <td>{{ $plan->created_at->toDayDateTimeString() }}</td>
                                        <td>{{ \Carbon\Carbon::parse($plan->expire_date)->toDayDateTimeString() }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-danger"
                                                        href="{{ route('deleteplan', $plan->id) }}">Delete</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.plans', $plan->puser->id ?? '1') }}">More
                                                        actions</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
@endsection