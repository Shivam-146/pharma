-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 31, 2026 at 08:58 PM
-- Server version: 10.11.16-MariaDB-cll-lve
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demotechnodome_pharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$MDBKslfyqB1XIg.7fN6hnuDyL0b6WK5lvUqNuICTbNrFv92cEieU6', '2026-05-21 06:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(3, 'Eye Drop', 'eye-drop', '2026-05-28 07:15:09'),
(4, 'MouthWash', 'mouthwash', '2026-05-28 07:15:32'),
(5, 'Tablets', 'tablets', '2026-05-28 08:42:07'),
(6, 'Syrups', 'syrups', '2026-05-28 08:42:18');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(50) DEFAULT 'New',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(500) DEFAULT NULL COMMENT 'Path relative to project root',
  `additional_images` text DEFAULT NULL,
  `composition` text DEFAULT NULL,
  `uses` text DEFAULT NULL,
  `dosage` text DEFAULT NULL,
  `safety_information` text DEFAULT NULL,
  `storage` text DEFAULT NULL,
  `manufacturer_details` text DEFAULT NULL,
  `brochure` varchar(500) DEFAULT NULL COMMENT 'Path relative to project root',
  `badge` varchar(100) DEFAULT NULL COMMENT 'e.g. Best Seller, New',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `image`, `additional_images`, `composition`, `uses`, `dosage`, `safety_information`, `storage`, `manufacturer_details`, `brochure`, `badge`, `created_at`) VALUES
(2, 4, 'Alkadent+', 'alkadent', 'uploads/products/alkadent_1779955470.png', NULL, 'Chlorhexidine Gluconate(0.2%),Sodium Fluoride(0.05%),Zinc Chloride(0.09%),Peppermint Extract', '1. Strengthens enamel and resuces plaque buildup.\r\n2. Suitable for adults and teens aged 12 and above.\r\n3.Alcohol Free Formula - safe for senaitive mouths\r\n4.Kills 99.9% of germs with every Rinse', 'Designed for everyday Use.\r\nProcedure:\r\n1. Pour 20ml \r\n2.Rinse 30sec\r\n3.Spit Out\r\n4.Wait 30 min', NULL, NULL, 'Manufactured By Maascure Pharmaceutical Private Limited.', NULL, NULL, '2026-05-28 07:26:42'),
(3, 3, 'Optirelief', 'optirelief', 'uploads/products/optirelief_1779956119.jpeg', NULL, 'Carboxymethyl Cellulose-1% (w/v)', 'Relieves the symptoms of dry,irritated eyes.\r\nIt lubricates,hydreates and contributes to tear regeneration.', 'As durected by the Physician', NULL, 'Store in cool Place.\r\nProtect from Light.\r\nDo not freeze.\r\nKeep out of reach of children.', 'Mannufactured by Maascure Pharmaceutical Pvt. Limited.', NULL, NULL, '2026-05-28 08:15:19'),
(4, 3, 'Oculocef', 'oculocef', 'uploads/products/oculocef_1779958050.png', NULL, NULL, 'Broad Spectrum Antibiotic Eye Drop', 'As directed by Ophthalmologist.', NULL, 'Store below 25\'C.', 'Mannufactured by Maascure Pharmaceutical Pvt. Limited.', NULL, NULL, '2026-05-28 08:47:30'),
(5, 5, 'Cefmocure', 'cefmocure', 'uploads/products/cefmocure_1779958222.png', NULL, 'Cefixime 200mg', 'Broad Spectrum Antibiotic.', 'As directed by Physician', NULL, NULL, 'Mannufactured by Maascure Pharmaceutical Pvt. Limited.', NULL, NULL, '2026-05-28 08:50:22'),
(6, 5, 'Cap Q10', 'cap-q10', 'uploads/products/cap-q10_1780209101.png', NULL, NULL, 'Energy, Immunity, Heart Health, Overall Wellness', NULL, NULL, NULL, 'Manufactured by Maascure Pharmaceutical Pvt. Limited.', NULL, NULL, '2026-05-28 08:52:28'),
(7, 5, 'Hepatovex', 'hepatovex', 'uploads/products/hepatovex_1780211742.png', NULL, 'Vitamin B12', '1. Reduces Liver Fat\r\n2. Promotes Regeneration\r\n3. Protects Liver Cells\r\n4. Improves Metabolism', 'As per the Physician', 'Protect from direct sunlight\r\nKeep out of reach of the children', 'Store in an cool,dry place', 'Mannufactured by Maascure Pharmaceutical Pvt. Limited.', NULL, NULL, '2026-05-31 07:07:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
