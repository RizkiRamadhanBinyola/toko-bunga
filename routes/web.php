<?php

use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Login;
use App\Livewire\Admin\ProductManager;
use App\Livewire\Admin\Settings;
use App\Livewire\Admin\SettingsPayment;
use App\Livewire\Admin\SettingsSeo;
use App\Livewire\Admin\SettingsSocial;
use App\Models\AdminLog;
use App\Livewire\Storefront\ProductCatalog;
use App\Livewire\Storefront\CategoryPage;
use App\Livewire\Storefront\Homepage;
use App\Livewire\Storefront\ProductDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;

// ─── Setup (hapus route ini setelah deploy pertama) ───────────────────────────
Route::get('/setup/storage-link', function () {
    $target = storage_path('app/public');
    $link = public_path('storage');
    if (file_exists($link) && is_link($link)) {
        return 'Storage link already exists.';
    }
    if (file_exists($link)) {
        return 'A file/directory named "storage" already exists in public/.';
    }
    symlink($target, $link);
    return 'Storage link created!';
});

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
        AdminLog::log('logout', 'Admin logout');
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
        Route::get('/settings/social', SettingsSocial::class)->name('admin.settings.social');
        Route::get('/settings/payment', SettingsPayment::class)->name('admin.settings.payment');
        Route::get('/settings/seo', SettingsSeo::class)->name('admin.settings.seo');

        // Export log aktivitas ke Excel
        Route::get('/logs/export', function () {
            $months = (int) request('months', 3);

            $query = AdminLog::with('user');

            if ($months > 0) {
                $query->where('created_at', '>=', now()->subMonths($months));
            }

            $logs = $query->orderByDesc('created_at')->get();

            $writer = new Writer();
            $writer->openToBrowser('log-aktivitas.xlsx');

            $writer->addRow(Row::fromValues(['Waktu', 'Admin', 'Aksi', 'Deskripsi', 'IP Address', 'User Agent']));

            foreach ($logs as $log) {
                $writer->addRow(Row::fromValues([
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->user?->name ?? '—',
                    $log->action,
                    $log->description ?? '—',
                    $log->ip_address ?? '—',
                    $log->user_agent ?? '—',
                ]));
            }

            $writer->close();
            exit;
        })->name('admin.logs.export');
    });
});
