-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2026 at 07:31 PM
-- Server version: 10.11.18-MariaDB
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fastlinkpayment_rental_car_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`fastlinkpayment`@`localhost` PROCEDURE `generate_quotation_no` (IN `p_save_type` VARCHAR(10), IN `p_company_id` INT, IN `p_user_prefix` VARCHAR(100), IN `v_user_id` INT, OUT `p_quotation_no` VARCHAR(30), OUT `p_draft_flag` VARCHAR(5))   BEGIN
    DECLARE v_prefix VARCHAR(20);
    DECLARE v_company_code VARCHAR(20);
    DECLARE v_year VARCHAR(4);
    DECLARE v_next INT DEFAULT 0;
    SET v_year = DATE_FORMAT(NOW(), '%Y');
    START TRANSACTION;
    SELECT company_code INTO v_company_code FROM tbl_company
    WHERE ids = p_company_id ;
    SELECT current_number INTO v_next
    FROM document_sequences
    WHERE company_id = p_company_id and doc_type=p_save_type and doc_year=v_year
    FOR UPDATE;
    IF v_next IS NULL OR v_next = 0 THEN
        SET v_next = 1;
        INSERT INTO document_sequences(doc_type,doc_year,current_number,company_id,user_id)
        VALUES (p_save_type, v_year,v_next,p_company_id,v_user_id);
    ELSE
        SET v_next = v_next + 1;
        UPDATE document_sequences
        SET current_number = v_next,user_id= v_user_id
        WHERE company_id = p_company_id and doc_type=p_save_type and doc_year=v_year;
    END IF;
    COMMIT;
IF p_save_type = 'QD' THEN
        SET p_quotation_no = CONCAT(
            'QD/', v_company_code, '/', v_year, '/', p_user_prefix, '/', LPAD(v_next,4,'0')
        );
        SET p_draft_flag = 'Yes';
    ELSE
        SET p_quotation_no = CONCAT(
            v_company_code, '/', v_year, '/', p_user_prefix, '/', LPAD(v_next,4,'0')
        );
        SET p_draft_flag = 'No';
    END IF;
END$$

CREATE DEFINER=`fastlinkpayment`@`localhost` PROCEDURE `sp_log_vehicle_movement` (IN `p_vehicle_id` INT, IN `p_action_type` VARCHAR(50), IN `p_old_status` VARCHAR(50), IN `p_new_status` VARCHAR(50), IN `p_reference_type` VARCHAR(50), IN `p_reference_id` INT, IN `p_reference_no` VARCHAR(100), IN `p_location_from` VARCHAR(100), IN `p_location_to` VARCHAR(100), IN `p_staff_id` INT, IN `p_customer_id` VARCHAR(100), IN `p_garage_id` INT, IN `p_odometer` INT, IN `p_fuel_level` VARCHAR(30), IN `p_remarks` TEXT, IN `p_created_by` INT, IN `p_created_name` VARCHAR(100))   BEGIN

    DECLARE v_vehicle_no VARCHAR(50);

    /* Get Vehicle Number */
    SELECT vehicle_number
    INTO v_vehicle_no
    FROM tbl_vehicles
    WHERE ids = p_vehicle_id
    LIMIT 1;

    /* If vehicle doesn't exist, exit */
    IF v_vehicle_no IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Vehicle not found.';
    END IF;

    /* Insert Vehicle Log */
    INSERT INTO tbl_vehicle_log_movement
    (
        vehicle_ids,
        vehicle_no,
        log_datetime,
        action_type,
        old_status,
        new_status,
        reference_type,
        reference_id,
        reference_no,
        location_from,
        location_to,
        staff_id,
        customer_id,
        garage_id,
        odometer,
        fuel_level,
        remarks,
        created_by,
        created_name
    )
    VALUES
    (
        p_vehicle_id,
        v_vehicle_no,
        NOW(),
        p_action_type,
        p_old_status,
        p_new_status,
        p_reference_type,
        p_reference_id,
        p_reference_no,
        p_location_from,
        p_location_to,
        p_staff_id,
        p_customer_id,
        p_garage_id,
        p_odometer,
        p_fuel_level,
        p_remarks,
        p_created_by,
        p_created_name
    );

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booking_info`
--

CREATE TABLE `booking_info` (
  `ids` int(11) NOT NULL,
  `booking_id` varchar(20) DEFAULT NULL,
  `reg_number` varchar(50) DEFAULT NULL,
  `car_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(150) DEFAULT NULL,
  `customer_id` varchar(50) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `rent_start_date` date DEFAULT NULL,
  `rent_end_date` date DEFAULT NULL,
  `total_days_taken` int(11) DEFAULT NULL,
  `rent_per_day` decimal(10,2) DEFAULT NULL,
  `rent_total_cost` decimal(10,3) DEFAULT NULL,
  `rent_discount_if_any` decimal(10,2) DEFAULT NULL,
  `rent_after_discount` decimal(10,3) DEFAULT NULL,
  `rent_tax_any` decimal(10,2) DEFAULT NULL,
  `rent_grand_total` decimal(10,3) DEFAULT NULL,
  `vehicles_image` varchar(1500) DEFAULT NULL,
  `jack_and_tools` tinyint(1) DEFAULT NULL,
  `spare_tyre` tinyint(1) DEFAULT NULL,
  `radio_yes_no` tinyint(1) DEFAULT NULL,
  `cd_recorder` tinyint(1) DEFAULT NULL,
  `drivers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `clients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Triggers `booking_info`
--
DELIMITER $$
CREATE TRIGGER `trg_booking_id` BEFORE INSERT ON `booking_info` FOR EACH ROW BEGIN

    SET NEW.booking_id = CONCAT(

        'B',

        LPAD(

            IFNULL(

                (SELECT AUTO_INCREMENT

                 FROM information_schema.TABLES

                 WHERE TABLE_SCHEMA = DATABASE()

                   AND TABLE_NAME = 'booking_info'

                ),

                1

            ),

            4,

            '0'

        )

    );

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cashmemo`
--

CREATE TABLE `cashmemo` (
  `id` int(11) NOT NULL,
  `cashmemo_no` varchar(100) DEFAULT NULL,
  `cashmemo_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_no` varchar(200) DEFAULT NULL,
  `model_ids` int(11) DEFAULT NULL,
  `model_names` varchar(500) DEFAULT NULL,
  `vehicle_color` varchar(200) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `cashmemo_notes` text DEFAULT NULL,
  `cashmemo_payment_type` varchar(200) DEFAULT NULL,
  `cashmemo_cheque_date` date DEFAULT NULL,
  `cashmemo_cheque_ref_no` varchar(200) DEFAULT NULL,
  `company_signature` varchar(1000) DEFAULT NULL,
  `company_sign_name` varchar(1000) DEFAULT NULL,
  `company_sign_date_time` datetime DEFAULT NULL,
  `customer_signature` varchar(1000) DEFAULT NULL,
  `customer_sign_name` varchar(1000) DEFAULT NULL,
  `customer_sign_datetime` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `ids` int(11) NOT NULL,
  `customer_id` varchar(20) NOT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `customer_email` varchar(200) DEFAULT NULL,
  `customer_addr` text DEFAULT NULL,
  `customer_attn` varchar(1000) DEFAULT NULL,
  `customer_cr_cpr` varchar(100) DEFAULT NULL,
  `cpr_expiry_date` date DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `customer_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `client_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `driver_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `company_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_on` datetime DEFAULT NULL
) ;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`ids`, `customer_id`, `customer_name`, `customer_mobile`, `customer_email`, `customer_addr`, `customer_attn`, `customer_cr_cpr`, `cpr_expiry_date`, `customer_type`, `customer_address`, `client_docs`, `driver_docs`, `register_date`, `company_id`, `created_by`, `status`, `updated_on`) VALUES
(1, 'C0001', 'BAQER MAHMOOD ', '33310186', 'anzelabk@gmail.com', 'VILLA 4850 RD 2053 AL LAWZI 1020', '', '560502141', '2030-02-04', 'Individual', NULL, '\"{\\\"vehicles\\\":[]}\"', NULL, '2026-09-13 00:00:00', 1, 1, 'Active', NULL),
(2, 'C0002', 'baqer', '', '', '', '', '', NULL, 'Individual', NULL, '{\"vehicles\":[]}', NULL, '2026-09-14 16:54:27', 1, NULL, 'Active', NULL),
(3, 'C0003', '', '', '', '', '', '560502141', NULL, NULL, NULL, '{\"vehicles\":[]}', NULL, '2026-09-14 16:56:10', 1, NULL, 'Active', NULL),
(4, 'C0004', '', '', '', '', '', '560502141', NULL, NULL, NULL, '{\"vehicles\":[]}', NULL, '2026-09-15 11:12:09', 1, NULL, 'Active', NULL),
(5, 'C0005', '', '', '', '', '', '560502141', NULL, 'Individual', NULL, '{\"vehicles\":[]}', NULL, '2026-09-15 11:14:09', 1, NULL, 'Active', NULL),
(6, 'C0006', 'baqer mahmood', '', 'anzelabk@gmail.com', 'fastlink', 'ok', '560502141', NULL, 'Individual', NULL, '{\"vehicles\":[]}', NULL, '2026-09-15 11:15:59', 1, NULL, 'Active', NULL),
(7, 'C0007', 'ABDULLA ISA ALI KHAMIS MOHAMED ALROMAIHI', '33661055', 'anzelabk@gmail.com', 'FASTLINK', 'GOOD CUSTOMER', '020711840', '2030-12-10', 'Individual', NULL, '\"{\\\"vehicles\\\":[]}\"', NULL, '2026-09-22 00:00:00', 1, 1, 'Active', NULL),
(8, 'C0008', 'nidham', '39771190', 'nidham1@gmail.com', 'flat 13 bldg 4 road 1101 Tubli 711', '', '760504989', '2028-05-26', 'Individual', NULL, '\"{\\\"vehicles\\\":[]}\"', NULL, '2026-10-14 00:00:00', 1, 1, 'Active', NULL),
(9, 'C0009', 'nidham', '', '', '', '', '', NULL, NULL, NULL, '[]', NULL, '2026-10-14 13:05:51', 1, NULL, 'Active', NULL),
(10, 'C0010', '', '', '', '', '', '760504989', NULL, NULL, NULL, '[]', NULL, '2026-10-14 13:06:23', 1, NULL, 'Active', NULL),
(11, 'C0011', '', '39771190', '', '', '', '', NULL, NULL, NULL, '{\"vehicles\":[]}', NULL, '2026-10-14 13:07:52', 1, NULL, 'Active', NULL),
(12, 'C0012', 'Anzel Sait', '', 'anzelabk@gmail.com', '', '', '850549558', NULL, 'Individual', NULL, '{\"vehicles\":[]}', NULL, '2026-11-02 15:17:46', 1, NULL, 'Active', NULL),
(13, 'C0013', 'Anzel Sait', '', 'anzelabk@gmail.com', '', '', '850549558', NULL, 'Individual', NULL, '{\"vehicles\":[]}', NULL, '2026-11-02 15:21:14', 1, NULL, 'Active', NULL),
(14, 'C0014', '', '', '', '', '', '', NULL, NULL, NULL, '{\"vehicles\":[]}', NULL, '2026-11-05 12:58:04', 1, NULL, 'Active', NULL),
(15, 'C0015', '', '', '', '', '', '', NULL, NULL, NULL, '{\"vehicles\":[]}', NULL, '2026-11-05 12:58:04', 1, NULL, 'Active', NULL);

--
-- Triggers `customer_details`
--
DELIMITER $$
CREATE TRIGGER `trg_customer_id` BEFORE INSERT ON `customer_details` FOR EACH ROW BEGIN

    SET NEW.customer_id = CONCAT(

        'C',

        LPAD(

            IFNULL(

                (SELECT AUTO_INCREMENT

                 FROM information_schema.TABLES

                 WHERE TABLE_SCHEMA = DATABASE()

                   AND TABLE_NAME = 'customer_details'

                ),

                1

            ),

            4,

            '0'

        )

    );

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `document_sequences`
--

