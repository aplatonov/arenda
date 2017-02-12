-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 12, 2017 at 06:06 PM
-- Server version: 5.5.54-0ubuntu0.14.04.1
-- PHP Version: 5.6.30-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `arenda`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_cat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_cat`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Все объекты', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_02_04_095000_create_roles_table', 1),
(2, '2017_02_04_095148_create_users_table', 1),
(3, '2017_02_04_144643_create_password_resets_table', 1),
(4, '2017_02_04_144756_create_categories_table', 1),
(5, '2017_02_04_145314_create_objects_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `object_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `images` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `year` int(10) unsigned NOT NULL,
  `name_period` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_period` int(10) DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `free_since` datetime DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `customer_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `objects_object_name_unique` (`object_name`),
  KEY `objects_owner_id_foreign` (`owner_id`),
  KEY `objects_category_id_foreign` (`category_id`),
  KEY `objects_customer_id_foreign` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`id`, `object_name`, `description`, `images`, `category_id`, `year`, `name_period`, `min_period`, `price`, `owner_id`, `free_since`, `disabled`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'Первый', 'Офигительное описание', NULL, 1, 2002, 'сут', 5, 1000.00, 1, '2017-02-10 00:00:00', 0, NULL, '2017-02-09 19:41:57', '2017-02-09 19:41:57'),
(2, 'Второй', 'Офигительное описание\r\nеще чуть', NULL, 1, 2001, 'сут', 4, 9999.00, 1, '2017-06-01 00:00:00', 0, NULL, '2017-02-09 19:43:38', '2017-02-12 13:21:26'),
(7, 'Дрезина', 'ыждвжлажыдва\r\nфждылвжф\r\nжылважыв', NULL, 1, 1999, 'час', 3, 1200.00, 8, NULL, 1, 7, '2017-02-11 18:13:50', '2017-02-12 10:34:30'),
(8, 'Чайник промышленный', 'ыждвьждавыа\r\nыжвьвлжа\r\nыдвлаыдвоалд\r\n1200', NULL, 1, 2012, 'сут', 1, 50.00, 7, '2017-02-25 00:00:00', 0, NULL, '2017-02-11 18:18:06', '2017-02-11 18:18:06');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Администратор', 'admin', NULL, NULL),
(2, 'Пользователь', 'user', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dopname` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(10) unsigned NOT NULL DEFAULT '2',
  `valid` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmation_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_login_unique` (`login`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `name`, `dopname`, `phone`, `role_id`, `valid`, `confirmed`, `confirmation_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'a432974@yandex.ru', '$2y$10$0/HQaBzhVs7rFNj19p0n2O/CiljebCftmFa6IdcKFnRxKKeI2HB4u', 'ООО "Техника в аренду"', 'менеджер Петрова Юлия', '+7-927-456-78-90', 1, 1, 1, NULL, 'Ts68IIwNiwwckhYcvRNN0i8S37gxlnOImYiAAL6MqDkWbcWcNm9TmhFNNIqY', NULL, NULL),
(2, 'user', 'fake@yandex.ru', '$2y$10$dLJ0492oUF4hYGin/GhY5eUz0s6aKDgxsfS645rASo5q91Kt26sgO', 'ИП "Копатель"', 'директор Копков Игорь', '+7-123-456-78-90', 2, 1, 1, NULL, NULL, NULL, NULL),
(3, 'new', 'new@newr.ru', '$2y$10$7uJpvK6Ngzwbn5LHaCTLF.knws4xGH83/QSifChMSha92jTdaguzu', 'ИП "Новый"', 'менеджер Женя', '12345', 2, 1, 1, 'PJJQxl5zIZ89J8XvXfUK29Q49e3FY5V7', 'HyaLTdraL4jfPn5eYlsIdTYwBmdhzi2oP8zDB1lYk7HrpAT8ga6WQlhBuTlp', '2017-02-04 12:46:05', '2017-02-07 18:22:27'),
(5, 'mmm', 'mmmm@mmmm.mm', '$2y$10$adhvlPv/qfp.BsHV5scB5eii3DrRwcarEYBzBuMr7IfdouqjxQw6G', 'Mamba', 'Петрович', '12344223', 2, 1, 1, '4rHhLSIvhbcO46kLhrKTlYne1Rw0q1Yo', 'tfSl1tbJ2JOkYa8T2LM2jvC06xEgWPtKmcVXWBxynENSpusBNFPdosGUIA7f', '2017-02-07 17:08:53', '2017-02-07 18:58:27'),
(6, 'ttt', 'ttt@ttt.tt', '$2y$10$c5n/sMEsdbeuiAvK1pWoTeFgZ4BbcYtoTJB7NS8zx5LNcP/0nnvp6', 'tttxttxZTTX', 'slkfdjk', '345-053', 2, 0, 1, 'NfTaUjAMNUyvYKsQQVlq68KEFjo3pGiz', 'V6HZA4M1bFbj89DCsQ1bDerISKOfQ8Ir9VGkRZFnKjZY5JfD7ZcWHifXug3d', '2017-02-07 19:00:41', '2017-02-11 13:02:23'),
(7, 'rrrr', 'rrr@rrr.rrr', '$2y$10$djJJH9da1tkffvT2vHBr7ehDVy9BrM9p7h4TXBJSHAz3gnX5ON2nK', 'ИП "Сдавалкин"', 'Александр первый', '+7 923 334 23 12', 2, 1, 1, 'xwVxocdW95peeK9QsvrNUoewTeQ2PPFl', 'ChxTfP6pEZ7El6onOnIiEOuDZPuBq7SJRpALW3ejY1bxt4T0waXw5n4FJw0J', '2017-02-11 12:54:30', '2017-02-11 18:19:23'),
(8, 'eee', 'eee@eee.eee', '$2y$10$hlSFAopiKrT2cJXAr9IvhuVDzfhlaxaukT1AUSgeZSHL892OF3UH2', 'ООО "Пирожки из теста"', 'Сигал Стивен', '(8422) 123-332', 2, 1, 1, 'bp5nQLzft4eDZmPnyFPPqBV0bSYv1r5T', 'nNWQVYqqpgyUxaJ2mxqHFGo9uQHrStLPIbYoLjkfOdSQ3QNPWDkxVbX18FRf', '2017-02-11 12:57:34', '2017-02-11 13:02:54');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `objects`
--
ALTER TABLE `objects`
  ADD CONSTRAINT `objects_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `objects_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `objects_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
