-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2024 at 02:32 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mists_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts_tbl`
--

CREATE TABLE `accounts_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `role` enum('USER','HEAD','ADMIN','S-ADMIN') NOT NULL,
  `profile_picture` varchar(300) NOT NULL,
  `department` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_tbl`
--

INSERT INTO `accounts_tbl` (`id`, `username`, `password`, `full_name`, `role`, `profile_picture`, `department`) VALUES
(1, 'test1', '$2y$10$fkNgLwyDFGe/ymT2I5/IJ.sIQsUTqocx98mSmAXUT.9vV/0ZlhOpC', 'User Account', 'USER', '', 'VSD'),
(2, 'test2', '$2y$10$u6T9NJ2ctnFDIDB2D2lmFuXXW/AUhWpMzvKL/fkKp.0seMA4PJaZa', 'JRQ', 'HEAD', '', 'VSD'),
(3, 'user1', '$2y$10$Jye.ZFPXfA1RTBOG6w4EKu1r28WOvf6GHvj3zmkNqy6.a0.p1oi/.', 'User1 Name1', 'USER', '', 'HR'),
(4, 'head', '$2y$10$DP.O4eN/aRuxCzYKL81EuuJeHN3q8CMhur6vePIoFzOvK0Kkhqa9G', 'head name', 'HEAD', '', 'HR'),
(5, 'admin', '$2y$10$YQsTBuaLxNZffUAJlbg2VexHnwxK.PVW3.axJxa0j6Da3jFMQdHRC', 'Admin Account', 'ADMIN', '', 'MIS'),
(6, 'user2', '$2y$10$EXC8mgybrgwSms8mJEasnObG8ZymFtqcK/7Q/zxP1jRl7wyumyJfm', 'USER 2', 'USER', '', 'HR');

-- --------------------------------------------------------

--
-- Table structure for table `authorizations_tbl`
--

CREATE TABLE `authorizations_tbl` (
  `account_id` int(11) NOT NULL,
  `inventory_view_auth` tinyint(1) NOT NULL,
  `inventory_edit_auth` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorizations_tbl`
--

