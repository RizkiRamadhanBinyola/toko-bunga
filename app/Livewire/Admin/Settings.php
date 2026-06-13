<?php

namespace App\Livewire\Admin;

use App\Models\AdminLog;
use App\Models\Setting as SettingModel;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class Settings extends Component
{
    use WithFileUploads;

    public string $whatsappNumber = '';
    public string $storeName = '';
    public string $storeAddress = '';
    public string $storeDescription = '';

    public string $homeBannerHeading = '';
    public string $homeBannerHighlight = '';
    public string $homeBannerSubheading = '';
    public string $homeBannerDescription = '';

    public $homeHeroBackgroundUpload;
    public string $homeHeroBackground = '';

    public bool $showCategoriesSection = true;
    public string $categoriesSectionTitle = '';
    public string $categoriesSectionDescription = '';

    public bool $showLatestProductsSection = true;
    public string $latestProductsSectionTitle = '';
    public string $latestProductsSectionDescription = '';

    public bool $showCtaSection = true;
    public string $ctaSectionTitle = '';
    public string $ctaSectionDescription = '';

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
        $this->homeHeroBackground = SettingModel::get('home_hero_background', '');

        $this->showCategoriesSection = SettingModel::get('show_categories_section', '1') === '1';
        $this->categoriesSectionTitle = SettingModel::get('categories_section_title', 'Kategori Produk');
        $this->categoriesSectionDescription = SettingModel::get('categories_section_description', 'Pilih kategori bunga papan yang Anda butuhkan');

        $this->showLatestProductsSection = SettingModel::get('show_latest_products_section', '1') === '1';
        $this->latestProductsSectionTitle = SettingModel::get('latest_products_section_title', 'Produk Terbaru');
        $this->latestProductsSectionDescription = SettingModel::get('latest_products_section_description', 'Rangkaian bunga papan pilihan untuk Anda');

        $this->showCtaSection = SettingModel::get('show_cta_section', '1') === '1';
        $this->ctaSectionTitle = SettingModel::get('cta_section_title', 'Pesan Sekarang');
        $this->ctaSectionDescription = SettingModel::get('cta_section_description', 'Hubungi kami via WhatsApp untuk konsultasi dan pemesanan bunga papan');

        $this->footerMapLocation = SettingModel::get('footer_map_location', '');
    }

    public function save(): void
    {
        $rules = [
            'whatsappNumber' => 'nullable|string|max:30',
            'storeName' => 'nullable|string|max:255',
            'storeAddress' => 'nullable|string|max:500',
            'storeDescription' => 'nullable|string|max:500',
            'homeBannerHeading' => 'nullable|string|max:255',
            'homeBannerHighlight' => 'nullable|string|max:255',
            'homeBannerSubheading' => 'nullable|string|max:255',
            'homeBannerDescription' => 'nullable|string|max:500',
            'homeHeroBackgroundUpload' => 'nullable|image|max:2048',
            'showCategoriesSection' => 'boolean',
            'categoriesSectionTitle' => 'nullable|string|max:255',
            'categoriesSectionDescription' => 'nullable|string|max:500',
            'showLatestProductsSection' => 'boolean',
            'latestProductsSectionTitle' => 'nullable|string|max:255',
            'latestProductsSectionDescription' => 'nullable|string|max:500',
            'showCtaSection' => 'boolean',
            'ctaSectionTitle' => 'nullable|string|max:255',
            'ctaSectionDescription' => 'nullable|string|max:500',
            'footerMapLocation' => 'nullable|string|max:500',
        ];

        $this->validate($rules);

        if ($this->homeHeroBackgroundUpload) {
            $this->homeHeroBackground = $this->homeHeroBackgroundUpload->store('settings', 'public');
            $this->homeHeroBackgroundUpload = null;
        }

        SettingModel::set('whatsapp_number', $this->whatsappNumber);
        SettingModel::set('store_name', $this->storeName);
        SettingModel::set('store_address', $this->storeAddress);
        SettingModel::set('store_description', $this->storeDescription);

        SettingModel::set('home_banner_heading', $this->homeBannerHeading);
        SettingModel::set('home_banner_highlight', $this->homeBannerHighlight);
        SettingModel::set('home_banner_subheading', $this->homeBannerSubheading);
        SettingModel::set('home_banner_description', $this->homeBannerDescription);
        SettingModel::set('home_hero_background', $this->homeHeroBackground);

        SettingModel::set('show_categories_section', $this->showCategoriesSection ? '1' : '0');
        SettingModel::set('categories_section_title', $this->categoriesSectionTitle);
        SettingModel::set('categories_section_description', $this->categoriesSectionDescription);

        SettingModel::set('show_latest_products_section', $this->showLatestProductsSection ? '1' : '0');
        SettingModel::set('latest_products_section_title', $this->latestProductsSectionTitle);
        SettingModel::set('latest_products_section_description', $this->latestProductsSectionDescription);

        SettingModel::set('show_cta_section', $this->showCtaSection ? '1' : '0');
        SettingModel::set('cta_section_title', $this->ctaSectionTitle);
        SettingModel::set('cta_section_description', $this->ctaSectionDescription);

        SettingModel::set('footer_map_location', $this->footerMapLocation);

        AdminLog::log('update_settings', 'Pengaturan toko diperbarui');

        $this->dispatch('show-toast', message: 'Pengaturan berhasil disimpan.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
