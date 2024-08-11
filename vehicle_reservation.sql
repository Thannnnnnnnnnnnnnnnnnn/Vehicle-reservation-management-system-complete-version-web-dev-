-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Aug 11, 2024 at 01:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vehicle_reservation`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `tbl_id` int(69) NOT NULL,
  `Email` varchar(69) NOT NULL,
  `password` varchar(69) NOT NULL,
  `account_type` varchar(69) NOT NULL,
  `Contact_No` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`tbl_id`, `Email`, `password`, `account_type`, `Contact_No`, `Firstname`, `Lastname`) VALUES
(1, 'admin@gmail.com', 'admin', '1', '09270726974', 'thandwadw', 'evora'),
(2, 'user@gmail.com', 'user', '2', '09270726974', 'Than', 'Evora'),
(68, 'thanevora86@gmail.com', 'admin', '1', '+639270726974', 'than', 'evora');

-- --------------------------------------------------------

--
-- Table structure for table `table`
--

CREATE TABLE `table` (
  `Reservation_id` int(11) NOT NULL,
  `Vehicle_type` varchar(25) NOT NULL,
  `Vehicle_color` varchar(25) NOT NULL,
  `Vehicle_brand` varchar(25) NOT NULL,
  `Plate_no` varchar(25) NOT NULL,
  `Date` varchar(25) NOT NULL,
  `Time` varchar(25) NOT NULL,
  `Status` varchar(25) NOT NULL,
  `Plate_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table`
--

INSERT INTO `table` (`Reservation_id`, `Vehicle_type`, `Vehicle_color`, `Vehicle_brand`, `Plate_no`, `Date`, `Time`, `Status`, `Plate_image`) VALUES
(6761, '2 Wheel', 'black', 'toyota', 'asdwads', '2024-05-07', '5:19 AM', 'Rejected', ''),
(6763, '4 Wheel', 'pink', 'toyota', 'AAA-1234', '2024-05-06', '5:24 AM', 'Rejected', ''),
(6765, '2 Wheel', 'black', 'nissan', 'AAA-123444dd', '2024-05-07', '5:25 AM', 'Approved', ''),
(6777, '4 Wheel', 'black', 'nissan', 'AAA-12345', '2024-05-08', '11:52 AM', 'Approved', ''),
(6778, '2 Wheel', 'dwdw', 'honda', 'AAA-1234', '2024-05-08', '11:52 AM', 'Pending', ''),
(6836, '2 Wheel', 'pink', 'toyota', 'AAA-1234', '2024-05-29', '10:38 PM', 'Pending', ''),
(6838, '2 Wheel', 'black', 'toyota', '', '2024-05-29', '10:40 PM', 'Pending', 'C:\\xampp\\htdocs\\adi\\image\\plus.jpg'),
(6841, '2 Wheel', 'pink', 'hyundai', 'AAA-1234', '2024-05-29', '10:46 PM', 'Approved', ''),
(6843, '2 Wheel', 'black', 'nissan', 'AAA-1234', '2024-05-29', '10:46 PM', 'Pending', ''),
(6844, '2 Wheel', 'black', 'nissan', 'AAA-1234', '2024-05-29', '10:46 PM', 'Pending', ''),
(6855, '4 Wheel', 'yellow', 'honda', 'AAA-1234', '2024-08-11', '3:56 PM', 'Pending', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`tbl_id`);

--
-- Indexes for table `table`
--
ALTER TABLE `table`
  ADD PRIMARY KEY (`Reservation_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `tbl_id` int(69) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `table`
--
ALTER TABLE `table`
  MODIFY `Reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6856;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
