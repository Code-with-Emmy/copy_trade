<?php

namespace App\Http\Livewire\Admin;

use App\Traits\PingServer;
use Livewire\Component;

class BuySlot extends Component
{
    use PingServer;
    public $amount;
    public $amountPerSlot;
    public $slot;
    public $message;

    public function mount()
    {
        $response = $this->fetctApi('/settings');
        $this->amountPerSlot = (int) data_get($this->apiResponseData($response, []), 'amount_per_slot', 0);
    }

    public function render()
    {
        return view('livewire.admin.buy-slot');
    }

    public function calculateSlot()
    {
        $slot = $this->slot ? $this->slot : 0;
        $this->amount = $slot * intval($this->amountPerSlot);
        $this->message = '';
    }


    public function purchaseSlot()
    {
        if ($this->slot > 0) {
            $response = $this->fetctApi('/purchase-slot', [
                'slot' => $this->slot,
                'amount' => $this->amount
            ], 'POST');
            if ($response->failed()) {
                session()->flash('message', $this->apiResponseMessage($response));
            } else {
                session()->flash('success', $this->apiResponseMessage($response, 'Slot purchased successfully.'));
            }
            return redirect()->route('tsettings');
        } else {
            $this->message = 'Invalid Number of slot';
        }
    }
}
