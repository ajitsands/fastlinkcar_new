<?php
/**
 * Database Synchronizer Script
 * CAUTION: Run this script on your live server to verify and update the database structure.
 * ALWAYS take a database backup before running!
 */

// -------------------------------------------------------------
// CONFIGURATION
// -------------------------------------------------------------
// Provide your LIVE server database credentials here:
$host = '127.0.0.1';
$db   = 'YOUR_LIVE_DB_NAME';
$user = 'YOUR_LIVE_DB_USER';
$pass = 'YOUR_LIVE_DB_PASSWORD';
$charset = 'utf8mb4';

// -------------------------------------------------------------
// EMBEDDED BLUEPRINT (Do not edit manually)
// -------------------------------------------------------------
$blueprintJson = <<<JSON
{
    "booking_info": {
        "create_sql": "CREATE TABLE `booking_info` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `booking_id` varchar(20) DEFAULT NULL,\n  `reg_number` varchar(50) DEFAULT NULL,\n  `car_id` int(11) DEFAULT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(150) DEFAULT NULL,\n  `customer_id` varchar(50) DEFAULT NULL,\n  `customer_name` varchar(150) DEFAULT NULL,\n  `rent_start_date` date DEFAULT NULL,\n  `rent_end_date` date DEFAULT NULL,\n  `total_days_taken` int(11) DEFAULT NULL,\n  `rent_per_day` decimal(10,2) DEFAULT NULL,\n  `rent_total_cost` decimal(10,3) DEFAULT NULL,\n  `rent_discount_if_any` decimal(10,2) DEFAULT NULL,\n  `rent_after_discount` decimal(10,3) DEFAULT NULL,\n  `rent_tax_any` decimal(10,2) DEFAULT NULL,\n  `rent_grand_total` decimal(10,3) DEFAULT NULL,\n  `vehicles_image` varchar(1500) DEFAULT NULL,\n  `jack_and_tools` tinyint(1) DEFAULT NULL,\n  `spare_tyre` tinyint(1) DEFAULT NULL,\n  `radio_yes_no` tinyint(1) DEFAULT NULL,\n  `cd_recorder` tinyint(1) DEFAULT NULL,\n  `drivers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `clients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `booking_id` (`booking_id`),\n  CONSTRAINT `booking_info_chk_1` CHECK (json_valid(`drivers`)),\n  CONSTRAINT `booking_info_chk_2` CHECK (json_valid(`vehicles`)),\n  CONSTRAINT `booking_info_chk_3` CHECK (json_valid(`clients`))\n) ENGINE=MyISAM DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "booking_id": {
                "Field": "booking_id",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "reg_number": {
                "Field": "reg_number",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "car_id": {
                "Field": "car_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_id": {
                "Field": "customer_id",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_start_date": {
                "Field": "rent_start_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_end_date": {
                "Field": "rent_end_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_days_taken": {
                "Field": "total_days_taken",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_per_day": {
                "Field": "rent_per_day",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_total_cost": {
                "Field": "rent_total_cost",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_discount_if_any": {
                "Field": "rent_discount_if_any",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_after_discount": {
                "Field": "rent_after_discount",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_tax_any": {
                "Field": "rent_tax_any",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rent_grand_total": {
                "Field": "rent_grand_total",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_image": {
                "Field": "vehicles_image",
                "Type": "varchar(1500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "jack_and_tools": {
                "Field": "jack_and_tools",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "spare_tyre": {
                "Field": "spare_tyre",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "radio_yes_no": {
                "Field": "radio_yes_no",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cd_recorder": {
                "Field": "cd_recorder",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "drivers": {
                "Field": "drivers",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles": {
                "Field": "vehicles",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "clients": {
                "Field": "clients",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "cashmemo": {
        "create_sql": "CREATE TABLE `cashmemo` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `cashmemo_no` varchar(100) DEFAULT NULL,\n  `cashmemo_date` date DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(150) DEFAULT NULL,\n  `customer_phone` varchar(50) DEFAULT NULL,\n  `customer_email` varchar(150) DEFAULT NULL,\n  `customer_cpr_cr` varchar(200) DEFAULT NULL,\n  `customer_address` text,\n  `contract_ids` int(11) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(200) DEFAULT NULL,\n  `vehicle_ids` int(11) DEFAULT NULL,\n  `vehicle_no` varchar(200) DEFAULT NULL,\n  `model_ids` int(11) DEFAULT NULL,\n  `model_names` varchar(500) DEFAULT NULL,\n  `vehicle_color` varchar(200) DEFAULT NULL,\n  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `allItemSubtotal` decimal(18,5) NOT NULL,\n  `subtotal` decimal(12,5) DEFAULT NULL,\n  `total_discount` decimal(18,2) NOT NULL,\n  `total_discount_amount` decimal(18,4) NOT NULL,\n  `after_discount_amount` decimal(18,4) NOT NULL,\n  `vat_total` decimal(12,5) DEFAULT NULL,\n  `grand_total` decimal(12,5) DEFAULT NULL,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `draft` enum('Yes','No') DEFAULT 'No',\n  `reference_number` varchar(20) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `user_name` varchar(150) DEFAULT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(200) DEFAULT NULL,\n  `cashmemo_notes` text,\n  `cashmemo_payment_type` varchar(200) DEFAULT NULL,\n  `cashmemo_cheque_date` date DEFAULT NULL,\n  `cashmemo_cheque_ref_no` varchar(200) DEFAULT NULL,\n  `company_signature` varchar(1000) DEFAULT NULL,\n  `company_sign_name` varchar(1000) DEFAULT NULL,\n  `company_sign_date_time` datetime DEFAULT NULL,\n  `customer_signature` varchar(1000) DEFAULT NULL,\n  `customer_sign_name` varchar(1000) DEFAULT NULL,\n  `customer_sign_datetime` datetime DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `quotation_no` (`cashmemo_no`),\n  UNIQUE KEY `uk_invoice_no` (`cashmemo_no`),\n  CONSTRAINT `cashmemo_chk_1` CHECK (json_valid(`items`))\n) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "cashmemo_no": {
                "Field": "cashmemo_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "cashmemo_date": {
                "Field": "cashmemo_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_phone": {
                "Field": "customer_phone",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_email": {
                "Field": "customer_email",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_cpr_cr": {
                "Field": "customer_cpr_cr",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_address": {
                "Field": "customer_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contract_ids": {
                "Field": "contract_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_ids": {
                "Field": "model_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_names": {
                "Field": "model_names",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_color": {
                "Field": "vehicle_color",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "items": {
                "Field": "items",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "allItemSubtotal": {
                "Field": "allItemSubtotal",
                "Type": "decimal(18,5)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "subtotal": {
                "Field": "subtotal",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount": {
                "Field": "total_discount",
                "Type": "decimal(18,2)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount_amount": {
                "Field": "total_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "after_discount_amount": {
                "Field": "after_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vat_total": {
                "Field": "vat_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "grand_total": {
                "Field": "grand_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "draft": {
                "Field": "draft",
                "Type": "enum('Yes','No')",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "reference_number": {
                "Field": "reference_number",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_name": {
                "Field": "user_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cashmemo_notes": {
                "Field": "cashmemo_notes",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cashmemo_payment_type": {
                "Field": "cashmemo_payment_type",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cashmemo_cheque_date": {
                "Field": "cashmemo_cheque_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cashmemo_cheque_ref_no": {
                "Field": "cashmemo_cheque_ref_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_signature": {
                "Field": "company_signature",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_sign_name": {
                "Field": "company_sign_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_sign_date_time": {
                "Field": "company_sign_date_time",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_signature": {
                "Field": "customer_signature",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_sign_name": {
                "Field": "customer_sign_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_sign_datetime": {
                "Field": "customer_sign_datetime",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "customer_details": {
        "create_sql": "CREATE TABLE `customer_details` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `customer_id` varchar(20) NOT NULL,\n  `customer_name` varchar(500) DEFAULT NULL,\n  `customer_mobile` varchar(20) DEFAULT NULL,\n  `customer_email` varchar(200) DEFAULT NULL,\n  `customer_addr` text,\n  `customer_attn` varchar(1000) DEFAULT NULL,\n  `customer_cr_cpr` varchar(100) DEFAULT NULL,\n  `cpr_expiry_date` date DEFAULT NULL,\n  `customer_type` varchar(50) DEFAULT NULL,\n  `customer_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `client_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `driver_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `company_id` int(11) NOT NULL,\n  `created_by` int(11) DEFAULT NULL,\n  `status` enum('Active','Inactive') DEFAULT 'Active',\n  `updated_on` datetime DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `customer_id` (`customer_id`),\n  KEY `idx_customer_name` (`customer_name`),\n  KEY `idx_customer_mobile` (`customer_mobile`),\n  CONSTRAINT `customer_details_chk_1` CHECK (json_valid(`customer_address`)),\n  CONSTRAINT `customer_details_chk_2` CHECK (json_valid(`client_docs`)),\n  CONSTRAINT `customer_details_chk_3` CHECK (json_valid(`driver_docs`))\n) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "customer_id": {
                "Field": "customer_id",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "customer_mobile": {
                "Field": "customer_mobile",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "customer_email": {
                "Field": "customer_email",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_addr": {
                "Field": "customer_addr",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_attn": {
                "Field": "customer_attn",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_cr_cpr": {
                "Field": "customer_cr_cpr",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cpr_expiry_date": {
                "Field": "cpr_expiry_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_type": {
                "Field": "customer_type",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_address": {
                "Field": "customer_address",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "client_docs": {
                "Field": "client_docs",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_docs": {
                "Field": "driver_docs",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "register_date": {
                "Field": "register_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "enum('Active','Inactive')",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "updated_on": {
                "Field": "updated_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "document_sequences": {
        "create_sql": "CREATE TABLE `document_sequences` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `doc_type` varchar(50) NOT NULL,\n  `doc_year` int(11) NOT NULL,\n  `company_id` int(11) NOT NULL,\n  `current_number` int(11) NOT NULL,\n  `user_id` int(11) NOT NULL,\n  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`id`)\n) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "doc_type": {
                "Field": "doc_type",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "doc_year": {
                "Field": "doc_year",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "current_number": {
                "Field": "current_number",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "expensevoucher": {
        "create_sql": "CREATE TABLE `expensevoucher` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `expensevoucher_no` varchar(100) DEFAULT NULL,\n  `expensevoucher_date` date DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(150) DEFAULT NULL,\n  `customer_phone` varchar(50) DEFAULT NULL,\n  `customer_email` varchar(150) DEFAULT NULL,\n  `customer_cpr_cr` varchar(200) DEFAULT NULL,\n  `customer_address` text,\n  `contract_ids` int(11) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(200) DEFAULT NULL,\n  `vehicle_ids` int(11) DEFAULT NULL,\n  `vehicle_no` varchar(200) DEFAULT NULL,\n  `model_ids` int(11) DEFAULT NULL,\n  `model_names` varchar(500) DEFAULT NULL,\n  `vehicle_color` varchar(200) DEFAULT NULL,\n  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `allItemSubtotal` decimal(18,5) NOT NULL,\n  `subtotal` decimal(12,5) DEFAULT NULL,\n  `total_discount` decimal(18,2) NOT NULL,\n  `total_discount_amount` decimal(18,4) NOT NULL,\n  `after_discount_amount` decimal(18,4) NOT NULL,\n  `vat_total` decimal(12,5) DEFAULT NULL,\n  `grand_total` decimal(12,5) DEFAULT NULL,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `draft` enum('Yes','No') DEFAULT 'No',\n  `reference_number` varchar(20) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `user_name` varchar(150) DEFAULT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(200) DEFAULT NULL,\n  `expensevoucher_notes` text,\n  `expensevoucher_payment_type` varchar(200) DEFAULT NULL,\n  `expensevoucher_cheque_date` date DEFAULT NULL,\n  `expensevoucher_cheque_ref_no` varchar(200) DEFAULT NULL,\n  `company_signature` varchar(1000) DEFAULT NULL,\n  `company_sign_name` varchar(1000) DEFAULT NULL,\n  `company_sign_date_time` datetime DEFAULT NULL,\n  `customer_signature` varchar(1000) DEFAULT NULL,\n  `customer_sign_name` varchar(1000) DEFAULT NULL,\n  `customer_sign_datetime` datetime DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `quotation_no` (`expensevoucher_no`),\n  UNIQUE KEY `uk_invoice_no` (`expensevoucher_no`),\n  CONSTRAINT `expensevoucher_chk_1` CHECK (json_valid(`items`))\n) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "expensevoucher_no": {
                "Field": "expensevoucher_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "expensevoucher_date": {
                "Field": "expensevoucher_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_phone": {
                "Field": "customer_phone",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_email": {
                "Field": "customer_email",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_cpr_cr": {
                "Field": "customer_cpr_cr",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_address": {
                "Field": "customer_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contract_ids": {
                "Field": "contract_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_ids": {
                "Field": "model_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_names": {
                "Field": "model_names",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_color": {
                "Field": "vehicle_color",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "items": {
                "Field": "items",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "allItemSubtotal": {
                "Field": "allItemSubtotal",
                "Type": "decimal(18,5)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "subtotal": {
                "Field": "subtotal",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount": {
                "Field": "total_discount",
                "Type": "decimal(18,2)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount_amount": {
                "Field": "total_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "after_discount_amount": {
                "Field": "after_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vat_total": {
                "Field": "vat_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "grand_total": {
                "Field": "grand_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "draft": {
                "Field": "draft",
                "Type": "enum('Yes','No')",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "reference_number": {
                "Field": "reference_number",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_name": {
                "Field": "user_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "expensevoucher_notes": {
                "Field": "expensevoucher_notes",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "expensevoucher_payment_type": {
                "Field": "expensevoucher_payment_type",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "expensevoucher_cheque_date": {
                "Field": "expensevoucher_cheque_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "expensevoucher_cheque_ref_no": {
                "Field": "expensevoucher_cheque_ref_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_signature": {
                "Field": "company_signature",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_sign_name": {
                "Field": "company_sign_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_sign_date_time": {
                "Field": "company_sign_date_time",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_signature": {
                "Field": "customer_signature",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_sign_name": {
                "Field": "customer_sign_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_sign_datetime": {
                "Field": "customer_sign_datetime",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "invoices": {
        "create_sql": "CREATE TABLE `invoices` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `invoice_due_date` date DEFAULT NULL,\n  `invoice_no` varchar(100) DEFAULT NULL,\n  `invoice_date` date DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(150) DEFAULT NULL,\n  `customer_phone` varchar(50) DEFAULT NULL,\n  `customer_email` varchar(150) DEFAULT NULL,\n  `customer_cpr_cr` varchar(200) NOT NULL,\n  `customer_address` text,\n  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `allItemSubtotal` decimal(18,5) NOT NULL,\n  `subtotal` decimal(12,5) DEFAULT NULL,\n  `total_discount` decimal(18,2) NOT NULL,\n  `total_discount_amount` decimal(18,4) NOT NULL,\n  `after_discount_amount` decimal(18,4) NOT NULL,\n  `vat_total` decimal(12,5) DEFAULT NULL,\n  `grand_total` decimal(12,5) DEFAULT NULL,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `draft` enum('Yes','No') DEFAULT 'No',\n  `reference_number` varchar(20) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `user_name` varchar(150) DEFAULT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(200) DEFAULT NULL,\n  `attention` text,\n  `lpo_number` varchar(100) DEFAULT NULL,\n  `trn_no` varchar(100) DEFAULT NULL,\n  `quotation_ref_no` varchar(100) DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `quotation_no` (`invoice_no`),\n  UNIQUE KEY `uk_invoice_no` (`invoice_no`),\n  CONSTRAINT `invoices_chk_1` CHECK (json_valid(`items`))\n) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "invoice_due_date": {
                "Field": "invoice_due_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "invoice_no": {
                "Field": "invoice_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "invoice_date": {
                "Field": "invoice_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_phone": {
                "Field": "customer_phone",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_email": {
                "Field": "customer_email",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_cpr_cr": {
                "Field": "customer_cpr_cr",
                "Type": "varchar(200)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_address": {
                "Field": "customer_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "items": {
                "Field": "items",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "allItemSubtotal": {
                "Field": "allItemSubtotal",
                "Type": "decimal(18,5)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "subtotal": {
                "Field": "subtotal",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount": {
                "Field": "total_discount",
                "Type": "decimal(18,2)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount_amount": {
                "Field": "total_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "after_discount_amount": {
                "Field": "after_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vat_total": {
                "Field": "vat_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "grand_total": {
                "Field": "grand_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "draft": {
                "Field": "draft",
                "Type": "enum('Yes','No')",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "reference_number": {
                "Field": "reference_number",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_name": {
                "Field": "user_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "attention": {
                "Field": "attention",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "lpo_number": {
                "Field": "lpo_number",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "trn_no": {
                "Field": "trn_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "quotation_ref_no": {
                "Field": "quotation_ref_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "quotations": {
        "create_sql": "CREATE TABLE `quotations` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `user_prefix` varchar(200) DEFAULT NULL,\n  `quotation_no` varchar(50) DEFAULT NULL,\n  `quotation_date` date DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(150) DEFAULT NULL,\n  `customer_phone` varchar(50) DEFAULT NULL,\n  `customer_email` varchar(150) DEFAULT NULL,\n  `customer_cpr_cr` varchar(200) DEFAULT NULL,\n  `customer_address` text,\n  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `allItemSubtotal` decimal(18,5) NOT NULL,\n  `subtotal` decimal(12,5) DEFAULT NULL,\n  `total_discount` decimal(18,2) NOT NULL,\n  `total_discount_amount` decimal(18,4) NOT NULL,\n  `after_discount_amount` decimal(18,4) NOT NULL,\n  `vat_total` decimal(12,5) DEFAULT NULL,\n  `grand_total` decimal(12,5) DEFAULT NULL,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `draft` enum('Yes','No') DEFAULT 'No',\n  `reference_number` varchar(20) DEFAULT NULL,\n  `user_id` int(11) DEFAULT NULL,\n  `user_name` varchar(150) DEFAULT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(200) DEFAULT NULL,\n  `attention` text,\n  `introduction` longtext,\n  `terms` longtext,\n  `quotation_status` varchar(100) NOT NULL DEFAULT 'Not Approved',\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `quotation_no` (`quotation_no`),\n  CONSTRAINT `quotations_chk_1` CHECK (json_valid(`items`))\n) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "user_prefix": {
                "Field": "user_prefix",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "quotation_no": {
                "Field": "quotation_no",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "quotation_date": {
                "Field": "quotation_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_phone": {
                "Field": "customer_phone",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_email": {
                "Field": "customer_email",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_cpr_cr": {
                "Field": "customer_cpr_cr",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_address": {
                "Field": "customer_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "items": {
                "Field": "items",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "allItemSubtotal": {
                "Field": "allItemSubtotal",
                "Type": "decimal(18,5)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "subtotal": {
                "Field": "subtotal",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount": {
                "Field": "total_discount",
                "Type": "decimal(18,2)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_discount_amount": {
                "Field": "total_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "after_discount_amount": {
                "Field": "after_discount_amount",
                "Type": "decimal(18,4)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vat_total": {
                "Field": "vat_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "grand_total": {
                "Field": "grand_total",
                "Type": "decimal(12,5)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "draft": {
                "Field": "draft",
                "Type": "enum('Yes','No')",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "reference_number": {
                "Field": "reference_number",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_name": {
                "Field": "user_name",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "attention": {
                "Field": "attention",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "introduction": {
                "Field": "introduction",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "terms": {
                "Field": "terms",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "quotation_status": {
                "Field": "quotation_status",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": "Not Approved",
                "Extra": ""
            }
        }
    },
    "shortcut_actions": {
        "create_sql": "CREATE TABLE `shortcut_actions` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `action_name` varchar(50) DEFAULT NULL,\n  `description` varchar(100) DEFAULT NULL,\n  `default_key` varchar(20) DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `action_name` (`action_name`)\n) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "action_name": {
                "Field": "action_name",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "description": {
                "Field": "description",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "default_key": {
                "Field": "default_key",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_banks": {
        "create_sql": "CREATE TABLE `tbl_banks` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `bank_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,\n  `account_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,\n  `company_id` int(11) DEFAULT '1',\n  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`ids`)\n) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "bank_name": {
                "Field": "bank_name",
                "Type": "varchar(255)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "account_no": {
                "Field": "account_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "tbl_company": {
        "create_sql": "CREATE TABLE `tbl_company` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_code` varchar(100) NOT NULL,\n  `company_name` varchar(200) NOT NULL,\n  `company_logo` varchar(1000) NOT NULL DEFAULT 'default.jpg',\n  `status` varchar(10) NOT NULL DEFAULT 'Active',\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `company_code` (`company_code`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_code": {
                "Field": "company_code",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(200)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_logo": {
                "Field": "company_logo",
                "Type": "varchar(1000)",
                "Null": "NO",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(10)",
                "Null": "NO",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_customer_ledger": {
        "create_sql": "CREATE TABLE `tbl_customer_ledger` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `customer_code` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,\n  `quotation_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,\n  `booking_no` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,\n  `trans_date` date NOT NULL,\n  `cheque_date` date DEFAULT NULL,\n  `trans_type` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,\n  `payment_method` enum('Cash','Cheque','BankTransfer','CreditCard','Other','N\/A') COLLATE utf8mb4_general_ci DEFAULT 'N\/A',\n  `bank_id` int(11) DEFAULT NULL,\n  `company_bank_id` int(11) DEFAULT NULL,\n  `debit` decimal(18,5) DEFAULT '0.00000',\n  `credit` decimal(18,5) DEFAULT '0.00000',\n  `ref_no` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,\n  `cheque_status` enum('Pending','Collected','Bounced') COLLATE utf8mb4_general_ci DEFAULT 'Pending',\n  `collected_at` datetime DEFAULT NULL,\n  `description` text COLLATE utf8mb4_general_ci,\n  `user_id` int(11) NOT NULL,\n  `company_id` int(11) NOT NULL,\n  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `booking_ids` int(11) DEFAULT NULL,\n  `contract_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(500) COLLATE utf8mb4_general_ci DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  KEY `idx_customer` (`customer_code`)\n) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "quotation_no": {
                "Field": "quotation_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_no": {
                "Field": "booking_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "trans_date": {
                "Field": "trans_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cheque_date": {
                "Field": "cheque_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "trans_type": {
                "Field": "trans_type",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "payment_method": {
                "Field": "payment_method",
                "Type": "enum('Cash','Cheque','BankTransfer','CreditCard','Other','N\/A')",
                "Null": "YES",
                "Key": "",
                "Default": "N\/A",
                "Extra": ""
            },
            "bank_id": {
                "Field": "bank_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_bank_id": {
                "Field": "company_bank_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "debit": {
                "Field": "debit",
                "Type": "decimal(18,5)",
                "Null": "YES",
                "Key": "",
                "Default": "0.00000",
                "Extra": ""
            },
            "credit": {
                "Field": "credit",
                "Type": "decimal(18,5)",
                "Null": "YES",
                "Key": "",
                "Default": "0.00000",
                "Extra": ""
            },
            "ref_no": {
                "Field": "ref_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cheque_status": {
                "Field": "cheque_status",
                "Type": "enum('Pending','Collected','Bounced')",
                "Null": "YES",
                "Key": "",
                "Default": "Pending",
                "Extra": ""
            },
            "collected_at": {
                "Field": "collected_at",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "description": {
                "Field": "description",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contract_ids": {
                "Field": "contract_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_drivers": {
        "create_sql": "CREATE TABLE `tbl_drivers` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_ids` int(11) DEFAULT NULL,\n  `driver_name` varchar(1000) DEFAULT NULL,\n  `driver_contact_no` varchar(500) DEFAULT NULL,\n  `driver_email_id` varchar(1000) DEFAULT NULL,\n  `driver_cpr_no` varchar(1000) DEFAULT NULL,\n  `driver_cpr_expiry_date` date DEFAULT NULL,\n  `license_no` varchar(1000) DEFAULT NULL,\n  `license_issue_place` varchar(1000) DEFAULT NULL,\n  `license_issue_date` date DEFAULT NULL,\n  `license_expiry_date` date DEFAULT NULL,\n  `driver_address` text,\n  `created_by` varchar(500) DEFAULT NULL,\n  `created_on` datetime DEFAULT NULL,\n  `driver_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `driver_status` varchar(100) DEFAULT 'Active',\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_drivers_chk_1` CHECK (json_valid(`driver_documents`))\n) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_ids": {
                "Field": "company_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_name": {
                "Field": "driver_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_contact_no": {
                "Field": "driver_contact_no",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_email_id": {
                "Field": "driver_email_id",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_cpr_no": {
                "Field": "driver_cpr_no",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_cpr_expiry_date": {
                "Field": "driver_cpr_expiry_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_no": {
                "Field": "license_no",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_issue_place": {
                "Field": "license_issue_place",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_issue_date": {
                "Field": "license_issue_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_expiry_date": {
                "Field": "license_expiry_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_address": {
                "Field": "driver_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_by": {
                "Field": "created_by",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_documents": {
                "Field": "driver_documents",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_status": {
                "Field": "driver_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_garage_services": {
        "create_sql": "CREATE TABLE `tbl_garage_services` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `service_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n  `unit` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `charge_per_unit` decimal(10,2) DEFAULT '0.00',\n  `status` enum('Available','Deactivated') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',\n  `company_id` int(11) DEFAULT '1',\n  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,\n  `created_by` int(11) DEFAULT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "service_name": {
                "Field": "service_name",
                "Type": "varchar(255)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "unit": {
                "Field": "unit",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "charge_per_unit": {
                "Field": "charge_per_unit",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": "0.00",
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "enum('Available','Deactivated')",
                "Null": "YES",
                "Key": "",
                "Default": "Available",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_garages": {
        "create_sql": "CREATE TABLE `tbl_garages` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `garage_code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,\n  `garage_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n  `address` text COLLATE utf8mb4_unicode_ci,\n  `contact_person` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `contact_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `email_id` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `status` enum('Available','Deactivated') COLLATE utf8mb4_unicode_ci DEFAULT 'Available',\n  `company_id` int(11) DEFAULT '1',\n  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,\n  `created_by` int(11) DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `garage_code` (`garage_code`)\n) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "garage_code": {
                "Field": "garage_code",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "garage_name": {
                "Field": "garage_name",
                "Type": "varchar(255)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "address": {
                "Field": "address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contact_person": {
                "Field": "contact_person",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contact_number": {
                "Field": "contact_number",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "email_id": {
                "Field": "email_id",
                "Type": "varchar(150)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "enum('Available','Deactivated')",
                "Null": "YES",
                "Key": "",
                "Default": "Available",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_invoice_billing_schedules": {
        "create_sql": "CREATE TABLE `tbl_invoice_billing_schedules` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `contract_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(100) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `booking_ref_no` varchar(100) DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicle_ids` int(11) DEFAULT NULL,\n  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `contract_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `invoice_schedule_date` date DEFAULT NULL,\n  `invoice_due_date` date DEFAULT NULL,\n  `invoice_amount` decimal(10,3) DEFAULT '0.000',\n  `invoice_period_from` date DEFAULT NULL,\n  `invoice_period_to` date DEFAULT NULL,\n  `log_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `status` varchar(100) DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_invoice_billing_schedules_chk_1` CHECK (json_valid(`customer_details`)),\n  CONSTRAINT `tbl_invoice_billing_schedules_chk_2` CHECK (json_valid(`vehicle_details`)),\n  CONSTRAINT `tbl_invoice_billing_schedules_chk_3` CHECK (json_valid(`contract_details`)),\n  CONSTRAINT `tbl_invoice_billing_schedules_chk_4` CHECK (json_valid(`log_details`))\n) ENGINE=InnoDB DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "contract_ids": {
                "Field": "contract_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ref_no": {
                "Field": "booking_ref_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_details": {
                "Field": "customer_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_details": {
                "Field": "vehicle_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contract_details": {
                "Field": "contract_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "invoice_schedule_date": {
                "Field": "invoice_schedule_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "invoice_due_date": {
                "Field": "invoice_due_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "invoice_amount": {
                "Field": "invoice_amount",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": "0.000",
                "Extra": ""
            },
            "invoice_period_from": {
                "Field": "invoice_period_from",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "invoice_period_to": {
                "Field": "invoice_period_to",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "log_details": {
                "Field": "log_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_ledger_heads": {
        "create_sql": "CREATE TABLE `tbl_ledger_heads` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `head_name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,\n  `head_type` enum('Debit','Credit') COLLATE utf8mb4_general_ci NOT NULL,\n  `is_locked` tinyint(1) DEFAULT '0',\n  `company_id` int(11) DEFAULT '1',\n  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,\n  `violation_fine_type` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'No',\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `head_name` (`head_name`)\n) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "head_name": {
                "Field": "head_name",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "head_type": {
                "Field": "head_type",
                "Type": "enum('Debit','Credit')",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "is_locked": {
                "Field": "is_locked",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": "0",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "timestamp",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "violation_fine_type": {
                "Field": "violation_fine_type",
                "Type": "varchar(10)",
                "Null": "NO",
                "Key": "",
                "Default": "No",
                "Extra": ""
            }
        }
    },
    "tbl_maintenance_request_services": {
        "create_sql": "CREATE TABLE `tbl_maintenance_request_services` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `request_id` int(11) NOT NULL,\n  `service_id` int(11) NOT NULL,\n  `qty` decimal(10,2) DEFAULT '1.00',\n  `cost` decimal(10,3) DEFAULT '0.000',\n  `unit` varchar(50) DEFAULT NULL,\n  `remarks` text,\n  PRIMARY KEY (`ids`),\n  KEY `request_id` (`request_id`),\n  CONSTRAINT `tbl_maintenance_request_services_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `tbl_maintenance_requests` (`ids`) ON DELETE CASCADE\n) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "request_id": {
                "Field": "request_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "service_id": {
                "Field": "service_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "qty": {
                "Field": "qty",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": "1.00",
                "Extra": ""
            },
            "cost": {
                "Field": "cost",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": "0.000",
                "Extra": ""
            },
            "unit": {
                "Field": "unit",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "remarks": {
                "Field": "remarks",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_maintenance_requests": {
        "create_sql": "CREATE TABLE `tbl_maintenance_requests` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `request_no` varchar(100) NOT NULL,\n  `vehicle_id` int(11) NOT NULL,\n  `garage_id` int(11) NOT NULL,\n  `status` varchar(50) DEFAULT 'Pending',\n  `company_id` int(11) DEFAULT NULL,\n  `additional_charges` decimal(10,3) DEFAULT '0.000',\n  `additional_charges_remarks` varchar(255) DEFAULT NULL,\n  `total_cost` decimal(10,3) DEFAULT '0.000',\n  `created_on` datetime DEFAULT NULL,\n  `created_by` int(11) DEFAULT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "request_no": {
                "Field": "request_no",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_id": {
                "Field": "vehicle_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "garage_id": {
                "Field": "garage_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": "Pending",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "additional_charges": {
                "Field": "additional_charges",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": "0.000",
                "Extra": ""
            },
            "additional_charges_remarks": {
                "Field": "additional_charges_remarks",
                "Type": "varchar(255)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "total_cost": {
                "Field": "total_cost",
                "Type": "decimal(10,3)",
                "Null": "YES",
                "Key": "",
                "Default": "0.000",
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_outsourcing_companies": {
        "create_sql": "CREATE TABLE `tbl_outsourcing_companies` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_id` int(11) DEFAULT '1',\n  `company_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n  `cr_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,\n  `address` text COLLATE utf8mb4_unicode_ci,\n  `contact_person_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `contact_person_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `email_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',\n  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,\n  `created_by` int(11) DEFAULT NULL,\n  `updated_on` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,\n  `updated_by` int(11) DEFAULT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(255)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "cr_number": {
                "Field": "cr_number",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "address": {
                "Field": "address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contact_person_name": {
                "Field": "contact_person_name",
                "Type": "varchar(255)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contact_person_number": {
                "Field": "contact_person_number",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "email_id": {
                "Field": "email_id",
                "Type": "varchar(255)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "updated_on": {
                "Field": "updated_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": "on update CURRENT_TIMESTAMP"
            },
            "updated_by": {
                "Field": "updated_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_permissions": {
        "create_sql": "CREATE TABLE `tbl_permissions` (\n  `permission_id` int(11) NOT NULL AUTO_INCREMENT,\n  `permission_name` varchar(200) DEFAULT NULL,\n  `permission_key` varchar(100) DEFAULT NULL,\n  `module_group` varchar(100) DEFAULT 'General',\n  `status` varchar(20) DEFAULT 'Active',\n  PRIMARY KEY (`permission_id`),\n  UNIQUE KEY `uniq_perm_key` (`permission_key`)\n) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=latin1",
        "columns": {
            "permission_id": {
                "Field": "permission_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "permission_name": {
                "Field": "permission_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "permission_key": {
                "Field": "permission_key",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "module_group": {
                "Field": "module_group",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "General",
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_quotation_introduction": {
        "create_sql": "CREATE TABLE `tbl_quotation_introduction` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `intrn_title` varchar(500) DEFAULT NULL,\n  `intrn_content` longtext,\n  `company_id` int(11) DEFAULT NULL,\n  `user_id` int(11) NOT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "intrn_title": {
                "Field": "intrn_title",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "intrn_content": {
                "Field": "intrn_content",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_role_permissions": {
        "create_sql": "CREATE TABLE `tbl_role_permissions` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `role_id` int(11) NOT NULL,\n  `permission_id` int(11) NOT NULL,\n  `status` varchar(20) NOT NULL DEFAULT 'Granted',\n  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `uniq_role_perm` (`role_id`,`permission_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "role_id": {
                "Field": "role_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "permission_id": {
                "Field": "permission_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "",
                "Default": "Granted",
                "Extra": ""
            },
            "updated_date": {
                "Field": "updated_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "tbl_roles": {
        "create_sql": "CREATE TABLE `tbl_roles` (\n  `role_id` int(11) NOT NULL AUTO_INCREMENT,\n  `role_name` varchar(100) NOT NULL,\n  `status` varchar(20) NOT NULL DEFAULT 'Active',\n  PRIMARY KEY (`role_id`)\n) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1",
        "columns": {
            "role_id": {
                "Field": "role_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "role_name": {
                "Field": "role_name",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_service_type": {
        "create_sql": "CREATE TABLE `tbl_service_type` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `service_type` varchar(500) DEFAULT NULL,\n  `vat_perct` decimal(10,2) DEFAULT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "service_type": {
                "Field": "service_type",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vat_perct": {
                "Field": "vat_perct",
                "Type": "decimal(10,2)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_staff": {
        "create_sql": "CREATE TABLE `tbl_staff` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_ids` int(11) DEFAULT NULL,\n  `staff_name` varchar(1000) DEFAULT NULL,\n  `staff_contact_no` varchar(500) DEFAULT NULL,\n  `staff_email_id` varchar(1000) DEFAULT NULL,\n  `staff_cpr_no` varchar(1000) DEFAULT NULL,\n  `staff_cpr_expiry_date` date DEFAULT NULL,\n  `license_no` varchar(1000) DEFAULT NULL,\n  `license_issue_place` varchar(1000) DEFAULT NULL,\n  `license_issue_date` date DEFAULT NULL,\n  `license_expiry_date` date DEFAULT NULL,\n  `staff_address` text,\n  `created_by` varchar(500) DEFAULT NULL,\n  `created_on` datetime DEFAULT NULL,\n  `staff_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `staff_status` varchar(100) DEFAULT 'Active',\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_staff_chk_1` CHECK (json_valid(`staff_documents`))\n) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_ids": {
                "Field": "company_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_name": {
                "Field": "staff_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_contact_no": {
                "Field": "staff_contact_no",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_email_id": {
                "Field": "staff_email_id",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_cpr_no": {
                "Field": "staff_cpr_no",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_cpr_expiry_date": {
                "Field": "staff_cpr_expiry_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_no": {
                "Field": "license_no",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_issue_place": {
                "Field": "license_issue_place",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_issue_date": {
                "Field": "license_issue_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "license_expiry_date": {
                "Field": "license_expiry_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_address": {
                "Field": "staff_address",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_by": {
                "Field": "created_by",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_documents": {
                "Field": "staff_documents",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_status": {
                "Field": "staff_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_system_settings": {
        "create_sql": "CREATE TABLE `tbl_system_settings` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `company_id` int(11) NOT NULL DEFAULT '1',\n  `vat_percentage` decimal(5,2) NOT NULL DEFAULT '10.00',\n  `timezone` varchar(100) NOT NULL DEFAULT 'Asia\/Bahrain',\n  `date_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',\n  `currency_code` varchar(10) NOT NULL DEFAULT 'BHD',\n  `currency_symbol` varchar(20) NOT NULL DEFAULT 'BD',\n  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n  `updated_by` int(11) DEFAULT '1',\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `idx_company` (`company_id`)\n) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "UNI",
                "Default": "1",
                "Extra": ""
            },
            "vat_percentage": {
                "Field": "vat_percentage",
                "Type": "decimal(5,2)",
                "Null": "NO",
                "Key": "",
                "Default": "10.00",
                "Extra": ""
            },
            "timezone": {
                "Field": "timezone",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": "Asia\/Bahrain",
                "Extra": ""
            },
            "date_format": {
                "Field": "date_format",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "",
                "Default": "Y-m-d",
                "Extra": ""
            },
            "currency_code": {
                "Field": "currency_code",
                "Type": "varchar(10)",
                "Null": "NO",
                "Key": "",
                "Default": "BHD",
                "Extra": ""
            },
            "currency_symbol": {
                "Field": "currency_symbol",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "",
                "Default": "BD",
                "Extra": ""
            },
            "updated_at": {
                "Field": "updated_at",
                "Type": "timestamp",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED on update CURRENT_TIMESTAMP"
            },
            "updated_by": {
                "Field": "updated_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "1",
                "Extra": ""
            }
        }
    },
    "tbl_terms_and_condition": {
        "create_sql": "CREATE TABLE `tbl_terms_and_condition` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `terms_condition` longtext NOT NULL,\n  `t_c_name` varchar(500) DEFAULT NULL,\n  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `status` tinyint(4) NOT NULL DEFAULT '1',\n  `company_id` int(11) NOT NULL,\n  `user_id` int(11) NOT NULL,\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "terms_condition": {
                "Field": "terms_condition",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "t_c_name": {
                "Field": "t_c_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "status": {
                "Field": "status",
                "Type": "tinyint(4)",
                "Null": "NO",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_terms_and_condition_contract": {
        "create_sql": "CREATE TABLE `tbl_terms_and_condition_contract` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `terms_condition` longtext NOT NULL,\n  `t_c_name` varchar(500) DEFAULT NULL,\n  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `status` tinyint(4) NOT NULL DEFAULT '1',\n  `company_id` int(11) NOT NULL,\n  `user_id` int(11) NOT NULL,\n  `is_default` tinyint(1) DEFAULT '0',\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "terms_condition": {
                "Field": "terms_condition",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "t_c_name": {
                "Field": "t_c_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_at": {
                "Field": "created_at",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "status": {
                "Field": "status",
                "Type": "tinyint(4)",
                "Null": "NO",
                "Key": "",
                "Default": "1",
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "is_default": {
                "Field": "is_default",
                "Type": "tinyint(1)",
                "Null": "YES",
                "Key": "",
                "Default": "0",
                "Extra": ""
            }
        }
    },
    "tbl_user_permissions": {
        "create_sql": "CREATE TABLE `tbl_user_permissions` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `user_id` int(11) NOT NULL,\n  `permission_id` int(11) NOT NULL,\n  `status` varchar(20) NOT NULL DEFAULT 'Granted',\n  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `uniq_user_perm` (`user_id`,`permission_id`)\n) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "permission_id": {
                "Field": "permission_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "status": {
                "Field": "status",
                "Type": "varchar(20)",
                "Null": "NO",
                "Key": "",
                "Default": "Granted",
                "Extra": ""
            },
            "updated_date": {
                "Field": "updated_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "tbl_users": {
        "create_sql": "CREATE TABLE `tbl_users` (\n  `user_id` int(11) NOT NULL AUTO_INCREMENT,\n  `profile_name` varchar(500) DEFAULT NULL,\n  `user_name` varchar(100) DEFAULT NULL,\n  `user_passkey` varchar(100) DEFAULT NULL,\n  `user_role_id` varchar(100) DEFAULT NULL,\n  `user_role_name` varchar(255) DEFAULT NULL,\n  `company_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `user_mobile` varchar(100) DEFAULT NULL,\n  `user_email` varchar(500) DEFAULT NULL,\n  `profile_image` varchar(1000) NOT NULL DEFAULT 'profile.jpg',\n  `user_status` varchar(50) DEFAULT 'Active',\n  `created_date` date NOT NULL,\n  PRIMARY KEY (`user_id`),\n  UNIQUE KEY `idx_unique_user_name` (`user_name`),\n  CONSTRAINT `tbl_users_chk_1` CHECK (json_valid(`company_json`))\n) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1",
        "columns": {
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "profile_name": {
                "Field": "profile_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_name": {
                "Field": "user_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "user_passkey": {
                "Field": "user_passkey",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_role_id": {
                "Field": "user_role_id",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_role_name": {
                "Field": "user_role_name",
                "Type": "varchar(255)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_json": {
                "Field": "company_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_mobile": {
                "Field": "user_mobile",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_email": {
                "Field": "user_email",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "profile_image": {
                "Field": "profile_image",
                "Type": "varchar(1000)",
                "Null": "NO",
                "Key": "",
                "Default": "profile.jpg",
                "Extra": ""
            },
            "user_status": {
                "Field": "user_status",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "created_date": {
                "Field": "created_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_bookings": {
        "create_sql": "CREATE TABLE `tbl_vehicle_bookings` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `booking_no` varchar(100) DEFAULT NULL,\n  `category_id` int(11) DEFAULT NULL,\n  `category_name` varchar(100) DEFAULT NULL,\n  `brand_id` int(11) DEFAULT NULL,\n  `brand_name` varchar(100) DEFAULT NULL,\n  `model_id` int(11) DEFAULT NULL,\n  `model_name` varchar(100) DEFAULT NULL,\n  `vehicle_id` int(11) DEFAULT NULL,\n  `vehicle_no` varchar(100) DEFAULT NULL,\n  `book_through` varchar(100) DEFAULT NULL,\n  `quotation_number` varchar(100) DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(500) DEFAULT NULL,\n  `customer_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `book_from_date` datetime NOT NULL,\n  `book_to_date` datetime DEFAULT NULL,\n  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `book_status` varchar(100) DEFAULT NULL,\n  `company_id` int(11) NOT NULL,\n  `user_id` int(11) NOT NULL,\n  `created_date` datetime NOT NULL,\n  `modified_date` datetime NOT NULL,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_bookings_chk_1` CHECK (json_valid(`customer_details_json`)),\n  CONSTRAINT `tbl_vehicle_bookings_chk_2` CHECK (json_valid(`book_details_json`))\n) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "booking_no": {
                "Field": "booking_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_name": {
                "Field": "category_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_name": {
                "Field": "brand_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_id": {
                "Field": "model_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_name": {
                "Field": "model_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_id": {
                "Field": "vehicle_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_through": {
                "Field": "book_through",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "quotation_number": {
                "Field": "quotation_number",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_details_json": {
                "Field": "customer_details_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_from_date": {
                "Field": "book_from_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_to_date": {
                "Field": "book_to_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_details_json": {
                "Field": "book_details_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_status": {
                "Field": "book_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_date": {
                "Field": "created_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "modified_date": {
                "Field": "modified_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_brand": {
        "create_sql": "CREATE TABLE `tbl_vehicle_brand` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `brand_name` varchar(200) DEFAULT NULL,\n  `brand_description` text,\n  `brand_status` varchar(100) DEFAULT 'Active',\n  `brand_image` varchar(500) DEFAULT 'default.jpg',\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "brand_name": {
                "Field": "brand_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_description": {
                "Field": "brand_description",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_status": {
                "Field": "brand_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "brand_image": {
                "Field": "brand_image",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_category": {
        "create_sql": "CREATE TABLE `tbl_vehicle_category` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `category_name` varchar(200) DEFAULT NULL,\n  `category_image` varchar(100) NOT NULL DEFAULT 'default.jpg',\n  `category_description` text NOT NULL,\n  `category_status` varchar(50) NOT NULL DEFAULT 'Active',\n  PRIMARY KEY (`ids`)\n) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "category_name": {
                "Field": "category_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_image": {
                "Field": "category_image",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            },
            "category_description": {
                "Field": "category_description",
                "Type": "text",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_status": {
                "Field": "category_status",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_contract_extensions": {
        "create_sql": "CREATE TABLE `tbl_vehicle_contract_extensions` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_id` int(11) DEFAULT NULL,\n  `agreement_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(200) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `vehicle_ids` int(11) DEFAULT NULL,\n  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `extension_date` date DEFAULT NULL,\n  `extend_start_date` datetime DEFAULT NULL,\n  `extend_end_date` datetime DEFAULT NULL,\n  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_contract_extensions_chk_1` CHECK (json_valid(`customer_details`)),\n  CONSTRAINT `tbl_vehicle_contract_extensions_chk_2` CHECK (json_valid(`vehicle_details`)),\n  CONSTRAINT `tbl_vehicle_contract_extensions_chk_3` CHECK (json_valid(`otp_details`)),\n  CONSTRAINT `tbl_vehicle_contract_extensions_chk_4` CHECK (json_valid(`extend_log_json`))\n) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_ids": {
                "Field": "agreement_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_details": {
                "Field": "customer_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_details": {
                "Field": "vehicle_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extension_date": {
                "Field": "extension_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_start_date": {
                "Field": "extend_start_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_end_date": {
                "Field": "extend_end_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_details": {
                "Field": "extend_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "otp_details": {
                "Field": "otp_details",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_log_json": {
                "Field": "extend_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_contract_replacement": {
        "create_sql": "CREATE TABLE `tbl_vehicle_contract_replacement` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_id` int(11) DEFAULT NULL,\n  `agreement_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(200) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `vehicle_ids` int(11) DEFAULT NULL,\n  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicle_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `extension_date` date DEFAULT NULL,\n  `extend_start_date` datetime DEFAULT NULL,\n  `extend_end_date` datetime DEFAULT NULL,\n  `extend_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `extend_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_contract_replacement_chk_1` CHECK (json_valid(`customer_details`)),\n  CONSTRAINT `tbl_vehicle_contract_replacement_chk_2` CHECK (json_valid(`vehicle_details`)),\n  CONSTRAINT `tbl_vehicle_contract_replacement_chk_3` CHECK (json_valid(`otp_details`)),\n  CONSTRAINT `tbl_vehicle_contract_replacement_chk_4` CHECK (json_valid(`extend_log_json`))\n) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_ids": {
                "Field": "agreement_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_details": {
                "Field": "customer_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_details": {
                "Field": "vehicle_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extension_date": {
                "Field": "extension_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_start_date": {
                "Field": "extend_start_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_end_date": {
                "Field": "extend_end_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_details": {
                "Field": "extend_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "otp_details": {
                "Field": "otp_details",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_log_json": {
                "Field": "extend_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_log_movement": {
        "create_sql": "CREATE TABLE `tbl_vehicle_log_movement` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `vehicle_ids` int(11) NOT NULL,\n  `vehicle_no` varchar(50) NOT NULL,\n  `log_datetime` datetime NOT NULL,\n  `action_type` varchar(50) NOT NULL,\n  `old_status` varchar(50) DEFAULT NULL,\n  `new_status` varchar(50) DEFAULT NULL,\n  `reference_type` varchar(50) DEFAULT NULL,\n  `reference_id` int(11) DEFAULT NULL,\n  `reference_no` varchar(100) DEFAULT NULL,\n  `location_from` varchar(100) DEFAULT NULL,\n  `location_to` varchar(100) DEFAULT NULL,\n  `staff_id` int(11) DEFAULT NULL,\n  `customer_id` varchar(100) DEFAULT NULL,\n  `garage_id` int(11) DEFAULT NULL,\n  `odometer` int(11) DEFAULT NULL,\n  `fuel_level` varchar(30) DEFAULT NULL,\n  `remarks` text,\n  `created_by` int(11) DEFAULT NULL,\n  `created_name` varchar(100) DEFAULT NULL,\n  `created_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,\n  PRIMARY KEY (`ids`),\n  KEY `idx_vehicle` (`vehicle_ids`),\n  KEY `idx_datetime` (`log_datetime`),\n  KEY `idx_action` (`action_type`),\n  KEY `idx_reference` (`reference_type`,`reference_id`),\n  KEY `idx_staff` (`staff_id`),\n  KEY `idx_customer` (`customer_id`),\n  KEY `idx_garage` (`garage_id`)\n) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "vehicle_ids": {
                "Field": "vehicle_ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "log_datetime": {
                "Field": "log_datetime",
                "Type": "datetime",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "action_type": {
                "Field": "action_type",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "old_status": {
                "Field": "old_status",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "new_status": {
                "Field": "new_status",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "reference_type": {
                "Field": "reference_type",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "reference_id": {
                "Field": "reference_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "reference_no": {
                "Field": "reference_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "location_from": {
                "Field": "location_from",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "location_to": {
                "Field": "location_to",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_id": {
                "Field": "staff_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "customer_id": {
                "Field": "customer_id",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "garage_id": {
                "Field": "garage_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "odometer": {
                "Field": "odometer",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "fuel_level": {
                "Field": "fuel_level",
                "Type": "varchar(30)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "remarks": {
                "Field": "remarks",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_name": {
                "Field": "created_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "timestamp",
                "Null": "YES",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            }
        }
    },
    "tbl_vehicle_model": {
        "create_sql": "CREATE TABLE `tbl_vehicle_model` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `category_id` int(11) DEFAULT NULL,\n  `brand_id` int(11) DEFAULT NULL,\n  `modal_name` varchar(200) DEFAULT NULL,\n  `vehicle_modal_pic` varchar(2000) NOT NULL DEFAULT 'default.jpg',\n  `model_status` varchar(100) DEFAULT 'Active',\n  `model_description` text,\n  `price_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_model_chk_1` CHECK (json_valid(`price_json`))\n) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "modal_name": {
                "Field": "modal_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_modal_pic": {
                "Field": "vehicle_modal_pic",
                "Type": "varchar(2000)",
                "Null": "NO",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            },
            "model_status": {
                "Field": "model_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "model_description": {
                "Field": "model_description",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "price_json": {
                "Field": "price_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_non_revenue_ticket": {
        "create_sql": "CREATE TABLE `tbl_vehicle_non_revenue_ticket` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `booking_no` varchar(100) DEFAULT NULL,\n  `category_id` int(11) DEFAULT NULL,\n  `category_name` varchar(100) DEFAULT NULL,\n  `brand_id` int(11) DEFAULT NULL,\n  `brand_name` varchar(100) DEFAULT NULL,\n  `model_id` int(11) DEFAULT NULL,\n  `model_name` varchar(100) DEFAULT NULL,\n  `vehicle_id` int(11) DEFAULT NULL,\n  `vehicle_no` varchar(100) DEFAULT NULL,\n  `staff_ids` int(11) DEFAULT NULL,\n  `staff_name` varchar(500) DEFAULT NULL,\n  `staff_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `book_from_date` datetime NOT NULL,\n  `book_to_date` datetime DEFAULT NULL,\n  `notes` text,\n  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `book_status` varchar(100) DEFAULT NULL,\n  `return_notes` text,\n  `company_id` int(11) NOT NULL,\n  `user_id` int(11) NOT NULL,\n  `created_date` datetime NOT NULL,\n  `modified_date` datetime NOT NULL,\n  `modified_id` int(11) DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_non_revenue_ticket_chk_1` CHECK (json_valid(`book_details_json`))\n) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "booking_no": {
                "Field": "booking_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_name": {
                "Field": "category_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_name": {
                "Field": "brand_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_id": {
                "Field": "model_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_name": {
                "Field": "model_name",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_id": {
                "Field": "vehicle_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_ids": {
                "Field": "staff_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_name": {
                "Field": "staff_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "staff_details_json": {
                "Field": "staff_details_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_from_date": {
                "Field": "book_from_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_to_date": {
                "Field": "book_to_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "notes": {
                "Field": "notes",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_details_json": {
                "Field": "book_details_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "book_status": {
                "Field": "book_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "return_notes": {
                "Field": "return_notes",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_date": {
                "Field": "created_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "modified_date": {
                "Field": "modified_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "modified_id": {
                "Field": "modified_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_pricing_master": {
        "create_sql": "CREATE TABLE `tbl_vehicle_pricing_master` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `price_item` varchar(1000) DEFAULT NULL,\n  `price_status` varchar(100) DEFAULT 'Active',\n  `ledger_status` varchar(50) NOT NULL DEFAULT 'Yes',\n  PRIMARY KEY (`ids`)\n) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "price_item": {
                "Field": "price_item",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "price_status": {
                "Field": "price_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "ledger_status": {
                "Field": "ledger_status",
                "Type": "varchar(50)",
                "Null": "NO",
                "Key": "",
                "Default": "Yes",
                "Extra": ""
            }
        }
    },
    "tbl_vehicle_rentout_contracts": {
        "create_sql": "CREATE TABLE `tbl_vehicle_rentout_contracts` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `company_id` int(11) DEFAULT NULL,\n  `booking_ids` int(11) DEFAULT NULL,\n  `agreement_no` varchar(100) DEFAULT NULL,\n  `agreement_group_ref_no` varchar(100) DEFAULT NULL,\n  `agreement_date` date DEFAULT NULL,\n  `customer_code` varchar(100) DEFAULT NULL,\n  `customer_name` varchar(500) DEFAULT NULL,\n  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `quotation_number` varchar(200) NOT NULL,\n  `vehicle_category_id` int(11) DEFAULT NULL,\n  `vehicle_model_id` int(11) DEFAULT NULL,\n  `vehicle_id` int(11) DEFAULT NULL,\n  `vehicle_no` varchar(100) DEFAULT NULL,\n  `vechile_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `service_type` varchar(100) DEFAULT NULL,\n  `service_start_date_time` datetime DEFAULT NULL,\n  `service_end_date_time` datetime DEFAULT NULL,\n  `contract_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `km_in` decimal(18,3) DEFAULT NULL,\n  `km_out` decimal(18,3) DEFAULT NULL,\n  `km_used` decimal(18,3) DEFAULT NULL,\n  `vehicle_accessories_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `extend_date` date DEFAULT NULL,\n  `lease_period` int(11) DEFAULT NULL,\n  `return_date` datetime DEFAULT NULL,\n  `remarks1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `remarks2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `terms_condition` longtext,\n  `vehicle_rentout_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `driver_status` varchar(100) DEFAULT NULL,\n  `driver_ids` int(11) DEFAULT NULL,\n  `driver_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `customer_driver_name` varchar(1000) DEFAULT NULL,\n  `customer_driver_contact_number` varchar(100) DEFAULT NULL,\n  `customer_driver_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `received_by` varchar(200) DEFAULT NULL,\n  `delivered_by` varchar(200) DEFAULT NULL,\n  `hirer_signature` varchar(2000) DEFAULT NULL,\n  `hirer_name` varchar(1000) DEFAULT NULL,\n  `hirer_signature_date` datetime DEFAULT NULL,\n  `hier_signature_status` varchar(20) DEFAULT 'No',\n  `hirer_signed_ip` varchar(200) DEFAULT NULL,\n  `hirer_signed_device` varchar(200) DEFAULT NULL,\n  `delivered_signature_status` varchar(100) DEFAULT 'No',\n  `delivered_signature` varchar(2000) DEFAULT NULL,\n  `delivered_signatory` varchar(1000) DEFAULT NULL,\n  `delivered_signature_date` datetime DEFAULT NULL,\n  `delivered_signed_ip` varchar(200) DEFAULT NULL,\n  `delivered_signed_device` varchar(200) DEFAULT NULL,\n  `minprice_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `agreement_status` varchar(100) DEFAULT 'Generated',\n  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `receiver_name` varchar(1000) DEFAULT NULL,\n  `receiver_signature` varchar(1000) DEFAULT NULL,\n  `receiver_signature_datetime` datetime DEFAULT NULL,\n  `receiver_signed_device` varchar(1000) DEFAULT NULL,\n  `receiver_signed_ip` varchar(100) DEFAULT NULL,\n  `return_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicle_return_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `close_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `close_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `violations_json` longtext,\n  `replaced_vehicle_json` longtext,\n  PRIMARY KEY (`ids`),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_1` CHECK (json_valid(`customer_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_10` CHECK (json_valid(`minprice_otp_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_11` CHECK (json_valid(`log_json`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_12` CHECK (json_valid(`rentout_log_json`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_13` CHECK (json_valid(`return_log_json`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_14` CHECK (json_valid(`vehicle_return_images`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_15` CHECK (json_valid(`close_log_json`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_16` CHECK (json_valid(`close_otp_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_2` CHECK (json_valid(`vechile_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_3` CHECK (json_valid(`contract_details_json`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_4` CHECK (json_valid(`vehicle_accessories_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_5` CHECK (json_valid(`remarks1`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_6` CHECK (json_valid(`remarks2`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_7` CHECK (json_valid(`vehicle_rentout_images`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_8` CHECK (json_valid(`driver_details`)),\n  CONSTRAINT `tbl_vehicle_rentout_contracts_chk_9` CHECK (json_valid(`customer_driver_attachments`))\n) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "booking_ids": {
                "Field": "booking_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_no": {
                "Field": "agreement_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_group_ref_no": {
                "Field": "agreement_group_ref_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_date": {
                "Field": "agreement_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_code": {
                "Field": "customer_code",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_name": {
                "Field": "customer_name",
                "Type": "varchar(500)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_details": {
                "Field": "customer_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "quotation_number": {
                "Field": "quotation_number",
                "Type": "varchar(200)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_category_id": {
                "Field": "vehicle_category_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_model_id": {
                "Field": "vehicle_model_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_id": {
                "Field": "vehicle_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_no": {
                "Field": "vehicle_no",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vechile_details": {
                "Field": "vechile_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "service_type": {
                "Field": "service_type",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "service_start_date_time": {
                "Field": "service_start_date_time",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "service_end_date_time": {
                "Field": "service_end_date_time",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "contract_details_json": {
                "Field": "contract_details_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "km_in": {
                "Field": "km_in",
                "Type": "decimal(18,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "km_out": {
                "Field": "km_out",
                "Type": "decimal(18,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "km_used": {
                "Field": "km_used",
                "Type": "decimal(18,3)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_accessories_details": {
                "Field": "vehicle_accessories_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "extend_date": {
                "Field": "extend_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "lease_period": {
                "Field": "lease_period",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "return_date": {
                "Field": "return_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "remarks1": {
                "Field": "remarks1",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "remarks2": {
                "Field": "remarks2",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "terms_condition": {
                "Field": "terms_condition",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_rentout_images": {
                "Field": "vehicle_rentout_images",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_status": {
                "Field": "driver_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_ids": {
                "Field": "driver_ids",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "driver_details": {
                "Field": "driver_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_driver_name": {
                "Field": "customer_driver_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_driver_contact_number": {
                "Field": "customer_driver_contact_number",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "customer_driver_attachments": {
                "Field": "customer_driver_attachments",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "received_by": {
                "Field": "received_by",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_by": {
                "Field": "delivered_by",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "hirer_signature": {
                "Field": "hirer_signature",
                "Type": "varchar(2000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "hirer_name": {
                "Field": "hirer_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "hirer_signature_date": {
                "Field": "hirer_signature_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "hier_signature_status": {
                "Field": "hier_signature_status",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "hirer_signed_ip": {
                "Field": "hirer_signed_ip",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "hirer_signed_device": {
                "Field": "hirer_signed_device",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_signature_status": {
                "Field": "delivered_signature_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "delivered_signature": {
                "Field": "delivered_signature",
                "Type": "varchar(2000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_signatory": {
                "Field": "delivered_signatory",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_signature_date": {
                "Field": "delivered_signature_date",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_signed_ip": {
                "Field": "delivered_signed_ip",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "delivered_signed_device": {
                "Field": "delivered_signed_device",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "minprice_otp_details": {
                "Field": "minprice_otp_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "log_json": {
                "Field": "log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "agreement_status": {
                "Field": "agreement_status",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "Generated",
                "Extra": ""
            },
            "rentout_log_json": {
                "Field": "rentout_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "receiver_name": {
                "Field": "receiver_name",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "receiver_signature": {
                "Field": "receiver_signature",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "receiver_signature_datetime": {
                "Field": "receiver_signature_datetime",
                "Type": "datetime",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "receiver_signed_device": {
                "Field": "receiver_signed_device",
                "Type": "varchar(1000)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "receiver_signed_ip": {
                "Field": "receiver_signed_ip",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "return_log_json": {
                "Field": "return_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_return_images": {
                "Field": "vehicle_return_images",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "close_log_json": {
                "Field": "close_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "close_otp_details": {
                "Field": "close_otp_details",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "violations_json": {
                "Field": "violations_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "replaced_vehicle_json": {
                "Field": "replaced_vehicle_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "tbl_vehicles": {
        "create_sql": "CREATE TABLE `tbl_vehicles` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `category_id` int(11) NOT NULL,\n  `model_id` int(11) NOT NULL,\n  `model_names` varchar(1000) NOT NULL,\n  `brand_id` int(11) NOT NULL,\n  `company_id` int(11) NOT NULL,\n  `vehicle_number` varchar(100) NOT NULL,\n  `chassis_number` varchar(100) DEFAULT NULL,\n  `vehicle_year` int(11) NOT NULL,\n  `vehicle_color` varchar(100) NOT NULL,\n  `image_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `other_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `vehicle_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `vehicle_status` varchar(100) NOT NULL,\n  `is_outsourced` enum('Yes','No') DEFAULT 'No',\n  `outsourcing_company_id` int(11) DEFAULT '0',\n  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,\n  `created_by` int(11) NOT NULL,\n  `vehicle_purchase_date` date NOT NULL,\n  `next_passing_date` date DEFAULT NULL,\n  `passing_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `next_insurance_date` date DEFAULT NULL,\n  `insurance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `next_maintenance_date` date DEFAULT NULL,\n  `maintenance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `rentout_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  `vehicle_status_notes` text,\n  `vehicle_status_log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,\n  PRIMARY KEY (`ids`),\n  UNIQUE KEY `chassis_number` (`chassis_number`),\n  CONSTRAINT `tbl_vehicles_chk_1` CHECK (json_valid(`image_json`)),\n  CONSTRAINT `tbl_vehicles_chk_2` CHECK (json_valid(`other_details_json`)),\n  CONSTRAINT `tbl_vehicles_chk_3` CHECK (json_valid(`vehicle_attachments`)),\n  CONSTRAINT `tbl_vehicles_chk_4` CHECK (json_valid(`passing_histroy`)),\n  CONSTRAINT `tbl_vehicles_chk_5` CHECK (json_valid(`insurance_histroy`)),\n  CONSTRAINT `tbl_vehicles_chk_6` CHECK (json_valid(`maintenance_histroy`)),\n  CONSTRAINT `tbl_vehicles_chk_7` CHECK (json_valid(`rentout_log_json`)),\n  CONSTRAINT `tbl_vehicles_chk_8` CHECK (json_valid(`vehicle_status_log_json`))\n) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_id": {
                "Field": "model_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_names": {
                "Field": "model_names",
                "Type": "varchar(1000)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_number": {
                "Field": "vehicle_number",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "chassis_number": {
                "Field": "chassis_number",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "UNI",
                "Default": null,
                "Extra": ""
            },
            "vehicle_year": {
                "Field": "vehicle_year",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_color": {
                "Field": "vehicle_color",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "image_json": {
                "Field": "image_json",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "other_details_json": {
                "Field": "other_details_json",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_attachments": {
                "Field": "vehicle_attachments",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_status": {
                "Field": "vehicle_status",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "is_outsourced": {
                "Field": "is_outsourced",
                "Type": "enum('Yes','No')",
                "Null": "YES",
                "Key": "",
                "Default": "No",
                "Extra": ""
            },
            "outsourcing_company_id": {
                "Field": "outsourcing_company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": "0",
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_purchase_date": {
                "Field": "vehicle_purchase_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_passing_date": {
                "Field": "next_passing_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "passing_histroy": {
                "Field": "passing_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_insurance_date": {
                "Field": "next_insurance_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "insurance_histroy": {
                "Field": "insurance_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_maintenance_date": {
                "Field": "next_maintenance_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "maintenance_histroy": {
                "Field": "maintenance_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "rentout_log_json": {
                "Field": "rentout_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_status_notes": {
                "Field": "vehicle_status_notes",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_status_log_json": {
                "Field": "vehicle_status_log_json",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "user_shortcuts": {
        "create_sql": "CREATE TABLE `user_shortcuts` (\n  `id` int(11) NOT NULL AUTO_INCREMENT,\n  `user_id` int(11) DEFAULT NULL,\n  `action_name` varchar(50) DEFAULT NULL,\n  `shortcut_key` varchar(20) DEFAULT NULL,\n  PRIMARY KEY (`id`),\n  UNIQUE KEY `user_id` (`user_id`,`action_name`)\n) ENGINE=MyISAM DEFAULT CHARSET=latin1",
        "columns": {
            "id": {
                "Field": "id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "user_id": {
                "Field": "user_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "MUL",
                "Default": null,
                "Extra": ""
            },
            "action_name": {
                "Field": "action_name",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "shortcut_key": {
                "Field": "shortcut_key",
                "Type": "varchar(20)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "vehicles": {
        "create_sql": "CREATE TABLE `vehicles` (\n  `ids` int(11) NOT NULL AUTO_INCREMENT,\n  `vehicles_name` varchar(200) NOT NULL,\n  `vehicles_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,\n  `vehicles_status` varchar(25) NOT NULL DEFAULT 'Available',\n  `vehicles_number` int(11) NOT NULL,\n  `vehicles_passing_date` date NOT NULL,\n  `vehicles_insurance_date` datetime NOT NULL,\n  `vehicles_purchase_date` date NOT NULL,\n  `vehicles_modal` int(11) NOT NULL,\n  `category` varchar(200) NOT NULL,\n  `company_id` int(11) DEFAULT NULL,\n  `company_name` varchar(300) DEFAULT NULL,\n  PRIMARY KEY (`ids`),\n  KEY `idx_vehicle_status` (`vehicles_status`,`company_id`),\n  CONSTRAINT `vehicles_chk_1` CHECK (json_valid(`vehicles_details`))\n) ENGINE=MyISAM DEFAULT CHARSET=latin1",
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "PRI",
                "Default": null,
                "Extra": "auto_increment"
            },
            "vehicles_name": {
                "Field": "vehicles_name",
                "Type": "varchar(200)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_details": {
                "Field": "vehicles_details",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_status": {
                "Field": "vehicles_status",
                "Type": "varchar(25)",
                "Null": "NO",
                "Key": "MUL",
                "Default": "Available",
                "Extra": ""
            },
            "vehicles_number": {
                "Field": "vehicles_number",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_passing_date": {
                "Field": "vehicles_passing_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_insurance_date": {
                "Field": "vehicles_insurance_date",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_purchase_date": {
                "Field": "vehicles_purchase_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicles_modal": {
                "Field": "vehicles_modal",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category": {
                "Field": "category",
                "Type": "varchar(200)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_name": {
                "Field": "company_name",
                "Type": "varchar(300)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "view_vehicle_details": {
        "create_sql": null,
        "columns": {
            "ids": {
                "Field": "ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": "0",
                "Extra": ""
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_name": {
                "Field": "category_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_name": {
                "Field": "brand_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_id": {
                "Field": "model_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_name": {
                "Field": "model_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "model_names": {
                "Field": "model_names",
                "Type": "varchar(1000)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "company_id": {
                "Field": "company_id",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_number": {
                "Field": "vehicle_number",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_year": {
                "Field": "vehicle_year",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_color": {
                "Field": "vehicle_color",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "image_json": {
                "Field": "image_json",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "other_details_json": {
                "Field": "other_details_json",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_attachments": {
                "Field": "vehicle_attachments",
                "Type": "longtext",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_status": {
                "Field": "vehicle_status",
                "Type": "varchar(100)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "created_on": {
                "Field": "created_on",
                "Type": "datetime",
                "Null": "NO",
                "Key": "",
                "Default": "CURRENT_TIMESTAMP",
                "Extra": "DEFAULT_GENERATED"
            },
            "created_by": {
                "Field": "created_by",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_purchase_date": {
                "Field": "vehicle_purchase_date",
                "Type": "date",
                "Null": "NO",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_passing_date": {
                "Field": "next_passing_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "passing_histroy": {
                "Field": "passing_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_insurance_date": {
                "Field": "next_insurance_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "insurance_histroy": {
                "Field": "insurance_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "next_maintenance_date": {
                "Field": "next_maintenance_date",
                "Type": "date",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "maintenance_histroy": {
                "Field": "maintenance_histroy",
                "Type": "longtext",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    },
    "view_vehicle_model": {
        "create_sql": null,
        "columns": {
            "model_ids": {
                "Field": "model_ids",
                "Type": "int(11)",
                "Null": "NO",
                "Key": "",
                "Default": "0",
                "Extra": ""
            },
            "model_name": {
                "Field": "model_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "vehicle_modal_pic": {
                "Field": "vehicle_modal_pic",
                "Type": "varchar(2000)",
                "Null": "NO",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            },
            "category_id": {
                "Field": "category_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_name": {
                "Field": "category_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_image": {
                "Field": "category_image",
                "Type": "varchar(100)",
                "Null": "YES",
                "Key": "",
                "Default": "default.jpg",
                "Extra": ""
            },
            "category_description": {
                "Field": "category_description",
                "Type": "text",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "category_status": {
                "Field": "category_status",
                "Type": "varchar(50)",
                "Null": "YES",
                "Key": "",
                "Default": "Active",
                "Extra": ""
            },
            "brand_id": {
                "Field": "brand_id",
                "Type": "int(11)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            },
            "brand_name": {
                "Field": "brand_name",
                "Type": "varchar(200)",
                "Null": "YES",
                "Key": "",
                "Default": null,
                "Extra": ""
            }
        }
    }
}
JSON;

$blueprint = json_decode($blueprintJson, true);

// -------------------------------------------------------------
// SYNC LOGIC
// -------------------------------------------------------------
echo "<pre>";
echo "<h2>Database Synchronization Log</h2>";

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    echo "Connected to database successfully.\n\n";
} catch (\PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\nPlease update the credentials in this script.\n");
}

$liveTables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
$liveTablesAssoc = array_flip($liveTables);

$tablesCreated = 0;
$columnsAdded = 0;

foreach ($blueprint as $tableName => $tableData) {
    echo "Checking table: <strong>$tableName</strong>...\n";
    
    // 1. Check if table exists
    if (!isset($liveTablesAssoc[$tableName])) {
        // Table doesn't exist, create it
        echo " - <span style='color:green'>Table missing. Creating...</span>\n";
        $createSql = $tableData['create_sql'];
        
        // Ensure IF NOT EXISTS is used just in case
        $createSql = preg_replace('/^CREATE TABLE `/', 'CREATE TABLE IF NOT EXISTS `', $createSql);
        
        try {
            $pdo->exec($createSql);
            echo "   [SUCCESS] Created table $tableName.\n";
            $tablesCreated++;
        } catch (\PDOException $e) {
            echo "   <span style='color:red'>[ERROR] Failed to create table: " . $e->getMessage() . "</span>\n";
        }
    } else {
        // Table exists, check columns
        $liveColumnsRaw = $pdo->query("SHOW COLUMNS FROM `$tableName`")->fetchAll();
        $liveColumns = [];
        foreach ($liveColumnsRaw as $col) {
            $liveColumns[$col['Field']] = $col;
        }
        
        $blueprintColumns = $tableData['columns'];
        
        // Find missing columns
        foreach ($blueprintColumns as $colName => $colDef) {
            if (!isset($liveColumns[$colName])) {
                echo " - <span style='color:orange'>Column missing: $colName. Adding...</span>\n";
                
                $type = $colDef['Type'];
                $null = $colDef['Null'] === 'NO' ? 'NOT NULL' : 'NULL';
                $default = '';
                if ($colDef['Default'] !== null) {
                    $default = "DEFAULT " . $pdo->quote($colDef['Default']);
                } elseif ($colDef['Null'] === 'YES') {
                    $default = "DEFAULT NULL";
                }
                
                $extra = $colDef['Extra'];
                
                // Formulate ALTER TABLE
                $alterSql = "ALTER TABLE `$tableName` ADD COLUMN `$colName` $type $null $default $extra";
                
                try {
                    $pdo->exec($alterSql);
                    echo "   [SUCCESS] Added column $colName to $tableName.\n";
                    $columnsAdded++;
                } catch (\PDOException $e) {
                    echo "   <span style='color:red'>[ERROR] Failed to add column $colName: " . $e->getMessage() . "</span>\n";
                }
            }
        }
        
        echo " - Verification complete.\n";
    }
    echo "\n";
}

echo "--------------------------------------------------------\n";
echo "Synchronization finished!\n";
echo "Tables created: $tablesCreated\n";
echo "Columns added: $columnsAdded\n";
echo "--------------------------------------------------------\n";
echo "</pre>";