-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 16, 2020 at 08:50 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci-template`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbltoken`
--

CREATE TABLE `tbltoken` (
  `id` int(255) NOT NULL,
  `token` text NOT NULL,
  `username` text NOT NULL,
  `expireTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbltoken`
--

INSERT INTO `tbltoken` (`id`, `token`, `username`, `expireTime`) VALUES
(1, 'TVRZd01qUXlOelkwTlN3M05qWTJNemN3TlRNPQ==', '766637053', 1602427645),
(2, 'TVRZd01qUXlOemczTUN3M05qWTJNemN3TlRNPQ==', '766637053', 1602427870),
(3, 'TVRZd01qUXlPREV4Tml3M05qWTJNemN3TlRJPQ==', '766637052', 1602428116),
(4, 'TVRZd01qUXpOekV6TkN3M05qWTJNemN3TlRJPQ==', '766637052', 1602437134),
(5, 'TVRZd01qUXpOelkzTUN4aFpHMXBiZz09', 'admin', 1602437670),
(6, 'TVRZd01qUXpOemN3Tnl4aFpHMXBiZz09', 'admin', 1602437707),
(7, 'TVRZd01qUTJPVFUyTWl3M05qWTJNemN3TlRJPQ==', '766637052', 1602469562),
(8, 'TVRZd01qUTJPVGc0TVN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469881),
(9, 'TVRZd01qUTJPVGt5TVN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469921),
(10, 'TVRZd01qUTJPVGswTlN3M05qWTJNemN3TlRJPQ==', '766637052', 1602469945),
(11, 'TVRZd01qVXhORE0xT1N4aFpHMXBiZz09', 'admin', 1602514359);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL COMMENT 'Unique ID of the user',
  `activated` int(11) NOT NULL DEFAULT 0 COMMENT '1 if active; 0 if not',
  `email` varchar(20) NOT NULL COMMENT 'Email of the user (unique)',
  `password` varchar(255) NOT NULL COMMENT 'Hash of the password',
  `fullname` varchar(200) NOT NULL COMMENT 'Human readable full name',
  `rawPassword` text NOT NULL COMMENT 'DEBUG ONLY',
  `type` int(11) NOT NULL DEFAULT 1 COMMENT '0 for admin and 1 for user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `activated`, `email`, `password`, `fullname`, `rawPassword`, `type`) VALUES
(1, 1, 'admin', '$2y$10$o/JZyopHlAAeaDOLpL0WE.zsjqxViLPwOK7BPtn9yd9swZIqoDOMu', 'Administrator', 'Bestcoop1!', 0),
(2, 1, '766637052', '$2y$10$p.PoHwvmmni2xxcI70WtQu3yF1cQoFx3W8Qfs1G4zATtDqYU9qkwa', 'Praveen Jayakody', '', 2),
(11, 0, '766637056', '$2y$10$rZXNuUaxNMqekAYj3AMbfeFECRNCkVwSjtZDxwJcXt3UcMvHcg1xa', 'Mail Example', '', 1),
(12, 1, '766637052', '$2y$10$Icx296pO7PNy6icSSA1Fu.KCtiVImUK95ZSPGk0f9Z9VfgHXw27xS', 'Praveen Jayakody', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `verify`
--

CREATE TABLE `verify` (
  `id` int(11) NOT NULL,
  `token` int(6) NOT NULL,
  `username` text NOT NULL,
  `expireTime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbltoken`
--
ALTER TABLE `tbltoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify`
--
ALTER TABLE `verify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbltoken`
--
ALTER TABLE `tbltoken`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique ID of the user', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `verify`
--
ALTER TABLE `verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
