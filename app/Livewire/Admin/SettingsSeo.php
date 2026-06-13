<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting as SettingModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class SettingsSeo extends Component
{
    use WithFileUploads;

    public string $seoMetaDescription = '';
    public string $seoOgTitle = '';
    public string $seoOgDescription = '';

    public $seoOgImageUpload = null;
    public string $seoOgImage = '';

    public $faviconUpload = null;
    public string $favicon = '';

    public function mount(): void
    {
        $this->seoMetaDescription = SettingModel::get('seo_meta_description', 'Toko bunga papan untuk berbagai acara Anda.');
        $this->seoOgTitle = SettingModel::get('seo_og_title', '');
        $this->seoOgDescription = SettingModel::get('seo_og_description', '');
        $this->seoOgImage = SettingModel::get('seo_og_image', '');
        $this->favicon = SettingModel::get('favicon', '');
    }

    public function save(): void
    {
        $this->validate([
            'seoMetaDescription' => 'nullable|string|max:500',
            'seoOgTitle'         => 'nullable|string|max:255',
            'seoOgDescription'   => 'nullable|string|max:500',
            'seoOgImageUpload'   => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'faviconUpload'      => 'nullable|image|mimes:png,ico,svg,x-icon|max:1024',
        ]);

        if ($this->seoOgImageUpload) {
            $this->seoOgImage = $this->seoOgImageUpload->store('settings', 'public');
            $this->seoOgImageUpload = null;
        }

        if ($this->faviconUpload) {
            $this->favicon = $this->faviconUpload->store('settings', 'public');
            $this->faviconUpload = null;
        }

        SettingModel::set('seo_meta_description', $this->seoMetaDescription);
        SettingModel::set('seo_og_title', $this->seoOgTitle);
        SettingModel::set('seo_og_description', $this->seoOgDescription);
        SettingModel::set('seo_og_image', $this->seoOgImage);
        SettingModel::set('favicon', $this->favicon);

        AdminLog::log('update_settings', 'Pengaturan SEO diperbarui');
        $this->dispatch('show-toast', message: 'Pengaturan SEO berhasil disimpan.', type: 'success');
    }

    public function removeFavicon(): void
    {
        if ($this->favicon) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->favicon);
        }
        $this->favicon = '';
    }

    public function removeOgImage(): void
    {
        if ($this->seoOgImage) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($this->seoOgImage);
        }
        $this->seoOgImage = '';
    }

    public function render()
    {
        return view('livewire.admin.settings-seo');
    }
}