CREATE TABLE `document_sequences` (
  `id` int(11) NOT NULL,
  `doc_type` varchar(50) NOT NULL,
  `doc_year` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `current_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `document_sequences`
--

INSERT INTO `document_sequences` (`id`, `doc_type`, `doc_year`, `company_id`, `current_number`, `user_id`, `created_on`) VALUES
(10, 'QD', 2026, 1, 4, 1, '2026-07-13 15:37:27'),
(11, 'QD', 2026, 2, 1, 1, '2026-08-23 17:48:00'),
(9, 'QT', 2026, 1, 5, 1, '2026-06-20 13:40:08'),
(8, 'PO', 2026, 1, 0, 1, '2026-06-05 21:25:55'),
(12, 'QT', 2026, 2, 4, 1, '2026-08-23 17:49:13');

-- --------------------------------------------------------

--
-- Table structure for table `expensevoucher`
--

CREATE TABLE `expensevoucher` (
  `id` int(11) NOT NULL,
  `expensevoucher_no` varchar(100) DEFAULT NULL,
  `expensevoucher_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_no` varchar(200) DEFAULT NULL,
  `model_ids` int(11) DEFAULT NULL,
  `model_names` varchar(500) DEFAULT NULL,
  `vehicle_color` varchar(200) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `expensevoucher_notes` text DEFAULT NULL,
  `expensevoucher_payment_type` varchar(200) DEFAULT NULL,
  `expensevoucher_cheque_date` date DEFAULT NULL,
  `expensevoucher_cheque_ref_no` varchar(200) DEFAULT NULL,
  `company_signature` varchar(1000) DEFAULT NULL,
  `company_sign_name` varchar(1000) DEFAULT NULL,
  `company_sign_date_time` datetime DEFAULT NULL,
  `customer_signature` varchar(1000) DEFAULT NULL,
  `customer_sign_name` varchar(1000) DEFAULT NULL,
  `customer_sign_datetime` datetime DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) NOT NULL,
  `customer_address` text DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `attention` text DEFAULT NULL,
  `lpo_number` varchar(100) DEFAULT NULL,
  `trn_no` varchar(100) DEFAULT NULL,
  `quotation_ref_no` varchar(100) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` int(11) NOT NULL,
  `user_prefix` varchar(200) DEFAULT NULL,
  `quotation_no` varchar(50) DEFAULT NULL,
  `quotation_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `attention` text DEFAULT NULL,
  `introduction` longtext DEFAULT NULL,
  `terms` longtext DEFAULT NULL,
  `quotation_status` varchar(100) NOT NULL DEFAULT 'Not Approved'
) ;

-- --------------------------------------------------------

--
-- Table structure for table `shortcut_actions`
--

CREATE TABLE `shortcut_actions` (
  `id` int(11) NOT NULL,
  `action_name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `default_key` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `shortcut_actions`
--

INSERT INTO `shortcut_actions` (`id`, `action_name`, `description`, `default_key`) VALUES
(1, 'open_dashboard', 'Open Dashboard', 'Alt+D'),
(2, 'open_sales', 'Open Sales', 'Alt+S'),
(3, 'open_purchase', 'Open Purchase', 'Alt+P'),
(4, 'open_accounts', 'Open Accounts', 'Alt+A'),
(5, 'new_invoice', 'New Invoice', 'Ctrl+I'),
(6, 'save_record', 'Save Record', 'Ctrl+S'),
(7, 'search', 'Search', 'Ctrl+F'),
(8, 'logout', 'Logout', 'Alt+L');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_banks`
--

CREATE TABLE `tbl_banks` (
  `ids` int(11) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `account_no` varchar(100) DEFAULT NULL,
  `company_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_banks`
--

INSERT INTO `tbl_banks` (`ids`, `bank_name`, `account_no`, `company_id`, `created_at`) VALUES
(1, 'AL Salam Bank', '9895016611', 1, '2026-04-21 15:53:29'),
(2, 'AL Salam Bank', '9895016611', 1, '2026-04-21 15:56:57'),
(3, 'Alsalam Bank', '1252222', 1, '2026-04-22 02:02:31'),
(4, 'Federal Bank', '0783058935', 1, '2026-04-22 02:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_company`
--

CREATE TABLE `tbl_company` (
  `ids` int(11) NOT NULL,
  `company_code` varchar(100) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_logo` varchar(1000) NOT NULL DEFAULT 'default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_company`
--

INSERT INTO `tbl_company` (`ids`, `company_code`, `company_name`, `company_logo`, `status`) VALUES
(1, 'FL', 'Fast Link', 'assets/img/logo/logo.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_ledger`
--

CREATE TABLE `tbl_customer_ledger` (
  `ids` int(11) NOT NULL,
  `customer_code` varchar(100) NOT NULL,
  `quotation_no` varchar(100) DEFAULT NULL,
  `booking_no` varchar(100) DEFAULT NULL,
  `trans_date` date NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `trans_type` varchar(100) NOT NULL,
  `payment_method` enum('Cash','Cheque','BankTransfer','CreditCard','Other','N/A') DEFAULT 'N/A',
  `bank_id` int(11) DEFAULT NULL,
  `company_bank_id` int(11) DEFAULT NULL,
  `debit` decimal(18,5) DEFAULT 0.00000,
  `credit` decimal(18,5) DEFAULT 0.00000,
  `ref_no` varchar(200) DEFAULT NULL,
  `cheque_status` enum('Pending','Collected','Bounced') DEFAULT 'Pending',
  `collected_at` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_ids` int(11) DEFAULT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_ledger`
--

INSERT INTO `tbl_customer_ledger` (`ids`, `customer_code`, `quotation_no`, `booking_no`, `trans_date`, `cheque_date`, `trans_type`, `payment_method`, `bank_id`, `company_bank_id`, `debit`, `credit`, `ref_no`, `cheque_status`, `collected_at`, `description`, `user_id`, `company_id`, `created_at`, `booking_ids`, `contract_ids`, `agreement_no`) VALUES
(1, 'C0006', '', '', '2026-09-22', NULL, 'Direct Contract Rentout', 'N/A', NULL, NULL, 52.80000, 0.00000, 'FL/AGR/2026/0002', 'Pending', NULL, 'Rentout from Direct Contract (Agreement No: FL/AGR/2026/0002)', 1, 1, '2026-09-22 06:00:15', 0, 2, 'FL/AGR/2026/0002'),
(2, 'C0002', '', NULL, '2026-09-22', NULL, 'Rental Without Driver', 'N/A', NULL, NULL, 24.00000, 0.00000, NULL, 'Pending', NULL, 'Auto Post Rental Fee', 1, 1, '2026-09-22 06:03:09', 0, 1, 'FL/AGR/2026/0001'),
(3, 'C0002', '', NULL, '2026-09-22', NULL, 'VAT', 'N/A', NULL, NULL, 2.40000, 0.00000, NULL, 'Pending', NULL, 'Auto Post VAT of Rental Fee', 1, 1, '2026-09-22 06:03:09', 0, 1, 'FL/AGR/2026/0001'),
(4, 'C0008', '', '', '2026-10-14', NULL, 'Direct Contract Rentout', 'N/A', NULL, NULL, 15.40000, 0.00000, 'FL/AGR/2026/0004', 'Pending', NULL, 'Rentout from Direct Contract (Agreement No: FL/AGR/2026/0004)', 1, 1, '2026-10-14 05:37:46', 0, 4, 'FL/AGR/2026/0004'),
(5, 'C0006', NULL, NULL, '2026-10-14', NULL, '\n                            Invoice\n                        ', 'N/A', NULL, NULL, 52.80000, 0.00000, '', 'Pending', NULL, 'weekly', 1, 1, '2026-10-14 08:45:15', 0, 2, 'FL/AGR/2026/0002'),
(6, 'C0006', '', '', '2026-10-15', NULL, 'Direct Contract Rentout', 'N/A', NULL, NULL, 59.40000, 0.00000, 'FL/AGR/2026/0005', 'Pending', NULL, 'Rentout from Direct Contract (Agreement No: FL/AGR/2026/0005)', 1, 1, '2026-10-15 05:02:09', 0, 5, 'FL/AGR/2026/0005'),
(7, 'C0012', '', NULL, '2026-11-02', NULL, 'Rental Without Driver', 'N/A', NULL, NULL, 10.00000, 0.00000, NULL, 'Pending', NULL, 'Auto Post Rental Fee', 1, 1, '2026-11-02 07:25:04', 0, 6, 'FL/AGR/2026/0006'),
(8, 'C0012', '', NULL, '2026-11-02', NULL, 'VAT', 'N/A', NULL, NULL, 1.00000, 0.00000, NULL, 'Pending', NULL, 'Auto Post VAT of Rental Fee', 1, 1, '2026-11-02 07:25:04', 0, 6, 'FL/AGR/2026/0006');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_drivers`
--

CREATE TABLE `tbl_drivers` (
  `ids` int(11) NOT NULL,
  `company_ids` int(11) DEFAULT NULL,
  `driver_name` varchar(1000) DEFAULT NULL,
  `driver_contact_no` varchar(500) DEFAULT NULL,
  `driver_email_id` varchar(1000) DEFAULT NULL,
  `driver_cpr_no` varchar(1000) DEFAULT NULL,
  `driver_cpr_expiry_date` date DEFAULT NULL,
  `license_no` varchar(1000) DEFAULT NULL,
  `license_issue_place` varchar(1000) DEFAULT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `driver_address` text DEFAULT NULL,
  `created_by` varchar(500) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `driver_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `driver_status` varchar(100) DEFAULT 'Active'
) ;

--
-- Dumping data for table `tbl_drivers`
--

INSERT INTO `tbl_drivers` (`ids`, `company_ids`, `driver_name`, `driver_contact_no`, `driver_email_id`, `driver_cpr_no`, `driver_cpr_expiry_date`, `license_no`, `license_issue_place`, `license_issue_date`, `license_expiry_date`, `driver_address`, `created_by`, `created_on`, `driver_documents`, `driver_status`) VALUES
(1, 1, 'Driver1', '21323423', 'test@gmail.com', '234234234', '2026-07-11', '234324', 'Bahrain', '2026-07-16', '2026-07-15', 'test', '1', '2026-08-29 00:00:00', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"License\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/webp\\/file_6a38f26e4fcc30.20658168.webp\\\"]},{\\\"documentName\\\":\\\"test\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/webp\\/file_6a928bbe27f144.53377310.webp\\\"]}]}\"', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_garages`
--

CREATE TABLE `tbl_garages` (
  `ids` int(11) NOT NULL,
  `garage_code` varchar(100) NOT NULL,
  `garage_name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person` varchar(150) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `email_id` varchar(150) DEFAULT NULL,
  `status` enum('Available','Deactivated') DEFAULT 'Available',
  `company_id` int(11) DEFAULT 1,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_garages`
--

INSERT INTO `tbl_garages` (`ids`, `garage_code`, `garage_name`, `address`, `contact_person`, `contact_number`, `email_id`, `status`, `company_id`, `created_on`, `created_by`) VALUES
(1, '01', 'ALMOAYYED', 'SALMABAD', 'SANEESH', '32000139', 'anzelabk@gmail.com', 'Available', 1, '2026-09-13 15:54:09', 1),
(2, '02', 'QUICKLANE', 'SALMABAD', 'SAJNU', '33661055', 'anzelabk@gmail.com', 'Available', 1, '2026-09-13 15:54:51', 1),
(3, '03', 'ZAYANI FOR MG SERVICE', 'SITRA', 'MR YOUSIF', '33661055', 'anzelabk@gmail.com', 'Available', 1, '2026-09-13 15:55:35', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_garage_services`
--

CREATE TABLE `tbl_garage_services` (
  `ids` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `unit` varchar(100) DEFAULT NULL,
  `charge_per_unit` decimal(10,2) DEFAULT 0.00,
  `status` enum('Available','Deactivated') DEFAULT 'Available',
  `company_id` int(11) DEFAULT 1,
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_garage_services`
--

INSERT INTO `tbl_garage_services` (`ids`, `service_name`, `unit`, `charge_per_unit`, `status`, `company_id`, `created_on`, `created_by`) VALUES
(1, 'Tyre Change', 'Nos', 2.00, 'Available', 1, '2026-08-18 18:28:06', 1),
(2, 'Fuel Change', '', 0.00, 'Available', 1, '2026-08-18 18:34:44', 1),
(3, 'Oil Change & Filter', 'Job', 150.00, 'Available', 1, '2026-08-19 17:37:28', NULL),
(4, 'Brake Pad Replacement', 'Job', 200.00, 'Available', 1, '2026-08-19 17:37:28', NULL),
(5, 'AC Gas Refill', 'Job', 100.00, 'Available', 1, '2026-08-19 17:37:28', NULL),
(6, 'Full Vehicle Polish', 'Job', 300.00, 'Available', 1, '2026-08-19 17:37:28', NULL),
(7, 'Tire Replacement & Balancing', 'Job', 50.00, 'Available', 1, '2026-08-19 17:37:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_billing_schedules`
--

CREATE TABLE `tbl_invoice_billing_schedules` (
  `ids` int(11) NOT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(100) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `booking_ref_no` varchar(100) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `contract_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `invoice_schedule_date` date DEFAULT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `invoice_amount` decimal(10,3) DEFAULT 0.000,
  `invoice_period_from` date DEFAULT NULL,
  `invoice_period_to` date DEFAULT NULL,
  `log_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ledger_heads`
--

CREATE TABLE `tbl_ledger_heads` (
  `ids` int(11) NOT NULL,
  `head_name` varchar(100) NOT NULL,
  `head_type` enum('Debit','Credit') NOT NULL,
  `is_locked` tinyint(1) DEFAULT 0,
  `company_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `violation_fine_type` varchar(10) NOT NULL DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ledger_heads`
--

INSERT INTO `tbl_ledger_heads` (`ids`, `head_name`, `head_type`, `is_locked`, `company_id`, `created_at`, `violation_fine_type`) VALUES
(1, 'Opening Balance', 'Debit', 1, 1, '2026-04-22 02:15:22', 'No'),
(2, 'Invoice', 'Debit', 1, 1, '2026-04-22 02:15:22', 'No'),
(3, 'Payment', 'Credit', 1, 1, '2026-04-22 02:15:22', 'No'),
(4, 'Advance', 'Credit', 1, 1, '2026-04-22 02:15:22', 'No'),
(5, 'Discount', 'Credit', 1, 1, '2026-04-22 02:15:22', 'No'),
(6, 'Other', 'Credit', 0, 1, '2026-04-22 02:15:22', 'No'),
(7, 'Management Fee', 'Credit', 0, 1, '2026-04-22 02:17:59', 'No'),
(14, 'Deposit', 'Credit', 0, 1, '2026-05-27 22:28:48', 'No'),
(15, 'Rental Without Driver', 'Debit', 1, 1, '2026-05-27 22:32:23', 'No'),
(16, 'Rental With Driver', 'Debit', 1, 1, '2026-05-27 22:32:23', 'No'),
(17, 'Delay Fine', 'Debit', 1, 1, '2026-05-27 22:32:23', 'Yes'),
(18, 'Violation Fee', 'Debit', 1, 1, '2026-05-27 22:32:23', 'Yes'),
(22, 'Refund', 'Debit', 0, 1, '2026-05-27 22:28:48', 'No'),
(23, 'Vehicle Violation', 'Debit', 0, 1, '2026-08-01 13:28:28', 'Yes'),
(24, 'Violation1', 'Debit', 0, 1, '2026-08-01 13:34:10', 'Yes'),
(25, 'Violation2', 'Debit', 0, 1, '2026-08-01 13:34:29', 'Yes'),
(26, 'violation3', 'Debit', 0, 1, '2026-08-02 10:35:32', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_maintenance_requests`
--

CREATE TABLE `tbl_maintenance_requests` (
  `ids` int(11) NOT NULL,
  `request_no` varchar(100) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `garage_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `company_id` int(11) DEFAULT NULL,
  `additional_charges` decimal(10,3) DEFAULT 0.000,
  `additional_charges_remarks` varchar(255) DEFAULT NULL,
  `total_cost` decimal(10,3) DEFAULT 0.000,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_maintenance_request_services`
--

CREATE TABLE `tbl_maintenance_request_services` (
  `ids` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `qty` decimal(10,2) DEFAULT 1.00,
  `cost` decimal(10,3) DEFAULT 0.000,
  `unit` varchar(50) DEFAULT NULL,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_outsourcing_companies`
--

CREATE TABLE `tbl_outsourcing_companies` (
  `ids` int(11) NOT NULL,
  `company_id` int(11) DEFAULT 1,
  `company_name` varchar(255) NOT NULL,
  `cr_number` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `contact_person_number` varchar(50) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  `created_on` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_outsourcing_companies`
--

INSERT INTO `tbl_outsourcing_companies` (`ids`, `company_id`, `company_name`, `cr_number`, `address`, `contact_person_name`, `contact_person_number`, `email_id`, `status`, `created_on`, `created_by`, `updated_on`, `updated_by`) VALUES
(2, 1, 'SaNDS Lab', '787889', 'Manama Bahrain', 'Ancy Varghese', '98797997', 'care@sandslab.com', 'Inactive', '2026-08-16 17:05:18', 1, '2026-08-18 14:21:47', 74);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(200) DEFAULT NULL,
  `permission_key` varchar(100) DEFAULT NULL,
  `module_group` varchar(100) DEFAULT 'General',
  `status` varchar(20) DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`permission_id`, `permission_name`, `permission_key`, `module_group`, `status`) VALUES
(1, 'Dashboard Access', 'dashboard_access', 'Dashboard', 'Active'),
(2, 'Dashboard Manage', 'dashboard_manage', 'Dashboard', 'Active'),
(3, 'Users Access', 'users_access', 'Masters', 'Active'),
(4, 'Users Manage', 'users_manage', 'Masters', 'Active'),
(5, 'Vehicle Configuration Access', 'vehicle_config_access', 'Masters', 'Active'),
(6, 'Vehicle Configuration Manage', 'vehicle_config_manage', 'Masters', 'Active'),
(7, 'Vehicle Registration Access', 'vehicle_registration_access', 'Masters', 'Active'),
(8, 'Vehicle Registration Manage', 'vehicle_registration_manage', 'Masters', 'Active'),
(9, 'Driver Registration Access', 'driver_registration_access', 'Masters', 'Active'),
(10, 'Driver Registration Manage', 'driver_registration_manage', 'Masters', 'Active'),
(11, 'Staff Registration Access', 'staff_registration_access', 'Masters', 'Active'),
(12, 'Staff Registration Manage', 'staff_registration_manage', 'Masters', 'Active'),
(13, 'List of Vehicles Access', 'list_of_vehicles_access', 'Masters', 'Active'),
(14, 'List of Vehicles Manage', 'list_of_vehicles_manage', 'Masters', 'Active'),
(15, 'Customers Access', 'customers_access', 'Masters', 'Active'),
(16, 'Customers Manage', 'customers_manage', 'Masters', 'Active'),
(17, 'Outsourcing Company Access', 'outsourcing_company_access', 'Masters', 'Active'),
(18, 'Outsourcing Company Manage', 'outsourcing_company_manage', 'Masters', 'Active'),
(19, 'Vehicle Reservation Access', 'vehicle_reservation_access', 'Operations', 'Active'),
(20, 'Vehicle Reservation Manage', 'vehicle_reservation_manage', 'Operations', 'Active'),
(21, 'Generate Contract Access', 'generate_contract_access', 'Operations', 'Active'),
(22, 'Generate Contract Manage', 'generate_contract_manage', 'Operations', 'Active'),
(23, 'Contract List Access', 'contract_list_access', 'Operations', 'Active'),
(24, 'Contract List Manage', 'contract_list_manage', 'Operations', 'Active'),
(25, 'Send Contract Access', 'send_contract_access', 'Operations', 'Active'),
(26, 'Send Contract Manage', 'send_contract_manage', 'Operations', 'Active'),
(27, 'Staff Use Allocation Access', 'staff_use_allocation_access', 'Operations', 'Active'),
(28, 'Staff Use Allocation Manage', 'staff_use_allocation_manage', 'Operations', 'Active'),
(29, 'Quotation Access', 'quotation_access', 'Accounting', 'Active'),
(30, 'Quotation Manage', 'quotation_manage', 'Accounting', 'Active'),
(31, 'Invoice Access', 'invoice_access', 'Accounting', 'Active'),
(32, 'Invoice Manage', 'invoice_manage', 'Accounting', 'Active'),
(33, 'Cash Memo/Receipt Access', 'cash_memo_access', 'Accounting', 'Active'),
(34, 'Cash Memo/Receipt Manage', 'cash_memo_manage', 'Accounting', 'Active'),
(35, 'Expense Voucher Access', 'expense_voucher_access', 'Accounting', 'Active'),
(36, 'Expense Voucher Manage', 'expense_voucher_manage', 'Accounting', 'Active'),
(37, 'Customer Ledger Access', 'customer_ledger_access', 'Accounting', 'Active'),
(38, 'Customer Ledger Manage', 'customer_ledger_manage', 'Accounting', 'Active'),
(39, 'Fund Flow Report Access', 'fund_flow_report_access', 'Accounting', 'Active'),
(40, 'Fund Flow Report Manage', 'fund_flow_report_manage', 'Accounting', 'Active'),
(41, 'Unbilled Contracts Access', 'unbilled_contracts_access', 'Accounting', 'Active'),
(42, 'Unbilled Contracts Manage', 'unbilled_contracts_manage', 'Accounting', 'Active'),
(43, 'Vehicle Insight Access', 'vehicle_insight_access', 'Reports', 'Active'),
(44, 'Vehicle Insight Manage', 'vehicle_insight_manage', 'Reports', 'Active'),
(45, 'Expected Returns Access', 'expected_returns_access', 'Reports', 'Active'),
(46, 'Expected Returns Manage', 'expected_returns_manage', 'Reports', 'Active'),
(47, 'Customer Balances Access', 'customer_balances_access', 'Reports', 'Active'),
(48, 'Customer Balances Manage', 'customer_balances_manage', 'Reports', 'Active'),
(49, 'Daily Rental Report Access', 'daily_rental_report_access', 'Reports', 'Active'),
(50, 'Daily Rental Report Manage', 'daily_rental_report_manage', 'Reports', 'Active'),
(51, 'Daily Cash Report Access', 'daily_cash_report_access', 'Reports', 'Active'),
(52, 'Daily Cash Report Manage', 'daily_cash_report_manage', 'Reports', 'Active'),
(53, 'Staff Use Report Access', 'staff_use_report_access', 'Reports', 'Active'),
(54, 'Staff Use Report Manage', 'staff_use_report_manage', 'Reports', 'Active'),
(55, 'Contract & Replacement History Access', 'contract_history_report_access', 'Reports', 'Active'),
(56, 'Contract & Replacement History Manage', 'contract_history_report_manage', 'Reports', 'Active'),
(57, 'System Settings Access', 'system_settings_access', 'Settings', 'Active'),
(58, 'System Settings Manage', 'system_settings_manage', 'Settings', 'Active'),
(59, 'Garage and Service Master Access', 'garage_and_service_access', 'Registration', 'Active'),
(60, 'Garage and Service Master Manage', 'garage_and_service_manage', 'Registration', 'Active'),
(61, 'Vehicle Insurance Access', 'vehicle_insurance_access', 'Masters', 'Active'),
(62, 'Vehicle Insurance Manage', 'vehicle_insurance_manage', 'Masters', 'Active'),
(63, 'Maintenance Request Access', 'maintenance_request_access', 'General', 'Active'),
(64, 'Maintenance Request Manage', 'maintenance_request_manage', 'General', 'Active'),
(65, 'Maintenance Request Approve', 'maintenance_request_approve', 'General', 'Active'),
(66, 'Quotation Approve', 'quotation_approve', 'Accounting', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_quotation_introduction`
--

CREATE TABLE `tbl_quotation_introduction` (
  `ids` int(11) NOT NULL,
  `intrn_title` varchar(500) DEFAULT NULL,
  `intrn_content` longtext DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_quotation_introduction`
--

INSERT INTO `tbl_quotation_introduction` (`ids`, `intrn_title`, `intrn_content`, `company_id`, `user_id`) VALUES
(4, '111', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', 1, 1),
(6, 'Intro2', '<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>', 1, 1),
(7, 'eeee', '<p>eeeee</p>', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`role_id`, `role_name`, `status`) VALUES
(1, 'Administrator', 'Active'),
(2, 'User', 'Active'),
(3, 'Super Admin', 'Active'),
(4, 'Accountant', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_permissions`
--

CREATE TABLE `tbl_role_permissions` (
  `ids` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Granted',
  `updated_date` datetime DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_role_permissions`
--

INSERT INTO `tbl_role_permissions` (`ids`, `role_id`, `permission_id`, `status`, `updated_date`) VALUES
(1, 4, 29, 'Granted', '2026-08-30 18:18:49'),
(2, 4, 30, 'Granted', '2026-08-30 18:18:49'),
(3, 4, 31, 'Granted', '2026-08-30 18:18:49'),
(4, 4, 32, 'Granted', '2026-08-30 18:18:49'),
(5, 4, 33, 'Granted', '2026-08-30 18:18:49'),
(6, 4, 34, 'Granted', '2026-08-30 18:18:49'),
(7, 4, 35, 'Granted', '2026-08-30 18:18:49'),
(8, 4, 36, 'Granted', '2026-08-30 18:18:49'),
(9, 4, 37, 'Granted', '2026-08-30 18:18:49'),
(10, 4, 38, 'Granted', '2026-08-30 18:18:49'),
(11, 4, 39, 'Granted', '2026-08-30 18:18:49'),
(12, 4, 40, 'Granted', '2026-08-30 18:18:49'),
(13, 4, 41, 'Granted', '2026-08-30 18:18:49'),
(14, 4, 42, 'Granted', '2026-08-30 18:18:49'),
(15, 4, 1, 'Granted', '2026-08-30 18:18:49'),
(16, 4, 2, 'Granted', '2026-08-30 18:18:49'),
(17, 4, 3, 'Granted', '2026-08-30 18:18:49'),
(18, 4, 4, 'Granted', '2026-08-30 18:18:49'),
(19, 4, 5, 'Granted', '2026-08-30 18:18:49'),
(20, 4, 6, 'Granted', '2026-08-30 18:18:49'),
(21, 4, 7, 'Granted', '2026-08-30 18:18:49'),
(22, 4, 8, 'Granted', '2026-08-30 18:18:49'),
(23, 4, 9, 'Granted', '2026-08-30 18:18:49'),
(24, 4, 10, 'Granted', '2026-08-30 18:18:49'),
(25, 4, 11, 'Granted', '2026-08-30 18:18:49'),
(26, 4, 12, 'Granted', '2026-08-30 18:18:49'),
(27, 4, 13, 'Granted', '2026-08-30 18:18:49'),
(28, 4, 14, 'Granted', '2026-08-30 18:18:49'),
(29, 4, 15, 'Granted', '2026-08-30 18:18:49'),
(30, 4, 16, 'Granted', '2026-08-30 18:18:49'),
(31, 4, 17, 'Granted', '2026-08-30 18:18:49'),
(32, 4, 18, 'Granted', '2026-08-30 18:18:49'),
(33, 4, 19, 'Granted', '2026-08-30 18:18:49'),
(34, 4, 20, 'Granted', '2026-08-30 18:18:49'),
(35, 4, 21, 'Granted', '2026-08-30 18:18:49'),
(36, 4, 22, 'Granted', '2026-08-30 18:18:49'),
(37, 4, 23, 'Granted', '2026-08-30 18:18:49'),
(38, 4, 24, 'Granted', '2026-08-30 18:18:49'),
(39, 4, 25, 'Granted', '2026-08-30 18:18:49'),
(40, 4, 26, 'Granted', '2026-08-30 18:18:49'),
(41, 4, 27, 'Granted', '2026-08-30 18:18:49'),
(42, 4, 28, 'Granted', '2026-08-30 18:18:49'),
(43, 4, 43, 'Granted', '2026-08-30 18:18:49'),
(44, 4, 44, 'Granted', '2026-08-30 18:18:49'),
(45, 4, 45, 'Granted', '2026-08-30 18:18:49'),
(46, 4, 46, 'Granted', '2026-08-30 18:18:49'),
(47, 4, 47, 'Granted', '2026-08-30 18:18:49'),
(48, 4, 48, 'Granted', '2026-08-30 18:18:49'),
(49, 4, 49, 'Granted', '2026-08-30 18:18:49'),
(50, 4, 50, 'Granted', '2026-08-30 18:18:49'),
(51, 4, 51, 'Granted', '2026-08-30 18:18:49'),
(52, 4, 52, 'Granted', '2026-08-30 18:18:49'),
(53, 4, 53, 'Granted', '2026-08-30 18:18:49'),
(54, 4, 54, 'Granted', '2026-08-30 18:18:49'),
(55, 4, 55, 'Granted', '2026-08-30 18:18:49'),
(56, 4, 56, 'Granted', '2026-08-30 18:18:49'),
(57, 4, 57, 'Granted', '2026-08-30 18:18:49'),
(58, 4, 58, 'Granted', '2026-08-30 18:18:49'),
(59, 1, 29, 'Granted', '2026-08-17 16:58:38'),
(60, 1, 30, 'Granted', '2026-08-17 16:58:38'),
(61, 1, 31, 'Granted', '2026-08-17 16:58:38'),
(62, 1, 32, 'Granted', '2026-08-17 16:58:38'),
(63, 1, 33, 'Granted', '2026-08-17 16:58:38'),
(64, 1, 34, 'Granted', '2026-08-17 16:58:38'),
(65, 1, 35, 'Granted', '2026-08-17 16:58:38'),
(66, 1, 36, 'Granted', '2026-08-17 16:58:38'),
(67, 1, 37, 'Granted', '2026-08-17 16:58:38'),
(68, 1, 38, 'Granted', '2026-08-17 16:58:38'),
(69, 1, 39, 'Granted', '2026-08-17 16:58:38'),
(70, 1, 40, 'Granted', '2026-08-17 16:58:38'),
(71, 1, 41, 'Granted', '2026-08-17 16:58:38'),
(72, 1, 42, 'Granted', '2026-08-17 16:58:38'),
(73, 1, 1, 'Granted', '2026-08-17 16:58:38'),
(74, 1, 2, 'Granted', '2026-08-17 16:58:38'),
(75, 1, 3, 'Granted', '2026-08-17 16:58:38'),
(76, 1, 4, 'Granted', '2026-08-17 16:58:38'),
(77, 1, 5, 'Granted', '2026-08-17 16:58:38'),
(78, 1, 6, 'Granted', '2026-08-17 16:58:38'),
(79, 1, 7, 'Granted', '2026-08-17 16:58:38'),
(80, 1, 8, 'Granted', '2026-08-17 16:58:38'),
(81, 1, 9, 'Granted', '2026-08-17 16:58:38'),
(82, 1, 10, 'Granted', '2026-08-17 16:58:38'),
(83, 1, 11, 'Granted', '2026-08-17 16:58:38'),
(84, 1, 12, 'Granted', '2026-08-17 16:58:38'),
(85, 1, 13, 'Granted', '2026-08-17 16:58:38'),
(86, 1, 14, 'Granted', '2026-08-17 16:58:38'),
(87, 1, 15, 'Granted', '2026-08-17 16:58:38'),
(88, 1, 16, 'Granted', '2026-08-17 16:58:38'),
(89, 1, 17, 'Granted', '2026-08-17 16:58:38'),
(90, 1, 18, 'Granted', '2026-08-17 16:58:38'),
(91, 1, 19, 'Granted', '2026-08-17 16:58:38'),
(92, 1, 20, 'Granted', '2026-08-17 16:58:38'),
(93, 1, 21, 'Granted', '2026-08-17 16:58:38'),
(94, 1, 22, 'Granted', '2026-08-17 16:58:38'),
(95, 1, 23, 'Granted', '2026-08-17 16:58:38'),
(96, 1, 24, 'Granted', '2026-08-17 16:58:38'),
(97, 1, 25, 'Granted', '2026-08-17 16:58:38'),
(98, 1, 26, 'Granted', '2026-08-17 16:58:38'),
(99, 1, 27, 'Granted', '2026-08-17 16:58:38'),
(100, 1, 28, 'Granted', '2026-08-17 16:58:38'),
(101, 1, 43, 'Granted', '2026-08-17 16:58:38'),
(102, 1, 44, 'Granted', '2026-08-17 16:58:38'),
(103, 1, 45, 'Granted', '2026-08-17 16:58:38'),
(104, 1, 46, 'Granted', '2026-08-17 16:58:38'),
(105, 1, 47, 'Granted', '2026-08-17 16:58:38'),
(106, 1, 48, 'Granted', '2026-08-17 16:58:38'),
(107, 1, 49, 'Granted', '2026-08-17 16:58:38'),
(108, 1, 50, 'Granted', '2026-08-17 16:58:38'),
(109, 1, 51, 'Granted', '2026-08-17 16:58:38'),
(110, 1, 52, 'Granted', '2026-08-17 16:58:38'),
(111, 1, 53, 'Granted', '2026-08-17 16:58:38'),
(112, 1, 54, 'Granted', '2026-08-17 16:58:38'),
(113, 1, 55, 'Granted', '2026-08-17 16:58:38'),
(114, 1, 56, 'Granted', '2026-08-17 16:58:38'),
(115, 1, 57, 'Granted', '2026-08-17 16:58:38'),
(116, 1, 58, 'Granted', '2026-08-17 16:58:38'),
(117, 2, 29, 'Revoked', '2026-08-17 19:38:44'),
(118, 2, 30, 'Revoked', '2026-08-17 19:38:44'),
(119, 2, 31, 'Revoked', '2026-08-17 19:38:44'),
(120, 2, 32, 'Revoked', '2026-08-17 19:38:44'),
(121, 2, 33, 'Revoked', '2026-08-17 19:38:44'),
(122, 2, 34, 'Revoked', '2026-08-17 19:38:44'),
(123, 2, 35, 'Revoked', '2026-08-17 19:38:44'),
(124, 2, 36, 'Revoked', '2026-08-17 19:38:44'),
(125, 2, 37, 'Revoked', '2026-08-17 19:38:44'),
(126, 2, 38, 'Revoked', '2026-08-17 19:38:44'),
(127, 2, 39, 'Revoked', '2026-08-17 19:38:44'),
(128, 2, 40, 'Revoked', '2026-08-17 19:38:44'),
(129, 2, 41, 'Revoked', '2026-08-17 19:38:44'),
(130, 2, 42, 'Revoked', '2026-08-17 19:38:44'),
(131, 2, 1, 'Revoked', '2026-08-17 19:38:44'),
(132, 2, 2, 'Revoked', '2026-08-17 19:38:44'),
(133, 2, 3, 'Revoked', '2026-08-17 19:38:44'),
(134, 2, 4, 'Revoked', '2026-08-17 19:38:44'),
(135, 2, 5, 'Revoked', '2026-08-17 19:38:44'),
(136, 2, 6, 'Revoked', '2026-08-17 19:38:44'),
(137, 2, 7, 'Revoked', '2026-08-17 19:38:44'),
(138, 2, 8, 'Revoked', '2026-08-17 19:38:44'),
(139, 2, 9, 'Revoked', '2026-08-17 19:38:44'),
(140, 2, 10, 'Revoked', '2026-08-17 19:38:44'),
(141, 2, 11, 'Granted', '2026-08-17 19:38:44'),
(142, 2, 12, 'Revoked', '2026-08-17 19:38:44'),
(143, 2, 13, 'Revoked', '2026-08-17 19:38:44'),
(144, 2, 14, 'Revoked', '2026-08-17 19:38:44'),
(145, 2, 15, 'Revoked', '2026-08-17 19:38:44'),
(146, 2, 16, 'Revoked', '2026-08-17 19:38:44'),
(147, 2, 17, 'Revoked', '2026-08-17 19:38:44'),
(148, 2, 18, 'Revoked', '2026-08-17 19:38:44'),
(149, 2, 19, 'Revoked', '2026-08-17 19:38:44'),
(150, 2, 20, 'Revoked', '2026-08-17 19:38:44'),
(151, 2, 21, 'Revoked', '2026-08-17 19:38:44'),
(152, 2, 22, 'Revoked', '2026-08-17 19:38:44'),
(153, 2, 23, 'Revoked', '2026-08-17 19:38:44'),
(154, 2, 24, 'Revoked', '2026-08-17 19:38:44'),
(155, 2, 25, 'Revoked', '2026-08-17 19:38:44'),
(156, 2, 26, 'Revoked', '2026-08-17 19:38:44'),
(157, 2, 27, 'Revoked', '2026-08-17 19:38:44'),
(158, 2, 28, 'Revoked', '2026-08-17 19:38:44'),
(159, 2, 43, 'Revoked', '2026-08-17 19:38:44'),
(160, 2, 44, 'Revoked', '2026-08-17 19:38:44'),
(161, 2, 45, 'Revoked', '2026-08-17 19:38:44'),
(162, 2, 46, 'Revoked', '2026-08-17 19:38:44'),
(163, 2, 47, 'Revoked', '2026-08-17 19:38:44'),
(164, 2, 48, 'Revoked', '2026-08-17 19:38:44'),
(165, 2, 49, 'Revoked', '2026-08-17 19:38:44'),
(166, 2, 50, 'Revoked', '2026-08-17 19:38:44'),
(167, 2, 51, 'Revoked', '2026-08-17 19:38:44'),
(168, 2, 52, 'Revoked', '2026-08-17 19:38:44'),
(169, 2, 53, 'Revoked', '2026-08-17 19:38:44'),
(170, 2, 54, 'Revoked', '2026-08-17 19:38:44'),
(171, 2, 55, 'Revoked', '2026-08-17 19:38:44'),
(172, 2, 56, 'Revoked', '2026-08-17 19:38:44'),
(173, 2, 57, 'Revoked', '2026-08-17 19:38:44'),
(174, 2, 58, 'Revoked', '2026-08-17 19:38:44'),
(175, 1, 59, 'Granted', '2026-08-18 17:57:56'),
(176, 1, 60, 'Granted', '2026-08-18 17:57:56'),
(177, 3, 59, 'Granted', '2026-08-18 17:57:56'),
(178, 3, 60, 'Granted', '2026-08-18 17:57:56'),
(179, 4, 59, 'Granted', '2026-08-30 18:18:49'),
(180, 4, 60, 'Granted', '2026-08-30 18:18:49'),
(181, 1, 61, 'Granted', '2026-08-19 11:42:26'),
(182, 1, 62, 'Granted', '2026-08-19 11:42:26'),
(183, 3, 61, 'Granted', '2026-08-19 11:42:26'),
(184, 3, 62, 'Granted', '2026-08-19 11:42:26'),
(185, 4, 61, 'Granted', '2026-08-30 18:18:49'),
(186, 4, 62, 'Granted', '2026-08-30 18:18:49'),
(187, 1, 63, 'Granted', '2026-08-19 17:29:04'),
(188, 3, 63, 'Granted', '2026-08-19 17:29:04'),
(189, 4, 63, 'Granted', '2026-08-30 18:18:49'),
(190, 1, 64, 'Granted', '2026-08-23 12:15:52'),
(191, 1, 65, 'Granted', '2026-08-23 12:15:52'),
(192, 3, 1, 'Granted', '2026-08-23 12:15:52'),
(193, 3, 2, 'Granted', '2026-08-23 12:15:52'),
(194, 3, 3, 'Granted', '2026-08-23 12:15:52'),
(195, 3, 4, 'Granted', '2026-08-23 12:15:52'),
(196, 3, 5, 'Granted', '2026-08-23 12:15:52'),
(197, 3, 6, 'Granted', '2026-08-23 12:15:52'),
(198, 3, 7, 'Granted', '2026-08-23 12:15:52'),
(199, 3, 8, 'Granted', '2026-08-23 12:15:52'),
(200, 3, 9, 'Granted', '2026-08-23 12:15:52'),
(201, 3, 10, 'Granted', '2026-08-23 12:15:52'),
(202, 3, 11, 'Granted', '2026-08-23 12:15:52'),
(203, 3, 12, 'Granted', '2026-08-23 12:15:52'),
(204, 3, 13, 'Granted', '2026-08-23 12:15:52'),
(205, 3, 14, 'Granted', '2026-08-23 12:15:52'),
(206, 3, 15, 'Granted', '2026-08-23 12:15:52'),
(207, 3, 16, 'Granted', '2026-08-23 12:15:52'),
(208, 3, 17, 'Granted', '2026-08-23 12:15:52'),
(209, 3, 18, 'Granted', '2026-08-23 12:15:52'),
(210, 3, 19, 'Granted', '2026-08-23 12:15:52'),
(211, 3, 20, 'Granted', '2026-08-23 12:15:52'),
(212, 3, 21, 'Granted', '2026-08-23 12:15:52'),
(213, 3, 22, 'Granted', '2026-08-23 12:15:52'),
(214, 3, 23, 'Granted', '2026-08-23 12:15:52'),
(215, 3, 24, 'Granted', '2026-08-23 12:15:52'),
(216, 3, 25, 'Granted', '2026-08-23 12:15:52'),
(217, 3, 26, 'Granted', '2026-08-23 12:15:52'),
(218, 3, 27, 'Granted', '2026-08-23 12:15:52'),
(219, 3, 28, 'Granted', '2026-08-23 12:15:52'),
(220, 3, 29, 'Granted', '2026-08-23 12:15:52'),
(221, 3, 30, 'Granted', '2026-08-23 12:15:52'),
(222, 3, 31, 'Granted', '2026-08-23 12:15:52'),
(223, 3, 32, 'Granted', '2026-08-23 12:15:52'),
(224, 3, 33, 'Granted', '2026-08-23 12:15:52'),
(225, 3, 34, 'Granted', '2026-08-23 12:15:52'),
(226, 3, 35, 'Granted', '2026-08-23 12:15:52'),
(227, 3, 36, 'Granted', '2026-08-23 12:15:52'),
(228, 3, 37, 'Granted', '2026-08-23 12:15:52'),
(229, 3, 38, 'Granted', '2026-08-23 12:15:52'),
(230, 3, 39, 'Granted', '2026-08-23 12:15:52'),
(231, 3, 40, 'Granted', '2026-08-23 12:15:52'),
(232, 3, 41, 'Granted', '2026-08-23 12:15:52'),
(233, 3, 42, 'Granted', '2026-08-23 12:15:52'),
(234, 3, 43, 'Granted', '2026-08-23 12:15:52'),
(235, 3, 44, 'Granted', '2026-08-23 12:15:52'),
(236, 3, 45, 'Granted', '2026-08-23 12:15:52'),
(237, 3, 46, 'Granted', '2026-08-23 12:15:52'),
(238, 3, 47, 'Granted', '2026-08-23 12:15:52'),
(239, 3, 48, 'Granted', '2026-08-23 12:15:52'),
(240, 3, 49, 'Granted', '2026-08-23 12:15:52'),
(241, 3, 50, 'Granted', '2026-08-23 12:15:52'),
(242, 3, 51, 'Granted', '2026-08-23 12:15:52'),
(243, 3, 52, 'Granted', '2026-08-23 12:15:52'),
(244, 3, 53, 'Granted', '2026-08-23 12:15:52'),
(245, 3, 54, 'Granted', '2026-08-23 12:15:52'),
(246, 3, 55, 'Granted', '2026-08-23 12:15:52'),
(247, 3, 56, 'Granted', '2026-08-23 12:15:52'),
(248, 3, 57, 'Granted', '2026-08-23 12:15:52'),
(249, 3, 58, 'Granted', '2026-08-23 12:15:52'),
(250, 3, 64, 'Granted', '2026-08-23 12:15:52'),
(251, 3, 65, 'Granted', '2026-08-23 12:15:52'),
(252, 4, 64, 'Granted', '2026-08-30 18:18:49'),
(253, 4, 65, 'Granted', '2026-08-30 18:18:49'),
(254, 1, 66, 'Granted', '2026-08-23 12:32:42'),
(255, 3, 66, 'Granted', '2026-08-23 12:32:42'),
(256, 4, 66, 'Granted', '2026-08-30 18:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service_type`
--

CREATE TABLE `tbl_service_type` (
  `ids` int(11) NOT NULL,
  `service_type` varchar(500) DEFAULT NULL,
  `vat_perct` decimal(10,2) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_service_type`
--

INSERT INTO `tbl_service_type` (`ids`, `service_type`, `vat_perct`) VALUES
(1, 'Rental Without Driver', 10.00),
(2, 'Rental With Driver', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `ids` int(11) NOT NULL,
  `company_ids` int(11) DEFAULT NULL,
  `staff_name` varchar(1000) DEFAULT NULL,
  `staff_contact_no` varchar(500) DEFAULT NULL,
  `staff_email_id` varchar(1000) DEFAULT NULL,
  `staff_cpr_no` varchar(1000) DEFAULT NULL,
  `staff_cpr_expiry_date` date DEFAULT NULL,
  `license_no` varchar(1000) DEFAULT NULL,
  `license_issue_place` varchar(1000) DEFAULT NULL,
  `license_issue_date` date DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `staff_address` text DEFAULT NULL,
  `created_by` varchar(500) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `staff_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `staff_status` varchar(100) DEFAULT 'Active'
) ;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`ids`, `company_ids`, `staff_name`, `staff_contact_no`, `staff_email_id`, `staff_cpr_no`, `staff_cpr_expiry_date`, `license_no`, `license_issue_place`, `license_issue_date`, `license_expiry_date`, `staff_address`, `created_by`, `created_on`, `staff_documents`, `staff_status`) VALUES
(1, 1, 'Test Staff', '2132342311', 'teststaf@gmail.com', '23423423411', '2026-07-21', '23432411', 'Bahrain', '2026-07-31', '2026-08-13', 'test111', '1', '2026-07-15 00:00:00', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"ttt\\\",\\\"files\\\":[\\\"uploads\\/staffdocs\\/files\\/file_6a57a1166ddaa8.20034926.pdf\\\"]},{\\\"documentName\\\":\\\"pic\\\",\\\"files\\\":[\\\"uploads\\/staffdocs\\/webp\\/file_6a57a1990c3683.06390215.webp\\\"]}]}\"', 'Active'),
(2, 1, 'Manu', '32423', 'dsfs@wer.rty', '324535', '2026-07-16', 'fdg234', 'dsf', '2026-07-23', '2026-07-31', 'redgdf', '1', '2026-07-15 00:00:00', '\"{\\\"vehicles\\\":[]}\"', 'Active'),
(4, 1, 'ANZEL SAIT', '33661055', 'anzelabk@gmail.com', '850549558', '2027-01-01', '850549558', 'BAHRAIN', '2030-01-01', '2030-01-01', 'FASTLINK', '1', '2026-09-13 00:00:00', '\"{\\\"vehicles\\\":[]}\"', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_system_settings`
--

CREATE TABLE `tbl_system_settings` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL DEFAULT 1,
  `vat_percentage` decimal(5,2) NOT NULL DEFAULT 10.00,
  `timezone` varchar(100) NOT NULL DEFAULT 'Asia/Bahrain',
  `date_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',
  `currency_code` varchar(10) NOT NULL DEFAULT 'BHD',
  `currency_symbol` varchar(20) NOT NULL DEFAULT 'BD',
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_system_settings`
--

INSERT INTO `tbl_system_settings` (`id`, `company_id`, `vat_percentage`, `timezone`, `date_format`, `currency_code`, `currency_symbol`, `updated_at`, `updated_by`) VALUES
(1, 1, 10.00, 'Asia/Bahrain', 'd-M-Y', 'BHD', 'BD', '2026-08-19 11:27:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_terms_and_condition`
--

CREATE TABLE `tbl_terms_and_condition` (
  `ids` int(11) NOT NULL,
  `terms_condition` longtext NOT NULL,
  `t_c_name` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_terms_and_condition`
--

INSERT INTO `tbl_terms_and_condition` (`ids`, `terms_condition`, `t_c_name`, `created_at`, `status`, `company_id`, `user_id`) VALUES
(10, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', 'With Guarentee', '2026-03-02 17:57:44', 1, 1, 1),
(9, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>', 'New Terms and Condition', '2026-03-02 17:54:03', 1, 1, 1),
(11, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over </span><strong style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">100 languages, including Arabic</strong><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, </span><em style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"><u>though context-aware</u></em><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"> nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>', 'New Sample Data', '2026-03-03 01:30:07', 1, 1, 1),
(12, '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>', '111', '2026-03-15 03:12:24', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_terms_and_condition_contract`
--

CREATE TABLE `tbl_terms_and_condition_contract` (
  `ids` int(11) NOT NULL,
  `terms_condition` longtext NOT NULL,
  `t_c_name` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_terms_and_condition_contract`
--

INSERT INTO `tbl_terms_and_condition_contract` (`ids`, `terms_condition`, `t_c_name`, `created_at`, `status`, `company_id`, `user_id`, `is_default`) VALUES
(10, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', 'With Guarentee', '2026-03-02 17:57:44', 1, 1, 1, 1),
(9, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>', 'New Terms and Condition', '2026-03-02 17:54:03', 1, 1, 1, 0),
(12, '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>', '111', '2026-03-15 03:12:24', 1, 1, 1, 0),
(13, '<p>erty</p>', 'ttterty', '2026-08-29 12:09:57', 1, 1, 1, 0),
(14, '<p>yyy</p>', 'uuy', '2026-08-29 12:11:40', 1, 1, 1, 0),
(16, '<p>The above lease ratesssss are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>', '111', '2026-08-29 12:24:12', 1, 1, 1, 0),
(17, '<p>tttestttt ggg</p>', 'testttt gg', '2026-08-29 12:24:29', 1, 1, 1, 0),
(18, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabics can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>', 'New Terms and Condition', '2026-09-02 10:09:45', 1, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `profile_name` varchar(500) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_passkey` varchar(100) DEFAULT NULL,
  `user_role_id` varchar(100) DEFAULT NULL,
  `user_role_name` varchar(255) DEFAULT NULL,
  `company_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `user_mobile` varchar(100) DEFAULT NULL,
  `user_email` varchar(500) DEFAULT NULL,
  `profile_image` varchar(1000) NOT NULL DEFAULT 'profile.jpg',
  `user_status` varchar(50) DEFAULT 'Active',
  `created_date` date NOT NULL
) ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `profile_name`, `user_name`, `user_passkey`, `user_role_id`, `user_role_name`, `company_json`, `user_mobile`, `user_email`, `profile_image`, `user_status`, `created_date`) VALUES
(1, 'Administrator', 'admin', 'passme', '1', 'Administrator', '[{\"ids\":\"1\",\"company_name\":\"Fast Link\"}]', '12345123', 'admin123@gmail.com', 'user_6a6622c528a7d2.68109295.jpg', 'Active', '2026-03-17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_permissions`
--

CREATE TABLE `tbl_user_permissions` (
  `ids` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Granted',
  `updated_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_permissions`
--

INSERT INTO `tbl_user_permissions` (`ids`, `user_id`, `permission_id`, `status`, `updated_date`) VALUES
(1, 1, 29, 'Granted', '2026-08-17 17:46:17'),
(2, 1, 30, 'Granted', '2026-08-17 17:46:17'),
(3, 1, 31, 'Granted', '2026-08-17 17:46:17'),
(4, 1, 32, 'Granted', '2026-08-17 17:46:17'),
(5, 1, 33, 'Granted', '2026-08-17 17:46:17'),
(6, 1, 34, 'Granted', '2026-08-17 17:46:17'),
(7, 1, 35, 'Granted', '2026-08-17 17:46:17'),
(8, 1, 36, 'Granted', '2026-08-17 17:46:18'),
(9, 1, 37, 'Granted', '2026-08-17 17:46:18'),
(10, 1, 38, 'Granted', '2026-08-17 17:46:18'),
(11, 1, 39, 'Granted', '2026-08-17 17:46:18'),
(12, 1, 40, 'Granted', '2026-08-17 17:46:18'),
(13, 1, 41, 'Granted', '2026-08-17 17:46:18'),
(14, 1, 42, 'Granted', '2026-08-17 17:46:18'),
(15, 1, 1, 'Granted', '2026-08-17 17:46:18'),
(16, 1, 2, 'Granted', '2026-08-17 17:46:18'),
(17, 1, 3, 'Granted', '2026-08-17 17:46:18'),
(18, 1, 4, 'Granted', '2026-08-17 17:46:18'),
(19, 1, 5, 'Granted', '2026-08-17 17:46:18'),
(20, 1, 6, 'Granted', '2026-08-17 17:46:18'),
(21, 1, 7, 'Granted', '2026-08-17 17:46:18'),
(22, 1, 8, 'Granted', '2026-08-17 17:46:18'),
(23, 1, 9, 'Granted', '2026-08-17 17:46:18'),
(24, 1, 10, 'Granted', '2026-08-17 17:46:18'),
(25, 1, 11, 'Granted', '2026-08-17 17:46:18'),
(26, 1, 12, 'Granted', '2026-08-17 17:46:18'),
(27, 1, 13, 'Granted', '2026-08-17 17:46:18'),
(28, 1, 14, 'Granted', '2026-08-17 17:46:18'),
(29, 1, 15, 'Granted', '2026-08-17 17:46:18'),
(30, 1, 16, 'Granted', '2026-08-17 17:46:18'),
(31, 1, 17, 'Granted', '2026-08-17 17:46:18'),
(32, 1, 18, 'Granted', '2026-08-17 17:46:18'),
(33, 1, 19, 'Granted', '2026-08-17 17:46:18'),
(34, 1, 20, 'Granted', '2026-08-17 17:46:18'),
(35, 1, 21, 'Granted', '2026-08-17 17:46:18'),
(36, 1, 22, 'Granted', '2026-08-17 17:46:18'),
(37, 1, 23, 'Granted', '2026-08-17 17:46:18'),
(38, 1, 24, 'Granted', '2026-08-17 17:46:18'),
(39, 1, 25, 'Granted', '2026-08-17 17:46:18'),
(40, 1, 26, 'Granted', '2026-08-17 17:46:18'),
(41, 1, 27, 'Granted', '2026-08-17 17:46:18'),
(42, 1, 28, 'Granted', '2026-08-17 17:46:18'),
(43, 1, 43, 'Granted', '2026-08-17 17:46:18'),
(44, 1, 44, 'Granted', '2026-08-17 17:46:18'),
(45, 1, 45, 'Granted', '2026-08-17 17:46:18'),
(46, 1, 46, 'Granted', '2026-08-17 17:46:18'),
(47, 1, 47, 'Granted', '2026-08-17 17:46:18'),
(48, 1, 48, 'Granted', '2026-08-17 17:46:18'),
(49, 1, 49, 'Granted', '2026-08-17 17:46:18'),
(50, 1, 50, 'Granted', '2026-08-17 17:46:18'),
(51, 1, 51, 'Granted', '2026-08-17 17:46:18'),
(52, 1, 52, 'Granted', '2026-08-17 17:46:18'),
(53, 1, 53, 'Granted', '2026-08-17 17:46:18'),
(54, 1, 54, 'Granted', '2026-08-17 17:46:18'),
(55, 1, 55, 'Granted', '2026-08-17 17:46:18'),
(56, 1, 56, 'Granted', '2026-08-17 17:46:18'),
(57, 1, 57, 'Granted', '2026-08-17 17:46:18'),
(58, 1, 58, 'Granted', '2026-08-17 17:46:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicles`
--

CREATE TABLE `tbl_vehicles` (
  `ids` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_names` varchar(1000) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `vehicle_number` varchar(100) NOT NULL,
  `chassis_number` varchar(100) DEFAULT NULL,
  `vehicle_year` int(11) NOT NULL,
  `vehicle_color` varchar(100) NOT NULL,
  `image_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `other_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_status` varchar(100) NOT NULL,
  `is_outsourced` enum('Yes','No') DEFAULT 'No',
  `outsourcing_company_id` int(11) DEFAULT 0,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `vehicle_purchase_date` date NOT NULL,
  `next_passing_date` date DEFAULT NULL,
  `passing_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `next_insurance_date` date DEFAULT NULL,
  `insurance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `next_maintenance_date` date DEFAULT NULL,
  `maintenance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicle_status_notes` text DEFAULT NULL,
  `vehicle_status_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Dumping data for table `tbl_vehicles`
--

INSERT INTO `tbl_vehicles` (`ids`, `category_id`, `model_id`, `model_names`, `brand_id`, `company_id`, `vehicle_number`, `chassis_number`, `vehicle_year`, `vehicle_color`, `image_json`, `other_details_json`, `vehicle_attachments`, `vehicle_status`, `is_outsourced`, `outsourcing_company_id`, `created_on`, `created_by`, `vehicle_purchase_date`, `next_passing_date`, `passing_histroy`, `next_insurance_date`, `insurance_histroy`, `next_maintenance_date`, `maintenance_histroy`, `rentout_log_json`, `vehicle_status_notes`, `vehicle_status_log_json`) VALUES
(1, 21, 92, 'KAIYI   X3', 28, 1, '145521', '123123', 2024, 'RED', '[]', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"DELIVERY DATE 01-07-2024\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":5500}', '{\"vehicles\":[{\"documentName\":\"OWNERSHIP AND INSURANCE\",\"files\":[\"uploads\\/rentedcars\\/files\\/file_6aa684c8e9ae16.27142077.pdf\"]}]}', 'Parking', 'No', 0, '2026-09-13 00:00:00', 1, '2024-03-06', '2027-06-30', '[{\"id\":\"6aa69c1ae006d\",\"date\":\"2027-06-30\",\"amount\":\"\",\"remarks\":\"\",\"attachment\":\"\\/uploads\\/vehicles\\/documents\\/1789303834_145521.pdf\",\"created_at\":\"2026-09-13 15:50:34\",\"created_by\":1}]', '2027-06-30', '[{\"id\":\"6aa69c3c9ccaa\",\"date\":\"2027-06-30\",\"amount\":\"132\",\"remarks\":\"\",\"attachment\":\"\\/uploads\\/vehicles\\/documents\\/1789303868_145521.pdf\",\"created_at\":\"2026-09-13 15:51:08\",\"created_by\":1}]', NULL, NULL, '{\"user_id\":1,\"datetime\":\"2026-09-22 11:33:09\"}', 'test', '{\"user_id\":1,\"datetime\":\"2026-09-22 11:35:37\"}'),
(6, 21, 94, 'CHERRY  TIGGO 2', 29, 1, '278613', 'LVVDB21B5NE023085', 2022, 'WHITE', '[]', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":5500}', '{\"vehicles\":[]}', 'Rentout', 'No', 0, '2026-09-22 00:00:00', 1, '2022-01-03', '2027-03-30', '[{\"id\":\"1790058378636_0.06951182979051485\",\"added_info\":\"PASSING\",\"next_date\":\"2027-03-30\",\"done_date\":\"2026-03-30\",\"remarks\":\"3 MONTHS \",\"documents\":[]}]', '2027-03-30', '[{\"id\":\"1790058563299_0.9282708408287489\",\"added_info\":\"INSURANCE\",\"next_date\":\"2027-03-30\",\"done_date\":\"2026-03-30\",\"remarks\":\"1 MONTH\",\"documents\":[]}]', NULL, NULL, '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', NULL, NULL),
(7, 1, 2, 'NISSAN SUNNY', 1, 1, '123456', '123654', 2023, 'b', '[]', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":2000}', '{\"vehicles\":[]}', 'Rentout', 'No', 0, '2026-10-14 00:00:00', 1, '2026-10-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 2, 95, 'MG MG5', 9, 1, '409572', '275904', 2022, 'GRAY', '[]', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":4500}', '{\"vehicles\":[]}', 'Available', 'No', 0, '2026-11-09 00:00:00', 1, '2022-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 21, 96, 'HAVAL JOLLION', 31, 1, '692197', '791296', 2025, 'WHITE', '[]', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":6500}', '{\"vehicles\":[]}', 'Available', 'No', 0, '2026-11-09 00:00:00', 1, '2025-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_bookings`
--

CREATE TABLE `tbl_vehicle_bookings` (
  `ids` int(11) NOT NULL,
  `booking_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `model_name` varchar(100) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `book_through` varchar(100) DEFAULT NULL,
  `quotation_number` varchar(100) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `book_from_date` datetime NOT NULL,
  `book_to_date` datetime DEFAULT NULL,
  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `book_status` varchar(100) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_brand`
--

CREATE TABLE `tbl_vehicle_brand` (
  `ids` int(11) NOT NULL,
  `brand_name` varchar(200) DEFAULT NULL,
  `brand_description` text DEFAULT NULL,
  `brand_status` varchar(100) DEFAULT 'Active',
  `brand_image` varchar(500) DEFAULT 'default.jpg'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_brand`
--

INSERT INTO `tbl_vehicle_brand` (`ids`, `brand_name`, `brand_description`, `brand_status`, `brand_image`) VALUES
(1, 'NISSAN', NULL, 'Active', 'default.jpg'),
(2, 'CHANGAN', NULL, 'Active', 'default.jpg'),
(3, 'HONDA', NULL, 'Active', 'default.jpg'),
(4, 'HYUNDAI', NULL, 'Active', 'default.jpg'),
(5, 'KIA', NULL, 'Active', 'default.jpg'),
(6, 'MITSUBISHI', NULL, 'Active', 'default.jpg'),
(7, 'TOYOTA', NULL, 'Active', 'default.jpg'),
(8, 'MAZDA', NULL, 'Active', 'default.jpg'),
(9, 'MG', NULL, 'Active', 'default.jpg'),
(10, 'SUZUKI', NULL, 'Active', 'default.jpg'),
(11, 'AUDI', NULL, 'Active', 'default.jpg'),
(12, 'BMW', NULL, 'Active', 'default.jpg'),
(13, 'LEXUS', NULL, 'Active', 'default.jpg'),
(14, 'MERCEDES BENZ', NULL, 'Active', 'default.jpg'),
(15, 'FORD', NULL, 'Active', 'default.jpg'),
(16, 'GMC', NULL, 'Active', 'default.jpg'),
(17, 'CHEVROLET', NULL, 'Active', 'default.jpg'),
(18, 'JEEP', NULL, 'Active', 'default.jpg'),
(19, 'LAND ROVER', NULL, 'Active', 'default.jpg'),
(20, 'VOLKSWAGEN', NULL, 'Active', 'default.jpg'),
(21, 'MINI COOPER', '', 'Active', '69da64c443675.jpg'),
(22, 'ISUZU', '', 'Active', 'default.jpg'),
(28, 'KAIYI ', '', 'Active', 'default.jpg'),
(29, 'CHERRY ', '', 'Active', 'default.jpg'),
(30, 'MG5', 'SEDAN', 'Active', 'default.jpg'),
(31, 'HAVAL', 'SUV TYPE', 'Active', 'default.jpg'),
(32, 'HAVAL', 'HAVAL JOLLION', 'Active', 'default.jpg'),
(33, 'BAIC', 'SMALL TYPE', 'Active', 'default.jpg'),
(34, 'BAIC', 'SEDAN', 'Active', 'default.jpg'),
(35, 'BAIC', 'SMALL ', 'Active', 'default.jpg'),
(36, 'BAIC', 'SEDAN', 'Active', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_category`
--

CREATE TABLE `tbl_vehicle_category` (
  `ids` int(11) NOT NULL,
  `category_name` varchar(200) DEFAULT NULL,
  `category_image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `category_description` text NOT NULL,
  `category_status` varchar(50) NOT NULL DEFAULT 'Active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_category`
--

INSERT INTO `tbl_vehicle_category` (`ids`, `category_name`, `category_image`, `category_description`, `category_status`) VALUES
(1, 'SMALL CARS', 'small_car.jpg', 'Compact and fuel-efficient vehicles, ideal for city driving and short trips.', 'Active'),
(2, 'MEDIUM CARS', 'medium_car.jpg', 'Comfortable mid-size cars suitable for daily use, business travel, and small families.', 'Active'),
(3, 'MEDIUM SUV CARS', 'medium_suv.jpg', 'Spacious and versatile vehicles with higher ground clearance, perfect for family trips and mixed road conditions.', 'Active'),
(4, 'LEXURY SEDAN', 'luxury_sedan.jpg', 'Premium vehicles offering superior comfort, advanced features, and a smooth driving experience.', 'Active'),
(5, 'SUV', 'SUV.jpg', 'Large and powerful vehicles designed for space, comfort, and performance on all types of terrain.', 'Active'),
(6, 'LUGGAGE VAN', 'luggage_van.jpg', 'Specially designed vans for transporting luggage and cargo, ideal for airport transfers and logistics.', 'Active'),
(7, 'MINIBUS ', 'mini_bus.jpg', 'Compact buses that can carry small groups, suitable for tours, staff transport, and events.', 'Active'),
(8, 'PICKUP', 'pickup.jpg', 'Utility vehicles with an open cargo bed, ideal for transporting goods and light commercial use.', 'Active'),
(9, 'HATCHBACK', 'hatchback.jpg', 'Small cars with a rear door opening upwards, offering compact size with flexible storage space.', 'Active'),
(10, 'MID BUS', 'mid_bus.jpg', 'Medium-capacity buses designed for group travel, offering more seating than minibuses with added comfort.', 'Active'),
(11, 'VAN', 'van.jpg', 'Multi-purpose vehicles used for both passenger transport and cargo, suitable for business or family use.', 'Active'),
(12, 'SIX WHEEL / FLAT BED  / TOWING', 'default.jpg', 'Heavy-duty vehicles designed for transporting large loads, equipment, or towing other vehicles.', 'Active'),
(19, 'NISSAN SUNNY', 'default.jpg', 'SMALL', 'Active'),
(20, 'NISSAN SUNNY', 'default.jpg', 'SMALL CAR', 'Active'),
(21, 'COMPACT SUV', 'default.jpg', '1.5', 'Active'),
(22, 'CHERRY', 'default.jpg', 'COMPACT SUV', 'Active'),
(23, 'MG -5', 'default.jpg', 'SEDAN', 'Active'),
(24, 'MG5', 'default.jpg', 'SALOON SEDAN', 'Active'),
(25, 'COMPACT SUV', 'default.jpg', 'SUV ', 'Active'),
(26, 'SUV', 'default.jpg', 'SMALL SUV', 'Active'),
(27, 'SEDAN', 'default.jpg', 'SMALL TYPE', 'Active'),
(28, 'SMALL CARS', 'default.jpg', 'SEDAN', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_contract_extensions`
--

CREATE TABLE `tbl_vehicle_contract_extensions` (
  `ids` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `agreement_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `extension_date` date DEFAULT NULL,
  `extend_start_date` datetime DEFAULT NULL,
  `extend_end_date` datetime DEFAULT NULL,
  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_contract_replacement`
--

CREATE TABLE `tbl_vehicle_contract_replacement` (
  `ids` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `agreement_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `extension_date` date DEFAULT NULL,
  `extend_start_date` datetime DEFAULT NULL,
  `extend_end_date` datetime DEFAULT NULL,
  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_log_movement`
--

CREATE TABLE `tbl_vehicle_log_movement` (
  `ids` int(11) NOT NULL,
  `vehicle_ids` int(11) NOT NULL,
  `vehicle_no` varchar(50) NOT NULL,
  `log_datetime` datetime NOT NULL,
  `action_type` varchar(50) NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `reference_type` varchar(50) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `reference_no` varchar(100) DEFAULT NULL,
  `location_from` varchar(100) DEFAULT NULL,
  `location_to` varchar(100) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `customer_id` varchar(100) DEFAULT NULL,
  `garage_id` int(11) DEFAULT NULL,
  `odometer` int(11) DEFAULT NULL,
  `fuel_level` varchar(30) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_name` varchar(100) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_log_movement`
--

INSERT INTO `tbl_vehicle_log_movement` (`ids`, `vehicle_ids`, `vehicle_no`, `log_datetime`, `action_type`, `old_status`, `new_status`, `reference_type`, `reference_id`, `reference_no`, `location_from`, `location_to`, `staff_id`, `customer_id`, `garage_id`, `odometer`, `fuel_level`, `remarks`, `created_by`, `created_name`, `created_on`) VALUES
(1, 6, '278613', '2026-09-22 11:40:57', 'Vehicle Added', NULL, 'Available', 'Vehicle', 6, '278613', NULL, 'Main Parking', NULL, NULL, NULL, NULL, NULL, 'New vehicle registered into the system.', 1, 'Administrator', '2026-09-22 06:10:57'),
(2, 1, '145521', '2026-09-22 14:00:15', 'Rentout', NULL, NULL, 'Direct Contract', 2, 'FL/AGR/2026/0002', NULL, NULL, NULL, 'C0006', NULL, 3423, 'full', NULL, 1, 'System', '2026-09-22 08:30:15'),
(3, 1, '145521', '2026-09-22 14:03:09', 'Rentout', 'Rentout', 'Rentout', 'Agreement', 1, 'FL/AGR/2026/0001', 'Main Parking', 'Customer', NULL, 'C0002', NULL, 32423, 'full', 'Vehicle rented out under Agreement No. FL/AGR/2026/0001', 1, 'Administrator', '2026-09-22 08:33:09'),
(4, 1, '145521', '2026-09-22 14:03:58', 'Return', 'Rentout', 'Parking', 'Agreement', 1, 'FL/AGR/2026/0001', 'Customer', 'Main Parking', NULL, NULL, NULL, 222222, NULL, 'Vehicle returned under Agreement No. FL/AGR/2026/0001', 1, 'Administrator', '2026-09-22 08:33:58'),
(5, 1, '145521', '2026-09-22 14:05:17', 'Return', 'Parking', 'Parking', 'Agreement', 2, 'FL/AGR/2026/0002', 'Customer', 'Main Parking', NULL, NULL, NULL, 89889, NULL, 'Vehicle returned under Agreement No. FL/AGR/2026/0002', 1, 'Administrator', '2026-09-22 08:35:17'),
(6, 7, '123456', '2026-10-14 12:58:46', 'Vehicle Added', NULL, 'Available', 'Vehicle', 7, '123456', NULL, 'Main Parking', NULL, NULL, NULL, NULL, NULL, 'New vehicle registered into the system.', 1, 'Administrator', '2026-10-14 07:28:46'),
(7, 7, '123456', '2026-10-14 13:37:46', 'Rentout', NULL, NULL, 'Direct Contract', 4, 'FL/AGR/2026/0004', NULL, NULL, NULL, 'C0008', NULL, 20000, '50%', NULL, 1, 'System', '2026-10-14 08:07:46'),
(8, 1, '145521', '2026-10-15 13:02:09', 'Rentout', NULL, NULL, 'Direct Contract', 5, 'FL/AGR/2026/0005', NULL, NULL, NULL, 'C0006', NULL, 1200, 'full', NULL, 1, 'System', '2026-10-15 07:32:09'),
(9, 1, '145521', '2026-10-15 13:03:42', 'Return', 'Rentout', 'Parking', 'Agreement', 5, 'FL/AGR/2026/0005', 'Customer', 'Main Parking', NULL, NULL, NULL, 1300, NULL, 'Vehicle returned under Agreement No. FL/AGR/2026/0005', 1, 'Administrator', '2026-10-15 07:33:42'),
(10, 6, '278613', '2026-11-02 15:25:04', 'Rentout', 'Available', 'Rentout', 'Agreement', 6, 'FL/AGR/2026/0006', 'Main Parking', 'Customer', NULL, 'C0012', NULL, 75000, '2', 'Vehicle rented out under Agreement No. FL/AGR/2026/0006', 1, 'Administrator', '2026-11-02 09:55:04'),
(11, 8, '409572', '2026-11-09 15:50:48', 'Vehicle Added', NULL, 'Available', 'Vehicle', 8, '409572', NULL, 'Main Parking', NULL, NULL, NULL, NULL, NULL, 'New vehicle registered into the system.', 1, 'Administrator', '2026-11-09 10:20:48'),
(12, 9, '692197', '2026-11-09 16:16:11', 'Vehicle Added', NULL, 'Available', 'Vehicle', 9, '692197', NULL, 'Main Parking', NULL, NULL, NULL, NULL, NULL, 'New vehicle registered into the system.', 1, 'Administrator', '2026-11-09 10:46:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_model`
--

CREATE TABLE `tbl_vehicle_model` (
  `ids` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `modal_name` varchar(200) DEFAULT NULL,
  `vehicle_modal_pic` varchar(2000) NOT NULL DEFAULT 'default.jpg',
  `model_status` varchar(100) DEFAULT 'Active',
  `model_description` text DEFAULT NULL,
  `price_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL
) ;

--
-- Dumping data for table `tbl_vehicle_model`
--

INSERT INTO `tbl_vehicle_model` (`ids`, `category_id`, `brand_id`, `modal_name`, `vehicle_modal_pic`, `model_status`, `model_description`, `price_json`) VALUES
(1, 1, 1, 'MICRA', 'micra.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"5\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"5\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"6\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"5\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"5\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"5\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"5\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5\"}]'),
(2, 1, 1, 'SUNNY', 'sunny.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"10\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"11\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"12\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"13\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"14\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"15\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"16\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"17\"},{\"ids\":\"12\",\"item\":\"Delay Fine\",\"amount\":\"5\"},{\"ids\":\"13\",\"item\":\"10\",\"amount\":\"\"}]'),
(3, 1, 2, 'ALSVIN', 'alsvin.jpg', 'Active', NULL, NULL),
(4, 1, 3, 'CITY', 'city.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"10\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"12\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"14\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"15\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"10\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"14\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"15\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"20\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"\"},{\"ids\":\"10\",\"item\":\"test\",\"amount\":\"\"},{\"ids\":\"11\",\"item\":\"123\",\"amount\":\"\"}]'),
(5, 1, 4, 'ACCENT', 'accent.jpg', 'Active', NULL, NULL),
(6, 1, 5, 'PEGAS', 'pegas.jpg', 'Active', NULL, NULL),
(7, 1, 6, 'LANCER', 'lancer.jpg', 'Active', NULL, NULL),
(8, 1, 7, 'YARIS', 'default.jpg', 'Active', NULL, NULL),
(9, 1, 7, 'COROLLA ', 'default.jpg', 'Active', NULL, NULL),
(10, 2, 1, 'ALTIMA ', 'default.jpg', 'Active', NULL, NULL),
(11, 2, 1, 'MAXIMA ', 'default.jpg', 'Active', NULL, NULL),
(12, 2, 7, 'CAMRY', 'default.jpg', 'Active', NULL, NULL),
(13, 2, 7, 'AVALON', 'default.jpg', 'Active', NULL, NULL),
(14, 2, 4, 'ELENTRA', 'default.jpg', 'Active', NULL, NULL),
(15, 2, 5, 'OPTIMA ', 'default.jpg', 'Active', NULL, NULL),
(16, 2, 5, 'K5', 'default.jpg', 'Active', NULL, NULL),
(17, 2, 7, 'CROWN', 'default.jpg', 'Active', NULL, NULL),
(18, 3, 1, 'KICKS', 'default.jpg', 'Active', NULL, NULL),
(19, 3, 1, 'MAGNITE', 'default.jpg', 'Active', NULL, NULL),
(20, 3, 7, 'COROLLA CROSS', 'default.jpg', 'Active', NULL, NULL),
(21, 3, 7, 'RAIZE', 'default.jpg', 'Active', NULL, NULL),
(22, 3, 7, 'RUSH', 'default.jpg', 'Active', NULL, NULL),
(23, 3, 7, 'VELOZ', 'default.jpg', 'Active', NULL, NULL),
(24, 3, 7, 'URBAN CRUISER', 'default.jpg', 'Active', NULL, NULL),
(25, 3, 7, 'RAV4', 'default.jpg', 'Active', NULL, NULL),
(26, 3, 8, 'CX9', 'default.jpg', 'Active', NULL, NULL),
(27, 3, 9, 'RX5', 'default.jpg', 'Active', NULL, NULL),
(28, 3, 9, 'ZS11', 'default.jpg', 'Active', NULL, NULL),
(29, 3, 9, 'RX8', 'default.jpg', 'Active', NULL, NULL),
(30, 3, 9, 'RX9', 'default.jpg', 'Active', NULL, NULL),
(31, 3, 10, 'JIMNY', 'default.jpg', 'Active', NULL, NULL),
(32, 4, 11, 'A3', 'default.jpg', 'Active', NULL, NULL),
(33, 4, 11, 'A4', 'default.jpg', 'Active', NULL, NULL),
(34, 4, 11, 'A6', 'default.jpg', 'Active', NULL, NULL),
(35, 4, 11, 'A8', 'default.jpg', 'Active', NULL, NULL),
(36, 4, 12, '5 SERIES', 'default.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"342\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"45\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"9.253\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"8\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"7\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"8\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"3\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5.485\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"11\"},{\"ids\":\"10\",\"item\":\"test\",\"amount\":\"14\"},{\"ids\":\"11\",\"item\":\"123\",\"amount\":\"12\"}]'),
(37, 4, 12, '7 SERIES', 'default.jpg', 'Active', NULL, NULL),
(38, 4, 13, 'ES350', 'default.jpg', 'Active', NULL, NULL),
(39, 4, 13, 'LS500', 'default.jpg', 'Active', NULL, NULL),
(40, 4, 13, 'LS350', 'default.jpg', 'Active', NULL, NULL),
(41, 4, 14, 'A-CLASS', 'default.jpg', 'Active', NULL, '[{\"ids\":null,\"item\":\"\",\"amount\":\"34\"},{\"ids\":null,\"item\":\"\",\"amount\":\"43\"},{\"ids\":null,\"item\":\"\",\"amount\":\"567\"},{\"ids\":null,\"item\":\"\",\"amount\":\"657\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"}]'),
(42, 4, 14, 'C-CLASS', 'default.jpg', 'Active', NULL, NULL),
(43, 4, 14, 'E-CLASS', 'default.jpg', 'Active', NULL, NULL),
(44, 4, 14, 'S-CLASS', 'default.jpg', 'Active', NULL, NULL),
(45, 4, 14, 'MAYBACH S CLASS', 'default.jpg', 'Active', NULL, NULL),
(46, 4, 14, 'EQS', 'default.jpg', 'Active', NULL, NULL),
(47, 5, 1, 'PATROL', 'default.jpg', 'Active', NULL, NULL),
(48, 5, 1, 'PATHFINDER', 'default.jpg', 'Active', NULL, NULL),
(49, 5, 1, 'X- TERRA', 'default.jpg', 'Active', NULL, NULL),
(50, 5, 1, 'X-TRAIL', 'default.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"4\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"4\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"25\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"25\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"150\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"150\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"350\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"350\"},{\"ids\":\"12\",\"item\":\"Delay Fine\",\"amount\":\"25\"},{\"ids\":\"13\",\"item\":\"10\",\"amount\":\"\"}]'),
(51, 5, 14, 'G -CLASS', 'default.jpg', 'Active', NULL, NULL),
(52, 5, 7, 'FORTUNER', 'default.jpg', 'Active', NULL, NULL),
(53, 5, 7, 'SEQUOIA', 'default.jpg', 'Active', NULL, NULL),
(54, 5, 7, 'HIGHLANDER', 'default.jpg', 'Active', NULL, NULL),
(55, 5, 7, 'LAND CRUISER PRADO', 'default.jpg', 'Active', NULL, NULL),
(56, 5, 7, 'LAND CRUISER ', 'default.jpg', 'Active', NULL, NULL),
(57, 5, 15, 'TERRITORY', 'default.jpg', 'Active', NULL, NULL),
(58, 5, 15, 'BRONCO', 'default.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour without driver\",\"amount\":\"\"},{\"ids\":\"2\",\"item\":\"Price per hour with driver\",\"amount\":\"\"},{\"ids\":\"3\",\"item\":\"Price per day without driver\",\"amount\":\"\"},{\"ids\":\"4\",\"item\":\"Price per day with driver\",\"amount\":\"\"},{\"ids\":\"5\",\"item\":\"Price per week without driver\",\"amount\":\"\"},{\"ids\":\"6\",\"item\":\"Price per week with driver\",\"amount\":\"8\"},{\"ids\":\"7\",\"item\":\"Price per month without driver\",\"amount\":\"\"},{\"ids\":\"8\",\"item\":\"Price per month with driver\",\"amount\":\"8\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"5\"}]'),
(59, 5, 15, 'EXPEDITION', 'default.jpg', 'Active', NULL, NULL),
(60, 5, 16, 'YUKON', 'default.jpg', 'Active', NULL, NULL),
(61, 5, 17, 'TAHOE', 'default.jpg', 'Active', NULL, NULL),
(62, 5, 18, 'WRENGLER', 'default.jpg', 'Active', NULL, NULL),
(63, 5, 18, 'Grand Cherokee ', 'default.jpg', 'Active', NULL, NULL),
(64, 5, 13, 'RX350', 'default.jpg', 'Active', NULL, NULL),
(65, 5, 13, 'LX 600', 'default.jpg', 'Active', NULL, NULL),
(66, 5, 13, 'LX 700', 'default.jpg', 'Active', NULL, NULL),
(67, 5, 19, 'DEFENDER', 'default.jpg', 'Active', NULL, NULL),
(68, 5, 19, 'Range Rover Sport', 'default.jpg', 'Active', NULL, NULL),
(69, 5, 19, 'Range Rover Velar', 'default.jpg', 'Active', NULL, NULL),
(70, 5, 19, 'Range Rover Evoque', 'default.jpg', 'Active', NULL, NULL),
(71, 5, 19, 'Discovery', 'default.jpg', 'Active', NULL, NULL),
(72, 5, 20, 'TERAMOUNT', 'default.jpg', 'Active', NULL, NULL),
(73, 6, 7, 'HIACE CARGO ', 'default.jpg', 'Active', NULL, NULL),
(74, 6, 1, 'URVAN CAGRO', 'default.jpg', 'Active', NULL, NULL),
(75, 7, 7, 'HIACE', 'default.jpg', 'Active', NULL, NULL),
(76, 7, 1, 'URVAN', 'default.jpg', 'Active', NULL, NULL),
(77, 8, 7, 'HILUX', 'default.jpg', 'Active', NULL, NULL),
(78, 9, 21, 'CONVERTIBLE', 'default.jpg', 'Active', NULL, NULL),
(79, 9, 21, 'COUNTRYMAN', 'default.jpg', 'Active', NULL, NULL),
(80, 9, 21, 'COOPER -S', 'default.jpg', 'Active', NULL, NULL),
(81, 10, 7, 'COASTER', 'default.jpg', 'Active', NULL, NULL),
(82, 11, 14, 'VITO', 'default.jpg', 'Active', NULL, NULL),
(83, 11, 14, 'VIANO', 'default.jpg', 'Active', NULL, NULL),
(84, 11, 14, 'SPRINTER', 'default.jpg', 'Active', NULL, NULL),
(85, 12, 22, 'NPR', 'default.jpg', 'Active', NULL, NULL),
(86, 12, 22, 'NPR DOUBLE CABIN', 'default.jpg', 'Active', NULL, NULL),
(91, 19, 1, '2025', 'default.jpg', 'Active', '216175', NULL),
(92, 21, 28, ' X3', 'default.jpg', 'Active', '1.5', '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"0.000\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"0.000\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"6.000\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"0.000\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"0.000\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"0.000\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"0.000\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"0.000\"}]'),
(94, 21, 29, 'TIGGO 2', 'default.jpg', 'Active', '2022', NULL),
(95, 2, 9, 'MG5', 'default.jpg', 'Active', 'SEDAN', NULL),
(96, 21, 31, 'JOLLION', 'default.jpg', 'Active', 'COMPACT SUV', NULL),
(97, 1, 33, 'U5P', 'default.jpg', 'Active', 'SEDAN', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_non_revenue_ticket`
--

CREATE TABLE `tbl_vehicle_non_revenue_ticket` (
  `ids` int(11) NOT NULL,
  `booking_no` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `model_name` varchar(100) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `staff_ids` int(11) DEFAULT NULL,
  `staff_name` varchar(500) DEFAULT NULL,
  `staff_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `book_from_date` datetime NOT NULL,
  `book_to_date` datetime DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `book_status` varchar(100) DEFAULT NULL,
  `return_notes` text DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_id` int(11) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_pricing_master`
--

CREATE TABLE `tbl_vehicle_pricing_master` (
  `ids` int(11) NOT NULL,
  `price_item` varchar(1000) DEFAULT NULL,
  `price_status` varchar(100) DEFAULT 'Active',
  `ledger_status` varchar(50) NOT NULL DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_pricing_master`
--

INSERT INTO `tbl_vehicle_pricing_master` (`ids`, `price_item`, `price_status`, `ledger_status`) VALUES
(1, 'Price per hour rental without driver', 'Active', 'No'),
(2, 'Price per hour rental with driver', 'Active', 'No'),
(3, 'Price per day rental without driver', 'Active', 'No'),
(4, 'Price per day rental with driver', 'Active', 'No'),
(5, 'Price per week rental without driver', 'Active', 'No'),
(6, 'Price per week rental with driver', 'Active', 'No'),
(7, 'Price per month rental without driver', 'Active', 'No'),
(8, 'Price per month rental with driver', 'Active', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_rentout_contracts`
--

CREATE TABLE `tbl_vehicle_rentout_contracts` (
  `ids` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(100) DEFAULT NULL,
  `agreement_group_ref_no` varchar(100) DEFAULT NULL,
  `agreement_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `quotation_number` varchar(200) NOT NULL,
  `vehicle_category_id` int(11) DEFAULT NULL,
  `vehicle_model_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `vechile_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `service_type` varchar(100) DEFAULT NULL,
  `service_start_date_time` datetime DEFAULT NULL,
  `service_end_date_time` datetime DEFAULT NULL,
  `contract_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `km_in` decimal(18,3) DEFAULT NULL,
  `km_out` decimal(18,3) DEFAULT NULL,
  `km_used` decimal(18,3) DEFAULT NULL,
  `vehicle_accessories_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `extend_date` date DEFAULT NULL,
  `lease_period` int(11) DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `remarks1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `remarks2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `terms_condition` longtext DEFAULT NULL,
  `vehicle_rentout_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `driver_status` varchar(100) DEFAULT NULL,
  `driver_ids` int(11) DEFAULT NULL,
  `driver_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `customer_driver_name` varchar(1000) DEFAULT NULL,
  `customer_driver_contact_number` varchar(100) DEFAULT NULL,
  `customer_driver_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `received_by` varchar(200) DEFAULT NULL,
  `delivered_by` varchar(200) DEFAULT NULL,
  `hirer_signature` varchar(2000) DEFAULT NULL,
  `hirer_name` varchar(1000) DEFAULT NULL,
  `hirer_signature_date` datetime DEFAULT NULL,
  `hier_signature_status` varchar(20) DEFAULT 'No',
  `hirer_signed_ip` varchar(200) DEFAULT NULL,
  `hirer_signed_device` varchar(200) DEFAULT NULL,
  `delivered_signature_status` varchar(100) DEFAULT 'No',
  `delivered_signature` varchar(2000) DEFAULT NULL,
  `delivered_signatory` varchar(1000) DEFAULT NULL,
  `delivered_signature_date` datetime DEFAULT NULL,
  `delivered_signed_ip` varchar(200) DEFAULT NULL,
  `delivered_signed_device` varchar(200) DEFAULT NULL,
  `minprice_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `agreement_status` varchar(100) DEFAULT 'Generated',
  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `receiver_name` varchar(1000) DEFAULT NULL,
  `receiver_signature` varchar(1000) DEFAULT NULL,
  `receiver_signature_datetime` datetime DEFAULT NULL,
  `receiver_signed_device` varchar(1000) DEFAULT NULL,
  `receiver_signed_ip` varchar(100) DEFAULT NULL,
  `return_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `vehicle_return_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `close_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `close_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `violations_json` longtext DEFAULT NULL,
  `replaced_vehicle_json` longtext DEFAULT NULL
) ;

--
-- Dumping data for table `tbl_vehicle_rentout_contracts`
--

INSERT INTO `tbl_vehicle_rentout_contracts` (`ids`, `company_id`, `booking_ids`, `agreement_no`, `agreement_group_ref_no`, `agreement_date`, `customer_code`, `customer_name`, `customer_details`, `quotation_number`, `vehicle_category_id`, `vehicle_model_id`, `vehicle_id`, `vehicle_no`, `vechile_details`, `service_type`, `service_start_date_time`, `service_end_date_time`, `contract_details_json`, `km_in`, `km_out`, `km_used`, `vehicle_accessories_details`, `extend_date`, `lease_period`, `return_date`, `remarks1`, `remarks2`, `terms_condition`, `vehicle_rentout_images`, `driver_status`, `driver_ids`, `driver_details`, `customer_driver_name`, `customer_driver_contact_number`, `customer_driver_attachments`, `received_by`, `delivered_by`, `hirer_signature`, `hirer_name`, `hirer_signature_date`, `hier_signature_status`, `hirer_signed_ip`, `hirer_signed_device`, `delivered_signature_status`, `delivered_signature`, `delivered_signatory`, `delivered_signature_date`, `delivered_signed_ip`, `delivered_signed_device`, `minprice_otp_details`, `log_json`, `agreement_status`, `rentout_log_json`, `receiver_name`, `receiver_signature`, `receiver_signature_datetime`, `receiver_signed_device`, `receiver_signed_ip`, `return_log_json`, `vehicle_return_images`, `close_log_json`, `close_otp_details`, `violations_json`, `replaced_vehicle_json`) VALUES
(1, 1, 0, 'FL/AGR/2026/0001', NULL, '2026-09-22', 'C0002', 'baqer', '{\"customer_name\":\"baqer\",\"customer_code\":\"C0002\",\"customer_mobile\":\"\",\"customer_email\":\"\",\"customer_attention\":\"\",\"customer_address\":\"\"}', '', 21, 92, 1, '145521', '{\"vehicle_id\":1,\"category_id\":21,\"model_id\":92,\"veh_no\":\"145521\",\"category_name\":\"COMPACT SUV\",\"model_name\":\"KAIYI   X3\",\"vehicle_color\":\"RED\",\"vehicle_year\":2024}', 'Rental Without Driver', '2026-01-01 00:00:00', '2026-01-02 00:00:00', '{\"period_from\":\"2026-01-01 00:00:00\",\"period_to\":\"2026-01-02 00:00:00\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"24\",\"unit_price\":\"1\",\"min_price\":\"0\",\"vat\":\"10\",\"total_amt\":\"26.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}', 222222.000, 32423.000, 189799.000, '{\"chk_tools\":\"No\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-22T11:24\",\"vehicle_km_out\":\"32423\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, '2026-09-22 11:33:00', NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[]', NULL, 0, '[]', '', '', '[]', '1', NULL, 'uploads/signatures/hirer_1790065491_1.png', 'baqer', '2026-09-22 13:54:51', 'Yes', '94.76.1.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1790065491_1.png', 'Administrator', '2026-09-22 13:54:51', '94.76.1.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-09-22 11:24:51\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', 'Administrator', 'uploads/signatures/receiver_0_1790066038.png', '2026-09-22 11:33:58', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '94.76.1.183', '{\"user_id\":1,\"datetime\":\"2026-09-22 11:33:58\"}', '[]', NULL, NULL, '[]', NULL),
(2, 1, 0, 'FL/AGR/2026/0002', NULL, '2026-09-22', 'C0006', 'baqer mahmood', '{\"customer_name\":\"baqer mahmood\",\"customer_code\":\"C0006\",\"customer_mobile\":\"\",\"customer_email\":\"anzelabk@gmail.com\",\"customer_attention\":\"ok\",\"customer_address\":\"fastlink\"}', '', 21, 92, 1, '145521', '{\"vehicle_id\":1,\"category_id\":21,\"model_id\":92,\"veh_no\":\"145521\",\"category_name\":\"COMPACT SUV\",\"model_name\":\"KAIYI   X3\",\"vehicle_color\":\"RED\",\"vehicle_year\":2024}', 'Rental Without Driver', '2026-01-05 00:00:00', '2026-01-06 00:00:00', '{\"period_from\":\"2026-01-05 00:00:00\",\"period_to\":\"2026-01-06 00:00:00\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"24\",\"unit_price\":\"2\",\"min_price\":\"0\",\"vat\":\"10\",\"total_amt\":\"52.800\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}', 89889.000, 3423.000, 86466.000, '{\"chk_tools\":\"No\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-22T11:29\",\"vehicle_km_out\":\"3423\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, '2026-09-22 11:34:00', NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[\"1790065805_3638.jpg\"]', NULL, 0, '[]', 'test', '435435', '{\"vehicles\":[{\"documentName\":\"test\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6ab23c82318f42.29684319.webp\"]}]}', '1', NULL, 'uploads/signatures/hirer_1790065815_1.png', 'baqer mahmood', '2026-09-22 14:00:15', 'Yes', '94.76.1.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1790065815_1.png', 'Administrator', '2026-09-22 14:00:15', '94.76.1.183', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-09-22 11:30:15\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', 'Administrator', 'uploads/signatures/receiver_0_1790066117.png', '2026-09-22 11:35:17', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', '94.76.1.183', '{\"user_id\":1,\"datetime\":\"2026-09-22 11:35:17\"}', '[]', NULL, NULL, '[]', NULL),
(3, 1, 0, 'FL/AGR/2026/0003', NULL, '2026-10-14', 'C0008', 'nidham', '{\"customer_name\":\"nidham\",\"customer_code\":\"C0008\",\"customer_mobile\":\"39771190\",\"customer_email\":\"nidham1@gmail.com\",\"customer_attention\":\"\",\"customer_address\":\"flat 13 bldg 4 road 1101 Tubli 711\"}', '', 1, 2, 7, '123456', '{\"vehicle_id\":7,\"category_id\":1,\"model_id\":2,\"veh_no\":\"123456\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"b\",\"vehicle_year\":2023}', 'Rental Without Driver', '2026-10-14 00:00:00', '2026-10-20 00:00:00', '{\"period_from\":\"2026-10-14 00:00:00\",\"period_to\":\"2026-10-20 00:00:00\",\"rate_type_id\":\"week\",\"rate_type\":\"Weekly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"1\",\"unit_price\":\"14\",\"min_price\":\"14\",\"vat\":\"10\",\"total_amt\":\"15.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}', NULL, 20000.000, NULL, '{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-10-14T10:43\",\"vehicle_km_out\":\"20000\",\"fuel_level\":\"50%\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, NULL, NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[]', NULL, 0, '[]', '', '', '[]', NULL, NULL, 'uploads/signatures/hirer_1791963988_7.png', 'nidham', '2026-10-14 13:16:28', 'Yes', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1791963988_7.png', 'Administrator', '2026-10-14 13:16:28', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-10-14 10:46:28\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 0, 'FL/AGR/2026/0004', NULL, '2026-10-14', 'C0008', 'nidham', '{\"customer_name\":\"nidham\",\"customer_code\":\"C0008\",\"customer_mobile\":\"39771190\",\"customer_email\":\"nidham1@gmail.com\",\"customer_attention\":\"\",\"customer_address\":\"flat 13 bldg 4 road 1101 Tubli 711\"}', '', 1, 2, 7, '123456', '{\"vehicle_id\":7,\"category_id\":1,\"model_id\":2,\"veh_no\":\"123456\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"b\",\"vehicle_year\":2023}', 'Rental Without Driver', '2026-10-15 00:00:00', '2026-10-20 00:00:00', '{\"period_from\":\"2026-10-15 00:00:00\",\"period_to\":\"2026-10-20 00:00:00\",\"rate_type_id\":\"week\",\"rate_type\":\"Weekly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"1\",\"unit_price\":\"14\",\"min_price\":\"14\",\"vat\":\"10\",\"total_amt\":\"15.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}', NULL, 20000.000, NULL, '{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-10-14T11:03\",\"vehicle_km_out\":\"20000\",\"fuel_level\":\"50%\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, NULL, NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[]', NULL, 0, '[]', 'nidham', '23213213', '[]', NULL, NULL, 'uploads/signatures/hirer_1791965266_7.png', 'nidham', '2026-10-14 13:37:46', 'Yes', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1791965266_7.png', 'Administrator', '2026-10-14 13:37:46', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-10-14 11:07:46\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 0, 'FL/AGR/2026/0005', NULL, '2026-10-15', 'C0006', 'baqer mahmood', '{\"customer_name\":\"baqer mahmood\",\"customer_code\":\"C0006\",\"customer_mobile\":\"\",\"customer_email\":\"anzelabk@gmail.com\",\"customer_attention\":\"ok\",\"customer_address\":\"fastlink\"}', '', 21, 92, 1, '145521', '{\"vehicle_id\":1,\"category_id\":21,\"model_id\":92,\"veh_no\":\"145521\",\"category_name\":\"COMPACT SUV\",\"model_name\":\"KAIYI   X3\",\"vehicle_color\":\"RED\",\"vehicle_year\":2024}', 'Rental Without Driver', '2026-10-01 00:00:00', '2026-10-10 00:00:00', '{\"period_from\":\"2026-10-01 00:00:00\",\"period_to\":\"2026-10-10 00:00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"9\",\"unit_price\":\"6\",\"min_price\":\"6\",\"vat\":\"10\",\"total_amt\":\"59.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}', 1300.000, 1200.000, 100.000, '{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-10-15T10:31\",\"vehicle_km_out\":\"1200\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, '2026-10-15 10:32:00', NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[\"1792049517_3935.jpg\"]', NULL, 0, '[]', 'Test', '12421424', '[]', '1', NULL, 'uploads/signatures/hirer_1792049529_1.png', 'baqer mahmood', '2026-10-15 13:02:09', 'Yes', '46.184.209.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1792049529_1.png', 'Administrator', '2026-10-15 13:02:09', '46.184.209.51', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-10-15 10:32:09\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', 'Administrator', 'uploads/signatures/receiver_0_1792049622.png', '2026-10-15 10:33:42', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '46.184.209.51', '{\"user_id\":1,\"datetime\":\"2026-10-15 10:33:42\"}', '[]', NULL, NULL, '[]', NULL),
(6, 1, 0, 'FL/AGR/2026/0006', NULL, '2026-11-02', 'C0012', 'Anzel Sait', '{\"customer_name\":\"Anzel Sait\",\"customer_code\":\"C0012\",\"customer_mobile\":\"\",\"customer_email\":\"anzelabk@gmail.com\",\"customer_attention\":\"\",\"customer_address\":\"\"}', '', 21, 94, 6, '278613', '{\"vehicle_id\":6,\"category_id\":21,\"model_id\":94,\"veh_no\":\"278613\",\"category_name\":\"COMPACT SUV\",\"model_name\":\"CHERRY  TIGGO 2\",\"vehicle_color\":\"WHITE\",\"vehicle_year\":2022}', 'Rental Without Driver', '2026-11-02 00:00:00', '2026-11-04 00:00:00', '{\"period_from\":\"2026-11-02 00:00:00\",\"period_to\":\"2026-11-04 00:00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"2\",\"unit_price\":\"5\",\"min_price\":\"0\",\"vat\":\"10\",\"total_amt\":\"11.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"no\",\"otp_details\":\"\"}', NULL, 75000.000, NULL, '{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-11-02T12:52\",\"vehicle_km_out\":\"75000\",\"fuel_level\":\"2\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}', NULL, NULL, NULL, NULL, NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', '[]', NULL, 0, '[]', '', '', '[]', NULL, NULL, 'uploads/signatures/hirer_1793613233_6.png', 'Anzel Sait', '2026-11-02 15:23:53', 'Yes', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_1793613233_6.png', 'Administrator', '2026-11-02 15:23:53', '46.184.212.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/156.0.0.0 Safari/537.36', NULL, '{\"user_id\":1,\"datetime\":\"2026-11-02 12:53:53\"}', 'Rentout', '{\"user_id\":1,\"datetime\":\"2026-11-02 12:55:04\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_shortcuts`
--

CREATE TABLE `user_shortcuts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action_name` varchar(50) DEFAULT NULL,
  `shortcut_key` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `ids` int(11) NOT NULL,
  `vehicles_name` varchar(200) NOT NULL,
  `vehicles_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicles_status` varchar(25) NOT NULL DEFAULT 'Available',
  `vehicles_number` int(11) NOT NULL,
  `vehicles_passing_date` date NOT NULL,
  `vehicles_insurance_date` datetime NOT NULL,
  `vehicles_purchase_date` date NOT NULL,
  `vehicles_modal` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(300) DEFAULT NULL
) ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_vehicle_details`
-- (See below for the actual view)
--
CREATE TABLE `view_vehicle_details` (
`ids` int(11)
,`category_id` int(11)
,`category_name` varchar(200)
,`brand_id` int(11)
,`brand_name` varchar(200)
,`model_id` int(11)
,`model_name` varchar(200)
,`model_names` varchar(1000)
,`company_id` int(11)
,`vehicle_number` varchar(100)
,`vehicle_year` int(11)
,`vehicle_color` varchar(100)
,`image_json` longtext
,`other_details_json` longtext
,`vehicle_attachments` longtext
,`vehicle_status` varchar(100)
,`created_on` datetime
,`created_by` int(11)
,`vehicle_purchase_date` date
,`next_passing_date` date
,`passing_histroy` longtext
,`next_insurance_date` date
,`insurance_histroy` longtext
,`next_maintenance_date` date
,`maintenance_histroy` longtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_vehicle_model`
-- (See below for the actual view)
--
CREATE TABLE `view_vehicle_model` (
`model_ids` int(11)
,`model_name` varchar(200)
,`vehicle_modal_pic` varchar(2000)
,`category_id` int(11)
,`category_name` varchar(200)
,`category_image` varchar(100)
,`category_description` text
,`category_status` varchar(50)
,`brand_id` int(11)
,`brand_name` varchar(200)
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking_info`
--
ALTER TABLE `booking_info`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `booking_id` (`booking_id`);

--
-- Indexes for table `cashmemo`
--
ALTER TABLE `cashmemo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_no` (`cashmemo_no`),
  ADD UNIQUE KEY `uk_invoice_no` (`cashmemo_no`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `customer_id` (`customer_id`),
  ADD KEY `idx_customer_name` (`customer_name`),
  ADD KEY `idx_customer_mobile` (`customer_mobile`);

--
-- Indexes for table `document_sequences`
--
ALTER TABLE `document_sequences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expensevoucher`
--
ALTER TABLE `expensevoucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_no` (`expensevoucher_no`),
  ADD UNIQUE KEY `uk_invoice_no` (`expensevoucher_no`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_no` (`invoice_no`),
  ADD UNIQUE KEY `uk_invoice_no` (`invoice_no`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotation_no` (`quotation_no`);

--
-- Indexes for table `shortcut_actions`
--
ALTER TABLE `shortcut_actions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `action_name` (`action_name`);

--
-- Indexes for table `tbl_banks`
--
ALTER TABLE `tbl_banks`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `company_code` (`company_code`);

--
-- Indexes for table `tbl_customer_ledger`
--
ALTER TABLE `tbl_customer_ledger`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `idx_customer` (`customer_code`);

--
-- Indexes for table `tbl_drivers`
--
ALTER TABLE `tbl_drivers`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_garages`
--
ALTER TABLE `tbl_garages`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `garage_code` (`garage_code`);

--
-- Indexes for table `tbl_garage_services`
--
ALTER TABLE `tbl_garage_services`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_invoice_billing_schedules`
--
ALTER TABLE `tbl_invoice_billing_schedules`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_ledger_heads`
--
ALTER TABLE `tbl_ledger_heads`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `head_name` (`head_name`);

--
-- Indexes for table `tbl_maintenance_requests`
--
ALTER TABLE `tbl_maintenance_requests`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_maintenance_request_services`
--
ALTER TABLE `tbl_maintenance_request_services`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `request_id` (`request_id`);

--
-- Indexes for table `tbl_outsourcing_companies`
--
ALTER TABLE `tbl_outsourcing_companies`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`permission_id`),
  ADD UNIQUE KEY `uniq_perm_key` (`permission_key`);

--
-- Indexes for table `tbl_quotation_introduction`
--
ALTER TABLE `tbl_quotation_introduction`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_role_permissions`
--
ALTER TABLE `tbl_role_permissions`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `uniq_role_perm` (`role_id`,`permission_id`);

--
-- Indexes for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_system_settings`
--
ALTER TABLE `tbl_system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_company` (`company_id`);

--
-- Indexes for table `tbl_terms_and_condition`
--
ALTER TABLE `tbl_terms_and_condition`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_terms_and_condition_contract`
--
ALTER TABLE `tbl_terms_and_condition_contract`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `idx_unique_user_name` (`user_name`);

--
-- Indexes for table `tbl_user_permissions`
--
ALTER TABLE `tbl_user_permissions`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `uniq_user_perm` (`user_id`,`permission_id`);

--
-- Indexes for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `chassis_number` (`chassis_number`);

--
-- Indexes for table `tbl_vehicle_bookings`
--
ALTER TABLE `tbl_vehicle_bookings`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_brand`
--
ALTER TABLE `tbl_vehicle_brand`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_category`
--
ALTER TABLE `tbl_vehicle_category`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_contract_extensions`
--
ALTER TABLE `tbl_vehicle_contract_extensions`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_contract_replacement`
--
ALTER TABLE `tbl_vehicle_contract_replacement`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_log_movement`
--
ALTER TABLE `tbl_vehicle_log_movement`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `idx_vehicle` (`vehicle_ids`),
  ADD KEY `idx_datetime` (`log_datetime`),
  ADD KEY `idx_action` (`action_type`),
  ADD KEY `idx_reference` (`reference_type`,`reference_id`),
  ADD KEY `idx_staff` (`staff_id`),
  ADD KEY `idx_customer` (`customer_id`),
  ADD KEY `idx_garage` (`garage_id`);

--
-- Indexes for table `tbl_vehicle_model`
--
ALTER TABLE `tbl_vehicle_model`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_non_revenue_ticket`
--
ALTER TABLE `tbl_vehicle_non_revenue_ticket`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_pricing_master`
--
ALTER TABLE `tbl_vehicle_pricing_master`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_vehicle_rentout_contracts`
--
ALTER TABLE `tbl_vehicle_rentout_contracts`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `user_shortcuts`
--
ALTER TABLE `user_shortcuts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`action_name`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`ids`),
  ADD KEY `idx_vehicle_status` (`vehicles_status`,`company_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking_info`
--
ALTER TABLE `booking_info`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashmemo`
--
ALTER TABLE `cashmemo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `expensevoucher`
--
ALTER TABLE `expensevoucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shortcut_actions`
--
ALTER TABLE `shortcut_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_banks`
--
ALTER TABLE `tbl_banks`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_customer_ledger`
--
ALTER TABLE `tbl_customer_ledger`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_drivers`
--
ALTER TABLE `tbl_drivers`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_garages`
--
ALTER TABLE `tbl_garages`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_garage_services`
--
ALTER TABLE `tbl_garage_services`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_invoice_billing_schedules`
--
ALTER TABLE `tbl_invoice_billing_schedules`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_ledger_heads`
--
ALTER TABLE `tbl_ledger_heads`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_maintenance_requests`
--
ALTER TABLE `tbl_maintenance_requests`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_maintenance_request_services`
--
ALTER TABLE `tbl_maintenance_request_services`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_outsourcing_companies`
--
ALTER TABLE `tbl_outsourcing_companies`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `tbl_quotation_introduction`
--
ALTER TABLE `tbl_quotation_introduction`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_role_permissions`
--
ALTER TABLE `tbl_role_permissions`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=257;

--
-- AUTO_INCREMENT for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_system_settings`
--
ALTER TABLE `tbl_system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_terms_and_condition`
--
ALTER TABLE `tbl_terms_and_condition`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_terms_and_condition_contract`
--
ALTER TABLE `tbl_terms_and_condition_contract`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_permissions`
--
ALTER TABLE `tbl_user_permissions`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_bookings`
--
ALTER TABLE `tbl_vehicle_bookings`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_brand`
--
ALTER TABLE `tbl_vehicle_brand`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_vehicle_category`
--
ALTER TABLE `tbl_vehicle_category`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_vehicle_contract_extensions`
--
ALTER TABLE `tbl_vehicle_contract_extensions`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_contract_replacement`
--
ALTER TABLE `tbl_vehicle_contract_replacement`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_log_movement`
--
ALTER TABLE `tbl_vehicle_log_movement`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_vehicle_model`
--
ALTER TABLE `tbl_vehicle_model`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_non_revenue_ticket`
--
ALTER TABLE `tbl_vehicle_non_revenue_ticket`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_vehicle_pricing_master`
--
ALTER TABLE `tbl_vehicle_pricing_master`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_vehicle_rentout_contracts`
--
ALTER TABLE `tbl_vehicle_rentout_contracts`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_shortcuts`
--
ALTER TABLE `user_shortcuts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Structure for view `view_vehicle_details`
--
DROP TABLE IF EXISTS `view_vehicle_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fastlinkpayment_rental_car_user`@`localhost` SQL SECURITY DEFINER VIEW `view_vehicle_details`  AS SELECT `v`.`ids` AS `ids`, `v`.`category_id` AS `category_id`, `c`.`category_name` AS `category_name`, `v`.`brand_id` AS `brand_id`, `b`.`brand_name` AS `brand_name`, `v`.`model_id` AS `model_id`, `m`.`modal_name` AS `model_name`, `v`.`model_names` AS `model_names`, `v`.`company_id` AS `company_id`, `v`.`vehicle_number` AS `vehicle_number`, `v`.`vehicle_year` AS `vehicle_year`, `v`.`vehicle_color` AS `vehicle_color`, `v`.`image_json` AS `image_json`, `v`.`other_details_json` AS `other_details_json`, `v`.`vehicle_attachments` AS `vehicle_attachments`, `v`.`vehicle_status` AS `vehicle_status`, `v`.`created_on` AS `created_on`, `v`.`created_by` AS `created_by`, `v`.`vehicle_purchase_date` AS `vehicle_purchase_date`, `v`.`next_passing_date` AS `next_passing_date`, `v`.`passing_histroy` AS `passing_histroy`, `v`.`next_insurance_date` AS `next_insurance_date`, `v`.`insurance_histroy` AS `insurance_histroy`, `v`.`next_maintenance_date` AS `next_maintenance_date`, `v`.`maintenance_histroy` AS `maintenance_histroy` FROM (((`tbl_vehicles` `v` left join `tbl_vehicle_category` `c` on(`v`.`category_id` = `c`.`ids`)) left join `tbl_vehicle_brand` `b` on(`v`.`brand_id` = `b`.`ids`)) left join `tbl_vehicle_model` `m` on(`v`.`model_id` = `m`.`ids`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_vehicle_model`
--
DROP TABLE IF EXISTS `view_vehicle_model`;

CREATE ALGORITHM=UNDEFINED DEFINER=`fastlinkpayment_rental_car_user`@`localhost` SQL SECURITY DEFINER VIEW `view_vehicle_model`  AS SELECT `v`.`ids` AS `model_ids`, `v`.`modal_name` AS `model_name`, `v`.`vehicle_modal_pic` AS `vehicle_modal_pic`, `v`.`category_id` AS `category_id`, `c`.`category_name` AS `category_name`, `c`.`category_image` AS `category_image`, `c`.`category_description` AS `category_description`, `c`.`category_status` AS `category_status`, `v`.`brand_id` AS `brand_id`, `b`.`brand_name` AS `brand_name` FROM ((`tbl_vehicle_model` `v` left join `tbl_vehicle_category` `c` on(`v`.`category_id` = `c`.`ids`)) left join `tbl_vehicle_brand` `b` on(`v`.`brand_id` = `b`.`ids`)) ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_maintenance_request_services`
--
ALTER TABLE `tbl_maintenance_request_services`
  ADD CONSTRAINT `tbl_maintenance_request_services_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_maintenance_requests` (`ids`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
