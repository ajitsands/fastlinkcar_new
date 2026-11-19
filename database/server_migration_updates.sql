-- ============================================================================
-- FastLink Car Rental - Server Migration Updates
-- Run this on an existing live database to add all new tables and columns.
-- For a fresh database install, import db_fastlink_carrental_schema.sql instead.
-- ============================================================================

-- 1. Customer Accounts Master
CREATE TABLE IF NOT EXISTS tbl_customer_accounts (
    ids INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    account_name VARCHAR(150) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    company_id INT NOT NULL DEFAULT 1,
    created_by INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Customer Details Updates (status ENUM + extra fields + blacklist + account)
ALTER TABLE customer_details
    MODIFY COLUMN status ENUM('Active','Inactive','Blacklisted') DEFAULT 'Active';

ALTER TABLE customer_details
    ADD COLUMN IF NOT EXISTS customer_account_id INT NULL AFTER customer_type,
    ADD COLUMN IF NOT EXISTS nationality VARCHAR(100) NULL AFTER customer_cr_cpr,
    ADD COLUMN IF NOT EXISTS license_no VARCHAR(100) NULL AFTER nationality,
    ADD COLUMN IF NOT EXISTS license_issue_place VARCHAR(100) NULL AFTER license_no,
    ADD COLUMN IF NOT EXISTS license_expiry_date DATE NULL AFTER license_issue_place,
    ADD COLUMN IF NOT EXISTS phone_1 VARCHAR(50) NULL AFTER customer_mobile,
    ADD COLUMN IF NOT EXISTS phone_2 VARCHAR(50) NULL AFTER phone_1,
    ADD COLUMN IF NOT EXISTS fax_no VARCHAR(50) NULL AFTER phone_2,
    ADD COLUMN IF NOT EXISTS website VARCHAR(150) NULL AFTER fax_no,
    ADD COLUMN IF NOT EXISTS vat_reg_no VARCHAR(100) NULL AFTER customer_addr,
    ADD COLUMN IF NOT EXISTS is_blacklisted TINYINT(1) NOT NULL DEFAULT 0 AFTER status,
    ADD COLUMN IF NOT EXISTS blacklist_description TEXT NULL AFTER is_blacklisted;

-- 3. Vehicle Lookup Master (Color, Body Type, Engine Type, Capacity cc, Transmission)
CREATE TABLE IF NOT EXISTS tbl_vehicle_lookup_master (
    ids INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    lookup_type ENUM('color','body_type','engine_type','capacity_cc','transmission') NOT NULL,
    lookup_value VARCHAR(120) NOT NULL,
    status ENUM('Active','Inactive') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_type_val (lookup_type, lookup_value)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO tbl_vehicle_lookup_master (lookup_type, lookup_value) VALUES
('color', 'White'), ('color', 'Black'), ('color', 'Silver'), ('color', 'Grey'),
('color', 'Blue'), ('color', 'Red'), ('color', 'Pearl White'), ('color', 'Brown'), ('color', 'Gold'),
('body_type', 'NA'), ('body_type', 'Sedan'), ('body_type', 'SUV'), ('body_type', 'Hatchback'),
('body_type', 'Coupe'), ('body_type', 'Pickup'), ('body_type', 'Van'), ('body_type', 'Crossover'),
('engine_type', 'NA'), ('engine_type', 'Petrol'), ('engine_type', 'Diesel'), ('engine_type', 'Hybrid'), ('engine_type', 'Electric'),
('capacity_cc', 'NA'), ('capacity_cc', '1200 cc'), ('capacity_cc', '1500 cc'), ('capacity_cc', '1600 cc'),
('capacity_cc', '1800 cc'), ('capacity_cc', '2000 cc'), ('capacity_cc', '2500 cc'), ('capacity_cc', '3000 cc'), ('capacity_cc', '3500 cc'),
('transmission', 'NA'), ('transmission', 'Automatic'), ('transmission', 'Manual'), ('transmission', 'CVT');

-- 4. Vehicles Table Updates
ALTER TABLE tbl_vehicles
    MODIFY COLUMN vehicle_status VARCHAR(50) NOT NULL DEFAULT 'Available';

ALTER TABLE tbl_vehicles
    ADD COLUMN IF NOT EXISTS is_active TINYINT(1) NOT NULL DEFAULT 1 AFTER vehicle_status,
    ADD COLUMN IF NOT EXISTS daily_rent DECIMAL(10,3) NULL DEFAULT 0.000 AFTER vehicle_color,
    ADD COLUMN IF NOT EXISTS weekly_rent DECIMAL(10,3) NULL DEFAULT 0.000 AFTER daily_rent,
    ADD COLUMN IF NOT EXISTS monthly_rent DECIMAL(10,3) NULL DEFAULT 0.000 AFTER weekly_rent,
    ADD COLUMN IF NOT EXISTS mileage_km INT NULL AFTER monthly_rent,
    ADD COLUMN IF NOT EXISTS body_type VARCHAR(100) NULL AFTER mileage_km,
    ADD COLUMN IF NOT EXISTS engine_type VARCHAR(100) NULL AFTER body_type,
    ADD COLUMN IF NOT EXISTS capacity_cc VARCHAR(50) NULL AFTER engine_type,
    ADD COLUMN IF NOT EXISTS transmission VARCHAR(100) NULL AFTER capacity_cc;

-- 5. Print Format Master Table & Default FastLink Header
CREATE TABLE IF NOT EXISTS tbl_print_settings (
    ids INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL DEFAULT 1,
    company_name VARCHAR(255) NOT NULL DEFAULT 'FAST LINK',
    company_name_ar VARCHAR(255) NULL,
    header_subtitle VARCHAR(255) NULL,
    header_address TEXT NULL,
    header_phone VARCHAR(255) NULL,
    header_email VARCHAR(255) NULL,
    header_website VARCHAR(255) NULL,
    header_logo VARCHAR(255) NULL,
    show_logo TINYINT(1) NOT NULL DEFAULT 1,
    logo_width INT NOT NULL DEFAULT 150,
    footer_text TEXT NULL,
    footer_text_ar TEXT NULL,
    footer_note TEXT NULL,
    show_footer TINYINT(1) NOT NULL DEFAULT 1,
    accent_color VARCHAR(20) NOT NULL DEFAULT '#1b3d94',
    updated_by INT NULL,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_company_print (company_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- 6. Customer Ledger trans_type length & Rentout Contracts violations_json
ALTER TABLE tbl_customer_ledger
    MODIFY COLUMN trans_type VARCHAR(100) NOT NULL;

ALTER TABLE tbl_vehicle_rentout_contracts
    ADD COLUMN IF NOT EXISTS violations_json LONGTEXT NULL;
