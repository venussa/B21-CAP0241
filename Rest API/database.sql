-- phpMyAdmin SQL Dump
-- version 4.6.6deb4+deb9u2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2021 at 02:48 PM
-- Server version: 10.1.48-MariaDB-0+deb9u2
-- PHP Version: 7.0.33-0+deb9u10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bangunan`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_process`
--

CREATE TABLE `data_process` (
  `id` int(11) NOT NULL,
  `fullname` varchar(32) COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_swedish_ci NOT NULL,
  `urlimage` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `buildtype` varchar(25) COLLATE utf8mb4_swedish_ci NOT NULL,
  `address` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `geocordinate` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `damage_lvl` varchar(25) COLLATE utf8mb4_swedish_ci NOT NULL,
  `datetime` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(1) NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `data_process`
--

INSERT INTO `data_process` (`id`, `fullname`, `email`, `urlimage`, `buildtype`, `address`, `geocordinate`, `damage_lvl`, `datetime`, `status`, `timestamp`) VALUES
(13, 'Yudha Romadhon', 'steavenroger@gmail.com', 'upload/steavenrogergmail.com-1622408699.jpeg', 'Bangunan', 'JL. Peggangsaan Timur No.56 Jakarta Pusat', '-6.205367099999995, 106.89148713256965', 'Rusak Berat', '2021-05-30 21:19:16', 0, 1622384356),
(15, 'Yudha Romadhon', 'steavenroger@gmail.com', 'upload/steavenrogergmail.com-1622409649.jpeg', 'Bangunan', 'JL. Peggangsaan Timur No.56 Jakarta Pusat', '-6.205367099999995, 106.89148713256965', 'Rusak Berat', '2021-05-30 21:27:42', 0, 1622384862);

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id` int(11) NOT NULL,
  `fullname` varchar(60) COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_swedish_ci NOT NULL,
  `province` varchar(20) COLLATE utf8mb4_swedish_ci NOT NULL,
  `city` varchar(20) COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `role` varchar(10) COLLATE utf8mb4_swedish_ci NOT NULL,
  `register_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumping data for table `data_user`
--

INSERT INTO `data_user` (`id`, `fullname`, `email`, `phone`, `province`, `city`, `password`, `role`, `register_time`) VALUES
(1, 'Yudha Romadhon 1', 'steavenroger@gmail.com', '082110975564', 'Sumatra Barat', 'Padang', 'ab56b4d92b40713acc5af89985d4b786', 'user', 1622252667),
(2, 'Dian Kristy Pasaribu', 'dainty@gmail.com', '082110976557', 'Sumatra Utara', 'Medan', 'e10adc3949ba59abbe56e057f20f883e', 'user', 1622252667),
(3, 'Geadalfa Giyanda', 'sad_boy@gmail.com', '082110976558', 'Jawa barat', 'Depok', 'e10adc3949ba59abbe56e057f20f883e', 'user', 1622252667),
(4, 'Anggara Diebrata', 'anggara@gmail.com', '082110976559', 'Jawa Tengah', 'Semarang', 'e10adc3949ba59abbe56e057f20f883e', 'admin', 1622252667),
(5, 'Farhan Eka Fajri', 'the_healer_lv3@gmail.com', '082110976560', 'DKI Jakarta', 'Jakarta Timur', 'e10adc3949ba59abbe56e057f20f883e', 'user', 1622252667),
(6, 'Rizky Damayanty Ritonga', 'rizky@gmail.com', '082110976561', 'Sumatra Utara', 'Medan', 'e10adc3949ba59abbe56e057f20f883e', 'user', 1622252667),
(9, 'Sadrian sadboi', 'reallysadboi@gmail.com', '082110697169', 'Jawa Barat', 'Depok', 'd1b2cc725d846f0460ff290c60925070', 'user', 1622369469);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_process`
--
ALTER TABLE `data_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_user`
--
ALTER TABLE `data_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_process`
--
ALTER TABLE `data_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
