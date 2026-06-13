<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting as SettingModel;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SettingsSocial extends Component
{
    public string $socialMediaInstagram = '';
    public string $socialMediaFacebook = '';
    public string $socialMediaTiktok = '';
    public string $socialMediaYoutube = '';
    public string $socialMediaWhatsapp = '';

    public function mount(): void
    {
        $this->socialMediaInstagram = SettingModel::get('social_media_instagram', '');
        $this->socialMediaFacebook = SettingModel::get('social_media_facebook', '');
        $this->socialMediaTiktok = SettingModel::get('social_media_tiktok', '');
        $this->socialMediaYoutube = SettingModel::get('social_media_youtube', '');
        $this->socialMediaWhatsapp = SettingModel::get('social_media_whatsapp', '');
    }

    public function save(): void
    {
        $this->validate([
            'socialMediaInstagram' => 'nullable|string|max:500',
            'socialMediaFacebook'  => 'nullable|string|max:500',
            'socialMediaTiktok'    => 'nullable|string|max:500',
            'socialMediaYoutube'   => 'nullable|string|max:500',
            'socialMediaWhatsapp'  => 'nullable|string|max:500',
        ]);

        SettingModel::set('social_media_instagram', $this->socialMediaInstagram);
        SettingModel::set('social_media_facebook', $this->socialMediaFacebook);
        SettingModel::set('social_media_tiktok', $this->socialMediaTiktok);
        SettingModel::set('social_media_youtube', $this->socialMediaYoutube);
        SettingModel::set('social_media_whatsapp', $this->socialMediaWhatsapp);

        AdminLog::log('update_settings', 'Pengaturan media sosial diperbarui');
        $this->dispatch('show-toast', message: 'Pengaturan media sosial berhasil disimpan.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings-social');
    }
}
