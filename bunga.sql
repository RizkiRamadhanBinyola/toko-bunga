-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Bulan Mei 2026 pada 02.29
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
-- Database: `bunga`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'Fresh Flowers', 'fresh-flowers', NULL, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(2, 'Bouquet', 'bouquet', 1, 'categories/fiHxUZaWERnYq6ECYaRTw6fHTvg60068hgextYxe.jpg', 1, '2026-05-16 12:22:07', '2026-05-16 15:48:21'),
(3, 'Rustic Bouquet', 'rustic-bouquet', 1, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(4, 'Standing Flower', 'standing-flower', 1, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(5, 'Occasion', 'occasion', NULL, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(6, 'Wedding', 'wedding', 5, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(7, 'Sympathy', 'sympathy', 5, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(8, 'Congratulation', 'congratulation', 5, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(9, 'Grand Opening', 'grand-opening', NULL, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(10, 'Standing Banner', 'standing-banner', 9, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(11, 'Table Flower', 'table-flower', 9, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(12, 'Premium Arrangement', 'premium-arrangement', 9, NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07');

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
(8, '2026_05_17_000001_create_product_variants_table', 2);

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
(1, 2, 'Bunga Papan Ucapan Selamat', 'bunga-papan-ucapan-selamat', 350000.00, 'Numquam quae odio iure minima tempore sed. Voluptate alias dolor praesentium ipsa corporis quia illum.', 'products/Y4iVvr52stvfnQQEftEjeUG9nJPTPm38YyFuwkV0.png', 1, '2026-05-16 12:22:07', '2026-05-16 12:35:20'),
(2, 1, 'Bunga Papan Dukacita', 'bunga-papan-dukacita', 300000.00, 'Sapiente sapiente vel rerum et ut velit voluptatem. Debitis debitis quas autem nulla. Repellendus veritatis voluptate molestiae autem odio vel aliquam.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(3, 1, 'Standing Flower Premium', 'standing-flower-premium', 750000.00, 'Dolores maiores id alias nam velit temporibus. Assumenda cum sunt voluptatem totam molestias quibusdam. Quas consectetur sunt est quia.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(4, 1, 'Bouquet Mawar Merah', 'bouquet-mawar-merah', 250000.00, 'Voluptatem quas recusandae deleniti. Iste voluptatem ea qui eius odio non aliquid. Maiores dolores sed itaque asperiores.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(5, 6, 'Bouquet Mawar Putih', 'bouquet-mawar-putih', 250000.00, 'Omnis natus accusantium vel eum quaerat qui natus est. Iure natus temporibus ut et ipsa aut.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(6, 9, 'Hand Bouquet Elegant', 'hand-bouquet-elegant', 180000.00, 'Doloribus est eligendi perspiciatis non. Reiciendis maiores ut harum et reprehenderit fugiat. At natus qui placeat aut.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(7, 3, 'Bunga Meja Grand Opening', 'bunga-meja-grand-opening', 500000.00, 'Dolorum cumque veniam porro molestias nisi eum aliquam. Cupiditate id voluptas consequatur similique iste consequuntur in.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(8, 2, 'Standing Flower Custom', 'standing-flower-custom', 1000000.00, 'In quam dolorem neque voluptas. Alias quia ullam illo aspernatur possimus.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(9, 1, 'Bouquet Campuran Premium', 'bouquet-campuran-premium', 350000.00, 'Nisi inventore consequuntur eum eius repellat fugit maxime. Quo impedit sit qui fugit magni corporis.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(10, 4, 'Bunga Papan Wedding', 'bunga-papan-wedding', 450000.00, 'Soluta recusandae ex voluptate. Iusto aliquam quidem expedita adipisci vel ut.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(11, 10, 'Sympathy Flower Arrangement', 'sympathy-flower-arrangement', 400000.00, 'Occaecati eveniet quia qui numquam id. Adipisci totam reprehenderit consequatur numquam ea ut ea. Eos et quod iste minus molestias.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(12, 8, 'Grand Opening Standing Banner', 'grand-opening-standing-banner', 850000.00, 'Architecto sit ducimus illo itaque sed velit. Suscipit non ipsam quo provident id blanditiis consequatur.', NULL, 1, '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(13, 1, 'TES', 'tes', 124444.00, 'TES', 'products/cHAq3ZVAlcbua79Jwrbi2vZ0ny2y4DQdpMdJJpOP.png', 1, '2026-05-16 13:30:55', '2026-05-16 13:30:55');

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

--
-- Dumping data untuk tabel `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `created_at`) VALUES
(1, 1, 'product-images/awzxmrDLuvdeeQl1Pkc9QZe5ogWcNKfT9ZEvYmcB.png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `image`, `description`, `price`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 13, 'variants/Y2wPp8EbICfwvrGiquRHmP9Iu1s2hY2FtuSG1rrY.png', 'TES', 122222222.00, 0, '2026-05-16 13:32:12', '2026-05-16 13:32:12'),
(2, 13, 'variants/nGOGsl8lsDstnwEiGUmsacgf9dNlAArhRt80cDzp.png', 'ETAAEF', 3563252.00, 1, '2026-05-16 13:32:59', '2026-05-16 13:32:59');

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
(1, 'whatsapp_number', '628979912254', '2026-05-16 12:22:07', '2026-05-16 14:38:48'),
(2, 'store_name', 'Florist Elegan', '2026-05-16 12:22:07', '2026-05-16 12:22:07'),
(3, 'store_address', 'Jl. Bunga Indah No. 123, Jakarta Pusat', '2026-05-16 12:22:07', '2026-05-16 12:22:07');

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
(1, 'Admin', 'admin@bunga.test', '2026-05-16 12:22:07', '$2y$12$MYTqlkDNQ4aKaHQERJkYUOONQ2HByPOsRxS1L4eEaCjxPhYfTXNu.', NULL, '2026-05-16 12:22:07', '2026-05-16 12:22:07');

--
-- Indexes for dumped tables
--

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

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
