# E-Commerce Florist — Agent Guide

Florist catalog website with admin dashboard + WhatsApp redirect orders. No payment, no cart, no customer login.

## Stack (verified from config files)
- **Laravel 12** (`composer.json` → `"laravel/framework": "^12.0"`)
- **Livewire 4** (`"livewire/livewire": "^4.3"`) — NOT v3 as older docs said
- **Tailwind CSS 4** (`"tailwindcss": "^4.0.0"`) — config-free (just `@import "tailwindcss"` in CSS)
- **Vite 7** with `@tailwindcss/vite` + `laravel-vite-plugin`
- **MySQL** (dev) / **SQLite** (testing — `phpunit.xml` uses `:memory:`)
- No Alpine.js, Lucide, or Heroicons packages installed yet

## Current state

Built. All custom code exists:
- 4 migrations (categories, products, product_images, settings)
- 4 models (Category, Product, ProductImage, Setting)
- 4 Admin Livewire components (Dashboard, CategoryManager, ProductManager, Settings)
- 4 Storefront Livewire components (Navbar, Homepage, CategoryPage, ProductDetail)
- 2 Blade layouts (admin, storefront)
- 4 seeders with demo data (categories + products + settings)
- Routes: `/`, `/category/{slug}`, `/product/{slug}`, `/admin/*`

## Developer commands (from `composer.json`)

```bash
# Full setup (first time)
composer setup

# Dev: runs 3 processes: server, queue, vite
composer dev

# Test: runs config:clear + artisan test (SQLite in-memory)
composer test

# Reset + reseed
php artisan migrate:fresh --seed

# Individual
php artisan serve
npm run build          # Vite build
npm run dev            # Vite dev server
```

## Windows quirks
- `php artisan pail` requires Unix-only `pcntl` extension — removed from `composer dev`. Use `storage/logs/laravel.log` on Windows instead.

## Architecture conventions (from AGENTS.md, reconcile with code)
- Livewire components go in `App\Livewire\Admin\*` and `App\Livewire\Storefront\*`
- Blade views in `resources/views/livewire/admin/` and `resources/views/livewire/storefront/`
- All CRUD must be Livewire (no jQuery, no traditional form submits)
- WhatsApp redirect via `wa.me` URL with encoded message

## Database schema (target, not yet migrated)

**categories:** id, name, slug, parent_id (nullable → subcategory, max 2 levels), thumbnail, status, timestamps
**products:** id, category_id, name, slug, price, description, thumbnail, status, timestamps
**product_images:** id, product_id, image_url, created_at

## Env quirks
- `.env` defaults to SQLite (DB_CONNECTION=sqlite). Uses `database/database.sqlite`.
- `.env.example` also SQLite-first but documents MySQL params as comments
- `.editorconfig`: 4-space indent, LF line endings, UTF-8

## Coding standards
- PSR-4: `App\` → `app/`, `Database\Factories\` → `database/factories/`, `Tests\` → `tests/`
- Laravel Pint for formatting (`"laravel/pint": "^1.24"` in dev)
- No Testbench or Pest — uses PHPUnit 11
- No `opencode.json` config exists in this repo
