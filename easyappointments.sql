-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 02:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easyappointments`
--

-- --------------------------------------------------------

--
-- Table structure for table `ea_appointments`
--

CREATE TABLE `ea_appointments` (
  `id` int(11) NOT NULL,
  `book_datetime` datetime DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `location` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `hash` text DEFAULT NULL,
  `is_unavailable` tinyint(4) NOT NULL DEFAULT 0,
  `id_users_provider` int(11) DEFAULT NULL,
  `id_users_customer` int(11) DEFAULT NULL,
  `id_services` int(11) DEFAULT NULL,
  `id_google_calendar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_appointments`
--

INSERT INTO `ea_appointments` (`id`, `book_datetime`, `start_datetime`, `end_datetime`, `location`, `notes`, `hash`, `is_unavailable`, `id_users_provider`, `id_users_customer`, `id_services`, `id_google_calendar`) VALUES
(16, '2023-11-04 21:53:17', '2023-11-05 09:00:00', '2023-11-05 10:30:00', '', '', 'qVRatWEcwnAg', 0, 2, 15, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ea_consents`
--

CREATE TABLE `ea_consents` (
  `id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(256) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `ip` varchar(256) DEFAULT NULL,
  `type` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ea_migrations`
--

CREATE TABLE `ea_migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_migrations`
--

INSERT INTO `ea_migrations` (`version`) VALUES
(21);

-- --------------------------------------------------------

--
-- Table structure for table `ea_roles`
--

CREATE TABLE `ea_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT NULL,
  `appointments` int(11) DEFAULT NULL,
  `customers` int(11) DEFAULT NULL,
  `services` int(11) DEFAULT NULL,
  `users` int(11) DEFAULT NULL,
  `system_settings` int(11) DEFAULT NULL,
  `user_settings` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_roles`
--

INSERT INTO `ea_roles` (`id`, `name`, `slug`, `is_admin`, `appointments`, `customers`, `services`, `users`, `system_settings`, `user_settings`) VALUES
(1, 'Administrator', 'admin', 1, 15, 15, 15, 15, 15, 15),
(2, 'Provider', 'provider', 0, 15, 15, 0, 0, 0, 15),
(3, 'Customer', 'customer', 0, 0, 0, 0, 0, 0, 0),
(4, 'Secretary', 'secretary', 0, 15, 15, 0, 0, 0, 15);

-- --------------------------------------------------------

--
-- Table structure for table `ea_secretaries_providers`
--

CREATE TABLE `ea_secretaries_providers` (
  `id_users_secretary` int(11) NOT NULL,
  `id_users_provider` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ea_services`
--

CREATE TABLE `ea_services` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `currency` varchar(32) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `location` text DEFAULT NULL,
  `availabilities_type` varchar(32) DEFAULT 'flexible',
  `attendants_number` int(11) DEFAULT 1,
  `id_service_categories` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_services`
--

INSERT INTO `ea_services` (`id`, `name`, `duration`, `price`, `currency`, `description`, `location`, `availabilities_type`, `attendants_number`, `id_service_categories`) VALUES
(1, 'Service', 30, 0.00, '', NULL, NULL, 'flexible', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ea_services_providers`
--

CREATE TABLE `ea_services_providers` (
  `id_users` int(11) NOT NULL,
  `id_services` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_services_providers`
--

INSERT INTO `ea_services_providers` (`id_users`, `id_services`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ea_service_categories`
--

CREATE TABLE `ea_service_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ea_settings`
--

CREATE TABLE `ea_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(512) DEFAULT NULL,
  `value` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_settings`
--

INSERT INTO `ea_settings` (`id`, `name`, `value`) VALUES
(1, 'company_working_plan', '{\"monday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"tuesday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"wednesday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"thursday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"friday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"saturday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"sunday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]}}'),
(2, 'book_advance_timeout', '30'),
(3, 'google_analytics_code', ''),
(4, 'customer_notifications', '1'),
(5, 'date_format', 'DMY'),
(6, 'require_captcha', '0'),
(7, 'time_format', 'regular'),
(8, 'display_cookie_notice', '0'),
(9, 'cookie_notice_content', 'Cookie notice content.'),
(10, 'display_terms_and_conditions', '0'),
(11, 'terms_and_conditions_content', 'Terms and conditions content.'),
(12, 'display_privacy_policy', '0'),
(13, 'privacy_policy_content', 'Privacy policy content.'),
(14, 'first_weekday', 'sunday'),
(15, 'require_phone_number', '1'),
(16, 'api_token', ''),
(17, 'display_any_provider', '1'),
(18, 'company_name', 'Appointment System'),
(19, 'company_email', 'mycompanyemail@gmail.com'),
(20, 'company_link', 'https://companylink.com');

-- --------------------------------------------------------

--
-- Table structure for table `ea_users`
--

CREATE TABLE `ea_users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(256) DEFAULT NULL,
  `last_name` varchar(512) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `mobile_number` varchar(128) DEFAULT NULL,
  `phone_number` varchar(128) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `state` varchar(128) DEFAULT NULL,
  `zip_code` varchar(64) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `timezone` varchar(256) DEFAULT 'UTC',
  `dateOfBirth` varchar(255) NOT NULL,
  `motherMaidenName` varchar(255) NOT NULL,
  `programGraduatedEnrolled` varchar(255) NOT NULL,
  `yearGraduate` varchar(255) NOT NULL,
  `nameOfSchool` varchar(255) NOT NULL,
  `document_requested` varchar(255) NOT NULL,
  `uploaded_valid_id` varchar(255) NOT NULL,
  `language` varchar(256) DEFAULT 'english',
  `id_roles` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_users`
--

INSERT INTO `ea_users` (`id`, `first_name`, `last_name`, `email`, `mobile_number`, `phone_number`, `address`, `city`, `state`, `zip_code`, `notes`, `timezone`, `dateOfBirth`, `motherMaidenName`, `programGraduatedEnrolled`, `yearGraduate`, `nameOfSchool`, `document_requested`, `uploaded_valid_id`, `language`, `id_roles`) VALUES
(1, 'drexell', 'mingo', 'drexell.mingo.18624@gmail.com', NULL, '09661461793', NULL, NULL, NULL, NULL, NULL, 'UTC', '', '', '', '', '', '', '', 'english', 1),
(2, 'Jane', 'Doe', 'jane@example.org', NULL, '+1 (000) 000-0000', NULL, NULL, NULL, NULL, NULL, 'UTC', '', '', '', '', '', '', '', 'english', 2),
(3, 'James', 'Doe', 'james@example.org', NULL, '+1 (000) 000-0000', NULL, NULL, NULL, NULL, NULL, 'UTC', '', '', '', '', '', '', '', 'english', 3),
(15, 'drexellee', 'mingooo', 'drexell.mingooo.18624@gmail.com', NULL, '09661461793', '', '', NULL, '', '', 'Asia/Manila', '1997-05-30', 'Motherrrrrr', 'BSITE', '2024', 'AMA UNIVERSITYY', 'Special Order', '1699131194069_86_z2.png,1699131194069_793_z1.jpg', 'english', 3);

-- --------------------------------------------------------

--
-- Table structure for table `ea_user_settings`
--

CREATE TABLE `ea_user_settings` (
  `id_users` int(11) NOT NULL,
  `username` varchar(256) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `salt` varchar(512) DEFAULT NULL,
  `working_plan` text DEFAULT NULL,
  `working_plan_exceptions` text DEFAULT NULL,
  `notifications` tinyint(4) DEFAULT NULL,
  `google_sync` tinyint(4) DEFAULT NULL,
  `google_token` text DEFAULT NULL,
  `google_calendar` varchar(128) DEFAULT NULL,
  `sync_past_days` int(11) DEFAULT 30,
  `sync_future_days` int(11) DEFAULT 90,
  `calendar_view` varchar(32) DEFAULT 'default'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ea_user_settings`
--

INSERT INTO `ea_user_settings` (`id_users`, `username`, `password`, `salt`, `working_plan`, `working_plan_exceptions`, `notifications`, `google_sync`, `google_token`, `google_calendar`, `sync_past_days`, `sync_future_days`, `calendar_view`) VALUES
(1, 'bossingtest', 'c117ba2f1bda277bcb866f573e151e382cd1608b4749431cf2d02efc042840d8', 'eeeab3df06153548a8e167af604838a924bd6d69fcab8a7c093c788de17f3953', NULL, NULL, 1, NULL, NULL, NULL, 30, 90, 'default'),
(2, 'janedoe', '8a1e1433c4ab904b52869b601ad193ec6feced28b561aceff8f3b11f35151e68', '0adbe47315759f79245a39bc4a8bd6e4ec7f11a1445f561edf4bf96ca3e9a3ca', '{\"monday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"tuesday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"wednesday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"thursday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"friday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"saturday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]},\"sunday\":{\"start\":\"09:00\",\"end\":\"18:00\",\"breaks\":[{\"start\":\"14:30\",\"end\":\"15:00\"}]}}', NULL, 1, 0, NULL, NULL, 30, 90, 'default');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ea_appointments`
--
ALTER TABLE `ea_appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_users_provider` (`id_users_provider`),
  ADD KEY `id_users_customer` (`id_users_customer`),
  ADD KEY `id_services` (`id_services`);

--
-- Indexes for table `ea_consents`
--
ALTER TABLE `ea_consents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ea_roles`
--
ALTER TABLE `ea_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ea_secretaries_providers`
--
ALTER TABLE `ea_secretaries_providers`
  ADD PRIMARY KEY (`id_users_secretary`,`id_users_provider`),
  ADD KEY `secretaries_users_provider` (`id_users_provider`);

--
-- Indexes for table `ea_services`
--
ALTER TABLE `ea_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_service_categories` (`id_service_categories`);

--
-- Indexes for table `ea_services_providers`
--
ALTER TABLE `ea_services_providers`
  ADD PRIMARY KEY (`id_users`,`id_services`),
  ADD KEY `services_providers_services` (`id_services`);

--
-- Indexes for table `ea_service_categories`
--
ALTER TABLE `ea_service_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ea_settings`
--
ALTER TABLE `ea_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ea_users`
--
ALTER TABLE `ea_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_roles` (`id_roles`);

--
-- Indexes for table `ea_user_settings`
--
ALTER TABLE `ea_user_settings`
  ADD PRIMARY KEY (`id_users`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ea_appointments`
--
ALTER TABLE `ea_appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `ea_consents`
--
ALTER TABLE `ea_consents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ea_roles`
--
ALTER TABLE `ea_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `ea_services`
--
ALTER TABLE `ea_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ea_service_categories`
--
ALTER TABLE `ea_service_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ea_settings`
--
ALTER TABLE `ea_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ea_users`
--
ALTER TABLE `ea_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ea_appointments`
--
ALTER TABLE `ea_appointments`
  ADD CONSTRAINT `appointments_services` FOREIGN KEY (`id_services`) REFERENCES `ea_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_users_customer` FOREIGN KEY (`id_users_customer`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_users_provider` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ea_secretaries_providers`
--
ALTER TABLE `ea_secretaries_providers`
  ADD CONSTRAINT `secretaries_users_provider` FOREIGN KEY (`id_users_provider`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `secretaries_users_secretary` FOREIGN KEY (`id_users_secretary`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ea_services`
--
ALTER TABLE `ea_services`
  ADD CONSTRAINT `services_service_categories` FOREIGN KEY (`id_service_categories`) REFERENCES `ea_service_categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ea_services_providers`
--
ALTER TABLE `ea_services_providers`
  ADD CONSTRAINT `services_providers_services` FOREIGN KEY (`id_services`) REFERENCES `ea_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `services_providers_users_provider` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ea_users`
--
ALTER TABLE `ea_users`
  ADD CONSTRAINT `users_roles` FOREIGN KEY (`id_roles`) REFERENCES `ea_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ea_user_settings`
--
ALTER TABLE `ea_user_settings`
  ADD CONSTRAINT `user_settings_users` FOREIGN KEY (`id_users`) REFERENCES `ea_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
