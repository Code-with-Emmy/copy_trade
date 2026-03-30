@extends('layouts.admin-dasht')

@section('content')
    @php
        $signalCollection = $signals instanceof \Illuminate\Support\Collection ? $signals : collect($signals);
        $signalCount = $signalCollection->count();
        $publishedCount = $signalCollection->where('status', 'published')->count();
        $resultCount = $signalCollection->filter(function ($signal) {
            return !empty($signal->result);
        })->count();
    @endphp

    <div class="page-content-stack animate-in fade-in slide-in-from-bottom-6 duration-1000">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <div class="mb-2 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-500">
                    <a href="{{ route('admin.dashboard') }}" class="transition-colors hover:text-yellow-500">Admin</a>
                    <i data-lucide="chevron-right" class="h-3 w-3"></i>
                    <span class="text-slate-300">Signals</span>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-white">Trade <span class="gold-text">Signals</span></h1>
                <p class="mt-1 max-w-3xl text-sm font-medium text-slate-400">
                    Publish market calls, review live signal status, and log outcomes from a dedicated trading signal board.
                </p>
            </div>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Add Signal
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Signals</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($signalCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Entries in the current feed</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Published</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight gold-text">{{ number_format($publishedCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Signals already live for subscribers</p>
            </div>
            <div class="dashboard-glass p-6 sm:p-7">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Results Logged</p>
                <h2 class="mt-4 text-2xl font-black tracking-tight text-white">{{ number_format($resultCount) }}</h2>
                <p class="mt-2 text-[10px] font-black uppercase tracking-widest text-slate-400">Signals with recorded outcomes</p>
            </div>
        </div>

        <x-danger-alert />
        <x-success-alert />

        <div class="dashboard-glass overflow-hidden">
            <div class="card-body p-4 sm:p-6">
                <h5 class="card-title">Signals</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-primary text-white">
                            <th>Ref</th>
                            <th>Trade Direction</th>
                            <th>Currency Pair</th>
                            <th>Price</th>
                            <th>Take Profit-1</th>
                            <th>Take Profit-2</th>
                            <th>Stop Loss</th>
                            <th>Result</th>
                            <th>Status</th>
                            <th>Date Added</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @forelse ($signals as $signal)
                                <tr>
                                    <td>#{{ $signal->reference }}</td>
                                    <td>
                                        @if ($signal->trade_direction == 'Buy')
                                            <i class="fa fa-arrow-up text-success"></i>
                                        @else
                                            <i class="fa fa-arrow-down text-danger"></i>
                                        @endif
                                        {{ $signal->trade_direction }}
                                    </td>
                                    <td>{{ $signal->currency_pair }}</td>
                                    <td>{{ $signal->price }}</td>
                                    <td>{{ $signal->take_profit1 }}</td>
                                    <td>{{ $signal->take_profit2 ? $signal->take_profit2 : '-' }}</td>
                                    <td>{{ $signal->stop_loss1 }}</td>
                                    <td>{{ $signal->result ? $signal->result : '-' }}</td>
                                    <td>
                                        @if ($signal->status == 'published')
                                            <span class="badge badge-success"> {{ $signal->status }}</span>
                                        @else
                                            <span class="badge badge-danger"> {{ $signal->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($signal->created_at)->addHour()->toDayDateTimeString() }}</td>
                                    <td>
                                        @if ($signal->status == 'unpublished')
                                            <a href="{{ route('pubsignals', ['signal' => $signal->id]) }}" class="btn btn-info btn-sm m-1">
                                                Publish
                                            </a>
                                        @else
                                            <a href="#" class="btn btn-secondary btn-sm m-1" data-toggle="modal" data-target="#resultModal{{ $signal->id }}">
                                                Add Result
                                            </a>
                                        @endif

                                        <a href="{{ route('delete.signal', ['signal' => $signal->id]) }}" class="btn btn-danger btn-sm m-1">
                                            Delete
                                        </a>

                                        <div class="modal fade" id="resultModal{{ $signal->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Update Signal Result</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('updt.result') }}" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="signalId" value="{{ $signal->id }}">
                                                            <div class="form-group">
                                                                <label for="">Result</label>
                                                                <input type="text" name="result" value="{{ $signal->result }}" class="form-control rounded-none py-3" id="">
                                                            </div>
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary btn-sm">Publish Result</button>
                                                                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No Data Available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Signal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body py-3">
                        <form action="{{ route('postsignals') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="">Trade Direction</label>
                                    <select name="direction" class="form-control rounded-none py-3" required>
                                        <option value="Sell">Sell</option>
                                        <option value="Buy">Buy</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Currency Pair</label>
                                    <input type="text" name="pair" class="form-control rounded-none py-3" placeholder="eg EUR/USD" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Price</label>
                                    <input type="text" name="price" class="form-control rounded-none py-3" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Take Profit 1</label>
                                    <input type="text" step="any" name="tp1" class="form-control rounded-none py-3" required>
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Take Profit 2</label>
                                    <input type="text" step="any" name="tp2" class="form-control rounded-none py-3">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label for="">Stop Loss</label>
                                    <input type="text" step="any" name="sl1" class="form-control rounded-none py-3" required>
                                </div>
                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary px-3">Add Signal</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
