-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for dbinventory
CREATE DATABASE IF NOT EXISTS `dbinventory` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dbinventory`;

-- Dumping structure for table dbinventory.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.cache: ~0 rows (approximately)

-- Dumping structure for table dbinventory.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.cache_locks: ~0 rows (approximately)

-- Dumping structure for table dbinventory.cash_transactions
CREATE TABLE IF NOT EXISTS `cash_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `transaction_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('debit','credit') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `balance` decimal(15,2) NOT NULL DEFAULT '0.00',
  `reference` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionable_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transactionable_id` bigint unsigned DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` enum('active','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancelled_by` bigint unsigned DEFAULT NULL,
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cash_transactions_transactionable_type_transactionable_id_index` (`transactionable_type`,`transactionable_id`),
  KEY `cash_transactions_user_id_foreign` (`user_id`),
  KEY `cash_transactions_cancelled_by_foreign` (`cancelled_by`),
  CONSTRAINT `cash_transactions_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cash_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.cash_transactions: ~39 rows (approximately)
INSERT INTO `cash_transactions` (`id`, `transaction_date`, `description`, `type`, `amount`, `balance`, `reference`, `transactionable_type`, `transactionable_id`, `notes`, `status`, `cancelled_at`, `cancelled_by`, `cancel_reason`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '2026-03-01', 'Modal awal usaha — setoran owner', 'debit', 50000000.00, 0.00, 'MDL-001', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:45', '2026-05-02 22:53:45'),
	(2, '2026-03-05', 'Tambahan modal kas dari owner', 'debit', 10000000.00, 0.00, 'MDL-002', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:45', '2026-05-02 22:53:45'),
	(3, '2026-03-10', 'Pembayaran Pembelian PUR-20260310-0001', 'credit', 2132000.00, 0.00, 'PUR-20260310-0001', 'App\\Models\\Purchase', 1, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(4, '2026-03-15', 'Pembayaran Pembelian PUR-20260315-0002', 'credit', 2184000.00, 0.00, 'PUR-20260315-0002', 'App\\Models\\Purchase', 2, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(5, '2026-04-01', 'Pembayaran Pembelian PUR-20260401-0003', 'credit', 2730000.00, 0.00, 'PUR-20260401-0003', 'App\\Models\\Purchase', 3, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(6, '2026-04-05', 'Pembayaran Pembelian PUR-20260405-0004', 'credit', 3450000.00, 0.00, 'PUR-20260405-0004', 'App\\Models\\Purchase', 4, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(7, '2026-04-10', 'Pembayaran Pembelian PUR-20260410-0005', 'credit', 1007500.00, 0.00, 'PUR-20260410-0005', 'App\\Models\\Purchase', 5, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(8, '2026-04-15', 'Pembayaran Pembelian PUR-20260415-0006', 'credit', 1190640.00, 0.00, 'PUR-20260415-0006', 'App\\Models\\Purchase', 6, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(9, '2026-04-20', 'Pembayaran Pembelian PUR-20260420-0007', 'credit', 696800.00, 0.00, 'PUR-20260420-0007', 'App\\Models\\Purchase', 7, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(10, '2026-05-01', 'Pembayaran Pembelian PUR-20260501-0008', 'credit', 488400.00, 0.00, 'PUR-20260501-0008', 'App\\Models\\Purchase', 8, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(11, '2026-05-02', 'Pembayaran Pembelian PUR-20260502-0013 (Inden)', 'credit', 781313.00, 0.00, 'PUR-20260502-0013', 'App\\Models\\Purchase', 13, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(12, '2026-05-03', 'Pembayaran Pembelian PUR-20260503-0015 (Inden)', 'credit', 728000.00, 0.00, 'PUR-20260503-0015', 'App\\Models\\Purchase', 15, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(13, '2026-03-18', 'Pembayaran Penjualan INV-20260318-0001', 'debit', 440000.00, 0.00, 'INV-20260318-0001', 'App\\Models\\Sale', 1, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(14, '2026-03-25', 'Pembayaran Penjualan INV-20260325-0002', 'debit', 850000.00, 0.00, 'INV-20260325-0002', 'App\\Models\\Sale', 2, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(15, '2026-04-03', 'Pembayaran Penjualan INV-20260403-0003', 'debit', 852500.00, 0.00, 'INV-20260403-0003', 'App\\Models\\Sale', 3, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(16, '2026-04-10', 'Pembayaran Penjualan INV-20260410-0004', 'debit', 544500.00, 0.00, 'INV-20260410-0004', 'App\\Models\\Sale', 4, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(17, '2026-04-18', 'Pembayaran Penjualan INV-20260418-0005', 'debit', 562500.00, 0.00, 'INV-20260418-0005', 'App\\Models\\Sale', 5, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(18, '2026-04-25', 'Pembayaran Penjualan INV-20260425-0006', 'debit', 435000.00, 0.00, 'INV-20260425-0006', 'App\\Models\\Sale', 6, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(19, '2026-04-28', 'Pembayaran Penjualan INV-20260428-0007', 'debit', 365500.00, 0.00, 'INV-20260428-0007', 'App\\Models\\Sale', 7, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(20, '2026-05-01', 'Pembayaran Penjualan INV-20260501-0008', 'debit', 479850.00, 0.00, 'INV-20260501-0008', 'App\\Models\\Sale', 8, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(21, '2026-05-01', 'Pembayaran Penjualan INV-20260501-0009', 'debit', 358800.00, 0.00, 'INV-20260501-0009', 'App\\Models\\Sale', 9, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(22, '2026-05-02', 'Pembayaran Penjualan INV-20260502-0010', 'debit', 178000.00, 0.00, 'INV-20260502-0010', 'App\\Models\\Sale', 10, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(23, '2026-05-02', 'Pembayaran Penjualan INV-20260502-0011', 'debit', 261250.00, 0.00, 'INV-20260502-0011', 'App\\Models\\Sale', 11, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(24, '2026-03-31', 'Bayar listrik workshop Maret 2026', 'credit', 1500000.00, 0.00, 'OPS-001', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(25, '2026-03-31', 'Bayar air PDAM Maret 2026', 'credit', 800000.00, 0.00, 'OPS-002', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(26, '2026-04-01', 'Beli ATK & perlengkapan kantor', 'credit', 500000.00, 0.00, 'OPS-003', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(27, '2026-04-05', 'Biaya kurir & pengiriman barang', 'credit', 350000.00, 0.00, 'OPS-004', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(28, '2026-04-10', 'Service mesin crimping', 'credit', 2500000.00, 0.00, 'OPS-005', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(29, '2026-04-15', 'Beli bensin operasional', 'credit', 250000.00, 0.00, 'OPS-006', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(30, '2026-04-30', 'Bayar listrik workshop April 2026', 'credit', 1500000.00, 0.00, 'OPS-007', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(31, '2026-04-30', 'Bayar air PDAM April 2026', 'credit', 800000.00, 0.00, 'OPS-008', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(32, '2026-05-01', 'Beli plastik packing & isolasi', 'credit', 400000.00, 0.00, 'OPS-009', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(33, '2026-05-02', 'Biaya kurir & pengiriman Mei', 'credit', 300000.00, 0.00, 'OPS-010', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(34, '2026-04-05', 'Jasa crimping selang customer walk-in', 'debit', 150000.00, 0.00, 'JASA-001', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(35, '2026-04-12', 'Jasa potong selang custom', 'debit', 200000.00, 0.00, 'JASA-002', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(36, '2026-04-20', 'Jasa repair hydraulic hose on-site', 'debit', 350000.00, 0.00, 'JASA-003', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(37, '2026-05-01', 'Jasa crimping selang 2 unit', 'debit', 175000.00, 0.00, 'JASA-004', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(38, '2026-05-02', 'Jasa maintenance sistem hidrolik', 'debit', 500000.00, 0.00, 'JASA-005', NULL, NULL, NULL, 'active', NULL, NULL, NULL, 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53'),
	(39, '2026-04-08', 'Bayar ongkir (SALAH INPUT)', 'credit', 750000.00, 0.00, 'OPS-ERR', NULL, NULL, NULL, 'cancelled', '2026-04-08 07:00:00', 1, 'Salah input nominal, seharusnya dicatat ke rekening lain', 1, '2026-05-02 22:53:53', '2026-05-02 22:53:53');

-- Dumping structure for table dbinventory.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.categories: ~6 rows (approximately)
INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Selang Hidrolik', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43'),
	(2, 'Fitting & Coupling', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43'),
	(3, 'O-Ring & Seal', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43'),
	(4, 'Hose Clamp', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43'),
	(5, 'Tube & Tubing', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43'),
	(6, 'Lain-lain', NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43');

-- Dumping structure for table dbinventory.customers
CREATE TABLE IF NOT EXISTS `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `credit_limit` decimal(15,2) NOT NULL DEFAULT '0.00',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.customers: ~8 rows (approximately)
INSERT INTO `customers` (`id`, `kode`, `name`, `contact_person`, `phone`, `email`, `address`, `credit_limit`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'CUST-0001', 'PT Mitra Hidrolik Mandiri', NULL, '0778-123456', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(2, 'CUST-0002', 'PT Citra Mandiri Cahaya', NULL, '0778-234567', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(3, 'CUST-0003', 'PT Batam Teknik Perkasa', NULL, '0778-345678', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(4, 'CUST-0004', 'CV Jaya Makmur Sejahtera', NULL, '0778-456789', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(5, 'CUST-0005', 'PT Karya Utama Mandiri', NULL, '0778-567890', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(6, 'CUST-0006', 'PT Bintang Samudra', NULL, '0778-678901', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(7, 'CUST-0007', 'PT Global Teknik Indonesia', NULL, '0778-789012', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(8, 'CUST-0008', 'CV Abadi Jaya Teknik', NULL, '0778-890123', NULL, NULL, 0.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL);

-- Dumping structure for table dbinventory.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table dbinventory.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.jobs: ~0 rows (approximately)

-- Dumping structure for table dbinventory.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.job_batches: ~0 rows (approximately)

-- Dumping structure for table dbinventory.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.migrations: ~0 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_04_13_082737_create_suppliers_table', 1),
	(5, '2026_04_13_082738_create_categories_table', 1),
	(6, '2026_04_13_082738_create_customers_table', 1),
	(7, '2026_04_13_082739_create_products_table', 1),
	(8, '2026_04_13_082739_create_purchases_table', 1),
	(9, '2026_04_13_082740_create_purchase_items_table', 1),
	(10, '2026_04_13_082740_create_sales_table', 1),
	(11, '2026_04_13_082741_create_cash_transactions_table', 1),
	(12, '2026_04_13_082741_create_sale_items_table', 1),
	(13, '2026_05_01_163836_add_user_id_to_cash_transactions_table', 1),
	(14, '2026_05_03_020000_add_kode_to_customers_and_suppliers_table', 1),
	(15, '2026_05_03_021000_add_cancel_fields_to_cash_transactions_table', 1),
	(16, '2026_05_03_023000_populate_missing_product_codes', 1),
	(17, '2026_05_03_054000_add_inden_fields_to_purchases_table', 1);

-- Dumping structure for table dbinventory.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table dbinventory.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'MTR',
  `buy_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `sell_price` decimal(15,2) NOT NULL DEFAULT '0.00',
  `stock` decimal(10,2) NOT NULL DEFAULT '0.00',
  `stock_minimum` decimal(10,2) NOT NULL DEFAULT '0.00',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.products: ~22 rows (approximately)
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `unit`, `buy_price`, `sell_price`, `stock`, `stock_minimum`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'PRD-0001', 'HAMMERSPIR 3/8" R1', 'MTR', 23725.00, 26500.00, 28.00, 10.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:50', NULL),
	(2, 1, 'PRD-0002', 'HAMMERSPIR 1/2" R1', 'MTR', 31525.00, 35000.00, 17.00, 10.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:50', NULL),
	(3, 1, 'PRD-0003', 'HAMMERSPIR 5/8" R1', 'MTR', 35750.00, 39500.00, 20.00, 10.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:50', NULL),
	(4, 1, 'PRD-0004', 'HAMMERSPIR 3/4" R1', 'MTR', 37700.00, 42000.00, 17.00, 10.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:50', NULL),
	(5, 1, 'PRD-0005', 'HAMMERSPIR 3/8" R2', 'MTR', 27950.00, 31500.00, 32.00, 10.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:49', NULL),
	(6, 1, 'PRD-0006', 'HAMMERSPIR 3/4" R2', 'MTR', 53300.00, 58500.00, 15.00, 5.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:49', NULL),
	(7, 1, 'PRD-0007', 'HAMMERSPIR 1" R2', 'MTR', 72800.00, 79500.00, 10.00, 5.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:50', NULL),
	(8, 1, 'PRD-0008', 'HAMMERSPIR 5/32" OIL', 'MTR', 13650.00, 15500.00, 55.00, 20.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:52', NULL),
	(9, 1, 'PRD-0009', 'HAMMERSPIR 3/16" OIL', 'MTR', 13650.00, 15500.00, 75.00, 20.00, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:49', NULL),
	(10, 1, 'PRD-0010', 'HAMMERSPIR 5/8" OIL', 'MTR', 32500.00, 36000.00, 12.00, 5.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:50', NULL),
	(11, 1, 'PRD-0011', 'HAMMERSPIR 1" OIL', 'MTR', 61425.00, 68000.00, 2.00, 5.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:53', NULL),
	(12, 1, 'PRD-0012', 'HI POWER 1/4" R1', 'MTR', 17050.00, 19500.00, 35.00, 15.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:52', NULL),
	(13, 1, 'PRD-0013', 'HI POWER 3/8" R1', 'MTR', 24035.00, 27000.00, 30.00, 10.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:49', NULL),
	(14, 1, 'PRD-0014', 'HI POWER 1/4" R2', 'MTR', 22275.00, 25000.00, 20.00, 10.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:51', NULL),
	(15, 1, 'PRD-0015', 'HI POWER 5/8" R2', 'MTR', 43725.00, 48500.00, 10.00, 5.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:51', NULL),
	(16, 1, 'PRD-0016', 'HI POWER 3/8" 4SP', 'MTR', 77000.00, 85000.00, 7.00, 5.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:50', NULL),
	(17, 1, 'PRD-0017', 'HI POWER 1/2" 4SP', 'MTR', 85800.00, 95000.00, 8.00, 5.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:50', NULL),
	(18, 1, 'PRD-0018', 'HI POWER 1" 4SH', 'MTR', 140800.00, 155000.00, 1.00, 3.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:53', NULL),
	(19, 1, 'PRD-0019', 'HI POWER 1 1/4" 4SH', 'MTR', 189750.00, 210000.00, 0.00, 2.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:54', NULL),
	(20, 3, 'PRD-0020', 'ORING SIZE 2*9 NBR70', 'PCS', 8000.00, 10000.00, 220.00, 50.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:50', NULL),
	(21, 3, 'PRD-0021', 'ORING SIZE 2*12 NBR70', 'PCS', 2000.00, 3500.00, 150.00, 50.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:51', NULL),
	(22, 3, 'PRD-0022', 'ORING KIT', 'BOX', 125000.00, 145000.00, 7.00, 3.00, NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:49', NULL);

-- Dumping structure for table dbinventory.purchases
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `supplier_id` bigint unsigned NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` date NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `remaining` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('belum_bayar','lunas','sebagian') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_bayar',
  `is_inden` tinyint(1) NOT NULL DEFAULT '0',
  `inden_received` tinyint(1) NOT NULL DEFAULT '0',
  `received_date` date DEFAULT NULL,
  `paid_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.purchases: ~15 rows (approximately)
INSERT INTO `purchases` (`id`, `supplier_id`, `invoice_no`, `purchase_date`, `subtotal`, `discount`, `tax`, `total`, `paid_amount`, `remaining`, `status`, `is_inden`, `inden_received`, `received_date`, `paid_date`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'PUR-20260310-0001', '2026-03-10', 2132000.00, 0.00, 0.00, 2132000.00, 2132000.00, 0.00, 'lunas', 0, 0, NULL, '2026-03-10', 'Pembelian stok awal selang R1', '2026-05-02 22:53:45', '2026-05-02 22:53:45', NULL),
	(2, 2, 'PUR-20260315-0002', '2026-03-15', 2184000.00, 0.00, 0.00, 2184000.00, 2184000.00, 0.00, 'lunas', 0, 0, NULL, '2026-03-15', 'Restok selang R2', '2026-05-02 22:53:46', '2026-05-02 22:53:46', NULL),
	(3, 3, 'PUR-20260401-0003', '2026-04-01', 2730000.00, 0.00, 0.00, 2730000.00, 2730000.00, 0.00, 'lunas', 0, 0, NULL, '2026-04-01', 'Stok selang oil kecil', '2026-05-02 22:53:46', '2026-05-02 22:53:46', NULL),
	(4, 4, 'PUR-20260405-0004', '2026-04-05', 3450000.00, 0.00, 0.00, 3450000.00, 3450000.00, 0.00, 'lunas', 0, 0, NULL, '2026-04-05', 'Restok O-Ring lengkap', '2026-05-02 22:53:46', '2026-05-02 22:53:46', NULL),
	(5, 5, 'PUR-20260410-0005', '2026-04-10', 2015000.00, 0.00, 0.00, 2015000.00, 1007500.00, 1007500.00, 'sebagian', 0, 0, NULL, NULL, 'DP 50% selang 5/8 & 3/4', '2026-05-02 22:53:46', '2026-05-02 22:53:46', NULL),
	(6, 6, 'PUR-20260415-0006', '2026-04-15', 1984400.00, 0.00, 0.00, 1984400.00, 1190640.00, 793760.00, 'sebagian', 0, 0, NULL, NULL, 'DP 60% HI POWER R1', '2026-05-02 22:53:47', '2026-05-02 22:53:47', NULL),
	(7, 7, 'PUR-20260420-0007', '2026-04-20', 1742000.00, 0.00, 0.00, 1742000.00, 696800.00, 1045200.00, 'sebagian', 0, 0, NULL, NULL, 'DP 40% selang besar', '2026-05-02 22:53:47', '2026-05-02 22:53:47', NULL),
	(8, 8, 'PUR-20260501-0008', '2026-05-01', 1628000.00, 0.00, 0.00, 1628000.00, 488400.00, 1139600.00, 'sebagian', 0, 0, NULL, NULL, 'DP 30% HI POWER 4SP', '2026-05-02 22:53:47', '2026-05-02 22:53:47', NULL),
	(9, 9, 'PUR-20260501-0009', '2026-05-01', 1282500.00, 0.00, 0.00, 1282500.00, 0.00, 1282500.00, 'belum_bayar', 0, 0, NULL, NULL, 'PO belum bayar — tunggu invoice supplier', '2026-05-02 22:53:47', '2026-05-02 22:53:47', NULL),
	(10, 10, 'PUR-20260501-0010', '2026-05-01', 1359875.00, 0.00, 0.00, 1359875.00, 0.00, 1359875.00, 'belum_bayar', 0, 0, NULL, NULL, 'PO selang R2 & 4SH — termin 30 hari', '2026-05-02 22:53:47', '2026-05-02 22:53:47', NULL),
	(11, 11, 'PUR-20260502-0011', '2026-05-02', 569250.00, 0.00, 0.00, 569250.00, 0.00, 569250.00, 'belum_bayar', 0, 0, NULL, NULL, 'PO HI POWER 1 1/4 4SH — pending approval', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(12, 12, 'PUR-20260502-0012', '2026-05-02', 800000.00, 0.00, 0.00, 800000.00, 0.00, 800000.00, 'belum_bayar', 0, 0, NULL, NULL, 'PO tambahan oring 2*9', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(13, 1, 'PUR-20260502-0013', '2026-05-02', 1562625.00, 0.00, 0.00, 1562625.00, 781313.00, 781312.00, 'sebagian', 1, 0, NULL, NULL, 'Inden selang HAMMERSPIR & HI POWER — stok menipis, ETA 7 hari', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(14, 3, 'PUR-20260503-0014', '2026-05-03', 2356750.00, 0.00, 0.00, 2356750.00, 0.00, 2356750.00, 'belum_bayar', 1, 0, NULL, NULL, 'Inden HI POWER 4SH besar — stok habis, ETA 14 hari', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(15, 6, 'PUR-20260503-0015', '2026-05-03', 728000.00, 0.00, 0.00, 728000.00, 728000.00, 0.00, 'lunas', 1, 0, NULL, '2026-05-03', 'Inden selang 1" R1 — sudah bayar lunas, tunggu kiriman', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL);

-- Dumping structure for table dbinventory.purchase_items
CREATE TABLE IF NOT EXISTS `purchase_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  KEY `purchase_items_product_id_foreign` (`product_id`),
  CONSTRAINT `purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.purchase_items: ~28 rows (approximately)
INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `qty`, `unit`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 50.00, 'MTR', 23725.00, 1186250.00, '2026-05-02 22:53:45', '2026-05-02 22:53:45'),
	(2, 1, 2, 30.00, 'MTR', 31525.00, 945750.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(3, 2, 5, 40.00, 'MTR', 27950.00, 1118000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(4, 2, 6, 20.00, 'MTR', 53300.00, 1066000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(5, 3, 8, 100.00, 'MTR', 13650.00, 1365000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(6, 3, 9, 100.00, 'MTR', 13650.00, 1365000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(7, 4, 20, 200.00, 'PCS', 8000.00, 1600000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(8, 4, 21, 300.00, 'PCS', 2000.00, 600000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(9, 4, 22, 10.00, 'BOX', 125000.00, 1250000.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(10, 5, 3, 30.00, 'MTR', 35750.00, 1072500.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(11, 5, 4, 25.00, 'MTR', 37700.00, 942500.00, '2026-05-02 22:53:46', '2026-05-02 22:53:46'),
	(12, 6, 12, 60.00, 'MTR', 17050.00, 1023000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(13, 6, 13, 40.00, 'MTR', 24035.00, 961400.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(14, 7, 7, 15.00, 'MTR', 72800.00, 1092000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(15, 7, 10, 20.00, 'MTR', 32500.00, 650000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(16, 8, 16, 10.00, 'MTR', 77000.00, 770000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(17, 8, 17, 10.00, 'MTR', 85800.00, 858000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(18, 9, 11, 10.00, 'MTR', 61425.00, 614250.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(19, 9, 14, 30.00, 'MTR', 22275.00, 668250.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(20, 10, 15, 15.00, 'MTR', 43725.00, 655875.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(21, 10, 18, 5.00, 'MTR', 140800.00, 704000.00, '2026-05-02 22:53:47', '2026-05-02 22:53:47'),
	(22, 11, 19, 3.00, 'MTR', 189750.00, 569250.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(23, 12, 20, 100.00, 'PCS', 8000.00, 800000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(24, 13, 11, 20.00, 'MTR', 61425.00, 1228500.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(25, 13, 14, 15.00, 'MTR', 22275.00, 334125.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(26, 14, 18, 10.00, 'MTR', 140800.00, 1408000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(27, 14, 19, 5.00, 'MTR', 189750.00, 948750.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(28, 15, 7, 10.00, 'MTR', 72800.00, 728000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48');

-- Dumping structure for table dbinventory.sales
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` bigint unsigned NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_date` date NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT '0.00',
  `discount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `tax` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL DEFAULT '0.00',
  `paid_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `remaining` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('belum_bayar','lunas','sebagian') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_bayar',
  `paid_date` date DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_customer_id_foreign` (`customer_id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.sales: ~15 rows (approximately)
INSERT INTO `sales` (`id`, `customer_id`, `invoice_no`, `sale_date`, `subtotal`, `discount`, `tax`, `total`, `paid_amount`, `remaining`, `status`, `paid_date`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 'INV-20260318-0001', '2026-03-18', 440000.00, 0.00, 0.00, 440000.00, 440000.00, 0.00, 'lunas', '2026-03-18', 'Jual selang R1 ke PT Mitra', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(2, 2, 'INV-20260325-0002', '2026-03-25', 850000.00, 0.00, 0.00, 850000.00, 850000.00, 0.00, 'lunas', '2026-03-25', 'Jual O-Ring batch', '2026-05-02 22:53:48', '2026-05-02 22:53:48', NULL),
	(3, 3, 'INV-20260403-0003', '2026-04-03', 852500.00, 0.00, 0.00, 852500.00, 852500.00, 0.00, 'lunas', '2026-04-03', 'Jual selang oil kecil', '2026-05-02 22:53:49', '2026-05-02 22:53:49', NULL),
	(4, 4, 'INV-20260410-0004', '2026-04-10', 544500.00, 0.00, 0.00, 544500.00, 544500.00, 0.00, 'lunas', '2026-04-10', 'Jual selang R2', '2026-05-02 22:53:49', '2026-05-02 22:53:49', NULL),
	(5, 5, 'INV-20260418-0005', '2026-04-18', 562500.00, 0.00, 0.00, 562500.00, 562500.00, 0.00, 'lunas', '2026-04-18', 'Jual HI POWER R1', '2026-05-02 22:53:49', '2026-05-02 22:53:49', NULL),
	(6, 6, 'INV-20260425-0006', '2026-04-25', 435000.00, 0.00, 0.00, 435000.00, 435000.00, 0.00, 'lunas', '2026-04-25', 'Jual O-Ring Kit', '2026-05-02 22:53:49', '2026-05-02 22:53:49', NULL),
	(7, 1, 'INV-20260428-0007', '2026-04-28', 731000.00, 0.00, 0.00, 731000.00, 365500.00, 365500.00, 'sebagian', NULL, 'DP 50% jual selang 5/8 & 3/4', '2026-05-02 22:53:49', '2026-05-02 22:53:49', NULL),
	(8, 2, 'INV-20260501-0008', '2026-05-01', 685500.00, 0.00, 0.00, 685500.00, 479850.00, 205650.00, 'sebagian', NULL, 'Cicilan 70% selang besar', '2026-05-02 22:53:50', '2026-05-02 22:53:50', NULL),
	(9, 7, 'INV-20260501-0009', '2026-05-01', 598000.00, 0.00, 0.00, 598000.00, 358800.00, 239200.00, 'sebagian', NULL, 'DP 60% jual selang ke PT Global', '2026-05-02 22:53:50', '2026-05-02 22:53:50', NULL),
	(10, 3, 'INV-20260502-0010', '2026-05-02', 445000.00, 0.00, 0.00, 445000.00, 178000.00, 267000.00, 'sebagian', NULL, 'DP 40% HI POWER 4SP', '2026-05-02 22:53:50', '2026-05-02 22:53:50', NULL),
	(11, 8, 'INV-20260502-0011', '2026-05-02', 475000.00, 0.00, 0.00, 475000.00, 261250.00, 213750.00, 'sebagian', NULL, 'Cicil 55% jual oring', '2026-05-02 22:53:50', '2026-05-02 22:53:50', NULL),
	(12, 4, 'INV-20260501-0012', '2026-05-01', 492500.00, 0.00, 0.00, 492500.00, 0.00, 492500.00, 'belum_bayar', NULL, 'Belum bayar — termin 14 hari', '2026-05-02 22:53:51', '2026-05-02 22:53:51', NULL),
	(13, 5, 'INV-20260502-0013', '2026-05-02', 514000.00, 0.00, 0.00, 514000.00, 0.00, 514000.00, 'belum_bayar', NULL, 'Belum bayar — PO customer', '2026-05-02 22:53:51', '2026-05-02 22:53:51', NULL),
	(14, 6, 'INV-20260502-0014', '2026-05-02', 195000.00, 0.00, 0.00, 195000.00, 0.00, 195000.00, 'belum_bayar', NULL, 'Belum bayar — kirim dulu', '2026-05-02 22:53:52', '2026-05-02 22:53:52', NULL),
	(15, 7, 'INV-20260503-0015', '2026-05-03', 442500.00, 0.00, 0.00, 442500.00, 0.00, 442500.00, 'belum_bayar', NULL, 'Belum bayar — customer baru', '2026-05-02 22:53:52', '2026-05-02 22:53:52', NULL);

-- Dumping structure for table dbinventory.sale_items
CREATE TABLE IF NOT EXISTS `sale_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `qty` decimal(10,2) NOT NULL,
  `unit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_items_sale_id_foreign` (`sale_id`),
  KEY `sale_items_product_id_foreign` (`product_id`),
  CONSTRAINT `sale_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `sale_items_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.sale_items: ~28 rows (approximately)
INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `qty`, `unit`, `price`, `subtotal`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 10.00, 'MTR', 26500.00, 265000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(2, 1, 2, 5.00, 'MTR', 35000.00, 175000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(3, 2, 20, 50.00, 'PCS', 10000.00, 500000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(4, 2, 21, 100.00, 'PCS', 3500.00, 350000.00, '2026-05-02 22:53:48', '2026-05-02 22:53:48'),
	(5, 3, 8, 30.00, 'MTR', 15500.00, 465000.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(6, 3, 9, 25.00, 'MTR', 15500.00, 387500.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(7, 4, 5, 8.00, 'MTR', 31500.00, 252000.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(8, 4, 6, 5.00, 'MTR', 58500.00, 292500.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(9, 5, 12, 15.00, 'MTR', 19500.00, 292500.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(10, 5, 13, 10.00, 'MTR', 27000.00, 270000.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(11, 6, 22, 3.00, 'BOX', 145000.00, 435000.00, '2026-05-02 22:53:49', '2026-05-02 22:53:49'),
	(12, 7, 3, 10.00, 'MTR', 39500.00, 395000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(13, 7, 4, 8.00, 'MTR', 42000.00, 336000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(14, 8, 7, 5.00, 'MTR', 79500.00, 397500.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(15, 8, 10, 8.00, 'MTR', 36000.00, 288000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(16, 9, 1, 12.00, 'MTR', 26500.00, 318000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(17, 9, 2, 8.00, 'MTR', 35000.00, 280000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(18, 10, 16, 3.00, 'MTR', 85000.00, 255000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(19, 10, 17, 2.00, 'MTR', 95000.00, 190000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(20, 11, 20, 30.00, 'PCS', 10000.00, 300000.00, '2026-05-02 22:53:50', '2026-05-02 22:53:50'),
	(21, 11, 21, 50.00, 'PCS', 3500.00, 175000.00, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(22, 12, 14, 10.00, 'MTR', 25000.00, 250000.00, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(23, 12, 15, 5.00, 'MTR', 48500.00, 242500.00, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(24, 13, 11, 3.00, 'MTR', 68000.00, 204000.00, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(25, 13, 18, 2.00, 'MTR', 155000.00, 310000.00, '2026-05-02 22:53:51', '2026-05-02 22:53:51'),
	(26, 14, 12, 10.00, 'MTR', 19500.00, 195000.00, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(27, 15, 19, 1.00, 'MTR', 210000.00, 210000.00, '2026-05-02 22:53:52', '2026-05-02 22:53:52'),
	(28, 15, 8, 15.00, 'MTR', 15500.00, 232500.00, '2026-05-02 22:53:52', '2026-05-02 22:53:52');

-- Dumping structure for table dbinventory.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.sessions: ~2 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('1iIrVVJ56RKX3LrehJslUjKrVOWqoUMhAzf6oKNM', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJxclBudWo5VlpYRFBnTFU5RkhqS2I4V2RudzJtTUgyVURwV2lGNmpBIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHBzOlwvXC9zaXN0ZW1pbnZlbnRvcnkudGVzdFwvZGFzaGJvYXJkIiwicm91dGUiOiJkYXNoYm9hcmQifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MX0=', 1777789778),
	('gDXX8ynxE5e0b8EKipOfUMmiElZPFpcNEGNBM9ra', 1, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiIzTzI0ZXFCOUh3amV3RWJxaWVNVW16SVNZRjMyekhoSmNGaDJJNTBzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdFwvc2lzdGVtSW52ZW50b3J5XC9wdWJsaWNcL3B1cmNoYXNlc1wvY3JlYXRlIiwicm91dGUiOiJwdXJjaGFzZXMuY3JlYXRlIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjF9', 1777789192);

-- Dumping structure for table dbinventory.suppliers
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact_person` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_kode_unique` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.suppliers: ~16 rows (approximately)
INSERT INTO `suppliers` (`id`, `kode`, `name`, `contact_person`, `phone`, `email`, `address`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'SUP-0001', 'PT Anugrah Rejeki Cemerlang', NULL, '0778-111001', NULL, NULL, NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43', NULL),
	(2, 'SUP-0002', 'PT Mitra Hidrolik Mandiri', NULL, '0778-111002', NULL, NULL, NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43', NULL),
	(3, 'SUP-0003', 'PT Ostynn Batam Perkasa', NULL, '0778-111003', NULL, NULL, NULL, '2026-05-02 22:53:43', '2026-05-02 22:53:43', NULL),
	(4, 'SUP-0004', 'PT An-Flex Perkasa', NULL, '0778-111004', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(5, 'SUP-0005', 'PT Batam Niaga Perkasa', NULL, '0778-111005', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(6, 'SUP-0006', 'PT Citra Mandiri Cahaya', NULL, '0778-111006', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(7, 'SUP-0007', 'PT Sunway Trek Masindo', NULL, '0778-111007', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(8, 'SUP-0008', 'PT Auto Part Otomotive', NULL, '0778-111008', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(9, 'SUP-0009', 'PT Indo Selang', NULL, '0778-111009', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(10, 'SUP-0010', 'PT Amplasindo Jarta Tama', NULL, '0778-111010', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(11, 'SUP-0011', 'PT Panca Jaya Hosindo', NULL, '0778-111011', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(12, 'SUP-0012', 'PT Talenta Seal', NULL, '0778-111012', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(13, 'SUP-0013', 'PT Majesty Jaya Bersama', NULL, '0778-111013', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(14, 'SUP-0014', 'PT Bravo Maju Jaya', NULL, '0778-111014', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(15, 'SUP-0015', 'PT Bina Niaga Indonesia', NULL, '0778-111015', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL),
	(16, 'SUP-0016', 'PT Sarang Mas Sejahtera', NULL, '0778-111016', NULL, NULL, NULL, '2026-05-02 22:53:44', '2026-05-02 22:53:44', NULL);

-- Dumping structure for table dbinventory.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table dbinventory.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'Admin RPC', 'admin@rpc.com', NULL, '$2y$12$25mrN5J.GwBYNq40CNtIC.XOJ/MxAfeQad4DPQp5U.VUg4yhufNIW', NULL, '2026-05-02 22:53:45', '2026-05-02 22:53:45');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
