-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2026 at 08:52 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_organizer`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `event_id`, `status`, `created_at`) VALUES
(14, 13, 11, 'approved', '2026-06-02 19:33:21'),
(16, 6, 16, 'rejected', '2026-06-03 13:39:40'),
(18, 13, 12, 'approved', '2026-06-04 07:45:28'),
(20, 15, 21, 'approved', '2026-06-04 07:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(8, 'Bootcamp & Workshop'),
(5, 'Festival'),
(10, 'Konser Hiburan'),
(1, 'Music'),
(7, 'Seminar & Edukasi'),
(4, 'Sport'),
(9, 'Turnamen E-Sports');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `event_id`, `comment`, `created_at`) VALUES
(7, 13, 16, 'p saya A', '2026-06-02 19:51:15'),
(8, 6, 16, 'p saya B', '2026-06-02 20:35:12'),
(9, 6, 16, 'saya B juga', '2026-06-03 13:40:25'),
(10, 15, 21, 'halo', '2026-06-04 07:55:57'),
(11, 15, 11, 'ui', '2026-06-04 08:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `owner_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT 'default.jpg',
  `quota` int DEFAULT '50',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `price` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `owner_id`, `title`, `description`, `date`, `location`, `category_id`, `image`, `quota`, `created_at`, `price`) VALUES
