-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.127.126.52:3306
-- Generation Time: Feb 06, 2026 at 09:03 AM
-- Server version: 11.1.3-MariaDB
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_fields`
--

CREATE TABLE `additional_fields` (
                                     `id` int(10) UNSIGNED NOT NULL,
                                     `name` varchar(30) NOT NULL,
                                     `sort_no` int(11) NOT NULL,
                                     `alias` varchar(255) DEFAULT NULL,
                                     `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
                                     `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `additional_fields`
--

INSERT INTO `additional_fields` (`id`, `name`, `sort_no`, `alias`, `is_deleted`, `modified_at`) VALUES
                                                                                                    (1, 'Color', 1, 'color', 0, '2020-11-30 15:40:26'),
                                                                                                    (2, 'Size', 1, 'color', 0, '2020-11-30 15:40:26');

-- --------------------------------------------------------

--
-- Table structure for table `additional_field_values`
--

CREATE TABLE `additional_field_values` (
                                           `id` int(10) UNSIGNED NOT NULL,
                                           `additional_field_id` int(10) UNSIGNED NOT NULL,
                                           `name` text NOT NULL,
                                           `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
                                           `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `additional_field_values`
--

INSERT INTO `additional_field_values` (`id`, `additional_field_id`, `name`, `is_deleted`, `modified_at`) VALUES
                                                                                                             (1, 1, 'Red', 0, '2020-11-30 15:41:07'),
                                                                                                             (2, 1, 'Green', 0, '2020-11-30 15:41:14'),
                                                                                                             (3, 2, 'S', 0, '2020-11-30 15:41:25'),
                                                                                                             (4, 2, 'M', 0, '2020-11-30 15:41:25'),
                                                                                                             (5, 2, 'L', 0, '2020-11-30 15:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `additional_goods_field_values`
--

CREATE TABLE `additional_goods_field_values` (
                                                 `id` int(10) UNSIGNED NOT NULL,
                                                 `good_id` int(10) UNSIGNED NOT NULL,
                                                 `additional_field_id` int(10) UNSIGNED NOT NULL,
                                                 `additional_field_value_id` int(10) UNSIGNED NOT NULL,
                                                 `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT 0,
                                                 `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `additional_goods_field_values`
--

INSERT INTO `additional_goods_field_values` (`id`, `good_id`, `additional_field_id`, `additional_field_value_id`, `is_deleted`, `modified_at`) VALUES
                                                                                                                                                   (1, 1, 1, 1, 0, '2020-11-30 15:43:15'),
                                                                                                                                                   (2, 1, 2, 4, 0, '2020-11-30 15:43:22'),
                                                                                                                                                   (3, 2, 1, 2, 0, '2020-11-30 15:43:29'),
                                                                                                                                                   (4, 2, 2, 3, 0, '2020-11-30 15:43:29');

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
                         `id` int(10) UNSIGNED NOT NULL,
                         `article` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `name` varchar(250) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
                         `price` double(12,2) NOT NULL,
                         `ean` varchar(13) NOT NULL DEFAULT '',
                         `vat` float(5,2) UNSIGNED NOT NULL DEFAULT 19.00,
  `modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `article`, `name`, `price`, `ean`, `vat`, `modified_at`) VALUES
                                                                                        (1, 'A123', 'test good 1', 45.00, '4041388630126', 19.00, '2020-11-27 09:11:19'),
                                                                                        (2, 'A124', 'test good 2', 45.00, '9002859043062', 19.00, '2020-11-27 09:11:19'),
                                                                                        (3, 'A125', 'test good 3', 5.50, '4041388630126', 19.00, '2020-11-27 09:11:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
                         `id` int(11) NOT NULL,
                         `name` varchar(50) NOT NULL,
                         `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`) VALUES
                                               (2, 'програміст', 'developer'),
                                               (3, 'менеджер', 'manager'),
                                               (4, 'тестувальник', 'qa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
                         `id` int(11) NOT NULL,
                         `first_name` varchar(50) NOT NULL,
                         `last_name` varchar(50) DEFAULT NULL,
                         `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `role_id`) VALUES
                                                                     (5, 'testsw', 'testt', 2),
                                                                     (13, 'first name', 'last names', 2),
                                                                     (14, 'first name', 'last name', 2),
                                                                     (20, 'first name', 'last name', 2),
                                                                     (21, 'first name', 'last name', 2),
                                                                     (22, 'first name', 'last name', 2),
                                                                     (23, 'first name', 'last name', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_fields`
--
ALTER TABLE `additional_fields`
    ADD PRIMARY KEY (`id`);

--
-- Indexes for table `additional_field_values`
--
ALTER TABLE `additional_field_values`
    ADD PRIMARY KEY (`id`),
  ADD KEY `textile_filed_id` (`additional_field_id`);

--
-- Indexes for table `additional_goods_field_values`
--
ALTER TABLE `additional_goods_field_values`
    ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `good_id_2` (`good_id`,`additional_field_id`),
  ADD KEY `good_id` (`good_id`),
  ADD KEY `textile_filed_id` (`additional_field_id`),
  ADD KEY `textile_filed_value_id` (`additional_field_value_id`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
    ADD PRIMARY KEY (`id`),
  ADD KEY `ean` (`ean`),
  ADD KEY `article` (`article`),
  ADD KEY `ean_mainsupplier` (`ean`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`),
  ADD KEY `roles_slug_index` (`slug`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`id`),
  ADD KEY `users_first_name_index` (`first_name`),
  ADD KEY `users_roles_id_fk` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_fields`
--
ALTER TABLE `additional_fields`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `additional_field_values`
--
ALTER TABLE `additional_field_values`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `additional_goods_field_values`
--
ALTER TABLE `additional_goods_field_values`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
    ADD CONSTRAINT `users_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
