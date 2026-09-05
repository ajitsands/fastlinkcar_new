-- MySQL dump 10.13  Distrib 8.0.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: aacar_local
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
  UNIQUE KEY `booking_id` (`booking_id`),
  CONSTRAINT `booking_info_chk_1` CHECK (json_valid(`drivers`)),
  CONSTRAINT `booking_info_chk_2` CHECK (json_valid(`vehicles`)),
  CONSTRAINT `booking_info_chk_3` CHECK (json_valid(`clients`))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_info`
--

LOCK TABLES `booking_info` WRITE;
/*!40000 ALTER TABLE `booking_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50003 TRIGGER `trg_booking_id` BEFORE INSERT ON `booking_info` FOR EACH ROW BEGIN

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
  UNIQUE KEY `uk_invoice_no` (`cashmemo_no`),
  CONSTRAINT `cashmemo_chk_1` CHECK (json_valid(`items`))
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cashmemo`
--

LOCK TABLES `cashmemo` WRITE;
/*!40000 ALTER TABLE `cashmemo` DISABLE KEYS */;
INSERT INTO `cashmemo` VALUES (1,'AA/2026/CM/0001','2026-06-28','C0003','Client1','112424','ancy@gmail.com','23423423','tets',4,4,'AA/2026/AGR/0004',1,'565656',4,'NISSAN MICRA','white','[{\"item_name\":\"deposit\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.08000,12.00000,10.00,1.2000,10.8000,1.08000,20.00000,'2026-06-28 11:17:48','No',NULL,1,'admin',1,'AA Car Rental','3saedsa','Cash','2026-06-17','123',NULL,NULL,NULL,NULL,NULL,NULL),(2,'AA/2026/CM/0002','2026-06-28','C0003','Client1','112424','ancy@gmail.com','23423423','tets',4,4,'AA/2026/AGR/0004',1,'565656',4,'NISSAN MICRA','white','[{\"item_name\":\"DEPOSIT\",\"qty\":\"1\",\"price\":\"20\",\"vat\":\"10\",\"total\":\"22.000\"}]',21.80000,20.00000,10.00,2.0000,18.0000,1.80000,19.80000,'2026-06-28 11:26:19','No',NULL,1,'admin',1,'AA Car Rental','','Cheque','2026-07-01','',NULL,NULL,NULL,NULL,NULL,NULL),(3,'AA/2026/CM/0003','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Deposit\",\"qty\":\"1\",\"price\":\"1\",\"vat\":\"10\",\"total\":\"1.100\"}]',1.10000,1.00000,0.00,0.0000,1.0000,0.10000,1.10000,'2026-07-12 13:15:33','No',NULL,1,'admin',1,'AA Car Rental','123','Benefit',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(4,'AA/2026/CM/0004','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Payment\",\"qty\":\"1\",\"price\":\"1\",\"vat\":\"10\",\"total\":\"1.100\"}]',1.10000,1.00000,0.00,0.0000,1.0000,0.10000,1.10000,'2026-07-12 13:16:43','No',NULL,1,'admin',1,'AA Car Rental','234','Benefit',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(5,'AA/2026/CM/0005','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Payment\",\"qty\":\"1\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"11.000\"}]',11.00000,10.00000,0.00,0.0000,10.0000,1.00000,11.00000,'2026-07-12 13:30:30','No',NULL,1,'admin',1,'AA Car Rental','22222','Cheque','2026-07-14','1231',NULL,NULL,NULL,NULL,NULL,NULL),(6,'AA/2026/CM/0006','2026-07-15','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Payment\",\"qty\":\"1\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"11.000\"}]',10.90000,10.00000,10.00,1.0000,9.0000,0.90000,9.90000,'2026-07-15 07:15:34','No',NULL,1,'admin',1,'AA Car Rental','','Cash',NULL,'','uploads/signatures/cashmemocomp_6_1784119629.png','AA Car Rental','2026-07-15 15:47:09','uploads/signatures/cashmemocust_6_1784119629.png','we','2026-07-15 15:47:09'),(7,'AA/2026/CM/0007','2026-07-15','C0003','Client1','112424','ancy@gmail.com','23423423','tets',3,3,'AA/2026/AGR/0003',2,'333333',3,'NISSAN SUNNY','white','[{\"item_name\":\"Deposit\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.17600,12.00000,2.00,0.2400,11.7600,1.17600,12.93600,'2026-07-15 12:31:11','No',NULL,1,'admin',1,'AA Car Rental','','Cash',NULL,'','uploads/signatures/cashmemocomp_7_1784119354.png','AA','2026-07-15 15:42:34','uploads/signatures/cashmemocust_7_1784119354.png','DD','2026-07-15 15:42:34'),(8,'AA/2026/CM/0008','2026-07-25','C0009','ANZEL SAIT','33661055','anzelabk@gmail.com','850549558','FASTLINK',8,11,'AA/2026/AGR/0008',50,'538745',7,'NISSAN X-TRAIL','GOLD AND BLACK','[{\"item_name\":\"Deposit\",\"qty\":\"1\",\"price\":\"50\",\"vat\":\"10\",\"total\":\"55.000\"}]',55.00000,50.00000,0.00,0.0000,50.0000,5.00000,55.00000,'2026-07-25 08:52:15','No',NULL,65,'ansel',1,'AA Car Rental','','Cash',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(9,'AA/2026/CM/0009','2026-07-25','C0009','ANZEL SAIT','33661055','anzelabk@gmail.com','850549558','FASTLINK',8,11,'AA/2026/AGR/0008',50,'538745',7,'NISSAN X-TRAIL','GOLD AND BLACK','[{\"item_name\":\"Payment\",\"qty\":\"1\",\"price\":\"47.200\",\"vat\":\"10\",\"total\":\"51.920\"}]',51.92000,47.20000,0.00,0.0000,47.2000,4.72000,51.92000,'2026-07-25 08:53:30','No',NULL,65,'ansel',1,'AA Car Rental','','Cash',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(10,'AA/2026/CM/0010','2026-07-25','C0009','ANZEL SAIT','33661055','anzelabk@gmail.com','850549558','FASTLINK',12,15,'AA/2026/AGR/0012',50,'538745',7,'NISSAN X-TRAIL','GOLD AND BLACK','[{\"item_name\":\"Advance\",\"qty\":\"1\",\"price\":\"50\",\"vat\":\"10\",\"total\":\"55.000\"}]',55.00000,50.00000,0.00,0.0000,50.0000,5.00000,55.00000,'2026-07-25 09:05:45','No',NULL,65,'ansel',1,'AA Car Rental','','Cash',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `cashmemo` ENABLE KEYS */;
UNLOCK TABLES;

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
  `customer_email` varchar(200) DEFAULT NULL,
  `customer_addr` text,
  `customer_attn` varchar(1000) DEFAULT NULL,
  `customer_cr_cpr` varchar(100) DEFAULT NULL,
  `cpr_expiry_date` date DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `customer_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `client_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `driver_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `company_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `updated_on` datetime DEFAULT NULL,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `customer_id` (`customer_id`),
  KEY `idx_customer_name` (`customer_name`),
  KEY `idx_customer_mobile` (`customer_mobile`),
  CONSTRAINT `customer_details_chk_1` CHECK (json_valid(`customer_address`)),
  CONSTRAINT `customer_details_chk_2` CHECK (json_valid(`client_docs`)),
  CONSTRAINT `customer_details_chk_3` CHECK (json_valid(`driver_docs`))
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_details`
--

