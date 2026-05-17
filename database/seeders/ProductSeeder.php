<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->toArray();

        if (empty($categoryIds)) {
            return;
        }

        $products = [
            ['name' => 'Bunga Papan Ucapan Selamat', 'price' => 350000],
            ['name' => 'Bunga Papan Dukacita', 'price' => 300000],
            ['name' => 'Standing Flower Premium', 'price' => 750000],
            ['name' => 'Bouquet Mawar Merah', 'price' => 250000],
            ['name' => 'Bouquet Mawar Putih', 'price' => 250000],
            ['name' => 'Hand Bouquet Elegant', 'price' => 180000],
            ['name' => 'Bunga Meja Grand Opening', 'price' => 500000],
            ['name' => 'Standing Flower Custom', 'price' => 1000000],
            ['name' => 'Bouquet Campuran Premium', 'price' => 350000],
            ['name' => 'Bunga Papan Wedding', 'price' => 450000],
            ['name' => 'Sympathy Flower Arrangement', 'price' => 400000],
            ['name' => 'Grand Opening Standing Banner', 'price' => 850000],
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'price' => $product['price'],
                'description' => fake()->paragraph(2),
                'status' => true,
            ]);
        }
    }
}
