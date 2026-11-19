-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_fastlink_carrental
-- ------------------------------------------------------
-- Server version	8.0.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `booking_info`
--

DROP TABLE IF EXISTS `booking_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `booking_info` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `drivers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `clients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `booking_id` (`booking_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_booking_id` BEFORE INSERT ON `booking_info` FOR EACH ROW BEGIN
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `cashmemo`
--

DROP TABLE IF EXISTS `cashmemo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cashmemo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cashmemo_no` varchar(100) DEFAULT NULL,
  `cashmemo_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text,
  `contract_ids` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_no` varchar(200) DEFAULT NULL,
  `model_ids` int(11) DEFAULT NULL,
  `model_names` varchar(500) DEFAULT NULL,
  `vehicle_color` varchar(200) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `cashmemo_notes` text,
  `cashmemo_payment_type` varchar(200) DEFAULT NULL,
  `cashmemo_cheque_date` date DEFAULT NULL,
  `cashmemo_cheque_ref_no` varchar(200) DEFAULT NULL,
  `company_signature` varchar(1000) DEFAULT NULL,
  `company_sign_name` varchar(1000) DEFAULT NULL,
  `company_sign_date_time` datetime DEFAULT NULL,
  `customer_signature` varchar(1000) DEFAULT NULL,
  `customer_sign_name` varchar(1000) DEFAULT NULL,
  `customer_sign_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_no` (`cashmemo_no`),
  UNIQUE KEY `uk_invoice_no` (`cashmemo_no`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `customer_details`
--

DROP TABLE IF EXISTS `customer_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_details` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(20) NOT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `phone_1` varchar(50) DEFAULT NULL,
  `phone_2` varchar(50) DEFAULT NULL,
  `fax_no` varchar(50) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `customer_email` varchar(200) DEFAULT NULL,
  `customer_addr` text,
  `vat_reg_no` varchar(100) DEFAULT NULL,
  `customer_attn` varchar(1000) DEFAULT NULL,
  `customer_cr_cpr` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `license_no` varchar(100) DEFAULT NULL,
  `license_issue_place` varchar(100) DEFAULT NULL,
  `license_expiry_date` date DEFAULT NULL,
  `cpr_expiry_date` date DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `customer_account_id` int(11) DEFAULT NULL,
  `customer_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `client_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `driver_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive','Blacklisted') DEFAULT 'Active',
  `is_blacklisted` tinyint(1) NOT NULL DEFAULT '0',
  `blacklist_description` text,
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `idx_customer_name` (`customer_name`),
  KEY `idx_customer_mobile` (`customer_mobile`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `trg_customer_id` BEFORE INSERT ON `customer_details` FOR EACH ROW BEGIN
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
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `document_sequences`
--

DROP TABLE IF EXISTS `document_sequences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document_sequences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_type` varchar(50) NOT NULL,
  `doc_year` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `current_number` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `expensevoucher`
--

DROP TABLE IF EXISTS `expensevoucher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expensevoucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expensevoucher_no` varchar(100) DEFAULT NULL,
  `expensevoucher_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text,
  `contract_ids` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_no` varchar(200) DEFAULT NULL,
  `model_ids` int(11) DEFAULT NULL,
  `model_names` varchar(500) DEFAULT NULL,
  `vehicle_color` varchar(200) DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `expensevoucher_notes` text,
  `expensevoucher_payment_type` varchar(200) DEFAULT NULL,
  `expensevoucher_cheque_date` date DEFAULT NULL,
  `expensevoucher_cheque_ref_no` varchar(200) DEFAULT NULL,
  `company_signature` varchar(1000) DEFAULT NULL,
  `company_sign_name` varchar(1000) DEFAULT NULL,
  `company_sign_date_time` datetime DEFAULT NULL,
  `customer_signature` varchar(1000) DEFAULT NULL,
  `customer_sign_name` varchar(1000) DEFAULT NULL,
  `customer_sign_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_no` (`expensevoucher_no`),
  UNIQUE KEY `uk_invoice_no` (`expensevoucher_no`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_due_date` date DEFAULT NULL,
  `invoice_no` varchar(100) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) NOT NULL,
  `customer_address` text,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `attention` text,
  `lpo_number` varchar(100) DEFAULT NULL,
  `trn_no` varchar(100) DEFAULT NULL,
  `quotation_ref_no` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_no` (`invoice_no`),
  UNIQUE KEY `uk_invoice_no` (`invoice_no`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `quotations`
--

DROP TABLE IF EXISTS `quotations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `quotations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_prefix` varchar(200) DEFAULT NULL,
  `quotation_no` varchar(50) DEFAULT NULL,
  `quotation_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(150) DEFAULT NULL,
  `customer_phone` varchar(50) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `customer_cpr_cr` varchar(200) DEFAULT NULL,
  `customer_address` text,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `allItemSubtotal` decimal(18,5) NOT NULL,
  `subtotal` decimal(12,5) DEFAULT NULL,
  `total_discount` decimal(18,2) NOT NULL,
  `total_discount_amount` decimal(18,4) NOT NULL,
  `after_discount_amount` decimal(18,4) NOT NULL,
  `vat_total` decimal(12,5) DEFAULT NULL,
  `grand_total` decimal(12,5) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `draft` enum('Yes','No') DEFAULT 'No',
  `reference_number` varchar(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(150) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `attention` text,
  `introduction` longtext,
  `terms` longtext,
  `quotation_status` varchar(100) NOT NULL DEFAULT 'Not Approved',
  PRIMARY KEY (`id`),
  UNIQUE KEY `quotation_no` (`quotation_no`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shortcut_actions`
--

DROP TABLE IF EXISTS `shortcut_actions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shortcut_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_name` varchar(50) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `default_key` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `action_name` (`action_name`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_banks`
--

DROP TABLE IF EXISTS `tbl_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_banks` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `account_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_company`
--

DROP TABLE IF EXISTS `tbl_company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_company` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_code` varchar(100) NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_logo` varchar(1000) NOT NULL DEFAULT 'default.jpg',
  `status` varchar(10) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `company_code` (`company_code`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_customer_accounts`
--

DROP TABLE IF EXISTS `tbl_customer_accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_customer_accounts` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(150) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `company_id` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_customer_ledger`
--

DROP TABLE IF EXISTS `tbl_customer_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_customer_ledger` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `quotation_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `booking_no` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trans_date` date NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `trans_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `payment_method` enum('Cash','Cheque','BankTransfer','CreditCard','Other','N/A') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'N/A',
  `bank_id` int(11) DEFAULT NULL,
  `company_bank_id` int(11) DEFAULT NULL,
  `debit` decimal(18,5) DEFAULT '0.00000',
  `credit` decimal(18,5) DEFAULT '0.00000',
  `ref_no` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cheque_status` enum('Pending','Collected','Bounced') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `collected_at` datetime DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking_ids` int(11) DEFAULT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ids`),
  KEY `idx_customer` (`customer_code`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_drivers`
--

DROP TABLE IF EXISTS `tbl_drivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_drivers` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `driver_address` text,
  `created_by` varchar(500) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `driver_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `driver_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_garage_services`
--

DROP TABLE IF EXISTS `tbl_garage_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_garage_services` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_per_unit` decimal(10,2) DEFAULT '0.00',
  `status` enum('Available','Deactivated') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `company_id` int(11) DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_garages`
--

DROP TABLE IF EXISTS `tbl_garages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_garages` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `garage_code` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `garage_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_person` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Available','Deactivated') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `company_id` int(11) DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `garage_code` (`garage_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_invoice_billing_schedules`
--

DROP TABLE IF EXISTS `tbl_invoice_billing_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_invoice_billing_schedules` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `contract_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(100) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `booking_ref_no` varchar(100) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicle_ids` int(11) DEFAULT NULL,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `contract_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `invoice_schedule_date` date DEFAULT NULL,
  `invoice_due_date` date DEFAULT NULL,
  `invoice_amount` decimal(10,3) DEFAULT '0.000',
  `invoice_period_from` date DEFAULT NULL,
  `invoice_period_to` date DEFAULT NULL,
  `log_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `status` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_ledger_heads`
--

DROP TABLE IF EXISTS `tbl_ledger_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_ledger_heads` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `head_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `head_type` enum('Debit','Credit') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `company_id` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `violation_fine_type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `head_name` (`head_name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_maintenance_request_services`
--

DROP TABLE IF EXISTS `tbl_maintenance_request_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_maintenance_request_services` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `request_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `qty` decimal(10,2) DEFAULT '1.00',
  `cost` decimal(10,3) DEFAULT '0.000',
  `unit` varchar(50) DEFAULT NULL,
  `remarks` text,
  PRIMARY KEY (`ids`),
  KEY `request_id` (`request_id`),
  CONSTRAINT `tbl_maintenance_request_services_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_maintenance_requests` (`ids`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_maintenance_requests`
--

DROP TABLE IF EXISTS `tbl_maintenance_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_maintenance_requests` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `request_no` varchar(100) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `garage_id` int(11) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `company_id` int(11) DEFAULT NULL,
  `additional_charges` decimal(10,3) DEFAULT '0.000',
  `additional_charges_remarks` varchar(255) DEFAULT NULL,
  `total_cost` decimal(10,3) DEFAULT '0.000',
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_outsourcing_companies`
--

DROP TABLE IF EXISTS `tbl_outsourcing_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_outsourcing_companies` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT '1',
  `company_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cr_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `contact_person_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_number` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_permissions`
--

DROP TABLE IF EXISTS `tbl_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_permissions` (
  `permission_id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(200) DEFAULT NULL,
  `permission_key` varchar(100) DEFAULT NULL,
  `module_group` varchar(100) DEFAULT 'General',
  `status` varchar(20) DEFAULT 'Active',
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `uniq_perm_key` (`permission_key`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_print_settings`
--

DROP TABLE IF EXISTS `tbl_print_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_print_settings` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_quotation_introduction`
--

DROP TABLE IF EXISTS `tbl_quotation_introduction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_quotation_introduction` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `intrn_title` varchar(500) DEFAULT NULL,
  `intrn_content` longtext,
  `company_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_refund_requests`
--

DROP TABLE IF EXISTS `tbl_refund_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_refund_requests` (
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
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_role_permissions`
--

DROP TABLE IF EXISTS `tbl_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_role_permissions` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Granted',
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `uniq_role_perm` (`role_id`,`permission_id`)
) ENGINE=MyISAM AUTO_INCREMENT=259 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_roles`
--

DROP TABLE IF EXISTS `tbl_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_service_type`
--

DROP TABLE IF EXISTS `tbl_service_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_service_type` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `service_type` varchar(500) DEFAULT NULL,
  `vat_perct` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_staff`
--

DROP TABLE IF EXISTS `tbl_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_staff` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `staff_address` text,
  `created_by` varchar(500) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `staff_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `staff_status` varchar(100) DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_system_settings`
--

DROP TABLE IF EXISTS `tbl_system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL DEFAULT '1',
  `vat_percentage` decimal(5,2) NOT NULL DEFAULT '10.00',
  `timezone` varchar(100) NOT NULL DEFAULT 'Asia/Bahrain',
  `date_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',
  `currency_code` varchar(10) NOT NULL DEFAULT 'BHD',
  `currency_symbol` varchar(20) NOT NULL DEFAULT 'BD',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_company` (`company_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_terms_and_condition`
--

DROP TABLE IF EXISTS `tbl_terms_and_condition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_terms_and_condition` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `terms_condition` longtext NOT NULL,
  `t_c_name` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_terms_and_condition_contract`
--

DROP TABLE IF EXISTS `tbl_terms_and_condition_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_terms_and_condition_contract` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `terms_condition` longtext NOT NULL,
  `t_c_name` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_user_permissions`
--

DROP TABLE IF EXISTS `tbl_user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_user_permissions` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Granted',
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `uniq_user_perm` (`user_id`,`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_users`
--

DROP TABLE IF EXISTS `tbl_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(500) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_passkey` varchar(100) DEFAULT NULL,
  `user_role_id` varchar(100) DEFAULT NULL,
  `user_role_name` varchar(255) DEFAULT NULL,
  `company_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `user_mobile` varchar(100) DEFAULT NULL,
  `user_email` varchar(500) DEFAULT NULL,
  `profile_image` varchar(1000) NOT NULL DEFAULT 'profile.jpg',
  `user_status` varchar(50) DEFAULT 'Active',
  `created_date` date NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `idx_unique_user_name` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_bookings`
--

DROP TABLE IF EXISTS `tbl_vehicle_bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_bookings` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `customer_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `book_from_date` datetime NOT NULL,
  `book_to_date` datetime DEFAULT NULL,
  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `book_status` varchar(100) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_brand`
--

DROP TABLE IF EXISTS `tbl_vehicle_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_brand` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(200) DEFAULT NULL,
  `brand_description` text,
  `brand_status` varchar(100) DEFAULT 'Active',
  `brand_image` varchar(500) DEFAULT 'default.jpg',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_category`
--

DROP TABLE IF EXISTS `tbl_vehicle_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_category` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(200) DEFAULT NULL,
  `category_image` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `category_description` text NOT NULL,
  `category_status` varchar(50) NOT NULL DEFAULT 'Active',
  PRIMARY KEY (`ids`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_contract_extensions`
--

DROP TABLE IF EXISTS `tbl_vehicle_contract_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_contract_extensions` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `agreement_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `extension_date` date DEFAULT NULL,
  `extend_start_date` datetime DEFAULT NULL,
  `extend_end_date` datetime DEFAULT NULL,
  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_contract_replacement`
--

DROP TABLE IF EXISTS `tbl_vehicle_contract_replacement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_contract_replacement` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `agreement_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(200) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `vehicle_ids` int(11) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `extension_date` date DEFAULT NULL,
  `extend_start_date` datetime DEFAULT NULL,
  `extend_end_date` datetime DEFAULT NULL,
  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_log_movement`
--

DROP TABLE IF EXISTS `tbl_vehicle_log_movement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_log_movement` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `remarks` text,
  `created_by` int(11) DEFAULT NULL,
  `created_name` varchar(100) DEFAULT NULL,
  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  KEY `idx_vehicle` (`vehicle_ids`),
  KEY `idx_datetime` (`log_datetime`),
  KEY `idx_action` (`action_type`),
  KEY `idx_reference` (`reference_type`,`reference_id`),
  KEY `idx_staff` (`staff_id`),
  KEY `idx_customer` (`customer_id`),
  KEY `idx_garage` (`garage_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_lookup_master`
--

DROP TABLE IF EXISTS `tbl_vehicle_lookup_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_lookup_master` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `lookup_type` enum('color','body_type','engine_type','capacity_cc','transmission') NOT NULL,
  `lookup_value` varchar(120) NOT NULL,
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `uq_type_val` (`lookup_type`,`lookup_value`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_model`
--

DROP TABLE IF EXISTS `tbl_vehicle_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_model` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `modal_name` varchar(200) DEFAULT NULL,
  `vehicle_modal_pic` varchar(2000) NOT NULL DEFAULT 'default.jpg',
  `model_status` varchar(100) DEFAULT 'Active',
  `model_description` text,
  `price_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_non_revenue_ticket`
--

DROP TABLE IF EXISTS `tbl_vehicle_non_revenue_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_non_revenue_ticket` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `staff_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `book_from_date` datetime NOT NULL,
  `book_to_date` datetime DEFAULT NULL,
  `notes` text,
  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `book_status` varchar(100) DEFAULT NULL,
  `return_notes` text,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `modified_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_pricing_master`
--

DROP TABLE IF EXISTS `tbl_vehicle_pricing_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_pricing_master` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `price_item` varchar(1000) DEFAULT NULL,
  `price_status` varchar(100) DEFAULT 'Active',
  `ledger_status` varchar(50) NOT NULL DEFAULT 'Yes',
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicle_rentout_contracts`
--

DROP TABLE IF EXISTS `tbl_vehicle_rentout_contracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicle_rentout_contracts` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `booking_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(100) DEFAULT NULL,
  `agreement_group_ref_no` varchar(100) DEFAULT NULL,
  `agreement_date` date DEFAULT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(500) DEFAULT NULL,
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `quotation_number` varchar(200) NOT NULL,
  `vehicle_category_id` int(11) DEFAULT NULL,
  `vehicle_model_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `vechile_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `service_type` varchar(100) DEFAULT NULL,
  `service_start_date_time` datetime DEFAULT NULL,
  `service_end_date_time` datetime DEFAULT NULL,
  `contract_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `km_in` decimal(18,3) DEFAULT NULL,
  `km_out` decimal(18,3) DEFAULT NULL,
  `km_used` decimal(18,3) DEFAULT NULL,
  `vehicle_accessories_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `extend_date` date DEFAULT NULL,
  `lease_period` int(11) DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `remarks1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `remarks2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `terms_condition` longtext,
  `vehicle_rentout_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `driver_status` varchar(100) DEFAULT NULL,
  `driver_ids` int(11) DEFAULT NULL,
  `driver_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `customer_driver_name` varchar(1000) DEFAULT NULL,
  `customer_driver_contact_number` varchar(100) DEFAULT NULL,
  `customer_driver_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
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
  `minprice_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `agreement_status` varchar(100) DEFAULT 'Generated',
  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `receiver_name` varchar(1000) DEFAULT NULL,
  `receiver_signature` varchar(1000) DEFAULT NULL,
  `receiver_signature_datetime` datetime DEFAULT NULL,
  `receiver_signed_device` varchar(1000) DEFAULT NULL,
  `receiver_signed_ip` varchar(100) DEFAULT NULL,
  `return_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicle_return_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `close_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `close_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `violations_json` longtext,
  `replaced_vehicle_json` longtext,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbl_vehicles`
--

DROP TABLE IF EXISTS `tbl_vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_vehicles` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `model_names` varchar(1000) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `vehicle_number` varchar(100) NOT NULL,
  `chassis_number` varchar(100) DEFAULT NULL,
  `vehicle_year` int(11) NOT NULL,
  `vehicle_color` varchar(100) NOT NULL,
  `daily_rent` decimal(10,3) DEFAULT '0.000',
  `weekly_rent` decimal(10,3) DEFAULT '0.000',
  `monthly_rent` decimal(10,3) DEFAULT '0.000',
  `mileage_km` int(11) DEFAULT NULL,
  `body_type` varchar(100) DEFAULT NULL,
  `engine_type` varchar(100) DEFAULT NULL,
  `capacity_cc` varchar(50) DEFAULT NULL,
  `transmission` varchar(100) DEFAULT NULL,
  `image_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `other_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_status` varchar(50) NOT NULL DEFAULT 'Available',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_outsourced` enum('Yes','No') DEFAULT 'No',
  `outsourcing_company_id` int(11) DEFAULT '0',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `vehicle_purchase_date` date NOT NULL,
  `next_passing_date` date DEFAULT NULL,
  `passing_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `next_insurance_date` date DEFAULT NULL,
  `insurance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `next_maintenance_date` date DEFAULT NULL,
  `maintenance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `vehicle_status_notes` text,
  `vehicle_status_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `chassis_number` (`chassis_number`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_shortcuts`
--

DROP TABLE IF EXISTS `user_shortcuts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_shortcuts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action_name` varchar(50) DEFAULT NULL,
  `shortcut_key` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`action_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vehicles` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
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
  `company_name` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`ids`),
  KEY `idx_vehicle_status` (`vehicles_status`,`company_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `view_vehicle_details`
--

DROP TABLE IF EXISTS `view_vehicle_details`;
/*!50001 DROP VIEW IF EXISTS `view_vehicle_details`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_vehicle_details` AS SELECT 
 1 AS `ids`,
 1 AS `category_id`,
 1 AS `category_name`,
 1 AS `brand_id`,
 1 AS `brand_name`,
 1 AS `model_id`,
 1 AS `model_name`,
 1 AS `model_names`,
 1 AS `company_id`,
 1 AS `vehicle_number`,
 1 AS `vehicle_year`,
 1 AS `vehicle_color`,
 1 AS `image_json`,
 1 AS `other_details_json`,
 1 AS `vehicle_attachments`,
 1 AS `vehicle_status`,
 1 AS `created_on`,
 1 AS `created_by`,
 1 AS `vehicle_purchase_date`,
 1 AS `next_passing_date`,
 1 AS `passing_histroy`,
 1 AS `next_insurance_date`,
 1 AS `insurance_histroy`,
 1 AS `next_maintenance_date`,
 1 AS `maintenance_histroy`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `view_vehicle_model`
--

DROP TABLE IF EXISTS `view_vehicle_model`;
/*!50001 DROP VIEW IF EXISTS `view_vehicle_model`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `view_vehicle_model` AS SELECT 
 1 AS `model_ids`,
 1 AS `model_name`,
 1 AS `vehicle_modal_pic`,
 1 AS `category_id`,
 1 AS `category_name`,
 1 AS `category_image`,
 1 AS `category_description`,
 1 AS `category_status`,
 1 AS `brand_id`,
 1 AS `brand_name`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'db_fastlink_carrental'
--
/*!50003 DROP PROCEDURE IF EXISTS `generate_quotation_no` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `generate_quotation_no`(IN `p_save_type` VARCHAR(10), IN `p_company_id` INT, IN `p_user_prefix` VARCHAR(100), IN `v_user_id` INT, OUT `p_quotation_no` VARCHAR(30), OUT `p_draft_flag` VARCHAR(5))
BEGIN
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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_log_vehicle_movement` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_log_vehicle_movement`(IN `p_vehicle_id` INT, IN `p_action_type` VARCHAR(50), IN `p_old_status` VARCHAR(50), IN `p_new_status` VARCHAR(50), IN `p_reference_type` VARCHAR(50), IN `p_reference_id` INT, IN `p_reference_no` VARCHAR(100), IN `p_location_from` VARCHAR(100), IN `p_location_to` VARCHAR(100), IN `p_staff_id` INT, IN `p_customer_id` VARCHAR(100), IN `p_garage_id` INT, IN `p_odometer` INT, IN `p_fuel_level` VARCHAR(30), IN `p_remarks` TEXT, IN `p_created_by` INT, IN `p_created_name` VARCHAR(100))
BEGIN

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

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `view_vehicle_details`
--

/*!50001 DROP VIEW IF EXISTS `view_vehicle_details`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`sandsl23`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_vehicle_details` AS select `v`.`ids` AS `ids`,`v`.`category_id` AS `category_id`,`c`.`category_name` AS `category_name`,`v`.`brand_id` AS `brand_id`,`b`.`brand_name` AS `brand_name`,`v`.`model_id` AS `model_id`,`m`.`modal_name` AS `model_name`,`v`.`model_names` AS `model_names`,`v`.`company_id` AS `company_id`,`v`.`vehicle_number` AS `vehicle_number`,`v`.`vehicle_year` AS `vehicle_year`,`v`.`vehicle_color` AS `vehicle_color`,`v`.`image_json` AS `image_json`,`v`.`other_details_json` AS `other_details_json`,`v`.`vehicle_attachments` AS `vehicle_attachments`,`v`.`vehicle_status` AS `vehicle_status`,`v`.`created_on` AS `created_on`,`v`.`created_by` AS `created_by`,`v`.`vehicle_purchase_date` AS `vehicle_purchase_date`,`v`.`next_passing_date` AS `next_passing_date`,`v`.`passing_histroy` AS `passing_histroy`,`v`.`next_insurance_date` AS `next_insurance_date`,`v`.`insurance_histroy` AS `insurance_histroy`,`v`.`next_maintenance_date` AS `next_maintenance_date`,`v`.`maintenance_histroy` AS `maintenance_histroy` from (((`tbl_vehicles` `v` left join `tbl_vehicle_category` `c` on((`v`.`category_id` = `c`.`ids`))) left join `tbl_vehicle_brand` `b` on((`v`.`brand_id` = `b`.`ids`))) left join `tbl_vehicle_model` `m` on((`v`.`model_id` = `m`.`ids`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_vehicle_model`
--

/*!50001 DROP VIEW IF EXISTS `view_vehicle_model`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`sandsl23`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `view_vehicle_model` AS select `v`.`ids` AS `model_ids`,`v`.`modal_name` AS `model_name`,`v`.`vehicle_modal_pic` AS `vehicle_modal_pic`,`v`.`category_id` AS `category_id`,`c`.`category_name` AS `category_name`,`c`.`category_image` AS `category_image`,`c`.`category_description` AS `category_description`,`c`.`category_status` AS `category_status`,`v`.`brand_id` AS `brand_id`,`b`.`brand_name` AS `brand_name` from ((`tbl_vehicle_model` `v` left join `tbl_vehicle_category` `c` on((`v`.`category_id` = `c`.`ids`))) left join `tbl_vehicle_brand` `b` on((`v`.`brand_id` = `b`.`ids`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-19 17:02:37
