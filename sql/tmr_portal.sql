-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2025 at 02:57 AM
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
-- Database: `tmr_portal`
--
CREATE DATABASE IF NOT EXISTS `tmr_portal` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tmr_portal`;

-- --------------------------------------------------------

--
-- Table structure for table `accounts_tbl`
--

CREATE TABLE `accounts_tbl` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `role` enum('USER','HEAD','ADMIN','S-ADMIN') NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'no-link',
  `department` varchar(255) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts_tbl`
--

INSERT INTO `accounts_tbl` (`id`, `username`, `password`, `full_name`, `role`, `profile_picture`, `department`, `status`) VALUES
(1, 'superadmin', '$2y$10$gvvEzYYA3NQjXWwl2HUeduC8Ak2x06DKTomMxCM7gNDzy9xFrp0pO', 'Super Admin', 'S-ADMIN', 'no-link', 'MIS', 'Active'),
(2, 'redel.santiago', '$2y$10$nsfWQU6uMhyv1QSd313f7e8/GAdHiZvRulbOh4xWU6QBLptWqdTyO', 'Redel Santiago', 'ADMIN', 'no-link', 'MIS', 'Active'),
(3, 'josh.alcantara', '$2y$10$315ZkScimh.NAE81Fz9USO8bagYsfQW4c/fX5FW4WeVVeyST0Tm9q', 'Joshua Alcantara', 'ADMIN', 'no-link', 'MIS', 'Active'),
(4, 'user', '$2y$10$2vOTNfrAOXNRlLJzzki5..jXI.EvCjsVc2YpqSc7kdMDBkcrnaWR.', 'TMR Staff', 'USER', 'no-link', 'Service', 'Active'),
(5, 'head', '$2y$10$DPkqJwjAu0mv4nPF0C75cespAMbs0YifsQRXPgTO.BH3BxFGIjpxK', 'TMR Head', 'HEAD', 'no-link', 'Service', 'Active'),
(6, 'admin', '$2y$10$pgbgu/ubDwujPoneqFmDaO9WOEKZ6X0P1Smv0RAhsffSqZmI.Re46', 'Admin Account', 'ADMIN', 'no-link', 'MIS', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `authorizations_tbl`
--

CREATE TABLE `authorizations_tbl` (
  `account_id` int(11) NOT NULL,
  `inventory_view_auth` tinyint(1) NOT NULL DEFAULT 0,
  `inventory_edit_auth` tinyint(1) NOT NULL DEFAULT 0,
  `accounts_view_auth` tinyint(1) NOT NULL DEFAULT 0,
  `accounts_edit_auth` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authorizations_tbl`
--

INSERT INTO `authorizations_tbl` (`account_id`, `inventory_view_auth`, `inventory_edit_auth`, `accounts_view_auth`, `accounts_edit_auth`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 1, 1, 0),
(3, 0, 1, 1, 0),
(4, 0, 0, 0, 0),
(5, 0, 0, 0, 0),
(6, 1, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inventory_disposal_tbl`
--

CREATE TABLE `inventory_disposal_tbl` (
  `disposal_id` int(11) NOT NULL,
  `inventory_id` int(11) NOT NULL,
  `date_added` date NOT NULL,
  `date_disposed` date DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `isDisposed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_disposed_items_tbl`
--

CREATE TABLE `inventory_disposed_items_tbl` (
  `inventory_id` int(11) NOT NULL,
  `disposed_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_disposed_tbl`
--

CREATE TABLE `inventory_disposed_tbl` (
  `disposed_id` int(11) NOT NULL,
  `disposed_date` date NOT NULL,
  `scanned_form_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_records_tbl`
--

CREATE TABLE `inventory_records_tbl` (
  `id` int(11) NOT NULL,
  `item_type` varchar(255) NOT NULL,
  `item_category` varchar(255) NOT NULL,
  `item_specification` varchar(255) DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `date_acquired` date NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `serial_number` varchar(255) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `computer_name` varchar(255) DEFAULT NULL,
  `department` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `price` double NOT NULL,
  `fa_number` varchar(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_repairs_tbl`
--

CREATE TABLE `inventory_repairs_tbl` (
  `repair_id` int(11) NOT NULL,
  `repaired_item` int(11) NOT NULL,
  `repair_description` text NOT NULL,
  `gatepass_number` varchar(255) NOT NULL,
  `remarks` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_requests_tbl`
--

CREATE TABLE `inventory_requests_tbl` (
  `request_id` int(11) NOT NULL,
  `requestor_id` int(11) NOT NULL,
  `request_name` varchar(255) NOT NULL,
  `requested_asset_id` int(11) NOT NULL,
  `request_reason` text NOT NULL,
  `request_sql` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `ticket_status` enum('OPEN','PENDING','ON GOING','FOR APPROVAL','PRIORITY','REJECTED','APPROVED','FINISHED','CLOSED','CANCELLED','REOPEN') NOT NULL,
  `date_created` datetime NOT NULL,
  `date_accepted` datetime DEFAULT NULL,
  `date_finished` datetime DEFAULT NULL,
  `ticket_due_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `inventory_disposal_tbl`
--
ALTER TABLE `inventory_disposal_tbl`
  ADD PRIMARY KEY (`disposal_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `inventory_disposed_items_tbl`
--
ALTER TABLE `inventory_disposed_items_tbl`
  ADD KEY `disposed_id` (`disposed_id`),
  ADD KEY `inventory_id` (`inventory_id`);

--
-- Indexes for table `inventory_disposed_tbl`
--
ALTER TABLE `inventory_disposed_tbl`
  ADD PRIMARY KEY (`disposed_id`);

--
-- Indexes for table `inventory_records_tbl`
--
ALTER TABLE `inventory_records_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_repairs_tbl`
--
ALTER TABLE `inventory_repairs_tbl`
  ADD PRIMARY KEY (`repair_id`),
  ADD KEY `repaired_item` (`repaired_item`);

--
-- Indexes for table `inventory_requests_tbl`
--
ALTER TABLE `inventory_requests_tbl`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `requestor_id` (`requestor_id`),
  ADD KEY `requested_asset_id` (`requested_asset_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inventory_disposal_tbl`
--
ALTER TABLE `inventory_disposal_tbl`
  MODIFY `disposal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_disposed_tbl`
--
ALTER TABLE `inventory_disposed_tbl`
  MODIFY `disposed_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_records_tbl`
--
ALTER TABLE `inventory_records_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_repairs_tbl`
--
ALTER TABLE `inventory_repairs_tbl`
  MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_requests_tbl`
--
ALTER TABLE `inventory_requests_tbl`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_records_tbl`
--
ALTER TABLE `ticket_records_tbl`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authorizations_tbl`
--
ALTER TABLE `authorizations_tbl`
  ADD CONSTRAINT `fk_authorizations_accounts` FOREIGN KEY (`account_id`) REFERENCES `accounts_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_disposal_tbl`
--
ALTER TABLE `inventory_disposal_tbl`
  ADD CONSTRAINT `fk_disposal_records` FOREIGN KEY (`inventory_id`) REFERENCES `inventory_records_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_disposed_items_tbl`
--
ALTER TABLE `inventory_disposed_items_tbl`
  ADD CONSTRAINT `fk_disposed_disposal` FOREIGN KEY (`disposed_id`) REFERENCES `inventory_disposed_tbl` (`disposed_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_disposed_records` FOREIGN KEY (`inventory_id`) REFERENCES `inventory_records_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_repairs_tbl`
--
ALTER TABLE `inventory_repairs_tbl`
  ADD CONSTRAINT `fk_repair_record` FOREIGN KEY (`repaired_item`) REFERENCES `inventory_records_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventory_requests_tbl`
--
ALTER TABLE `inventory_requests_tbl`
  ADD CONSTRAINT `fk_requests_accounts` FOREIGN KEY (`requestor_id`) REFERENCES `accounts_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_requests_records` FOREIGN KEY (`requested_asset_id`) REFERENCES `inventory_records_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
