-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2022 at 06:46 PM
-- Server version: 10.3.31-MariaDB-0+deb10u1
-- PHP Version: 7.3.31-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ShineGG`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) NOT NULL,
  `name` char(40) NOT NULL DEFAULT '',
  `team` varchar(10) NOT NULL,
  `region` char(20) NOT NULL DEFAULT 'US_EC',
  `main_char` varchar(20) DEFAULT NULL,
  `profile_picture` char(180) DEFAULT NULL,
  `password` text NOT NULL,
  `bio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `team`, `region`, `main_char`, `profile_picture`, `password`, `bio`) VALUES
(1, 'Fir\'', 'KC', 'EU', 'Sheik', 'https://pbs.twimg.com/media/FSwMJzNXsAAHYer.jpg', 'Xuyeqe(1', 'J\'adore Kirby. Je pense que les personnes qui aiment Kirby méritent plus d\'avantages que les autres personnes comme une prime spéciale du gouvernement chaque mois. Travail, Patrie, Kirby.'),
(2, 'Namu', '', 'EU', NULL, 'https://cdn.discordapp.com/attachments/556553671501021194/962312307415871528/1577619071292.png', 'pi', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
