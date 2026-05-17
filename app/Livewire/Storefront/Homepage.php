<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.storefront')]
class Homepage extends Component
{
    public function render()
    {
        return view('livewire.storefront.homepage', [
            'categories' => Category::parents()->active()->with('children')->orderBy('name')->take(6)->get(),
            'latestProducts' => Product::active()->with(['category', 'variants'])->latest()->take(8)->get(),
        ]);
    }
}
