-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2021 at 06:39 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
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
  `email` varchar(150) COLLATE utf8mb4_swedish_ci NOT NULL,
  `scan_type` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `image` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `damage_lvl` varchar(30) COLLATE utf8mb4_swedish_ci NOT NULL,
  `process_token` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_report`
--

CREATE TABLE `data_report` (
  `id` int(11) NOT NULL,
  `fullname` varchar(30) COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_swedish_ci NOT NULL,
  `urlimage` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `buildtype` varchar(25) COLLATE utf8mb4_swedish_ci NOT NULL,
  `scan_type` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `address` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `geocordinate` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `damage_lvl` varchar(25) COLLATE utf8mb4_swedish_ci NOT NULL,
  `datetime` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `process_token` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(1) NOT NULL,
  `timestamp` bigint(20) NOT NULL,
  `verified_timestamp` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_token`
--

CREATE TABLE `data_token` (
  `id` int(11) NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_swedish_ci NOT NULL,
  `token` text COLLATE utf8mb4_swedish_ci NOT NULL,
  `start_date` bigint(20) NOT NULL,
  `end_date` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `login_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_user`
--

CREATE TABLE `data_user` (
  `id` int(11) NOT NULL,
  `photo` text COLLATE utf8mb4_swedish_ci NOT NULL,
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
-- Indexes for dumped tables
--

--
-- Indexes for table `data_process`
--
ALTER TABLE `data_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_report`
--
ALTER TABLE `data_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_token`
--
ALTER TABLE `data_token`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `data_report`
--
ALTER TABLE `data_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `data_token`
--
ALTER TABLE `data_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `data_user`
--
ALTER TABLE `data_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
