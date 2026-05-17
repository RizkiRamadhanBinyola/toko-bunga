<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $names = [
            'Bunga Papan Ucapan Selamat', 'Bunga Papan Dukacita', 'Bunga Papan Grand Opening',
            'Karangan Bunga Standing', 'Bouquet Mawar Merah', 'Bouquet Mawar Putih',
            'Bunga Meja Elegan', 'Hand Bouquet Premium', 'Bunga Papan Wedding',
            'Bouquet Campuran', 'Standing Flower Custom', 'Bunga Papan Promosi',
        ];

        $name = fake()->unique()->randomElement($names);

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.fake()->numberBetween(1, 999)),
            'price' => fake()->numberBetween(100000, 5000000),
            'description' => fake()->paragraph(3),
            'status' => true,
        ];
    }
}
