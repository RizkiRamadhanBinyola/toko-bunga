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
    }
}
