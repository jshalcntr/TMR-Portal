-- Add ETA confirmation fields to backorders_tbl
-- This script adds fields to track whether ETA_2 and ETA_3 have been confirmed by users

ALTER TABLE `backorders_tbl` 
ADD COLUMN `eta_2_confirmed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Whether ETA_2 has been confirmed by user' AFTER `eta_2`,
ADD COLUMN `eta_3_confirmed` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Whether ETA_3 has been confirmed by user' AFTER `eta_3`;

-- Add indexes for better performance
CREATE INDEX `idx_eta_2_confirmed` ON `backorders_tbl` (`eta_2_confirmed`);
CREATE INDEX `idx_eta_3_confirmed` ON `backorders_tbl` (`eta_3_confirmed`);

-- Update existing records to set confirmation status based on current ETA values
-- If ETA_2 exists and is not null, mark it as confirmed (assuming it was manually set)
UPDATE `backorders_tbl` 
SET `eta_2_confirmed` = 1 
WHERE `eta_2` IS NOT NULL AND `eta_2` != '';

-- If ETA_3 exists and is not null, mark it as confirmed (assuming it was manually set)
UPDATE `backorders_tbl` 
SET `eta_3_confirmed` = 1 
WHERE `eta_3` IS NOT NULL AND `eta_3` != '';
