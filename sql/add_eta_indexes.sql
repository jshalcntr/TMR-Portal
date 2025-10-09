-- Add indexes for ETA fields and related columns for better performance
ALTER TABLE `backorders_tbl`
ADD INDEX `idx_eta_dates` (`eta_1`, `eta_2`, `eta_3`),
ADD INDEX `idx_eta_confirmations` (`eta_2_confirmed`, `eta_3_confirmed`),
ADD INDEX `idx_order_status` (`order_status`),
ADD INDEX `idx_is_deleted` (`is_deleted`);

-- Add last_updated column if it doesn't exist
ALTER TABLE `backorders_tbl`
ADD COLUMN IF NOT EXISTS `last_updated` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD INDEX `idx_last_updated` (`last_updated`);