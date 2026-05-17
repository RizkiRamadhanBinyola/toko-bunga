<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront')]
class CategoryPage extends Component
{
    public Category $category;

    public function mount(string $slug): void
    {
        $this->category = Category::where('slug', $slug)->active()->firstOrFail();
    }

    public function render()
    {
        $categoryIds = $this->category->children()->active()->pluck('id')->push($this->category->id);

        return view('livewire.storefront.category-page', [
            'products' => Product::active()
                ->whereIn('category_id', $categoryIds)
                ->with(['category', 'variants'])
                ->latest()
                ->paginate(12),
        ]);
    }
}
