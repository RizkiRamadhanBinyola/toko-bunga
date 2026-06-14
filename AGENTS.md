# Toko Bunga — Florist E-Commerce (Laravel 12 + Livewire 4)

Catalog website with admin dashboard, WhatsApp order redirects. No cart, no payment, no customer login.

## Stack
- Laravel 12, Livewire 4, Tailwind CSS 4, Vite 7
- Alpine.js (bundled with Livewire 4, no separate package)
- MySQL (dev `.env`) / SQLite in-memory (testing `phpunit.xml`)

## Dev commands
- `composer setup` — full first-time setup
- `composer dev` — runs server + queue + vite concurrently
- `composer test` — runs `config:clear && artisan test` (SQLite in-memory)
- `php artisan migrate:fresh --seed` — reset + reseed
- **Windows:** `php artisan pail` unavailable (requires `pcntl`); use `storage/logs/laravel.log`
- `./vendor/bin/pint` — Laravel code style fixer (dev dep)

## Architecture
- **Admin components** (9): `Dashboard`, `CategoryManager`, `ProductManager`, `Settings`, `SettingsSocial`, `SettingsPayment`, `SettingsSeo`, `Login`, `Logout` — all in `App\Livewire\Admin\`
- **Storefront components** (5): `Homepage`, `Navbar`, `CategoryPage`, `ProductDetail`, `ProductCatalog` — all in `App\Livewire\Storefront\`
- **Models (6):** `Category`, `Product`, `ProductImage`, `ProductVariant`, `Setting`, `User`
- **Layouts (3):** `admin.blade.php`, `storefront.blade.php`, `guest.blade.php`
- All CRUD via Livewire (no jQuery, no traditional form submits)
- Admin routes under `/admin/*` protected by `auth` middleware; login uses `guest`
- `/category/{slug}` redirects to `/products?category={slug}` (legacy compat)

## Database quirks
- `categories.parent_id` — self-referencing FK with `cascadeOnDelete` (max 2 levels)
- `product_images` has **no timestamps** (`$timestamps = false` on model)
- `product_variants` — name/image/description/price all nullable; `sort_order` defaults to 0
- `settings` — key-value store with static `get(key, default)` / `set(key, value)` helpers (upsert)
- `Product` and `Category` both use `booted()` to auto-generate slug from name on `creating`

## Non-obvious patterns
- **Computed accessors on `Product`:** `starting_price` (lowest variant price, else base price), `display_image` (first variant image, else thumbnail)
- **Computed accessors on `ProductVariant`:** `effective_*` fields fall back to parent product's corresponding field
- **File uploads:** `ProductManager` uses `Storage::disk('public')` with `WithFileUploads` trait
- **WhatsApp order flow:** `ProductDetail` builds a structured message → `rawurlencode()` → `wa.me` redirect
- **SweetAlert2:** imported globally in `resources/js/app.js` (aliased as `window.Swal`). Used for delete confirmation dialogs in admin blade views AND toast notifications via global Alpine `x-on:show-toast.window` handler in `layouts/admin.blade.php`. Toast messages are dispatched via `$this->dispatch('show-toast', ...)`
- **URL-persisted filters:** `ProductCatalog` uses `#[Url]` attribute on all filter properties
- **Pagination:** 10 per page (admin), 12 per page (storefront)
- **Alpine.js:** used for sidebar, navbar dropdown/mobile menu, variant carousel (injected by Livewire 4)

## Seeders
- Admin user: `admin@bunga.test` / `admin123`
- 12 categories (3 parents × 3 children each), 12 products, 4 settings (`whatsapp_number`, `store_name`, `store_address`, `store_description`). Settings component manages 9 keys: the 4 above plus `home_banner_*` (3) and `footer_map_location`

## Deployment ke InfinityFree

### Prasyarat
- PHP 8.2+ (cek Panel InfinityFree → PHP version)
- MySQL database (buat via InfinityFree control panel)
- FTP client (FileZilla atau sejenisnya)

### Langkah-langkah

#### 1. Persiapan lokal
```bash
# Install production dependencies (tanpa dev)
composer install --no-dev --optimize-autoloader

# Build Vite assets
npm install && npm run build

# Cache config/routes/views (opsional — jalankan dengan .env production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 2. Upload via FTP
Upload seluruh folder berikut (kecuali yg tidak perlu):
| Upload | Skip |
|--------|------|
| `public/` | `.git/` |
| `app/` | `node_modules/` |
| `bootstrap/` | `.env` (buat baru) |
| `config/` | `storage/framework/cache/data/` |
| `database/` | |
| `resources/` | |
| `routes/` | |
| `storage/` (isi folder) | |
| `vendor/` | |
| `public/build/` (hasil `npm run build`) | |
| `.htaccess` | |
| `composer.json`, `composer.lock` | |

#### 3. Setup di InfinityFree
1. Buat file `.env` di root dengan isi dari `.env.example`, sesuaikan:
   - `APP_URL` → domain InfinityFree (https://namadomain.epizy.com)
   - `DB_*` → kredensial MySQL dari panel InfinityFree
   - `APP_DEBUG=false`
   - `APP_ENV=production`
   - `SESSION_DOMAIN` → domain kamu
   - `SESSION_SECURE_COOKIE=true`
   - `QUEUE_CONNECTION=sync` (penting — InfinityFree tdk support queue worker)

2. Akses `https://namadomain.epizy.com/setup/storage-link` **sekali** untuk membuat symlink storage (hapus route ini setelahnya)

3. Import database:
   - Export dari phpMyAdmin lokal, atau jalankan migration via URL (butuh route khusus) — atau upload database.sql manual

#### 4. Setelah deploy
- Login admin di `/admin/login` (user: `admin@bunga.test` / `admin123`)
- **Segera ganti password admin!**
- Hapus route `/setup/storage-link` dari `routes/web.php`
- Set favicon, SEO meta, dan pengaturan toko via admin panel

### Catatan penting
- **Tidak ada SSH** → semua persiapan harus dilakukan lokal, lalu diupload via FTP
- **Queue worker tidak bisa jalan** → `QUEUE_CONNECTION=sync` (eksekusi langsung)
- **Session & Cache** pakai database → pastikan tabel `sessions`, `cache`, `jobs` sudah termigrasi
- **Storage link** harus dibuat manual via route `/setup/storage-link`
- **HTTPS** → InfinityFree pakai Cloudflare, pastikan `SESSION_SECURE_COOKIE=true`
- **Error pages** custom sudah tersedia (403, 404, 419, 500, 503)
- **Livewire file uploads** — Pastikan folder `storage/tmp/` ikut terupload. File `public/.user.ini` akan mengarahkan `upload_tmp_dir` ke folder tsb, dan `AppServiceProvider` set `TMPDIR` env var sebagai fallback. Jika upload foto masih gagal, cek apakah `storage/tmp/` writable (755) di hosting.
