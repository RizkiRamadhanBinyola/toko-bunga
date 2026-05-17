<?php

namespace App\Livewire\Admin;

use App\Models\Setting as SettingModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Settings extends Component
{
    public string $whatsappNumber = '';

    public string $storeName = '';

    public string $storeAddress = '';

    public function mount(): void
    {
        $this->whatsappNumber = SettingModel::get('whatsapp_number', '');
        $this->storeName = SettingModel::get('store_name', '');
        $this->storeAddress = SettingModel::get('store_address', '');
    }

    public function save(): void
    {
        $this->validate([
            'whatsappNumber' => 'nullable|string|max:30',
            'storeName' => 'nullable|string|max:255',
            'storeAddress' => 'nullable|string|max:500',
        ]);

        SettingModel::set('whatsapp_number', $this->whatsappNumber);
        SettingModel::set('store_name', $this->storeName);
        SettingModel::set('store_address', $this->storeAddress);

        session()->flash('message', 'Pengaturan berhasil disimpan.');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
