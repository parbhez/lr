-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2017 at 07:54 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lr`
--

-- --------------------------------------------------------

--
-- Table structure for table `lr_user`
--

CREATE TABLE `lr_user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lr_user`
--

INSERT INTO `lr_user` (`id`, `name`, `username`, `email`, `password`) VALUES
(6, 'Faria Rahman', 'Faria', 'faria@yahoo.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(7, 'Masud Parbhez', 'Parbhez', 'masud.affb@gmail.com', 'e10adc3949ba59abbe56e057f20f883e'),
(8, 'Sharmin Akther', 'Sharmin', 'sharmin@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(9, 'Ahadul Islam', 'pavel', 'pavel.affb@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055'),
(10, 'Saiful Islam bhuiyan', 'Saiful', 'saiful.affb@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lr_user`
--
ALTER TABLE `lr_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lr_user`
--
ALTER TABLE `lr_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
