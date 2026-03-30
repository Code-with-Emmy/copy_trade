<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingsCont;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ManageAssetController extends Controller
{
    protected array $supportedAssets = [
        'btc',
        'eth',
        'ltc',
        'link',
        'bnb',
        'aave',
        'usdt',
        'bch',
        'xrp',
        'xlm',
        'ada',
    ];

    protected function ensureAssetColumns(): void
    {
        if (!Schema::hasTable('settings_conts')) {
            return;
        }

        foreach ($this->supportedAssets as $asset) {
            if (!Schema::hasColumn('settings_conts', $asset)) {
                Schema::table('settings_conts', function (Blueprint $table) use ($asset) {
                    $table->string($asset)->nullable()->default('disabled');
                });
            }
        }
    }

    protected function settingsRecord(): SettingsCont
    {
        $this->ensureAssetColumns();

        return SettingsCont::query()->firstOrNew(['id' => 1], [
            'use_crypto_feature' => 'false',
            'use_transfer' => 'false',
            'currency_rate' => '1',
            'fee' => '0',
        ]);
    }

    public function setassetstatus($asset, $status){
        $this->ensureAssetColumns();

        if (!in_array($asset, $this->supportedAssets, true)) {
            return redirect()->back()->with('message', 'Unsupported asset selected.');
        }

        $settings = $this->settingsRecord();
        $settings->{$asset} = $status;
        $settings->save();

        return redirect()->back()->with('success', "Asset Status $status");
    }

    public function useexchange($value){
        $settings = $this->settingsRecord();
        $settings->use_crypto_feature = $value;
        $settings->save();

        return response()->json(['status'=> 200, 'success'=> "Action Successful"]);
    }

    public function exchangefee(Request $request){
        if ($request->rate) {
            $rate = $request->rate;
        }else {
            $rate = NULL;
        }

        $settings = $this->settingsRecord();
        $settings->fee = $request->fee;
        $settings->currency_rate = $rate;
        $settings->save();

        return redirect()->back()->with('success', "Exchange fee and Rate Updated");
    }
}