LOCK TABLES `customer_details` WRITE;
/*!40000 ALTER TABLE `customer_details` DISABLE KEYS */;
INSERT INTO `customer_details` VALUES (1,'C0001','ABC','12121','abc@gmail.com','Manama, Kingdom of Bahrain','tsse','212324333','2026-07-09','Individual',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-06-20 00:00:00',1,1,'Inactive','2026-08-18 12:43:32'),(2,'C0002','EFG','34343434','efg@gmail.com','test','test','124324324324','2026-07-10','Corporate',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-06-20 00:00:00',1,1,'Active',NULL),(3,'C0003','Client1','112424','ancy@gmail.com','tets','tedst','23423423','2026-07-11','Individual',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-06-22 00:00:00',1,64,'Active',NULL),(4,'C0004','fedaa zuhair ','66995029','fedaa_zuhair@outlook.com ','00','.','971208638',NULL,'Individual',NULL,'[]',NULL,'2026-06-29 13:47:36',1,NULL,'Active',NULL),(5,'C0005','ruel','37338987',NULL,'blk 340 bld 176 rd 4005 mannai plaz ajuffair',NULL,'761134395',NULL,'Individual',NULL,'[]',NULL,'2026-06-29 13:53:29',1,NULL,'Active',NULL),(6,'C0006','zainab ali hassan ahmed altaweel','39976780',NULL,'abu bham blk 367 rd 6706 villa 243',NULL,'850405270',NULL,'Individual',NULL,'[]',NULL,'2026-06-29 15:59:05',1,NULL,'Active',NULL),(7,'C0007','MOF','66666585','Ali8720039@gmail.com','Salmabad - Bahrain','Mr .Ali Hussain',NULL,NULL,'Corporate',NULL,'[]',NULL,'2026-06-30 01:01:13',1,NULL,'Active',NULL),(8,'C0008','FARZANAH ZIAUL HUSSAIN ZIAEEN','34477913','ANZEL@FASTLINK.US','FASTLINK','GOOD','690611536','2026-10-07','Individual',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-07-06 00:00:00',1,1,'Active',NULL),(9,'C0009','ANZEL SAIT','33661055','anzelabk@gmail.com','FASTLINK','BAD CUSTOMER','850549558','2026-09-07','Individual',NULL,'\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"test\\\",\\\"files\\\":[\\\"uploads\\/customerdocs\\/webp\\/file_6a84434dc7eeb1.52620425.webp\\\"]}]}\"',NULL,'2026-07-06 00:00:00',1,1,'Active',NULL),(10,'C0010','Tanu','123123','tanu@gmail.com','test','test','212121',NULL,'Agency',NULL,'[]',NULL,'2026-07-11 12:43:51',1,NULL,'Active',NULL),(11,'C0011','ANZEL',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'[]',NULL,'2026-07-14 17:45:50',1,NULL,'Active',NULL),(12,'C0012','ANGEL','37333099','ANGEL@FASTLINK.US','ADLIYA','OK','870242067','2027-01-01','Individual',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-07-14 00:00:00',1,1,'Active',NULL),(13,'C0013','JEFFREY CARRILLO','34516411','jbicena0@gmail.com','Hoora, Manama','','7512002004','2027-05-05','Individual',NULL,'\"{\\\"vehicles\\\":[]}\"',NULL,'2026-07-23 00:00:00',1,1,'Active','2026-08-18 14:25:00'),(14,'C0014','Sinto','123123','sinto@gmail.com','test','test','1232134','2026-08-19','Individual',NULL,'{\"vehicles\":[{\"documentName\":\"ttt\",\"files\":[\"uploads\\/customerdocs\\/webp\\/file_6a8c16afdf14b1.85634139.webp\"]},{\"documentName\":\"yy\",\"files\":[\"uploads\\/customerdocs\\/webp\\/file_6a8c16b7e5c807.59806943.webp\"]}]}',NULL,'2026-08-24 13:02:37',1,NULL,'Active',NULL),(15,'C0015','IAn','234234','ian@gmail.com','test','sdrw','234234','2029-01-01','Individual',NULL,'{\"vehicles\":[{\"documentName\":\"y\",\"files\":[\"uploads\\/customerdocs\\/webp\\/file_6a947bb04f5769.96936108.webp\"]}]}',NULL,'2026-08-30 21:51:33',1,NULL,'Active',NULL);
/*!40000 ALTER TABLE `customer_details` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50003 TRIGGER `trg_customer_id` BEFORE INSERT ON `customer_details` FOR EACH ROW BEGIN

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
-- Dumping data for table `document_sequences`
--

LOCK TABLES `document_sequences` WRITE;
/*!40000 ALTER TABLE `document_sequences` DISABLE KEYS */;
INSERT INTO `document_sequences` VALUES (10,'QD',2026,1,4,1,'2026-07-13 15:37:27'),(11,'QD',2026,2,1,1,'2026-08-23 17:48:00'),(9,'QT',2026,1,5,1,'2026-06-20 13:40:08'),(8,'PO',2026,1,0,1,'2026-06-05 21:25:55'),(12,'QT',2026,2,4,1,'2026-08-23 17:49:13');
/*!40000 ALTER TABLE `document_sequences` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `uk_invoice_no` (`expensevoucher_no`),
  CONSTRAINT `expensevoucher_chk_1` CHECK (json_valid(`items`))
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expensevoucher`
--

LOCK TABLES `expensevoucher` WRITE;
/*!40000 ALTER TABLE `expensevoucher` DISABLE KEYS */;
INSERT INTO `expensevoucher` VALUES (1,'AA/2026/EV/0001','2026-06-28','C0003','Client1','112424','ancy@gmail.com','23423423','tets',4,4,'AA/2026/AGR/0004',1,'565656',4,'NISSAN MICRA','white','[{\"item_name\":\"payment\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.08000,12.00000,10.00,1.2000,10.8000,1.08000,11.88000,'2026-06-28 11:17:48','No',NULL,1,'admin',1,'AA Car Rental','3saedsa','Cash','2026-06-17','123',NULL,NULL,NULL,NULL,NULL,NULL),(2,'AA/2026/EV/0002','2026-06-28','C0003','Client1','112424','ancy@gmail.com','23423423','tets',4,4,'AA/2026/AGR/0004',1,'565656',4,'NISSAN MICRA','white','[{\"item_name\":\"payment\",\"qty\":\"1\",\"price\":\"20\",\"vat\":\"10\",\"total\":\"22.000\"}]',21.80000,20.00000,10.00,2.0000,18.0000,1.80000,19.80000,'2026-06-28 11:26:19','No',NULL,1,'admin',1,'AA Car Rental','','Cheque','2026-07-01','',NULL,NULL,NULL,NULL,NULL,NULL),(3,'AA/2026/EV/0003','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Payment\",\"qty\":\"1\",\"price\":\"1\",\"vat\":\"10\",\"total\":\"1.100\"}]',1.10000,1.00000,0.00,0.0000,1.0000,0.10000,1.10000,'2026-07-12 13:15:33','No',NULL,1,'admin',1,'AA Car Rental','123','Benefit',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(4,'AA/2026/EV/0004','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"refund\",\"qty\":\"1\",\"price\":\"1\",\"vat\":\"10\",\"total\":\"1.100\"}]',1.10000,1.00000,0.00,0.0000,1.0000,0.10000,1.10000,'2026-07-12 13:16:43','No',NULL,1,'admin',1,'AA Car Rental','234','Benefit',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL),(5,'AA/2026/EV/0005','2026-07-12','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Refund\",\"qty\":\"1\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"11.000\"}]',11.00000,10.00000,0.00,0.0000,10.0000,1.00000,11.00000,'2026-07-12 13:30:30','No',NULL,1,'admin',1,'AA Car Rental','22222','Cheque','2026-07-14','1231',NULL,NULL,NULL,NULL,NULL,NULL),(6,'AA/2026/EV/0006','2026-07-14','C0010','Tanu','123123','tanu@gmail.com','212121','test',7,10,'AA/2026/AGR/0007',2,'157720',6,'NISSAN SUNNY','WHITE','[{\"item_name\":\"Refund\",\"qty\":\"1\",\"price\":\"120\",\"vat\":\"10\",\"total\":\"132.000\"}]',132.00000,120.00000,0.00,0.0000,120.0000,12.00000,132.00000,'2026-07-14 21:44:14','No',NULL,1,'admin',1,'AA Car Rental','tttrg345','Cash',NULL,'','uploads/signatures/expensevouchercomp_6_1784119703.png','RR','2026-07-15 15:48:23','uploads/signatures/expensevouchercust_6_1784119703.png','VV','2026-07-15 15:48:23'),(7,'AA/2026/EV/0007','2026-07-25','C0009','ANZEL SAIT','33661055','anzelabk@gmail.com','850549558','FASTLINK',12,15,'AA/2026/AGR/0012',50,'538745',7,'NISSAN X-TRAIL','GOLD AND BLACK','[{\"item_name\":\"Refund\",\"qty\":\"1\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"11.000\"}]',11.00000,10.00000,0.00,0.0000,10.0000,1.00000,11.00000,'2026-07-25 09:08:35','No',NULL,65,'ansel',1,'AA Car Rental','','Cash',NULL,'',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `expensevoucher` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `uk_invoice_no` (`invoice_no`),
  CONSTRAINT `invoices_chk_1` CHECK (json_valid(`items`))
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (1,'2026-06-20','AA/2026/PO/0001','2026-06-20','C0001','ABC','12121','abc@gmail.com','212324333','Manama, Kingdom of Bahrain','[{\"contract_id\":\"1\",\"agreement_no\":\"\\n                        AA\\/2026\\/AGR\\/0001\\n                    \",\"vehicle_id\":\"1\",\"booking_ids\":\"1\",\"vehicle_model_id\":\"1\",\"model_name\":\"NISSAN MICRA\",\"vehicleno\":\"12345\",\"item_name\":\"Rental Without Driver\",\"period_from\":\"2026-06-01\",\"period_to\":\"2026-06-18\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.20000,12.00000,0.00,0.0000,0.0000,1.20000,13.20000,'2026-06-20 14:16:28','No','0',1,'admin',1,'AA Car Rental','test','1111','123123213123','2323'),(2,'2026-06-23','AA/2026/PO/0002','2026-06-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"contract_id\":\"4\",\"agreement_no\":\"\\n                        AA\\/2026\\/AGR\\/0004\\n                    \",\"vehicle_id\":\"4\",\"booking_ids\":\"4\",\"vehicle_model_id\":\"1\",\"model_name\":\"NISSAN MICRA\",\"vehicleno\":\"565656\",\"item_name\":\"test\",\"period_from\":\"2026-07-01\",\"period_to\":\"2026-07-10\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.20000,12.00000,0.00,0.0000,0.0000,1.20000,13.20000,'2026-06-23 09:32:14','No','0',1,'admin',1,'AA Car Rental','12','233','123','23'),(3,'2026-07-13','AA/2026/PO/0003','2026-07-13','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"contract_id\":\"6\",\"agreement_no\":\"\\n                        AA\\/2026\\/AGR\\/0006\\n                    \",\"vehicle_id\":\"5\",\"booking_ids\":\"9\",\"vehicle_model_id\":\"2\",\"model_name\":\"NISSAN SUNNY\",\"vehicleno\":\"157763\",\"item_name\":\"Advance\",\"period_from\":\"2026-07-17\",\"period_to\":\"2026-07-27\",\"qty\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\"}]',13.20000,12.00000,0.00,0.0000,0.0000,1.20000,13.20000,'2026-07-13 09:26:23','No','0',1,'admin',1,'AA Car Rental','tt','12221','433434','4353');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `quotation_no` (`quotation_no`),
  CONSTRAINT `quotations_chk_1` CHECK (json_valid(`items`))
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `quotations`
--

LOCK TABLES `quotations` WRITE;
/*!40000 ALTER TABLE `quotations` DISABLE KEYS */;
INSERT INTO `quotations` VALUES (1,'PM','AA/2026/PM/0001','2026-06-20','C0001','ABC','12121','abc@gmail.com',NULL,'Manama, Kingdom of Bahrain','[{\"item_name\":\"NISSAN MICRA\",\"item_model_id\":\"1\",\"item_model_pic\":\"micra.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-06-01T11:09\",\"period_to\":\"2026-06-18T11:09\",\"qty\":\"1\",\"price\":\"6\",\"duration\":\"408\",\"vat\":\"10\",\"total\":\"2692.800\"}]',2692.80000,2448.00000,0.00,0.0000,0.0000,244.80000,2692.80000,'2026-06-20 08:10:08','No','0',1,'Admin',1,'AA Car Rental','tsse','<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><br></p>','Approved'),(2,'CM','AA/2026/CM/0002','2026-06-23','C0001','ABC','12121','abc@gmail.com','212324333','Manama, Kingdom of Bahrain','[{\"item_name\":\"NISSAN MICRA\",\"item_model_id\":\"1\",\"item_model_pic\":\"micra.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-06-24T10:35\",\"period_to\":\"2026-07-09T10:35\",\"qty\":\"1\",\"price\":\"8\",\"duration\":\"360\",\"vat\":\"10\",\"total\":\"3168.000\"}]',3168.00000,2880.00000,0.00,0.0000,0.0000,288.00000,3168.00000,'2026-06-23 07:55:54','No','0',1,'admin',1,'AA Car Rental','tsse','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','Approved'),(3,'ABC','QD/AA/2026/ABC/0001','2026-07-13','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"AUDI A3\",\"item_model_id\":\"32\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-07-13T13:07\",\"period_to\":\"2026-07-22T13:07\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"216\",\"vat\":\"10\",\"total\":\"2851.200\"}]',2851.20000,2592.00000,0.00,0.0000,0.0000,259.20000,2851.20000,'2026-07-13 10:07:27','Yes','0',1,'admin',1,'AA Car Rental','tedst','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','Not Approved'),(4,'ABC','AA/2026/ABC/0003','2026-07-25','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"NISSAN X-TRAIL\",\"item_model_id\":\"50\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-07-17T12:12\",\"period_to\":\"2026-07-27T12:12\",\"qty\":\"1\",\"price\":\"28\",\"duration\":\"10\",\"vat\":\"10\",\"total\":\"308.000\"},{\"item_name\":\"NISSAN MICRA\",\"item_model_id\":\"1\",\"item_model_pic\":\"micra.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-07-26T12:13\",\"period_to\":\"2026-07-27T12:13\",\"qty\":\"1\",\"price\":\"8\",\"duration\":\"1\",\"vat\":\"10\",\"total\":\"8.800\"}]',316.80000,288.00000,0.00,0.0000,0.0000,28.80000,316.80000,'2026-07-25 09:14:02','No','0',65,'ansel',1,'AA Car Rental','tedst','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','Approved'),(5,'tt','AA/2026/tt/0004','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"CHEVROLET TAHOE\",\"item_model_id\":\"61\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-23T13:13\",\"period_to\":\"2026-08-24T13:13\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"24\",\"vat\":\"10\",\"total\":\"316.800\"}]',316.80000,288.00000,0.00,0.0000,288.0000,28.80000,316.80000,'2026-08-23 10:13:46','No','0',1,'admin',1,'AA Car Rental','tedst','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','Not Approved'),(6,'NX','QD/AA/2026/NX/0002','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"CHANGAN ALSVIN\",\"item_model_id\":\"3\",\"item_model_pic\":\"alsvin.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-23T17:43\",\"period_to\":\"2026-08-23T19:45\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"3\",\"vat\":\"10\",\"total\":\"39.600\"}]',39.60000,36.00000,0.00,0.0000,36.0000,3.60000,39.60000,'2026-08-23 14:44:02','Yes','0',1,'admin',1,'AA Car Rental','tedst','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','Not Approved'),(7,'NX','QD/AA/2026/NX/0003','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"BMW 5 SERIES\",\"item_model_id\":\"36\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-08-23T17:45\",\"period_to\":\"2026-08-25T17:45\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"2\",\"vat\":\"10\",\"total\":\"22.000\"}]',22.00000,20.00000,1.00,0.2000,19.8000,1.98000,21.78000,'2026-08-23 14:45:47','Yes','0',1,'admin',1,'AA Car Rental','tedst','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over </span><strong style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">100 languages, including Arabic</strong><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, </span><em style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"><u>though context-aware</u></em><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"> nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','Not Approved'),(8,'WS','QD/AA/2026/WS/0004','2026-08-23','C0010','Tanu','123123','tanu@gmail.com','212121','test','[{\"item_name\":\"CHEVROLET TAHOE\",\"item_model_id\":\"61\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"week\",\"rate_type_name\":\"Weekly\",\"period_from\":\"2026-08-23T17:46\",\"period_to\":\"2026-08-31T17:46\",\"qty\":\"1\",\"price\":\"30\",\"duration\":\"2\",\"vat\":\"10\",\"total\":\"66.000\"}]',66.00000,60.00000,5.00,3.0000,57.0000,5.70000,62.70000,'2026-08-23 14:46:59','Yes','0',1,'admin',1,'AA Car Rental','test','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p><br></p>','Not Approved'),(9,'NX','QD/CR/2026/NX/0001','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"CHANGAN ALSVIN\",\"item_model_id\":\"3\",\"item_model_pic\":\"alsvin.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-23T17:47\",\"period_to\":\"2026-08-24T17:47\",\"qty\":\"1\",\"price\":\"2\",\"duration\":\"24\",\"vat\":\"10\",\"total\":\"52.800\"}]',52.80000,48.00000,2.00,0.9600,47.0400,4.70400,51.74400,'2026-08-23 14:48:00','Yes','0',1,'admin',2,'AA Car Rental','tedst','<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>','<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','Not Approved'),(10,'NX','CR/2026/NX/0001','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"CHANGAN ALSVIN\",\"item_model_id\":\"3\",\"item_model_pic\":\"alsvin.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-23T17:47\",\"period_to\":\"2026-08-24T17:47\",\"qty\":\"1\",\"price\":\"2\",\"duration\":\"24\",\"vat\":\"10\",\"total\":\"52.800\"}]',52.80000,48.00000,2.00,0.9600,47.0400,4.70400,51.74400,'2026-08-23 14:49:13','No','0',1,'admin',2,'AA Car Rental','tedst','<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>','<p><strong>Terms and Condition</strong></p><p><span style=\"color: rgba(0, 0, 0, 0.96); background-color: rgb(255, 255, 255);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol>','Not Approved'),(11,'NX','CR/2026/NX/0002','2026-08-23','C0003','Client1','112424','ancy@gmail.com','23423423','tets','[{\"item_name\":\"CHANGAN ALSVIN\",\"item_model_id\":\"3\",\"item_model_pic\":\"alsvin.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-23T17:47\",\"period_to\":\"2026-08-24T17:47\",\"qty\":\"1\",\"price\":\"2\",\"duration\":\"24\",\"vat\":\"10\",\"total\":\"52.800\"}]',52.80000,48.00000,2.00,0.9600,47.0400,4.70400,51.74400,'2026-08-23 14:49:32','No','0',1,'admin',2,'AA Car Rental','tedst','<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>','<p><strong>Terms and Condition</strong></p><p><span style=\"color: rgba(0, 0, 0, 0.96); background-color: rgb(255, 255, 255);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol>','Approved'),(12,'TT','CR/2026/TT/0003','2026-08-24','C0014','Sinto','123123','sinto@gmail.com','1232134','test','[{\"item_name\":\"AUDI A3\",\"item_model_id\":\"32\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-24 12:00\",\"period_to\":\"2026-08-24 15:30\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"4\",\"vat\":\"10\",\"total\":\"44.000\"},{\"item_name\":\"BMW 5 SERIES\",\"item_model_id\":\"36\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-08-24 11:00\",\"period_to\":\"2026-08-24 12:00\",\"qty\":\"1\",\"price\":\"50\",\"duration\":\"1\",\"vat\":\"0\",\"total\":\"50.000\"}]',94.00000,90.00000,10.00,9.0000,81.0000,3.60000,84.60000,'2026-08-24 10:07:42','No','0',1,'admin',2,'AA Car Rental','test','<p>TEst</p>','<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','Not Approved'),(13,'TT','CR/2026/TT/0004','2026-08-24','C0014','Sinto','123123','sinto@gmail.com','1232134','test','[{\"item_name\":\"CHEVROLET TAHOE\",\"item_model_id\":\"61\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-08-25 12:00\",\"period_to\":\"2026-08-27 12:00\",\"qty\":\"1\",\"price\":\"4\",\"duration\":\"48\",\"vat\":\"10\",\"total\":\"211.200\"},{\"item_name\":\"FORD EXPEDITION\",\"item_model_id\":\"59\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"week\",\"rate_type_name\":\"Weekly\",\"period_from\":\"2026-08-25 12:00\",\"period_to\":\"2026-09-05 12:00\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"2\",\"vat\":\"0\",\"total\":\"20.000\"}]',231.20000,212.00000,5.00,10.6000,201.4000,18.24000,219.64000,'2026-08-24 10:17:45','No','0',1,'admin',2,'AA Car Rental','test','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>','<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','Not Approved'),(14,'RR','AA/2026/RR/0005','2026-08-24','C0014','Sinto','123123','sinto@gmail.com','1232134','test','[{\"item_name\":\"BMW 5 SERIES\",\"item_model_id\":\"36\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-02-22 12:15\",\"period_to\":\"2026-02-25 23:12\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"4\",\"vat\":\"10\",\"total\":\"52.800\"}]',52.80000,48.00000,0.00,0.0000,48.0000,4.80000,52.80000,'2026-08-24 12:27:04','No','0',1,'admin',1,'AA Car Rental','test','<p><br></p>','<p><br></p>','Not Approved');
/*!40000 ALTER TABLE `quotations` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `shortcut_actions`
--

LOCK TABLES `shortcut_actions` WRITE;
/*!40000 ALTER TABLE `shortcut_actions` DISABLE KEYS */;
INSERT INTO `shortcut_actions` VALUES (1,'open_dashboard','Open Dashboard','Alt+D'),(2,'open_sales','Open Sales','Alt+S'),(3,'open_purchase','Open Purchase','Alt+P'),(4,'open_accounts','Open Accounts','Alt+A'),(5,'new_invoice','New Invoice','Ctrl+I'),(6,'save_record','Save Record','Ctrl+S'),(7,'search','Search','Ctrl+F'),(8,'logout','Logout','Alt+L');
/*!40000 ALTER TABLE `shortcut_actions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_banks`
--

DROP TABLE IF EXISTS `tbl_banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_banks` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `bank_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `account_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company_id` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_banks`
--

LOCK TABLES `tbl_banks` WRITE;
/*!40000 ALTER TABLE `tbl_banks` DISABLE KEYS */;
INSERT INTO `tbl_banks` VALUES (1,'AL Salam Bank','9895016611',1,'2026-04-21 15:53:29'),(2,'AL Salam Bank','9895016611',1,'2026-04-21 15:56:57'),(3,'Alsalam Bank','1252222',1,'2026-04-22 02:02:31'),(4,'Federal Bank','0783058935',1,'2026-04-22 02:07:53'),(5,'yy','34543',1,'2026-05-27 22:38:32');
/*!40000 ALTER TABLE `tbl_banks` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_company`
--

LOCK TABLES `tbl_company` WRITE;
/*!40000 ALTER TABLE `tbl_company` DISABLE KEYS */;
INSERT INTO `tbl_company` VALUES (1,'AA','AA Car Rental','assets/img/logo/logo.jpg','Active'),(2,'CR','Class Rental car','assets/img/logo/logo_classic.png','Active');
/*!40000 ALTER TABLE `tbl_company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_customer_ledger`
--

DROP TABLE IF EXISTS `tbl_customer_ledger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_customer_ledger` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `customer_code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `quotation_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `booking_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `trans_date` date NOT NULL,
  `cheque_date` date DEFAULT NULL,
  `trans_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `payment_method` enum('Cash','Cheque','BankTransfer','CreditCard','Other','N/A') COLLATE utf8mb4_general_ci DEFAULT 'N/A',
  `bank_id` int(11) DEFAULT NULL,
  `company_bank_id` int(11) DEFAULT NULL,
  `debit` decimal(18,5) DEFAULT '0.00000',
  `credit` decimal(18,5) DEFAULT '0.00000',
  `ref_no` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cheque_status` enum('Pending','Collected','Bounced') COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `collected_at` datetime DEFAULT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `booking_ids` int(11) DEFAULT NULL,
  `contract_ids` int(11) DEFAULT NULL,
  `agreement_no` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`ids`),
  KEY `idx_customer` (`customer_code`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_customer_ledger`
--

LOCK TABLES `tbl_customer_ledger` WRITE;
/*!40000 ALTER TABLE `tbl_customer_ledger` DISABLE KEYS */;
INSERT INTO `tbl_customer_ledger` VALUES (1,'C0001','AA/2026/PM/0001','AA/2026/RS/0001','2026-06-20',NULL,'Rental Without Driver','N/A',NULL,NULL,2448.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-06-20 06:04:10',1,1,'AA/2026/AGR/0001'),(2,'C0001','AA/2026/PM/0001','AA/2026/RS/0001','2026-06-20',NULL,'VAT','N/A',NULL,NULL,244.80000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-06-20 06:04:10',1,1,'AA/2026/AGR/0001'),(3,'C0001','AA/2026/PM/0001','AA/2026/RS/0001','2026-06-20',NULL,'Rental Without Driver','N/A',NULL,NULL,3794.00000,0.00000,NULL,'Pending',NULL,'Auto Post Extension Fee',1,1,'2026-06-20 11:44:18',1,1,'AA/2026/AGR/0001'),(4,'C0002','','AA/2026/RS/0002','2026-06-20',NULL,'Rental Without Driver','N/A',NULL,NULL,108.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-06-20 14:20:20',2,2,'AA/2026/AGR/0002'),(5,'C0002','','AA/2026/RS/0002','2026-06-20',NULL,'VAT','N/A',NULL,NULL,10.80000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-06-20 14:20:20',2,2,'AA/2026/AGR/0002'),(6,'C0002',NULL,'AA/2026/RS/0002','2026-06-20','2026-06-30','\n                            Payment\n                        ','Cheque',1,1,0.00000,10.00000,'','Collected','2026-06-20 21:37:12','',1,1,'2026-06-20 18:37:01',2,2,'AA/2026/AGR/0002'),(7,'C0003','','AA/2026/RS/0003','2026-06-22',NULL,'Rental With Driver','N/A',NULL,NULL,250.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',64,1,'2026-06-22 06:13:05',3,3,'AA/2026/AGR/0003'),(8,'C0003',NULL,'AA/2026/RS/0003','2026-06-22','2026-06-17','\n                            Deposit\n                        ','Cheque',1,4,0.00000,100.00000,'','Collected','2026-06-22 11:47:54','test',64,1,'2026-06-22 08:45:58',3,3,'AA/2026/AGR/0003'),(9,'C0003',NULL,'AA/2026/RS/0003','2026-06-22',NULL,'\n                            Violation Fee\n                        ','N/A',NULL,NULL,100.00000,0.00000,'','Pending',NULL,'',64,1,'2026-06-22 08:46:56',3,3,'AA/2026/AGR/0003'),(10,'C0003','3453','AA/2026/RS/0003','2026-06-22',NULL,'Rental With Driver','N/A',NULL,NULL,180.00000,0.00000,NULL,'Pending',NULL,'Auto Post Extension Fee',64,1,'2026-06-22 06:19:01',3,3,'AA/2026/AGR/0003'),(11,'C0003','','AA/2026/RS/0004','2026-06-22',NULL,'Rental Without Driver','N/A',NULL,NULL,90.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',64,1,'2026-06-22 06:52:26',4,4,'AA/2026/AGR/0004'),(12,'C0003','','AA/2026/RS/0004','2026-06-22',NULL,'VAT','N/A',NULL,NULL,9.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',64,1,'2026-06-22 06:52:26',4,4,'AA/2026/AGR/0004'),(13,'C0003','','AA/2026/RS/0004','2026-06-28','2026-06-17','AA/2026/CM/0001','Cash',NULL,NULL,0.00000,10.80000,'123','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0001',1,1,'2026-06-28 11:17:48',4,4,'AA/2026/AGR/0004'),(14,'C0003','','AA/2026/RS/0004','2026-06-28','2026-06-17','AA/2026/CM/0001','Cash',NULL,NULL,0.00000,1.08000,'123','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0001',1,1,'2026-06-28 11:17:48',4,4,'AA/2026/AGR/0004'),(15,'C0003','','AA/2026/RS/0004','2026-06-28',NULL,'AA/2026/CM/0001','N/A',NULL,NULL,1.20000,0.00000,NULL,'Pending',NULL,'Discount Auto Post From Receipt AA/2026/CM/0001',1,1,'2026-06-28 11:17:48',4,4,'AA/2026/AGR/0004'),(16,'C0003','','AA/2026/RS/0004','2026-06-28','2026-07-01','AA/2026/CM/0002','Cheque',NULL,NULL,0.00000,18.00000,'','Collected','2026-06-28 14:27:36','Auto Post From Receipt AA/2026/CM/0002',1,1,'2026-06-28 11:26:19',4,4,'AA/2026/AGR/0004'),(17,'C0003','','AA/2026/RS/0004','2026-06-28','2026-07-01','AA/2026/CM/0002','Cheque',NULL,NULL,0.00000,1.80000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0002',1,1,'2026-06-28 11:26:19',4,4,'AA/2026/AGR/0004'),(18,'C0003','','AA/2026/RS/0004','2026-06-28',NULL,'AA/2026/CM/0002','N/A',NULL,NULL,0.00000,2.00000,NULL,'Pending',NULL,'Discount Auto Post From Receipt AA/2026/CM/0002',1,1,'2026-06-28 11:26:19',4,4,'AA/2026/AGR/0004'),(19,'C0001','AA/2026/PM/0001','AA/2026/RS/0001','2026-06-29',NULL,'Rental Without Driver','N/A',NULL,NULL,2448.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-06-29 06:04:14',1,1,'AA/2026/AGR/0001'),(20,'C0001','AA/2026/PM/0001','AA/2026/RS/0001','2026-06-29',NULL,'VAT','N/A',NULL,NULL,244.80000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-06-29 06:04:14',1,1,'AA/2026/AGR/0001'),(21,'C0003','','AA/2026/RS/0008','2026-07-11',NULL,'Rental Without Driver','N/A',NULL,NULL,150.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-11 09:44:56',9,6,'AA/2026/AGR/0006'),(22,'C0003','','AA/2026/RS/0008','2026-07-11',NULL,'VAT','N/A',NULL,NULL,15.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-11 09:44:56',9,6,'AA/2026/AGR/0006'),(23,'C0003','','AA/2026/RS/0008','2026-07-11',NULL,'Rental Without Driver','N/A',NULL,NULL,150.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-11 09:44:56',9,6,'AA/2026/AGR/0006'),(24,'C0003','','AA/2026/RS/0008','2026-07-11',NULL,'VAT','N/A',NULL,NULL,15.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-11 09:44:56',9,6,'AA/2026/AGR/0006'),(25,'C0010','','AA/2026/RS/0009','2026-07-11',NULL,'Rental Without Driver','N/A',NULL,NULL,234.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-11 13:20:16',10,7,'AA/2026/AGR/0007'),(26,'C0010','','AA/2026/RS/0009','2026-07-11',NULL,'VAT','N/A',NULL,NULL,23.40000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-11 13:20:16',10,7,'AA/2026/AGR/0007'),(27,'C0010','','AA/2026/RS/0009','2026-07-12',NULL,'AA/2026/CM/0003','Cash',NULL,NULL,0.00000,0.10000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0003',1,1,'2026-07-12 12:50:05',10,7,'AA/2026/AGR/0007'),(28,'C0010','','AA/2026/RS/0009','2026-07-14',NULL,'AA/2026/EV/0006','Cash',NULL,NULL,120.00000,0.00000,'','Pending',NULL,'Auto Post From Receipt AA/2026/EV/0006',1,1,'2026-07-14 21:44:14',10,7,'AA/2026/AGR/0007'),(29,'C0010','','AA/2026/RS/0009','2026-07-14',NULL,'AA/2026/EV/0006','Cash',NULL,NULL,12.00000,0.00000,'','Pending',NULL,'VAT Auto Post From Expense Voucher AA/2026/EV/0006',1,1,'2026-07-14 21:44:14',10,7,'AA/2026/AGR/0007'),(30,'C0010','','AA/2026/RS/0009','2026-07-15',NULL,'AA/2026/CM/0006','Cash',NULL,NULL,0.00000,9.00000,'','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0006',1,1,'2026-07-15 07:15:34',10,7,'AA/2026/AGR/0007'),(31,'C0010','','AA/2026/RS/0009','2026-07-15',NULL,'AA/2026/CM/0006','Cash',NULL,NULL,0.00000,0.90000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0006',1,1,'2026-07-15 07:15:34',10,7,'AA/2026/AGR/0007'),(32,'C0010','','AA/2026/RS/0009','2026-07-15',NULL,'AA/2026/CM/0006','N/A',NULL,NULL,0.00000,1.00000,NULL,'Pending',NULL,'Discount Auto Post From Receipt AA/2026/CM/0006',1,1,'2026-07-15 07:15:34',10,7,'AA/2026/AGR/0007'),(33,'C0003','','AA/2026/RS/0003','2026-07-15',NULL,'AA/2026/CM/0007','Cash',NULL,NULL,0.00000,11.76000,'','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0007',1,1,'2026-07-15 12:31:11',3,3,'AA/2026/AGR/0003'),(34,'C0003','','AA/2026/RS/0003','2026-07-15',NULL,'AA/2026/CM/0007','Cash',NULL,NULL,0.00000,1.17600,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0007',1,1,'2026-07-15 12:31:11',3,3,'AA/2026/AGR/0003'),(35,'C0003','','AA/2026/RS/0003','2026-07-15',NULL,'AA/2026/CM/0007','N/A',NULL,NULL,0.00000,0.24000,NULL,'Pending',NULL,'Discount Auto Post From Receipt AA/2026/CM/0007',1,1,'2026-07-15 12:31:11',3,3,'AA/2026/AGR/0003'),(36,'C0003','','AA/2026/RS/0011','2026-07-23',NULL,'Rental Without Driver','N/A',NULL,NULL,144.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-23 06:36:40',12,9,'AA/2026/AGR/0009'),(37,'C0003','','AA/2026/RS/0011','2026-07-23',NULL,'VAT','N/A',NULL,NULL,14.40000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-23 06:36:40',12,9,'AA/2026/AGR/0009'),(38,'C0003',NULL,'AA/2026/RS/0011','2026-07-23',NULL,'\n                            Delay Fine\n                        ','N/A',NULL,NULL,12.00000,0.00000,'','Pending',NULL,'sd',1,1,'2026-07-23 09:13:54',12,9,'AA/2026/AGR/0009'),(39,'C0005','','AA/2026/RS/0012','2026-07-23',NULL,'Rental Without Driver','N/A',NULL,NULL,20.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-23 10:24:12',13,10,'AA/2026/AGR/0010'),(40,'C0005','','AA/2026/RS/0012','2026-07-23',NULL,'VAT','N/A',NULL,NULL,2.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-23 10:24:12',13,10,'AA/2026/AGR/0010'),(41,'C0009','','AA/2026/RS/0010','2026-07-23',NULL,'Rental Without Driver','N/A',NULL,NULL,2.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-23 10:25:01',11,8,'AA/2026/AGR/0008'),(42,'C0009','','AA/2026/RS/0010','2026-07-23',NULL,'VAT','N/A',NULL,NULL,0.20000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-23 10:25:01',11,8,'AA/2026/AGR/0008'),(43,'C0003','','AA/2026/RS/0013','2026-07-23',NULL,'Rental Without Driver','N/A',NULL,NULL,5768.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-23 10:30:53',14,11,'AA/2026/AGR/0011'),(44,'C0003','','AA/2026/RS/0013','2026-07-23',NULL,'VAT','N/A',NULL,NULL,576.80000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-23 10:30:53',14,11,'AA/2026/AGR/0011'),(45,'C0009',NULL,'AA/2026/RS/0010','2026-07-25',NULL,'\n                            Violation Fee\n                        ','N/A',NULL,NULL,100.00000,0.00000,'','Pending',NULL,'tearfic vio',65,1,'2026-07-25 07:57:24',11,8,'AA/2026/AGR/0008'),(46,'C0009','','AA/2026/RS/0010','2026-07-25',NULL,'AA/2026/CM/0008','Cash',NULL,NULL,0.00000,50.00000,'','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0008',65,1,'2026-07-25 08:52:15',11,8,'AA/2026/AGR/0008'),(47,'C0009','','AA/2026/RS/0010','2026-07-25',NULL,'AA/2026/CM/0008','Cash',NULL,NULL,0.00000,5.00000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0008',65,1,'2026-07-25 08:52:15',11,8,'AA/2026/AGR/0008'),(48,'C0009','','AA/2026/RS/0010','2026-07-25',NULL,'AA/2026/CM/0009','Cash',NULL,NULL,0.00000,47.20000,'','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0009',65,1,'2026-07-25 08:53:30',11,8,'AA/2026/AGR/0008'),(49,'C0009','','AA/2026/RS/0010','2026-07-25',NULL,'AA/2026/CM/0009','Cash',NULL,NULL,0.00000,4.72000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0009',65,1,'2026-07-25 08:53:30',11,8,'AA/2026/AGR/0008'),(50,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'Rental Without Driver','N/A',NULL,NULL,360.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',65,1,'2026-07-25 06:34:15',15,12,'AA/2026/AGR/0012'),(51,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'VAT','N/A',NULL,NULL,36.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',65,1,'2026-07-25 06:34:15',15,12,'AA/2026/AGR/0012'),(52,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'AA/2026/CM/0010','Cash',NULL,NULL,0.00000,50.00000,'','Pending',NULL,'Auto Post From Receipt AA/2026/CM/0010',65,1,'2026-07-25 09:05:45',15,12,'AA/2026/AGR/0012'),(53,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'AA/2026/CM/0010','Cash',NULL,NULL,0.00000,5.00000,'','Pending',NULL,'VAT Auto Post From Receipt AA/2026/CM/0010',65,1,'2026-07-25 09:05:45',15,12,'AA/2026/AGR/0012'),(54,'C0009',NULL,'AA/2026/RS/0014','2026-07-25','2026-07-26','\n                            Deposit\n                        ','Cheque',3,3,0.00000,100.00000,'3243','Collected','2026-07-25 12:07:30','tets',65,1,'2026-07-25 09:07:06',15,12,'AA/2026/AGR/0012'),(55,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'AA/2026/EV/0007','Cash',NULL,NULL,10.00000,0.00000,'','Pending',NULL,'Auto Post From Expense Voucher AA/2026/EV/0007',65,1,'2026-07-25 09:08:35',15,12,'AA/2026/AGR/0012'),(56,'C0009','','AA/2026/RS/0014','2026-07-25',NULL,'AA/2026/EV/0007','Cash',NULL,NULL,1.00000,0.00000,'','Pending',NULL,'VAT Auto Post From Expense Voucher AA/2026/EV/0007',65,1,'2026-07-25 09:08:35',15,12,'AA/2026/AGR/0012'),(57,'C0003','','AA/2026/RS/0015','2026-07-28',NULL,'Rental Without Driver','N/A',NULL,NULL,60.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-28 05:27:49',16,13,'AA/2026/AGR/0013'),(58,'C0003','','AA/2026/RS/0015','2026-07-28',NULL,'VAT','N/A',NULL,NULL,6.00000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-28 05:27:49',16,13,'AA/2026/AGR/0013'),(59,'C0005','','AA/2026/RS/0007','2026-07-28',NULL,'Rental Without Driver','N/A',NULL,NULL,0.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-28 07:08:28',7,5,'AA/2026/AGR/0005'),(60,'C0010','','AA/2026/RS/0016','2026-07-28',NULL,'Rental Without Driver','N/A',NULL,NULL,4.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-07-28 07:39:52',17,14,'AA/2026/AGR/0015'),(61,'C0010','','AA/2026/RS/0016','2026-07-28',NULL,'VAT','N/A',NULL,NULL,0.40000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-07-28 07:39:52',17,14,'AA/2026/AGR/0015'),(62,'C0010','','AA/2026/RS/0016','2026-07-28',NULL,'Rental Without Driver','N/A',NULL,NULL,18.00000,0.00000,NULL,'Pending',NULL,'Auto Post Extension Fee',1,1,'2026-07-28 07:42:34',17,14,'AA/2026/AGR/0015'),(63,'C0010','','AA/2026/RS/0016','2026-07-28',NULL,'VAT','N/A',NULL,NULL,1.80000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Extension Fee',1,1,'2026-07-28 07:42:34',17,14,'AA/2026/AGR/0015'),(64,'','AA/2026/AGR/0010','13','2026-08-01',NULL,'Vehicle Violation','N/A',NULL,NULL,10.00000,0.00000,'AA/2026/AGR/0010','Pending',NULL,'Vehicle Violation: AccidentVioloation (Agreement No: AA/2026/AGR/0010)',1,1,'2026-08-01 11:12:32',13,10,'AA/2026/AGR/0010'),(65,'','AA/2026/AGR/0010','13','2026-08-01',NULL,'Vehicle Violation','N/A',NULL,NULL,12.00000,0.00000,'AA/2026/AGR/0010','Pending',NULL,'Vehicle Violation: Traffice violation (Agreement No: AA/2026/AGR/0010)',1,1,'2026-08-01 11:12:32',13,10,'AA/2026/AGR/0010'),(66,'C0010','','AA/2026/RS/0017','2026-08-01',NULL,'Rental Without Driver','N/A',NULL,NULL,2.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-08-01 12:20:30',18,15,'AA/2026/AGR/0016'),(67,'C0010','','AA/2026/RS/0017','2026-08-01',NULL,'VAT','N/A',NULL,NULL,0.20000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-08-01 12:20:30',18,15,'AA/2026/AGR/0016'),(68,'C0010','AA/2026/AGR/0016','18','2026-08-02',NULL,'Vehicle Violation','N/A',NULL,NULL,1.00000,0.00000,'AA/2026/AGR/0016','Pending',NULL,'Vehicle Violation: ttt (Agreement No: AA/2026/AGR/0016)',1,1,'2026-08-01 12:21:51',18,15,'AA/2026/AGR/0016'),(69,'C0010','AA/2026/AGR/0016','18','2026-08-02',NULL,'Vehicle Violation','N/A',NULL,NULL,2.00000,0.00000,'AA/2026/AGR/0016','Pending',NULL,'Vehicle Violation: yyy (Agreement No: AA/2026/AGR/0016)',1,1,'2026-08-01 12:21:51',18,15,'AA/2026/AGR/0016'),(70,'C0010','AA/2026/AGR/0007','AA/2026/RS/0009','2026-08-01',NULL,'Vehicle Violation','N/A',NULL,NULL,10.00000,0.00000,'AA/2026/AGR/0007','Pending',NULL,'Vehicle Violation: Accident (Agreement No: AA/2026/AGR/0007)',1,1,'2026-08-01 12:30:46',0,7,'AA/2026/AGR/0007'),(71,'C0003','AA/2026/AGR/0006','AA/2026/RS/0008','2026-08-01',NULL,'Vehicle Violation','N/A',NULL,NULL,12.00000,0.00000,'AA/2026/AGR/0006','Pending',NULL,'Vehicle Violation: Violation1 (Remarks: tst) (Agreement No: AA/2026/AGR/0006)',1,1,'2026-08-01 13:35:04',0,6,'AA/2026/AGR/0006'),(72,'C0003','AA/2026/AGR/0006','AA/2026/RS/0008','2026-07-28',NULL,'Vehicle Violation','N/A',NULL,NULL,14.00000,0.00000,'AA/2026/AGR/0006','Pending',NULL,'Vehicle Violation: Violation2 (Remarks: test) (Agreement No: AA/2026/AGR/0006)',1,1,'2026-08-01 13:35:04',0,6,'AA/2026/AGR/0006'),(73,'C0010','','AA/2026/RS/0018','2026-08-01',NULL,'Rental Without Driver','N/A',NULL,NULL,12.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-08-01 13:46:00',19,16,'AA/2026/AGR/0017'),(74,'C0010','','AA/2026/RS/0018','2026-08-01',NULL,'VAT','N/A',NULL,NULL,1.20000,0.00000,NULL,'Pending',NULL,'Auto Post VAT of Rental Fee',1,1,'2026-08-01 13:46:00',19,16,'AA/2026/AGR/0017'),(75,'C0010','AA/2026/AGR/0017','AA/2026/RS/0018','2026-08-01',NULL,'Violation1','N/A',NULL,NULL,12.00000,0.00000,'AA/2026/AGR/0017','Pending',NULL,'Vehicle Violation: Violation1 (Remarks: test) (Agreement No: AA/2026/AGR/0017)',1,1,'2026-08-01 13:47:20',0,16,'AA/2026/AGR/0017'),(76,'C0010','AA/2026/AGR/0017','AA/2026/RS/0018','2026-08-02',NULL,'violation2','N/A',NULL,NULL,13.00000,0.00000,'AA/2026/AGR/0017','Pending',NULL,'Vehicle Violation: violation2 (Remarks: test) (Agreement No: AA/2026/AGR/0017)',1,1,'2026-08-01 13:47:20',0,16,'AA/2026/AGR/0017'),(77,'C0010','','AA/2026/RS/0019','2026-08-01',NULL,'Rental With Driver','N/A',NULL,NULL,168.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-08-01 14:01:55',20,17,'AA/2026/AGR/0018'),(78,'C0010','','20','2026-08-02',NULL,'Vehicle Violation','N/A',NULL,NULL,12.00000,0.00000,'AA/2026/AGR/0018','Pending',NULL,'Vehicle Violation (Replaced Vehicle 12345): Vehicle Violation (Remarks: test) (Agreement No: AA/2026/AGR/0018)',1,1,'2026-08-02 14:08:34',20,17,'AA/2026/AGR/0018'),(79,'C0010','','20','2026-08-02',NULL,'Violation Fee','N/A',NULL,NULL,12.00000,0.00000,'AA/2026/AGR/0018','Pending',NULL,'Vehicle Violation (Replaced Vehicle 12345): Violation Fee (Remarks: test) (Agreement No: AA/2026/AGR/0018)',1,1,'2026-08-02 14:12:16',20,17,'AA/2026/AGR/0018'),(80,'C0010','','20','2026-08-02',NULL,'Violation1','N/A',NULL,NULL,1.00000,0.00000,'AA/2026/AGR/0018','Pending',NULL,'Vehicle Violation (Replaced Vehicle 55555): Violation1 (Remarks: test) (Agreement No: AA/2026/AGR/0018)',1,1,'2026-08-02 14:33:03',20,17,'AA/2026/AGR/0018'),(82,'C0014','','AA/2026/RS/0020','2026-08-30',NULL,'Rental With Driver','N/A',NULL,NULL,276.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,1,'2026-08-30 03:22:43',21,18,'AA/2026/AGR/0030'),(83,'C0014','','AA/2026/RS/0022','2026-08-30',NULL,'Rental With Driver','N/A',NULL,NULL,450.00000,0.00000,NULL,'Pending',NULL,'Auto Post Rental Fee',1,0,'2026-08-30 13:52:17',23,19,'AA/2026/AGR/0031'),(84,'C0014','','','2026-09-03',NULL,'Direct Contract Rentout','N/A',NULL,NULL,1820.00000,0.00000,'AA/2026/AGR/0041','Pending',NULL,'Rentout from Direct Contract (Agreement No: AA/2026/AGR/0041)',1,1,'2026-09-03 09:51:01',0,33,'AA/2026/AGR/0041'),(85,'C0014','','','2026-09-03',NULL,'Direct Contract Rentout','N/A',NULL,NULL,1820.00000,0.00000,'AA/2026/AGR/0042','Pending',NULL,'Rentout from Direct Contract (Agreement No: AA/2026/AGR/0042)',1,1,'2026-09-03 09:51:01',0,34,'AA/2026/AGR/0042');
/*!40000 ALTER TABLE `tbl_customer_ledger` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_drivers_chk_1` CHECK (json_valid(`driver_documents`))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_drivers`
--

LOCK TABLES `tbl_drivers` WRITE;
/*!40000 ALTER TABLE `tbl_drivers` DISABLE KEYS */;
INSERT INTO `tbl_drivers` VALUES (1,1,'Driver1','21323423','test@gmail.com','234234234','2026-07-11','234324','Bahrain','2026-07-16','2026-07-15','test','1','2026-08-29 00:00:00','\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"License\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/webp\\/file_6a38f26e4fcc30.20658168.webp\\\"]},{\\\"documentName\\\":\\\"test\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/webp\\/file_6a928bbe27f144.53377310.webp\\\"]}]}\"','Active');
/*!40000 ALTER TABLE `tbl_drivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_garage_services`
--

DROP TABLE IF EXISTS `tbl_garage_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_garage_services` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge_per_unit` decimal(10,2) DEFAULT '0.00',
  `status` enum('Available','Deactivated') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `company_id` int(11) DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_garage_services`
--

LOCK TABLES `tbl_garage_services` WRITE;
/*!40000 ALTER TABLE `tbl_garage_services` DISABLE KEYS */;
INSERT INTO `tbl_garage_services` VALUES (1,'Tyre Change','Nos',2.00,'Available',1,'2026-08-18 18:28:06',1),(2,'Fuel Change','',0.00,'Available',1,'2026-08-18 18:34:44',1),(3,'Oil Change & Filter','Job',150.00,'Available',1,'2026-08-19 17:37:28',NULL),(4,'Brake Pad Replacement','Job',200.00,'Available',1,'2026-08-19 17:37:28',NULL),(5,'AC Gas Refill','Job',100.00,'Available',1,'2026-08-19 17:37:28',NULL),(6,'Full Vehicle Polish','Job',300.00,'Available',1,'2026-08-19 17:37:28',NULL),(7,'Tire Replacement & Balancing','Job',50.00,'Available',1,'2026-08-19 17:37:28',NULL),(8,'yyy','',3.00,'Available',1,'2026-08-20 15:17:29',1);
/*!40000 ALTER TABLE `tbl_garage_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_garages`
--

DROP TABLE IF EXISTS `tbl_garages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_garages` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `garage_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `garage_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `contact_person` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('Available','Deactivated') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',
  `company_id` int(11) DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`),
  UNIQUE KEY `garage_code` (`garage_code`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_garages`
--

LOCK TABLES `tbl_garages` WRITE;
/*!40000 ALTER TABLE `tbl_garages` DISABLE KEYS */;
INSERT INTO `tbl_garages` VALUES (1,'GAR-0001','Garage1','test','test','21312312','teats@gmail.com','Available',1,'2026-08-18 18:23:57',1),(2,'GAR-0002','Garahe2','test','Ajit','43534534','ajy@gmail,cim','Available',1,'2026-08-18 18:27:41',1),(3,'GAR-0003','Salmabad Garage','','','','','Deactivated',1,'2026-08-18 18:34:09',1),(4,'G001','Al Quoz Main Garage','Street 4, Al Quoz Ind Area 1, Dubai','Ahmed','0501234567','alquoz@garage.com','',1,'2026-08-19 17:37:28',NULL),(5,'G002','Quick Fix Auto','Deira, Dubai','Mohammed','0559876543','quickfix@garage.com','',1,'2026-08-19 17:37:28',NULL),(6,'GAR-0006','gar5',NULL,'','',NULL,'Available',1,'2026-08-20 14:01:09',1),(7,'GAR-0007','rr',NULL,'','',NULL,'Available',1,'2026-08-20 14:31:19',1),(8,'GAR-0008','gar5','','dffs','2324','','Available',1,'2026-08-20 15:07:06',1),(9,'GAR-0009','dfd','','','','','Available',1,'2026-08-20 15:07:16',1),(11,'GAR-0010','Test Garage from API','','Test Person','123456789','','Available',1,'2026-08-20 12:09:47',1),(12,'GAR-0012','Test Garage Nulls',NULL,'Test Person','123456789',NULL,'Available',1,'2026-08-20 12:10:14',1),(13,'GAR-0013','Direct Include Test','','Person','123','','Available',1,'2026-08-20 12:11:09',1),(14,'GAR-0014','123','','','','','Available',1,'2026-08-20 15:14:19',1),(15,'GAR-0015','rr','','','','','Available',1,'2026-08-20 15:17:03',1),(16,'GAR-0016','6666','','','','','Available',1,'2026-08-20 15:17:16',1);
/*!40000 ALTER TABLE `tbl_garages` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_invoice_billing_schedules_chk_1` CHECK (json_valid(`customer_details`)),
  CONSTRAINT `tbl_invoice_billing_schedules_chk_2` CHECK (json_valid(`vehicle_details`)),
  CONSTRAINT `tbl_invoice_billing_schedules_chk_3` CHECK (json_valid(`contract_details`)),
  CONSTRAINT `tbl_invoice_billing_schedules_chk_4` CHECK (json_valid(`log_details`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_invoice_billing_schedules`
--

LOCK TABLES `tbl_invoice_billing_schedules` WRITE;
/*!40000 ALTER TABLE `tbl_invoice_billing_schedules` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_invoice_billing_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_ledger_heads`
--

DROP TABLE IF EXISTS `tbl_ledger_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_ledger_heads` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `head_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `head_type` enum('Debit','Credit') COLLATE utf8mb4_general_ci NOT NULL,
  `is_locked` tinyint(1) DEFAULT '0',
  `company_id` int(11) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `violation_fine_type` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'No',
  PRIMARY KEY (`ids`),
  UNIQUE KEY `head_name` (`head_name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_ledger_heads`
--

LOCK TABLES `tbl_ledger_heads` WRITE;
/*!40000 ALTER TABLE `tbl_ledger_heads` DISABLE KEYS */;
INSERT INTO `tbl_ledger_heads` VALUES (1,'Opening Balance','Debit',1,1,'2026-04-22 02:15:22','No'),(2,'Invoice','Debit',1,1,'2026-04-22 02:15:22','No'),(3,'Payment','Credit',1,1,'2026-04-22 02:15:22','No'),(4,'Advance','Credit',1,1,'2026-04-22 02:15:22','No'),(5,'Discount','Credit',1,1,'2026-04-22 02:15:22','No'),(6,'Other','Credit',0,1,'2026-04-22 02:15:22','No'),(7,'Management Fee','Credit',0,1,'2026-04-22 02:17:59','No'),(14,'Deposit','Credit',0,1,'2026-05-27 22:28:48','No'),(15,'Rental Without Driver','Debit',1,1,'2026-05-27 22:32:23','No'),(16,'Rental With Driver','Debit',1,1,'2026-05-27 22:32:23','No'),(17,'Delay Fine','Debit',1,1,'2026-05-27 22:32:23','Yes'),(18,'Violation Fee','Debit',1,1,'2026-05-27 22:32:23','Yes'),(22,'Refund','Debit',0,1,'2026-05-27 22:28:48','No'),(23,'Vehicle Violation','Debit',0,1,'2026-08-01 13:28:28','Yes'),(24,'Violation1','Debit',0,1,'2026-08-01 13:34:10','Yes'),(25,'Violation2','Debit',0,1,'2026-08-01 13:34:29','Yes'),(26,'violation3','Debit',0,1,'2026-08-02 10:35:32','Yes');
/*!40000 ALTER TABLE `tbl_ledger_heads` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_maintenance_request_services`
--

LOCK TABLES `tbl_maintenance_request_services` WRITE;
/*!40000 ALTER TABLE `tbl_maintenance_request_services` DISABLE KEYS */;
INSERT INTO `tbl_maintenance_request_services` VALUES (3,2,1,1.00,0.000,'Nos',''),(4,3,1,1.00,0.000,'Nos',''),(5,4,1,1.00,0.000,'Nos',''),(9,1,1,2.00,12.000,'Nos','test remrk'),(10,1,2,1.00,3.000,'ltr','tt'),(11,1,8,1.00,4.000,'Nos','t'),(12,5,1,1.00,10.000,'Nos',''),(13,6,1,1.00,10.000,'Nos','tt'),(14,6,2,1.00,20.000,'ltr','yy'),(15,1,2,1.00,4.000,'Nos',''),(16,7,4,1.00,250.000,'Job',''),(17,7,3,1.00,150.000,'Job',''),(18,8,4,1.00,0.000,'Job',''),(19,7,5,1.00,100.000,'Job',''),(20,9,4,1.00,0.000,'Job',''),(21,9,5,1.00,0.000,'Job','');
/*!40000 ALTER TABLE `tbl_maintenance_request_services` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_maintenance_requests`
--

LOCK TABLES `tbl_maintenance_requests` WRITE;
/*!40000 ALTER TABLE `tbl_maintenance_requests` DISABLE KEYS */;
INSERT INTO `tbl_maintenance_requests` VALUES (1,'MR-2026-0001',1,1,'Approved',1,4.000,'test',27.000,'2026-08-20 15:25:42',1),(2,'AA-MR-2026-0001',15,2,'Pending',1,0.000,NULL,0.000,'2026-08-20 15:57:35',1),(3,'AA-MR-2026-0002',5,1,'Pending',1,0.000,NULL,0.000,'2026-08-20 16:01:03',1),(4,'AA-MR-2026-0003',3,1,'Approved',1,0.000,NULL,0.000,'2026-08-20 16:03:25',1),(5,'AA-MR-2026-0004',13,1,'Completed',1,20.000,'test ',30.000,'2026-08-20 18:07:07',1),(6,'AA-MR-2026-0005',12,1,'Completed',1,40.000,'service',70.000,'2026-08-23 12:39:27',1),(7,'AA-MR-2026-0006',1,1,'Approved',1,0.000,'',500.000,'2026-08-24 13:41:22',1),(8,'AA-MR-2026-0007',15,1,'Pending',1,0.000,NULL,0.000,'2026-08-24 13:46:14',1),(9,'CR-MR-2026-0001',15,1,'Pending',2,0.000,NULL,0.000,'2026-08-24 15:01:56',1);
/*!40000 ALTER TABLE `tbl_maintenance_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_outsourcing_companies`
--

DROP TABLE IF EXISTS `tbl_outsourcing_companies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_outsourcing_companies` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT '1',
  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cr_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_person_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`ids`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_outsourcing_companies`
--

LOCK TABLES `tbl_outsourcing_companies` WRITE;
/*!40000 ALTER TABLE `tbl_outsourcing_companies` DISABLE KEYS */;
INSERT INTO `tbl_outsourcing_companies` VALUES (1,1,'Abc','2214242122','test','Ancy','123214323','ancy@gmail.com','Active','2026-08-16 14:51:55',1,'2026-08-16 15:30:20',1),(2,1,'SaNDS Lab','787889','Manama Bahrain','Ancy Varghese','98797997','care@sandslab.com','Inactive','2026-08-16 17:05:18',1,'2026-08-18 14:21:47',74);
/*!40000 ALTER TABLE `tbl_outsourcing_companies` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_permissions`
--

LOCK TABLES `tbl_permissions` WRITE;
/*!40000 ALTER TABLE `tbl_permissions` DISABLE KEYS */;
INSERT INTO `tbl_permissions` VALUES (1,'Dashboard Access','dashboard_access','Dashboard','Active'),(2,'Dashboard Manage','dashboard_manage','Dashboard','Active'),(3,'Users Access','users_access','Masters','Active'),(4,'Users Manage','users_manage','Masters','Active'),(5,'Vehicle Configuration Access','vehicle_config_access','Masters','Active'),(6,'Vehicle Configuration Manage','vehicle_config_manage','Masters','Active'),(7,'Vehicle Registration Access','vehicle_registration_access','Masters','Active'),(8,'Vehicle Registration Manage','vehicle_registration_manage','Masters','Active'),(9,'Driver Registration Access','driver_registration_access','Masters','Active'),(10,'Driver Registration Manage','driver_registration_manage','Masters','Active'),(11,'Staff Registration Access','staff_registration_access','Masters','Active'),(12,'Staff Registration Manage','staff_registration_manage','Masters','Active'),(13,'List of Vehicles Access','list_of_vehicles_access','Masters','Active'),(14,'List of Vehicles Manage','list_of_vehicles_manage','Masters','Active'),(15,'Customers Access','customers_access','Masters','Active'),(16,'Customers Manage','customers_manage','Masters','Active'),(17,'Outsourcing Company Access','outsourcing_company_access','Masters','Active'),(18,'Outsourcing Company Manage','outsourcing_company_manage','Masters','Active'),(19,'Vehicle Reservation Access','vehicle_reservation_access','Operations','Active'),(20,'Vehicle Reservation Manage','vehicle_reservation_manage','Operations','Active'),(21,'Generate Contract Access','generate_contract_access','Operations','Active'),(22,'Generate Contract Manage','generate_contract_manage','Operations','Active'),(23,'Contract List Access','contract_list_access','Operations','Active'),(24,'Contract List Manage','contract_list_manage','Operations','Active'),(25,'Send Contract Access','send_contract_access','Operations','Active'),(26,'Send Contract Manage','send_contract_manage','Operations','Active'),(27,'Staff Use Allocation Access','staff_use_allocation_access','Operations','Active'),(28,'Staff Use Allocation Manage','staff_use_allocation_manage','Operations','Active'),(29,'Quotation Access','quotation_access','Accounting','Active'),(30,'Quotation Manage','quotation_manage','Accounting','Active'),(31,'Invoice Access','invoice_access','Accounting','Active'),(32,'Invoice Manage','invoice_manage','Accounting','Active'),(33,'Cash Memo/Receipt Access','cash_memo_access','Accounting','Active'),(34,'Cash Memo/Receipt Manage','cash_memo_manage','Accounting','Active'),(35,'Expense Voucher Access','expense_voucher_access','Accounting','Active'),(36,'Expense Voucher Manage','expense_voucher_manage','Accounting','Active'),(37,'Customer Ledger Access','customer_ledger_access','Accounting','Active'),(38,'Customer Ledger Manage','customer_ledger_manage','Accounting','Active'),(39,'Fund Flow Report Access','fund_flow_report_access','Accounting','Active'),(40,'Fund Flow Report Manage','fund_flow_report_manage','Accounting','Active'),(41,'Unbilled Contracts Access','unbilled_contracts_access','Accounting','Active'),(42,'Unbilled Contracts Manage','unbilled_contracts_manage','Accounting','Active'),(43,'Vehicle Insight Access','vehicle_insight_access','Reports','Active'),(44,'Vehicle Insight Manage','vehicle_insight_manage','Reports','Active'),(45,'Expected Returns Access','expected_returns_access','Reports','Active'),(46,'Expected Returns Manage','expected_returns_manage','Reports','Active'),(47,'Customer Balances Access','customer_balances_access','Reports','Active'),(48,'Customer Balances Manage','customer_balances_manage','Reports','Active'),(49,'Daily Rental Report Access','daily_rental_report_access','Reports','Active'),(50,'Daily Rental Report Manage','daily_rental_report_manage','Reports','Active'),(51,'Daily Cash Report Access','daily_cash_report_access','Reports','Active'),(52,'Daily Cash Report Manage','daily_cash_report_manage','Reports','Active'),(53,'Staff Use Report Access','staff_use_report_access','Reports','Active'),(54,'Staff Use Report Manage','staff_use_report_manage','Reports','Active'),(55,'Contract & Replacement History Access','contract_history_report_access','Reports','Active'),(56,'Contract & Replacement History Manage','contract_history_report_manage','Reports','Active'),(57,'System Settings Access','system_settings_access','Settings','Active'),(58,'System Settings Manage','system_settings_manage','Settings','Active'),(59,'Garage and Service Master Access','garage_and_service_access','Registration','Active'),(60,'Garage and Service Master Manage','garage_and_service_manage','Registration','Active'),(61,'Vehicle Insurance Access','vehicle_insurance_access','Masters','Active'),(62,'Vehicle Insurance Manage','vehicle_insurance_manage','Masters','Active'),(63,'Maintenance Request Access','maintenance_request_access','General','Active'),(64,'Maintenance Request Manage','maintenance_request_manage','General','Active'),(65,'Maintenance Request Approve','maintenance_request_approve','General','Active'),(66,'Quotation Approve','quotation_approve','Accounting','Active');
/*!40000 ALTER TABLE `tbl_permissions` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_quotation_introduction`
--

LOCK TABLES `tbl_quotation_introduction` WRITE;
/*!40000 ALTER TABLE `tbl_quotation_introduction` DISABLE KEYS */;
INSERT INTO `tbl_quotation_introduction` VALUES (4,'111','<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>',1,1),(6,'Intro2','<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>',1,1),(7,'eeee','<p>eeeee</p>',1,1);
/*!40000 ALTER TABLE `tbl_quotation_introduction` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_role_permissions`
--

LOCK TABLES `tbl_role_permissions` WRITE;
/*!40000 ALTER TABLE `tbl_role_permissions` DISABLE KEYS */;
INSERT INTO `tbl_role_permissions` VALUES (1,4,29,'Granted','2026-08-30 18:18:49'),(2,4,30,'Granted','2026-08-30 18:18:49'),(3,4,31,'Granted','2026-08-30 18:18:49'),(4,4,32,'Granted','2026-08-30 18:18:49'),(5,4,33,'Granted','2026-08-30 18:18:49'),(6,4,34,'Granted','2026-08-30 18:18:49'),(7,4,35,'Granted','2026-08-30 18:18:49'),(8,4,36,'Granted','2026-08-30 18:18:49'),(9,4,37,'Granted','2026-08-30 18:18:49'),(10,4,38,'Granted','2026-08-30 18:18:49'),(11,4,39,'Granted','2026-08-30 18:18:49'),(12,4,40,'Granted','2026-08-30 18:18:49'),(13,4,41,'Granted','2026-08-30 18:18:49'),(14,4,42,'Granted','2026-08-30 18:18:49'),(15,4,1,'Granted','2026-08-30 18:18:49'),(16,4,2,'Granted','2026-08-30 18:18:49'),(17,4,3,'Granted','2026-08-30 18:18:49'),(18,4,4,'Granted','2026-08-30 18:18:49'),(19,4,5,'Granted','2026-08-30 18:18:49'),(20,4,6,'Granted','2026-08-30 18:18:49'),(21,4,7,'Granted','2026-08-30 18:18:49'),(22,4,8,'Granted','2026-08-30 18:18:49'),(23,4,9,'Granted','2026-08-30 18:18:49'),(24,4,10,'Granted','2026-08-30 18:18:49'),(25,4,11,'Granted','2026-08-30 18:18:49'),(26,4,12,'Granted','2026-08-30 18:18:49'),(27,4,13,'Granted','2026-08-30 18:18:49'),(28,4,14,'Granted','2026-08-30 18:18:49'),(29,4,15,'Granted','2026-08-30 18:18:49'),(30,4,16,'Granted','2026-08-30 18:18:49'),(31,4,17,'Granted','2026-08-30 18:18:49'),(32,4,18,'Granted','2026-08-30 18:18:49'),(33,4,19,'Granted','2026-08-30 18:18:49'),(34,4,20,'Granted','2026-08-30 18:18:49'),(35,4,21,'Granted','2026-08-30 18:18:49'),(36,4,22,'Granted','2026-08-30 18:18:49'),(37,4,23,'Granted','2026-08-30 18:18:49'),(38,4,24,'Granted','2026-08-30 18:18:49'),(39,4,25,'Granted','2026-08-30 18:18:49'),(40,4,26,'Granted','2026-08-30 18:18:49'),(41,4,27,'Granted','2026-08-30 18:18:49'),(42,4,28,'Granted','2026-08-30 18:18:49'),(43,4,43,'Granted','2026-08-30 18:18:49'),(44,4,44,'Granted','2026-08-30 18:18:49'),(45,4,45,'Granted','2026-08-30 18:18:49'),(46,4,46,'Granted','2026-08-30 18:18:49'),(47,4,47,'Granted','2026-08-30 18:18:49'),(48,4,48,'Granted','2026-08-30 18:18:49'),(49,4,49,'Granted','2026-08-30 18:18:49'),(50,4,50,'Granted','2026-08-30 18:18:49'),(51,4,51,'Granted','2026-08-30 18:18:49'),(52,4,52,'Granted','2026-08-30 18:18:49'),(53,4,53,'Granted','2026-08-30 18:18:49'),(54,4,54,'Granted','2026-08-30 18:18:49'),(55,4,55,'Granted','2026-08-30 18:18:49'),(56,4,56,'Granted','2026-08-30 18:18:49'),(57,4,57,'Granted','2026-08-30 18:18:49'),(58,4,58,'Granted','2026-08-30 18:18:49'),(59,1,29,'Granted','2026-08-17 16:58:38'),(60,1,30,'Granted','2026-08-17 16:58:38'),(61,1,31,'Granted','2026-08-17 16:58:38'),(62,1,32,'Granted','2026-08-17 16:58:38'),(63,1,33,'Granted','2026-08-17 16:58:38'),(64,1,34,'Granted','2026-08-17 16:58:38'),(65,1,35,'Granted','2026-08-17 16:58:38'),(66,1,36,'Granted','2026-08-17 16:58:38'),(67,1,37,'Granted','2026-08-17 16:58:38'),(68,1,38,'Granted','2026-08-17 16:58:38'),(69,1,39,'Granted','2026-08-17 16:58:38'),(70,1,40,'Granted','2026-08-17 16:58:38'),(71,1,41,'Granted','2026-08-17 16:58:38'),(72,1,42,'Granted','2026-08-17 16:58:38'),(73,1,1,'Granted','2026-08-17 16:58:38'),(74,1,2,'Granted','2026-08-17 16:58:38'),(75,1,3,'Granted','2026-08-17 16:58:38'),(76,1,4,'Granted','2026-08-17 16:58:38'),(77,1,5,'Granted','2026-08-17 16:58:38'),(78,1,6,'Granted','2026-08-17 16:58:38'),(79,1,7,'Granted','2026-08-17 16:58:38'),(80,1,8,'Granted','2026-08-17 16:58:38'),(81,1,9,'Granted','2026-08-17 16:58:38'),(82,1,10,'Granted','2026-08-17 16:58:38'),(83,1,11,'Granted','2026-08-17 16:58:38'),(84,1,12,'Granted','2026-08-17 16:58:38'),(85,1,13,'Granted','2026-08-17 16:58:38'),(86,1,14,'Granted','2026-08-17 16:58:38'),(87,1,15,'Granted','2026-08-17 16:58:38'),(88,1,16,'Granted','2026-08-17 16:58:38'),(89,1,17,'Granted','2026-08-17 16:58:38'),(90,1,18,'Granted','2026-08-17 16:58:38'),(91,1,19,'Granted','2026-08-17 16:58:38'),(92,1,20,'Granted','2026-08-17 16:58:38'),(93,1,21,'Granted','2026-08-17 16:58:38'),(94,1,22,'Granted','2026-08-17 16:58:38'),(95,1,23,'Granted','2026-08-17 16:58:38'),(96,1,24,'Granted','2026-08-17 16:58:38'),(97,1,25,'Granted','2026-08-17 16:58:38'),(98,1,26,'Granted','2026-08-17 16:58:38'),(99,1,27,'Granted','2026-08-17 16:58:38'),(100,1,28,'Granted','2026-08-17 16:58:38'),(101,1,43,'Granted','2026-08-17 16:58:38'),(102,1,44,'Granted','2026-08-17 16:58:38'),(103,1,45,'Granted','2026-08-17 16:58:38'),(104,1,46,'Granted','2026-08-17 16:58:38'),(105,1,47,'Granted','2026-08-17 16:58:38'),(106,1,48,'Granted','2026-08-17 16:58:38'),(107,1,49,'Granted','2026-08-17 16:58:38'),(108,1,50,'Granted','2026-08-17 16:58:38'),(109,1,51,'Granted','2026-08-17 16:58:38'),(110,1,52,'Granted','2026-08-17 16:58:38'),(111,1,53,'Granted','2026-08-17 16:58:38'),(112,1,54,'Granted','2026-08-17 16:58:38'),(113,1,55,'Granted','2026-08-17 16:58:38'),(114,1,56,'Granted','2026-08-17 16:58:38'),(115,1,57,'Granted','2026-08-17 16:58:38'),(116,1,58,'Granted','2026-08-17 16:58:38'),(117,2,29,'Revoked','2026-08-17 19:38:44'),(118,2,30,'Revoked','2026-08-17 19:38:44'),(119,2,31,'Revoked','2026-08-17 19:38:44'),(120,2,32,'Revoked','2026-08-17 19:38:44'),(121,2,33,'Revoked','2026-08-17 19:38:44'),(122,2,34,'Revoked','2026-08-17 19:38:44'),(123,2,35,'Revoked','2026-08-17 19:38:44'),(124,2,36,'Revoked','2026-08-17 19:38:44'),(125,2,37,'Revoked','2026-08-17 19:38:44'),(126,2,38,'Revoked','2026-08-17 19:38:44'),(127,2,39,'Revoked','2026-08-17 19:38:44'),(128,2,40,'Revoked','2026-08-17 19:38:44'),(129,2,41,'Revoked','2026-08-17 19:38:44'),(130,2,42,'Revoked','2026-08-17 19:38:44'),(131,2,1,'Revoked','2026-08-17 19:38:44'),(132,2,2,'Revoked','2026-08-17 19:38:44'),(133,2,3,'Revoked','2026-08-17 19:38:44'),(134,2,4,'Revoked','2026-08-17 19:38:44'),(135,2,5,'Revoked','2026-08-17 19:38:44'),(136,2,6,'Revoked','2026-08-17 19:38:44'),(137,2,7,'Revoked','2026-08-17 19:38:44'),(138,2,8,'Revoked','2026-08-17 19:38:44'),(139,2,9,'Revoked','2026-08-17 19:38:44'),(140,2,10,'Revoked','2026-08-17 19:38:44'),(141,2,11,'Granted','2026-08-17 19:38:44'),(142,2,12,'Revoked','2026-08-17 19:38:44'),(143,2,13,'Revoked','2026-08-17 19:38:44'),(144,2,14,'Revoked','2026-08-17 19:38:44'),(145,2,15,'Revoked','2026-08-17 19:38:44'),(146,2,16,'Revoked','2026-08-17 19:38:44'),(147,2,17,'Revoked','2026-08-17 19:38:44'),(148,2,18,'Revoked','2026-08-17 19:38:44'),(149,2,19,'Revoked','2026-08-17 19:38:44'),(150,2,20,'Revoked','2026-08-17 19:38:44'),(151,2,21,'Revoked','2026-08-17 19:38:44'),(152,2,22,'Revoked','2026-08-17 19:38:44'),(153,2,23,'Revoked','2026-08-17 19:38:44'),(154,2,24,'Revoked','2026-08-17 19:38:44'),(155,2,25,'Revoked','2026-08-17 19:38:44'),(156,2,26,'Revoked','2026-08-17 19:38:44'),(157,2,27,'Revoked','2026-08-17 19:38:44'),(158,2,28,'Revoked','2026-08-17 19:38:44'),(159,2,43,'Revoked','2026-08-17 19:38:44'),(160,2,44,'Revoked','2026-08-17 19:38:44'),(161,2,45,'Revoked','2026-08-17 19:38:44'),(162,2,46,'Revoked','2026-08-17 19:38:44'),(163,2,47,'Revoked','2026-08-17 19:38:44'),(164,2,48,'Revoked','2026-08-17 19:38:44'),(165,2,49,'Revoked','2026-08-17 19:38:44'),(166,2,50,'Revoked','2026-08-17 19:38:44'),(167,2,51,'Revoked','2026-08-17 19:38:44'),(168,2,52,'Revoked','2026-08-17 19:38:44'),(169,2,53,'Revoked','2026-08-17 19:38:44'),(170,2,54,'Revoked','2026-08-17 19:38:44'),(171,2,55,'Revoked','2026-08-17 19:38:44'),(172,2,56,'Revoked','2026-08-17 19:38:44'),(173,2,57,'Revoked','2026-08-17 19:38:44'),(174,2,58,'Revoked','2026-08-17 19:38:44'),(175,1,59,'Granted','2026-08-18 17:57:56'),(176,1,60,'Granted','2026-08-18 17:57:56'),(177,3,59,'Granted','2026-08-18 17:57:56'),(178,3,60,'Granted','2026-08-18 17:57:56'),(179,4,59,'Granted','2026-08-30 18:18:49'),(180,4,60,'Granted','2026-08-30 18:18:49'),(181,1,61,'Granted','2026-08-19 11:42:26'),(182,1,62,'Granted','2026-08-19 11:42:26'),(183,3,61,'Granted','2026-08-19 11:42:26'),(184,3,62,'Granted','2026-08-19 11:42:26'),(185,4,61,'Granted','2026-08-30 18:18:49'),(186,4,62,'Granted','2026-08-30 18:18:49'),(187,1,63,'Granted','2026-08-19 17:29:04'),(188,3,63,'Granted','2026-08-19 17:29:04'),(189,4,63,'Granted','2026-08-30 18:18:49'),(190,1,64,'Granted','2026-08-23 12:15:52'),(191,1,65,'Granted','2026-08-23 12:15:52'),(192,3,1,'Granted','2026-08-23 12:15:52'),(193,3,2,'Granted','2026-08-23 12:15:52'),(194,3,3,'Granted','2026-08-23 12:15:52'),(195,3,4,'Granted','2026-08-23 12:15:52'),(196,3,5,'Granted','2026-08-23 12:15:52'),(197,3,6,'Granted','2026-08-23 12:15:52'),(198,3,7,'Granted','2026-08-23 12:15:52'),(199,3,8,'Granted','2026-08-23 12:15:52'),(200,3,9,'Granted','2026-08-23 12:15:52'),(201,3,10,'Granted','2026-08-23 12:15:52'),(202,3,11,'Granted','2026-08-23 12:15:52'),(203,3,12,'Granted','2026-08-23 12:15:52'),(204,3,13,'Granted','2026-08-23 12:15:52'),(205,3,14,'Granted','2026-08-23 12:15:52'),(206,3,15,'Granted','2026-08-23 12:15:52'),(207,3,16,'Granted','2026-08-23 12:15:52'),(208,3,17,'Granted','2026-08-23 12:15:52'),(209,3,18,'Granted','2026-08-23 12:15:52'),(210,3,19,'Granted','2026-08-23 12:15:52'),(211,3,20,'Granted','2026-08-23 12:15:52'),(212,3,21,'Granted','2026-08-23 12:15:52'),(213,3,22,'Granted','2026-08-23 12:15:52'),(214,3,23,'Granted','2026-08-23 12:15:52'),(215,3,24,'Granted','2026-08-23 12:15:52'),(216,3,25,'Granted','2026-08-23 12:15:52'),(217,3,26,'Granted','2026-08-23 12:15:52'),(218,3,27,'Granted','2026-08-23 12:15:52'),(219,3,28,'Granted','2026-08-23 12:15:52'),(220,3,29,'Granted','2026-08-23 12:15:52'),(221,3,30,'Granted','2026-08-23 12:15:52'),(222,3,31,'Granted','2026-08-23 12:15:52'),(223,3,32,'Granted','2026-08-23 12:15:52'),(224,3,33,'Granted','2026-08-23 12:15:52'),(225,3,34,'Granted','2026-08-23 12:15:52'),(226,3,35,'Granted','2026-08-23 12:15:52'),(227,3,36,'Granted','2026-08-23 12:15:52'),(228,3,37,'Granted','2026-08-23 12:15:52'),(229,3,38,'Granted','2026-08-23 12:15:52'),(230,3,39,'Granted','2026-08-23 12:15:52'),(231,3,40,'Granted','2026-08-23 12:15:52'),(232,3,41,'Granted','2026-08-23 12:15:52'),(233,3,42,'Granted','2026-08-23 12:15:52'),(234,3,43,'Granted','2026-08-23 12:15:52'),(235,3,44,'Granted','2026-08-23 12:15:52'),(236,3,45,'Granted','2026-08-23 12:15:52'),(237,3,46,'Granted','2026-08-23 12:15:52'),(238,3,47,'Granted','2026-08-23 12:15:52'),(239,3,48,'Granted','2026-08-23 12:15:52'),(240,3,49,'Granted','2026-08-23 12:15:52'),(241,3,50,'Granted','2026-08-23 12:15:52'),(242,3,51,'Granted','2026-08-23 12:15:52'),(243,3,52,'Granted','2026-08-23 12:15:52'),(244,3,53,'Granted','2026-08-23 12:15:52'),(245,3,54,'Granted','2026-08-23 12:15:52'),(246,3,55,'Granted','2026-08-23 12:15:52'),(247,3,56,'Granted','2026-08-23 12:15:52'),(248,3,57,'Granted','2026-08-23 12:15:52'),(249,3,58,'Granted','2026-08-23 12:15:52'),(250,3,64,'Granted','2026-08-23 12:15:52'),(251,3,65,'Granted','2026-08-23 12:15:52'),(252,4,64,'Granted','2026-08-30 18:18:49'),(253,4,65,'Granted','2026-08-30 18:18:49'),(254,1,66,'Granted','2026-08-23 12:32:42'),(255,3,66,'Granted','2026-08-23 12:32:42'),(256,4,66,'Granted','2026-08-30 18:18:49');
/*!40000 ALTER TABLE `tbl_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_roles`
--

LOCK TABLES `tbl_roles` WRITE;
/*!40000 ALTER TABLE `tbl_roles` DISABLE KEYS */;
INSERT INTO `tbl_roles` VALUES (1,'Administrator','Active'),(2,'User','Active'),(3,'Super Admin','Active'),(4,'Accountant','Active');
/*!40000 ALTER TABLE `tbl_roles` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_service_type`
--

LOCK TABLES `tbl_service_type` WRITE;
/*!40000 ALTER TABLE `tbl_service_type` DISABLE KEYS */;
INSERT INTO `tbl_service_type` VALUES (1,'Rental Without Driver',10.00),(2,'Rental With Driver',0.00);
/*!40000 ALTER TABLE `tbl_service_type` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_staff_chk_1` CHECK (json_valid(`staff_documents`))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_staff`
--

LOCK TABLES `tbl_staff` WRITE;
/*!40000 ALTER TABLE `tbl_staff` DISABLE KEYS */;
INSERT INTO `tbl_staff` VALUES (1,1,'Test Staff','2132342311','teststaf@gmail.com','23423423411','2026-07-21','23432411','Bahrain','2026-07-31','2026-08-13','test111','1','2026-07-15 00:00:00','\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"ttt\\\",\\\"files\\\":[\\\"uploads\\/staffdocs\\/files\\/file_6a57a1166ddaa8.20034926.pdf\\\"]},{\\\"documentName\\\":\\\"pic\\\",\\\"files\\\":[\\\"uploads\\/staffdocs\\/webp\\/file_6a57a1990c3683.06390215.webp\\\"]}]}\"','Active'),(2,1,'Manu','32423','dsfs@wer.rty','324535','2026-07-16','fdg234','dsf','2026-07-23','2026-07-31','redgdf','1','2026-07-15 00:00:00','\"{\\\"vehicles\\\":[]}\"','Active'),(3,1,'RUMEL','37338987','','761134395','2028-11-15','761134395','BAHRAIN','2026-07-23','2030-07-23','','1','2026-07-23 00:00:00','\"{\\\"vehicles\\\":[]}\"','Active');
/*!40000 ALTER TABLE `tbl_staff` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_system_settings`
--

LOCK TABLES `tbl_system_settings` WRITE;
/*!40000 ALTER TABLE `tbl_system_settings` DISABLE KEYS */;
INSERT INTO `tbl_system_settings` VALUES (1,1,10.00,'Asia/Bahrain','d-M-Y','BHD','BD','2026-08-19 11:27:04',1);
/*!40000 ALTER TABLE `tbl_system_settings` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_terms_and_condition`
--

LOCK TABLES `tbl_terms_and_condition` WRITE;
/*!40000 ALTER TABLE `tbl_terms_and_condition` DISABLE KEYS */;
INSERT INTO `tbl_terms_and_condition` VALUES (10,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','With Guarentee','2026-03-02 17:57:44',1,1,1),(9,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','New Terms and Condition','2026-03-02 17:54:03',1,1,1),(11,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over </span><strong style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">100 languages, including Arabic</strong><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, </span><em style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"><u>though context-aware</u></em><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"> nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','New Sample Data','2026-03-03 01:30:07',1,1,1),(12,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','111','2026-03-15 03:12:24',1,1,1);
/*!40000 ALTER TABLE `tbl_terms_and_condition` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_terms_and_condition_contract`
--

LOCK TABLES `tbl_terms_and_condition_contract` WRITE;
/*!40000 ALTER TABLE `tbl_terms_and_condition_contract` DISABLE KEYS */;
INSERT INTO `tbl_terms_and_condition_contract` VALUES (10,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','With Guarentee','2026-03-02 17:57:44',1,1,1,1),(9,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','New Terms and Condition','2026-03-02 17:54:03',1,1,1,0),(12,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','111','2026-03-15 03:12:24',1,1,1,0),(13,'<p>erty</p>','ttterty','2026-08-29 12:09:57',1,1,1,0),(14,'<p>yyy</p>','uuy','2026-08-29 12:11:40',1,1,1,0),(16,'<p>The above lease ratesssss are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','111','2026-08-29 12:24:12',1,1,1,0),(17,'<p>tttestttt ggg</p>','testttt gg','2026-08-29 12:24:29',1,1,1,0),(18,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabics can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>','New Terms and Condition','2026-09-02 10:09:45',1,1,1,0);
/*!40000 ALTER TABLE `tbl_terms_and_condition_contract` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_user_permissions`
--

LOCK TABLES `tbl_user_permissions` WRITE;
/*!40000 ALTER TABLE `tbl_user_permissions` DISABLE KEYS */;
INSERT INTO `tbl_user_permissions` VALUES (1,1,29,'Granted','2026-08-17 17:46:17'),(2,1,30,'Granted','2026-08-17 17:46:17'),(3,1,31,'Granted','2026-08-17 17:46:17'),(4,1,32,'Granted','2026-08-17 17:46:17'),(5,1,33,'Granted','2026-08-17 17:46:17'),(6,1,34,'Granted','2026-08-17 17:46:17'),(7,1,35,'Granted','2026-08-17 17:46:17'),(8,1,36,'Granted','2026-08-17 17:46:18'),(9,1,37,'Granted','2026-08-17 17:46:18'),(10,1,38,'Granted','2026-08-17 17:46:18'),(11,1,39,'Granted','2026-08-17 17:46:18'),(12,1,40,'Granted','2026-08-17 17:46:18'),(13,1,41,'Granted','2026-08-17 17:46:18'),(14,1,42,'Granted','2026-08-17 17:46:18'),(15,1,1,'Granted','2026-08-17 17:46:18'),(16,1,2,'Granted','2026-08-17 17:46:18'),(17,1,3,'Granted','2026-08-17 17:46:18'),(18,1,4,'Granted','2026-08-17 17:46:18'),(19,1,5,'Granted','2026-08-17 17:46:18'),(20,1,6,'Granted','2026-08-17 17:46:18'),(21,1,7,'Granted','2026-08-17 17:46:18'),(22,1,8,'Granted','2026-08-17 17:46:18'),(23,1,9,'Granted','2026-08-17 17:46:18'),(24,1,10,'Granted','2026-08-17 17:46:18'),(25,1,11,'Granted','2026-08-17 17:46:18'),(26,1,12,'Granted','2026-08-17 17:46:18'),(27,1,13,'Granted','2026-08-17 17:46:18'),(28,1,14,'Granted','2026-08-17 17:46:18'),(29,1,15,'Granted','2026-08-17 17:46:18'),(30,1,16,'Granted','2026-08-17 17:46:18'),(31,1,17,'Granted','2026-08-17 17:46:18'),(32,1,18,'Granted','2026-08-17 17:46:18'),(33,1,19,'Granted','2026-08-17 17:46:18'),(34,1,20,'Granted','2026-08-17 17:46:18'),(35,1,21,'Granted','2026-08-17 17:46:18'),(36,1,22,'Granted','2026-08-17 17:46:18'),(37,1,23,'Granted','2026-08-17 17:46:18'),(38,1,24,'Granted','2026-08-17 17:46:18'),(39,1,25,'Granted','2026-08-17 17:46:18'),(40,1,26,'Granted','2026-08-17 17:46:18'),(41,1,27,'Granted','2026-08-17 17:46:18'),(42,1,28,'Granted','2026-08-17 17:46:18'),(43,1,43,'Granted','2026-08-17 17:46:18'),(44,1,44,'Granted','2026-08-17 17:46:18'),(45,1,45,'Granted','2026-08-17 17:46:18'),(46,1,46,'Granted','2026-08-17 17:46:18'),(47,1,47,'Granted','2026-08-17 17:46:18'),(48,1,48,'Granted','2026-08-17 17:46:18'),(49,1,49,'Granted','2026-08-17 17:46:18'),(50,1,50,'Granted','2026-08-17 17:46:18'),(51,1,51,'Granted','2026-08-17 17:46:18'),(52,1,52,'Granted','2026-08-17 17:46:18'),(53,1,53,'Granted','2026-08-17 17:46:18'),(54,1,54,'Granted','2026-08-17 17:46:18'),(55,1,55,'Granted','2026-08-17 17:46:18'),(56,1,56,'Granted','2026-08-17 17:46:18'),(57,1,57,'Granted','2026-08-17 17:46:18'),(58,1,58,'Granted','2026-08-17 17:46:18'),(59,74,29,'Granted','2026-08-17 18:02:34'),(60,74,30,'Granted','2026-08-17 18:02:34'),(61,74,31,'Granted','2026-08-17 18:02:34'),(62,74,32,'Granted','2026-08-17 18:02:34'),(63,74,33,'Granted','2026-08-17 18:02:34'),(64,74,34,'Granted','2026-08-17 18:02:34'),(65,74,35,'Granted','2026-08-17 18:02:34'),(66,74,36,'Granted','2026-08-17 18:02:34'),(67,74,37,'Granted','2026-08-17 18:02:34'),(68,74,38,'Granted','2026-08-17 18:02:34'),(69,74,39,'Granted','2026-08-17 18:02:34'),(70,74,40,'Granted','2026-08-17 18:02:34'),(71,74,41,'Granted','2026-08-17 18:02:34'),(72,74,42,'Granted','2026-08-17 18:02:34'),(73,74,1,'Granted','2026-08-17 18:02:34'),(74,74,2,'Granted','2026-08-17 18:02:34'),(75,74,3,'Granted','2026-08-17 18:02:34'),(76,74,4,'Revoked','2026-08-17 18:02:34'),(77,74,5,'Granted','2026-08-17 18:02:34'),(78,74,6,'Granted','2026-08-17 18:02:34'),(79,74,7,'Granted','2026-08-17 18:02:34'),(80,74,8,'Granted','2026-08-17 18:02:34'),(81,74,9,'Granted','2026-08-17 18:02:34'),(82,74,10,'Revoked','2026-08-17 18:02:34'),(83,74,11,'Granted','2026-08-17 18:02:34'),(84,74,12,'Granted','2026-08-17 18:02:34'),(85,74,13,'Granted','2026-08-17 18:02:34'),(86,74,14,'Granted','2026-08-17 18:02:34'),(87,74,15,'Granted','2026-08-17 18:02:34'),(88,74,16,'Granted','2026-08-17 18:02:34'),(89,74,17,'Granted','2026-08-17 18:02:34'),(90,74,18,'Granted','2026-08-17 18:02:34'),(91,74,19,'Revoked','2026-08-17 18:02:34'),(92,74,20,'Revoked','2026-08-17 18:02:34'),(93,74,21,'Granted','2026-08-17 18:02:34'),(94,74,22,'Granted','2026-08-17 18:02:34'),(95,74,23,'Granted','2026-08-17 18:02:34'),(96,74,24,'Granted','2026-08-17 18:02:34'),(97,74,25,'Granted','2026-08-17 18:02:34'),(98,74,26,'Granted','2026-08-17 18:02:34'),(99,74,27,'Granted','2026-08-17 18:02:34'),(100,74,28,'Granted','2026-08-17 18:02:35'),(101,74,43,'Granted','2026-08-17 18:02:35'),(102,74,44,'Granted','2026-08-17 18:02:35'),(103,74,45,'Granted','2026-08-17 18:02:35'),(104,74,46,'Granted','2026-08-17 18:02:35'),(105,74,47,'Granted','2026-08-17 18:02:35'),(106,74,48,'Granted','2026-08-17 18:02:35'),(107,74,49,'Granted','2026-08-17 18:02:35'),(108,74,50,'Granted','2026-08-17 18:02:35'),(109,74,51,'Granted','2026-08-17 18:02:35'),(110,74,52,'Granted','2026-08-17 18:02:35'),(111,74,53,'Granted','2026-08-17 18:02:35'),(112,74,54,'Granted','2026-08-17 18:02:35'),(113,74,55,'Granted','2026-08-17 18:02:35'),(114,74,56,'Granted','2026-08-17 18:02:35'),(115,74,57,'Granted','2026-08-17 18:02:35'),(116,74,58,'Granted','2026-08-17 18:02:35');
/*!40000 ALTER TABLE `tbl_user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

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
  UNIQUE KEY `idx_unique_user_name` (`user_name`),
  CONSTRAINT `tbl_users_chk_1` CHECK (json_valid(`company_json`))
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_users`
--

LOCK TABLES `tbl_users` WRITE;
/*!40000 ALTER TABLE `tbl_users` DISABLE KEYS */;
INSERT INTO `tbl_users` VALUES (1,'Administrator','admin','passme','1','Administrator','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"},{\"ids\":\"2\",\"company_name\":\"Class Rental car\"}]','12345123','admin123@gmail.com','user_6a6622c528a7d2.68109295.jpg','Active','2026-03-17'),(71,'Super Admin 2','superadmin2','passme','3','Super Admin','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','2342423432','superadmin@gmial.com','default.jpg','Active','2026-08-16'),(64,'Fida','fida','passme','1','Administrator','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','2432434','fida@gmail.com','user_6a38f064c43002.30582550.jpg','Active','2026-06-22'),(65,'aastaff','ansel','123456','1','Administrator','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','13244214','ansel@gmail.com','user_6a646758c39191.06769775.jpg','Active','2026-07-25'),(66,'qqrt','qq','qq','1','Administrator','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','23122134','qq123rt@gmail.com','user_6a81ab30dcba24.14667267.jpg','Active','2026-07-26'),(69,'Kumar','kumar','123456','2','User','[{\"ids\":\"2\",\"company_name\":\"Class Rental car\"}]','98952016611','care@sandslab.com','user_6a81c9da8f7e11.04027417.jpg','Active','2026-08-16'),(67,'tt','wer','sd','2','User','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"},{\"ids\":\"2\",\"company_name\":\"Class Rental car\"}]','3423','fdfd@were.fgg','user_6a65f83d83a3f5.09479555.jpg','Active','2026-07-26'),(68,'ajit','ajit','passme','1','Administrator','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','8075501121','ajit@sandslab.com','user_6a6b51f1e6a2d9.31862680.jpg','Active','2026-07-30'),(70,'Super Admin','superadmin','passme','3','Super Admin','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"},{\"ids\":\"2\",\"company_name\":\"Class Rental car\"}]','9895016611','super@sandslab.com','default.jpg','Active','2026-08-16'),(72,'Super Admin 3','superadmin3','passme','3','Super Admin','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"},{\"ids\":\"2\",\"company_name\":\"Class Rental car\"}]','234235345','superadmin3@gmail.com','default.jpg','Active','2026-08-16'),(73,'AA Uuser','aauser1','passme','2','User','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','15514511','aa@sandslab.com','default.jpg','Active','2026-08-16'),(74,'accounts1','accounts1','passme','4','Accountant','[{\"ids\":\"1\",\"company_name\":\"AA Car Rental\"}]','1225222','ajit@sandslab.com','default.jpg','Active','2026-08-17');
/*!40000 ALTER TABLE `tbl_users` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_bookings_chk_1` CHECK (json_valid(`customer_details_json`)),
  CONSTRAINT `tbl_vehicle_bookings_chk_2` CHECK (json_valid(`book_details_json`))
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_bookings`
--

LOCK TABLES `tbl_vehicle_bookings` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_bookings` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_bookings` VALUES (1,'AA/2026/RS/0001',1,'SMALL CARS',1,'NISSAN',1,'MICRA',1,'12345','quotation','AA/2026/PM/0001','C0001','ABC','{\"customer_code\":\"C0001\",\"customer_name\":\"ABC\",\"phone\":\"12121\",\"email\":\"abc@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"tsse\"}','2026-06-01 11:09:00','2026-06-18 11:09:00','{\"fromDate\":\"2026-06-01T11:09\",\"toDate\":\"2026-06-18T11:09\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"408\",\"price\":\"6\",\"vat\":\"10\",\"total\":\"2692.800\",\"notes\":\"\",\"quotation_ref\":\"AA\\/2026\\/PM\\/0001\"}','Rentout',1,1,'2026-06-20 11:10:50','2026-07-14 15:44:03'),(2,'AA/2026/RS/0002',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',2,'66666','direct','','C0002','EFG','{\"customer_code\":\"C0002\",\"customer_name\":\"EFG\",\"phone\":\"34343434\",\"email\":\"efg@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-07-01 11:29:00','2026-07-10 11:29:00','{\"fromDate\":\"2026-07-01T11:29\",\"toDate\":\"2026-07-10T11:29\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"9\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"118.800\",\"notes\":\"\",\"quotation_ref\":\"\"}','Rentout',1,1,'2026-06-20 11:29:39','2026-06-20 19:50:20'),(3,'AA/2026/RS/0003',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-01 11:32:00','2026-07-10 11:33:00','{\"fromDate\":\"2026-07-01T11:32\",\"toDate\":\"2026-07-10T11:33\",\"rateType\":\"day\",\"service\":\"2\",\"duration\":\"10\",\"price\":\"20\",\"vat\":\"0\",\"total\":\"200.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Closed',1,64,'2026-06-22 11:35:11','2026-06-22 11:43:05'),(4,'AA/2026/RS/0004',1,'SMALL CARS',1,'NISSAN',1,'MICRA',4,'565656','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-01 12:19:00','2026-07-10 12:19:00','{\"fromDate\":\"2026-07-01T12:19\",\"toDate\":\"2026-07-10T12:19\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"9\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"99.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Rentout',1,64,'2026-06-22 12:19:40','2026-06-22 12:22:26'),(5,'AA/2026/RS/0005',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333','direct','','C0001','ABC','{\"customer_code\":\"C0001\",\"customer_name\":\"ABC\",\"phone\":\"12121\",\"email\":\"abc@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"tsse\"}','2026-07-28 18:02:00','2026-07-29 18:02:00','{\"fromDate\":\"2026-07-28T18:02\",\"toDate\":\"2026-07-29T18:02\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"1\",\"price\":\"15\",\"vat\":\"10\",\"total\":\"16.500\",\"notes\":\"\",\"quotation_ref\":\"\"}','Confirmed',1,1,'2026-06-22 18:02:51','2026-06-29 11:29:32'),(6,'AA/2026/RS/0006',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333','direct','','C0005','ruel','{\"customer_code\":\"C0005\",\"customer_name\":\"ruel\",\"phone\":\"37338987\",\"email\":\"\",\"address\":\"blk 340 bld 176 rd 4005 mannai plaz ajuffair\",\"attention\":\"\"}','2026-06-30 11:38:00','2026-07-03 11:38:00','{\"fromDate\":\"2026-06-30T11:38\",\"toDate\":\"2026-07-03T11:38\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"3\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Booked',1,1,'2026-06-29 11:39:38','2026-06-29 11:39:38'),(7,'AA/2026/RS/0007',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',5,'157763','direct','','C0005','ruel','{\"customer_code\":\"C0005\",\"customer_name\":\"ruel\",\"phone\":\"37338987\",\"email\":\"\",\"address\":\"blk 340 bld 176 rd 4005 mannai plaz ajuffair\",\"attention\":\"\"}','2026-06-29 12:11:00','2026-06-30 12:11:00','{\"fromDate\":\"2026-06-29T12:11\",\"toDate\":\"2026-06-30T12:11\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"1\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Rentout',1,1,'2026-06-29 12:12:37','2026-07-28 12:38:28'),(8,'AA/2026/RS/0008',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-17 15:12:00','2026-07-27 15:12:00','{\"fromDate\":\"2026-07-17T15:12\",\"toDate\":\"2026-07-27T15:12\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"10\",\"price\":\"15\",\"vat\":\"10\",\"total\":\"165.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Booked',1,1,'2026-07-11 15:12:50','2026-07-11 15:12:50'),(9,'AA/2026/RS/0008',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',5,'157763','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-17 15:12:00','2026-07-27 15:12:00','{\"fromDate\":\"2026-07-17T15:12\",\"toDate\":\"2026-07-27T15:12\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"10\",\"price\":\"15\",\"vat\":\"10\",\"total\":\"165.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-11 15:12:50','2026-07-11 15:14:56'),(10,'AA/2026/RS/0009',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',6,'157720','direct','','C0010','Tanu','{\"customer_code\":\"C0010\",\"customer_name\":\"Tanu\",\"phone\":\"123123\",\"email\":\"tanu@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-07-05 15:18:00','2026-07-23 15:18:00','{\"fromDate\":\"2026-07-05T15:18\",\"toDate\":\"2026-07-23T15:18\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"18\",\"price\":\"13\",\"vat\":\"10\",\"total\":\"257.400\",\"notes\":\"tesy\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-11 15:19:36','2026-07-11 18:50:16'),(11,'AA/2026/RS/0010',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745','direct','','C0009','ANZEL SAIT','{\"customer_code\":\"C0009\",\"customer_name\":\"ANZEL SAIT\",\"phone\":\"33661055\",\"email\":\"anzelabk@gmail.com\",\"address\":\"FASTLINK\",\"attention\":\"BAD CUSTOMER\"}','2026-07-14 14:55:00','2026-07-15 14:56:00','{\"fromDate\":\"2026-07-14T14:55\",\"toDate\":\"2026-07-15T14:56\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"2\",\"price\":\"1\",\"vat\":\"10\",\"total\":\"2.200\",\"notes\":\"REMIND ME TOMORROW TO CALL CLIENT\",\"quotation_ref\":\"\"}','Closed',1,1,'2026-07-14 14:57:58','2026-07-23 15:55:01'),(12,'AA/2026/RS/0011',1,'SMALL CARS',1,'NISSAN',1,'MICRA',1,'12345','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-23 12:03:00','2026-07-24 12:03:00','{\"fromDate\":\"2026-07-23T12:03\",\"toDate\":\"2026-07-24T12:03\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"24\",\"price\":\"6\",\"vat\":\"10\",\"total\":\"158.400\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-23 12:03:56','2026-07-23 12:06:40'),(13,'AA/2026/RS/0012',1,'SMALL CARS',1,'NISSAN',1,'MICRA',1,'12345','direct','','C0005','ruel','{\"customer_code\":\"C0005\",\"customer_name\":\"ruel\",\"phone\":\"37338987\",\"email\":\"\",\"address\":\"blk 340 bld 176 rd 4005 mannai plaz ajuffair\",\"attention\":\"\"}','2026-07-23 14:34:00','2026-07-25 14:34:00','{\"fromDate\":\"2026-07-23T14:34\",\"toDate\":\"2026-07-25T14:34\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"2\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"22.000\",\"notes\":\"HI\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-23 14:37:40','2026-07-23 15:54:12'),(14,'AA/2026/RS/0013',1,'SMALL CARS',1,'NISSAN',1,'MICRA',8,'90909','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-07-01 15:57:00','2026-07-31 15:58:00','{\"fromDate\":\"2026-07-01T15:57\",\"toDate\":\"2026-07-31T15:58\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"721\",\"price\":\"8\",\"vat\":\"10\",\"total\":\"6344.800\",\"notes\":\"tt\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-23 15:58:32','2026-07-23 16:00:53'),(15,'AA/2026/RS/0014',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745','direct','','C0009','ANZEL SAIT','{\"customer_code\":\"C0009\",\"customer_name\":\"ANZEL SAIT\",\"phone\":\"33661055\",\"email\":\"anzelabk@gmail.com\",\"address\":\"FASTLINK\",\"attention\":\"BAD CUSTOMER\"}','2026-08-08 12:01:00','2026-08-20 12:01:00','{\"fromDate\":\"2026-08-08T12:01\",\"toDate\":\"2026-08-20T12:01\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"12\",\"price\":\"30\",\"vat\":\"10\",\"total\":\"396.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Returned',1,65,'2026-07-25 12:02:32','2026-07-25 12:04:15'),(16,'AA/2026/RS/0015',1,'SMALL CARS',3,'HONDA',4,'CITY',13,'568568','direct','','C0003','Client1','{\"customer_code\":\"C0003\",\"customer_name\":\"Client1\",\"phone\":\"112424\",\"email\":\"ancy@gmail.com\",\"address\":\"tets\",\"attention\":\"tedst\"}','2026-08-04 18:13:00','2026-08-08 18:13:00','{\"fromDate\":\"2026-08-04T18:13\",\"toDate\":\"2026-08-08T18:13\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"4\",\"price\":\"15\",\"vat\":\"10\",\"total\":\"66.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-07-27 18:13:43','2026-07-28 10:57:49'),(18,'AA/2026/RS/0017',1,'SMALL CARS',2,'CHANGAN',3,'ALSVIN',14,'55555','direct','','C0010','Tanu','{\"customer_code\":\"C0010\",\"customer_name\":\"Tanu\",\"phone\":\"123123\",\"email\":\"tanu@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-08-01 15:18:00','2026-08-02 15:18:00','{\"fromDate\":\"2026-08-01T15:18\",\"toDate\":\"2026-08-02T15:18\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"1\",\"price\":\"2\",\"vat\":\"10\",\"total\":\"2.200\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Closed',1,1,'2026-08-01 15:18:50','2026-08-01 15:20:30'),(19,'AA/2026/RS/0018',1,'SMALL CARS',2,'CHANGAN',3,'ALSVIN',12,'123123','direct','','C0010','Tanu','{\"customer_code\":\"C0010\",\"customer_name\":\"Tanu\",\"phone\":\"123123\",\"email\":\"tanu@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-08-05 16:44:00','2026-08-06 16:44:00','{\"fromDate\":\"2026-08-05T16:44\",\"toDate\":\"2026-08-06T16:44\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"1\",\"price\":\"12\",\"vat\":\"10\",\"total\":\"13.200\",\"notes\":\"\",\"quotation_ref\":\"\"}','Returned',1,1,'2026-08-01 16:44:59','2026-08-01 16:46:00'),(20,'AA/2026/RS/0019',1,'SMALL CARS',1,'NISSAN',1,'MICRA',1,'12345','direct','','C0010','Tanu','{\"customer_code\":\"C0010\",\"customer_name\":\"Tanu\",\"phone\":\"123123\",\"email\":\"tanu@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-08-08 17:00:00','2026-08-09 17:00:00','{\"fromDate\":\"2026-08-08T17:00\",\"toDate\":\"2026-08-09T17:00\",\"rateType\":\"hour\",\"service\":\"2\",\"duration\":\"24\",\"price\":\"0\",\"vat\":\"0\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Rentout',1,1,'2026-08-01 17:00:51','2026-08-01 17:01:55'),(21,'AA/2026/RS/0020',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',6,'157720','direct','','C0014','Sinto','{\"customer_code\":\"C0014\",\"customer_name\":\"Sinto\",\"phone\":\"123123\",\"email\":\"sinto@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2026-08-12 12:14:00','2026-08-13 11:11:00','{\"fromDate\":\"2026-08-12 12:14\",\"toDate\":\"2026-08-13 11:11\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"23\",\"price\":\"10\",\"vat\":\"10\",\"total\":\"253.000\",\"notes\":\"test\",\"quotation_ref\":\"\"}','Rentout',1,1,'2026-08-26 17:40:25','2026-08-27 16:24:11'),(22,'AA/2026/RS/0021',1,'SMALL CARS',2,'CHANGAN',3,'ALSVIN',14,'55555','direct','','C0014','Sinto','{\"customer_code\":\"C0014\",\"customer_name\":\"Sinto\",\"phone\":\"123123\",\"email\":\"sinto@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2027-01-01 00:00:00','2027-01-31 00:00:00','{\"fromDate\":\"2027-01-01 00:00\",\"toDate\":\"2027-01-31 00:00\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"30\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Confirmed',1,1,'2026-08-30 16:46:59','2026-08-30 16:46:59'),(23,'AA/2026/RS/0022',1,'SMALL CARS',3,'HONDA',4,'CITY',13,'568568','direct','','C0014','Sinto','{\"customer_code\":\"C0014\",\"customer_name\":\"Sinto\",\"phone\":\"123123\",\"email\":\"sinto@gmail.com\",\"address\":\"test\",\"attention\":\"test\"}','2027-01-01 00:00:00','2027-01-31 00:00:00','{\"fromDate\":\"2027-01-01 00:00\",\"toDate\":\"2027-01-31 00:00\",\"rateType\":\"day\",\"service\":\"1\",\"duration\":\"30\",\"price\":\"15\",\"vat\":\"10\",\"total\":\"495.000\",\"notes\":\"\",\"quotation_ref\":\"\"}','Confirmed',1,1,'2026-08-30 16:49:44','2026-08-30 18:48:07');
/*!40000 ALTER TABLE `tbl_vehicle_bookings` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_vehicle_brand`
--

LOCK TABLES `tbl_vehicle_brand` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_brand` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_brand` VALUES (1,'NISSAN',NULL,'Active','default.jpg'),(2,'CHANGAN',NULL,'Active','default.jpg'),(3,'HONDA',NULL,'Active','default.jpg'),(4,'HYUNDAI',NULL,'Active','default.jpg'),(5,'KIA',NULL,'Active','default.jpg'),(6,'MITSUBISHI',NULL,'Active','default.jpg'),(7,'TOYOTA',NULL,'Active','default.jpg'),(8,'MAZDA',NULL,'Active','default.jpg'),(9,'MG',NULL,'Active','default.jpg'),(10,'SUZUKI',NULL,'Active','default.jpg'),(11,'AUDI',NULL,'Active','default.jpg'),(12,'BMW',NULL,'Active','default.jpg'),(13,'LEXUS',NULL,'Active','default.jpg'),(14,'MERCEDES BENZ',NULL,'Active','default.jpg'),(15,'FORD',NULL,'Active','default.jpg'),(16,'GMC',NULL,'Active','default.jpg'),(17,'CHEVROLET',NULL,'Active','default.jpg'),(18,'JEEP',NULL,'Active','default.jpg'),(19,'LAND ROVER',NULL,'Active','default.jpg'),(20,'VOLKSWAGEN',NULL,'Active','default.jpg'),(21,'MINI COOPER','','Active','69da64c443675.jpg'),(22,'ISUZU','','Active','default.jpg');
/*!40000 ALTER TABLE `tbl_vehicle_brand` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_vehicle_category`
--

LOCK TABLES `tbl_vehicle_category` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_category` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_category` VALUES (1,'SMALL CARS','small_car.jpg','Compact and fuel-efficient vehicles, ideal for city driving and short trips.','Active'),(2,'MEDIUM CARS','medium_car.jpg','Comfortable mid-size cars suitable for daily use, business travel, and small families.','Active'),(3,'MEDIUM SUV CARS','medium_suv.jpg','Spacious and versatile vehicles with higher ground clearance, perfect for family trips and mixed road conditions.','Active'),(4,'LEXURY SEDAN','luxury_sedan.jpg','Premium vehicles offering superior comfort, advanced features, and a smooth driving experience.','Active'),(5,'SUV','SUV.jpg','Large and powerful vehicles designed for space, comfort, and performance on all types of terrain.','Active'),(6,'LUGGAGE VAN','luggage_van.jpg','Specially designed vans for transporting luggage and cargo, ideal for airport transfers and logistics.','Active'),(7,'MINIBUS ','mini_bus.jpg','Compact buses that can carry small groups, suitable for tours, staff transport, and events.','Active'),(8,'PICKUP','pickup.jpg','Utility vehicles with an open cargo bed, ideal for transporting goods and light commercial use.','Active'),(9,'HATCHBACK','hatchback.jpg','Small cars with a rear door opening upwards, offering compact size with flexible storage space.','Active'),(10,'MID BUS','mid_bus.jpg','Medium-capacity buses designed for group travel, offering more seating than minibuses with added comfort.','Active'),(11,'VAN','van.jpg','Multi-purpose vehicles used for both passenger transport and cargo, suitable for business or family use.','Active'),(12,'SIX WHEEL / FLAT BED  / TOWING','default.jpg','Heavy-duty vehicles designed for transporting large loads, equipment, or towing other vehicles.','Active'),(19,'NISSAN SUNNY','default.jpg','SMALL','Active'),(20,'NISSAN SUNNY','default.jpg','SMALL CAR','Active');
/*!40000 ALTER TABLE `tbl_vehicle_category` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_contract_extensions_chk_1` CHECK (json_valid(`customer_details`)),
  CONSTRAINT `tbl_vehicle_contract_extensions_chk_2` CHECK (json_valid(`vehicle_details`)),
  CONSTRAINT `tbl_vehicle_contract_extensions_chk_3` CHECK (json_valid(`otp_details`)),
  CONSTRAINT `tbl_vehicle_contract_extensions_chk_4` CHECK (json_valid(`extend_log_json`))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_contract_extensions`
--

LOCK TABLES `tbl_vehicle_contract_extensions` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_contract_extensions` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_contract_extensions` VALUES (1,1,1,'AA/2026/AGR/0001',1,'C0001',1,'{\"customer_name\":\"ABC\",\"customer_code\":\"C0001\",\"customer_mobile\":\"12121\",\"customer_email\":\"abc@gmail.com\",\"customer_attention\":\"tsse\",\"customer_address\":\"Manama, Kingdom of Bahrain\"}','{\"vehicle_id\":\"1\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2015\"}','2026-06-20','2026-06-18 11:09:00','2026-06-29 17:14:00','{\"period_from\":\"2026-06-18T11:09\",\"period_to\":\"2026-06-29T17:14\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"271\",\"unit_price\":\"14\",\"min_price\":\"5.000\",\"vat\":\"0\",\"total_amt\":\"3794.000\",\"qtn_ref_no\":\"AA\\/2026\\/PM\\/0001\",\"booking_notes\":\"\",\"otp_details\":\"\"}','\"\"','{\"user_id\":1,\"datetime\":\"2026-06-20 17:14:18\"}'),(2,1,3,'AA/2026/AGR/0003',3,'C0003',3,'{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','{\"vehicle_id\":\"3\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"333333\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"white\",\"vehicle_year\":\"2000\"}','2026-06-22','2026-07-10 11:33:00','2026-07-18 11:48:00','{\"period_from\":\"2026-07-10T11:33\",\"period_to\":\"2026-07-18T11:48\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"9\",\"unit_price\":\"20\",\"min_price\":\"13.000\",\"vat\":\"0\",\"total_amt\":\"180.000\",\"qtn_ref_no\":\"3453\",\"booking_notes\":\"test\",\"otp_details\":\"\"}','\"\"','{\"user_id\":64,\"datetime\":\"2026-06-22 11:49:00\"}'),(3,1,14,'AA/2026/AGR/0015',17,'C0010',12,'{\"customer_name\":\"Tanu\",\"customer_code\":\"C0010\",\"customer_mobile\":\"123123\",\"customer_email\":\"tanu@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','{\"vehicle_id\":\"12\",\"category_id\":\"1\",\"model_id\":\"3\",\"veh_no\":\"123123\",\"category_name\":\"SMALL CARS\",\"model_name\":\"CHANGAN ALSVIN\",\"vehicle_color\":\"Black\",\"vehicle_year\":\"2025\"}','2026-07-28','2026-08-10 13:01:00','2026-08-12 13:12:00','{\"period_from\":\"2026-08-10T13:01\",\"period_to\":\"2026-08-12T13:12\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"3\",\"unit_price\":\"6\",\"min_price\":\"0.000\",\"vat\":\"10\",\"total_amt\":\"19.800\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}','\"\"','{\"user_id\":1,\"datetime\":\"2026-07-28 13:12:34\"}');
/*!40000 ALTER TABLE `tbl_vehicle_contract_extensions` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_contract_replacement_chk_1` CHECK (json_valid(`customer_details`)),
  CONSTRAINT `tbl_vehicle_contract_replacement_chk_2` CHECK (json_valid(`vehicle_details`)),
  CONSTRAINT `tbl_vehicle_contract_replacement_chk_3` CHECK (json_valid(`otp_details`)),
  CONSTRAINT `tbl_vehicle_contract_replacement_chk_4` CHECK (json_valid(`extend_log_json`))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_contract_replacement`
--

LOCK TABLES `tbl_vehicle_contract_replacement` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_contract_replacement` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_contract_replacement` VALUES (1,1,1,'AA/2026/AGR/0001',1,'C0001',1,'{\"customer_name\":\"ABC\",\"customer_code\":\"C0001\",\"customer_mobile\":\"12121\",\"customer_email\":\"abc@gmail.com\",\"customer_attention\":\"tsse\",\"customer_address\":\"Manama, Kingdom of Bahrain\"}','{\"vehicle_id\":\"1\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2015\"}','2026-06-20','2026-06-18 11:09:00','2026-06-29 17:14:00','{\"period_from\":\"2026-06-18T11:09\",\"period_to\":\"2026-06-29T17:14\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"271\",\"unit_price\":\"14\",\"min_price\":\"5.000\",\"vat\":\"0\",\"total_amt\":\"3794.000\",\"qtn_ref_no\":\"AA\\/2026\\/PM\\/0001\",\"booking_notes\":\"\",\"otp_details\":\"\"}','\"\"','{\"user_id\":1,\"datetime\":\"2026-06-20 17:14:18\"}'),(2,1,3,'AA/2026/AGR/0003',3,'C0003',3,'{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','{\"vehicle_id\":\"3\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"333333\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"white\",\"vehicle_year\":\"2000\"}','2026-06-22','2026-07-10 11:33:00','2026-07-18 11:48:00','{\"period_from\":\"2026-07-10T11:33\",\"period_to\":\"2026-07-18T11:48\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"9\",\"unit_price\":\"20\",\"min_price\":\"13.000\",\"vat\":\"0\",\"total_amt\":\"180.000\",\"qtn_ref_no\":\"3453\",\"booking_notes\":\"test\",\"otp_details\":\"\"}','\"\"','{\"user_id\":64,\"datetime\":\"2026-06-22 11:49:00\"}');
/*!40000 ALTER TABLE `tbl_vehicle_contract_replacement` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_log_movement`
--

LOCK TABLES `tbl_vehicle_log_movement` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_log_movement` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_log_movement` VALUES (1,12,'123123','2026-07-27 18:06:55','Vehicle Added',NULL,'Available','Vehicle',12,'123123',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',NULL,'Administrator','2026-07-27 12:36:55'),(2,13,'568568','2026-07-27 18:13:00','Vehicle Added',NULL,'Available','Vehicle',13,'568568',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-07-27 12:43:00'),(3,13,'568568','2026-07-28 13:27:49','Rentout','Available','Rentout','Agreement',13,'AA/2026/AGR/0013','Main Parking','Customer',NULL,'C0003',NULL,123,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0013',1,'Administrator','2026-07-28 07:57:49'),(4,5,'157763','2026-07-28 15:08:28','Rentout','Rentout','Rentout','Agreement',5,'AA/2026/AGR/0005','Main Parking','Customer',NULL,'C0005',NULL,0,'','Vehicle rented out under Agreement No. AA/2026/AGR/0005',1,'Administrator','2026-07-28 09:38:28'),(5,12,'123123','2026-07-28 15:39:52','Rentout','Available','Rentout','Agreement',14,'AA/2026/AGR/0015','Main Parking','Customer',NULL,'C0010',NULL,123,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0015',1,'Administrator','2026-07-28 10:09:52'),(6,12,'123123','2026-07-28 16:09:54','Return','Rentout','Parking','Agreement',14,'AA/2026/AGR/0015','Customer','Main Parking',NULL,NULL,NULL,223,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0015',1,'Administrator','2026-07-28 10:39:54'),(7,13,'568568','2026-08-01 14:00:00','Return','Rentout','Parking','Agreement',13,'AA/2026/AGR/0014','Customer','Main Parking',NULL,NULL,NULL,12,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0014',1,'Administrator','2026-08-01 11:00:00'),(8,1,'12345','2026-08-01 14:12:32','Return','Rentout','Parking','Agreement',10,'AA/2026/AGR/0010','Customer','Main Parking',NULL,NULL,NULL,12,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0010',1,'Administrator','2026-08-01 11:12:32'),(9,14,'55555','2026-08-01 14:18:08','Vehicle Added',NULL,'Available','Vehicle',14,'55555',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-08-01 11:18:08'),(10,14,'55555','2026-08-01 15:20:30','Rentout','Available','Rentout','Agreement',15,'AA/2026/AGR/0016','Main Parking','Customer',NULL,'C0010',NULL,123,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0016',1,'Administrator','2026-08-01 12:20:30'),(11,14,'55555','2026-08-01 15:21:51','Return','Rentout','Parking','Agreement',15,'AA/2026/AGR/0016','Customer','Main Parking',NULL,NULL,NULL,1233,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0016',1,'Administrator','2026-08-01 12:21:51'),(12,6,'157720','2026-08-01 15:30:46','Return','Rentout','Parking','Agreement',7,'AA/2026/AGR/0007','Customer','Main Parking',NULL,NULL,NULL,1232,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0007',1,'Administrator','2026-08-01 12:30:46'),(13,5,'157763','2026-08-01 16:35:04','Return','Rentout','Parking','Agreement',6,'AA/2026/AGR/0006','Customer','Main Parking',NULL,NULL,NULL,23,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0006',1,'Administrator','2026-08-01 13:35:04'),(14,12,'123123','2026-08-01 16:46:00','Rentout','Available','Rentout','Agreement',16,'AA/2026/AGR/0017','Main Parking','Customer',NULL,'C0010',NULL,123,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0017',1,'Administrator','2026-08-01 13:46:00'),(15,12,'123123','2026-08-01 16:47:20','Return','Rentout','Parking','Agreement',16,'AA/2026/AGR/0017','Customer','Main Parking',NULL,NULL,NULL,0,NULL,'Vehicle returned under Agreement No. AA/2026/AGR/0017',1,'Administrator','2026-08-01 13:47:20'),(16,1,'12345','2026-08-01 17:01:55','Rentout','Available','Rentout','Agreement',17,'AA/2026/AGR/0018','Main Parking','Customer',NULL,'C0010',NULL,132,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0018',1,'Administrator','2026-08-01 14:01:55'),(17,1,'12345','2026-08-02 17:08:34','Replace Return','Rentout','Parking','Agreement',17,'AA/2026/AGR/0018','Customer','Main Parking',NULL,'C0010',NULL,234,'full','Replaced on contract: ',1,'Administrator','2026-08-02 14:08:34'),(18,6,'157720','2026-08-02 17:08:34','Replace Rentout','Parking','Rentout','Agreement',17,'AA/2026/AGR/0018','Main Parking','Customer',NULL,'C0010',NULL,0,'','Assigned on contract replacement: ',1,'Administrator','2026-08-02 14:08:34'),(19,1,'12345','2026-08-02 17:12:16','Replace Return','Rentout','Parking','Agreement',17,'AA/2026/AGR/0018','Customer','Main Parking',NULL,'C0010',NULL,155,'full','Replaced on contract: test',1,'Administrator','2026-08-02 14:12:16'),(20,14,'55555','2026-08-02 17:12:16','Replace Rentout','Parking','Rentout','Agreement',17,'AA/2026/AGR/0018','Main Parking','Customer',NULL,'C0010',NULL,100,'full','Assigned on contract replacement: test',1,'Administrator','2026-08-02 14:12:16'),(21,14,'55555','2026-08-02 17:33:03','Replace Return','Rentout','Parking','Agreement',17,'AA/2026/AGR/0018','Customer','Main Parking',NULL,'C0010',NULL,200,'full','Replaced on contract: test',1,'Administrator','2026-08-02 14:33:03'),(22,13,'568568','2026-08-02 17:33:03','Replace Rentout','Parking','Rentout','Agreement',17,'AA/2026/AGR/0018','Main Parking','Customer',NULL,'C0010',NULL,123,'half','Assigned on contract replacement: test',1,'Administrator','2026-08-02 14:33:03'),(23,13,'568568','2026-08-02 17:52:36','Replace Return','Rentout','Parking','Agreement',17,'AA/2026/AGR/0018','Customer','Main Parking',NULL,'C0010',NULL,444,'full','Replaced on contract: ',1,'Administrator','2026-08-02 14:52:36'),(24,8,'90909','2026-08-02 17:52:36','Replace Rentout','Parking','Rentout','Agreement',17,'AA/2026/AGR/0018','Main Parking','Customer',NULL,'C0010',NULL,33333,'','Assigned on contract replacement: ',1,'Administrator','2026-08-02 14:52:36'),(25,15,'909090','2026-08-19 15:08:55','Vehicle Added',NULL,'Available','Vehicle',15,'909090',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',74,'accounts1','2026-08-19 12:08:55'),(26,13,'568568','2026-08-23 11:06:00','Maintenance Out','Parking','Maintenance','Maintenance Request',5,'AA-MR-2026-0004',NULL,NULL,NULL,NULL,1,444,NULL,'test',NULL,NULL,'2026-08-23 08:06:30'),(27,13,'568568','2026-08-23 11:43:00','Maintenance In','Maintenance','Parking','Maintenance Request',5,'AA-MR-2026-0004',NULL,NULL,NULL,NULL,1,555,NULL,'tet',NULL,NULL,'2026-08-23 08:43:13'),(28,12,'123123','2026-08-23 12:40:00','Maintenance Out','Parking','Maintenance','Maintenance Request',6,'AA-MR-2026-0005',NULL,NULL,NULL,NULL,1,123,NULL,'ttt',NULL,NULL,'2026-08-23 09:40:24'),(29,12,'123123','2026-08-23 12:40:00','Maintenance In','Maintenance','Parking','Maintenance Request',6,'AA-MR-2026-0005',NULL,NULL,NULL,NULL,1,444,NULL,'ttr',NULL,NULL,'2026-08-23 09:40:44'),(30,16,'123333','2026-08-26 17:43:32','Vehicle Added',NULL,'Available','Vehicle',16,'123333',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-08-26 14:43:32'),(31,13,'568568','2026-08-30 16:52:17','Rentout','Available','Rentout','Agreement',19,'AA/2026/AGR/0031','Main Parking','Customer',NULL,'C0014',NULL,111,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0031',1,'Administrator','2026-08-30 13:52:17'),(32,13,'568568','2026-08-30 16:52:17','Rentout','Rentout','Rentout','Agreement',19,'AA/2026/AGR/0031','Main Parking','Customer',NULL,'C0014',NULL,111,'full','Vehicle rented out under Agreement No. AA/2026/AGR/0031',1,'Administrator','2026-08-30 13:52:17'),(33,17,'898989','2026-08-30 21:55:08','Vehicle Added',NULL,'Available','Vehicle',17,'898989',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-08-30 18:55:08'),(34,18,'555666','2026-08-30 21:56:03','Vehicle Added',NULL,'Available','Vehicle',18,'555666',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-08-30 18:56:03'),(35,1,'12345','2026-09-03 12:51:01','Rentout',NULL,NULL,'Direct Contract',33,'AA/2026/AGR/0041',NULL,NULL,NULL,'C0014',NULL,155,'full',NULL,1,'System','2026-09-03 09:51:01'),(36,17,'898989','2026-09-03 12:51:01','Rentout',NULL,NULL,'Direct Contract',34,'AA/2026/AGR/0042',NULL,NULL,NULL,'C0014',NULL,0,'',NULL,1,'System','2026-09-03 09:51:01'),(37,19,'545454','2026-09-03 12:54:42','Vehicle Added',NULL,'Available','Vehicle',19,'545454',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-09-03 09:54:42'),(38,20,'753159','2026-09-03 12:55:22','Vehicle Added',NULL,'Available','Vehicle',20,'753159',NULL,'Main Parking',NULL,NULL,NULL,NULL,NULL,'New vehicle registered into the system.',1,'Administrator','2026-09-03 09:55:22');
/*!40000 ALTER TABLE `tbl_vehicle_log_movement` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_model_chk_1` CHECK (json_valid(`price_json`))
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_model`
--

LOCK TABLES `tbl_vehicle_model` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_model` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_model` VALUES (1,1,1,'MICRA','micra.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"5\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"5\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"6\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"5\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"5\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"5\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"5\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5\"}]'),(2,1,1,'SUNNY','sunny.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"10\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"11\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"12\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"13\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"14\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"15\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"16\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"17\"},{\"ids\":\"12\",\"item\":\"Delay Fine\",\"amount\":\"5\"},{\"ids\":\"13\",\"item\":\"10\",\"amount\":\"\"}]'),(3,1,2,'ALSVIN','alsvin.jpg','Active',NULL,NULL),(4,1,3,'CITY','city.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"10\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"12\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"14\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"15\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"10\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"14\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"15\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"20\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"\"},{\"ids\":\"10\",\"item\":\"test\",\"amount\":\"\"},{\"ids\":\"11\",\"item\":\"123\",\"amount\":\"\"}]'),(5,1,4,'ACCENT','accent.jpg','Active',NULL,NULL),(6,1,5,'PEGAS','pegas.jpg','Active',NULL,NULL),(7,1,6,'LANCER','lancer.jpg','Active',NULL,NULL),(8,1,7,'YARIS','default.jpg','Active',NULL,NULL),(9,1,7,'COROLLA ','default.jpg','Active',NULL,NULL),(10,2,1,'ALTIMA ','default.jpg','Active',NULL,NULL),(11,2,1,'MAXIMA ','default.jpg','Active',NULL,NULL),(12,2,7,'CAMRY','default.jpg','Active',NULL,NULL),(13,2,7,'AVALON','default.jpg','Active',NULL,NULL),(14,2,4,'ELENTRA','default.jpg','Active',NULL,NULL),(15,2,5,'OPTIMA ','default.jpg','Active',NULL,NULL),(16,2,5,'K5','default.jpg','Active',NULL,NULL),(17,2,7,'CROWN','default.jpg','Active',NULL,NULL),(18,3,1,'KICKS','default.jpg','Active',NULL,NULL),(19,3,1,'MAGNITE','default.jpg','Active',NULL,NULL),(20,3,7,'COROLLA CROSS','default.jpg','Active',NULL,NULL),(21,3,7,'RAIZE','default.jpg','Active',NULL,NULL),(22,3,7,'RUSH','default.jpg','Active',NULL,NULL),(23,3,7,'VELOZ','default.jpg','Active',NULL,NULL),(24,3,7,'URBAN CRUISER','default.jpg','Active',NULL,NULL),(25,3,7,'RAV4','default.jpg','Active',NULL,NULL),(26,3,8,'CX9','default.jpg','Active',NULL,NULL),(27,3,9,'RX5','default.jpg','Active',NULL,NULL),(28,3,9,'ZS11','default.jpg','Active',NULL,NULL),(29,3,9,'RX8','default.jpg','Active',NULL,NULL),(30,3,9,'RX9','default.jpg','Active',NULL,NULL),(31,3,10,'JIMNY','default.jpg','Active',NULL,NULL),(32,4,11,'A3','default.jpg','Active',NULL,NULL),(33,4,11,'A4','default.jpg','Active',NULL,NULL),(34,4,11,'A6','default.jpg','Active',NULL,NULL),(35,4,11,'A8','default.jpg','Active',NULL,NULL),(36,4,12,'5 SERIES','default.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"342\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"45\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"9.253\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"8\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"7\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"8\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"3\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5.485\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"11\"},{\"ids\":\"10\",\"item\":\"test\",\"amount\":\"14\"},{\"ids\":\"11\",\"item\":\"123\",\"amount\":\"12\"}]'),(37,4,12,'7 SERIES','default.jpg','Active',NULL,NULL),(38,4,13,'ES350','default.jpg','Active',NULL,NULL),(39,4,13,'LS500','default.jpg','Active',NULL,NULL),(40,4,13,'LS350','default.jpg','Active',NULL,NULL),(41,4,14,'A-CLASS','default.jpg','Active',NULL,'[{\"ids\":null,\"item\":\"\",\"amount\":\"34\"},{\"ids\":null,\"item\":\"\",\"amount\":\"43\"},{\"ids\":null,\"item\":\"\",\"amount\":\"567\"},{\"ids\":null,\"item\":\"\",\"amount\":\"657\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"},{\"ids\":null,\"item\":\"\",\"amount\":\"\"}]'),(42,4,14,'C-CLASS','default.jpg','Active',NULL,NULL),(43,4,14,'E-CLASS','default.jpg','Active',NULL,NULL),(44,4,14,'S-CLASS','default.jpg','Active',NULL,NULL),(45,4,14,'MAYBACH S CLASS','default.jpg','Active',NULL,NULL),(46,4,14,'EQS','default.jpg','Active',NULL,NULL),(47,5,1,'PATROL','default.jpg','Active',NULL,NULL),(48,5,1,'PATHFINDER','default.jpg','Active',NULL,NULL),(49,5,1,'X- TERRA','default.jpg','Active',NULL,NULL),(50,5,1,'X-TRAIL','default.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"4\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"4\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"25\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"25\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"150\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"150\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"350\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"350\"},{\"ids\":\"12\",\"item\":\"Delay Fine\",\"amount\":\"25\"},{\"ids\":\"13\",\"item\":\"10\",\"amount\":\"\"}]'),(51,5,14,'G -CLASS','default.jpg','Active',NULL,NULL),(52,5,7,'FORTUNER','default.jpg','Active',NULL,NULL),(53,5,7,'SEQUOIA','default.jpg','Active',NULL,NULL),(54,5,7,'HIGHLANDER','default.jpg','Active',NULL,NULL),(55,5,7,'LAND CRUISER PRADO','default.jpg','Active',NULL,NULL),(56,5,7,'LAND CRUISER ','default.jpg','Active',NULL,NULL),(57,5,15,'TERRITORY','default.jpg','Active',NULL,NULL),(58,5,15,'BRONCO','default.jpg','Active',NULL,'[{\"ids\":\"1\",\"item\":\"Price per hour without driver\",\"amount\":\"\"},{\"ids\":\"2\",\"item\":\"Price per hour with driver\",\"amount\":\"\"},{\"ids\":\"3\",\"item\":\"Price per day without driver\",\"amount\":\"\"},{\"ids\":\"4\",\"item\":\"Price per day with driver\",\"amount\":\"\"},{\"ids\":\"5\",\"item\":\"Price per week without driver\",\"amount\":\"\"},{\"ids\":\"6\",\"item\":\"Price per week with driver\",\"amount\":\"8\"},{\"ids\":\"7\",\"item\":\"Price per month without driver\",\"amount\":\"\"},{\"ids\":\"8\",\"item\":\"Price per month with driver\",\"amount\":\"8\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"5\"}]'),(59,5,15,'EXPEDITION','default.jpg','Active',NULL,NULL),(60,5,16,'YUKON','default.jpg','Active',NULL,NULL),(61,5,17,'TAHOE','default.jpg','Active',NULL,NULL),(62,5,18,'WRENGLER','default.jpg','Active',NULL,NULL),(63,5,18,'Grand Cherokee ','default.jpg','Active',NULL,NULL),(64,5,13,'RX350','default.jpg','Active',NULL,NULL),(65,5,13,'LX 600','default.jpg','Active',NULL,NULL),(66,5,13,'LX 700','default.jpg','Active',NULL,NULL),(67,5,19,'DEFENDER','default.jpg','Active',NULL,NULL),(68,5,19,'Range Rover Sport','default.jpg','Active',NULL,NULL),(69,5,19,'Range Rover Velar','default.jpg','Active',NULL,NULL),(70,5,19,'Range Rover Evoque','default.jpg','Active',NULL,NULL),(71,5,19,'Discovery','default.jpg','Active',NULL,NULL),(72,5,20,'TERAMOUNT','default.jpg','Active',NULL,NULL),(73,6,7,'HIACE CARGO ','default.jpg','Active',NULL,NULL),(74,6,1,'URVAN CAGRO','default.jpg','Active',NULL,NULL),(75,7,7,'HIACE','default.jpg','Active',NULL,NULL),(76,7,1,'URVAN','default.jpg','Active',NULL,NULL),(77,8,7,'HILUX','default.jpg','Active',NULL,NULL),(78,9,21,'CONVERTIBLE','default.jpg','Active',NULL,NULL),(79,9,21,'COUNTRYMAN','default.jpg','Active',NULL,NULL),(80,9,21,'COOPER -S','default.jpg','Active',NULL,NULL),(81,10,7,'COASTER','default.jpg','Active',NULL,NULL),(82,11,14,'VITO','default.jpg','Active',NULL,NULL),(83,11,14,'VIANO','default.jpg','Active',NULL,NULL),(84,11,14,'SPRINTER','default.jpg','Active',NULL,NULL),(85,12,22,'NPR','default.jpg','Active',NULL,NULL),(86,12,22,'NPR DOUBLE CABIN','default.jpg','Active',NULL,NULL),(91,19,1,'2025','default.jpg','Active','216175',NULL);
/*!40000 ALTER TABLE `tbl_vehicle_model` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_non_revenue_ticket_chk_1` CHECK (json_valid(`book_details_json`))
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_non_revenue_ticket`
--

LOCK TABLES `tbl_vehicle_non_revenue_ticket` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_non_revenue_ticket` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_non_revenue_ticket` VALUES (1,'AA/2026/NRT/0001',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 18:30:00','2026-07-21 18:31:00','','{\"from_datetime\":\"2026-07-21 18:30:00\",\"to_datetime\":null,\"notes\":\"\"}','Returned','test',1,1,'2026-07-21 18:30:54','2026-07-21 18:31:11',1),(2,'AA/2026/NRT/0002',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 18:31:00','2026-07-21 18:34:00','','{\"from_datetime\":\"2026-07-21 18:31:00\",\"to_datetime\":null,\"notes\":\"\"}','Returned','test',1,1,'2026-07-21 18:32:03','2026-07-21 18:34:22',1),(3,'AA/2026/NRT/0002',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 18:31:00','2026-07-21 18:34:00','','{\"from_datetime\":\"2026-07-21 18:31:00\",\"to_datetime\":null,\"notes\":\"\"}','Returned','test',1,1,'2026-07-21 18:32:03','2026-07-21 18:34:22',1),(4,'AA/2026/NRT/0003',1,'SMALL CARS',1,'NISSAN',1,'MICRA',1,'12345',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 18:33:00','2026-07-21 18:34:00','test','{\"from_datetime\":\"2026-07-21 18:33:00\",\"to_datetime\":\"2026-07-30 18:34:00\",\"notes\":\"test\"}','Returned','test',1,1,'2026-07-21 18:34:05','2026-07-21 18:34:22',1),(5,'AA/2026/NRT/0004',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 19:13:00','2026-07-22 16:57:00','test','{\"from_datetime\":\"2026-07-21 19:13:00\",\"to_datetime\":null,\"notes\":\"test\"}','Returned','Minor scratches observed on the front bumper.',1,1,'2026-07-21 19:13:40','2026-07-22 16:57:40',1),(6,'AA/2026/NRT/0004',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-21 19:13:00','2026-07-22 16:57:00','test','{\"from_datetime\":\"2026-07-21 19:13:00\",\"to_datetime\":null,\"notes\":\"test\"}','Returned','Minor scratches observed on the front bumper.',1,1,'2026-07-21 19:13:40','2026-07-22 16:57:40',1),(7,'AA/2026/NRT/0005',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745',2,'Manu','{\"staff_id\":\"2\",\"staff_name\":\"Manu\",\"mobile\":\"32423\",\"email\":\"dsfs@wer.rty\",\"licence_no\":\"fdg234\",\"licence_issue_place\":\"dsf\",\"licence_issue_date\":\"23-07-2026\",\"licence_expiry_date\":\"31-07-2026\",\"cpr_no\":\"324535\",\"cpr_expiry\":\"16-07-2026\"}','2026-07-22 16:58:00','2026-07-23 11:12:00','ttt','{\"from_datetime\":\"2026-07-22 16:58:00\",\"to_datetime\":null,\"notes\":\"ttt\"}','Returned','treefd',1,1,'2026-07-22 16:58:47','2026-07-23 11:12:51',1),(8,'AA/2026/NRT/0006',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-23 11:08:00','2026-08-19 17:05:00','test','{\"from_datetime\":\"2026-07-23 11:08:00\",\"to_datetime\":null,\"notes\":\"test\"}','Returned','',1,1,'2026-07-23 11:09:19','2026-08-19 17:05:34',1),(9,'AA/2026/NRT/0007',5,'SUV',1,'NISSAN',50,'X-TRAIL',7,'538745',3,'RUMEL','{\"staff_id\":\"3\",\"staff_name\":\"RUMEL\",\"mobile\":\"37338987\",\"email\":\"\",\"licence_no\":\"761134395\",\"licence_issue_place\":\"BAHRAIN\",\"licence_issue_date\":\"23-07-2026\",\"licence_expiry_date\":\"23-07-2030\",\"cpr_no\":\"761134395\",\"cpr_expiry\":\"15-11-2028\"}','2026-07-23 14:58:00',NULL,'','{\"from_datetime\":\"2026-07-23 14:58:00\",\"to_datetime\":null,\"notes\":\"\"}','Rentout',NULL,1,1,'2026-07-23 14:58:28','2026-07-23 14:58:28',NULL),(10,'AA/2026/NRT/0008',1,'SMALL CARS',1,'NISSAN',1,'MICRA',8,'90909',1,'Test Staff','{\"staff_id\":\"1\",\"staff_name\":\"Test Staff\",\"mobile\":\"2132342311\",\"email\":\"teststaf@gmail.com\",\"licence_no\":\"23432411\",\"licence_issue_place\":\"Bahrain\",\"licence_issue_date\":\"31-07-2026\",\"licence_expiry_date\":\"13-08-2026\",\"cpr_no\":\"23423423411\",\"cpr_expiry\":\"21-07-2026\"}','2026-07-25 12:22:00','2026-07-25 17:29:00','tets on staff use issue','{\"from_datetime\":\"2026-07-25 12:22:00\",\"to_datetime\":null,\"notes\":\"tets on staff use issue\"}','Returned','no comments',1,65,'2026-07-25 12:23:21','2026-07-25 12:24:20',65),(11,'AA/2026/NRT/0009',1,'SMALL CARS',1,'NISSAN',2,'SUNNY',3,'333333',3,'RUMEL','{\"staff_id\":\"3\",\"staff_name\":\"RUMEL\",\"mobile\":\"37338987\",\"email\":\"\",\"licence_no\":\"761134395\",\"licence_issue_place\":\"BAHRAIN\",\"licence_issue_date\":\"23-07-2026\",\"licence_expiry_date\":\"23-07-2030\",\"cpr_no\":\"761134395\",\"cpr_expiry\":\"15-11-2028\"}','2026-08-19 17:05:00',NULL,'','{\"from_datetime\":\"2026-08-19 17:05:00\",\"to_datetime\":null,\"notes\":\"\"}','Rentout',NULL,1,1,'2026-08-19 17:05:49','2026-08-19 17:05:49',NULL);
/*!40000 ALTER TABLE `tbl_vehicle_non_revenue_ticket` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbl_vehicle_pricing_master`
--

LOCK TABLES `tbl_vehicle_pricing_master` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_pricing_master` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_pricing_master` VALUES (1,'Price per hour rental without driver','Active','No'),(2,'Price per hour rental with driver','Active','No'),(3,'Price per day rental without driver','Active','No'),(4,'Price per day rental with driver','Active','No'),(5,'Price per week rental without driver','Active','No'),(6,'Price per week rental with driver','Active','No'),(7,'Price per month rental without driver','Active','No'),(8,'Price per month rental with driver','Active','No');
/*!40000 ALTER TABLE `tbl_vehicle_pricing_master` ENABLE KEYS */;
UNLOCK TABLES;

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
  PRIMARY KEY (`ids`),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_1` CHECK (json_valid(`customer_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_10` CHECK (json_valid(`minprice_otp_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_11` CHECK (json_valid(`log_json`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_12` CHECK (json_valid(`rentout_log_json`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_13` CHECK (json_valid(`return_log_json`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_14` CHECK (json_valid(`vehicle_return_images`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_15` CHECK (json_valid(`close_log_json`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_16` CHECK (json_valid(`close_otp_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_2` CHECK (json_valid(`vechile_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_3` CHECK (json_valid(`contract_details_json`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_4` CHECK (json_valid(`vehicle_accessories_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_5` CHECK (json_valid(`remarks1`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_6` CHECK (json_valid(`remarks2`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_7` CHECK (json_valid(`vehicle_rentout_images`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_8` CHECK (json_valid(`driver_details`)),
  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_9` CHECK (json_valid(`customer_driver_attachments`))
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicle_rentout_contracts`
--

LOCK TABLES `tbl_vehicle_rentout_contracts` WRITE;
/*!40000 ALTER TABLE `tbl_vehicle_rentout_contracts` DISABLE KEYS */;
INSERT INTO `tbl_vehicle_rentout_contracts` VALUES (1,1,1,'AA/2026/AGR/0001','AA/2026/RS/0001','2026-06-20','C0001','ABC','{\"customer_name\":\"ABC\",\"customer_code\":\"C0001\",\"customer_mobile\":\"12121\",\"customer_email\":\"abc@gmail.com\",\"customer_attention\":\"tsse\",\"customer_address\":\"Manama, Kingdom of Bahrain\"}','AA/2026/PM/0001',1,1,1,'12345','{\"vehicle_id\":\"1\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2015\"}','Rental Without Driver','2026-06-01 11:09:00','2026-06-18 11:09:00','{\"period_from\":\"2026-06-01T11:09\",\"period_to\":\"2026-06-18T11:09\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"408\",\"unit_price\":\"6\",\"min_price\":\"5.000\",\"vat\":\"10\",\"total_amt\":\"2692.800\",\"qtn_ref_no\":\"AA\\/2026\\/PM\\/0001\",\"booking_notes\":\"\",\"otp_details\":\"\"}',0.000,1232.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-06-20T11:11\",\"vehicle_km_out\":\"1232\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-06-29 12:18:00',NULL,NULL,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','1',NULL,'uploads/signatures/hirer_1_1781944441.png','ABC','2026-06-20 11:34:01','Yes','46.184.241.136','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_1_1781944441.png','rrrr','2026-06-20 11:34:01','46.184.241.136','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-06-20 11:11:31\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-07-14 15:44:03\"}','abs','uploads/signatures/receiver_1_1782724775.png','2026-06-29 12:19:35','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','88.201.99.22','{\"user_id\":1,\"datetime\":\"2026-06-29 12:19:35\"}','[]',NULL,NULL,NULL,NULL),(2,1,2,'AA/2026/AGR/0002','AA/2026/RS/0002','2026-06-20','C0002','EFG','{\"customer_name\":\"EFG\",\"customer_code\":\"C0002\",\"customer_mobile\":\"34343434\",\"customer_email\":\"efg@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,2,2,'66666','{\"vehicle_id\":\"2\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"66666\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"white\",\"vehicle_year\":\"2016\"}','Rental Without Driver','2026-06-01 11:29:00','2026-06-10 11:29:00','{\"period_from\":\"2026-07-01T11:29\",\"period_to\":\"2026-07-10T11:29\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"9\",\"unit_price\":\"12\",\"min_price\":\"12.000\",\"vat\":\"10\",\"total_amt\":\"118.800\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,22222.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-07-01T11:30\",\"vehicle_km_out\":\"22222\",\"fuel_level\":\"Half\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}',NULL,NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"\"','{\"user_id\":1,\"datetime\":\"2026-06-20 11:30:17\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-06-20 19:50:20\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,1,3,'AA/2026/AGR/0003','AA/2026/RS/0003','2026-06-22','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,2,3,'333333','{\"vehicle_id\":\"3\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"333333\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"white\",\"vehicle_year\":\"2000\"}','Rental With Driver','2026-07-01 11:32:00','2026-07-10 11:33:00','{\"period_from\":\"2026-07-01T11:32\",\"period_to\":\"2026-07-10T11:33\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"10\",\"unit_price\":\"25\",\"min_price\":\"13.000\",\"vat\":\"0\",\"total_amt\":\"250.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',632222.000,20000.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-06-22T11:39\",\"vehicle_km_out\":\"20000\",\"fuel_level\":\"Full\",\"cust_driver_name\":\"test\",\"cust_driver_contact_no\":\"34535\",\"cust_driver_documents\":{\"vehicles\":[{\"documentName\":\"cpr\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a38f500dc7598.89988471.webp\"]}]},\"vehicle_images\":[]}',NULL,NULL,'2026-07-16 11:52:00',NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,1,'{\"driver_id\":\"1\",\"driver_name\":\"Driver1\",\"driver_mobile\":\"21323423\",\"driver_license_no\":\"234324\",\"driver_license_issplace\":\"Bahrain\",\"driver_license_issdate\":\"2026-07-16\",\"driver_license_expdate\":\"2026-07-15\"}','test','34535','{\"vehicles\":[{\"documentName\":\"cpr\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a38f500dc7598.89988471.webp\"]}]}','64',NULL,'uploads/signatures/hirer_3_1782117730.png','Client1','2026-06-22 11:42:10','Yes','37.131.111.39','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_3_1782117730.png','test','2026-06-22 11:42:10','37.131.111.39','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','\"\"','{\"user_id\":64,\"datetime\":\"2026-06-22 11:41:38\"}','Closed','{\"user_id\":64,\"datetime\":\"2026-06-22 11:43:05\"}','rer','uploads/signatures/receiver_3_1782118376.png','2026-06-22 11:52:56','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','37.131.111.39','{\"user_id\":64,\"datetime\":\"2026-06-22 11:52:56\"}','[]','{\"user_id\":64,\"datetime\":\"2026-06-22 11:54:07\"}','{\"message\":\"OTP verification has been successfully completed on 22-06-2026 11:54 for the mobile number 35345345. Agreement No: AA\\/2026\\/AGR\\/0003. Outstanding balance: 430 BHD.\",\"closed_on\":\"2026-06-22 11:54:07\"}',NULL,NULL),(4,1,4,'AA/2026/AGR/0004','AA/2026/RS/0004','2026-06-22','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,1,4,'565656','{\"vehicle_id\":\"4\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"565656\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"white\",\"vehicle_year\":\"2020\"}','Rental Without Driver','2026-07-01 12:19:00','2026-07-10 12:19:00','{\"period_from\":\"2026-07-01T12:19\",\"period_to\":\"2026-07-10T12:19\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"9\",\"unit_price\":\"10\",\"min_price\":\"6.000\",\"vat\":\"10\",\"total_amt\":\"99.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',NULL,232.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-06-24T12:20\",\"vehicle_km_out\":\"232\",\"fuel_level\":\"fiukl\",\"cust_driver_name\":\"trest\",\"cust_driver_contact_no\":\"34\",\"cust_driver_documents\":{\"vehicles\":[{\"documentName\":\"erre\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a38fe72323ca5.81404527.webp\"]}]},\"vehicle_images\":[\"1782120071_3683.jpg\"]}',NULL,NULL,NULL,NULL,NULL,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','[\"1782120071_3683.jpg\"]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','trest','34','{\"vehicles\":[{\"documentName\":\"erre\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a38fe72323ca5.81404527.webp\"]}]}',NULL,NULL,'uploads/signatures/hirer_4_1782120105.png','Client1','2026-06-22 12:21:45','Yes','37.131.111.39','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_4_1782120105.png','werew','2026-06-22 12:21:45','37.131.111.39','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','\"\"','{\"user_id\":64,\"datetime\":\"2026-06-22 12:21:34\"}','Rentout','{\"user_id\":64,\"datetime\":\"2026-06-22 12:22:26\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,1,7,'AA/2026/AGR/0005','AA/2026/RS/0007','2026-06-29','C0005','ruel','{\"customer_name\":\"ruel\",\"customer_code\":\"C0005\",\"customer_mobile\":\"37338987\",\"customer_email\":\"\",\"customer_attention\":\"\",\"customer_address\":\"blk 340 bld 176 rd 4005 mannai plaz ajuffair\"}','',1,2,5,'157763','{\"vehicle_id\":\"5\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"157763\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"WHITE\",\"vehicle_year\":\"2019\"}','Rental Without Driver','2026-06-29 12:11:00','2026-06-30 12:11:00','{\"period_from\":\"2026-06-29T12:11\",\"period_to\":\"2026-06-30T12:11\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"1\",\"unit_price\":\"0\",\"min_price\":\"12.000\",\"vat\":\"10\",\"total_amt\":\"0.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"OTP verification has been successfully completed on 29-06-2026 12:14 for the mobile number 97337338987. The applicable unit price is  BHD.\"}',NULL,0.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"\",\"vehicle_km_out\":\"0\",\"fuel_level\":\"\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}',NULL,NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"OTP verification has been successfully completed on 29-06-2026 12:14 for the mobile number 97337338987. The applicable unit price is  BHD.\"','{\"user_id\":1,\"datetime\":\"2026-06-29 12:14:53\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-07-28 12:38:28\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,1,9,'AA/2026/AGR/0006','AA/2026/RS/0008','2026-07-11','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,2,5,'157763','{\"vehicle_id\":\"5\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"157763\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"WHITE\",\"vehicle_year\":\"2019\"}','Rental Without Driver','2026-07-17 15:12:00','2026-07-27 15:12:00','{\"period_from\":\"2026-07-17T15:12\",\"period_to\":\"2026-07-27T15:12\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"10\",\"unit_price\":\"15\",\"min_price\":\"12.000\",\"vat\":\"10\",\"total_amt\":\"165.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',23.000,122.000,0.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-07-11T15:13\",\"vehicle_km_out\":\"122\",\"fuel_level\":\"123\",\"cust_driver_name\":\"ttt\",\"cust_driver_contact_no\":\"2342\",\"cust_driver_documents\":{\"vehicles\":[{\"documentName\":\"t\",\"files\":[\"uploads\\/custDriverDocs\\/files\\/file_6a5233768ea7f5.96798718.pdf\"]}]},\"vehicle_images\":[\"1783772048_6828.jpg\"]}',NULL,NULL,'2026-08-01 16:34:00',NULL,NULL,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','[\"1783772048_6828.jpg\"]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','ttt','2342','{\"vehicles\":[{\"documentName\":\"t\",\"files\":[\"uploads\\/custDriverDocs\\/files\\/file_6a5233768ea7f5.96798718.pdf\"]}]}','1',NULL,'uploads/signatures/hirer_9_1783772064.png','Client1','2026-07-11 15:14:24','Yes','46.184.243.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_9_1783772064.png','34','2026-07-11 15:14:24','46.184.243.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-07-11 15:14:13\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-11 15:14:56\"}','sdf','uploads/signatures/receiver_9_1785591304.png','2026-08-01 16:35:04','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 16:35:04\"}','[]',NULL,NULL,'[{\"vehicle_id\":\"5\",\"vehicle_number\":\"157763\",\"violation_date\":\"2026-08-01\",\"title\":\"Violation1\",\"fee\":12,\"remarks\":\"tst\"},{\"vehicle_id\":\"5\",\"vehicle_number\":\"157763\",\"violation_date\":\"2026-07-28\",\"title\":\"Violation2\",\"fee\":14,\"remarks\":\"test\"}]',NULL),(7,1,10,'AA/2026/AGR/0007','AA/2026/RS/0009','2026-07-11','C0010','Tanu','{\"customer_name\":\"Tanu\",\"customer_code\":\"C0010\",\"customer_mobile\":\"123123\",\"customer_email\":\"tanu@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,2,6,'157720','{\"vehicle_id\":\"6\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"157720\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"WHITE\",\"vehicle_year\":\"2019\"}','Rental Without Driver','2026-07-05 15:18:00','2026-07-23 15:18:00','{\"period_from\":\"2026-07-05T15:18\",\"period_to\":\"2026-07-23T15:18\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"18\",\"unit_price\":\"13\",\"min_price\":\"12.000\",\"vat\":\"10\",\"total_amt\":\"257.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"tesy\",\"otp_details\":\"\"}',1232.000,12.000,1220.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"No\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-07-11T18:49\",\"vehicle_km_out\":\"12\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-08-01 15:30:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','1',NULL,'uploads/signatures/hirer_10_1783785008.png','Tanu','2026-07-11 18:50:08','Yes','46.184.243.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_10_1783785008.png','234efs','2026-07-11 18:50:08','46.184.243.131','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-07-11 18:49:53\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-11 18:50:16\"}','re','uploads/signatures/receiver_10_1785587446.png','2026-08-01 15:30:46','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 15:30:46\"}','[]',NULL,NULL,'[{\"title\":\"Accident\",\"fee\":10}]',NULL),(8,1,11,'AA/2026/AGR/0008','AA/2026/RS/0010','2026-07-14','C0009','ANZEL SAIT','{\"customer_name\":\"ANZEL SAIT\",\"customer_code\":\"C0009\",\"customer_mobile\":\"33661055\",\"customer_email\":\"anzelabk@gmail.com\",\"customer_attention\":\"BAD CUSTOMER\",\"customer_address\":\"FASTLINK\"}','',5,50,7,'538745','{\"vehicle_id\":\"7\",\"category_id\":\"5\",\"model_id\":\"50\",\"veh_no\":\"538745\",\"category_name\":\"SUV\",\"model_name\":\"NISSAN X-TRAIL\",\"vehicle_color\":\"GOLD AND BLACK\",\"vehicle_year\":\"2016\"}','Rental Without Driver','2026-07-14 14:55:00','2026-07-15 14:56:00','{\"period_from\":\"2026-07-14T14:55\",\"period_to\":\"2026-07-15T14:56\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"2\",\"unit_price\":\"1\",\"min_price\":\"0.000\",\"vat\":\"10\",\"total_amt\":\"2.200\",\"qtn_ref_no\":\"\",\"booking_notes\":\"REMIND ME TOMORROW TO CALL CLIENT\",\"otp_details\":\"\"}',1.000,0.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-07-14T15:46\",\"vehicle_km_out\":\"00\",\"fuel_level\":\"25%\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-07-25 10:55:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','65',NULL,'uploads/signatures/hirer_11_1784033571.png','ANZEL','2026-07-14 15:52:51','Yes','94.76.14.248','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_11_1784033571.png','JONSON','2026-07-14 15:52:51','94.76.14.248','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-07-14 15:46:25\"}','Closed','{\"user_id\":1,\"datetime\":\"2026-07-23 15:55:01\"}','tetst','uploads/signatures/receiver_11_1784966166.png','2026-07-25 10:56:06','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','94.76.14.248','{\"user_id\":65,\"datetime\":\"2026-07-25 10:56:06\"}','[\"1784966121_3034.jpg\"]','{\"user_id\":65,\"datetime\":\"2026-07-25 11:54:31\"}','{\"message\":\"\",\"closed_on\":\"2026-07-25 11:54:31\"}',NULL,NULL),(9,1,12,'AA/2026/AGR/0009','AA/2026/RS/0011','2026-07-23','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,1,1,'12345','{\"vehicle_id\":\"1\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2015\"}','Rental Without Driver','2026-07-23 12:03:00','2026-07-24 12:03:00','{\"period_from\":\"2026-07-23T12:03\",\"period_to\":\"2026-07-24T12:03\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"24\",\"unit_price\":\"6\",\"min_price\":\"5.000\",\"vat\":\"10\",\"total_amt\":\"158.400\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',34.000,0.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"\",\"vehicle_km_out\":\"0\",\"fuel_level\":\"ef\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-07-24 12:13:00',NULL,NULL,'<p>geg</p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','1',NULL,'uploads/signatures/hirer_12_1784797592.png','Client1','2026-07-23 12:06:32','Yes','37.131.106.185','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_12_1784797592.png','hfh','2026-07-23 12:06:32','37.131.106.185','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-07-23 12:05:47\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-23 12:06:40\"}','werfwe','uploads/signatures/receiver_12_1784798010.png','2026-07-23 12:13:30','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','37.131.106.185','{\"user_id\":1,\"datetime\":\"2026-07-23 12:13:30\"}','[]',NULL,NULL,NULL,NULL),(10,1,13,'AA/2026/AGR/0010','AA/2026/RS/0012','2026-07-23','C0005','ruel','{\"customer_name\":\"ruel\",\"customer_code\":\"C0005\",\"customer_mobile\":\"37338987\",\"customer_email\":\"\",\"customer_attention\":\"\",\"customer_address\":\"blk 340 bld 176 rd 4005 mannai plaz ajuffair\"}','',1,1,1,'12345','{\"vehicle_id\":\"1\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2015\"}','Rental Without Driver','2026-07-23 14:34:00','2026-07-25 14:34:00','{\"period_from\":\"2026-07-23T14:34\",\"period_to\":\"2026-07-25T14:34\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"2\",\"unit_price\":\"10\",\"min_price\":\"6.000\",\"vat\":\"10\",\"total_amt\":\"22.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"HI\",\"otp_details\":\"\"}',12.000,2656.000,0.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-07-23T14:42\",\"vehicle_km_out\":\"2656\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-08-01 14:12:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','1',NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"\"','{\"user_id\":1,\"datetime\":\"2026-07-23 14:42:40\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-23 15:54:12\"}','sdf','uploads/signatures/receiver_13_1785582752.png','2026-08-01 14:12:32','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 14:12:32\"}','[]',NULL,NULL,'[{\"title\":\"AccidentVioloation\",\"fee\":10},{\"title\":\"Traffice violation\",\"fee\":12}]',NULL),(11,1,14,'AA/2026/AGR/0011','AA/2026/RS/0013','2026-07-23','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,1,8,'90909','{\"vehicle_id\":\"8\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"90909\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"black\",\"vehicle_year\":\"2015\"}','Rental Without Driver','2026-07-01 15:57:00','2026-07-31 15:58:00','{\"period_from\":\"2026-07-01T15:57\",\"period_to\":\"2026-07-31T15:58\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"721\",\"unit_price\":\"8\",\"min_price\":\"5.000\",\"vat\":\"10\",\"total_amt\":\"6344.800\",\"qtn_ref_no\":\"\",\"booking_notes\":\"tt\",\"otp_details\":\"\"}',222.000,123.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"\",\"vehicle_km_out\":\"123\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-07-25 12:20:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','65',NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"\"','{\"user_id\":1,\"datetime\":\"2026-07-23 15:59:54\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-23 16:00:53\"}','ert','uploads/signatures/receiver_14_1784971250.png','2026-07-25 12:20:50','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','94.76.14.248','{\"user_id\":65,\"datetime\":\"2026-07-25 12:20:50\"}','[]',NULL,NULL,NULL,NULL),(12,1,15,'AA/2026/AGR/0012','AA/2026/RS/0014','2026-07-25','C0009','ANZEL SAIT','{\"customer_name\":\"ANZEL SAIT\",\"customer_code\":\"C0009\",\"customer_mobile\":\"33661055\",\"customer_email\":\"anzelabk@gmail.com\",\"customer_attention\":\"BAD CUSTOMER\",\"customer_address\":\"FASTLINK\"}','',5,50,7,'538745','{\"vehicle_id\":\"7\",\"category_id\":\"5\",\"model_id\":\"50\",\"veh_no\":\"538745\",\"category_name\":\"SUV\",\"model_name\":\"NISSAN X-TRAIL\",\"vehicle_color\":\"GOLD AND BLACK\",\"vehicle_year\":\"2016\"}','Rental Without Driver','2026-08-08 12:01:00','2026-08-20 12:01:00','{\"period_from\":\"2026-08-08T12:01\",\"period_to\":\"2026-08-20T12:01\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"12\",\"unit_price\":\"30\",\"min_price\":\"25.000\",\"vat\":\"10\",\"total_amt\":\"396.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',1500.000,1200.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-08T12:03\",\"vehicle_km_out\":\"1200\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-07-25 12:20:00',NULL,NULL,'<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','65',NULL,'uploads/signatures/hirer_15_1784970240.png','ANZEL SAIT','2026-07-25 12:04:00','Yes','94.76.14.248','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_15_1784970240.png','test','2026-07-25 12:04:00','94.76.14.248','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":65,\"datetime\":\"2026-07-25 12:03:43\"}','Returned','{\"user_id\":65,\"datetime\":\"2026-07-25 12:04:15\"}','ert','uploads/signatures/receiver_15_1784971287.png','2026-07-25 12:21:27','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','94.76.14.248','{\"user_id\":65,\"datetime\":\"2026-07-25 12:21:27\"}','[]',NULL,NULL,NULL,NULL),(13,1,16,'AA/2026/AGR/0014','AA/2026/RS/0015','2026-07-28','C0003','Client1','{\"customer_name\":\"Client1\",\"customer_code\":\"C0003\",\"customer_mobile\":\"112424\",\"customer_email\":\"ancy@gmail.com\",\"customer_attention\":\"tedst\",\"customer_address\":\"tets\"}','',1,4,13,'568568','{\"vehicle_id\":\"13\",\"category_id\":\"1\",\"model_id\":\"4\",\"veh_no\":\"568568\",\"category_name\":\"SMALL CARS\",\"model_name\":\"HONDA CITY\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2024\"}','Rental Without Driver','2026-08-04 18:13:00','2026-08-08 18:13:00','{\"period_from\":\"2026-08-04T18:13\",\"period_to\":\"2026-08-08T18:13\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"4\",\"unit_price\":\"15\",\"min_price\":\"14.000\",\"vat\":\"10\",\"total_amt\":\"66.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',12.000,56.000,0.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-07-30T10:32\",\"vehicle_km_out\":\"56\",\"fuel_level\":\"21\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-08-01 13:59:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}','1',NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"\"','{\"user_id\":1,\"datetime\":\"2026-07-28 11:13:47\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-07-28 10:57:49\"}','rt','uploads/signatures/receiver_16_1785581999.png','2026-08-01 13:59:59','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 13:59:59\"}','[]',NULL,NULL,'[{\"title\":\"test\",\"fee\":12}]',NULL),(15,1,18,'AA/2026/AGR/0016','AA/2026/RS/0017','2026-08-01','C0010','Tanu','{\"customer_name\":\"Tanu\",\"customer_code\":\"C0010\",\"customer_mobile\":\"123123\",\"customer_email\":\"tanu@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,3,14,'55555','{\"vehicle_id\":\"14\",\"category_id\":\"1\",\"model_id\":\"3\",\"veh_no\":\"55555\",\"category_name\":\"SMALL CARS\",\"model_name\":\"CHANGAN ALSVIN\",\"vehicle_color\":\"Black\",\"vehicle_year\":\"2012\"}','Rental Without Driver','2026-08-01 15:18:00','2026-08-02 15:18:00','{\"period_from\":\"2026-08-01T15:18\",\"period_to\":\"2026-08-02T15:18\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"1\",\"unit_price\":\"2\",\"min_price\":\"0.000\",\"vat\":\"10\",\"total_amt\":\"2.200\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',1233.000,123.000,1110.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-01T15:20\",\"vehicle_km_out\":\"123\",\"fuel_level\":\"full\",\"cust_driver_name\":\"test\",\"cust_driver_contact_no\":\"23424\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-08-02 15:21:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','test','23424','{\"vehicles\":[]}','1',NULL,'uploads/signatures/hirer_18_1785586824.png','Tanu','2026-08-01 15:20:24','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_18_1785586824.png','435','2026-08-01 15:20:24','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-08-01 15:20:15\"}','Closed','{\"user_id\":1,\"datetime\":\"2026-08-01 15:20:30\"}','test','uploads/signatures/receiver_18_1785586911.png','2026-08-01 15:21:51','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 15:21:51\"}','[]','{\"user_id\":1,\"datetime\":\"2026-08-01 16:43:24\"}','{\"message\":\"OTP verification has been successfully completed on 01-08-2026 16:43 for the mobile number 32423423. Agreement No: AA\\/2026\\/AGR\\/0016. Outstanding balance: 5.2 BHD.\",\"closed_on\":\"2026-08-01 16:43:24\"}','[{\"title\":\"ttt\",\"fee\":1},{\"title\":\"yyy\",\"fee\":2}]',NULL),(16,1,19,'AA/2026/AGR/0017','AA/2026/RS/0018','2026-08-01','C0010','Tanu','{\"customer_name\":\"Tanu\",\"customer_code\":\"C0010\",\"customer_mobile\":\"123123\",\"customer_email\":\"tanu@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,3,12,'123123','{\"vehicle_id\":\"12\",\"category_id\":\"1\",\"model_id\":\"3\",\"veh_no\":\"123123\",\"category_name\":\"SMALL CARS\",\"model_name\":\"CHANGAN ALSVIN\",\"vehicle_color\":\"Black\",\"vehicle_year\":\"2025\"}','Rental Without Driver','2026-08-05 16:44:00','2026-08-06 16:44:00','{\"period_from\":\"2026-08-05T16:44\",\"period_to\":\"2026-08-06T16:44\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"1\",\"unit_price\":\"12\",\"min_price\":\"0.000\",\"vat\":\"10\",\"total_amt\":\"13.200\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',0.000,123.000,0.000,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-01T16:45\",\"vehicle_km_out\":\"123\",\"fuel_level\":\"full\",\"cust_driver_name\":\"tef\",\"cust_driver_contact_no\":\"123\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,'2026-08-01 16:46:00',NULL,NULL,'<p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','tef','123','{\"vehicles\":[]}','1',NULL,'uploads/signatures/hirer_19_1785591953.png','Tanu','2026-08-01 16:45:53','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_19_1785591953.png','s','2026-08-01 16:45:53','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-08-01 16:45:47\"}','Returned','{\"user_id\":1,\"datetime\":\"2026-08-01 16:46:00\"}','tttt','uploads/signatures/receiver_19_1785592040.png','2026-08-01 16:47:20','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','::1','{\"user_id\":1,\"datetime\":\"2026-08-01 16:47:20\"}','[]',NULL,NULL,'[{\"vehicle_id\":\"12\",\"vehicle_number\":\"123123\",\"violation_date\":\"2026-08-01\",\"title\":\"Violation1\",\"ledger_id\":24,\"fee\":12,\"remarks\":\"test\"},{\"vehicle_id\":\"12\",\"vehicle_number\":\"123123\",\"violation_date\":\"2026-08-02\",\"title\":\"violation2\",\"ledger_id\":25,\"fee\":13,\"remarks\":\"test\"}]',NULL),(17,1,20,'AA/2026/AGR/0018','AA/2026/RS/0019','2026-08-01','C0010','Tanu','{\"customer_name\":\"Tanu\",\"customer_code\":\"C0010\",\"customer_mobile\":\"123123\",\"customer_email\":\"tanu@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,8,'90909','{\"vehicle_id\":\"8\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"90909\",\"category_name\":\"SMALL CARS\",\"model_name\":\"MICRA\",\"vehicle_color\":\"black\",\"vehicle_year\":\"2015\"}','Rental With Driver','2026-08-08 17:00:00','2026-08-09 17:00:00','{\"period_from\":\"2026-08-08T17:00\",\"period_to\":\"2026-08-09T17:00\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"24\",\"unit_price\":\"7\",\"min_price\":\"5.000\",\"vat\":\"0\",\"total_amt\":\"168.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\",\"fuel_out\":\"\",\"fuel_level\":\"\"}',NULL,33333.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-02T17:01\",\"vehicle_km_out\":\"132\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><br></p>',NULL,NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}',NULL,NULL,'uploads/signatures/hirer_20_1785592906.png','Tanu','2026-08-01 17:01:46','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_20_1785592906.png','ewr','2026-08-01 17:01:46','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-08-01 17:01:37\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-08-01 17:01:55\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'[{\"replacement_id\":\"REPL-1785679936-167\",\"replaced_on\":\"2026-08-02 17:12:16\",\"replaced_by_user\":1,\"staff_name\":\"test\",\"staff_signature\":\"data:image\\/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+AAAACWCAYAAABetOI8AAAQAElEQVR4AezdebRVVRkA8H0RQpRBI1M0c54qs9RyqPTpcihzamUuTbPMUtQ0h3DICbKVpqk5LNEGdVlOUZlJy4KVgoWgS1IzQSXSsBZqgoyiLob4jt7Lu4\\/34PGme+49P5fn3H32mb792\\/zzvbPPPr2W+Y8AAQIECBAgQIAAAQIECBDodoFeqab\\/uTkBAgQIECBAgAABAgQIECiGQLET8GL0sVYSIECAAAECBAgQIECAQA4EJOA17AS3Xr3Aj3\\/849Uf5AgCBAgQIECAAAECBAjUgYAEvA46qZtCzP1lBw4cmM4888y02Wab5T5WARIgQIAAAQIECBAgQGB1AhLw1QnZ300Cq7\\/swoULs4NmzJiRXnrppaxsRYAAAQIECBAgQIAAgXoVkIDXa88VIO7DDjus0sorrriiUu6SgosQIECAAAECBAgQIECghwUk4D0M7nbtF7juuusqB48ePbpSboSCNhAgQIAAAQIECBAgUDwBCXjx+rxuWvyBD3ygEuuLL76Yxo0bV9lW6JSAkwkQIECAAAECBAgQqIGABLwG6G7ZMQEJeMfc8neWiAgQIECAAAECBAgUU0ACXsx+r5tWb7LJJpVYr7\\/++jRr1qzKtgKBDgk4iQABAgQIECBAgECNBCTgNYJ32\\/YJlEqlyoGzZ89OI0eOrGwrEKhHATETIECAAAECBAgUV0ACXty+r4uW9+vXryrOmTNnVm3bIEBgjQQcTIAAAQIECBAgUEMBCXgN8d169QKDBw+uOqhlQl610wYBAjkXEB4BAgQIECBAoNgCEvBi93\\/uW98yAZ83b17uYxYgAQI5FRAWAQIECBAgQKDGAhLwGneA269aYMCAAVUHLFq0qGrbBgECBOpFQJwECBAgQIAAAQm4fwO5Fujfv39VfAsXLqzatkGAAAEC7RJwEAECBAgQIJADAQl4DjpBCG0LtHwCvmDBgrYPtocAAQIEciogLAIECBAgQCAEJOChYMmtQMt3wCXgue0qgREgQCC\\/AiIjQIAAAQI5EZCA56QjhNG6QMsEvFcv\\/2Rbl1JLgAABAnkVEBcBAgQIECgLyGbKEn5zKTBw4MCquHr37l21bYMAAQIECBBYpYCdBAgQIJAjAQl4jjpDKCsLlEqlqsqWk7JV7bRBgAABAgQI5ExAOAQIECDQXEAC3lxDOXcCpVJ1Ar7JJpvkLkYBESBAgAABAjkVEBYBAgRyJiABz1mHCKdaoFSqTsA33njj6gNsESBAgAABAgRyKiAsAgQItBSQgLcUsZ0rgalTp1bFs9FGG1Vt2yBAgAABAgQIEGhVQCUBAjkUkIDnsFOEtELgjTfeWLGxvNSvX7\\/la\\/8TIECAAAECBAjkW0B0BAi0JiABb01FXW4ENttss6pYWm5X7bRBgAABAgQIECBAIAQsBHIqIAHPaccI6x2BPn36vFN4d91y+91qPwQIECBAgAABAgRyIyAQAm0JSMDbklFPgAABAgQIECBAgACB+hMQcY4FJOA57hyhpbR06VIMBAgQIECAAAECBAjUjYBAVyUgAV+Vjn01F1hrrbVqHoMACBAgQIAAAQIECBCoE4GchykBz3kHFT28\\/v37VxGss846Vds2CBAgQIAAAQIECBAgkBeB1cUhAV+dkP01Fejbt2\\/V\\/X2GrIrDBgECBAgQIECAAAECdSTQzQl4HUkINZcC66+\\/flVc6623XtW2DQIECBAgQIAAAQIECNSLQGMn4PXSC+JsU2CDDTao7Ovdu3dqmZBXdioQIECAAAECBAgQIEAg5wIS8G7sIJfuWoElS5akUqnUtRd1NQIECBAgQIAAAQIECPSQgAS8h6BrcJuGuOXgwYMr7Vi2bFmlrECAAAECBAgQIECAAIF6E5CA11uP1U28XRNoDEHv06dP5WKvvPJKpaxAgAABAgQIECBAgACBehKQgNdTbxUw1njvO5LwctNnzJhRLq76114CBAgQIECAAAECBAjkTEACnrMOEc7KAhtuuGGlcsGCBZVyngtiI0CAAAECBAgQIECAQEsBCXhLEdu5E3jrrbcqMS1evLhSVmhTwA4CBAgQIECAAAECBHIoIAHPYacIqVpg3rx5lYoBAwZUygp5FRAXAQIECBAgQIAAAQKtCUjAW1NRlyuBl19+uRLP+973vkpZgUCrAioJECBAgAABAgQI5FRAAp7TjhHWOwLz589PzYedDxky5J0d1gRyKiAsAgQIECBAgAABAm0JSMDbklGfC4G5c+dW4ogZ0fv371\\/ZViBAYCUBFQQIECBAgAABAjkWkIDnuHOEllLzb4CXSqUUSTgXAgTyKiAuAgQIECBAgACBVQn0WtVO+wjUWuDf\\/\\/53JYRly5ZVygoECBBYSUAFAQIECBAgQCDnAhLwnHdQ0cObPHlyhaCpqalSViBAgEDeBMRDgAABAgQIEFidgAR8dUL211Rg4sSJlfvvvvvulbICAQIECFQJ2CBAgAABAgTqQEACXgedVOQQH3300Urz99xzz0pZgQABAgTyJCAWAgQIECBAoD0CEvD2KDmmJgILFixI06dPr9x71113rZQV6k9g6dKl6Yknnkg333xzOvDAA1Pfvn1TqVRKJ5xwQho+fHgaN25c\\/TVKxAQI5ENAFAQIECBAoE4EJOB10lFFDHPChAlpyZIlWdO33HLLtMEGG2Rlq\\/oSeOyxx9L555+fPvzhD6edd945DR06NI0ZMya9\\/fbbWUNuueWWNGLEiLTPPvtkS1ZpRYAAgToSECoBAgQIEGivgAS8vVKO63GB+++\\/v3LPeGJa2VCoC4GHHnoofehDH0q77bZbuvzyy9Ozzz5bFfegQYPS1ltvXVUXT8FLpVIaOXJkVb0NAgQIEGhTwA4CBAgQqCMBCXgddVaRQn3zzTfTHXfckTU5nnwfc8wxWdkq\\/wKvvPJK+tznPpf23XffNHXq1ErA22yzTTrppJPSDTfckCZNmpTmzJmTpk2blh5\\/\\/PF0ySWXVI6LwrBhw9KoUaOiaCFAgACBXAsIjgABAgTWREACviZaju0xgdtvvz1L0OKGn\\/nMZ5IJ2EIi\\/8udd96ZPdX+4x\\/\\/mAXbv3\\/\\/9I1vfCP961\\/\\/Ss8\\/\\/3y66aab0qmnnpo9Fc8OWL7aZZddsnfAm49yWLhwYTryyCOz+uWH+J8AAQIECLQuoJYAAQJ1JiABr7MOy1O4MaQ4nmb+97\\/\\/7fKwzj333OyaAwYMSPE0tFQqZdtW+RSIhHm\\/\\/fZLMVIhJs\\/r1atXOvTQQ9PkyZPTT3\\/607TFFlusNvAYpr7ZZptVHRfvhsfn54YPH15Vb4MAAQIECORBQAwECBBYUwEJ+JqKOT4TmDJlStphhx3SaaedlrbaaqvsieaJJ56YvvOd76S5c+dmx3R0NX78+MrT78WLF6cdd9yxo5dyXg8IxNPuD37wg+nPf\\/5zdreBAwemq666Kv3ud79L2267bVbXntXHPvaxdNttt610aHyKbsSIEdmM6eutt16Kp+qR7Me\\/vQsuuCB7qh5D2OPf30UXXZRuvfXW7Do\\/+tGP0qWXXpouu+yydOONN2avNNx3331p3LhxlQngVrqZCgIECBAgUD8CIiVAoA4FJOB12Gl5CDkSmXIcb731VoqZruNJZyRekSRF4vXrX\\/+6fMga\\/cY14oQ+ffqk7373u2ndddeNTUvOBGbNmpWOPfbY7H3v2bNnZ9Gtv\\/766amnnkpnnHFGljBnlWuwampqSjF5W\\/y2dlr8cSeetkeyH6MvfvCDH6STTz45fe9738uetH\\/\\/+99PX\\/\\/619Pxxx+fjZy4+OKLs39DMew9Yj388MOzmdY33XTTFPG3dg91BAgQIECAQHsEHEOAQEcEJOAdUXNO+uc\\/\\/7lKhZhc60tf+lI66qijUkzKtcqDm+2cPn16Gj16dFbz0Y9+NJ1wwglZ2SpfAjfffHPafvvts6fK5cjiCfTMmTPT5ptvXq7q0G8k35GExyz48emyDl1kNSe9+uqr6R\\/\\/+MdqjrKbAAECBAgQyK2AwAjUqYAEvE47rpZhxxDeW265pRJCzG690UYbVbabF+65557s\\/d+rr766eXWb5Z\\/97Gdp2bJlqW\\/fvunoo49OQ4YMafNYO3peIP6wEu9kDx06NL322mtZAPF+99ixY1Mk5dFvWWUXrA4++OAsST7ssMO64GorLhHvp8eT8E9\\/+tMrKpUIECBAgAABAmsg4FACHRWQgHdUrsDnxZPpjTfeuCIQT0Jjhuv4tNSFF16Ydt111xRJTvmARYsWpbPPPjt7l\\/vJJ58sV6\\/0G0PZy4n9hhtumOJJ6EoHqaiZwPXXX58++clPpngnuxxEjHB4+umnU7yTXa7r6t977703TZgwIcXw8njXO4aY77333qm87L\\/\\/\\/in+wPP73\\/8+G74eT89bLg8\\/\\/HCKf1\\/xx50lS5akuOZaa63V1aG6HgECBAgQIECgJwTco44FetVx7EKvkcB73\\/veqsm1YqhwzHa92267ZZNe\\/eUvf0mRrMVkXM1DjCG\\/H\\/\\/4x1N5hvPm+6IcCVQMDS6VSik+PbbTTjtFtaXGAkuXLk3xLvXpp5+e5syZk0UzaNCgNGbMmHTXXXd1+zv6pVIp+wxdTLg2fPjw9POf\\/zzFKIzyEnGceeaZ6ZBDDklNTU2tLvHv6T3veU8WuxUBAgQIECBAgEBnBJzbGQEJeGf0CnzuKaecUtX6mAm7XLH22mun2B+J0c4771yurvxeccUV6Ytf\\/GL6z3\\/+U6mLJ5Px9DwqBg8enH3Cqnfv3rFpqaFAJNxHHHFE9oeVchhHHnlkmjFjRoonz+U6vwQIECBAgAABAgR6RKDObyIBr\\/MOrFX4McFa8wmyrrnmmnTnnXdWhRNPxCdOnJjNTt2vX7+qfb\\/97W9TDGWPocOxIz5ZFcPYoxyfNevOIc1xD8vqBRYsWJCOO+64bLh2+egYBn733XenlqMbyvv9EiBAgAABAgQIEGhkgc62TQLeWcECn\\/\\/Zz3620vq33347HXPMMWnKlCmVuijEsN+Yyfyss86qei889r3++uvZu+EHHnhg9tmoqIv3ckeOHJlimHtsW2ojEK8L7LDDDileL4gISqVSlojHMPBSqRRVFgIECBAgQIAAAQIE1lCgkwn4Gt7N4Q0l8K1vfSv16dOnqk3f\\/OY3q7Zjo1QqZRNoPf7442mXXXaJqqolhqrPnTs3qyuVSmnLLbfMyla1ERg1alSK0QvlVwTijyG\\/+c1v0uGHH16bgNyVAAECBAgQIECAQIMI1HcC3iCdUK\\/N2HzzzdMdd9xRFf4jjzyShg8fXlVX3ogJ2GI262HDhqV40l2ub\\/4bQ5v\\/97\\/\\/Na9S7iGBmDwv+ije8X7jjTeyu8ZnxeL1gC984QvZthUBAgQIECBAgAABAh0XkIB33C45NaV4Fzyelja3GDFiRJaEz58\\/v3l1Vo6ELiZhe+qpp9Iee+yR1TVfzZ49O22zzTbpnHPOaV6t3I0C8XmuM844I+21116p+Wfi4nNy8a5+aqHcCAAADmxJREFUzCDejbd3aQIECBAgQIAAAQKFEZCA129X5ybyb3\\/72yvFEkn4H\\/7wh5XqyxUxgdtf\\/\\/rXLFEvlVZ+p\\/jKK6\\/MhqtHol4+x2\\/XCzz44IMp+uLaa6+tuvi+++6b4sn3QQcdVFVvgwABAgQIECBAgACBjgtIwDtuV\\/AzVzT\\/6KOPTpdccsmKindLv\\/rVr94ttf7Tq1evFO8bxyfIWjvib3\\/7W9pzzz3TL3\\/5y9Z2q+ukwM0335wOOOCANH369KorxR9UHnjggbTJJptU1dsgQIAAAQIECBAgQKBzAhLwzvk5+12BeO87hjC\\/u5n9zJw5M\\/ttaxXnPPPMM5Xd5513XhoyZEhlOwrxLvJXvvKVdO6558bmikWpwwKLFi1KJ510Uho6dGhasmRJ5TqlUinFUPQYfRCz11d2KBAgQIAAAQIECBAg0CUCEvAuYXSREBg\\/fnz8VJZJkyZlT7grFc0KMbw53gUvV8UT9Msuuyx7GvvDH\\/4wbbTRRuVd2W8cG09r49vUWUWNV\\/V6+xj2HxOt\\/eQnP6lqQu\\/evdONN96Yrr766pVmtq860AYBAgQIECBAgAABAh0WkIB3mM6JrQlEIt28PmbUjifdzevGjRuXYlbteBJbrh8+fHhW7NevXzYB28SJE7Nh7euuu25WH6uxY8emnXfeOcXnzGK7wEuHmn7PPfekgw8+OD333HNV54fxXXfdlT0RL5VWfh+\\/6mAbBAgQIECAAAECBAh0WEAC3mE6J7YmUE6km+8bMWJEiqeuse\\/4449P++yzT\\/PdWaJdVbF8Iz5xFsdPnTo1my093hdfXp2mTZuWYlbulk9wY5+ldYEYxn\\/qqaemo446KpW\\/t14+cquttkoPP\\/xwOuKII8pV7fh1CAECBAgQIECAAAECHRGQgHdEzTmrFIjJ1yKBbn5QfN4qEvHbbruteXU688wzs5nQqyqbbWy66aYpvk997733po033jjb8+abb2bvMMeQ6azCapUCF198cTa8vOVBMQph8uTJ2aiClvtyvS04AgQIECBAgAABAnUqIAGv047Lc9jxbfBbb701+0b4quKM4erxzvGqjol9a621Vjr00EPTCy+8kCXsURdLzNYdQ9WjbGlb4I477lhpZ7xnf\\/fdd6dBgwattE\\/FqgXsJUCAAAECBAgQINBRAQl4R+Wct0qBpqamdMopp6QddtghO27AgAHZ7wYbbJBiQrWHHnooxRDzrLKdq5iZOxL2X\\/ziFykmDVu8eHHaf\\/\\/909NPP93OKxTvsNGjR6eXX3650vBwi\\/e9zznnnBSelR0K9SIgTgIECBAgQIAAgToWkIDXceflPfRIwqdMmZIi2Z43b16K732\\/+uqradiwYSn2dTT+Y489NsUT9kgmFy5cmD7\\/+c+neFe8o9dr1POef\\/75dOKJJ1Y176abbsreBa+qtEGg3QIOJECAAAECBAgQ6IyABLwzes5tl0Bnku22bhBJ+GmnnZbtfumll9InPvGJ1PL98mxnAVePPvpoOuSQQ9J2222XZs6cmQmsvfba2SznX\\/7yl7NtKwJ1KSBoAgQIECBAgECdC0jA67wDixz+VVddlS666KLUt2\\/fFE\\/CY4b13XbbLfuWdbwbHk\\/ci+Tz+uuvp7POOivtvvvuKYael9seQ80PP\\/zwdN1116X4zFu53i8BAmsm4GgCBAgQIECAQGcFJOCdFXR+zQRKpVK64IIL0oUXXpj69++fxfHYY4+ls88+O+25555pl112yZLxGP6e7WyA1aJFi9L999+fbrjhhqydMbogPvFWKpXS+9\\/\\/\\/nTNNddUWhmfbttrr73SqFGjUkzE1qdPn8o+BQIE6k5AwAQIECBAgEADCEjAG6ATi9yEePodCfiLL76Yvva1r6UYal32eOKJJ7Ikdcstt0wx63c9JeLxBDs+HxZ\\/TDjooIPS9ttvn0qlUlpnnXWyGeFj+H1MSDd+\\/PgUn3iLNsekdPEbBvF5t+eeey7F\\/phBPpLx2GchQIBAxwScRYAAAQIECHSFgAS8KxRdo+YCgwcPziZmiyR7woQJacSIEWnXXXfNktZZs2al8847L\\/vk1nrrrZc+9alPpY985CNp2223zX4jQT399NPTV7\\/61XTkkUem4447LntyHk+Zr7zyynT55ZenmLxs\\/vz5XdLOmJX8\\/PPPz\\/4oEDPFx\\/vae+yxR4qZ4rfYYoss5qi79NJLszgeeOCBFMl0e24eDtdee2127a233ro9pziGAAEC+RcQIQECBAgQaBABCXiDdKRmvCMQw6xj+Hk8PY7h6GPGjElNTU3v7Fy+njt3bnrkkUfSM888k6ZNm5b9xpDu66+\\/Pt1+++3ZcO34zFk8eY6nzPG5rkiWTz755DRw4MAsOS6VSp36HTJkSJbUn7f8jwIjR47M3teeNGlSWrBgQYon+cvDbPP\\/zTffPO29997ppJNOSpdcckmKT4rFLPNPPvlkinfeX3vttWzm83Bo8yJ2ECBAgMAaCTiYAAECBAh0lYAEvKskXSd3AqVSKe23334pEtT77rsve1f86KOPzhLYSGJjiXekBw0alKvYI6YDDjggS7DjSf7YsWPT3\\/\\/+9yzBfuGFF9K4ceOyJ\\/LDhw\\/PPinW1NSUdtppp1y1QTAECBAg0GUCLkSAAAECDSQgAW+gztSUtgVimHkM6b7zzjtTJLDlJd6RnjNnTpbcxhPk8hJPpCNxj+XBBx\\/MJjeLJ87Nl3gqHkn8mizDhg3LEuu4Tjz9juvH8uyzz1ZiiJj+9Kc\\/pUiw40l+\\/BFhxx13bLtx9hAgQIAAgW4TcGECBAgQ6EoBCXhXarpWwwjE58yamppS0\\/Jln332SWeccUaKhLj5cuONN6ZyIt\\/e3yuuuKJynaFDh2bXb2pqStttt13D2GkIAQIECBDoMgEXIkCAQIMJSMAbrEM1hwABAgQIECBAoGsEXIUAAQJdLSAB72pR1yNAgAABAgQIECDQeQFXIECgAQUk4A3YqZpEgAABAgQIECBAoHMCziZAoDsEJODdoeqaBAgQIECAAAECBAh0XMCZBBpUQALeoB2rWQQIECBAgAABAgQIdEzAWQS6S0AC3l2yrkuAAAECBAgQIECAAIE1F3BGAwtIwBu4czWNAAECBAgQIECAAAECaybg6O4UkIB3p65rEyBAgAABAgQIECBAgED7BRr8SAl4g3ew5hEgQIAAAQIECBAgQIBA+wS6+ygJeHcLuz4BAgQIECBAgAABAgQIEFgusJoEfPkR\\/idAgAABAgQIECBAgAABAgQ6LZDvBLzTzXMBAgQIECBAgAABAgQIECCQDwEJ+Cr6wS4CBAgQIECAAAECBAgQINBVAhLwrpLs+uu4IgECBAgQIECAAAECBAg0kIAEvIE6s2ub4moECBAgQIAAAQIECBAg0JUCEvCu1HStrhNwJQIECBAgQIAAAQIECDSYgAS8wTpUc7pGwFUIECBAgAABAgQIECDQ1QIS8K4WdT0CnRdwBQIECBAgQIAAAQIEGlBAAt6AnapJBDon4GwCBAgQIECAAAECBLpDQALeHaquSYBAxwWcSYAAAQIECBAgQKBBBSTgDdqxmkWAQMcEnEWAAAECBAgQIECguwQk4N0l67oECBBYcwFnECBAgAABAgQINLCABLyBO1fTCBAgsGYCjiZAgAABAgQIEOhOAQl4d+q6NgECBAi0X8CRBAgQIECAAIEGF5CAN3gHax4BAgQItE\\/AUQQIECBAgACB7haQgHe3sOsTIECAAIHVCziCAAECBAgQKICABLwAnayJBAgQIEBg1QL2EiBAgAABAj0hIAHvCWX3IECAAAECBNoWsIcAAQIECBREQAJekI7WTAIECBAgQKB1AbUECBAgQKCnBCTgPSXtPgQIECBAgACBlQXUECBAgECBBCTgBepsTSVAgAABAgQIVAvYIkCAAIGeFJCA96S2exEgQIAAAQIECKwQUCJAgEDBBCTgBetwzSVAgAABAgQIEHhHwJoAAQI9LSAB72lx9yNAgAABAgQIECCQEgMCBAooIAEvYKdrMgECBAgQIECAQNEFtJ8AgVoISMBroe6eBAgQIECAAAECBIosoO0ECiogAS9ox2s2AQIECBAgQIAAgaIKaDeBWglIwGsl774ECBAgQIAAAQIECBRRQJsLLCABL3DnazoBAgQIECBAgAABAkUT0N5aCkjAa6nv3gQIECBAgAABAgQIECiSQMHbKgEv+D8AzSdAgAABAgQIECBAgEBRBGrdTgl4rXvA\\/QkQIECAAAECBAgQIECgCAJJAl6IbtZIAgQIECBAgAABAgQIEKi1QG0T8Fq33v0JECBAgAABAgQIECBAgEAPCRQ6Ae8hY7chQIAAAQIECBAgQIAAAQKGoNfw34BbEyBAgAABAgQIECBAgECBBDwBL1BnVzfVFgECBAgQIECAAAECBAj0pIAEvCe13WuFgBIBAgQIECBAgAABAgQKJiABL1iHa+47AtYECBAgQIAAAQIECBDoaQEJeE+Lux+BlBgQIECAAAECBAgQIFBAAQl4ATtdk4suoP0ECBAgQIAAAQIECNRCQAJeC3X3JFBkAW0nQIAAAQIECBAgUFABCXhBO16zCRRVQLsJECBAgAABAgQI1EpAAl4refclQKCIAtpMgAABAgQIECBQYAEJeIE7X9MJECiagPYSIECAAAECBAjUUkACXkt99yZAgECRBLSVAAECBAgQIFBwAQl4wf8BaD4BAgSKIqCdBAgQIECAAIFaC0jAa90D7k+AAAECRRDQRgIECBAgQIBAkoD7R0CAAAECBBpeQAMJECBAgACBPAhIwPPQC2IgQIAAAQKNLKBtBAgQIECAQCYgAc8YrAgQIECAAIFGFdAuAgQIECCQFwEJeF56QhwECBAgQIBAIwpoEwECBAgQqAhIwCsUCgQIECBAgACBRhPQHgIECBDIk8D\\/AQAA\\/\\/+3L0KeAAAABklEQVQDAK9F99lxyTAcAAAAAElFTkSuQmCC\",\"old_vehicle\":{\"vehicle_id\":1,\"vehicle_number\":\"12345\",\"category_id\":1,\"model_id\":1,\"km_out\":132,\"km_in\":155,\"km_used\":23,\"dt_out\":\"2026-08-02 17:12:16\",\"dt_in\":\"2026-08-02T17:11\",\"fuel_level_in\":\"full\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\"},\"old_return_images\":[\"1785679882_8221.jpg\"],\"violations\":[{\"vehicle_id\":1,\"vehicle_number\":\"12345\",\"violation_date\":\"2026-08-02\",\"title\":\"Violation Fee\",\"ledger_id\":18,\"fee\":12,\"remarks\":\"test\"}]},\"new_vehicle\":{\"vehicle_id\":14,\"vehicle_number\":\"55555\",\"category_id\":1,\"model_id\":3,\"km_out\":100,\"fuel_level_out\":\"full\",\"dt_out\":\"2026-08-02T17:11\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"No\",\"chk_radio\":\"No\"},\"new_rentout_images\":[]},\"remarks\":\"test\"},{\"replacement_id\":\"REPL-1785681183-170\",\"replaced_on\":\"2026-08-02 17:33:03\",\"replaced_by_user\":1,\"staff_name\":\"test\",\"staff_signature\":\"data:image\\/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+AAAACWCAYAAABetOI8AAAQAElEQVR4AezdCbRV4\\/\\/H8e\\/OkF9IrZXMCkUiZY6iGzIvU2QKqYgMt6gk0r0rIYrLUpKii4yZpxS6SiSxZB6uTMvUrFKGcn8+j851zrnTqXvu3dPbWvuec\\/Y+Z+\\/neT2t\\/\\/\\/32c+w65TwHwIIIIAAAggggAACCCCAAAII1LhAHfP1Py6OAAIIIIAAAggggAACCCCAQDwE4h3A49HG1BIBBBBAAAEEEEAAAQQQQCAAAgRwHxuBSyOAAAIIIIAAAggggAACCMRHgAAen7ZOrymfEUAAAQQQQAABBBBAAAEEalGAAF6L2FwqWYD3CCCAAAIIIIAAAggggEC8BAjg8WpvapsQ4BUBBBBAAAEEEEAAAQQQqGUBAngtg3M5BCTAhgACCCCAAAIIIIAAAvETIIDHr82pMQIIIIAAAggggAACCCCAgA8CBHAf0LkkAvEWoPYIIIAAAggggAACCMRTgAAez3an1gjEV4CaI4AAAggggAACCCDgkwAB3Cd4LosAAvEUoNYIIIAAAggggAAC8RUggMe37ak5AgjET4AaI4AAAggggAACCPgoQAD3EZ9LI4AAAvESoLYIIIAAAggggEC8BQjg8W5\\/ao8AAgjER4CaIoAAAggggAACPgsQwH1uAC6PAAIIIBAPAWqJAAIIIIAAAggQwPk3gAACCCCAQPQFqCECCCCAAAIIBECAAB6ARqAICCCAAAIIRFuA2iGAAAIIIICABAjgUmBDAAEEEEAAgegKUDMEEEAAAQQCIkAAD0hDUAwEEEAAAQQQiKYAtUIAAQQQQCAhQABPSPCKAAIIIIAAAghET4AaIYAAAggESIAAHqDGoCgIIIAAAggggEC0BKgNAggggECyAAE8WYP3CCCAAAIIIIAAAtERoCYIIIBAwAQI4AFrEIqDAAIIIIAAAgggEA0BaoEAAgikCxDA00X4jAACCCCAAAIIIIBA+AWoAQIIBFCAAB7ARqFICCCAAAIIIIAAAgiEW4DSI4BAeQIE8PJU2IcAAggggAACCCCAAALhFaDkCARUgAAe0IahWAgggAACCCCAAAIIIBBOAUqNQEUCBPCKZNiPAAIIIIAAAggggAACCIRPgBIHWIAAHuDGoWgIIIAAAggggAACCCCAQLgEKG1lAgTwynQ4hgACCCCAAAIIIIAAAgggEB6BgJeUAB7wBqJ4CCCAAAIIIIAAAggggAAC4RCoqpQE8KqEOI4AAggggAACCCCAAAIIIIBAFgRqOIBnoYScAgEEEEAAAQQQQAABBBBAAIEICEQ7gEeggagCAggggAACCCCAAAIIIIBANAQI4DXYjpwaAQQQQAABBBBAAAEEEEAAgYQAATwhEb1XaoQAAggggAACCCCAAAIIIBAgAQJ4gBojWkWhNggggAACCCCAAAIIIIAAAskCBPBkDd5HR4CaIIAAAggggAACCCCAAAIBEyCAB6xBKE40BKgFAggggAACCCCAAAIIIJAuQABPF+EzAuEXoAYIIIAAAggggAACCCAQQAECeAAbhSIhEG4BSo8AAggggAACCCCAAALlCRDAy1NhHwIIhFeAkiOAAAIIIIAAAgggEFABAnhAG4ZiIYBAOAUoNQIIIIAAAggggAACFQkQwCuSYT8CCCAQPgFKjAACCCCAAAIIIBBgAQJ4gBuHoiGAAALhEqC0CCCAAAIIIIAAApUJEMAr0+EYAggggEB4BCgpAggggAACCCAQcAECeMAbiOIhgAACCIRDgFIigAACCCCAAAJVCRDAqxLiOAIIIIAAAsEXoIQIIIAAAgggEAIBAngIGokiIoAAAgggEGwBSocAAggggAACmQgQwDNR4jsIIIAAAgggEFwBSoYAAggggEBIBAjgIWkoiokAAggggAACwRSgVAgggAACCGQqQADPVIrvIYAAAggggAACwROgRAgggAACIRIggIeosSgqAggggAACCCAQLAFKgwACCCCwLgIE8HXR4rsIIIAAAggggAACwRGgJAgggEDIBAjgIWswiosAAggggAACCCAQDAFKgQACCKyrAAF8XcX4PgIIIIAAAggggAAC\\/gtQAgQQCKEAATyEjUaREUAAAQQQQAABBBDwV4CrI4DA+ggQwNdHjd8ggAACCCCAAAIIIICAfwJcGYGQChDAQ9pwFBsBBBBAAAEEEEAAAQT8EeCqCKyvAAF8feX4HQIIIIAAAggggAACCCBQ+wJcMcQCBPAQNx5FRwABBBBAAAEEEEAAAQRqV4CrVUeAAF4dPX6LAAIIIIAAAggggAACCCBQewIhvxIBPOQNSPERQAABBBBAAAEEEEAAAQRqR6C6VyGAV1eQ3yOAAAIIIIAAAggggAACCCCQgUA1A3gGV+ArCCCAAAIIIIAAAggggAACCCBg4Q7gNCACCCCAAAIIIIAAAggggAACIREggFejofgpAggggAACCCCAAAIIIIAAApkKEMAzlQre9ygRAggggAACCCCAAAIIIIBAiAQI4CFqrGAVldIggAACCCCAAAIIIIAAAgisiwABfF20+G5wBCgJAggggAACCCCAAAIIIBAyAQJ4yBqM4gZDgFIggMC\\/Ah988IHl5eVZx44dbeLEiVZcXPzvAf4igAACCCCAAAIIlBEggJchYQcCgReggAj4KrBw4ULr1auXtWnTxlq3bm35+flWVFRkXbt2tebNm9v2229vF110kZWUlPhaTi6OAAIIIIAAAggETYAAHrQWoTwIBF6AAsZVYOnSpdavXz9r0qSJjR071ubOnVsuxQ8\\/\\/GB33323DRs2rNzj7EQAAQQQQAABBOIqQACPa8tTbwTCKkC5fRF4+OGHrUWLFjZy5EhbuXJlRmXIy8uz2267LaPv8iUEEEAAAQQQQCAOAgTwOLQydUQAgawJxPFEjz76qJ111ln2yy+\\/lKm+esMvvPBCGzJkiJ100kkpx9esWWNXXHGFDR8+3FasWJFyjA8IIIAAAggggEAcBQjgcWx16owAAmEVqPVyf\\/3113bBBReUuW6bNm3sxhtvtHnz5rnh5urtfuqpp9yCbJ7npXx\\/4MCB1r59e5s+fXrKfj4ggAACCCCAAAJxEyCAx63FqS8CCCCQocAff\\/zhFltbvnz52l+Ybbzxxm5u99tvv20K1nXqpP6\\/EfWEa4G20h+sfaP54ocffriNGzdu7R5eEEAAAQQQQACB+Amk\\/i+n+NWfGiOAAAIIVCAwdOhQmzp1aulRz\\/NMvdyDBg1yQbz0QNqb0aNH25gxY2yTTTZJObJ69Wrr3bu3Pffccyn7M\\/7AFxFAAAEEEEAAgZALEMBD3oAUHwEEEKgpgRkzZqScWo8WO+aYY1L2lffB8zzXcz5t2jTbe++9U77y119\\/ufnkGrqeciAEHygiAggggAACCCBQXQECeHUF+T0CCCAQQQENMU+es924cWMbPHiweV7q\\/O7Kqt62bVtTCD\\/22GNTvqYF2RTktUhbygE+VCbAMQQQQAABBBCIgAABPAKNSBUQQACBbAvMnj075ZQajr7NNtuk7MvkwxZbbGFPP\\/20nXDCCSlf\\/+KLL0yrppe3snrKF\\/mQkcC3335rd9xxh3Xp0sXq1avnbpQ0atTIdBNEC+Rp07Pbi4qKrKCgIKNzpn6JTwgggAACCCCQDQECeDYUOQcCCCAQMYEnn3wypUZ61FjKjnX4sNFGG5keZaYwnvyz559\\/3lq1asXq6MkoGb7XAnlvvPGGWwhPoxOaNm1qubm59vjjj9uqVavcWRYtWmQayZCfn2\\/atDhex44drW\\/fvta8eXP3ndD8oaAIIIAAAghERIAAHpGGpBoIIIBATQnk5ORU+9RakG3kyJGWvmr6ggULrEOHDnbvvfdW+xpxOIFGDAwYMMAF6EMOOcQ9Y12G61p3PV5uXX8T5+9TdwQQQAABBLIlQADPliTnQQABBCIqoGHL2ahajx497MUXX7SGDRuWOZ2OHX300TZ\\/\\/vwyx9hhNmfOHLewXbNmzeyWW26x77\\/\\/PmOWLbfc0rp162Z6RFynTp2sQYMG9sQTT2T8e77ouwAFQAABBBCIkAABPEKNSVUQQACBbAmoVzpb50o+z1FHHWUffvihtWvXLnm3e\\/\\/yyy9by5Yt7fXXX3ef4\\/pHYXvEiBF28cUXW\\/v27d187v333980h1sL2FXl4nme7bPPPnbmmWfaRx995G5q3HfffZaXl2dTpkyxJUuW2IknnljVaTiOwFoBXhBAAAEEsilAAM+mJudCAAEEIiJwzjnnpNTkq6++SvlcnQ\\/bbbedvfTSS9a7d28XLpPPpXnLhx12mOvlTcxlTj4etffLli1z87O1KrzmcnueZwrb\\/fv3tzFjxtjMmTOrrPLGG29smts9aNAgmzRpkulRb++++6499NBDtscee1T5e76AQKAFKBwCCCAQMQECeMQalOoggAAC2RDYZZddUoaKZ7tXevPNN7dRo0bZrbfeaptttllKkf\\/++2\\/TPGf1\\/r7\\/\\/vspx8L+4ccff3R1Pvnkk52vFqZTz\\/TkyZOtqrncCtpqFwXtwsJC94i3pUuXmhZke+2112zYsGHWuXNn22CDDcLORPkRCIwABUEAAQSyLUAAz7Yo50MAAQQiIqBwnKiKAnPifTZf+\\/TpY++8847tvffeZU773nvvuf3XXXed\\/fTTT2WOh2HH3Llz3arjGlGgsK3e\\/yuvvNI9mk3huaI61K9f3w0\\/79q1qwvs06dPNw0\\/Ly4udkH73HPPtZycHNM5KzoH+xFAIPQCVAABBCIoQACPYKNSJQQQQCAbAlq4q2nTpu5UXbp0MfXUug9Z\\/tOiRQv3KDL17NatW7fM2YcOHWq77rqrC6LqHS\\/zhQDteP\\/99003DDTHesMNN7Q2bdpYQUGBPfjgg6bh5hUVdeedd7bksK2h+DNmzLAHHnjABXiteK7HuVX0e\\/YjgAAC2RfgjAggUBMCBPCaUOWcCCCAQEQEbr755tJ5xPn5+bbnnnuawqCGiN9xxx32ySefZKWmGoauIdSau6w54OknVe+veo7PPvts++6779IP+\\/L5zz\\/\\/dMG6e\\/fu1qpVKzefXT35umHw7LPP2po1a8qUa6eddjLVr2\\/fvnb\\/\\/ffbrFmz7PfffzfNsU8O2wrvxn8IIIBAnAWoOwIRFSCAR7RhqRYCCCCQDYHTTjvNraStR1htu+229vHHH9sbb7zhFknLzc114dzzPNt9993domGvvvqqrV69er0vrUXDdI5XXnnF9ttvP0sPoo888og1adLETjrpJJs9e\\/Z6X2ddf6gbABMnTrTzzjvP9Lg09Virt15Dy7XCuFYbTz6ngrZGDfTr18+mTp1qb731lpWUlNi8efNM9dPwfv32wAMPNJ0n+be8RwABBBDwX4ASIFBTAgTwmpLlvAgggECEBDT8vKCgwLRat0JjejD+7LPP3GOzjjjiCNNQ6d12283NYdZK5+pFf+GFF2xdho8ffvjhbm74k08+6cJ9OuUzzzxjbdu2tQsvvNC+\\/fbbVRGBKAAAEABJREFU9MPr\\/VkLmukGg4aRq7ddc7Y9zzPNgdcQcfVa63FpX3\\/9dco1VN\\/zzz\\/fRo8ebZrbraD96KOPuhsVMlFZU37ABwQQQAABBCoW4EiEBQjgEW5cqoYAAghkU0C94S+++GLpsOm3337bnnjiCfc4sR122CHlUl988YV7hNZdd91lV111lR1\\/\\/PFudW7P89xQbc\\/777VOnTr2v\\/\\/9z7TC99Zbb2377ruvKeRr3rd6lzt16mSHHnqoO558EfUo33PPPda0aVM74IAD7Nprr12n4enqqddjvm677TbTnO1NNtnEtGmIvYaR6zFeWrU8+Zp6rxsMBx98sF1xxRU2YcIEt0CcbkDce++97iYEC6NJiQ0BBBBAILwClLwmBQjgNanLuRFAAIGICuhRVwq9p5xyinucmOZlz58\\/3+688047\\/fTTbZ999nFBO5PqK0hrHrR6jX\\/55RfT6ucaXv7ll1\\/aU089ZZprrlXANU+6ovNpJXXNIdfwdPXOK8hvueWWpk2LvCnAq6wK9Rour+H0Ctt61JmCtOZsq\\/c7+fz6bYcOHVx9rr\\/+envppZdMPd+a+63gPnLkSDckXddK\\/h3vEUAAAQQQQKAaAhH\\/KQE84g1M9RBAAIHaElBgveSSS0zztLWYmhYhU5ieNm2aC9GaR17e1q1bN9O8aoVd9X5Xt7y6roL8woULTdvnn39uWlFcYV6hXr3VeqyZvqdraWE5ze1W2RSyFeZ1TDcUioqKXH2uueYaV0b1tus3bNEQ0I0fjXTQ2gOaRqARHtGoGbVAAAEEEFhfgZr+HQG8poU5PwIIIBBTAc\\/zTKuC5+Tk2GWXXWZ5eXnlbhpmruCrsDtnzhy3WJkCsOZiK7xrQTYNCVdATt\\/69OnjHlFWnYXMtIDam2++aZqnPmnSJDesfty4cfbpp5\\/GtOWiV+2ff\\/7ZNNVAIx48z3OjMzzPc1MfNNdfq\\/lr2kR5Uw6ip0GNEEAAAQT8FKgigPtZNK6NAAIIIBBXAc0Lb9eunSm8a0E2ze\\/OKyfAK1Sph1s9mQrMY8eONS2gduSRR5p61LVaeYMGDapkVM+4wv\\/48ePtpptusl69elnLli1Lg5rnedaxY0f3CLELLrjAzf\\/WMPQqTxyBLyiYPvbYY271dnkPHDjQtOCc5sr37NnThg8fbldffbVpv1Z97\\/PPTRE9Mk4L8PXo0cMN09cIAwXdU0891Tp37uzm3GvUg9pJj2VL2GpfmzZtnPumm25q9evXd9MIGjdubDvuuKM1b97c3XDRNAJ9b\\/\\/993frBagsmmaga95www2mTdMGVK62bdvaNtts49ps0aJF7t+F\\/m1olX01j9Yf0Otee+1lzZo101s2BBBAAAEEakwg2AG8xqrNiRFAAAEEoibQokULUzjOz883rVSuHnXNG1+yZIn99ttvblG4wsJCUy+6gppCWMOGDTNm0PnUI6\\/ecQXR5N5UPXZMi69pwTjNgdeNAA3F13D3jC+Q5S9qTrvmtj\\/88MNuGL3mumshvRNOOMEUWDWP3\\/P+6w32PM+tYO95qfs0NFt10mruOocCtxaf0wgF3bBQ8NZNC+3XvPjbb7\\/d9Jg1LcCnhem0crw2DfXWon1a2V7lUhvpEW0yTdhq39y5c53EypUrbfny5W4awYIFC+z777+34uJi080Suep7ummi9QJUFk0z0DU1XUDb4MGD3aPxFNxV3l9\\/\\/dWNatC1tGmqga69atUqdz31fnueZyrriBEj7JtvvnH7+YMAAggggEA2BQjglWhyCAEEEEAgGgL16tUzrVx+7rnnumHwo0aNMoWwxYsX27Jly9x7hUb1mB511FHuEWdapC3T2ius6TwaLq\\/eYvWgn3nmme4Rap73b6BV766Crx6dpl569eqrx7hv376m4KpgquH4WshOC88p0KoXV8Pv9Si3W265xT3mTCu\\/F\\/5zI0HX0dB+9Tirx1c9ya1btzaVX+Fa5dfq7meddZapLLppoCH2zz33nCmwlvdYOK0Mn15nzcvXzQpt6vnWDQyFepVXAVZD9\\/Py8tyNDR1bn02\\/V7l0vvRNZdVCfeuz6eaLnNQDr9709LopvCf2ab2AnJwc03f79+9vuqmi1fgV6h944AHTDQTNEVfbaK0DLUKoGwOJ3\\/OKAAIIIIBAJgIE8EyU\\/PkOV0UAAQQQqAWBzTff3A1LVhBWkJ08ebK99dZbpp5R9cJqfrhCoYJmcrjUo9UUSpO3Ro0aVVhi9e4qTCpAK1Rr1XYF74KCAlMQ19Ds7t27u\\/nyubm5pp5l9eIqrOtRbgMGDDAFPwX4bt26udXZFdbV46weX5Xxgw8+sClTplgiXGv4faJ8uimQXP5EgNbvkjf1LCeHXfUy62aFNvVoKyyfccYZdvLJJ1vOP4H12GOPdeFb+9d3U7nkqfOlb5qKUCFqNQ5oRXu5VnYKBXSNltCNGw2hP+6440xtM3r0aFMPuobGV\\/Z7jiGAAAIIIJAuQABPF+HzWgFeEEAAAQQ0P\\/iggw4qDZrJAVM9tgqlyZt6RJPDa\\/J7PUrt9ddft0SgV+jV4nP5+fkuwCqEJjYN+U4E5\\/Je08O0fqde6URZVqxY4RazUw9wYt+YMWMsufyJAJ0eeDUXOg4trzUDslHPCRMmZOM0nAMBBBBAICYCBPCYNHToqkmBEUAAgYgJaPi5FgpLBHoFXw1LVw93cjDWe80fLyoqsqIKtvQwnZeXZ+qVToR1LWAWMb6sV0fz9XNyctx5t912W9OCcbqRoW3QoEFunvyGG27ojlf2R6MRKjvOMQQQQAABBJIFCODJGrxHYK0ALwgggAAC0RbYaKONTKMQvvnmG\\/vhhx9Mi+vpRoY2TQ\\/QsVmzZrkV1bVKe+LmRrqKpg+k7+MzAggggAACFQkQwCuSYT8C\\/glwZQQQQACBWhJo0qRJuVfSQnZagE4L87322muWGI2gR6cl\\/0CrpmuV\\/eR9vEcAAQQQQKAiAQJ4RTLsRyC2AlQcAQQQQKAiAQXypk2blh7WvH8tyFa6gzcIIIAAAghUIkAArwSHQwgg4IMAl0QAAQQCLDB\\/\\/nzTsPUAF5GiIYAAAggEWIAAHuDGoWgIIFD7AlwRAQQQqExAj2JLP67h6en7svFZvevvvvuu6TUb5+McCCCAAAL+CxDA\\/W8DSoAAAggkBHhFAIGAC9StW7dMCfUouf3228+0yv0uu+xizZs3N73Wq1fPtthiC9MCbu3bt7euXbuaVk3v3r27jR071m1a9E3v9arz9OzZ07Tom+d51rhxY9N599hjD9Nv+vfvbz\\/\\/\\/HOZ67MDAQQQQCA8AgTw8LQVJUUAAQRqWIDTI4BAVQLt2rUr9yvqqZ4xY4bNmzfPiouL3euqVats2bJlNn36dJs5c6ZNnDjRCgsL7b777rNevXq5TaFb7\\/WqED5+\\/Hi34FvyRdQDrt+MGDHC9tprLyspKUk+zHsEEEAAgRAJEMBD1FgUFQEEEIi0AJVDIAQCAwYMcI8vy8nJ8aW0ixYtcqHel4tzUQQQQACBagsQwKtNyAkQQAABBKIgQB0QyFRA4XvatGk2ZMgQa9asWaY\\/S\\/mefqfHnGln4nWrrbbSRzvwwAPduS+99FLzPM\\/tS\\/y56KKL3LD2xGdeEUAAAQTCJUAAD1d7UVoEEEAAgWgKUKsQCmjI+JdffmmPPfaYC8wK5FdeeaXddNNNpZ+1L7ENHTrUpkyZ4lZR1+\\/mzJljGk6eeNX8bn2eNWuW9e7d2yZMmOCOJ2hyc3Nt1KhRiY+8IoAAAgiEUIAAHsJGo8gIIIAAAghkV4CzVUfgtNNOM4VxbZqnfdVVV5V+1r7Edu2111qnTp2sSZMmVV7uwQcftBUrVpR+Tz3fI0eOLP3MGwQQQACBcAoQwMPZbpQaAQQQQACB6AhQkzICn332Wem+1q1b25133mkbbLBB6T7eIIAAAgiEU4AAHs52o9QIIIAAAgggkCWBIJ5Gq6onyvXxxx8TvhMYvCKAAAIhFyCAh7wBKT4CCCCAAAIIhFqgTOH1WLL33nuvdP+ee+5Z+p43CCCAAALhFiCAh7v9KD0CCCCAAAIIRERg5cqV1rFjRxs7dmxpjRo2bGg9evQo\\/Zz9N5wRAQQQQKA2BQjgtanNtRBAAAEEEEAAgQoEtJp6UVFRylE9muzss89O2RepD1QGAQQQiJkAATxmDU51EUAAAQQQQCCYAno0WXrJtBibnhnes2dP69atmx1zzDF25JFHWqtWraxly5amFdhPP\\/10GzhwoF1yySWm1dL79etnehTamDFjbPDgwabHmhn\\/lSvATgQQQKC2BQjgtS3O9RBAAAEEEEAAgXIEunTpYvXr1y9zZPHixTZ+\\/HgrLCy0yZMn29SpU+2jjz6yTz\\/91CZNmuSeQz58+HAbPXq03X333abHlV199dV28cUX2\\/XXX28HHXSQzZw5s8x52eG7AAVAAIEYChDAY9joVBkBBBBAAAEEgiegx4399NNPVlBQYDvttFNWCzh79uysno+TRUGAOiCAgB8CBHA\\/1LkmAggggAACCCBQjkC9evUsNzfXtAq6hpbXqVP9\\/6mmXvWjjz66nKuxCwEfBbg0AjEVqP7\\/VY8pHNVGAAEEEEAAAQRqSqBBgwb2yCOPWHFxsd1www02ZMiQlO3yyy93q6N36NDBGjVqlFKMzTbbzDp37mzDhg2zV1991ebPn2+77757ynf4gEDcBag\\/An4JEMD9kue6CCCAAAIIIIBAFQIaiq753Hl5eZaXtN1+++02btw4KyoqsgULFlhJSUnptnz5cjc3fNCgQXbYYYdZ3bp1q7gKhxFAoJYFuFyMBQjgMW58qo4AAggggAACCCCAAAJxE6C+fgoQwP3U59oIIIAAAggggAACCCCAQJwEYl5XAnjM\\/wFQfQQQQAABBBBAAAEEEEAgLgJ+15MA7ncLcH0EEEAAAQQQQAABBBBAAIE4CBgBPBbNTCURQAABBBBAAAEEEEAAAQT8FvA3gPtde66PAAIIIIAAAggggAACCCCAQC0JxDqA15Ixl0EAAQQQQAABBBBAAAEEEECAIeg+\\/hvg0ggggAACCCCAAAIIIIAAAjESoAc8Ro2dWlU+IYAAAggggAACCCCAAAII1KYAAbw2tbnWfwK8QwABBBBAAAEEEEAAAQRiJkAAj1mDU91\\/BfiLAAIIIIAAAggggAACCNS2AAG8tsW5HgJmGCCAAAIIIIAAAggggEAMBQjgMWx0qhx3AeqPAAIIIIAAAggggAACfggQwP1Q55oIxFmAuiOAAAIIIIAAAgggEFMBAnhMG55qIxBXAeqNAAIIIIAAAggggIBfAgRwv+S5LgIIxFGAOiOAAAIIIIAAAgjEWIAAHuPGp+oIIBA3AeqLAAIIIIAAAggg4KcAAdxPfa6NAAIIxEmAuiKAAAIIIIAAAjEXIIDH\\/B8A1UcAAQTiIkA9EUAAAQQQQAABvwUI4H63ANdHAAEEEIiDAHVEAAEEEEAAAQSMAM4\\/AiFV5yUAAACASURBVAQQQAABBCIvQAURQAABBBBAIAgCBPAgtAJlQAABBBBAIMoC1A0BBBBAAAEEnAAB3DHwBwEEEEAAAQSiKkC9EEAAAQQQCIoAATwoLUE5EEAAAQQQQCCKAtQJAQQQQACBUgECeCkFbxBAAAEEEEAAgagJUB8EEEAAgSAJ\\/B8AAP\\/\\/QUbJ7wAAAAZJREFUAwANed0Gwt3+CwAAAABJRU5ErkJggg==\",\"old_vehicle\":{\"vehicle_id\":14,\"vehicle_number\":\"55555\",\"category_id\":1,\"model_id\":3,\"category_name\":\"\",\"model_name\":\"\",\"km_out\":100,\"km_in\":200,\"km_used\":100,\"dt_out\":\"2026-08-02 17:33:03\",\"dt_in\":\"2026-08-02T17:29\",\"fuel_level_out\":\"full\",\"fuel_level_in\":\"full\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\"},\"old_return_images\":[\"1785681075_9771.jpg\"],\"violations\":[{\"vehicle_id\":14,\"vehicle_number\":\"55555\",\"violation_date\":\"2026-08-02\",\"title\":\"Violation1\",\"ledger_id\":24,\"fee\":1,\"remarks\":\"test\"}]},\"new_vehicle\":{\"vehicle_id\":13,\"vehicle_number\":\"568568\",\"category_id\":1,\"model_id\":4,\"category_name\":\"SMALL CARS\",\"model_name\":\"CITY\",\"km_out\":123,\"fuel_level_out\":\"half\",\"dt_out\":\"2026-08-02T17:31\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\"},\"new_rentout_images\":[]},\"remarks\":\"test\"},{\"replacement_id\":\"REPL-1785682356-449\",\"replaced_on\":\"2026-08-02 17:52:36\",\"replaced_by_user\":1,\"staff_name\":\"test\",\"staff_signature\":\"data:image\\/png;base64,iVBORw0KGgoAAAANSUhEUgAAA+AAAACWCAYAAABetOI8AAAQAElEQVR4AezdebRVVf0A8O+FUENN06ylqeA8lJqimDg9p5atZJmZmkMK5pCklTmiKA9wtsycckIghxKoZRgmtBBYmEziMhBKpRQVoQEyVoKUwM998t2fj+k9Hu++O5zPW+\\/ee86+5+y9v5\\/9\\/vm+fc4+7Vb4IUCAAAECBAgQIECAAAECBEou0C7K+qNxAgQIECBAgAABAgQIECCQD4F8J+D5GGNREiBAgAABAgQIECBAgEAFCEjAyzgImiZAgAABAgQIECBAgACB\\/AhIwPMz1itHap8AAQIECBAgQIAAAQIE2lBAAt6G2Jr6qIBtAgQIECBAgAABAgQI5EtAAp6v8RZtg4BPAgQIECBAgAABAgQItLGABLyNwTVHIAl4ESBAgAABAgQIECCQPwEJeP7GXMQECBAgQIAAAQIECBAgUAYBCXgZ0DVJIN8CoidAgAABAgQIECCQTwEJeD7HXdQE8isgcgIECBAgQIAAAQJlEpCAlwleswQI5FNA1AQIECBAgAABAvkVkIDnd+xFToBA\\/gRETIAAAQIECBAgUEYBCXgZ8TVNgACBfAmIlgABAgQIECCQbwEJeL7HX\\/QECBDIj4BICRAgQIAAAQJlFpCAl3kANE+AAAEC+RAQJQECBAgQIEBAAu5vgAABAgQI1L6ACAkQIECAAIEKEJCAV8Ag6AIBAgQIEKhtAdERIECAAAECSUACnhS8CBAgQIAAgdoVEBkBAgQIEKgQAQl4hQyEbhAgQIAAAQK1KSAqAgQIECDQICABb5DwSYAAAQIECBCoPQERESBAgEAFCUjAK2gwdIUAAQIECBAgUFsCoiFAgACBjwpIwD+qYZsAAQIECBAgQKB2BERCgACBChOQgFfYgOgOAQIECBAgQIBAbQiIggABAisLSMBXFrFPgAABAgQIECBAoPoFRECAQAUKSMArcFB0qbQCr776avzoRz+Kq666Ks4666zo2rVrFAqF4mvrrbeOurq6qK+vj4ceeij69u0bP\\/jBD+Lss8+O73\\/\\/+9m577\\/\\/fvghQIAAAQIECBBYk4ByAgRWJyABX52KspoSWLZsWTz++OOxzz77xMc+9rHYdddd49JLL40bb7wxfvazn8XUqVMbxTt\\/\\/vwYP3589OvXL771rW9F\\/\\/7948c\\/\\/nEMGjQofvKTn2TndujQITbZZJPYZptt4nOf+1w88MADjeqwQ4AAAQIECBAgUEYBTROoUAEJeIUOjG61jsCcOXPiuOOOi2984xsxffr0SMl469Qc8e6778a8efNi1qxZcd5558WZZ54ZY8eOjaVLl7ZWE+ohQIAAAQIECBCoQgFdJrAmAQn4mmSUV73A888\\/HwcffHA8\\/fTTq42lffv2ccghh8Thhx+eXVqeLjVveKVLzrfddtvo2LFjHHbYYdkx6bg0473ayj4ofPjhh+PII4+MAw44IIYPH\\/5BiV8CBAgQIECAAAECbS6gwQoWkIBX8ODoWssF3nzzzfjKV74Sc+fOLVbSqVOnuPnmm+OFF16IdA93ek2YMCHGjRuXXWJeX1+f3fdd\\/8Fnukc81ZFmudPl6OmY9Er1pRnvAQMGRJcuXbL7xosNfLgxY8aMOOmkk6Jbt27xj3\\/848NSHwQIECBAgAABAgTyICDGtQlIwNem47uqFHjqqaeic+fO8be\\/\\/S3r\\/8c\\/\\/vH4zne+k10qfvnll8e+++4bafY7Wvizxx57RJ8+fSLNsC9ZsiQGDhwYO+ywwyq1TZw4Mbs\\/PCXtq3ypgAABAgQIECBAgACB1heo8Bol4BU+QLq37gJ33HFHLF++PDsxLbp26qmnxu23355dTp4VtuLbhhtumK2OPnPmzGzF9JScFwqFYgvpnwBpkbaUrBcLbRAgQIAAAQIECBAgUJMCTQUlAW9KyPdVJZBWNx81alSxz8cff3w8+OCD2ernxcISbKRZ9p49e8a0adPi7rvvzlZIb2jmX\\/\\/6Vxx11FGRHn\\/WUOaTAAECBAgQIECAAIH8CZQ4Ac8fqIjLJ5Du0U73bjf0IN2HnRZDKxQKDUUl\\/0yJ+AUXXBDpPvC0iFt8+LNo0aKoq6uLdFn6h0U+CBAgQIAAAQIECBDImUBtJ+A5G8y8hztp0qRGBL169Wq035Y7nTt3jtmzZ8d+++1XbPbtt9+OY489Np544olimQ0CBAgQIECAAAECBPIjIAEv4Virum0F7rvvvmKDF198caQZ52JBGTbS\\/eGTJ0+OE088sdh6mglPM\\/P9+\\/ePFStWFMttECBAgAABAgQIECBQ+wIS8Nod49xFtuWWWxZj3nnnnYvb5dxIi8ANHTo0rrvuumI30uPP+vbtG7179y6W5WUjLYaXl1jFSYAAAQIECBAgQGBlAQn4yiL2W0mgbasZM2ZMtgBaQ6t77rlnw2bZP9u1axdXX3113HPPPY0WZ7v55psjLRL37rvvlr2PbdGBTTfdNNKVCZ06dWqL5rRBgAABAgQIECBAoOIEJOAVNyQ61BKBN998s9Fp2223XaP9SthJi7ONHTs2OnfuXOzOiBEjYvvtt48pU6YUy2pxI60Q\\/+9\\/\\/zsL7a233so+vREgQIAAAQIECBDIm4AEPG8jXqPxzpo1qxhZWol8p512Ku6XY2NNbe6\\/\\/\\/7ZTP0xxxxTPGThwoVxxBFHxK9+9atiWS1t1NfXx+DBg4shDRkypLhtgwABAgQIECBAgECeBCTgeRrtGo51\\/Pjxxeh222234nYlbmyxxRYxcuTIuPDCC2PjjTfOurh48eI488wz47HHHovly5dnZevxVhGnDhs2LPvHQr9+\\/Yr9SQvjnXHGGcV9GwQIECBAgAABAgTyJCABz9No12isaVGzF154oRjd1ltvXdyu1I0OHTrEnXfeGU8++WRss802WTfTveCnn3569OnTJ9uv1reJEyfGJz\\/5yTj55JNj3LhxxTDq6uoiXYJfLLBBgAABAgQIECBAIGcCEvCcDXgthpvu\\/05JeENs6RL0hu1K\\/0yXnj\\/77LNxyCGHFLt64403RrpfvFhQRRvXXnttdOvWLd55551GvU7J9913392orGQ7KiZAgAABAgQIECBQoQIS8AodGN1qvsCyZcsaHZzuqW5UUOE7O+ywQ4wePTp69OhR7Om9994b6VnhxYIK35g0aVLsvffeMWDAgFV6utlmm0V67FolrUy\\/SidbsUBVBAgQIECAAAECBNYkIAFfk4zyqhFIj7VKz9tu6PArr7zSsFk1n2nW\\/oEHHmj0vPCUtF5++eUVH0OasT\\/ooINixowZq+3rl770pairq1vtdwpbXUCFBAgQIECAAAECFSwgAa\\/gwdG15gmk+6lTEt5w9Ntvvx3VNgue+p7+iZCeF57um07bqezWW2+Nb37zm7F06dK0W1GvdOn87rvvHlddddVq+1UoFOK2226Lxx9\\/fLXfK6xFATERIECAAAECBAisTUACvjYd31WNwD777NOor7Nnz260X007hx9+eIwaNSoaHqX2yCOPREp033jjjYoII\\/1zIz3X+9BDD42XX355tX3q3LlzTJ06NS6++OIoFAqrPUYhgVYXUCEBAgQIECBAoMIFJOAVPkC61zyBXXfdtdGBI0aMaLRfbTtHHnlk\\/Pa3v43jjjsu6\\/rrr7+eJeFPPPFEtl+OtxdffDG++93vxs477xyDBw9ebRfat28f559\\/fqRV6bt06RJ+CORJQKwECBAgQIAAgaYEJOBNCfm+KgRWTvaq4VFkTcHusssu8ctf\\/jJ69+4d6ZL0JUuWxAknnBDpvvD\\/\\/ve\\/TZ2+3t+vWLEiHnvssejRo0ek2e599903e3TaP\\/\\/5z1XqLhQKceyxx0a6\\/z4tIJceQ7bKQQoIECilgLoJECBAgACBKhCQgFfBIOli0wJf\\/\\/rXY6uttioeOHz48OJ2NW9ssMEGccMNN8SDDz4Ym2yySRZKui88PbZs3rx52f76vL322muRZrYnTJgQv\\/nNb+KKK66I448\\/Pj71qU9Fu3bt4vTTT48hQ4ZEut975XY6duwYaaY+JdzpUXBpxn7HHXdc+TD7BAjkQkCQBAgQIECAQHMEJODNUXJMVQj06tWr2M9x48Zll0Kn+5WLhVW8cdZZZ2WXddfV1WVRTJkyJbp27RrTp0\\/P9tNbSqb79OkTPXv2jLPPPjvuuuuu7BL2tEDd0Ucfnc1ip3vl999\\/\\/2xGvVAoREqY08z2YYcdFt27d49bbrkl0uX7CxYsSFWu8tpwww0jrXh+\\/\\/33R1rsbsyYMZnzZz\\/72VWOVUCAAIE2E9AQAQIECBCoEgEJeJUMlG42LVBfXx8NCWo6OiWJW265ZRxxxBGRvkuvlJwWCoVsYbBCoWWfaWa4UGjZuYXC\\/85LdWy88caxxx57xDbbbBMbbbRRk31K97mPGzcuhZa93nrrrUgJdaHwvzpTMn399ddHuj970KBBcdFFF8XIkSMjLd6WEuU0i50S9mnTpsWyZcuyOpp6SzPwKXlPq5mn+7oXL14czz33XJx77rmx2WabNXW67wkQIJALAUESIECAAIHmCkjAmyvluKoQ6Nu3b5x00kmN+pqS1n79+kV6peS00Zct2En3RrfgtEanpDpSMvunP\\/0p0qXk5XrMWPpHQLpffs8994y0+np6HXPMMXHNNdfE0KFDIyX5v\\/vd77LVzNNMeTq+USB2CBAgQKDcAtonQIAAgSoSkIBX0WDpatMCaQY8JY5nnnlmdnDnzp2zz4a39H2aBf\\/e974XKVlvyeucc86JSy65pMXnpzbTJeINdVxwwQXF5DclwGt6pfut0yXm6fz0Ou2002LTTTdtCC3SPdkHHnhgVtfKx6bj77jjjnjmmWdi7Nix8de\\/\\/jXSPwHSTHi6lHzmzJmR\\/lGRXqNHj47+\\/ftn\\/8j46H31xYZsECBAgACBooANAgQIEFgXAQn4umg5tmoE0sJhKcFM90Wnz7RIWPpMyedDDz0Ut99+e\\/Gy9Pr6+nXafuCBB+KHP\\/zhOp1Tv1IbAwcOLNZxzz33FJPflACv6ZUuIx8wYECx3UcffTS7vPyUU07JxiXNqM+ZMycuu+yyWPnY1H66JD1djl9XVxef\\/vSns3O8ESBAgACBqhbQeQIECFSZgAS8ygZMd1smsO2227bsxAo\\/a\\/PNN4+UiN93333ZbPj8+fOzhdfS7Hp6bFmFd1\\/3CBAgQIBAVQvoPAECBNZVQAK+rmKOJ1BhAu3bt4\\/zzjsv0r3an\\/nMZ7LepUXTTjjhhJg7d262740AAQIECBCoOQEBESBQhQIS8CocNF0msDqBdP93upc7rVCeFksbNWpUpMXV0srnqzteGQECBAgQIECg5QLOJECgJQIS8JaoOYdAhQqkx66lx69NmTIl0mPOFi1aFCkxTwuwVWiXdYsAAQIECBAgsO4CziBQpQIS8CodON0msDaBLl26ZI83S5ehv\\/fee5FWfT\\/55JNjwYIFazvNdwQIECBAgAABAs0QcAiBlgpIwFsq5zwCFS6QHlE2bNiwuO6662KDDTaIVCHqVAAADeZJREFUtN29e\\/d46aWXKrznukeAAAECBAgQILAWAV9VsYAEvIoHT9cJNCWQFmi7+uqrY\\/jw4bHFFlvExIkTY999943x48c3darvCRAgQIAAAQIECKxGQNH6CEjA10fPuQSqRCDNfI8ePToOPvjgeP\\/996Ouri769OkTK1asqJIIdJMAAQIECBAgQIBARFQ5ggS8ygdQ9wk0VyDdF55WRu\\/Ro0d2yvXXXx9f+MIX4sUXX8z2vREgQIAAAQIECBAgsHaB9f1WAr6+gs4nUEUCaWX0QYMGxcCBA7P7wtMjyrp16xY333xzFUVRPV0dN25c9XRWTwkQIECAAAECBEousJ4JeMn7pwECBEogcPbZZ8fs2bPjoIMOiiVLlsSVV14ZRx11VCxcuLAEreWzyi9+8YtxxBFHRM+ePfMJIGoCBAgQIECAAIFVBKo7AV8lHAUECDRXYLvttssWY6uvr48OHTrEM888E1tttVUMGDAgli9f3txqHLcGgb\\/85S\\/ZNyNHjsw+vREgQIAAAQIECBCQgK\\/H34BTCVS7QEq8+\\/btG5MnT45DDz00S7yvvfbaOOGEE+Kdd96p9vDK2v977703W+zu2WefLWs\\/NE6AAAECBAgQIFA5AhLwyhmLde2J4wm0mkB6NNmYMWPipptuio4dO8aIESNi5513jp\\/\\/\\/Oet1kbeKvra174WY8eOjV133TVvoYuXAAECBAgQIEBgDQIS8DXAKG5KwPe1JpBmw6+44opsNnynnXaKBQsWxGmnnRa9evWK9957r9bCFQ8BAgQIECBAgACBNheQgLc5uQZbRUAlJRP4\\/Oc\\/H3\\/4wx+id+\\/e0a5du\\/jpT38aW2+9dfzxj38sWZsqJkCAAAECBAgQIJAHAQl4HkZZjK0uUOsVpseV3XDDDZHuX95kk00i3Q+eLlOvr6+v9dDFR4AAAQIECBAgQKBkAhLwktGqmEDJBNqs4vSYsnnz5sVll10WS5cujX79+kWnTp3i1VdfbbM+aIgAAQIECBAgQIBArQhIwGtlJMVBoEQCaQb8lltuieeeey57TNkbb7yRLSx2ySWXxKJFi0rUqmoJECBAgAABAgQI1J6ABLz2xlREBEoikGbDX3nllTj33HOz+m+77bbYfffds+eHZwVt9aYdAgQIECBAgAABAlUqIAGv0oHTbQLlENh8883j\\/vvvz+4N32233SJdnn7UUUfFwQcfHDNmzChHl9q8TQ0SIECAAAECBAgQaKmABLylcs4jkGOBlHCnldKvueaa2GijjbLL0\\/fee+84+eSTY+bMmTmWKXnoGiBAgAABAgQIEKhiAQl4FQ+erhMop8CGG24Y\\/fv3zx5Zdvrpp0d6jviwYcMiPcbs+OOPj5deeqmc3dN2SQRUSoAAAQIECBAgsD4CEvD10XMuAQLZgmyPPPJI\\/P73v4\\/u3btnIiNGjIi99torunbtGk8\\/\\/XRW5o3AeguogAABAgQIECBQ5QIS8CofQN0nUCkCBxxwQKTEe\\/r06XHKKadk3Zo6dWp8+ctfjv333z8effTRWLFiRVZeSW\\/p2eY77LBDDB48uJK6pS8VKKBLBAgQIECAAIH1FZCAr6+g8wkQaCSQZr5\\/8YtfxJ\\/\\/\\/Ofo0aNHdmn6tGnT4owzzsgeY5YuU290Qhl3Lr\\/88uzZ5q+\\/\\/nr07NkzFi5cWMbeaJrAWgV8SYAAAQIECNSAgAS8BgZRCAQqUWDHHXeMQYMGxezZs+PKK6+Mdu3axYIFC7KF2gqFQhx99NFx3333xeLFi8vW\\/YcffrhR22n2vlGBHQIEPhTwQYAAAQIECLSGgAS8NRTVQYDAGgW23377uPHGG2PWrFnZbHOnTp2yY8eMGRPf\\/va3s3vIL7jggpg0aVJW3lZv6dLz+fPnF5urq6uLug9exQIbBAhUjoCeECBAgACBGhGQgNfIQAqDQKUL7LbbbnHttdfGa6+9FsOHD49zzz03PvGJT8TcuXPj3nvvjYMOOigKhULsvvvu2ex4nz59Il3KnmbQWzu2v\\/\\/973HPPfc0qrZXr16N9u0QIECgQcAnAQIECBBoLQEJeGtJqocAgWYJFAqFOPHEE+P++++PefPmxZ133hlpAbeGk19++eVIs+PXX399nHrqqbHLLrtkiXl67NmWW24Z6ZUec3bRRRfFOeecE7\\/+9a9j+fLlDac36\\/Oyyy6LlITHhz9Dhw6Nk0466cM9HwQIEKgoAZ0hQIAAgRoSkIDX0GAKhUC1CXTs2DEuvPDCmDJlSsycOTNuuOGGOOaYY2KLLbZYJZT\\/\\/Oc\\/2SJpaaG0tNr6XXfdFQMHDoyvfvWr0b59+yxJLxQK2eexxx6bJfjpMvN+\\/fpliXpK+NN+t27dYsiQIY3q32+\\/\\/Rrt2yFAgACBBgGfBAgQINCaAhLw1tRUFwECLRbYc889o3fv3jF69OhssbYlS5bEhAkT4oorrojzzjsvjjvuuDj88MNjjz32aLKNUaNGxfnnn5\\/dc56S7pSoN+xPnDix0fnpMWk77bRTozI7BAgQIFAhArpBgACBGhOQgNfYgAqHQK0IbLTRRnHIIYfETTfdlK2W\\/uSTT8a4ceOyxdzSbHhatC3NhKcZ7ksvvTRLzrt27Rpp0bfmGNTV1UW69Pypp55qzuGOIUCAAIEcCgiZAAECrS0gAW9tUfURIFBygQ4dOsSBBx4Y3bt3zxZ2u\\/XWWyMl55MnT445c+bE2LFjs6S9b9++sddee2X96dKlS6RX3QeJ9913350d477vjMYbAQIECFSmgF4RIFCDAhLwGhxUIRHIu0BKstNl6\\/X19TF9+vRYsWJFPP\\/889krJedWPM\\/7X4j4CRAgQKBpAUcQIFAKAQl4KVTVSYAAAQIECBAgQIBAywWcSaBGBSTgNTqwwiJAgAABAgQIECBAoGUCziJQKgEJeKlk1UuAAAECBAgQIECAAIF1F3BGDQtIwGt4cIVGgAABAgQIECBAgACBdRNwdCkFJOCl1FU3AQIECBAgQIAAAQIECDRfoMaPlIDX+AALjwABAgQIECBAgAABAgSaJ1DqoyTgpRZWPwECBAgQIECAAAECBAgQ+ECgiQT8gyP8EiBAgAABAgQIECBAgAABAustUNkJ+HqHpwICBAgQIECAAAECBAgQIFAZAhLwtYyDrwgQIECAAAECBAgQIECAQGsJSMBbS7L161EjAQIECBAgQIAAAQIECNSQgAS8hgazdUNRGwECBAgQIECAAAECBAi0poAEvDU11dV6AmoiQIAAAQIECBAgQIBAjQlIwGtsQIXTOgJqIUCAAAECBAgQIECAQGsLSMBbW1R9BNZfQA0ECBAgQIAAAQIECNSggAS8BgdVSATWT8DZBAgQIECAAAECBAiUQkACXgpVdRIg0HIBZxIgQIAAAQIECBCoUQEJeI0OrLAIEGiZgLMIECBAgAABAgQIlEpAAl4qWfUSIEBg3QWcQYAAAQIECBAgUMMCEvAaHlyhESBAYN0EHE2AAAECBAgQIFBKAQl4KXXVTYAAAQLNF3AkAQIECBAgQKDGBSTgNT7AwiNAgACB5gk4igABAgQIECBQagEJeKmF1U+AAAECBJoWcAQBAgQIECCQAwEJeA4GWYgECBAgQGDtAr4lQIAAAQIE2kJAAt4WytogQIAAAQIE1izgGwIECBAgkBMBCXhOBlqYBAgQIECAwOoFlBIgQIAAgbYSkIC3lbR2CBAgQIAAAQKrCighQIAAgRwJSMBzNNhCJUCAAAECBAg0FrBHgAABAm0pIAFvS21tESBAgAABAgQI\\/L+ALQIECORMQAKeswEXLgECBAgQIECAwP8EvBMgQKCtBSTgbS2uPQIECBAgQIAAAQIRDAgQyKGABDyHgy5kAgQIECBAgACBvAuInwCBcghIwMuhrk0CBAgQIECAAAECeRYQO4GcCkjAczrwwiZAgAABAgQIECCQVwFxEyiXgAS8XPLaJUCAAAECBAgQIEAgjwJizrGABDzHgy90AgQIECBAgAABAgTyJiDecgpIwMupr20CBAgQIECAAAECBAjkSSDnsUrAc\\/4HIHwCBAgQIECAAAECBAjkRaDccUrAyz0C2idAgAABAgQIECBAgACBPAiEBDwXwyxIAgQIECBAgAABAgQIECi3QHkT8HJHr30CBAgQIECAAAECBAgQINBGArlOwNvIWDMECBAgQIAAAQIECBAgQMAl6GX8G9A0AQIECBAgQIAAAQIECORIwAx4jga7caj2CBAgQIAAAQIECBAgQKAtBSTgbamtrf8XsEWAAAECBAgQIECAAIGcCUjAczbgwv2fgHcCBAgQIECAAAECBAi0tYAEvK3FtUcgggEBAgQIECBAgAABAjkUkIDncNCFnHcB8RMgQIAAAQIECBAgUA4BCXg51LVJIM8CYidAgAABAgQIECCQUwEJeE4HXtgE8iogbgIECBAgQIAAAQLlEpCAl0teuwQI5FFAzAQIECBAgAABAjkWkIDnePCFToBA3gTES4AAAQIECBAgUE4BCXg59bVNgACBPAmIlQABAgQIECCQcwEJeM7\\/AIRPgACBvAiIkwABAgQIECBQbgEJeLlHQPsECBAgkAcBMRIgQIAAAQIEQgLuj4AAAQIECNS8gAAJECBAgACBShCQgFfCKOgDAQIECBCoZQGxESBAgAABApmABDxj8EaAAAECBAjUqoC4CBAgQIBApQhIwCtlJPSDAAECBAgQqEUBMREgQIAAgaKABLxIYYMAAQIECBAgUGsC4iFAgACBShL4PwAAAP\\/\\/3nd7PQAAAAZJREFUAwBJcD\\/o8oBU\\/wAAAABJRU5ErkJggg==\",\"old_vehicle\":{\"vehicle_id\":13,\"vehicle_number\":\"568568\",\"category_id\":1,\"model_id\":4,\"category_name\":\"\",\"model_name\":\"\",\"km_out\":123,\"km_in\":444,\"km_used\":321,\"dt_out\":\"2026-08-02 17:52:36\",\"dt_in\":\"2026-08-02T17:51\",\"fuel_level_out\":\"half\",\"fuel_level_in\":\"full\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\"},\"old_return_images\":[\"1785682334_8511.jpg\"],\"violations\":[]},\"new_vehicle\":{\"vehicle_id\":8,\"vehicle_number\":\"90909\",\"category_id\":1,\"model_id\":1,\"category_name\":\"SMALL CARS\",\"model_name\":\"MICRA\",\"km_out\":33333,\"fuel_level_out\":\"\",\"dt_out\":\"2026-08-02T17:51\",\"accessories\":{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\"},\"new_rentout_images\":[\"1785682346_5931.jpg\"]},\"remarks\":\"\"}]'),(18,1,21,'AA/2026/AGR/0030','AA/2026/RS/0020','2026-08-29','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,2,6,'157720','{\"vehicle_id\":\"6\",\"category_id\":\"1\",\"model_id\":\"2\",\"veh_no\":\"157720\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN SUNNY\",\"vehicle_color\":\"WHITE\",\"vehicle_year\":\"2019\"}','Rental With Driver','2026-08-12 12:14:00','2026-08-13 11:11:00','{\"period_from\":\"2026-08-12T12:14\",\"period_to\":\"2026-08-13T11:11\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"23\",\"unit_price\":\"12\",\"min_price\":\"11.000\",\"vat\":\"0\",\"total_amt\":\"276.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',NULL,1232.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-29T14:24\",\"vehicle_km_out\":\"1232\",\"fuel_level\":\"full\",\"cust_driver_name\":\"test\",\"cust_driver_contact_no\":\"2342\",\"cust_driver_documents\":{\"vehicles\":[{\"documentName\":\"y\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a92c1adaaad05.15441762.webp\"]},{\"documentName\":\"u\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a92c1b745f9a2.95089446.webp\"]}]},\"vehicle_images\":[\"1788012622_4853.jpg\",\"1788015230_2046.jpg\"]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[\"1788012622_4853.jpg\",\"1788015230_2046.jpg\"]',NULL,1,'{\"driver_id\":\"1\",\"driver_name\":\"Driver1\",\"driver_mobile\":\"21323423\",\"driver_license_no\":\"234324\",\"driver_license_issplace\":\"Bahrain\",\"driver_license_issdate\":\"16-Jul-2026\",\"driver_license_expdate\":\"15-Jul-2026\"}','test','2342','{\"vehicles\":[{\"documentName\":\"y\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a92c1adaaad05.15441762.webp\"]},{\"documentName\":\"u\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a92c1b745f9a2.95089446.webp\"]}]}',NULL,NULL,'uploads/signatures/hirer_21_1788007549.png','Sinto','2026-08-29 15:45:49','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_21_1788007549.png','Administrator','2026-08-29 15:45:49','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-08-30 09:10:40\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-08-30 09:10:41\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,1,23,'AA/2026/AGR/0031','AA/2026/RS/0022','2026-08-30','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,4,13,'568568','{\"vehicle_id\":\"13\",\"category_id\":\"1\",\"model_id\":\"4\",\"veh_no\":\"568568\",\"category_name\":\"SMALL CARS\",\"model_name\":\"HONDA CITY\",\"vehicle_color\":\"White\",\"vehicle_year\":\"2024\"}','Rental With Driver','2027-01-01 00:00:00','2027-01-31 00:00:00','{\"period_from\":\"2027-01-01T00:00\",\"period_to\":\"2027-01-31T00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"30\",\"unit_price\":\"15\",\"min_price\":\"15.000\",\"vat\":\"0\",\"total_amt\":\"450.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,111.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-08-30T16:51\",\"vehicle_km_out\":\"111\",\"fuel_level\":\"full\",\"cust_driver_name\":\"test\",\"cust_driver_contact_no\":\"314\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[\"1788097903_9412.jpg\"]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[\"1788097903_9412.jpg\"]',NULL,1,'{\"driver_id\":\"1\",\"driver_name\":\"Driver1\",\"driver_mobile\":\"21323423\",\"driver_license_no\":\"234324\",\"driver_license_issplace\":\"Bahrain\",\"driver_license_issdate\":\"16-Jul-2026\",\"driver_license_expdate\":\"15-Jul-2026\"}','test','314','{\"vehicles\":[]}',NULL,NULL,'uploads/signatures/hirer_23_1788097937.png','Sinto','2026-08-30 16:52:17','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_23_1788097937.png','Administrator','2026-08-30 16:52:17','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','\"\"','{\"user_id\":1,\"datetime\":\"2026-08-30 16:52:17\"}','Rentout','{\"user_id\":1,\"datetime\":\"2026-08-30 16:52:17\"}',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(24,1,0,'AA/2026/AGR/0032',NULL,'2026-09-02','C0014',NULL,NULL,'',NULL,NULL,1,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','{\"fuel_out\":\"full\",\"salik_out\":\"0\"}',NULL,155.000,NULL,'{\"tools\":1,\"tyre\":1,\"radio\":0,\"aid\":0,\"mats\":0}',NULL,NULL,NULL,NULL,NULL,NULL,'[]',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hirer_1788346694_1.png','Sinto','2026-09-02 13:58:14','1',NULL,NULL,'1','delivery_1788346694_1.png','Administrator','2026-09-02 13:58:14',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(25,1,0,'AA/2026/AGR/0033',NULL,'2026-09-02','C0014',NULL,NULL,'',NULL,NULL,17,NULL,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00','{\"fuel_out\":\"full\",\"salik_out\":\"0\"}',NULL,345.000,NULL,'{\"tools\":0,\"tyre\":0,\"radio\":0,\"aid\":0,\"mats\":0}',NULL,NULL,NULL,NULL,NULL,NULL,'[]',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'hirer_1788346694_17.png','Sinto','2026-09-02 13:58:14','1',NULL,NULL,'1','delivery_1788346694_17.png','Administrator','2026-09-02 13:58:14',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(26,1,0,'AA/2026/AGR/0034',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,17,'898989','{\"vehicle_id\":17,\"category_id\":1,\"model_id\":1,\"veh_no\":\"898989\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"blue\",\"vehicle_year\":2022}','2','0000-00-00 00:00:00','0000-00-00 00:00:00','{\"period_from\":\"01-01-2026 00:00\",\"period_to\":\"31-12-2026 00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental Without Driver\",\"duration\":\"364\",\"unit_price\":\"5\",\"min_price\":\"0\",\"vat\":\"0\",\"total_amt\":\"0\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,7877.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-02T14:38\",\"vehicle_km_out\":\"7877\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]',NULL,NULL,NULL,NULL,NULL,'hirer_1788349392_17.png','Sinto','2026-09-02 14:43:12','1',NULL,NULL,'1','delivery_1788349392_17.png','Administrator','2026-09-02 14:43:12',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(27,1,0,'AA/2026/AGR/0035',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,1,'12345','{\"vehicle_id\":1,\"category_id\":1,\"model_id\":1,\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":2015}','2','0000-00-00 00:00:00','0000-00-00 00:00:00','{\"period_from\":\"01-01-2026 00:00\",\"period_to\":\"10-01-2026 00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental Without Driver\",\"duration\":\"9\",\"unit_price\":\"5\",\"min_price\":\"0\",\"vat\":\"0\",\"total_amt\":\"0\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,155.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-02T14:52\",\"vehicle_km_out\":\"155\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]',NULL,NULL,NULL,NULL,NULL,'hirer_1788349964_1.png','Sinto','2026-09-02 14:52:44','1',NULL,NULL,'1','delivery_1788349964_1.png','Administrator','2026-09-02 14:52:44',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(28,1,0,'AA/2026/AGR/0036',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,17,'898989','{\"vehicle_id\":17,\"category_id\":1,\"model_id\":1,\"veh_no\":\"898989\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"blue\",\"vehicle_year\":2022}','1','2026-09-02 15:08:00','2026-09-02 15:08:00','{\"period_from\":\"2026-09-02 15:08\",\"period_to\":\"2026-09-02 15:08\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"0\",\"unit_price\":\"5\",\"min_price\":\"0\",\"vat\":\"0\",\"total_amt\":\"0\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,6555.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-02T15:07\",\"vehicle_km_out\":\"6555\",\"fuel_level\":\"half\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]',NULL,NULL,NULL,NULL,NULL,'hirer_1788350902_17.png','Sinto','2026-09-02 15:08:22','1',NULL,NULL,'1','delivery_1788350902_17.png','Administrator','2026-09-02 15:08:22',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(29,1,0,'AA/2026/AGR/0037',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,1,'12345','{\"vehicle_id\":1,\"category_id\":1,\"model_id\":1,\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":2015}','Rental With Driver','0000-00-00 00:00:00','0000-00-00 00:00:00','{\"period_from\":\"01-01-2027 10:15\",\"period_to\":\"10-01-2027 20:20\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"10\",\"unit_price\":\"5\",\"min_price\":\"5\",\"vat\":\"0\",\"total_amt\":\"50.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,155.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-09-02T15:21\",\"vehicle_km_out\":\"155\",\"fuel_level\":\"test\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]',NULL,NULL,NULL,NULL,NULL,'hirer_1788351732_1.png','Sinto','2026-09-02 15:22:12','1',NULL,NULL,'1','delivery_1788351732_1.png','Administrator','2026-09-02 15:22:12',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(30,1,0,'AA/2026/AGR/0038',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,1,'12345','{\"vehicle_id\":1,\"category_id\":1,\"model_id\":1,\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":2015}','Rental Without Driver','2027-05-30 00:00:00','2027-06-15 00:00:00','{\"period_from\":\"2027-05-30 00:00:00\",\"period_to\":\"2027-06-15 00:00:00\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"384\",\"unit_price\":\"5\",\"min_price\":\"5\",\"vat\":\"10\",\"total_amt\":\"2112.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,155.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-02T15:43\",\"vehicle_km_out\":\"155\",\"fuel_level\":\"ff\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]',NULL,NULL,NULL,NULL,NULL,'hirer_1788353069_1.png','Sinto','2026-09-02 15:44:29','1',NULL,NULL,'1','delivery_1788353069_1.png','Administrator','2026-09-02 15:44:29',NULL,NULL,NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(31,1,0,'AA/2026/AGR/0039',NULL,'2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,17,'898989','{\"vehicle_id\":17,\"category_id\":1,\"model_id\":1,\"veh_no\":\"898989\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"blue\",\"vehicle_year\":2022}','Rental With Driver','2026-01-01 00:00:00','2026-12-31 00:00:00','{\"period_from\":\"2026-01-01 00:00:00\",\"period_to\":\"2026-12-31 00:00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"364\",\"unit_price\":\"5\",\"min_price\":\"5\",\"vat\":\"0\",\"total_amt\":\"1820.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}',NULL,3535.000,NULL,'{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-09-02T17:18\",\"vehicle_km_out\":\"3535\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[\"1788358743_8900.jpg\",\"1788358746_1083.jpg\"]',NULL,1,'{\"driver_id\":1,\"driver_name\":\"Driver1\",\"driver_mobile\":\"21323423\",\"driver_license_no\":\"234324\",\"driver_license_issplace\":\"Bahrain\",\"driver_license_issdate\":\"2026-07-16\",\"driver_license_expdate\":\"2026-07-15\"}','tet','34534','{\"vehicles\":[{\"documentName\":\"y\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a9830499a5d19.03930237.webp\"]},{\"documentName\":\"y\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a9830511f2bc8.51196534.webp\"]}]}',NULL,NULL,'uploads/signatures/hirer_1788358753_17.png','Sinto','2026-09-02 17:19:13','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_1788358753_17.png','Administrator','2026-09-02 17:19:13','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36',NULL,NULL,'Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(32,1,22,'AA/2026/AGR/0040','AA/2026/RS/0021','2026-09-02','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,3,14,'55555','{\"vehicle_id\":\"14\",\"category_id\":\"1\",\"model_id\":\"3\",\"veh_no\":\"55555\",\"category_name\":\"SMALL CARS\",\"model_name\":\"CHANGAN ALSVIN\",\"vehicle_color\":\"Black\",\"vehicle_year\":\"2012\"}','Rental Without Driver','2027-01-01 00:00:00','2027-01-31 00:00:00','{\"period_from\":\"2027-01-01T00:00\",\"period_to\":\"2027-01-31T00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"30\",\"unit_price\":\"12\",\"min_price\":\"0.000\",\"vat\":\"10\",\"total_amt\":\"396.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,200.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-09-02T17:26\",\"vehicle_km_out\":\"200\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}','','','{\"vehicles\":[]}',NULL,NULL,NULL,NULL,NULL,'No',NULL,NULL,'No',NULL,NULL,NULL,NULL,NULL,'\"\"','{\"user_id\":1,\"datetime\":\"2026-09-02 17:26:54\"}','Generated',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(33,1,0,'AA/2026/AGR/0041',NULL,'2026-09-03','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,1,'12345','{\"vehicle_id\":1,\"category_id\":1,\"model_id\":1,\"veh_no\":\"12345\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"White\",\"vehicle_year\":2015}','Rental With Driver','2026-01-01 00:00:00','2026-12-31 00:00:00','{\"period_from\":\"2026-01-01 00:00:00\",\"period_to\":\"2026-12-31 00:00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"364\",\"unit_price\":\"5\",\"min_price\":\"5\",\"vat\":\"0\",\"total_amt\":\"1820.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,155.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"Yes\",\"chk_radio\":\"Yes\",\"date_out\":\"2026-09-03T12:50\",\"vehicle_km_out\":\"155\",\"fuel_level\":\"full\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]','test','12321','{\"vehicles\":[{\"documentName\":\"test\",\"files\":[\"uploads\\/custDriverDocs\\/webp\\/file_6a994301d7f1b6.05030769.webp\"]}]}',NULL,NULL,'uploads/signatures/hirer_1788429061_1.png','Sinto','2026-09-03 12:51:01','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_1788429061_1.png','Administrator','2026-09-03 12:51:01','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36',NULL,'{\"user_id\":1,\"datetime\":\"2026-09-03 12:51:01\"}','Rentout',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(34,1,0,'AA/2026/AGR/0042',NULL,'2026-09-03','C0014','Sinto','{\"customer_name\":\"Sinto\",\"customer_code\":\"C0014\",\"customer_mobile\":\"123123\",\"customer_email\":\"sinto@gmail.com\",\"customer_attention\":\"test\",\"customer_address\":\"test\"}','',1,1,17,'898989','{\"vehicle_id\":17,\"category_id\":1,\"model_id\":1,\"veh_no\":\"898989\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"blue\",\"vehicle_year\":2022}','Rental With Driver','2026-01-01 00:00:00','2026-12-31 00:00:00','{\"period_from\":\"2026-01-01 00:00:00\",\"period_to\":\"2026-12-31 00:00:00\",\"rate_type_id\":\"day\",\"rate_type\":\"Daily\",\"service_id\":\"2\",\"service_name\":\"Rental With Driver\",\"duration\":\"364\",\"unit_price\":\"5\",\"min_price\":\"5\",\"vat\":\"0\",\"total_amt\":\"1820.000\",\"qtn_ref_no\":\"\",\"booking_notes\":\"\",\"otp_details\":\"\"}',NULL,0.000,NULL,'{\"chk_tools\":\"No\",\"chk_spare\":\"No\",\"chk_radio\":\"No\",\"date_out\":\"2026-09-03T12:50\",\"vehicle_km_out\":\"\",\"fuel_level\":\"\",\"cust_driver_name\":\"\",\"cust_driver_contact_no\":\"\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[]}',NULL,NULL,NULL,NULL,NULL,'<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>','[]',NULL,0,'[]','','','[]',NULL,NULL,'uploads/signatures/hirer_1788429061_17.png','Sinto','2026-09-03 12:51:01','Yes','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36','Yes','uploads/signatures/delivery_1788429061_17.png','Administrator','2026-09-03 12:51:01','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/152.0.0.0 Safari/537.36',NULL,'{\"user_id\":1,\"datetime\":\"2026-09-03 12:51:01\"}','Rentout',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_vehicle_rentout_contracts` ENABLE KEYS */;
UNLOCK TABLES;

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
  `image_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `other_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `vehicle_status` varchar(100) NOT NULL,
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
  UNIQUE KEY `chassis_number` (`chassis_number`),
  CONSTRAINT `tbl_vehicles_chk_1` CHECK (json_valid(`image_json`)),
  CONSTRAINT `tbl_vehicles_chk_2` CHECK (json_valid(`other_details_json`)),
  CONSTRAINT `tbl_vehicles_chk_3` CHECK (json_valid(`vehicle_attachments`)),
  CONSTRAINT `tbl_vehicles_chk_4` CHECK (json_valid(`passing_histroy`)),
  CONSTRAINT `tbl_vehicles_chk_5` CHECK (json_valid(`insurance_histroy`)),
  CONSTRAINT `tbl_vehicles_chk_6` CHECK (json_valid(`maintenance_histroy`)),
  CONSTRAINT `tbl_vehicles_chk_7` CHECK (json_valid(`rentout_log_json`)),
  CONSTRAINT `tbl_vehicles_chk_8` CHECK (json_valid(`vehicle_status_log_json`))
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_vehicles`
--

LOCK TABLES `tbl_vehicles` WRITE;
/*!40000 ALTER TABLE `tbl_vehicles` DISABLE KEYS */;
INSERT INTO `tbl_vehicles` VALUES (1,1,1,'NISSAN MICRA',1,1,'12345',NULL,2015,'White','[\"veh_6a364a1d2d6bb4.06579273.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":12333,\"current_km\":155,\"fuel_level\":\"full\"}','{\"vehicles\":[]}','Rentout','No',0,'2026-06-20 00:00:00',1,'2026-06-19','2026-09-29','[{\"id\":\"6a85933a6669b\",\"date\":\"2026-09-29\",\"amount\":\"\",\"remarks\":\"\",\"attachment\":null,\"created_at\":\"2026-08-19 14:27:54\",\"created_by\":1},{\"id\":\"6a8590f805191\",\"date\":\"2026-09-05\",\"amount\":\"\",\"remarks\":\"22d\",\"attachment\":\"http:\\/\\/localhost:3030\\/uploads\\/vehicles\\/documents\\/1787138296_Screenshot 2026-07-30 170748.png\",\"created_at\":\"2026-08-19 14:18:16\",\"created_by\":1},{\"id\":\"1782118654889_0.7409205120413452\",\"added_info\":\"passing2026\",\"next_date\":\"2026-06-27\",\"done_date\":\"2026-06-22\",\"remarks\":\"test\",\"documents\":[]}]','2026-09-11','[{\"id\":\"6a85932af0eb1\",\"date\":\"2026-09-11\",\"amount\":\"\",\"remarks\":\"\",\"attachment\":null,\"created_at\":\"2026-08-19 14:27:38\",\"created_by\":1},{\"id\":\"6a85931d87611\",\"date\":\"2026-09-05\",\"amount\":\"\",\"remarks\":\"\",\"attachment\":null,\"created_at\":\"2026-08-19 14:27:25\",\"created_by\":1},{\"id\":\"6a8590d2e6475\",\"date\":\"2026-08-21\",\"amount\":\"123\",\"remarks\":\"test\",\"attachment\":\"http:\\/\\/localhost:3030\\/uploads\\/vehicles\\/documents\\/1787138258_Screenshot 2026-07-14 235830.png\",\"created_at\":\"2026-08-19 14:17:38\",\"created_by\":1},{\"id\":\"1782118693606_0.7273060750118302\",\"added_info\":\"insurance2026\",\"next_date\":\"2026-06-30\",\"done_date\":\"2026-06-20\",\"remarks\":\"test\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_6a38f924b80954.70348141.jpg\",\"isNew\":false,\"id\":\"1782118693606_jw0jc5tzb\"}]}]','2026-07-16','[{\"id\":\"1782118723582_0.9080521220646008\",\"added_info\":\"maintfor july\",\"next_date\":\"2026-07-16\",\"done_date\":\"2026-06-02\",\"remarks\":\"tt\",\"documents\":[]},{\"id\":\"1782119256218_0.34007807206546714\",\"added_info\":\"fdvd\",\"next_date\":\"2026-07-22\",\"done_date\":\"2026-06-18\",\"remarks\":\"rtt\",\"documents\":[]}]','{\"user_id\":1,\"datetime\":\"2026-08-01 17:01:55\"}','','{\"user_id\":1,\"datetime\":\"2026-08-26 17:41:47\"}'),(2,1,2,'NISSAN SUNNY',1,1,'66666',NULL,2016,'white','[\"veh_6a364a42b10a07.27059667.jpg\"]','{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"fdg\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":12333}','{\"vehicles\":[]}','Rentout','No',0,'2026-06-20 00:00:00',1,'2026-06-30',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-06-20 19:50:20\"}',NULL,NULL),(3,1,2,'NISSAN SUNNY',1,1,'333333',NULL,2000,'white','[\"veh_6a38f21dae4a23.38962016.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test \",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":1200}','{\"vehicles\":[{\"documentName\":\"Ownership\",\"files\":[\"uploads\\/rentedcars\\/webp\\/file_6a38f1fc40dcc5.00652317.webp\"]},{\"documentName\":\"doc2\",\"files\":[\"uploads\\/rentedcars\\/webp\\/file_6a38f20bd26dd3.88185722.webp\"]}]}','Staff Use','No',0,'2026-06-22 00:00:00',64,'2026-06-02',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":64,\"datetime\":\"2026-06-22 11:43:05\"}','','{\"user_id\":1,\"datetime\":\"2026-07-22 17:17:14\"}'),(5,1,2,'NISSAN SUNNY',1,1,'157763',NULL,2019,'WHITE','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"DELIVERY DATE 01-01-2019\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":4000}','{\"vehicles\":[{\"documentName\":\"OWNERSHIP AND INSURANCE\",\"files\":[\"uploads\\/rentedcars\\/files\\/file_6a3a81bb6040a8.61969448.pdf\"]}]}','Available','No',0,'2026-06-23 00:00:00',1,'2019-01-01',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-07-28 12:38:28\"}','','{\"user_id\":1,\"datetime\":\"2026-08-26 17:41:47\"}'),(4,1,1,'NISSAN MICRA',1,1,'565656',NULL,2020,'white','[\"veh_6a38fdef9a1ec4.32724387.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"sdf\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":3245}','{\"vehicles\":[]}','Rentout','No',0,'2026-06-22 00:00:00',64,'2026-07-02',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":64,\"datetime\":\"2026-06-22 12:22:26\"}',NULL,NULL),(6,1,2,'NISSAN SUNNY',1,1,'157720','',2019,'WHITE','[\"veh_6a9060e66c16c9.74029971.jpg\",\"veh_6a9060f0a327f1.73186295.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"DELIVERY DATE ON 01-01-2019\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":4000}','{\"vehicles\":[]}','Available','No',0,'2026-07-06 00:00:00',1,'2019-01-01',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-07-11 18:50:16\"}','','{\"user_id\":1,\"datetime\":\"2026-08-01 16:44:12\"}'),(7,5,50,'NISSAN X-TRAIL',1,1,'538745',NULL,2016,'GOLD AND BLACK','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"BRAND NEW \",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":15000}','{\"vehicles\":[{\"documentName\":\"INSURANCE & OWNERSHIP\",\"files\":[\"uploads\\/rentedcars\\/files\\/file_6a4b88e59648d4.24674559.pdf\"]}]}','Available','No',0,'2026-07-06 00:00:00',1,'2026-01-06','2026-07-26','[{\"id\":\"1783416260588_0.6398589070043089\",\"added_info\":\"PASSING MONTH JUNE\",\"next_date\":\"2026-06-30\",\"done_date\":\"2026-06-01\",\"remarks\":\"TRY TO DO PASSING IN MAY\",\"documents\":[{\"name\":\"XTRIAL OWNERSHI.pdf\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_6a4cc5c41764a2.70890286.pdf\",\"isNew\":false,\"id\":\"1783416260588_p80ndsphm\"}]},{\"id\":\"1784965837157_0.685477421874006\",\"added_info\":\"tyybshdf\",\"next_date\":\"2026-07-26\",\"done_date\":\"2026-07-25\",\"remarks\":\"tetet\",\"documents\":[{\"name\":\"Screenshot 2024-05-14 083839.png\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_6a646acc7a7c22.31442888.png\",\"isNew\":false,\"id\":\"1784965837157_5odyofxoo\"}]}]','2026-07-29','[{\"id\":\"1784965888318_0.4153097416316919\",\"added_info\":\"insurance\",\"next_date\":\"2026-07-29\",\"done_date\":\"2026-07-26\",\"remarks\":\"test\",\"documents\":[{\"name\":\"Screenshot 2024-05-14 083839.png\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_6a646aff9cbbb5.30025088.png\",\"isNew\":false,\"id\":\"1784965888318_00csp954x\"}]}]',NULL,NULL,'{\"user_id\":65,\"datetime\":\"2026-07-25 12:04:15\"}','','{\"user_id\":1,\"datetime\":\"2026-08-01 16:44:12\"}'),(8,1,1,'NISSAN MICRA',1,1,'90909',NULL,2015,'black','[\"veh_6a620fba472821.15993044.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":123}','{\"vehicles\":[]}','Rentout','No',0,'2026-07-23 00:00:00',1,'2026-07-24',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-07-23 16:00:53\"}',NULL,NULL),(13,1,4,'HONDA CITY',3,1,'568568','1234',2024,'White','[\"veh_6a675250e0a9a0.38587667.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":2000}','{\"vehicles\":[{\"documentName\":\"test\",\"files\":[\"uploads\\/rentedcars\\/webp\\/file_6a675245a48265.59221553.webp\"]}]}','Rentout','No',0,'2026-07-27 00:00:00',1,'2024-02-14',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-08-30 16:52:17\"}','','{\"user_id\":1,\"datetime\":\"2026-08-30 16:48:48\"}'),(12,1,3,'CHANGAN ALSVIN',2,1,'123123','12345',2025,'Black','[\"veh_6a674fab129db6.81665711.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":2000}','{\"vehicles\":[{\"documentName\":\"Ownership certificate\",\"files\":[\"uploads\\/rentedcars\\/files\\/file_6a674f931b4366.81200117.pdf\"]}]}','Available','No',0,'2026-07-27 00:00:00',1,'2025-06-03','2026-08-05','[{\"id\":\"1785669690699_0.9995047887393725\",\"added_info\":\"test\",\"next_date\":\"2026-08-05\",\"done_date\":\"2026-08-02\",\"remarks\":\"test\",\"documents\":[{\"name\":\"22.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_6a6f283a8a3585.63643726.jpg\",\"isNew\":false,\"id\":\"1785669690699_re577mhpd\"}]}]',NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-08-01 16:46:00\"}','','{\"user_id\":1,\"datetime\":\"2026-08-30 16:48:48\"}'),(14,1,3,'CHANGAN ALSVIN',2,1,'55555','123',2012,'Black','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":12313}','{\"vehicles\":[]}','Available','Yes',1,'2026-08-01 00:00:00',1,'2026-08-13',NULL,NULL,NULL,NULL,NULL,NULL,'{\"user_id\":1,\"datetime\":\"2026-08-01 15:20:30\"}','','{\"user_id\":1,\"datetime\":\"2026-08-01 16:44:12\"}'),(15,1,1,'NISSAN MICRA',1,2,'909090','1234Qwert',2012,'blue','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":123}','{\"vehicles\":[{\"documentName\":\"tt\",\"files\":[\"uploads\\/rentedcars\\/webp\\/file_6a859ccfdade51.78645900.webp\"]}]}','Maintenance','Yes',1,'2026-08-19 00:00:00',74,'2026-08-21',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,1,1,'NISSAN MICRA',1,2,'123333','123213',123,'blue','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":1200}','{\"vehicles\":[]}','Available','No',0,'2026-08-26 00:00:00',1,'2026-08-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(17,1,1,'NISSAN MICRA',1,1,'898989','88888',2022,'blue','[\"veh_6a947c8a1b1eb7.00396495.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":1233}','{\"vehicles\":[]}','Rentout','No',0,'2026-08-30 00:00:00',1,'2026-07-29',NULL,NULL,'2026-09-04','[{\"id\":\"6a99393a8cc0f\",\"date\":\"2026-09-04\",\"amount\":\"10\",\"remarks\":\"\",\"attachment\":null,\"created_at\":\"2026-09-03 12:09:14\",\"created_by\":1}]',NULL,NULL,NULL,NULL,NULL),(18,1,1,'NISSAN MICRA',1,2,'555666','5556666666',2017,'white','[\"veh_6a947cc19d5144.98637317.jpg\"]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":1233}','{\"vehicles\":[]}','Available','No',0,'2026-08-30 00:00:00',1,'2026-08-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(19,1,1,'NISSAN MICRA',1,2,'545454','123123213',2019,'White','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":1233}','{\"vehicles\":[]}','Available','No',0,'2026-09-03 00:00:00',1,'2000-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(20,1,1,'NISSAN MICRA',1,1,'753159','21312312321',2000,'Black','[]','{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":0}','{\"vehicles\":[]}','Available','No',0,'2026-09-03 00:00:00',1,'2026-06-17',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `tbl_vehicles` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `user_shortcuts`
--

LOCK TABLES `user_shortcuts` WRITE;
/*!40000 ALTER TABLE `user_shortcuts` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_shortcuts` ENABLE KEYS */;
UNLOCK TABLES;

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
  KEY `idx_vehicle_status` (`vehicles_status`,`company_id`),
  CONSTRAINT `vehicles_chk_1` CHECK (json_valid(`vehicles_details`))
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;

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

-- Dump completed on 2026-09-03 13:27:17
