<div class="space-y-6" x-data="{ openPaymentMethod: false, paymentMethodType: 'currency' }" @keydown.escape.window="openPaymentMethod = false">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h3 class="text-lg font-black uppercase tracking-tight text-white">Payment Methods</h3>
            <p class="mt-1 text-[10px] font-black uppercase tracking-widest text-slate-500">
                Configure deposit and withdrawal channels available to users.
            </p>
        </div>

        <button type="button"
            class="inline-flex items-center rounded-xl gold-gradient-bg px-5 py-3 text-[10px] font-black uppercase tracking-widest text-black shadow-xl shadow-yellow-500/10 transition-all hover:scale-[1.03]"
            @click="openPaymentMethod = true">
            <i class="fas fa-plus-circle mr-2"></i>
            Add New
        </button>
    </div>

    <div class="dashboard-glass overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Method Name</th>
                        <th>Type</th>
                        <th>Used For</th>
                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($methods as $method)
                        <tr>
                            <td>{{ $method->name }}</td>
                            <td>{{ ucfirst((string) $method->methodtype) }}</td>
                            <td>{{ ucfirst((string) $method->type) }}</td>
                            <td>
                                @if ($method->status === 'enabled')
                                    <span class="badge badge-success">{{ $method->status }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $method->status }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('editpaymethod', $method->id) }}" class="btn btn-primary btn-sm" title="View">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @if ($method->defaultpay === 'yes')
                                        <button class="btn btn-danger btn-sm" disabled title="You cannot delete the default method">
                                            Delete
                                        </button>
                                    @else
                                        <a href="{{ route('deletepaymethod', $method->id) }}" class="btn btn-danger btn-sm">
                                            Delete
                                        </a>
                                    @endif

                                    @if ($method->status === 'enabled')
                                        <a href="{{ route('togglestatus', $method->id) }}" class="btn btn-warning btn-sm">
                                            Disable
                                        </a>
                                    @else
                                        <a href="{{ route('togglestatus', $method->id) }}" class="btn btn-success btn-sm">
                                            Enable
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-slate-400">No payment methods created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-cloak x-show="openPaymentMethod"
        class="fixed inset-0 z-[140] flex items-center justify-center bg-black/75 px-4 py-6 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0" @click="openPaymentMethod = false"></div>

        <div class="relative w-full max-w-4xl rounded-[28px] border border-white/10 bg-[#0b1220] shadow-2xl shadow-black/70"
            @click.stop
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="flex items-center justify-between border-b border-white/10 px-6 py-5 sm:px-8">
                <div>
                    <h3 class="mb-1 text-xl font-black tracking-tight text-white">Add New Payment Method</h3>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500">Configure a new deposit or withdrawal channel</p>
                </div>
                <button type="button" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-slate-400 transition-all hover:bg-white/10 hover:text-white" @click="openPaymentMethod = false" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="max-h-[80vh] overflow-y-auto px-6 py-6 sm:px-8">
                <form method="POST" action="{{ route('addpaymethod') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <h6>Name</h6>
                            <input type="text" class="form-control" name="name" placeholder="Payment method name" required>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Minimum Amount</h6>
                            <input type="number" class="form-control" name="minimum" required>
                            <small>Applies mainly to withdrawals.</small>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Maximum Amount</h6>
                            <input type="number" class="form-control" name="maximum" required>
                            <small>Applies mainly to withdrawals.</small>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Charges</h6>
                            <input type="number" class="form-control" name="charges" required>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Charges Type</h6>
                            <select name="chargetype" class="form-control">
                                <option value="percentage">Percentage (%)</option>
                                <option value="fixed">Fixed ({{ $settings->currency }})</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Type</h6>
                            <select name="methodtype" class="form-control" x-model="paymentMethodType" required>
                                <option value="currency">Currency</option>
                                <option value="crypto">Crypto</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Image Url (Logo)</h6>
                            <input type="text" class="form-control" name="url">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'currency'" x-transition>
                            <h6>Bank Name</h6>
                            <input type="text" class="form-control" name="bank" :required="paymentMethodType === 'currency'">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'currency'" x-transition>
                            <h6>Account Name</h6>
                            <input type="text" class="form-control" name="account_name" :required="paymentMethodType === 'currency'">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'currency'" x-transition>
                            <h6>Account Number</h6>
                            <input type="number" class="form-control" name="account_number" :required="paymentMethodType === 'currency'">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'currency'" x-transition>
                            <h6>Swift/Other Code</h6>
                            <input type="text" class="form-control" name="swift">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'crypto'" x-transition>
                            <h6>Wallet Address</h6>
                            <input type="text" class="form-control" name="walletaddress" :required="paymentMethodType === 'crypto'">
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'crypto'" x-transition>
                            <h6>Barcode Image (Optional)</h6>
                            <input type="file" name="barcode" class="form-control">
                            <small>Recommended size: 575px by 575px.</small>
                        </div>

                        <div class="form-group col-md-6" x-show="paymentMethodType === 'crypto'" x-transition>
                            <h6>Wallet Network Type</h6>
                            <input type="text" placeholder="e.g. ERC20" class="form-control" name="wallettype" :required="paymentMethodType === 'crypto'">
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Status</h6>
                            <select name="status" class="form-control" required>
                                <option value="enabled">Enable</option>
                                <option value="disabled">Disable</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <h6>Type For</h6>
                            <select name="typefor" class="form-control" required>
                                <option value="withdrawal">Withdrawal</option>
                                <option value="deposit">Deposit</option>
                                <option value="both">Both</option>
                            </select>
                        </div>

                        <div class="form-group col-md-12">
                            <h6>Optional Note</h6>
                            <input type="text" class="form-control" name="note" placeholder="Payment may take up to 24 hours">
                        </div>

                        <div class="form-group col-md-12 flex flex-wrap gap-3 pt-2">
                            <button type="submit" class="px-4 btn btn-primary">Save Method</button>
                            <button type="button" class="btn btn-outline-light" @click="openPaymentMethod = false">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
