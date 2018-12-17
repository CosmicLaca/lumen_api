-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 17, 2018 at 08:13 PM
-- Server version: 10.2.19-MariaDB-1:10.2.19+maria~bionic
-- PHP Version: 7.2.13-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apitest`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2018_12_16_164457_create_table_users', 1),
(2, '2018_12_16_171106_create_table_products', 1),
(3, '2018_12_16_171135_create_table_shoppingcarts', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `uuid`, `name`, `price`, `currency`, `created_at`, `updated_at`) VALUES
(1, 'e38546f9-022b-11e9-9ccf-0235404fedf8', 'product_1', '10', 'HUF', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(2, 'e3854890-022b-11e9-9ccf-0235404fedf8', 'product_2', '20', 'HUF', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(3, 'e385494a-022b-11e9-9ccf-0235404fedf8', 'product_3', '30', 'HUF', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(4, 'e38549c1-022b-11e9-9ccf-0235404fedf8', 'product_4', '40', 'HUF', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(5, 'e3854a2d-022b-11e9-9ccf-0235404fedf8', 'product_5', '50', 'HUF', '2018-12-17 18:45:13', '2018-12-17 18:45:13');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `InsertProducts` BEFORE INSERT ON `products` FOR EACH ROW BEGIN 
	        SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateProducts` BEFORE INSERT ON `products` FOR EACH ROW BEGIN 
	        SET NEW.updated_at = NOW();
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `shoppingcarts`
--

CREATE TABLE `shoppingcarts` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Triggers `shoppingcarts`
--
DELIMITER $$
CREATE TRIGGER `InsertShoppingcarts` BEFORE INSERT ON `shoppingcarts` FOR EACH ROW BEGIN 
            SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateShoppingcarts` BEFORE INSERT ON `shoppingcarts` FOR EACH ROW BEGIN
	        SET NEW.updated_at = NOW();
        END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `username`, `password`, `name`, `phone`, `email`, `created_at`, `updated_at`) VALUES
(1, 'e386e720-022b-11e9-9ccf-0235404fedf8', 'User_1', '123456', 'user 1', '06/70 11111-22222', 'name_1@gmail.com', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(2, 'e386e867-022b-11e9-9ccf-0235404fedf8', 'User_2', '123456', 'user 2', '06/70 33333-44444', 'name_2@gmail.com', '2018-12-17 18:45:13', '2018-12-17 18:45:13'),
(3, 'e386e932-022b-11e9-9ccf-0235404fedf8', 'User_3', '123456', 'user 3', '06/70 5555-66666', 'name_3@gmail.com', '2018-12-17 18:45:13', '2018-12-17 18:45:13');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `InsertUsers` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
	        SET NEW.created_at = NOW();
            IF NEW.uuid = "" OR NEW.uuid IS NULL THEN
                SET NEW.uuid = UUID();
            END IF;	
        END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `UpdateUsers` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
	        SET NEW.updated_at = NOW();
        END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_name_unique` (`name`),
  ADD UNIQUE KEY `products_uuid_unique` (`uuid`);

--
-- Indexes for table `shoppingcarts`
--
ALTER TABLE `shoppingcarts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shoppingcarts_uuid_unique` (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_uuid_unique` (`uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `shoppingcarts`
--
ALTER TABLE `shoppingcarts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
