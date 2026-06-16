<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting as SettingModel;
use Illuminate\Support\Str;
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
                $extension = $logo->getClientOriginalExtension() ?: 'jpg';
                $filename = Str::random(40) . '.' . $extension;
                $relPath = 'uploads/payment-logos/' . $filename;
                $destPath = public_path($relPath);

                $dir = dirname($destPath);
                if (!is_dir($dir)) {
                    mkdir($dir, 0755, true);
                }

                $written = file_put_contents($destPath, $logo->get());
                if ($written === false) {
                    $this->dispatch('show-toast', message: 'Gagal menulis file logo.', type: 'error');
                    return;
                }

                $logo = $relPath;
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
