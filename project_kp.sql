-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2020-11-29 18:31:48
-- 服务器版本： 10.4.11-MariaDB
-- PHP 版本： 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `project_kp`
--

-- --------------------------------------------------------

--
-- 表的结构 `cashes`
--

CREATE TABLE `cashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `current_amount` decimal(15,2) NOT NULL,
  `amount_keyin` decimal(15,2) NOT NULL,
  `latest_amount` decimal(15,2) NOT NULL,
  `is_latest` int(10) UNSIGNED NOT NULL,
  `form_id` int(10) UNSIGNED DEFAULT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(58, 'Makanan', 'active', NULL, NULL),
(63, 'Rokok', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `form_cashes`
--

CREATE TABLE `form_cashes` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('Deposit','Withdraw') COLLATE utf8mb4_unicode_ci NOT NULL,
  `need_for` enum('Personal Use','Employee Salary','Utility Expense','') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Draft','Validated') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `form_cashes`
--

INSERT INTO `form_cashes` (`id`, `date`, `amount`, `description`, `type`, `need_for`, `status`, `created_at`, `updated_at`) VALUES
(21, '2020-11-30', '10.00', 'Test', 'Withdraw', 'Employee Salary', 'Draft', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qty` int(100) UNSIGNED DEFAULT NULL,
  `min_qty` int(100) UNSIGNED DEFAULT NULL,
  `max_qty` int(100) DEFAULT NULL,
  `sell_amount` decimal(25,2) DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `uom_id` int(10) UNSIGNED NOT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `brand`, `qty`, `min_qty`, `max_qty`, `sell_amount`, `category_id`, `uom_id`, `status`, `created_at`, `updated_at`) VALUES
(74, 'CD11', 'CDA', 'SAMSUNG', 4410, 20, NULL, '5000.00', 58, 1, 'active', NULL, NULL),
(76, 'A12', 'BANTAL', '1231', 0, 100, NULL, '10000.00', 58, 1, 'active', NULL, NULL),
(77, 'RK01', 'Rokok Surya', 'Surya', 100, 100, NULL, '3000.00', 63, 1, 'active', NULL, NULL),
(78, 'ASD', 'das', 'das', 0, 100, 160, '10000.00', 58, 1, 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(10) UNSIGNED NOT NULL,
  `start_date` date NOT NULL,
  `current_qty` int(10) UNSIGNED NOT NULL,
  `current_unit_price` decimal(15,2) NOT NULL,
  `purchase_qty` int(10) UNSIGNED NOT NULL,
  `purchase_unit_price` decimal(15,2) NOT NULL,
  `average_unit_price` decimal(15,2) NOT NULL,
  `inventory_qty` int(100) DEFAULT NULL,
  `is_latest` int(10) UNSIGNED DEFAULT NULL,
  `is_first` int(10) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `product_uoms`
--

CREATE TABLE `product_uoms` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `product_uoms`
--

INSERT INTO `product_uoms` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'pcs', 'active', '2020-11-19 12:08:31', '2020-11-19 12:08:31');

-- --------------------------------------------------------

--
-- 表的结构 `purchase_invoices`
--

CREATE TABLE `purchase_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `uid` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `status` enum('Draft','Validated') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `purchase_invoice_lines`
--

CREATE TABLE `purchase_invoice_lines` (
  `id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `sales_amount` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `sales_invoices`
--

CREATE TABLE `sales_invoices` (
  `id` int(10) UNSIGNED NOT NULL,
  `sales_date` date NOT NULL,
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `total_pay` decimal(15,2) NOT NULL,
  `total_refund` decimal(15,2) DEFAULT NULL,
  `payment` enum('Cash','Pending') COLLATE utf8mb4_unicode_ci NOT NULL,
  `uid` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Draft','Validated') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `sales_invoice_lines`
--

CREATE TABLE `sales_invoice_lines` (
  `id` int(10) UNSIGNED NOT NULL,
  `qty` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(15,2) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `sales_id` int(10) UNSIGNED NOT NULL,
  `price_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(125) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(125) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `name`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(6, 'HC002', 'How Come', '121213123', 'Batam iASDASDA', 'active', NULL, NULL),
(8, 'HC003', 'ABC', '12312', 'Bengkong Laut Batam', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','owner','kasir','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `level`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'administrator', 'admin');

--
-- 转储表的索引
--

--
-- 表的索引 `cashes`
--
ALTER TABLE `cashes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cashes_form_id_foreign` (`form_id`),
  ADD KEY `cashes_order_id_foreign` (`order_id`);

--
-- 表的索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- 表的索引 `form_cashes`
--
ALTER TABLE `form_cashes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_uom_id_foreign` (`uom_id`);

--
-- 表的索引 `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_prices_product_id_foreign` (`product_id`),
  ADD KEY `product_prices_order_id_foreign` (`order_id`);

--
-- 表的索引 `product_uoms`
--
ALTER TABLE `product_uoms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_uoms_name_unique` (`name`);

--
-- 表的索引 `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_invoices_uid_foreign` (`uid`),
  ADD KEY `purchase_invoices_supplier_id_foreign` (`supplier_id`);

--
-- 表的索引 `purchase_invoice_lines`
--
ALTER TABLE `purchase_invoice_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_invoice_lines_product_id_foreign` (`product_id`),
  ADD KEY `purchase_invoice_lines_order_id_foreign` (`order_id`);

--
-- 表的索引 `sales_invoices`
--
ALTER TABLE `sales_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoices_uid_foreign` (`uid`);

--
-- 表的索引 `sales_invoice_lines`
--
ALTER TABLE `sales_invoice_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_invoice_lines_product_id_foreign` (`product_id`),
  ADD KEY `sales_invoice_lines_sales_id_foreign` (`sales_id`),
  ADD KEY `sales_invoice_lines_price_id_foreign` (`price_id`);

--
-- 表的索引 `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_code_unique` (`code`);

--
-- 表的索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cashes`
--
ALTER TABLE `cashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用表AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- 使用表AUTO_INCREMENT `form_cashes`
--
ALTER TABLE `form_cashes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- 使用表AUTO_INCREMENT `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- 使用表AUTO_INCREMENT `product_uoms`
--
ALTER TABLE `product_uoms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `purchase_invoices`
--
ALTER TABLE `purchase_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- 使用表AUTO_INCREMENT `purchase_invoice_lines`
--
ALTER TABLE `purchase_invoice_lines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- 使用表AUTO_INCREMENT `sales_invoices`
--
ALTER TABLE `sales_invoices`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `sales_invoice_lines`
--
ALTER TABLE `sales_invoice_lines`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
