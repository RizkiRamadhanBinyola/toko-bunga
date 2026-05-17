<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Fresh Flowers', 'Bouquet', 'Standing Flower', 'Hand Bouquet',
            'Table Flower', 'Wedding Flower', 'Sympathy Flower', 'Congratulation Flower',
            'Grand Opening', 'Rustic Bouquet', 'Elegant Bouquet', 'Premium Flower',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'parent_id' => null,
            'status' => true,
        ];
    }
}
