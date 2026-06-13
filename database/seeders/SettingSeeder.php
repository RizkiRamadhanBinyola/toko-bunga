<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('whatsapp_number', '6281234567890');
        Setting::set('store_name', 'Florist Elegan');
        Setting::set('store_address', 'Jl. Bunga Indah No. 123, Jakarta Pusat');
        Setting::set('store_description', 'Menyediakan rangkaian bunga papan terbaik untuk berbagai acara Anda.');

        Setting::set('show_categories_section', '1');
        Setting::set('categories_section_title', 'Kategori Produk');
        Setting::set('categories_section_description', 'Pilih kategori bunga papan yang Anda butuhkan');

        Setting::set('show_latest_products_section', '1');
        Setting::set('latest_products_section_title', 'Produk Terbaru');
        Setting::set('latest_products_section_description', 'Rangkaian bunga papan pilihan untuk Anda');

        Setting::set('show_cta_section', '1');
        Setting::set('cta_section_title', 'Pesan Sekarang');
        Setting::set('cta_section_description', 'Hubungi kami via WhatsApp untuk konsultasi dan pemesanan bunga papan');

        Setting::set('payment_methods', json_encode([
            ['name' => 'BCA', 'logo' => ''],
            ['name' => 'Mandiri', 'logo' => ''],
            ['name' => 'BNI', 'logo' => ''],
        ]));

        // Social media
        Setting::set('social_media_instagram', 'https://instagram.com/tokobunga');
        Setting::set('social_media_facebook', 'https://facebook.com/tokobunga');
        Setting::set('social_media_tiktok', '');
        Setting::set('social_media_youtube', '');
        Setting::set('social_media_whatsapp', 'https://wa.me/6281234567890');

        // SEO & favicon
        Setting::set('seo_meta_description', 'Toko bunga papan online terpercaya. Rangkaian bunga papan untuk pernikahan, duka cita, dan berbagai acara.');
        Setting::set('seo_og_title', '');
        Setting::set('seo_og_description', '');
        Setting::set('seo_og_image', '');
        Setting::set('favicon', '');
    }
}
