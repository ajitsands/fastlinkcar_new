-- ============================================================================
-- FastLink Car Rental: Migration from fastlinkpayment_rental_car_db_old.sql
-- ============================================================================

CREATE TABLE IF NOT EXISTS `tbl_customer_accounts` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(150) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `company_id` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_print_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '1',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'FAST LINK',
  `company_name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `header_subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Car Rental & Fleet Solutions',
  `header_address` text COLLATE utf8mb4_unicode_ci,
  `header_phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `header_email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `header_website` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `header_logo` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assets/img/logo_new/fastlinklogoblue.png',
  `show_logo` tinyint(1) NOT NULL DEFAULT '1',
  `logo_width` int(11) NOT NULL DEFAULT '150',
  `footer_text` text COLLATE utf8mb4_unicode_ci,
  `footer_text_ar` text COLLATE utf8mb4_unicode_ci,
  `footer_note` text COLLATE utf8mb4_unicode_ci,
  `show_footer` tinyint(1) NOT NULL DEFAULT '1',
  `accent_color` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#1b3d94',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `company_id` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_refund_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_no` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `customer_code` varchar(100) NOT NULL,
  `agreement_no` varchar(100) NOT NULL,
  `amount` decimal(18,5) NOT NULL,
  `refund_mode` varchar(50) DEFAULT 'Cash',
  `reason` text,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `tbl_vehicle_lookup_master` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_type` enum('color','body_type','engine_type','capacity_cc','transmission') NOT NULL,
  `lookup_value` varchar(120) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `uq_type_val` (`lookup_type`,`lookup_value`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `customer_details` ADD COLUMN `phone_1` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `phone_2` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `fax_no` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `website` varchar(150) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `vat_reg_no` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `nationality` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `license_no` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `license_issue_place` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `license_expiry_date` date NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `customer_account_id` int(11) NULL DEFAULT NULL;
ALTER TABLE `customer_details` ADD COLUMN `is_blacklisted` tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE `customer_details` ADD COLUMN `blacklist_description` text NULL DEFAULT NULL;
ALTER TABLE `customer_details` MODIFY COLUMN `status` enum('Active','Inactive','Blacklisted') NULL DEFAULT 'Active';
ALTER TABLE `tbl_vehicles` ADD COLUMN `daily_rent` decimal(10,3) NULL DEFAULT '0.000';
ALTER TABLE `tbl_vehicles` ADD COLUMN `weekly_rent` decimal(10,3) NULL DEFAULT '0.000';
ALTER TABLE `tbl_vehicles` ADD COLUMN `monthly_rent` decimal(10,3) NULL DEFAULT '0.000';
ALTER TABLE `tbl_vehicles` ADD COLUMN `mileage_km` int(11) NULL DEFAULT NULL;
ALTER TABLE `tbl_vehicles` ADD COLUMN `body_type` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `tbl_vehicles` ADD COLUMN `engine_type` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `tbl_vehicles` ADD COLUMN `capacity_cc` varchar(50) NULL DEFAULT NULL;
ALTER TABLE `tbl_vehicles` ADD COLUMN `transmission` varchar(100) NULL DEFAULT NULL;
ALTER TABLE `tbl_vehicles` ADD COLUMN `is_active` tinyint(1) NOT NULL DEFAULT '1';
ALTER TABLE `tbl_vehicles` MODIFY COLUMN `vehicle_status` varchar(50) NOT NULL DEFAULT 'Available';

-- Seed default lookup values & FastLink print header
INSERT IGNORE INTO tbl_vehicle_lookup_master (lookup_type, lookup_value) VALUES
('color', 'White'), ('color', 'Black'), ('color', 'Silver'), ('color', 'Grey'),
('color', 'Blue'), ('color', 'Red'), ('color', 'Pearl White'), ('color', 'Brown'), ('color', 'Gold'),
('body_type', 'NA'), ('body_type', 'Sedan'), ('body_type', 'SUV'), ('body_type', 'Hatchback'),
('body_type', 'Coupe'), ('body_type', 'Pickup'), ('body_type', 'Van'), ('body_type', 'Crossover'),
('engine_type', 'NA'), ('engine_type', 'Petrol'), ('engine_type', 'Diesel'), ('engine_type', 'Hybrid'), ('engine_type', 'Electric'),
('capacity_cc', 'NA'), ('capacity_cc', '1200 cc'), ('capacity_cc', '1500 cc'), ('capacity_cc', '1600 cc'),
('capacity_cc', '1800 cc'), ('capacity_cc', '2000 cc'), ('capacity_cc', '2500 cc'), ('capacity_cc', '3000 cc'), ('capacity_cc', '3500 cc'),
('transmission', 'NA'), ('transmission', 'Automatic'), ('transmission', 'Manual'), ('transmission', 'CVT');

INSERT INTO tbl_print_settings (company_id, company_name, header_subtitle, header_address, header_phone, show_logo, show_footer)
VALUES (
    1,
    'FASTLINK TRADING SERVICES Co W.L.L',
    'VAT Reg No.   220002364600002',
    'Flat/Shop No. 13, Building 4, Road/Street 1101, Tubli, Block 711, Capital, Bahrain',
    '17212995, 33310186, 33310187',
    1,
    1
)
ON DUPLICATE KEY UPDATE
    company_name    = VALUES(company_name),
    header_subtitle = VALUES(header_subtitle),
    header_address  = VALUES(header_address),
    header_phone    = VALUES(header_phone);
