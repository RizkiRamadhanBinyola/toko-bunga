<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fresh Flowers',
                'children' => ['Bouquet', 'Rustic Bouquet', 'Standing Flower'],
            ],
            [
                'name' => 'Occasion',
                'children' => ['Wedding', 'Sympathy', 'Congratulation'],
            ],
            [
                'name' => 'Grand Opening',
                'children' => ['Standing Banner', 'Table Flower', 'Premium Arrangement'],
            ],
        ];

        foreach ($categories as $cat) {
            $parent = Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'status' => true,
            ]);

            foreach ($cat['children'] as $child) {
                Category::create([
                    'name' => $child,
                    'slug' => Str::slug($child),
                    'parent_id' => $parent->id,
                    'status' => true,
                ]);
            }
        }
    }
}
