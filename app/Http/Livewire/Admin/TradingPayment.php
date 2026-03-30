<?php

namespace App\Http\Livewire\Admin;

use App\Traits\PingServer;
use Livewire\Component;
use Livewire\WithFileUploads;

class TradingPayment extends Component
{
    public $amount;
    public $toPay;
    public $wallet;
    public $walletAddress;
    public $method;
    public $screenshot;
    use WithFileUploads;
    use PingServer;

    public function mount()
    {
        $response = $this->fetctApi('/settings');
        $wallet = $this->apiResponseData($response, []);
        $this->toPay = false;
        $this->method = data_get($wallet, 'currency_name', 'USDT');
        $this->walletAddress = data_get($wallet, 'wallet_address', '');
        $this->wallet = $wallet;
    }

    public function render()
    {
        return view('livewire.admin.trading-payment');
    }

    public function setToPay()
    {
        $this->toPay = true;
    }

    public function unSetToPay()
    {
        $this->toPay = false;
    }


    public function completePayment()
    {
        $response = $this->fetctApi('/save-payment', [
            'amount' => $this->amount,
        ], 'POST');

        if ($response->failed()) {
            session()->flash('message', $this->apiResponseMessage($response));
        } else {
            session()->flash('success', $this->apiResponseMessage($response, 'Payment saved successfully.'));
        }
        return redirect()->route('tra.pay');
    }
}
