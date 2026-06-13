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

    public string $storeDescription = '';

    public string $homeBannerHeading = '';
    public string $homeBannerHighlight = '';
    public string $homeBannerSubheading = '';
    public string $homeBannerDescription = '';

    public string $footerMapLocation = '';

    public function mount(): void
    {
        $this->whatsappNumber = SettingModel::get('whatsapp_number', '');
        $this->storeName = SettingModel::get('store_name', '');
        $this->storeAddress = SettingModel::get('store_address', '');
        $this->storeDescription = SettingModel::get('store_description', '');
        $this->homeBannerHeading = SettingModel::get('home_banner_heading', 'Bunga Papan');
        $this->homeBannerHighlight = SettingModel::get('home_banner_highlight', 'Terbaik untuk');
        $this->homeBannerSubheading = SettingModel::get('home_banner_subheading', 'Momen Spesial');
        $this->homeBannerDescription = SettingModel::get('home_banner_description', 'Kami menyediakan berbagai rangkaian bunga papan elegan untuk ucapan selamat, dukacita, grand opening, dan berbagai acara lainnya.');
        $this->footerMapLocation = SettingModel::get('footer_map_location', '');
    }

    public function save(): void
    {
        $this->validate([
            'whatsappNumber' => 'nullable|string|max:30',
            'storeName' => 'nullable|string|max:255',
            'storeAddress' => 'nullable|string|max:500',
            'storeDescription' => 'nullable|string|max:500',
            'homeBannerHeading' => 'nullable|string|max:255',
            'homeBannerHighlight' => 'nullable|string|max:255',
            'homeBannerSubheading' => 'nullable|string|max:255',
            'homeBannerDescription' => 'nullable|string|max:500',
            'footerMapLocation' => 'nullable|string|max:500',
        ]);

        SettingModel::set('whatsapp_number', $this->whatsappNumber);
        SettingModel::set('store_name', $this->storeName);
        SettingModel::set('store_address', $this->storeAddress);
        SettingModel::set('store_description', $this->storeDescription);
        SettingModel::set('home_banner_heading', $this->homeBannerHeading);
        SettingModel::set('home_banner_highlight', $this->homeBannerHighlight);
        SettingModel::set('home_banner_subheading', $this->homeBannerSubheading);
        SettingModel::set('home_banner_description', $this->homeBannerDescription);
        SettingModel::set('footer_map_location', $this->footerMapLocation);

        $this->dispatch('show-toast', message: 'Pengaturan berhasil disimpan.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
