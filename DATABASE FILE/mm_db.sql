-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2024 at 10:03 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feminine_health_worker_groups`
--

CREATE TABLE `feminine_health_worker_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `feminine_id` bigint(20) UNSIGNED NOT NULL,
  `health_worker_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feminine_health_worker_groups`
--

INSERT INTO `feminine_health_worker_groups` (`id`, `feminine_id`, `health_worker_id`, `created_at`, `updated_at`) VALUES
(1, 6, 5, '2024-06-25 14:58:40', '2024-06-25 14:58:40'),
(2, 7, 5, '2024-06-25 15:04:35', '2024-06-25 15:04:35'),
(3, 8, 5, '2024-06-25 15:06:36', '2024-06-25 15:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `menstruation_periods`
--

CREATE TABLE `menstruation_periods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `menstruation_date` date DEFAULT NULL,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menstruation_periods`
--

INSERT INTO `menstruation_periods` (`id`, `user_id`, `menstruation_date`, `remarks`, `is_seen`, `created_at`, `updated_at`) VALUES
(1, 8, '2024-06-25', NULL, 1, '2024-06-25 15:06:36', '2024-06-25 15:13:45'),
(2, 6, '2024-06-09', 'Start of menstruation', 0, '2024-06-25 15:45:40', '2024-06-25 15:45:40'),
(3, 6, '2024-05-05', NULL, 0, '2024-06-27 12:47:34', '2024-06-27 12:47:34'),
(4, 6, '2024-07-02', NULL, 0, '2024-07-03 20:43:24', '2024-07-03 20:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_07_12_033915_create_user_roles_table', 1),
(6, '2023_07_12_043915_create_users_table', 1),
(7, '2023_07_12_061338_create_menstruation_periods_table', 1),
(8, '2023_07_20_202312_create_feminine_health_worker_groups_table', 1),
(9, '2023_09_07_140524_add_contact_to_users_table', 1),
(10, '2023_09_18_191833_alter_email_to_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('nelbanbetache@gmail.com', 'J5m6TwK9g0xwDxOIo3MGEUs6EbENuEh3APKwpm7WdrUAeolefDwBcrfGNnVmKQhq', '2024-06-30 15:14:06'),
('nelbanbetache@gmail.com', 'NAlg4gxsdAN2dlM0RX306FrCFoaVal9d443XRiiDiKuA1PIOYmNAoLDmlK2kXqJo', '2024-06-30 15:27:59'),
('nelbanbetache@gmail.com', 'bFnKOUkPiRhWwJqfxWGjPDxqCvRcufSz2qGTYVFyR0F8L8FMSYxmAbazybXuXB0F', '2024-06-30 15:28:39'),
('nelbanbetache@gmail.com', 'w4B6U98g5wCYyPU8WuHaQWFZ0Iljv35whEFDemWIIOAAjUbNBk8rNGaS6kSavrQB', '2024-06-30 15:41:33'),
('nelbanbetache@gmail.com', 'LHETFoXdoB95sqRYu2e6fL66FFqUuXUM0PJc962JWNUljevJFYfod1YWqvWtlL1W', '2024-06-30 15:47:09'),
('nelbanbetache@gmail.com', 'i4xplfQSkaoc2bFAevHKUVOvhP7wjW2VsAQEz3yH0hc5mcs0LFwyaPlxepWg2yVl', '2024-06-30 15:47:23'),
('nelbanbetache@gmail.com', 'KK4QCgmMvtBQfE1oG0HOz4B9Ov23GRT1yeKVxMPKHHZghzFcuR9Uwtaocl6wI5Sj', '2024-06-30 15:47:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menstruation_status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = inactive and might be pregnant, 1 = active and not pregnant, 2 = not applicable',
  `user_role_id` bigint(20) UNSIGNED NOT NULL DEFAULT 2,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `remarks` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `address`, `birthdate`, `email`, `contact_no`, `email_verified_at`, `password`, `menstruation_status`, `user_role_id`, `is_active`, `remarks`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'MCC', NULL, 'Admin', NULL, NULL, 'mcc@admin.com', NULL, NULL, '$2y$10$y49EjcFnqd5xVGNVN56e7eGSTPiFHmaRviPEAOgv0c7M8DkW8xcbC', 0, 1, 1, NULL, NULL, '2024-06-25 14:47:30', '2024-06-25 14:47:30'),
(5, 'Kiah', NULL, 'Bacolod', 'Tarong Madridejos Cebu', '2002-06-25', 'kiahbacolod@gmail.com', NULL, NULL, '$2y$10$s2p0bPuSPdRmp2S5HHXNV.zcX4.q9fKhb7ZavCYIN4V4uLL7gSYu.', 2, 3, 1, 'BHW sa Tarong', NULL, '2024-06-25 14:53:08', '2024-06-25 15:01:51'),
(6, 'Jee Ann', NULL, 'Apitong', 'Maalat Madridejos Cebu', '2002-12-07', 'toxophilite07@gmail.com', NULL, NULL, '$2y$10$3obYDZRGCp0z6/wHAT08EuzVzb7L/iyAKmWIRlT0S0ZLyfDhioPcq', 1, 2, 1, NULL, NULL, '2024-06-25 14:58:00', '2024-06-27 11:29:28'),
(7, 'Nelban', NULL, 'Betache', 'Tarong Madridejos Cebu', '2000-03-18', 'nelbanbetache@gmail.com', NULL, NULL, '$2y$10$2r/E4HmXsW23nwAPcZPXoeh.YLTVnk1OQ8zmrUp7dtInRsQpEJ4NG', 1, 2, 1, NULL, NULL, '2024-06-25 15:04:01', '2024-06-30 15:11:35'),
(8, 'Demo', NULL, 'Demo', 'Demo', '2002-06-25', 'nelban.betache18@gmail.com', NULL, NULL, '$2y$10$1D2wYQDkaLs8fbIr3qpHi.JyCduYTcztYFqS/tippBFRcXkXggIcy', 1, 2, 1, NULL, NULL, '2024-06-25 15:06:36', '2024-06-25 15:06:36'),
(9, 'Jhoana Mae', NULL, 'Santillan', 'Pili Madridejos Cebu', '2002-12-09', 'jhoanasantillan@gmail.com', NULL, NULL, '$2y$10$RRBaFXevJymRVztP.m/3DOA.D8qfnmUP0jNBG8bwwuXdtWv6SEDNy', 1, 2, 1, NULL, NULL, '2024-06-25 15:31:00', '2024-06-25 15:31:28'),
(10, 'Nelcrisa', NULL, 'Betache', 'Tarong Madridejos Cebu', '1999-07-20', 'nelcrisa@gmail.com', NULL, NULL, '$2y$10$lhOjq1bg.zwSYqutVFqsQuylDn2HoBCYHbg/8ZttOAL3bLtChlNQ2', 0, 2, 1, NULL, NULL, '2024-06-25 15:40:55', '2024-06-28 19:19:23'),
(11, 'Jhoana Mae', NULL, 'Santillan', '(Purok Gumamela) Tarong  Madridejos Cebu', '2000-04-07', 'jhoanamaesantillan@gmail.com', NULL, NULL, '$2y$10$9VxQxp8zUwNBDPh8OS0a/uyjXvGOQbxTwhOXf5a.O7eDDSfo.FiqW', 1, 2, 1, NULL, NULL, '2024-06-27 08:29:15', '2024-06-27 08:33:53'),
(13, 'Rosalina', NULL, 'Apitong', 'Maalat Maridejos Cebu', '2000-12-12', 'kiahbacolod1@gmail.com', NULL, NULL, '$2y$10$W6uoS/CE6Cf3nTy1uJUfhOxqgPvqO2D762c62Tbg/zIOEgVJXrz7S', 1, 2, 1, NULL, NULL, '2024-06-30 19:46:39', '2024-06-30 20:05:19'),
(14, 'Lou', NULL, 'Yi', 'Maalat Madridjeos Cebu', '2001-12-12', 'bacolodkiah16@gmail.com', NULL, NULL, '$2y$10$WUQ7OO1IbQlMkg.Rakb9PO/ORAfSHyYy9rD/.JS88zG.bFm8rSsgC', 1, 2, 0, NULL, NULL, '2024-07-06 05:48:49', '2024-07-06 05:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'User', NULL, NULL),
(3, 'Health Worker', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `feminine_health_worker_groups`
--
ALTER TABLE `feminine_health_worker_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feminine_health_worker_groups_feminine_id_foreign` (`feminine_id`),
  ADD KEY `feminine_health_worker_groups_health_worker_id_foreign` (`health_worker_id`);

--
-- Indexes for table `menstruation_periods`
--
ALTER TABLE `menstruation_periods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menstruation_periods_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_user_role_id_foreign` (`user_role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feminine_health_worker_groups`
--
ALTER TABLE `feminine_health_worker_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menstruation_periods`
--
ALTER TABLE `menstruation_periods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feminine_health_worker_groups`
--
ALTER TABLE `feminine_health_worker_groups`
  ADD CONSTRAINT `feminine_health_worker_groups_feminine_id_foreign` FOREIGN KEY (`feminine_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feminine_health_worker_groups_health_worker_id_foreign` FOREIGN KEY (`health_worker_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menstruation_periods`
--
ALTER TABLE `menstruation_periods`
  ADD CONSTRAINT `menstruation_periods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