INSERT INTO `authorizations_tbl` (`account_id`, `inventory_view_auth`, `inventory_edit_auth`) VALUES
(3, 0, 0),
(5, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_records_tbl`
--

CREATE TABLE `inventory_records_tbl` (
  `id` int(11) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `date_acquired` date DEFAULT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `fa_number` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory_records_tbl`
--

INSERT INTO `inventory_records_tbl` (`id`, `item_type`, `item_name`, `brand`, `model`, `date_acquired`, `supplier`, `serial_number`, `remarks`, `user`, `department`, `status`, `price`, `fa_number`) VALUES
(1, 'Desktop', 'PC', 'New Brand', 'New Model', '2024-10-26', 'Vetco', '1234567890', 'Test Remarks', 'Kian', 'Management Information System Department', 'Active', 25000.00, 'TMRMIS24-0001'),
(2, 'Printer', 'Brother', 'Brother', 'HL-L3270', '2024-06-12', 'Supplier H', 'SN12354', 'Finance printer', 'Patricia Davis', 'Finance', 'Active', 300.00, NULL),
(3, 'Tools', 'Stanley Hammer', 'Stanley', '51-163', '2024-05-22', 'Supplier AA', 'SN12373', 'New hammer for IT department', 'Gina Wilson', 'IT', 'Active', 30.00, NULL),
(4, 'Printer', 'Canon Pixma', 'Canon', 'G7020', '2024-05-11', 'Supplier A', 'SN12349', 'Printer undergoing repair', 'Mike Adams', 'IT', 'Under Repair', 350.00, NULL),
(5, 'Desktop', 'Apple iMac', 'Apple', 'M1 24-inch', '2024-05-06', 'Supplier U', 'SN12367', 'iMac for IT department', 'Tina Nelson', 'IT', 'Active', 2500.00, NULL),
(6, 'Desktop', 'Lenovo ', 'Lenovo', 'M720q', '2024-04-25', 'Supplier G', 'SN12353', 'Desktop for HR', 'James Clark', 'HR', 'Active', 670.00, NULL),
(7, 'Desktop', 'HP Envy', 'HP', 'TE01', '2024-04-18', 'Supplier BB', 'SN12374', 'Desktop for HR team', 'Nathan Roberts', 'HR', 'Active', 1100.00, NULL),
(8, 'Laptop', 'Asus ZenBook', 'Asus', 'UX425', '2024-04-10', 'Supplier S', 'SN12365', 'ZenBook for Sales department', 'Megan Wright', 'Sales', 'Active', 1400.00, NULL),
(9, 'Tools', 'Fluke Multimeter', 'Fluke', '87V', '2024-03-30', 'Supplier R', 'SN12364', 'Multimeter needs repair', 'Ray Peterson', 'Finance', 'Under Repair', 150.00, NULL),
(10, 'Tools', 'Dell Docking Station', 'Dell', 'WD19', '2024-03-15', 'Supplier I', 'SN12355', 'Docking station for laptops', 'David Miller', 'IT', 'Active', 200.00, NULL),
(11, 'Laptop', 'Dell XPS 13', 'Dell', 'XPS9380', '2024-03-10', 'Supplier B', 'SN12346', 'Laptop for Finance Team', 'Jane Smith', 'Finance', 'Active', 1200.00, NULL),
(12, 'Laptop', 'HP Pavilion', 'HP', '15t-dy200', '2024-03-02', 'Supplier Y', 'SN12371', 'Laptop for sales activities', 'Olivia Scott', 'Sales', 'Active', 950.00, NULL),
(13, 'Desktop', 'Dell OptiPlex', 'Dell', '3080', '2024-02-22', 'Supplier N', 'SN12360', 'Desktop for finance team', 'Matt Parker', 'Finance', 'Active', 850.00, NULL),
(14, 'Laptop', 'MacBook Pro', 'Apple', 'M1 Pro', '2024-02-18', 'Supplier B', 'SN12350', 'Laptop issued for Sales head', 'Lisa Brown', 'Sales', 'Active', 2200.00, NULL),
(15, 'Laptop', 'Lenovo ThinkPad', 'Lenovo', 'X1 Carbon', '2024-02-05', 'Supplier J', 'SN12356', 'Laptop for sales team member', 'Diana Evans', 'Sales', 'Active', 1600.00, NULL),
(16, 'Accessories', 'Sony Webcam', 'Sony', 'WC100', '2024-02-01', 'Supplier W', 'SN12369', 'Webcam for remote meetings', 'Eli Hall', 'HR', 'Active', 120.00, NULL),
(17, 'Printer', 'HP LaserJet Pro', 'HP', 'M404dn', '2024-01-15', 'Supplier A', 'SN12345', 'Printer in working condition', 'John Doe', 'IT', 'Active', 400.00, NULL),
(18, 'Laptop', 'HP EliteBook', 'HP', '840 G8', '2024-01-13', 'Supplier O', 'SN12361', 'HR department laptop', 'Ann Taylor', 'HR', 'Active', 1800.00, NULL),
(19, 'Tools', 'Bosch Drill', 'Bosch', 'GSR120-LI', '2023-12-29', 'Supplier M', 'SN12359', 'Drill for IT department', 'Cathy Spencer', 'IT', 'Active', 80.00, NULL),
(20, 'Laptop', 'Microsoft Surface Pro', 'Microsoft', 'Pro 8', '2023-12-14', 'Supplier V', 'SN12368', 'Surface Pro for finance team', 'Kevin Jones', 'Finance', 'Active', 1700.00, NULL),
(21, 'Accessories', 'Samsung Monitor', 'Samsung', 'U28R55', '2023-12-01', 'Supplier F', 'SN12352', 'New monitor for finance team', 'Angela', 'Finance', 'Active', 280.00, NULL),
(22, 'Printer', 'Ricoh SP C360DNw', 'Ricoh', 'SP C360', '2023-11-25', 'Supplier X', 'SN12370', 'Retired printer', 'Cindy Adams', 'IT', 'Retired', 380.00, NULL),
(23, 'Accessories', 'Logitech Headset', 'Logitech', 'H390', '2023-11-19', 'Supplier P', 'SN12362', 'Sales headset', 'Jack Morrison', 'Sales', 'Active', 50.00, NULL),
(24, 'Accessories', 'Logitech Mouse', 'Logitech', 'M325', '2023-11-05', 'Supplier C', 'SN12347', 'Mouse replacement for HR', 'Mark Spencer', 'HR', 'Active', 25.00, NULL),
(25, 'Printer', 'Epson EcoTank', 'Epson', 'ET-4760', '2023-10-28', 'Supplier K', 'SN12357', 'Printer in HR department', 'Tom Green', 'HR', 'Active', 500.00, NULL),
(26, 'Printer', 'Printer', 'Printer', 'Printer', '2023-10-10', 'Printer', 'Printer', 'Printer', 'Printer', 'Printer', 'ACTIVE', 10000.00, 'TMRMIS23-0001'),
(27, 'Desktop', 'HP Desktop', 'HP', 'ProDesk 600', '2023-09-20', 'Supplier D', 'SN12348', 'Desktop for Sales Team', 'Sara Connor', 'Sales', 'Active', 750.00, NULL),
(28, 'Printer', 'Kyocera M5526cdn', 'Kyocera', 'M5526', '2023-09-14', 'Supplier Q', 'SN12363', 'Kyocera printer for IT', 'Alice Howard', 'IT', 'Active', 450.00, NULL),
(29, 'Accessories', 'HP Keyboard', 'HP', 'K600', '2023-08-17', 'Supplier L', 'SN12358', 'New keyboard for IT department', 'Jerry Brooks', 'IT', 'Active', 35.00, NULL),
(30, 'Accessories', 'Dell Monitor', 'Dell', 'P2419H', '2023-08-08', 'Supplier Z', 'SN12372', 'New finance monitor', 'Fred Warren', 'Finance', 'Active', 220.00, NULL),
(31, 'Tools', 'Screwdriver Set', 'Bosch', 'BS234', '2023-07-15', 'Supplier E', 'SN12351', 'Retired tool set', 'David Lee', 'IT', 'Retired', 40.00, NULL),
(32, 'Accessories', 'Acer Monitor', 'Acer', 'CB282K', '2023-07-03', 'Supplier T', 'SN12366', 'New monitor for HR', 'Nina Hill', 'HR', 'Active', 350.00, NULL),
(33, 'Tools', 'Crimping Tool', 'Stanley', '09916651566', '2022-07-19', 'Tindahan', '09352318692', 'Wow pogi ng may ari', 'Kian', 'Management Information System Department', '0', 1000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ticket_records_tbl`
--

CREATE TABLE `ticket_records_tbl` (
  `ticket_id` int(11) NOT NULL,
  `ticket_requestor_id` int(11) NOT NULL,
  `ticket_subject` varchar(50) NOT NULL,
  `ticket_type` varchar(50) NOT NULL,
  `ticket_description` text NOT NULL,
  `ticket_handler_id` int(11) DEFAULT NULL,
  `ticket_conclusion` text NOT NULL,
  `ticket_status` enum('PENDING','ON GOING','FOR APPROVAL','PRIORITY','REJECTED','APPROVED','FINISHED') NOT NULL,
  `date_created` datetime NOT NULL,
  `date_accepted` datetime DEFAULT NULL,
  `date_finished` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_records_tbl`
--

INSERT INTO `ticket_records_tbl` (`ticket_id`, `ticket_requestor_id`, `ticket_subject`, `ticket_type`, `ticket_description`, `ticket_handler_id`, `ticket_conclusion`, `ticket_status`, `date_created`, `date_accepted`, `date_finished`) VALUES
(124, 3, 'GTIOA', 'SOFTWARE', 'a', 5, 'D ko din alam\n', 'PENDING', '2024-09-10 08:19:18', NULL, NULL),
(126, 3, 'PARTNERS2', 'SOFTWARE', 'a', 5, '', 'PENDING', '2024-09-10 08:20:18', NULL, NULL),
(127, 3, 'Printer - Paper Jam', 'HARDWARE', 'a', 5, '', 'PENDING', '2024-09-10 08:21:11', NULL, NULL),
(128, 3, 'Printer - Paper Jam', 'HARDWARE', 'a', 5, '', 'PENDING', '2024-09-10 08:29:16', NULL, NULL),
(129, 1, 'Printer - No Ink', 'HARDWARE', 'Ubos na ink', 5, '', 'PENDING', '2024-09-10 08:29:49', NULL, NULL),
(130, 3, 'Monitor - Blured', 'HARDWARE', 'Ah', 5, '3', 'PENDING', '2024-09-10 08:38:25', NULL, NULL),
(131, 3, 'Printer - Not able to Print', 'HARDWARE', 'Ayaw magprint idol', 5, '', 'PENDING', '2024-09-10 08:44:42', NULL, NULL),
(132, 6, 'Internet/Wifi - Slow', 'HARDWARE', 'Bagal ng wifi ko', 5, '', 'PENDING', '2024-09-13 05:40:04', NULL, NULL),
(133, 3, 'BIT - Remove pending processes', 'SOFTWARE', 'f[awfawf', 5, '', 'PENDING', '2024-09-13 06:08:50', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts_tbl`
--
ALTER TABLE `accounts_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `authorizations_tbl`
--
ALTER TABLE `authorizations_tbl`
  ADD UNIQUE KEY `account_id` (`account_id`),
  ADD KEY `accounts_FK` (`account_id`);

--
-- Indexes for table `inventory_records_tbl`
--
ALTER TABLE `inventory_records_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_records_tbl`
--
ALTER TABLE `ticket_records_tbl`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket_requestor_id` (`ticket_requestor_id`),
  ADD KEY `ticket_handler` (`ticket_handler_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts_tbl`
--
ALTER TABLE `accounts_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventory_records_tbl`
--
ALTER TABLE `inventory_records_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ticket_records_tbl`
--
ALTER TABLE `ticket_records_tbl`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authorizations_tbl`
--
ALTER TABLE `authorizations_tbl`
  ADD CONSTRAINT `authorizations_tbl_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_records_tbl`
--
ALTER TABLE `ticket_records_tbl`
  ADD CONSTRAINT `ticket_records_tbl_ibfk_1` FOREIGN KEY (`ticket_requestor_id`) REFERENCES `accounts_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ticket_records_tbl_ibfk_2` FOREIGN KEY (`ticket_handler_id`) REFERENCES `accounts_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
