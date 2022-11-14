-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2022 at 01:50 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `abcd`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `referred_by` varchar(255) DEFAULT NULL,
  `earn` int(11) DEFAULT 0,
  `referrals` int(11) DEFAULT 0,
  `codes` int(11) DEFAULT 0,
  `balance` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `password`, `dob`, `email`, `city`, `referred_by`, `earn`, `referrals`, `codes`, `balance`) VALUES
(1, 'prasad', '8778635681', '12345678', '2000-01-11', 'jp@gmail.com', '8778635681', '324343', 0, 0, 0, 0),
(2, 'Tamilarasan', '6382088746', '12345678', '2022-11-13', 'tamil632000@gmail.com', '6382088746', 'tamil', 0, 0, 0, 0),
(3, 'Tamilarasan', '9965313369', '12345678', '2022-11-13', 'tamil632000@gmail.com', '9965313369', 'tamil', 0, 0, 0, 0),
(4, 'Tamilarasan', '9965313368', '12345678', '2022-11-13', 'tamil632000@gmail.com', '9965313368', 'tamil', 0, 0, 0, 0),
(5, 'Tamilarasan', '6382088744', '12345678', '2022-11-13', 'tamil632000@gmail.com', '6382088744', 'tamil', 0, 0, 0, 0),
(6, 'prasad', '9876543210', '12345678', '2022-11-14', 'jayaprasad356@gmail.com', '9876543210', '', 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
