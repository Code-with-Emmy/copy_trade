<?php

namespace App\Http\Livewire\Admin;

use App\Models\Settings;
use App\Traits\PingServer;
use Livewire\Component;

class SoftwareModule extends Component
{
    use PingServer;

    public $mod;

    public function mount()
    {
        $settings = Settings::find(1);
        $modules = $settings->modules ?? [];

        // Define default keys if they don't exist
        $defaults = [
            'investment' => false,
            'cryptoswap' => false,
            'membership' => false,
            'subscription' => false,
            'signal' => false,
        ];

        $this->mod = array_merge($defaults, $modules);
    }

    public function render()
    {
        return view('livewire.admin.software-module');
    }

    public function updateModule($module, $value)
    {
        $settings = Settings::find(1);
        $boolValue = $value === 'true';

        if ($module == 'membership' or $module == 'signal') {
            $response = $this->fetctApi('/set-modules', [
                'value' => $value,
                'module' => $module
            ], 'POST');
            $info = json_decode($response);

            if ($response->failed() or $info->error) {
                session()->flash('message', $info->message ?? 'Error communicating with server');
                return;
            }
        }

        // Update local state and DB
        $options = $settings->modules ?? [];
        $options[$module] = $boolValue;
        $settings->modules = $options;
        $settings->save();

        $this->mod[$module] = $boolValue;

        session()->flash('success', 'Module updated successfully');
    }
}