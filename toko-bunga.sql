-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Jun 2026 pada 15.50
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko-bunga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `user_id`, `action`, `description`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'login', 'Admin login', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 08:07:05', '2026-06-14 08:07:05'),
(2, 1, 'create_product', 'Produk: ', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 08:08:27', '2026-06-14 08:08:27'),
(3, 1, 'update_product', 'Produk: ', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 08:09:08', '2026-06-14 08:09:08'),
(4, 1, 'create_product', 'Produk: ', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 09:41:55', '2026-06-14 09:41:55'),
(5, 1, 'update_settings', 'Pengaturan toko diperbarui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(6, 1, 'update_settings', 'Pengaturan toko diperbarui', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 12:44:58', '2026-06-14 12:44:58'),
(7, 1, 'update_product', 'Produk: tes', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 13:07:17', '2026-06-14 13:07:17'),
(8, 1, 'update_product', 'Produk: tes produk', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 13:31:24', '2026-06-14 13:31:24'),
(9, 1, 'delete_product', 'Produk: tes produk', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 13:32:41', '2026-06-14 13:32:41'),
(10, 1, 'delete_product', 'Produk: tes', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', '2026-06-14 13:32:44', '2026-06-14 13:32:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('toko-bunga-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:2;', 1781441138),
('toko-bunga-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1781441138;', 1781441138);

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `parent_id`, `thumbnail`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fresh Flowers', 'fresh-flowers', NULL, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(2, 'Bouquet', 'bouquet', 1, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(3, 'Rustic Bouquet', 'rustic-bouquet', 1, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(4, 'Standing Flower', 'standing-flower', 1, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(5, 'Occasion', 'occasion', NULL, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(6, 'Wedding', 'wedding', 5, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(7, 'Sympathy', 'sympathy', 5, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(8, 'Congratulation', 'congratulation', 5, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(9, 'Grand Opening', 'grand-opening', NULL, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(10, 'Standing Banner', 'standing-banner', 9, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(11, 'Table Flower', 'table-flower', 9, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(12, 'Premium Arrangement', 'premium-arrangement', 9, NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_16_183742_create_categories_table', 1),
(5, '2026_05_16_183752_create_products_table', 1),
(6, '2026_05_16_183759_create_product_images_table', 1),
(7, '2026_05_16_183806_create_settings_table', 1),
(8, '2026_05_17_000001_create_product_variants_table', 1),
(9, '2026_05_17_000003_add_name_to_product_variants', 1),
(10, '2026_06_13_160106_create_admin_logs_table', 1),
(11, '2026_06_14_154424_add_status_to_product_variants', 2),
(12, '2026_06_14_155408_add_extra_images_to_product_variants', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `price`, `description`, `thumbnail`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 'Bunga Papan Ucapan Selamat', 'bunga-papan-ucapan-selamat', 350000.00, 'Sequi omnis quos molestias quae. At quisquam vitae rem hic neque quam.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(2, 7, 'Bunga Papan Dukacita', 'bunga-papan-dukacita', 300000.00, 'In modi quia quia natus numquam tenetur. Earum nulla voluptas qui magnam ipsa velit.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(3, 1, 'Standing Flower Premium', 'standing-flower-premium', 750000.00, 'Culpa molestiae odit et similique exercitationem. Velit quia repellendus id accusamus. Sint sint et architecto reiciendis assumenda provident facilis sapiente.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(4, 3, 'Bouquet Mawar Merah', 'bouquet-mawar-merah', 250000.00, 'Est maxime alias illum non aliquid eum nobis velit. Neque asperiores ea eveniet ea molestiae. Corrupti qui repellat assumenda vitae et ullam.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(5, 7, 'Bouquet Mawar Putih', 'bouquet-mawar-putih', 250000.00, 'Architecto et impedit illo ipsa officia vel odit. Provident rerum autem a voluptatem atque ut blanditiis. Debitis aliquid laudantium unde non et voluptate.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(6, 11, 'Hand Bouquet Elegant', 'hand-bouquet-elegant', 180000.00, 'Repellat sed error ea blanditiis. Ut delectus corrupti nobis fugit qui.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(7, 10, 'Bunga Meja Grand Opening', 'bunga-meja-grand-opening', 500000.00, 'Enim velit voluptas quaerat odio. Totam dolor voluptas accusamus tenetur fuga molestiae ex. Assumenda velit quam velit quos.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(8, 11, 'Standing Flower Custom', 'standing-flower-custom', 1000000.00, 'Eum aspernatur magni totam. Qui aut consectetur aspernatur harum praesentium. Minus voluptates voluptatem aperiam sit et.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(9, 12, 'Bouquet Campuran Premium', 'bouquet-campuran-premium', 350000.00, 'Accusamus nisi corporis vero mollitia modi dicta. Sit odio quae in et voluptatum voluptatem architecto. Quibusdam et dolorum ut et et ea minus.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(10, 1, 'Bunga Papan Wedding', 'bunga-papan-wedding', 450000.00, 'Quia doloremque molestiae error adipisci. Incidunt nisi error molestiae alias.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(11, 5, 'Sympathy Flower Arrangement', 'sympathy-flower-arrangement', 400000.00, 'Sunt quia voluptatum nihil dolores. Illo tempora dolor velit non laudantium. Velit est magni ut dolor beatae unde.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(12, 4, 'Grand Opening Standing Banner', 'grand-opening-standing-banner', 850000.00, 'Sunt eum quam soluta inventore odio et nam. Qui quisquam rerum fugit.', NULL, 1, '2026-06-14 07:32:42', '2026-06-14 07:32:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `extra_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_images`)),
  `description` text DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('sdQql0SBtMaAFqtl9hmHwqjJ38StmpH7EhkqLtQT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUW9XMHdSM0ZkRkt6dWdCRGpyMldlU3BTcnNwZk9YVkVOUWFQSVRyRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9kdWN0cyI7czo1OiJyb3V0ZSI7czoxNDoiYWRtaW4ucHJvZHVjdHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1781443964);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'whatsapp_number', '6281234567890', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(2, 'store_name', 'Florist Elegan', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(3, 'store_address', 'Jl. Bunga Indah No. 123, Jakarta Pusat', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(4, 'store_description', 'Menyediakan rangkaian bunga papan terbaik untuk berbagai acara Anda.', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(5, 'show_categories_section', '1', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(6, 'categories_section_title', 'Kategori Produk', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(7, 'categories_section_description', 'Pilih kategori bunga papan yang Anda butuhkan', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(8, 'show_latest_products_section', '1', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(9, 'latest_products_section_title', 'Produk Terbaru', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(10, 'latest_products_section_description', 'Rangkaian bunga papan pilihan untuk Anda', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(11, 'show_cta_section', '1', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(12, 'cta_section_title', 'Pesan Sekarang', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(13, 'cta_section_description', 'Hubungi kami via WhatsApp untuk konsultasi dan pemesanan bunga papan', '2026-06-14 07:32:42', '2026-06-14 07:32:42'),
(14, 'payment_methods', '[{\"name\":\"BCA\",\"logo\":\"\"},{\"name\":\"Mandiri\",\"logo\":\"\"},{\"name\":\"BNI\",\"logo\":\"\"}]', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(15, 'social_media_instagram', 'https://instagram.com/tokobunga', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(16, 'social_media_facebook', 'https://facebook.com/tokobunga', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(17, 'social_media_tiktok', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(18, 'social_media_youtube', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(19, 'social_media_whatsapp', 'https://wa.me/6281234567890', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(20, 'seo_meta_description', 'Toko bunga papan online terpercaya. Rangkaian bunga papan untuk pernikahan, duka cita, dan berbagai acara.', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(21, 'seo_og_title', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(22, 'seo_og_description', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(23, 'seo_og_image', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(24, 'favicon', '', '2026-06-14 07:32:43', '2026-06-14 07:32:43'),
(25, 'home_banner_heading', 'Bunga Papan', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(26, 'home_banner_highlight', 'Terbaik untuk', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(27, 'home_banner_subheading', 'Momen Spesial', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(28, 'home_banner_description', 'Kami menyediakan berbagai rangkaian bunga papan elegan untuk ucapan selamat, dukacita, grand opening, dan berbagai acara lainnya.', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(29, 'home_hero_background', 'settings/P36ysS6nP8b386I4fCb1XG3Z4UnWIcF9C1Xv3gzZ.webp', '2026-06-14 12:44:49', '2026-06-14 12:44:49'),
(30, 'footer_map_location', 'Monas', '2026-06-14 12:44:49', '2026-06-14 12:44:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@bunga.test', '2026-06-14 07:32:42', '$2y$12$cTgb8xYzlI.hP2e/2DhKq.diVidopY8xZg4ysWqyiSZqxs7RFv3iC', NULL, '2026-06-14 07:32:42', '2026-06-14 07:32:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_logs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
