<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\Settings;
use App\Livewire\Storefront\ProductCatalog;
use App\Livewire\Storefront\CategoryPage;
use App\Livewire\Storefront\Homepage;
use App\Livewire\Storefront\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ─── Storefront ───────────────────────────────────────────────────────────────
Route::get('/', Homepage::class)->name('home');
Route::get('/products', ProductCatalog::class)->name('products');
Route::get('/product/{slug}', ProductDetail::class)->name('product.show');

// Redirect lama /category/{slug} → /products?category={slug} agar link lama tidak 404
Route::get('/category/{slug}', function (string $slug) {
    return redirect()->route('products', ['category' => $slug]);
})->name('category.show');

// ─── Admin Auth ───────────────────────────────────────────────────────────────
Route::prefix('admin')->group(function () {
    // Login (guest only)
    Route::get('/login', Login::class)
        ->name('admin.login')
        ->middleware('guest');

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('admin.login');
    })->name('admin.logout');

    // Protected admin routes
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
        Route::get('/categories', CategoryManager::class)->name('admin.categories');
        Route::get('/products', ProductManager::class)->name('admin.products');
        Route::get('/settings', Settings::class)->name('admin.settings');
    });
});
