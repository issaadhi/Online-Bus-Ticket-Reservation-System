-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2021 at 11:42 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bus_ticket_booking_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booked_ticket`
--

CREATE TABLE `booked_ticket` (
  `id` int(30) NOT NULL,
  `bus_id` int(30) NOT NULL,
  `name` text NOT NULL,
  `address` text NOT NULL,
  `contact` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `booked_ticket`
--

INSERT INTO `booked_ticket` (`id`, `bus_id`, `name`, `address`, `contact`) VALUES
(6, 21, 'Pasindu', '12345', '0001049'),
(7, 22, 'Sahan', '7/2, Kuliyapitiya, Kurunegala. ', '0789864571'),
(8, 22, 'Sithara', '7/2, Kuliyapitiya, Kurunegala', '0778745121');

-- --------------------------------------------------------

--
-- Table structure for table `bus_list`
--

CREATE TABLE `bus_list` (
  `id` int(30) NOT NULL,
  `reg_No` text NOT NULL,
  `logo_path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_list`
--

INSERT INTO `bus_list` (`id`, `reg_No`, `logo_path`) VALUES
(1, 'NA-1023', 'b1.jpg'),
(4, 'NB-4588', '1633598280_b2.jpg'),
(5, 'ND-3759', '1633598280_b3.jpg'),
(6, 'ND-4753', '1633598340_b4.jpg'),
(7, 'NA-3398', '1633598340_b6.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `bus_sch_list`
--

CREATE TABLE `bus_sch_list` (
  `id` int(30) NOT NULL,
  `bus_id` int(30) NOT NULL,
  `bus_no` text NOT NULL,
  `departure_station_id` int(30) NOT NULL,
  `arrival_station_id` int(30) NOT NULL,
  `departure_datetime` datetime NOT NULL,
  `arrival_datetime` datetime NOT NULL,
  `seats` int(10) NOT NULL DEFAULT 0,
  `price` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_sch_list`
--

INSERT INTO `bus_sch_list` (`id`, `bus_id`, `bus_no`, `departure_station_id`, `arrival_station_id`, `departure_datetime`, `arrival_datetime`, `seats`, `price`, `date_created`) VALUES
(22, 5, '', 8, 1, '2021-10-30 08:00:00', '2021-10-30 11:00:00', 45, 90, '2021-10-07 14:55:55'),
(23, 7, '', 10, 9, '2021-10-30 09:00:00', '2021-10-30 14:00:00', 40, 160, '2021-10-07 14:56:54'),
(24, 1, '', 1, 6, '2021-10-30 08:00:00', '2021-10-30 12:00:00', 35, 140, '2021-10-07 14:57:55');

-- --------------------------------------------------------

--
-- Table structure for table `bus_station_list`
--

CREATE TABLE `bus_station_list` (
  `id` int(30) NOT NULL,
  `bus_station` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_station_list`
--

INSERT INTO `bus_station_list` (`id`, `bus_station`, `city`) VALUES
(1, 'Katugasthota', 'Kandy'),
(6, 'Diyathalawa', 'Badulla'),
(8, 'Kuliyapitiya', 'Kurunegala'),
(9, 'Fort', 'Colombo'),
(10, 'Fort', 'Galle');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'Online Bus Ticket Booking System', 'info@sample.comm', '+6948 8542 623', '1615490820_banner.jpg', '&lt;h3 style=&quot;font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; line-height: 1.3em; color: rgb(86, 86, 86); margin-bottom: 10px; font-size: 24px; text-align: center;&quot;&gt;Plan journey, Reserve bus seats, Reach destination.&lt;/h3&gt;&lt;p style=&quot;margin-bottom: 10px; color: rgb(72, 72, 72); font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; font-size: 16px; text-align: center;&quot;&gt;We provide a full-fledged online bus booking platform to buy and sell bus seats. The passenger can purchase bus tickets online and in return to confirm the seat reservation, a text message with the details of travel will be sent.&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;/p&gt;&lt;p style=&quot;margin-bottom: 10px; color: rgb(72, 72, 72); font-family: &amp;quot;Nunito Sans&amp;quot;, sans-serif; font-size: 16px; text-align: center;&quot;&gt;With the efficient bus reservation system from BusSeat.lk, plan your journey early, save your valuable time in buying bus tickets, avoid waiting in long queues, find your boarding place easily, and enjoy your happy journey with comfort.&lt;/p&gt;&lt;p style=&quot;text-align: center; background: transparent; position: relative;&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;&lt;/p&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `contact` text NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=admin , 2 = staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `address`, `contact`, `username`, `password`, `type`) VALUES
(1, 'Administrator', '', '', 'admin', 'admin123', 1),
(7, 'Pasindu', 'Sample Only', '+18456-5455-55', 'pasindu@yahoo.com', '12345', 1),
(10, 'Isuru', 'Sample Only', '+5465 555 623', 'isuru@yahoo.com', '12345', 1),
(15, 'Damith', 'Sample Address', '+1235 456 623', 'sample2@sample.com', 'sample123', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booked_ticket`
--
ALTER TABLE `booked_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_list`
--
ALTER TABLE `bus_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_sch_list`
--
ALTER TABLE `bus_sch_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bus_station_list`
--
ALTER TABLE `bus_station_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booked_ticket`
--
ALTER TABLE `booked_ticket`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bus_list`
--
ALTER TABLE `bus_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bus_sch_list`
--
ALTER TABLE `bus_sch_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `bus_station_list`
--
ALTER TABLE `bus_station_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
