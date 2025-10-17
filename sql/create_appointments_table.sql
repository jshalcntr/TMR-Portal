-- Create backorders appointment table
CREATE TABLE IF NOT EXISTS `backorders_appointment_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `backorder_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('Scheduled','Completed','Cancelled','Rescheduled') NOT NULL DEFAULT 'Scheduled',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_backorder_id` (`backorder_id`),
  KEY `idx_appointment_date` (`appointment_date`),
  KEY `idx_status` (`status`),
  KEY `idx_created_by` (`created_by`),
  CONSTRAINT `fk_backorder_appointment` FOREIGN KEY (`backorder_id`) REFERENCES `backorders_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;