<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\SettingsCont;
use App\Models\Wdmethod;
use App\Models\Paystack;
use App\Models\CpTransaction;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Schema\Blueprint;

class PaymentController extends Controller
{
    protected function ensureWdmethodSchema(): void
    {
        if (!Schema::hasTable('wdmethods')) {
            return;
        }

        $stringColumns = [
            'methodtype' => 'currency',
            'img_url' => null,
            'bankname' => null,
            'account_name' => null,
            'account_number' => null,
            'swift_code' => null,
            'network' => null,
            'charges_type' => 'fixed',
            'duration' => null,
            'defaultpay' => 'no',
        ];

        foreach ($stringColumns as $column => $default) {
            if (!Schema::hasColumn('wdmethods', $column)) {
                Schema::table('wdmethods', function (Blueprint $table) use ($column, $default) {
                    $definition = $table->string($column)->nullable();

                    if ($default !== null) {
                        $definition->default($default);
                    }
                });
            }
        }

        if (!Schema::hasColumn('wdmethods', 'wallet_address')) {
            Schema::table('wdmethods', function (Blueprint $table) {
                $table->text('wallet_address')->nullable();
            });
        }

        if (!Schema::hasColumn('wdmethods', 'barcode')) {
            Schema::table('wdmethods', function (Blueprint $table) {
                $table->string('barcode')->nullable();
            });
        }

        if (!Schema::hasColumn('wdmethods', 'charges_amount')) {
            Schema::table('wdmethods', function (Blueprint $table) {
                $table->decimal('charges_amount', 16, 2)->default(0);
            });
        }
    }

    protected function singletonRecord(string $modelClass, int $id = 1)
    {
        $record = $modelClass::query()->find($id);

        if ($record) {
            return $record;
        }

        $record = new $modelClass();
        $record->id = $id;

        return $record;
    }

    protected function wdmethodColumns(): array
    {
        $this->ensureWdmethodSchema();

        return Schema::hasTable('wdmethods') ? Schema::getColumnListing('wdmethods') : [];
    }

    protected function supportsWdmethod(string $column): bool
    {
        return in_array($column, $this->wdmethodColumns(), true);
    }

    protected function fillPaymentMethodModel(Wdmethod $method, Request $request, ?string $path = null): Wdmethod
    {
        $charges = (float) ($request['charges'] ?? 0);
        $chargeType = (string) ($request['chargetype'] ?? 'fixed');
        $imageValue = $path ?: $request['url'] ?: ($method->image ?? $method->img_url ?? null);

        $payload = [
            'name' => $request['name'],
            'minimum' => $request['minimum'],
            'maximum' => $request['maximum'],
            'status' => $request['status'],
        ];

        if ($this->supportsWdmethod('type')) {
            $payload['type'] = $request['typefor'] ?: $request['methodtype'];
        }

        if ($this->supportsWdmethod('charges_amount')) {
            $payload['charges_amount'] = $charges;
        }

        if ($this->supportsWdmethod('charges_type')) {
            $payload['charges_type'] = $chargeType;
        }

        if ($this->supportsWdmethod('fixed_fee')) {
            $payload['fixed_fee'] = $chargeType === 'fixed' ? $charges : 0;
        }

        if ($this->supportsWdmethod('percentage_fee')) {
            $payload['percentage_fee'] = $chargeType === 'percentage' ? $charges : 0;
        }

        if ($this->supportsWdmethod('duration')) {
            $payload['duration'] = $request['note'];
        }

        if ($this->supportsWdmethod('methodtype')) {
            $payload['methodtype'] = $request['methodtype'];
        }

        if ($this->supportsWdmethod('img_url')) {
            $payload['img_url'] = $request['url'];
        }

        if ($this->supportsWdmethod('image')) {
            $payload['image'] = $imageValue;
        }

        if ($this->supportsWdmethod('bankname')) {
            $payload['bankname'] = $request['bank'];
        }

        if ($this->supportsWdmethod('account_name')) {
            $payload['account_name'] = $request['account_name'];
        }

        if ($this->supportsWdmethod('account_number')) {
            $payload['account_number'] = $request['account_number'];
        }

        if ($this->supportsWdmethod('swift_code')) {
            $payload['swift_code'] = $request['swift'];
        }

        if ($this->supportsWdmethod('wallet_address')) {
            $payload['wallet_address'] = $request['walletaddress'];
        }

        if ($this->supportsWdmethod('barcode')) {
            $payload['barcode'] = $path ?: ($method->barcode ?? null);
        }

        if ($this->supportsWdmethod('network')) {
            $payload['network'] = $request['wallettype'];
        }

        foreach ($payload as $column => $value) {
            if ($this->supportsWdmethod($column)) {
                $method->{$column} = $value;
            }
        }

        return $method;
    }

