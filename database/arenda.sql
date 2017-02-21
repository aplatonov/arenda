-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 19, 2017 at 07:32 PM
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_cat`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Все объекты', 0, NULL, NULL),
(2, 'что-то еще', 1, NULL, NULL),
(3, 'Вторая корневая категория', 0, NULL, NULL),
(6, 'Третья корневая категория', 0, NULL, NULL),
(9, 'Категория 2.1', 3, NULL, NULL),
(10, 'Категория 2.2', 3, NULL, NULL),
(11, 'Категория 2.3', 3, NULL, NULL),
(12, 'Категория 3.1', 6, NULL, NULL),
(13, 'Категория 3.2', 6, NULL, NULL),
(14, 'ПодКатегория 2.2.1', 10, NULL, NULL),
(15, 'Четвертая корневая категория', 0, NULL, NULL),
(17, 'Пятая категория', 0, '2017-01-02 07:07:34', '2017-01-02 07:07:34'),
(18, 'Подкатегория пятой', 17, '2017-01-02 07:08:10', '2017-01-02 07:08:10'),
(19, 'Подподкатегория пятой', 18, '2017-01-04 18:20:27', '2017-01-04 18:20:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_02_04_095000_create_roles_table', 1),
(2, '2017_02_04_095148_create_users_table', 1),
(3, '2017_02_04_144643_create_password_resets_table', 1),
(4, '2017_02_04_144756_create_categories_table', 1),
(5, '2017_02_04_145314_create_objects_table', 1),
(6, '2017_02_14_230105_create_requests_table', 2);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `objects`
--

INSERT INTO `objects` (`id`, `object_name`, `description`, `images`, `category_id`, `year`, `name_period`, `min_period`, `price`, `owner_id`, `free_since`, `disabled`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'Первый', 'Офигительное описание', NULL, 1, 2002, 'сут', 5, 1000.00, 1, '2017-02-10 00:00:00', 0, NULL, '2017-02-09 19:41:57', '2017-02-16 19:14:44'),
(2, 'Второй', 'Офигительное описание\r\nеще чуть', NULL, 1, 2001, 'сут', 4, 9999.00, 1, '2017-06-01 00:00:00', 0, NULL, '2017-02-09 19:43:38', '2017-02-12 13:21:26'),
(7, 'Дрезина', 'ыждвжлажыдва\r\nфждылвжф\r\nжылважыв', NULL, 1, 1999, 'час', 3, 1200.00, 8, NULL, 1, 7, '2017-02-11 18:13:50', '2017-02-12 10:34:30'),
(8, 'Чайник кранышленный', 'ыждвьждавыа\r\nыжвьвлжа\r\nыдвлаыдвоалд\r\n1200', NULL, 1, 2012, 'час', 1, 50.00, 7, '2017-02-25 00:00:00', 0, NULL, '2017-02-11 18:18:06', '2017-02-18 16:30:38'),
(9, 'Ковш', 'ждыжалдвждла\r\nыфдвалдылова\r\nыдвладылвоа\r\nыдлвадыфвлоа', NULL, 1, 1999, 'час', 2, 200.00, 3, NULL, 0, NULL, '2017-02-13 17:57:58', '2017-02-13 17:57:58'),
(10, 'Черпак', 'жыдфлвжа\r\nжфылождылфва\r\nцжуложвыажф\r\n\r\nыфловаж', NULL, 1, 1900, 'день', NULL, 230.00, 3, '2017-03-05 00:00:00', 0, NULL, '2017-02-13 17:58:40', '2017-02-13 17:58:40'),
(11, 'Гидрач', 'ыва\r\n222\r\n333', NULL, 1, 2000, 'сут.', 5, 900.00, 3, NULL, 0, NULL, '2017-02-13 18:04:57', '2017-02-13 18:15:36');

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
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `request_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `owner_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `requests_request_name_unique` (`request_name`),
  KEY `requests_owner_id_foreign` (`owner_id`),
  KEY `requests_category_id_foreign` (`category_id`),
  KEY `requests_customer_id_foreign` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `request_name`, `comment`, `category_id`, `start_date`, `finish_date`, `owner_id`, `customer_id`, `disabled`, `created_at`, `updated_at`) VALUES
(2, 'Башенный кран', 'сросно-срочно', 1, '2017-02-18 00:00:00', '2017-02-21 00:00:00', 1, NULL, 0, '2017-02-15 19:33:12', '2017-02-15 19:33:12'),
(3, 'Гусеничный трактор', 'вымою отдам', 1, '2017-02-27 00:00:00', '2017-03-08 00:00:00', 2, NULL, 1, '2017-02-15 19:34:04', '2017-02-16 19:58:54'),
(4, 'Тройник-таймер ЬГ-812 БВ', 'Хрень какаято', 1, '2017-02-26 00:00:00', '2017-02-28 00:00:00', 2, NULL, 0, '2017-02-15 19:34:45', '2017-02-15 19:34:45'),
(5, 'Балалайка Дж.Леннона мод. 128 БЗ-ВД цвета ультрамарин', 'Только новая', 1, '2017-03-01 00:00:00', '2017-03-08 00:00:00', 1, NULL, 0, '2017-02-15 19:38:54', '2017-02-15 19:38:54'),
(6, 'Кирзовые сапоги на стройку с хозяином', 'Бред какой-то', 1, '2017-02-19 00:00:00', '2017-03-11 00:00:00', 1, NULL, 0, '2017-02-15 19:39:47', '2017-02-15 19:39:47');

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
  `pay_till` datetime DEFAULT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `name`, `dopname`, `phone`, `role_id`, `pay_till`, `valid`, `confirmed`, `confirmation_code`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'a432974@yandex.ru', '$2y$10$0/HQaBzhVs7rFNj19p0n2O/CiljebCftmFa6IdcKFnRxKKeI2HB4u', 'ООО "Техника в аренду"', 'менеджер Петрова Юлия', '+7-927-456-78-90', 1, '2017-02-23 00:00:00', 1, 1, NULL, 'LEWsSSjg8HfF8gcKoy9TVpR30oTiFjvNqifDVa6GxktaxQGn3JBEPXDNqGT6', NULL, '2017-02-18 19:51:53'),
(2, 'user', 'fake@yandex.ru', '$2y$10$dLJ0492oUF4hYGin/GhY5eUz0s6aKDgxsfS645rASo5q91Kt26sgO', 'ИП "Копатель"', 'директор Копков Игорь', '+7-123-456-78-90', 2, NULL, 1, 1, NULL, 'ImnXQlbSBhegbwF8MM8kYwoBL8geykTVmtHYv8rnURx3ieYPXeiLhHxk6yo4', NULL, '2017-02-18 19:53:05'),
(3, 'new', 'new@newr.ru', '$2y$10$7uJpvK6Ngzwbn5LHaCTLF.knws4xGH83/QSifChMSha92jTdaguzu', 'ИП "Новый"', 'менеджер Женя', '12345', 2, '2017-03-05 00:00:00', 1, 1, 'PJJQxl5zIZ89J8XvXfUK29Q49e3FY5V7', 'RkYqb080DXJdgnlztWhLxtnaHk4N7iqBG5OHjjkNWlPUlfmjaCn0zvdE1rbe', '2017-02-04 12:46:05', '2017-02-18 19:53:07'),
(5, 'mmm', 'mmmm@mmmm.mm', '$2y$10$adhvlPv/qfp.BsHV5scB5eii3DrRwcarEYBzBuMr7IfdouqjxQw6G', 'Mamba', 'Петрович', '12344223', 2, NULL, 1, 1, '4rHhLSIvhbcO46kLhrKTlYne1Rw0q1Yo', 'tfSl1tbJ2JOkYa8T2LM2jvC06xEgWPtKmcVXWBxynENSpusBNFPdosGUIA7f', '2017-02-07 17:08:53', '2017-02-07 18:58:27'),
(6, 'ttt', 'ttt@ttt.tt', '$2y$10$c5n/sMEsdbeuiAvK1pWoTeFgZ4BbcYtoTJB7NS8zx5LNcP/0nnvp6', 'Нормальное имя', 'Петрович', '345-053', 2, '2017-02-19 00:00:00', 0, 1, 'NfTaUjAMNUyvYKsQQVlq68KEFjo3pGiz', 'V6HZA4M1bFbj89DCsQ1bDerISKOfQ8Ir9VGkRZFnKjZY5JfD7ZcWHifXug3d', '2017-02-07 19:00:41', '2017-02-14 18:03:29'),
(7, 'rrrr', 'rrr@rrr.rrr', '$2y$10$djJJH9da1tkffvT2vHBr7ehDVy9BrM9p7h4TXBJSHAz3gnX5ON2nK', 'ИП "Сдавалкин"', 'Александр первый', '+7 923 334 23 12', 2, NULL, 1, 1, 'xwVxocdW95peeK9QsvrNUoewTeQ2PPFl', 'ChxTfP6pEZ7El6onOnIiEOuDZPuBq7SJRpALW3ejY1bxt4T0waXw5n4FJw0J', '2017-02-11 12:54:30', '2017-02-14 18:14:49'),
(8, 'eee', 'eee@eee.eee', '$2y$10$hlSFAopiKrT2cJXAr9IvhuVDzfhlaxaukT1AUSgeZSHL892OF3UH2', 'ООО "Пирожки из теста"', 'Сигал Стивен', '(8422) 123-332', 2, NULL, 1, 1, 'bp5nQLzft4eDZmPnyFPPqBV0bSYv1r5T', 'nNWQVYqqpgyUxaJ2mxqHFGo9uQHrStLPIbYoLjkfOdSQ3QNPWDkxVbX18FRf', '2017-02-11 12:57:34', '2017-02-11 13:02:54'),
(9, 'uuu', 'uuu@uuu.ru', '$2y$10$I3h0YjB2ILVSISeG/0BPRepRx7j5nqwjIXZSC7SkZZ4RIYyoQEOvO', 'Ух ты', 'Матроскин', '927-332-22-11', 2, '2017-02-13 00:00:00', 0, 0, 'sIvE3duTl9alS4PMQeiMtePO5gnbIWIa', 'GNDU72R2T5QD698rMsCCXLumuqZWKkyr61op92OOqOcRe15i1gq7WzFVXd4j', '2017-02-14 18:32:50', '2017-02-14 18:40:33'),
(10, 'kkk', 'kkk@kkk.kkk', '$2y$10$h/oUpTjmf.U9g1TnxlE1wer3JsiqDqW3a9JjUAuo4tmBhakrOt00S', 'Кафе "Картошка"', 'официант Джастин', '123 12312-21', 2, NULL, 1, 1, 'RULvthykVBpH01IRDQBvGYB2DjKmD0C1', 'DaOi2bg2uN0ob9TTf5jWNbT0mbS6M1NvVrCuzKq0OK489NtsjurAhZ63fXKb', '2017-02-18 19:02:52', '2017-02-18 19:05:53'),
(11, 'zzz', 'zzz@zzz.zzz', '$2y$10$cTMYeg2YvQ/E3jMIjXKZi.wypnqpELVxEH07/Jhlgv44DiiroZEeS', 'zzz', 'zzz', '213', 2, NULL, 1, 1, 'YeL9I0E6nbu58EMGAs17GSFzMEotqTOv', 'VMneaCjXt4z01Yhj1AI2HH8FkUpNOfa13xOl3Tdqrasa74QQjm1HqyJKcJ2s', '2017-02-18 19:07:52', '2017-02-18 19:08:41');

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
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `requests_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
