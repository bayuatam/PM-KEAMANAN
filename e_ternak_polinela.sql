-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 31, 2025 at 05:59 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_ternak_polinela`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Daging Segar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int UNSIGNED NOT NULL,
  `order_id` varchar(255) DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_whatsapp` varchar(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` enum('online','cod') NOT NULL,
  `order_status` enum('pending_payment','processing','at_logistics','completed','cancelled') NOT NULL DEFAULT 'pending_payment',
  `logistics_officer_id` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `customer_name`, `customer_whatsapp`, `total_amount`, `payment_method`, `order_status`, `logistics_officer_id`, `created_at`) VALUES
(1, NULL, '', '', 135.00, 'online', 'cancelled', NULL, '2025-09-26 22:19:04'),
(8, NULL, '', '', 135.00, 'cod', 'pending_payment', NULL, '2025-09-26 23:00:19'),
(9, NULL, 'Kaka', '08123456789', 135.00, 'cod', 'completed', 2, '2025-09-26 23:10:58'),
(10, NULL, 'Ari Julianto', '08123456789', 170000.00, 'cod', 'completed', 2, '2025-09-27 00:33:03'),
(11, NULL, 'Aditia Tampubolon', '08123456789', 300000.00, 'cod', 'at_logistics', 2, '2025-09-27 00:38:45'),
(12, NULL, 'Damar Apriansyah', '08123456789', 470000.00, 'cod', 'at_logistics', 2, '2025-09-27 00:41:01'),
(13, NULL, 'Budi Arif', '08123456789', 170000.00, 'cod', 'completed', 2, '2025-09-27 01:21:52'),
(14, NULL, 'Bayu Pratama', '08123456789', 300000.00, 'cod', 'completed', 2, '2025-10-28 22:33:23'),
(15, NULL, 'Indra', '08123456788', 170000.00, 'cod', 'completed', 2, '2025-10-28 22:51:36'),
(16, NULL, 'Indra Ken', '08123456786', 55000.00, 'cod', 'completed', 2, '2025-10-28 22:55:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int UNSIGNED NOT NULL,
  `order_id` int UNSIGNED NOT NULL,
  `product_id` int UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(10, 10, 3, 1, 170000.00),
(11, 11, 4, 1, 130000.00),
(12, 11, 3, 1, 170000.00),
(13, 12, 3, 2, 170000.00),
(14, 12, 4, 1, 130000.00),
(15, 13, 3, 1, 170000.00),
(16, 14, 3, 1, 170000.00),
(17, 14, 4, 1, 130000.00),
(18, 15, 3, 1, 170000.00),
(19, 16, 7, 1, 25000.00),
(20, 16, 6, 1, 30000.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int UNSIGNED NOT NULL,
  `seller_id` int UNSIGNED DEFAULT NULL,
  `category_id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `stock` int NOT NULL,
  `image` varchar(255) DEFAULT 'default-product.png',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `name`, `description`, `price`, `unit`, `stock`, `image`, `created_at`) VALUES
(3, 3, 1, 'Daging Kambing', 'Daging kambing segar cocok untuk membuat sate maupun olahan lainnya', 170000.00, 'kg', 18, '1758905059_f5b7c27421b0e7318396.avif', '2025-09-26 23:44:19'),
(4, 3, 1, 'Daging Sapi', 'Daging sapi segar yang dihasilkan peternak polinela', 130000.00, 'kg', 30, '1758906989_cd3dc899bcc54a7393db.jpg', '2025-09-27 00:16:29'),
(5, 4, 1, 'Telur Ayam', 'Telur ayam berkuliatas tinggi dengan harga terjangkau', 25000.00, 'kg', 10, '1758911667_8f4bcdf91336279fa9f7.jpg', '2025-09-27 01:34:27'),
(6, 4, 1, 'Daging Ayam Utuh', 'Daging Ayam Utuh Berkualitas', 30000.00, 'kg', 49, '1761666265_0e7ba4f5ad286a7f077a.jpeg', '2025-10-28 22:44:25'),
(7, 4, 1, 'Paha Ayam', 'Paha Ayam Berkualitas', 25000.00, 'kg', 49, '1761666325_a6d7d592adc1f76ff4d9.jpg', '2025-10-28 22:45:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `kelas` varchar(50) NOT NULL,
  `prodi` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('penjual','pembeli','logistik') NOT NULL DEFAULT 'pembeli',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `kelas`, `prodi`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Logistik', 'Staf', 'Logistik', 'logistik@polinela.ac.id', '$2y$10$kMKiMe0SeHp57QQlsCeN6O2KULICjWJw/XSlbdzBuV5yEE/Bbo.la', 'logistik', '2025-09-26 21:11:38'),
(3, 'Bayu Pratama', '5 A', 'MANAJEMEN INFORMATIKA', 'bayuptma42@gmail.com', '$2y$10$v3s41vSqDATxzB3p1ot7gOdn.2YYgouo71.65/6I4p6h1mi0tYnzK', 'penjual', '2025-09-26 21:16:12'),
(4, 'Ari Julianto', '5 A', 'MANAJEMEN INFORMATIKA', 'Ari@gmail.com', '$2y$10$4ovGRgx7xq6Opj4lYICh2uyLJYLki3nfWTRh8O02OZU/jkEHZFVmy', 'penjual', '2025-09-27 01:32:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_id` (`seller_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
