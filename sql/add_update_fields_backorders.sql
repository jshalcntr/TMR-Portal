-- Add updated_by column to backorders_tbl
ALTER TABLE `backorders_tbl`
ADD COLUMN `updated_by` int(11) DEFAULT NULL;