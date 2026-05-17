<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.storefront.navbar', [
            'categories' => Category::parents()->active()->with('children')->orderBy('name')->get(),
        ]);
    }
}