(11, 12, 'Music Festival', 'Festival musik dengan artis nasional.', '2026-08-01', 'Bandung', 1, 'default.jpg', 200, '2026-05-20 05:18:31', 50000),
(12, 12, 'Startup Workshop', 'Belajar membangun startup dari nol.', '2026-06-15', 'Surabaya', 8, 'default.jpg', 50, '2026-05-20 05:18:31', 50000),
(16, 12, 'Cyber Security Meetup', 'Diskusi keamanan siber terbaru.', '2026-06-28', 'Malang', 8, 'default.jpg', 60, '2026-05-20 05:18:31', 50000),
(17, 12, 'UI UX Design Camp', 'Pelatihan desain UI UX interaktif.', '2026-07-22', 'Makassar', 7, 'default.jpg', 70, '2026-05-20 05:18:31', 50000),
(21, 12, 'Bootcamp Web Development HMIF', 'Pelatihan intensif pengembangan aplikasi web menggunakan CodeIgniter 4 dan Tailwind CSS. Cocok untuk mahasiswa yang ingin memperdalam full-stack development.', '2026-06-15', 'Gedung Universitas Mataram', 8, 'default.jpg', 50, '2026-05-25 06:11:57', 50000),
(22, 12, 'Turnamen eFootball 2026 Campus Edition', 'Ajang unjuk taktik dan skill bermain eFootball tingkat universitas. Buktikan siapa manajer terbaik dengan formasi 4-3-1-2 andalanmu!', '2026-06-25', 'Arena E-Sports Mataram', 9, '1780560297_b27fe6fd6003ecba6b37.jpg', 64, '2026-05-25 06:11:57', 50000),
(26, 17, 'Event Seri 1 - EO ID 17', 'Deskripsi profesional untuk event seri ke-1.', '2026-06-05', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(27, 17, 'Event Seri 2 - EO ID 17', 'Deskripsi profesional untuk event seri ke-2.', '2026-06-06', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(28, 17, 'Event Seri 3 - EO ID 17', 'Deskripsi profesional untuk event seri ke-3.', '2026-06-07', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(29, 18, 'Event Seri 1 - EO ID 18', 'Deskripsi profesional untuk event seri ke-1.', '2026-06-05', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(30, 18, 'Event Seri 2 - EO ID 18', 'Deskripsi profesional untuk event seri ke-2.', '2026-06-06', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(31, 18, 'Event Seri 3 - EO ID 18', 'Deskripsi profesional untuk event seri ke-3.', '2026-06-07', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(32, 19, 'Event Seri 1 - EO ID 19', 'Deskripsi profesional untuk event seri ke-1.', '2026-06-05', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(33, 19, 'Event Seri 2 - EO ID 19', 'Deskripsi profesional untuk event seri ke-2.', '2026-06-06', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000),
(34, 19, 'Event Seri 3 - EO ID 19', 'Deskripsi profesional untuk event seri ke-3.', '2026-06-07', 'Mataram City', 1, 'default.jpg', 100, '2026-06-04 08:37:40', 50000);

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `event_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `event_id`, `created_at`) VALUES
(8, 13, 17, '2026-06-02 20:37:32'),
(9, 6, 16, '2026-06-03 13:40:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user','organizer','admin') DEFAULT 'user',
  `avatar` varchar(255) DEFAULT NULL,
  `bio` text,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `avatar`, `bio`, `phone`, `created_at`) VALUES
(6, 'Muhammad Akbar -  Arthur', 'f1d02410075@student.unram.ac.id', '$2y$10$OrSZOOMLFOwe7Hx0y.Sq1OiOoFu8YwdVdeTbJ78TvpD//BA1zeSOu', 'user', '1780432851_d2bdcfa849e89ba94ece.jpg', 'Halo guys', '6285253820284', '2026-05-19 00:36:25'),
(7, 'Mustafida - Firda', 'f1d02410126@student.unram.ac.id', '$2y$10$8CccO.T.9BXfyttI3AkVtOeAqtliUkbZkuBxXDWJNOdVNI9bIZVc2', 'organizer', NULL, 'Halo guys', '6285253820284', '2026-05-19 00:45:07'),
(8, 'Musfiqoh Rizkia Aulia - Rizka', 'f1d02410083@student.unram.ac.id', '$2y$10$rrztaLBn0UQnKb0H.xCuJunlcuRYrHLTiqvElp0hgxi/mqihr6Rva', 'admin', NULL, NULL, '6285253820284', '2026-05-19 00:54:57'),
(11, 'A1 Official', 'admin@eo.com', '$2y$10$kzj3y8qK/SL5Rmhmu0o7Vew1j1bAG72Fs0Rsj2XmdIU5WKGjselBG', 'admin', NULL, 'Administrator utama sistem EO Management.', '6285253820284', '2026-05-25 06:11:57'),
(12, 'EO1 Official', 'organizer@eo.com', '$2y$10$SU9vRMjaAQaoL8PN8rZhy.oqzCXU0SCVoUV2Vr.ycGdb9/NvCLazS', 'organizer', NULL, 'Penyelenggara event kampus dan turnamen gaming.', '6285253820284', '2026-05-25 06:11:57'),
(13, 'U1 Official', 'user@user.com', '$2y$10$1Emu1jFuLdNY.5UUVgN6jOHCdIV4uLZO6QJ9i4Nqg0uXuKmYDEicG', 'user', NULL, 'Mahasiswa Teknik Informatika penggiat IT.', '6285253820284', '2026-05-25 06:11:57'),
(15, 'Peserta Tester 1', 'peserta1@tester.com', '$2y$10$6ppTOlwfLpWoEukaFcpqCukfes6rS/yVkHfaigrqzM5wt/XRf.bs.', 'user', NULL, 'Saya tester', '6285253820284', '2026-06-04 07:52:33'),
(17, 'EO2 Official', 'organizer2@eo.com', '$2y$10$NCT9UWzpF9N8YeqrzfMPd.9HV3azcgQXtEjuX3QBA.x9r5b8.YUgK', 'organizer', NULL, 'Penyelenggara event kampus.', '6285253820284', '2026-06-04 08:37:40'),
(18, 'EO3 Official', 'organizer3@eo.com', '$2y$10$IadfjF8e8TBm1gJXwWeNSeDZZr6yEFbNAsIgXd6xazsoQtbmAD4oC', 'organizer', NULL, 'Spesialis turnamen gaming.', '6285253820284', '2026-06-04 08:37:40'),
(19, 'EO4 Official', 'organizer4@eo.com', '$2y$10$W7i26HWT5eWXLjdDQihXQefsRIYJJNI6Hvrz1QhdIYx5FMyVizIW2', 'organizer', NULL, 'Penyelenggara seminar IT.', '6285253820284', '2026-06-04 08:37:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_be` (`event_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkc_ce` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`event_id`),
  ADD UNIQUE KEY `unique_fav` (`user_id`,`event_id`),
  ADD KEY `fkc_fe` (`event_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fkc_be` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fkc_ce` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `fkc_fe` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