    // Return view
    public function paymentview(Request $request)
    {
        $this->ensureWdmethodSchema();
        $paymethod = Wdmethod::orderByDesc('id')->get();
        $coinpayment = $this->singletonRecord(CpTransaction::class);
        $paystack = $this->singletonRecord(Paystack::class);
        $moreSettings = $this->singletonRecord(SettingsCont::class);

        return view('admin.Settings.PaymentSettings.show', [
            'title' => 'Payment settings',
            'methods' => $paymethod,
            'cpd' => $coinpayment,
            'paystack' => $paystack,
            'moresettings' => $moreSettings,
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }

    public function addpaymethod(Request $request)
    {
        $this->ensureWdmethodSchema();

        if (!Schema::hasTable('wdmethods')) {
            return redirect()->back()->with('error', 'Payment methods table is missing. Run the required migration first.');
        }

        $this->validate($request, [
            'barcode' => 'image|mimes:jpg,jpeg,png|max:500',
        ]);

        if ($request->hasfile('barcode')) {
            $file = $request->file('barcode');
            $path = $file->store('photos', 'public');
        } else {
            $path = NULL;
        }

        $method = $this->fillPaymentMethodModel(new Wdmethod(), $request, $path);
        $method->save();

        return redirect()->back()->with('success', 'Payment method saved successfully.');
    }

    public function editmethod($id)
    {
        $this->ensureWdmethodSchema();
        $paymethod = Wdmethod::where('id', $id)->first();

        return view('admin.Settings.PaymentSettings.editpaymethod', [
            'title' => 'Update Payment Method',
            'method' => $paymethod,
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }

    public function deletepaymethod($id)
    {
        Wdmethod::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Payment Method Deleted Successfully. or more script or help chat the developer on telegram with https://wa.me/2348114313795');
    }

    //enable or disable payment method
    public function togglePaymentMethodStatus(int $id)
    {
        $method = Wdmethod::where('id', $id)->first();

        if ($method->status == 'enabled') {
            Wdmethod::where('id', $id)->update([
                'status' => 'disabled',
            ]);
        } else {
            Wdmethod::where('id', $id)->update([
                'status' => 'enabled',
            ]);
        }
        return redirect()->back()->with('success', 'Payment Method Status Updated');
    }

    public function updatemethod(Request $request)
    {
        $this->ensureWdmethodSchema();

        if (!Schema::hasTable('wdmethods')) {
            return redirect()->back()->with('error', 'Payment methods table is missing. Run the required migration first.');
        }

        $this->validate($request, [
            'barcode' => 'image|mimes:jpg,jpeg,png|max:500',
        ]);

        $method =  Wdmethod::where('id', $request->id)->first();

        if ($request->hasfile('barcode')) {
            $file = $request->file('barcode');
            if (Storage::disk('public')->exists($method->barcode)) {
                Storage::disk('public')->delete($method->barcode);
            }

            $path = $file->store('photos', 'public');
        } else {
            $path = $method->barcode;
        }

        $method = $this->fillPaymentMethodModel($method, $request, $path);
        $method->save();

        return redirect()->back()->with('success', 'Payment Method Updated');
    }

    public function paypreference(Request $request)
    {

        Settings::where('id', 1)
            ->update([
                'withdrawal_option' => $request['withdrawal_option'],
                'deposit_option' => $request['deposit_option'],
                'auto_merchant_option' => $request->merchat,
                'deduction_option' => $request->deduction_option,
                'credit_card_provider' => $request->credit_card_provider,
            ]);

        SettingsCont::where('id', 1)->update([
            'minamt' => $request->minamt,
        ]);

        return response()->json(['status' => 200, 'success' => 'Payment Option Saved successfully']);
    }

    //save CoinPayments credentials to DB
    public function updatecpd(Request $request)
    {
        $coinpayment = $this->singletonRecord(CpTransaction::class);
        $coinpayment->cp_p_key = $request['cp_p_key'];
        $coinpayment->cp_pv_key = $request['cp_pv_key'];
        $coinpayment->cp_m_id = $request['cp_m_id'];
        $coinpayment->cp_ipn_secret = $request['cp_ipn_secret'];
        $coinpayment->cp_debug_email = $request['cp_debug_email'];
        $coinpayment->save();

        return response()->json(['status' => 200, 'success' => 'Coinpayment Settings Saved successfully']);
    }

    //save paystack credentials to DB
    public function updategateway(Request $request)
    {

        Settings::where('id', '1')
            ->update([
                's_s_k' => $request['s_s_k'],
                's_p_k' => $request['s_p_k'],
                'pp_ci' => $request['pp_ci'],
                'pp_cs' => $request['pp_cs'],
            ]);

        $paystack = $this->singletonRecord(Paystack::class);
        $paystack->paystack_public_key = $request['paystack_public_key'];
        $paystack->paystack_secret_key = $request['paystack_secret_key'];
        $paystack->paystack_url = $request['paystack_url'];
        $paystack->paystack_email = $request['paystack_email'];
        $paystack->save();

        $settingChanges = $this->singletonRecord(SettingsCont::class);
        $settingChanges->flw_public_key = $request->flw_public_key;
        $settingChanges->flw_secret_key = $request->flw_secret_key;
        $settingChanges->flw_secret_hash = $request->flw_secret_hash;
        $settingChanges->bnc_api_key = $request->bnc_api_key;
        $settingChanges->bnc_secret_key = $request->bnc_secret_key;
        $settingChanges->save();

        return response()->json(['status' => 200, 'success' => ' Gateway Settings updated successfully']);
    }

    public function updateTransfer(Request $request)
    { 

        SettingsCont::where('id', 1)->update([
            'use_transfer' => $request->usertransfer,
            'min_transfer' => $request->min_transfer,
            'transfer_charges' => $request->charges,
        ]);
        return response()->json(['status' => 200, 'success' => 'Settings updated successfully']);
    }
}
