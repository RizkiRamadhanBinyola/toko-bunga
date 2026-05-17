<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalCategories' => Category::count(),
            'totalProducts' => Product::count(),
            'latestProducts' => Product::with(['category', 'variants'])->latest()->take(5)->get(),
        ]);
    }
}
