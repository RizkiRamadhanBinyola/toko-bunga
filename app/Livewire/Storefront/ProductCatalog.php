<?php

namespace App\Livewire\Storefront;

use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.storefront')]
class ProductCatalog extends Component
{
    use WithPagination;

    // ── Filters (synced to URL query string) ──────────────────────
    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(as: 'category', except: '')]
    public string $categorySlug = '';

    #[Url(as: 'sort', except: 'latest')]
    public string $sort = 'latest';

    #[Url(as: 'min', except: '')]
    public string $minPrice = '';

    #[Url(as: 'max', except: '')]
    public string $maxPrice = '';

    // ── Reset pagination when filters change ──────────────────────
    public function updatedSearch(): void       { $this->resetPage(); }
    public function updatedCategorySlug(): void { $this->resetPage(); }
    public function updatedSort(): void         { $this->resetPage(); }
    public function updatedMinPrice(): void     { $this->resetPage(); }
    public function updatedMaxPrice(): void     { $this->resetPage(); }

    public function setCategory(string $slug): void
    {
        $this->categorySlug = $slug;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search      = '';
        $this->categorySlug = '';
        $this->sort        = 'latest';
        $this->minPrice    = '';
        $this->maxPrice    = '';
        $this->resetPage();
    }

    public function render()
    {
        // ── Resolve category filter ───────────────────────────────
        $categoryIds = collect();
        $activeCategory = null;

        if ($this->categorySlug) {
            $activeCategory = Category::where('slug', $this->categorySlug)->active()->first();
            if ($activeCategory) {
                // Include parent + all children
                $categoryIds = $activeCategory->children()->active()->pluck('id')
                    ->push($activeCategory->id);
            }
        }

        // ── Build query ───────────────────────────────────────────
        $query = Product::active()->with(['category', 'variants']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('description', 'like', "%{$this->search}%");
            });
        }

        if ($categoryIds->isNotEmpty()) {
            $query->whereIn('category_id', $categoryIds);
        }

        // Price filter — compare against product base price
        if ($this->minPrice !== '') {
            $query->where('price', '>=', (float) $this->minPrice);
        }
        if ($this->maxPrice !== '') {
            $query->where('price', '<=', (float) $this->maxPrice);
        }

        // Sort
        match ($this->sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            default      => $query->latest(),
        };

        // ── Price range for slider hints ──────────────────────────
        $priceMin = Product::active()->min('price') ?? 0;
        $priceMax = Product::active()->max('price') ?? 10000000;

        return view('livewire.storefront.product-catalog', [
            'products'       => $query->paginate(12),
            'categories'     => Category::parents()->active()->with('children')->orderBy('name')->get(),
            'activeCategory' => $activeCategory,
            'priceMin'       => (int) $priceMin,
            'priceMax'       => (int) $priceMax,
            'totalResults'   => $query->count(),
        ])->title($activeCategory ? $activeCategory->name . ' — Produk' : 'Semua Produk');
    }
}
