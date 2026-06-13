<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting as SettingModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class SettingsPayment extends Component
{
    use WithFileUploads;

    public array $paymentMethods = [];

    public function mount(): void
    {
        $saved = json_decode(SettingModel::get('payment_methods', '[]'), true);
        $this->paymentMethods = is_array($saved) ? $saved : [];
    }

    public function save(): void
    {
        $this->validate([
            'paymentMethods.*.name' => 'nullable|string|max:255',
            'paymentMethods.*.logo' => 'nullable',
        ]);

        $processed = [];
        foreach ($this->paymentMethods as $method) {
            $logo = $method['logo'] ?? '';
            if ($logo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $logo = $logo->store('payment-logos', 'public');
            }
            $processed[] = [
                'name' => $method['name'] ?? '',
                'logo' => $logo,
            ];
        }
        $this->paymentMethods = $processed;

        SettingModel::set('payment_methods', json_encode($this->paymentMethods));

        AdminLog::log('update_settings', 'Metode pembayaran diperbarui');
        $this->dispatch('show-toast', message: 'Metode pembayaran berhasil disimpan.', type: 'success');
    }

    public function addPaymentMethod(): void
    {
        $this->paymentMethods[] = ['name' => '', 'logo' => ''];
    }

    public function removePaymentMethod(int $index): void
    {
        unset($this->paymentMethods[$index]);
        $this->paymentMethods = array_values($this->paymentMethods);
    }

    public function render()
    {
        return view('livewire.admin.settings-payment');
    }
}
