-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 18, 2026 at 01:08 PM
-- Server version: 10.11.17-MariaDB
-- PHP Version: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sandsl23_aa_car_rental`
--

DELIMITER $$
--
-- Procedures
--
$$

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
  `drivers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`drivers`)),
  `vehicles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vehicles`)),
  `clients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`clients`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `booking_info`
--

INSERT INTO `booking_info` (`ids`, `booking_id`, `reg_number`, `car_id`, `company_id`, `company_name`, `customer_id`, `customer_name`, `rent_start_date`, `rent_end_date`, `total_days_taken`, `rent_per_day`, `rent_total_cost`, `rent_discount_if_any`, `rent_after_discount`, `rent_tax_any`, `rent_grand_total`, `vehicles_image`, `jack_and_tools`, `spare_tyre`, `radio_yes_no`, `cd_recorder`, `drivers`, `vehicles`, `clients`, `created_at`) VALUES
(1, 'B0001', '256452', 101, 2, 'AA Car Rental', 'C0015', 'Ancy (4363636)', '2026-02-05', '2026-02-06', 2, 150.00, 300.000, 10.00, 290.000, 10.00, 319.000, '../../assets/img/car_images/p1.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}]', '[]', '[]', '2026-02-05 18:38:56'),
(2, 'B0002', '256452', 101, 2, 'AA Car Rental', 'C0012', 'Ancy (32232)', '2026-02-05', '2026-02-10', 6, 12.00, 72.000, 12.00, 60.000, 10.00, 66.000, '../../assets/img/car_images/p1.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"]}]', '[]', '[]', '2026-02-05 18:43:05'),
(3, 'B0003', '256452', 101, 2, 'AA Car Rental', 'C0012', 'Ancy (32232)', '2026-02-05', '2026-02-05', 1, 10.00, 10.000, 1.00, 9.000, 10.00, 9.900, '../../assets/img/car_images/p1.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"]}]', '[]', '[{\"files\": [\"uploads/client/webp/file_6984e68e4a7e80.97546867.webp\"], \"issueDate\": \"2026-02-04\", \"expiryDate\": \"2026-02-04\", \"documentType\": \"CPR\", \"issueLocation\": \"Cochin\"}]', '2026-02-05 18:51:10'),
(4, 'B0004', '256452', 101, 2, 'AA Car Rental', 'C0012', 'Ancy (32232)', '2026-02-05', '0000-00-00', 0, 0.00, 0.000, 0.00, 0.000, 0.00, 0.000, '../../assets/img/car_images/p1.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"]}]', '[]', '[{\"files\": [\"uploads/client/webp/file_6984e9f6ab4759.25934747.webp\"], \"issueDate\": \"2026-03-01\", \"expiryDate\": \"2026-03-01\", \"documentType\": \"Driving Licence\", \"issueLocation\": \"Cochin\"}]', '2026-02-05 19:05:29'),
(5, 'B0005', '256452', 101, 2, 'AA Car Rental', 'C0012', 'Ancy (32232)', '2026-02-05', '2026-02-12', 8, 10.00, 80.000, 10.00, 70.000, 10.00, 77.000, '../../assets/img/car_images/p1.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"]}, {\"files\": [\"uploads/driver/webp/file_6984eca16c57d0.53489654.webp\", \"uploads/driver/webp/file_6984eca1ba4028.66413432.webp\"], \"issueDate\": \"2026-02-03\", \"driverName\": \"Ajit Kumar \", \"expiryDate\": \"2026-02-27\", \"documentType\": \"DriverPhoto\", \"issueLocation\": \"Koratty\"}]', '[{\"files\": [\"uploads/rentedcars/webp/file_6984ecc2960de5.97835464.webp\", \"uploads/rentedcars/webp/file_6984ecc2dea546.61583628.webp\", \"uploads/rentedcars/webp/file_6984ecc3411537.91585101.webp\"], \"documentName\": \"Sample\"}]', '[]', '2026-02-05 19:17:27'),
(6, 'B0006', '125222', 9, 1, 'AA Car Rental', 'C0015', 'Ancy (4363636)', '2026-02-05', '2026-02-27', 23, 10.00, 230.000, 10.00, 220.000, 10.00, 242.000, 'uploads/vehicleImages/veh_69873cab0b8d82.65222394.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/driver/webp/file_69874043424cd8.92716687.webp\", \"uploads/driver/webp/file_69874043a319f7.44813982.webp\"], \"issueDate\": \"2026-02-01\", \"driverName\": \"Ajit Kumar \", \"expiryDate\": \"2026-03-07\", \"documentType\": \"CPR\", \"issueLocation\": \"Koratty\"}]', '[{\"files\": [\"uploads/rentedcars/webp/file_6987406a41cbd4.10053647.webp\", \"uploads/rentedcars/webp/file_6987406ab44c97.26557213.webp\"], \"documentName\": \"Sample\"}]', '[]', '2026-02-07 13:38:54'),
(7, 'B0007', '123232', 48, 1, 'AA Car Rental', 'C0015', 'Ancy (4363636)', '2026-02-16', '2026-03-07', 20, 100.00, 2000.000, 10.00, 1990.000, 10.00, 2189.000, 'uploads/vehicleImages/veh_69937bc2101242.98098213.jpg', 1, 1, 1, 1, '[{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}]', '[{\"files\": [\"uploads/rentedcars/webp/file_69937c7a1caeb0.96547717.webp\"], \"documentName\": \"front side\"}]', '[]', '2026-02-16 20:22:24'),
(8, 'B0008', NULL, NULL, NULL, NULL, NULL, NULL, '2026-02-16', '2026-03-07', 20, 100.00, 2000.000, 10.00, 1990.000, 10.00, 2189.000, NULL, 1, 1, 1, 1, '[]', '[]', '[]', '2026-02-16 20:22:30'),
(9, 'B0009', '256802', 16, 1, 'AA Car Rental', 'C0002', 'Ajit Kumar (8075501121)', '2026-02-17', '2026-02-28', 12, 150.00, 1800.000, 100.00, 1700.000, 10.00, 1870.000, 'uploads/vehicleImages/veh_6991b49a91a605.15524300.jpg', 1, 1, 1, 0, '[{\"files\": [null, null]}, {\"files\": [null, null]}, {\"files\": [\"uploads/driver/webp/file_699418ae680030.90382473.webp\"], \"issueDate\": \"2026-02-04\", \"driverName\": \"John\", \"expiryDate\": \"2026-03-06\", \"documentType\": \"DriverPhoto\", \"issueLocation\": \"Null\"}, {\"files\": [\"uploads/driver/webp/file_699418e0cdf673.24467190.webp\"], \"issueDate\": \"2026-02-03\", \"driverName\": \"John\", \"expiryDate\": \"2026-02-25\", \"documentType\": \"CPR\", \"issueLocation\": \"Bahrain\"}]', '[]', '[{\"files\": [\"uploads/client/webp/file_699419244337f2.74114219.webp\"], \"issueDate\": \"2026-02-04\", \"expiryDate\": \"2026-02-04\", \"documentType\": \"CPR\", \"issueLocation\": \"Company CR\"}]', '2026-02-17 07:32:06'),
(10, 'B0010', '256802', 16, 1, 'AA Car Rental', 'C0019', 'test (234)', '2026-02-17', '2026-03-06', 18, 120.00, 2160.000, 12.00, 2148.000, 10.00, 2362.800, 'uploads/vehicleImages/veh_6991b49a91a605.15524300.jpg', 1, 1, 1, 0, '[{\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\", \"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"]}, {\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\", \"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"]}]', '[{\"files\": [\"uploads/rentedcars/webp/file_6994261d030896.84938649.webp\"], \"documentName\": \"front\"}, {\"files\": [\"uploads/rentedcars/webp/file_6994263d2bfd26.31257140.webp\"], \"documentName\": \"seat\"}]', '[{\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"CPR\", \"issueLocation\": \"sde\"}, {\"files\": [\"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"Passport\", \"issueLocation\": \"ddd\"}]', '2026-02-17 08:28:50'),
(11, 'B0011', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-02', '2026-04-03', 33, 10.00, 330.000, 1.00, 329.000, 10.00, 361.900, NULL, 1, 1, 1, 1, '[{\"files\": [\"uploads/driver/webp/file_69a55c7c8a4c80.56262134.webp\"], \"issueDate\": \"2026-03-12\", \"driverName\": \"Ajit Kumar \", \"expiryDate\": \"2026-04-02\", \"documentType\": \"CPR\", \"issueLocation\": \"Koratty\"}]', '[]', '[]', '2026-03-02 09:47:32'),
(12, 'B0012', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03', '0000-00-00', 0, 0.00, 0.000, 0.00, 0.000, 0.00, 0.000, NULL, 1, 1, 1, 1, '[]', '[]', '[]', '2026-03-03 04:43:00'),
(13, 'B0013', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-03', '0000-00-00', 0, 0.00, 0.000, 0.00, 0.000, 0.00, 0.000, NULL, 1, 1, 1, 1, '[]', '[]', '[]', '2026-03-03 04:43:03'),
(14, 'B0014', NULL, NULL, NULL, NULL, NULL, NULL, '2026-03-09', '0000-00-00', 0, 0.00, 0.000, 0.00, 0.000, 0.00, 0.000, NULL, 1, 1, 1, 1, '[]', '[]', '[]', '2026-03-09 08:46:46');

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
  `customer_type` varchar(50) DEFAULT NULL,
  `customer_address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customer_address`)),
  `client_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`client_docs`)),
  `driver_docs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`driver_docs`)),
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `company_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`ids`, `customer_id`, `customer_name`, `customer_mobile`, `customer_email`, `customer_addr`, `customer_attn`, `customer_cr_cpr`, `customer_type`, `customer_address`, `client_docs`, `driver_docs`, `register_date`, `company_id`) VALUES
(1, 'C0001', 'Ajit Kumar', '9895765626', NULL, NULL, NULL, NULL, 'Individual', 'null', NULL, 'null', '2026-02-02 12:07:56', 0),
(2, 'C0002', 'Ajit Kumar', '8075501121', NULL, NULL, NULL, NULL, 'Individual', '{\"area\": \"125\", \"road\": \"2121\", \"block\": \"121\", \"house\": \"2222\", \"cpr_cr\": \"452222\", \"images\": [null, null], \"building\": \"2121\", \"mobile_other\": \"121221212121\", \"direct_number\": \"755522222\", \"customer_mobile\": \"1111111111\"}', '[[{\"files\": [\"uploads/client/webp/file_699419244337f2.74114219.webp\"], \"issueDate\": \"2026-02-04\", \"expiryDate\": \"2026-02-04\", \"documentType\": \"CPR\", \"issueLocation\": \"Company CR\"}]]', '[null, [{\"files\": [null, null]}, {\"files\": [null, null]}, {\"files\": [\"uploads/driver/webp/file_699418ae680030.90382473.webp\"], \"issueDate\": \"2026-02-04\", \"driverName\": \"John\", \"expiryDate\": \"2026-03-06\", \"documentType\": \"DriverPhoto\", \"issueLocation\": \"Null\"}, {\"files\": [\"uploads/driver/webp/file_699418e0cdf673.24467190.webp\"], \"issueDate\": \"2026-02-03\", \"driverName\": \"John\", \"expiryDate\": \"2026-02-25\", \"documentType\": \"CPR\", \"issueLocation\": \"Bahrain\"}]]', '2026-02-02 12:07:56', 0),
(3, 'C0003', 'Sample', '35078079', NULL, NULL, NULL, NULL, 'Agency', '{\"area\": \"454545\", \"road\": \"554\", \"block\": \"582232\", \"house\": \"6565\", \"cpr_cr\": \"65654654\", \"images\": [\"uploads/client/webp/file_697fb9103e60e4.66164422.webp\", \"uploads/client/webp/file_697fb91098a5d3.71101606.webp\"], \"building\": \"545\", \"mobile_other\": \"654\", \"direct_number\": \"65\", \"customer_mobile\": \"65\"}', NULL, 'null', '2026-02-02 12:07:56', 0),
(4, 'C0004', 'Sample', '35685689', NULL, NULL, NULL, NULL, 'Agency', '{\"area\": \"454545\", \"road\": \"554\", \"block\": \"582232\", \"house\": \"6565\", \"cpr_cr\": \"65654654\", \"images\": [\"uploads/client/webp/file_697fb9103e60e4.66164422.webp\", \"uploads/client/webp/file_697fb91098a5d3.71101606.webp\"], \"building\": \"545\", \"mobile_other\": \"654\", \"direct_number\": \"65\", \"customer_mobile\": \"65\"}', NULL, 'null', '2026-02-02 12:07:56', 0),
(5, 'C0005', 'Sample', '65', NULL, NULL, NULL, NULL, 'Agency', '{\"area\": \"454545\", \"road\": \"554\", \"block\": \"582232\", \"house\": \"6565\", \"cpr_cr\": \"65654654\", \"images\": [\"uploads/client/webp/file_697fb9103e60e4.66164422.webp\", \"uploads/client/webp/file_697fb91098a5d3.71101606.webp\"], \"building\": \"545\", \"mobile_other\": \"654\", \"direct_number\": \"65\", \"customer_mobile\": \"65\"}', NULL, 'null', '2026-02-02 12:07:56', 0),
(6, 'C0006', 'Kumar', '554511', NULL, NULL, NULL, NULL, 'Agency', '{\"area\": \"112\", \"road\": \"545412\", \"block\": \"2124\", \"house\": \"212112\", \"cpr_cr\": \"212121515\", \"images\": [\"uploads/client/webp/file_697fbed60fa0a2.86865711.webp\", \"uploads/client/webp/file_697fbed66f1035.73749855.webp\"], \"building\": \"212121\", \"mobile_other\": \"151512\", \"direct_number\": \"55151515\", \"customer_mobile\": \"554511\"}', NULL, 'null', '2026-02-02 12:07:56', 0),
(7, 'C0007', 'Test', '69325874101', NULL, NULL, NULL, NULL, 'Individual', '{\"area\": \"Sands\", \"road\": \"Koratty\", \"block\": \"Chandanam\", \"house\": \"Koratty\", \"cpr_cr\": \"456123\", \"images\": [\"uploads/client/files/file_69818ec1bb0fb2.14902046.docx\", \"uploads/client/files/file_69818ec1bb5403.29944587.xlsx\"], \"building\": \"Infopark\", \"mobile_other\": \"87767676\", \"direct_number\": \"12355666\", \"customer_mobile\": \"69325874101\"}', NULL, 'null', '2026-02-03 11:29:53', 0),
(8, 'C0008', '', '', NULL, NULL, NULL, NULL, 'Individual', '{\"area\": \"\", \"road\": \"\", \"block\": \"\", \"house\": \"\", \"cpr_cr\": \"\", \"images\": [\"uploads/client/webp/file_698448c0b30166.43832708.webp\", \"uploads/client/webp/file_698448c1156b62.43438304.webp\"], \"building\": \"\", \"mobile_other\": \"9895662255\", \"direct_number\": \"55625563\", \"customer_mobile\": \"\"}', NULL, 'null', '2026-02-05 13:08:29', 0),
(9, 'C0009', '', '', NULL, NULL, NULL, NULL, 'Corporate', '{\"area\": \"125\", \"road\": \"\", \"block\": \"\", \"house\": \"\", \"cpr_cr\": \"\", \"images\": [\"uploads/client/webp/file_69844a2c047af0.03814478.webp\", \"uploads/client/webp/file_69844a2c6197d1.36166541.webp\"], \"building\": \"\", \"mobile_other\": \"5626565\", \"direct_number\": \"78262656\", \"customer_mobile\": \"\"}', NULL, 'null', '2026-02-05 13:13:44', 0),
(10, 'C0010', '', '', NULL, NULL, NULL, NULL, 'Corporate', '{\"area\": \"\", \"road\": \"\", \"block\": \"\", \"house\": \"\", \"cpr_cr\": \"\", \"images\": [\"uploads/client/webp/file_69844b05084162.36998471.webp\"], \"building\": \"\", \"mobile_other\": \"54545454\", \"direct_number\": \"454545454\", \"customer_mobile\": \"\"}', NULL, 'null', '2026-02-05 13:17:20', 0),
(11, 'C0011', 'Ancy', '23232', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"12523\", \"road\": \"2332\", \"block\": \"323232\", \"house\": \"323\", \"cpr_cr\": \"323232\", \"images\": [\"uploads/client/webp/file_69844cff3d4080.42064314.webp\", \"uploads/client/webp/file_69844cff9ec021.26297074.webp\", \"uploads/client/webp/file_69844d000c17d1.45750234.webp\"], \"building\": \"3232\", \"mobile_other\": \"32323\", \"direct_number\": \"32323\", \"customer_mobile\": \"23232\"}', '[{\"files\": [\"uploads/client/webp/file_69849e2c6748c3.43523838.webp\"], \"issueDate\": \"2026-02-04\", \"expiryDate\": \"2026-02-04\", \"documentType\": \"CPR\", \"issueLocation\": \"Cochin\"}, [{\"files\": [\"uploads/client/webp/file_6984b181198c08.45985807.webp\", \"uploads/client/webp/file_6984b1816dfcc3.50315524.webp\"], \"issueDate\": \"2026-02-05\", \"expiryDate\": \"2026-02-05\", \"documentType\": \"CPR\", \"issueLocation\": \"Cochin\"}], []]', 'null', '2026-02-05 13:25:47', 0),
(12, 'C0012', 'Ancy', '32232', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"452\", \"road\": \"555\", \"block\": \"2552\", \"house\": \"6565659\", \"cpr_cr\": \"2332\", \"images\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"], \"building\": \"555656\", \"mobile_other\": \"59879856\", \"direct_number\": \"55565\", \"customer_mobile\": \"32232\"}', '[{\"files\": [\"uploads/client/webp/file_6984a0738d8323.05948353.webp\", \"uploads/client/webp/file_6984a073e6d064.31833254.webp\", \"uploads/client/webp/file_6984a0744b3080.03572260.webp\"], \"issueDate\": \"2026-02-05\", \"expiryDate\": \"2026-02-05\", \"documentType\": \"CPR\", \"issueLocation\": \"Cochin\"}, [], [{\"files\": [\"uploads/client/webp/file_6984e68e4a7e80.97546867.webp\"], \"issueDate\": \"2026-02-04\", \"expiryDate\": \"2026-02-04\", \"documentType\": \"CPR\", \"issueLocation\": \"Cochin\"}], [{\"files\": [\"uploads/client/webp/file_6984e9f6ab4759.25934747.webp\"], \"issueDate\": \"2026-03-01\", \"expiryDate\": \"2026-03-01\", \"documentType\": \"Driving Licence\", \"issueLocation\": \"Cochin\"}], []]', '[null, [{\"files\": [\"uploads/client/webp/file_69845e87888866.09223085.webp\"]}, {\"files\": [\"uploads/driver/webp/file_6984eca16c57d0.53489654.webp\", \"uploads/driver/webp/file_6984eca1ba4028.66413432.webp\"], \"issueDate\": \"2026-02-03\", \"driverName\": \"Ajit Kumar \", \"expiryDate\": \"2026-02-27\", \"documentType\": \"DriverPhoto\", \"issueLocation\": \"Koratty\"}]]', '2026-02-05 14:40:37', 0),
(13, 'C0013', 'SA', '54545', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"4544\", \"road\": \"45454\", \"block\": \"54545\", \"house\": \"45454\", \"cpr_cr\": \"5454\", \"images\": [\"uploads/client/webp/file_69845f3a4ddb88.99025701.webp\"], \"building\": \"54545\", \"mobile_other\": \"45454\", \"direct_number\": \"545454\", \"customer_mobile\": \"54545\"}', NULL, 'null', '2026-02-05 14:43:33', 0),
(14, 'C0014', 'SA', '54545', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"4544\", \"road\": \"45454\", \"block\": \"54545\", \"house\": \"45454\", \"cpr_cr\": \"5454\", \"images\": [\"uploads/client/webp/file_69845f3a4ddb88.99025701.webp\", \"uploads/client/webp/file_698460bf9887b2.03469024.webp\", \"uploads/client/webp/file_698460c00acae3.31901138.webp\"], \"building\": \"54545\", \"mobile_other\": \"45454\", \"direct_number\": \"545454\", \"customer_mobile\": \"54545\"}', NULL, 'null', '2026-02-05 14:50:16', 0),
(15, 'C0015', 'Ancy', '4363636', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"536346\", \"road\": \"36436\", \"block\": \"364364\", \"house\": \"64364363\", \"cpr_cr\": \"6436\", \"images\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"], \"building\": \"43643643\", \"mobile_other\": \"36436\", \"direct_number\": \"3636\", \"customer_mobile\": \"4363636\"}', '[[], []]', '[null, [{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/driver/webp/file_69874043424cd8.92716687.webp\", \"uploads/driver/webp/file_69874043a319f7.44813982.webp\"], \"issueDate\": \"2026-02-01\", \"driverName\": \"Ajit Kumar \", \"expiryDate\": \"2026-03-07\", \"documentType\": \"CPR\", \"issueLocation\": \"Koratty\"}], [{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}, {\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"]}]]', '2026-02-05 14:57:01', 0),
(16, 'C0016', 'Ancy', '4363636', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"536346\", \"road\": \"36436\", \"block\": \"364364\", \"house\": \"64364363\", \"cpr_cr\": \"6436\", \"images\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"], \"building\": \"43643643\", \"mobile_other\": \"36436\", \"direct_number\": \"3636\", \"customer_mobile\": \"4363636\"}', 'null', NULL, '2026-02-05 15:09:09', 0),
(17, 'C0017', 'Ancy', '4363636', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"536346\", \"road\": \"36436\", \"block\": \"364364\", \"house\": \"64364363\", \"cpr_cr\": \"6436\", \"images\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"], \"building\": \"43643643\", \"mobile_other\": \"36436\", \"direct_number\": \"3636\", \"customer_mobile\": \"4363636\"}', '[{\"files\": [\"uploads/client/webp/file_698462576945f4.80015122.webp\", \"uploads/client/webp/file_69846257d76e40.41645264.webp\"], \"issueDate\": \"2026-02-13\", \"expiryDate\": \"2026-02-13\", \"documentType\": \"Passport\", \"issueLocation\": \"Cochin\"}]', NULL, '2026-02-05 15:12:09', 0),
(18, 'C0018', 'Kumar', '2121', NULL, NULL, NULL, NULL, 'Corporate', '{\"area\": \"12212\", \"road\": \"121212\", \"block\": \"2121\", \"house\": \"2121\", \"cpr_cr\": \"2121\", \"images\": [\"uploads/client/webp/file_69846a54f36ec0.54051538.webp\", \"uploads/client/webp/file_69846a5558fed0.70453691.webp\"], \"building\": \"1212\", \"mobile_other\": \"2121\", \"direct_number\": \"2121\", \"customer_mobile\": \"2121\"}', '[{\"files\": [\"uploads/client/webp/file_69846a54f36ec0.54051538.webp\", \"uploads/client/webp/file_69846a5558fed0.70453691.webp\"], \"issueDate\": \"2026-02-02\", \"expiryDate\": \"2026-02-02\", \"documentType\": \"Driving Licence\", \"issueLocation\": \"Cochin\"}]', NULL, '2026-02-05 15:30:56', 0),
(19, 'C0019', 'test', '234', NULL, NULL, NULL, NULL, 'Individual', '{\"area\": \"1\", \"road\": \"4\", \"block\": \"2\", \"house\": \"34\", \"cpr_cr\": \"1324\", \"images\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\", \"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"], \"building\": \"2\", \"mobile_other\": \"2324\", \"direct_number\": \"23\", \"customer_mobile\": \"234\"}', '[{\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"CPR\", \"issueLocation\": \"sde\"}, {\"files\": [\"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"Passport\", \"issueLocation\": \"ddd\"}, [{\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"CPR\", \"issueLocation\": \"sde\"}, {\"files\": [\"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"], \"issueDate\": \"2026-02-01\", \"expiryDate\": \"2026-02-01\", \"documentType\": \"Passport\", \"issueLocation\": \"ddd\"}]]', '[[{\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\", \"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"]}, {\"files\": [\"uploads/client/webp/file_699423bcf3e3b8.81802303.webp\", \"uploads/client/files/file_6994240a0c5e89.75321002.pdf\"]}]]', '2026-02-17 13:50:03', 0),
(20, 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', 'Zaya Ameen', NULL, 'Individual', '{\"area\": \"123\", \"road\": \"112\", \"block\": \"123\", \"house\": \"No\", \"cpr_cr\": \"12345\", \"images\": [], \"building\": \"Second\", \"mobile_other\": \"989766565\", \"direct_number\": \"\", \"customer_mobile\": \"11223344\"}', '[]', NULL, '2026-03-09 13:29:43', 0),
(21, 'C0021', '', '', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"\", \"road\": \"\", \"block\": \"\", \"house\": \"\", \"cpr_cr\": \"\", \"images\": [], \"building\": \"\", \"mobile_other\": \"\", \"direct_number\": \"\", \"customer_mobile\": \"\"}', '[]', NULL, '2026-03-09 14:13:59', 0),
(22, 'C0022', '', '', NULL, NULL, NULL, NULL, NULL, '{\"area\": \"\", \"road\": \"\", \"block\": \"\", \"house\": \"\", \"cpr_cr\": \"\", \"images\": [], \"building\": \"\", \"mobile_other\": \"\", \"direct_number\": \"\", \"customer_mobile\": \"\"}', '[]', NULL, '2026-03-09 16:06:38', 0),
(23, 'C0023', 'Isa MAria Sinto', '1234556', 'isa @gmail.com', 'Manama. Kingdom of bahrain', 'Ms Isa MAria', '3434534543', 'Individual', NULL, '[]', NULL, '2026-03-14 21:31:54', 0),
(24, 'C0024', 'Ian Joseph Sinto', '4354385', 'ian@gmail.com', 'Kingdom of bahrain', 'Mr. Ian JOseph', NULL, 'Individual', NULL, '[]', NULL, '2026-03-14 21:38:33', 0),
(25, 'C0025', 'Anu', '1243214', 'sdfsd@dsf.sdf', 'fdsv', 'dsf', '324234', 'Agency', NULL, '[]', NULL, '2026-04-02 21:51:31', 1),
(26, 'C0026', 'Sandslab', '123123', 'sandslab@gmail.com', 'test', 'test', '1234214', 'Corporate', NULL, '[]', NULL, '2026-04-14 18:51:08', 1),
(27, 'C0027', 'Sandslab', '123123', 'sandslab@gmail.com', 'test', 'test', '1234214', 'Corporate', NULL, '[]', NULL, '2026-04-14 18:51:11', 1),
(28, 'C0028', 'Sandslab', '345435', 'ands@sdfn.com', 'sdsa', 'aaa', '12321', 'Corporate', NULL, '[]', NULL, '2026-04-14 18:55:06', 1),
(29, 'C0029', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', NULL, '2026-04-29 14:33:41', 1),
(30, 'C0030', 'testancy', '2342', 'ancy32fdg', 'fgdg', 'rtfgd', '3242343', 'Corporate', NULL, '[]', NULL, '2026-05-17 12:23:49', 1);

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
(1, 'QT', 2026, 1, 24, 1, '2026-03-15 20:56:13'),
(2, 'QT', 2026, 2, 21, 0, '2026-03-15 20:56:13'),
(3, 'QD', 2026, 1, 15, 1, '2026-03-15 20:56:13'),
(4, 'QD', 2026, 2, 1, 0, '2026-03-15 20:56:13'),
(5, 'QT', 26, 1, 18, 1, '2026-03-16 21:33:32'),
(6, 'QD', 20, 1, 2, 1, '2026-03-17 16:48:14'),
(7, 'QT', 20, 1, 2, 1, '2026-03-17 16:58:20');

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
  `customer_address` text DEFAULT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`items`)),
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
  `terms` longtext DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `user_prefix`, `quotation_no`, `quotation_date`, `customer_code`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `items`, `allItemSubtotal`, `subtotal`, `total_discount`, `total_discount_amount`, `after_discount_amount`, `vat_total`, `grand_total`, `created_at`, `draft`, `reference_number`, `user_id`, `user_name`, `company_id`, `company_name`, `attention`, `introduction`, `terms`) VALUES
(1, NULL, 'QT-AJ26-0001', '2026-02-26', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"125\", \"total\": \"137.50\", \"discount\": \"0\", \"item_name\": \"Item 5\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"13.20\", \"discount\": \"0\", \"item_name\": \"Item 6\"}]', 150.70000, 137.00000, 0.00, 0.0000, 137.0000, 13.70000, 150.70000, '2026-02-26 10:02:24', 'No', '100001', 1, 'admin', 1, 'SaNDS Lab', 'To Mt Ajit Kumar', NULL, '<p><br></p>'),
(2, NULL, 'QT-AJ26-0002', '2026-02-26', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"14\", \"total\": \"13.86\", \"discount\": \"10\", \"item_name\": \"Item 3\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"13.20\", \"discount\": \"0\", \"item_name\": \"Item 4\"}]', 27.06000, 24.60000, 2.00, 0.4900, 24.1100, 2.41000, 26.52000, '2026-02-26 10:29:53', 'No', '161040000103', 1, 'admin', 1, 'SaNDS Lab', '', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque</strong></li></ol>'),
(3, NULL, 'QT-AJ26-0003', '2026-02-26', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"10\", \"vat\": \"10\", \"price\": \"12.5\", \"total\": \"134.06\", \"discount\": \"2.5\", \"item_name\": \"Item 2\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"14.26\", \"total\": \"15.53\", \"discount\": \"1\", \"item_name\": \"Item 4\"}]', 149.59000, 135.99000, 0.00, 0.0000, 135.9900, 13.60000, 149.59000, '2026-02-26 15:03:48', 'No', '161040000103', 1, 'admin', 1, 'SaNDS Lab', '', NULL, '<p><br></p>'),
(4, NULL, 'QT-AJ26-0004', '2026-02-26', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"10\", \"vat\": \"10\", \"price\": \"12.5\", \"total\": \"134.06\", \"discount\": \"2.5\", \"item_name\": \"Item 2\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"14.26\", \"total\": \"15.53\", \"discount\": \"1\", \"item_name\": \"Item 4\"}]', 149.59000, 135.99000, 0.00, 0.0000, 135.9900, 13.60000, 149.59000, '2026-02-26 15:07:02', 'No', '161040000103', 1, 'admin', 1, 'SaNDS Lab', '', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque</strong></li></ol><p><br></p>'),
(5, NULL, 'QT-AJ26-0005', '2026-02-27', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"10\", \"total\": \"11.00\", \"discount\": \"0\", \"item_name\": \"Item 11\'11\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"21.78\", \"discount\": \"1\", \"item_name\": \"Item 10\"}, {\"qty\": \"12\", \"vat\": \"10\", \"price\": \"31\", \"total\": \"409.20\", \"discount\": \"0\", \"item_name\": \"Item 2\"}]', 441.98000, 401.80000, 5.00, 20.0900, 381.7100, 38.17000, 419.88000, '2026-02-27 00:11:06', 'No', '100001', 1, 'admin', 1, 'SaNDS Lab', 'To Mt Ajit Kumar', NULL, '<p><strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Payment Shiuld be in Advance</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>All Payment should in <strong>1<u>00%</u></strong> on order PO</li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span>Pay thjrough Cash or Cheque</li></ol>'),
(6, NULL, 'QT-AJ26-0006', '2026-02-28', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"10\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"1600.50\", \"discount\": \"3\", \"item_name\": \"Item 11\'11\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"142\", \"total\": \"156.20\", \"discount\": \"0\", \"item_name\": \"Item 5\"}]', 1756.70000, 1597.00000, 5.00, 79.8500, 1517.1500, 151.72000, 1668.87000, '2026-02-28 14:59:34', 'No', '161040000103', 1, 'admin', 1, 'SaNDS Lab', 'To Mr Ajit Kumar', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque</strong></li></ol>'),
(7, NULL, 'QT-AJ26-0007', '2026-03-01', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"15\", \"vat\": \"10\", \"price\": \"143\", \"total\": \"2241.53\", \"discount\": \"5\", \"item_name\": \"Item 2\"}]', 2241.53000, 2037.75000, 5.00, 101.8900, 1935.8600, 193.59000, 2129.45000, '2026-03-01 03:13:38', 'No', '101', 1, 'admin', 1, 'SaNDS Lab', 'To Mt Ajit Kumar', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque</strong></li></ol><p><br></p>'),
(8, NULL, 'QT-AJ26-0008', '2026-03-02', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"5\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"783.75\", \"discount\": \"5\", \"item_name\": \"Item 11\"}, {\"qty\": \"7\", \"vat\": \"10\", \"price\": \"250\", \"total\": \"1828.75\", \"discount\": \"5\", \"item_name\": \"Item 6\"}, {\"qty\": \"5\", \"vat\": \"0\", \"price\": \"45\", \"total\": \"225.00\", \"discount\": \"0\", \"item_name\": \"Item 7\"}]', 2837.50000, 2600.00000, 10.00, 260.0000, 2340.0000, 237.50000, 2574.00000, '2026-03-02 04:43:40', 'No', '100001', 1, 'admin', 1, 'SaNDS Lab', 'To Mt Ajit Kumar', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque123</strong></li></ol>'),
(9, NULL, 'QT-AJ26-0009', '2026-03-02', NULL, 'Ebin Rose', '12522', 'care@sandslab.com', 'KOratty, Trichur', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"15\", \"total\": \"16.50\", \"discount\": \"0\", \"item_name\": \"Item 3\"}, {\"qty\": \"15\", \"vat\": \"10\", \"price\": \"15\", \"total\": \"242.55\", \"discount\": \"2\", \"item_name\": \"Item 4\"}]', 259.05000, 235.50000, 10.00, 23.5500, 211.9500, 21.20000, 233.14000, '2026-03-02 04:58:18', 'No', '', 1, 'admin', 1, 'SaNDS Lab', '', NULL, '<p>This ia same Dat for <strong>Terms and Condition</strong></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment Shiuld be in Advance</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>All Payment should in i<u>100%</u> on order PO</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Pay thjrough Cash or Cheque123</strong></li></ol>'),
(10, NULL, 'QT-AJ26-0010', '2026-03-03', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}]', 766.70000, 697.00000, 5.00, 34.8500, 662.1500, 69.70000, 728.37000, '2026-03-03 10:14:15', 'No', '125222', 1, 'admin', 1, 'SaNDS Lab', 'To Mr Ajit Kumar', NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol>'),
(12, NULL, 'QT-AJ26-0012', '2026-03-05', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"10\", \"vat\": \"10\", \"price\": \"15\", \"total\": \"156.75\", \"discount\": \"5\", \"item_name\": \"Item 10\"}, {\"qty\": \"15\", \"vat\": \"10\", \"price\": \"140\", \"total\": \"2310.00\", \"discount\": \"0\", \"item_name\": \"Item 11\"}]', 2466.75000, 2242.50000, 0.00, 0.0000, 2242.5000, 224.25000, 2466.75000, '2026-03-05 05:44:28', 'No', '100001', 1, 'admin', 1, 'SaNDS Lab', 'To Mr Ajit Kumar', NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over </span><strong style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">100 languages, including Arabic</strong><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, </span><em style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"><u>though context-aware</u></em><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"> nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>'),
(11, NULL, 'QT-AJ26-0011', '2026-03-03', NULL, 'Ancy Varghese Thekkan', '+973 09895765626', 'sandslab@gmail.com', 'Chandanam Block, Infopark, Koratty', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"150\", \"total\": \"148.50\", \"discount\": \"10\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"562\", \"total\": \"618.20\", \"discount\": \"0\", \"item_name\": \"This is a Sample Data to Display as Product Discription and It Should be Shows as much we can, This is for rthe demo not the real data for the demo only. This shows that th  is will auto wrap and ispply in the dpcument.\"}]', 27601.20000, 25092.00000, 5.00, 1254.6000, 23837.4000, 2509.20000, 26221.14000, '2026-03-03 15:02:36', 'No', '125222', 1, 'admin', 1, 'SaNDS Lab', 'To Mr Ajit Kumar', NULL, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol>'),
(13, 'CMN', 'AA/26/CMN/0002', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:06:15', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(14, 'CMN', 'AA/26/CMN/0003', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:06:51', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(15, 'CMN', 'AA/26/CMN/0004', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:08:55', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(16, 'CMN', 'AA/26/CMN/0005', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:11:59', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(17, 'CMN', 'AA/26/CMN/0006', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:13:44', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(18, 'CMN', 'AA/26/CMN/0007', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"100\", \"total\": \"100.000\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T22:05\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T19:02\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"20\", \"total\": \"528.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-26T19:03\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-02T19:03\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 628.00000, 580.00000, 0.00, 0.0000, 0.0000, 48.00000, 628.00000, '2026-03-16 16:14:02', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>');
INSERT INTO `quotations` (`id`, `user_prefix`, `quotation_no`, `quotation_date`, `customer_code`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `items`, `allItemSubtotal`, `subtotal`, `total_discount`, `total_discount_amount`, `after_discount_amount`, `vat_total`, `grand_total`, `created_at`, `draft`, `reference_number`, `user_id`, `user_name`, `company_id`, `company_name`, `attention`, `introduction`, `terms`) VALUES
(19, 'CMN', 'AA/26/CMN/0008', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"410.000\", \"duration\": \"41\", \"perid_to\": \"2026-04-11T19:16\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:16\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 410.00000, 410.00000, 0.00, 0.0000, 0.0000, 0.00000, 410.00000, '2026-03-16 16:16:17', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'Hai', '<p>terms</p>'),
(20, 'CMN', 'AA/26/CMN/0009', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"410.000\", \"duration\": \"41\", \"perid_to\": \"2026-04-11T19:16\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:16\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"2\", \"total\": \"4.400\", \"duration\": \"2\", \"perid_to\": \"2026-04-11T19:18\", \"item_name\": \"HYUNDAI ACCENT\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:18\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 414.40000, 414.00000, 0.00, 0.0000, 0.0000, 0.40000, 414.40000, '2026-03-16 16:18:58', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'Hai', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(21, 'CMN', 'AA/26/CMN/0010', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"410.000\", \"duration\": \"41\", \"perid_to\": \"2026-04-11T19:16\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:16\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"2\", \"total\": \"4.400\", \"duration\": \"2\", \"perid_to\": \"2026-04-11T19:18\", \"item_name\": \"HYUNDAI ACCENT\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:18\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 414.40000, 414.00000, 0.00, 0.0000, 0.0000, 0.40000, 414.40000, '2026-03-16 16:24:51', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'Hai', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(22, 'CMN', 'AA/26/CMN/0011', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"410.000\", \"duration\": \"41\", \"perid_to\": \"2026-04-11T19:16\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:16\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"2\", \"total\": \"4.400\", \"duration\": \"2\", \"perid_to\": \"2026-04-11T19:18\", \"item_name\": \"HYUNDAI ACCENT\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:18\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 414.40000, 414.00000, 0.00, 0.0000, 0.0000, 0.40000, 414.40000, '2026-03-16 16:26:05', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'Hai', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(23, 'CMN', 'AA/26/CMN/0012', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"410.000\", \"duration\": \"41\", \"perid_to\": \"2026-04-11T19:16\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:16\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"2\", \"total\": \"4.400\", \"duration\": \"2\", \"perid_to\": \"2026-04-11T19:18\", \"item_name\": \"HYUNDAI ACCENT\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:18\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 414.40000, 414.00000, 0.00, 0.0000, 0.0000, 0.40000, 414.40000, '2026-03-16 16:31:22', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'Hai', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(24, 'LS', 'AA/26/LS/0013', '2026-03-25', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"1\", \"total\": \"1.100\", \"duration\": \"1\", \"perid_to\": \"2026-03-16T19:44\", \"item_name\": \"MITSUBISHI LANCER\", \"service_id\": \"1\", \"period_from\": \"2026-03-16T19:40\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}]', 1.10000, 1.00000, 0.00, 0.0000, 0.0000, 0.10000, 1.10000, '2026-03-16 16:40:32', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, 'test', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(25, 'LS', 'AA/26/LS/0014', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"10\", \"total\": \"2112.000\", \"duration\": \"192\", \"perid_to\": \"2026-03-24T19:43\", \"item_name\": \"TOYOTA COROLLA \", \"service_id\": \"1\", \"period_from\": \"2026-03-16T19:43\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"9\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}]', 2112.00000, 1920.00000, 0.00, 0.0000, 0.0000, 192.00000, 2112.00000, '2026-03-16 16:43:58', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(26, 'LS', 'AA/26/LS/0015', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"11\", \"total\": \"375.100\", \"duration\": \"31\", \"perid_to\": \"2026-04-01T19:44\", \"item_name\": \"TOYOTA COROLLA \", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:44\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"9\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 375.10000, 341.00000, 0.00, 0.0000, 0.0000, 34.10000, 375.10000, '2026-03-16 16:45:11', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(27, 'LS', 'AA/26/LS/0016', '2026-03-16', NULL, 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"27.000\", \"duration\": \"27\", \"perid_to\": \"2026-03-28T19:46\", \"item_name\": \"TOYOTA COROLLA \", \"service_id\": \"2\", \"period_from\": \"2026-03-01T19:46\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"9\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 27.00000, 27.00000, 0.00, 0.0000, 0.0000, 0.00000, 27.00000, '2026-03-16 16:46:55', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(28, 'CMN', 'AA/26/CMN/0017', '2026-03-16', '', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"200\", \"total\": \"1760.000\", \"duration\": \"8\", \"perid_to\": \"2026-10-16T19:51\", \"item_name\": \"TOYOTA COROLLA \", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:51\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"9\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 1760.00000, 1600.00000, 0.00, 0.0000, 0.0000, 160.00000, 1760.00000, '2026-03-16 16:51:47', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(29, 'MOI', 'AA/26/MOI/0018', '2026-03-16', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"1\", \"total\": \"397.100\", \"duration\": \"361\", \"perid_to\": \"2026-03-16T19:59\", \"item_name\": \"TOYOTA COROLLA \", \"service_id\": \"1\", \"period_from\": \"2026-03-01T19:54\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"9\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}]', 397.10000, 361.00000, 0.00, 0.0000, 0.0000, 36.10000, 397.10000, '2026-03-16 16:55:16', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p><br></p>'),
(30, 'vv', 'QD/AA/20/vv/0001', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"462.000\", \"duration\": \"35\", \"perid_to\": \"2026-04-04T14:18\", \"item_name\": \"HONDA CITY\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T14:17\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"4\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 462.00000, 420.00000, 0.00, 0.0000, 0.0000, 42.00000, 462.00000, '2026-03-17 11:18:14', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(31, 'ss', 'AA/20/ss/0001', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"24.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-24T14:28\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T14:27\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 24.00000, 24.00000, 0.00, 0.0000, 0.0000, 0.00000, 24.00000, '2026-03-17 11:28:20', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(32, 'ss', 'QD/AA/20/ss/0002', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"24.000\", \"duration\": \"24\", \"perid_to\": \"2026-03-24T14:28\", \"item_name\": \"TOYOTA AVALON\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T14:27\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"13\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 24.00000, 24.00000, 0.00, 0.0000, 0.0000, 0.00000, 24.00000, '2026-03-17 11:29:06', '', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(33, 'yy', 'AA/20/yy/0002', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"TOYOTA AVALON\",\"item_model_id\":\"13\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-03-17T14:35\",\"period_to\":\"\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"24\",\"vat\":\"0\",\"total\":\"288.000\"}]', 288.00000, 288.00000, 0.00, 0.0000, 0.0000, 0.00000, 288.00000, '2026-03-17 11:36:03', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', '', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p>'),
(56, 'CMN', 'AA/2026/CMN/0022', '2026-04-01', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"NISSAN MICRA\",\"item_model_id\":\"1\",\"item_model_pic\":\"micra.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-16T19:53\",\"period_to\":\"2026-05-08T19:53\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"22\",\"vat\":\"10\",\"total\":\"290.400\"},{\"item_name\":\"NISSAN SUNNY\",\"item_model_id\":\"2\",\"item_model_pic\":\"sunny.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-08T19:53\",\"period_to\":\"2026-05-06T19:54\",\"qty\":\"1\",\"price\":\"14\",\"duration\":\"29\",\"vat\":\"0\",\"total\":\"406.000\"}]', 696.40000, 670.00000, 0.00, 0.0000, 0.0000, 26.40000, 696.40000, '2026-04-05 16:54:15', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><br></p>'),
(34, 'GG', 'QD/AA/2026/GG/0002', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"0\", \"price\": \"12\", \"total\": \"96.000\", \"duration\": \"8\", \"perid_to\": \"2026-10-13T14:39\", \"item_name\": \"HYUNDAI ACCENT\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T14:39\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 96.00000, 96.00000, 0.00, 0.0000, 0.0000, 0.00000, 96.00000, '2026-03-17 11:39:33', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', NULL, '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(35, 'RR', 'AA/2026/RR/0013', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 406.40000, 374.00000, 0.00, 0.0000, 0.0000, 32.40000, 406.40000, '2026-03-17 13:21:50', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(36, 'RR', 'QD/AA/2026/RR/0003', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 406.40000, 374.00000, 0.00, 0.0000, 0.0000, 32.40000, 406.40000, '2026-03-17 13:33:37', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(37, 'RR', 'QD/AA/2026/RR/0004', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 13:34:30', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(38, 'RR', 'QD/AA/2026/RR/0005', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 13:37:26', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(39, 'RR', 'QD/AA/2026/RR/0006', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 13:37:41', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(40, 'RR', 'QD/AA/2026/RR/0007', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 13:39:22', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(41, 'RR', 'QD/AA/2026/RR/0008', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 13:39:39', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>');
INSERT INTO `quotations` (`id`, `user_prefix`, `quotation_no`, `quotation_date`, `customer_code`, `customer_name`, `customer_phone`, `customer_email`, `customer_address`, `items`, `allItemSubtotal`, `subtotal`, `total_discount`, `total_discount_amount`, `after_discount_amount`, `vat_total`, `grand_total`, `created_at`, `draft`, `reference_number`, `user_id`, `user_name`, `company_id`, `company_name`, `attention`, `introduction`, `terms`) VALUES
(42, 'RR', 'AA/2026/RR/0014', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 406.40000, 374.00000, 0.00, 0.0000, 0.0000, 32.40000, 406.40000, '2026-03-17 13:40:37', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(43, 'RR', 'AA/2026/RR/0015', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 406.40000, 374.00000, 0.00, 0.0000, 0.0000, 32.40000, 406.40000, '2026-03-17 14:33:57', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(44, 'RR', 'QD/AA/2026/RR/0009', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 15:26:53', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(45, 'RR', 'AA/2026/RR/0016', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 15:27:45', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(47, 'RR', 'QD/AA/2026/RR/0011', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}]', 406.40000, 374.00000, 0.00, 0.0000, 0.0000, 32.40000, 406.40000, '2026-03-17 15:50:21', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(46, 'RR', 'QD/AA/2026/RR/0010', '2026-03-17', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"2\", \"total\": \"20.000\", \"duration\": \"10\", \"item_name\": \"MITSUBISHI LANCER\", \"period_to\": \"2026-03-27T16:37\", \"service_id\": \"2\", \"period_from\": \"2026-03-17T16:37\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"7\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 15:28:03', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(48, 'RR', 'QD/AA/2026/RR/0012', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:21:24', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(49, 'AA/2026/RRT/0017', 'AA/2026/RRT/0017', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"2\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:23:26', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(50, 'RR', 'QD/AA/2026/RR/0013', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"0\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"Select Service\", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:23:50', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(51, 'AA/2026/RR/RRT', 'AA/2026/RR/RRT', '2026-03-17', 'C0012', 'Ancy Varghese Thekkan', '32232', 'ancy@gmail.com', 'test', '[{\"item_name\":\"HYUNDAI ACCENT\",\"item_model_id\":\"5\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-03-01T16:21\",\"period_to\":\"2026-03-28T16:21\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"27\",\"vat\":\"10\",\"total\":\"356.400\"},{\"item_name\":\"KIA PEGAS\",\"item_model_id\":\"6\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"month\",\"rate_type_name\":\"Monthly\",\"period_from\":\"2026-03-01T16:21\",\"period_to\":\"2026-06-30T16:21\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"5\",\"vat\":\"0\",\"total\":\"50.000\"},{\"item_name\":\"NISSAN SUNNY\",\"item_model_id\":\"2\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-03-01T16:34\",\"period_to\":\"2026-03-02T16:34\",\"qty\":\"1\",\"price\":\"5\",\"duration\":\"24\",\"vat\":\"10\",\"total\":\"132.000\"},{\"item_name\":\"HYUNDAI ELENTRA\",\"item_model_id\":\"14\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-03-16T18:48\",\"period_to\":\"2026-04-04T18:49\",\"qty\":\"1\",\"price\":\"1\",\"duration\":\"20\",\"vat\":\"0\",\"total\":\"20.000\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:24:29', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p>'),
(52, 'RRTV', 'QD/AA/2026/RRTV/0014', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"0\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"Select Service\", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:24:54', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(53, 'RRTV', 'AA/2026/RRTV/0019', '2026-03-17', 'C0012', 'Ancy', '32232', 'ancy@gmail.com', 'test', '[{\"qty\": \"1\", \"vat\": \"10\", \"price\": \"12\", \"total\": \"356.400\", \"duration\": \"27\", \"item_name\": \"HYUNDAI ACCENT\", \"period_to\": \"2026-03-28T16:21\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"day\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"5\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"10\", \"total\": \"50.000\", \"duration\": \"5\", \"item_name\": \"KIA PEGAS\", \"period_to\": \"2026-06-30T16:21\", \"service_id\": \"2\", \"period_from\": \"2026-03-01T16:21\", \"rate_type_id\": \"month\", \"service_name\": \"\\n                                    Rental With Driver\\n                                \", \"item_model_id\": \"6\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Monthly\"}, {\"qty\": \"1\", \"vat\": \"10\", \"price\": \"5\", \"total\": \"132.000\", \"duration\": \"24\", \"item_name\": \"NISSAN SUNNY\", \"period_to\": \"2026-03-02T16:34\", \"service_id\": \"1\", \"period_from\": \"2026-03-01T16:34\", \"rate_type_id\": \"hour\", \"service_name\": \"\\n                                    Rental Without Driver\\n                                \", \"item_model_id\": \"2\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Hourly\"}, {\"qty\": \"1\", \"vat\": \"0\", \"price\": \"1\", \"total\": \"20.000\", \"duration\": \"20\", \"item_name\": \"HYUNDAI ELENTRA\", \"period_to\": \"2026-04-04T18:49\", \"service_id\": \"0\", \"period_from\": \"2026-03-16T18:48\", \"rate_type_id\": \"day\", \"service_name\": \"Select Service\", \"item_model_id\": \"14\", \"item_model_pic\": \"default.jpg\", \"rate_type_name\": \"Daily\"}]', 558.40000, 514.00000, 0.00, 0.0000, 0.0000, 44.40000, 558.40000, '2026-03-17 16:45:52', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', '1234', '<p><strong>Dear Sir,</strong></p><p>Hope you asre doing good</p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>'),
(54, 'DD', 'AA/2026/DD/0020', '2026-03-24', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"TOYOTA COROLLA CROSS\",\"item_model_id\":\"20\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-03-01T09:47\",\"period_to\":\"2026-03-23T09:47\",\"qty\":\"1\",\"price\":\"1\",\"duration\":\"10\",\"vat\":\"10\",\"total\":\"580.800\"}]', 580.80000, 528.00000, 0.00, 0.0000, 0.0000, 52.80000, 580.80000, '2026-03-22 06:48:06', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p><br></p>'),
(55, 'CN', 'AA/2026/CN/0021', '2026-03-30', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"MINI COOPER CONVERTIBLE\",\"item_model_id\":\"78\",\"item_model_pic\":\"default.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-03-30T21:30\",\"period_to\":\"2026-04-03T21:24\",\"qty\":\"2\",\"price\":\"120\",\"duration\":\"4\",\"vat\":\"10\",\"total\":\"1056.000\"}]', 1056.00000, 960.00000, 0.00, 0.0000, 0.0000, 96.00000, 1056.00000, '2026-03-30 15:55:23', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p>'),
(57, 'LS', 'AA/2026/LS/0023', '2026-04-05', 'C0025', 'Anu', '1243214', 'sdfsd@dsf.sdf', 'fdsv', '[{\"item_name\":\"NISSAN SUNNY\",\"item_model_id\":\"2\",\"item_model_pic\":\"sunny.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-06T00:52\",\"period_to\":\"2026-04-23T00:52\",\"qty\":\"1\",\"price\":\"12\",\"duration\":\"17\",\"vat\":\"10\",\"total\":\"224.400\"},{\"item_name\":\"MITSUBISHI LANCER\",\"item_model_id\":\"7\",\"item_model_pic\":\"lancer.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-13T00:52\",\"period_to\":\"2026-05-07T00:52\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"24\",\"vat\":\"0\",\"total\":\"240.000\"},{\"item_name\":\"HYUNDAI ACCENT\",\"item_model_id\":\"5\",\"item_model_pic\":\"accent.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-04-06T00:53\",\"period_to\":\"2026-04-09T00:53\",\"qty\":\"1\",\"price\":\"15\",\"duration\":\"72\",\"vat\":\"10\",\"total\":\"1188.000\"}]', 1652.40000, 1524.00000, 0.00, 0.0000, 0.0000, 128.40000, 1652.40000, '2026-04-05 21:53:50', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'dsf', '<p><strong>Dear Sir, </strong></p><p>Thank you for inviting AA CAR RENTAL to quote for your requirement. We are pleased to confirm that AA CAR RENTAL will be able to provide a comprehensive solution to manage your fleet needs and please find below our competitive proposal: </p>', '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over </span><strong style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">100 languages, including Arabic</strong><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, </span><em style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"><u>though context-aware</u></em><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\"> nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>'),
(58, 'CNM', 'QD/AA/2026/CNM/0015', '2026-04-07', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"NISSAN SUNNY\",\"item_model_id\":\"2\",\"item_model_pic\":\"sunny.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-08T11:14\",\"period_to\":\"2026-04-10T11:14\",\"qty\":\"2\",\"price\":\"12\",\"duration\":\"2\",\"vat\":\"0\",\"total\":\"48.000\"},{\"item_name\":\"MITSUBISHI LANCER\",\"item_model_id\":\"7\",\"item_model_pic\":\"lancer.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-08T11:17\",\"period_to\":\"2026-04-22T11:17\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"14\",\"vat\":\"10\",\"total\":\"154.000\"},{\"item_name\":\"HYUNDAI ACCENT\",\"item_model_id\":\"5\",\"item_model_pic\":\"accent.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-04-07T11:18\",\"period_to\":\"2026-04-08T11:18\",\"qty\":\"1\",\"price\":\"8\",\"duration\":\"24\",\"vat\":\"0\",\"total\":\"192.000\"}]', 394.00000, 380.00000, 0.00, 0.0000, 0.0000, 14.00000, 394.00000, '2026-04-07 08:19:17', 'Yes', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>', '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>'),
(59, 'CNM', 'AA/2026/CNM/0024', '2026-04-07', 'C0020', 'Zaya', '11223344', 'zaya@gmail.com', 'Manama, Kingdom of Bahrain', '[{\"item_name\":\"NISSAN SUNNY\",\"item_model_id\":\"2\",\"item_model_pic\":\"sunny.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-08T11:14\",\"period_to\":\"2026-04-10T11:14\",\"qty\":\"2\",\"price\":\"12\",\"duration\":\"2\",\"vat\":\"0\",\"total\":\"48.000\"},{\"item_name\":\"MITSUBISHI LANCER\",\"item_model_id\":\"7\",\"item_model_pic\":\"lancer.jpg\",\"service_id\":\"1\",\"service_name\":\"\\n                                    Rental Without Driver\\n                                \",\"rate_type_id\":\"day\",\"rate_type_name\":\"Daily\",\"period_from\":\"2026-04-08T11:17\",\"period_to\":\"2026-04-22T11:17\",\"qty\":\"1\",\"price\":\"10\",\"duration\":\"14\",\"vat\":\"10\",\"total\":\"154.000\"},{\"item_name\":\"HYUNDAI ACCENT\",\"item_model_id\":\"5\",\"item_model_pic\":\"accent.jpg\",\"service_id\":\"2\",\"service_name\":\"\\n                                    Rental With Driver\\n                                \",\"rate_type_id\":\"hour\",\"rate_type_name\":\"Hourly\",\"period_from\":\"2026-04-07T11:18\",\"period_to\":\"2026-04-08T11:18\",\"qty\":\"1\",\"price\":\"8\",\"duration\":\"24\",\"vat\":\"0\",\"total\":\"192.000\"}]', 394.00000, 380.00000, 0.00, 0.0000, 0.0000, 14.00000, 394.00000, '2026-04-07 08:19:41', 'No', '0', 1, 'Admin', 1, 'AA Car Rental', 'Zaya Ameen', '<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>', '<p><strong>Terms and Condition</strong></p><p><span style=\"color: rgba(0, 0, 0, 0.96); background-color: rgb(255, 255, 255);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol>');

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
(1, 'AA', 'AA Car Rental', 'default.jpg', 'Active'),
(2, 'CR', 'Class Rental car', 'default.jpg', 'Active');

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
  `driver_documents` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`driver_documents`)),
  `driver_status` varchar(100) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_drivers`
--

INSERT INTO `tbl_drivers` (`ids`, `company_ids`, `driver_name`, `driver_contact_no`, `driver_email_id`, `driver_cpr_no`, `driver_cpr_expiry_date`, `license_no`, `license_issue_place`, `license_issue_date`, `license_expiry_date`, `driver_address`, `created_by`, `created_on`, `driver_documents`, `driver_status`) VALUES
(1, 1, 'Sanju', '5367486', 'sanju@gmail.com', '1232132434', '2027-06-12', '423423', 'Bahtain', '2026-01-01', '2028-12-30', 'test address', '1', '2026-04-20 00:00:00', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"cpr\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/files\\/file_69e5f5bebed433.99906985.pdf\\\"]},{\\\"documentName\\\":\\\"license\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/webp\\/file_69e5f5ce7fbe59.95245746.webp\\\"]}]}\"', 'Active'),
(2, 1, 'Jeffry', '8796734', 'jefy@gmail.com', '762634734', '2027-06-08', '21342342', 'Bahrain', '2026-03-02', '2028-10-20', 'A\'ali, Kingdom of Bahrain', '1', '2026-04-20 00:00:00', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"license\\\",\\\"files\\\":[\\\"uploads\\/driverdocs\\/files\\/file_69e5f77e836f85.80214855.pdf\\\"]}]}\"', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
(6, 'Intro2', '<p>Dear Sir</p><p>Thankyou for choosing AA Car Rental, we hereby submitting the quote as per the requetsed detaios</p>', 1, 1);

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
(2, 'User', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_permissions`
--

CREATE TABLE `tbl_role_permissions` (
  `ids` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_terms_and_condition_contract`
--

INSERT INTO `tbl_terms_and_condition_contract` (`ids`, `terms_condition`, `t_c_name`, `created_at`, `status`, `company_id`, `user_id`) VALUES
(10, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Gurentee for 1 Year </strong></li></ol><p><br></p>', 'With Guarentee', '2026-03-02 17:57:44', 1, 1, 1),
(9, '<p><strong>Terms and Condition</strong></p><p><span style=\"background-color: rgb(255, 255, 255); color: rgba(0, 0, 0, 0.96);\">Translating English to Arabic can be done efficiently using free tools like Google Translate, which supports instant translation between English and over 100 languages, including Arabic. Online platforms also offer user-friendly interfaces for text or document translation into Arabic, ensuring accuracy and speed. These tools are ideal for quick translations, though context-aware nuances may require human review for high-stakes content.</span></p><ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>Payment on Delevery 100%</strong></li><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><strong>No credit Limit is Applicable </strong></li></ol><p><br></p>', 'New Terms and Condition', '2026-03-02 17:54:03', 1, 1, 1),
(12, '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>', '111', '2026-03-15 03:12:24', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(11) NOT NULL,
  `profile_name` varchar(500) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_passkey` varchar(100) DEFAULT NULL,
  `user_role_id` int(11) DEFAULT NULL,
  `user_role_name` varchar(100) NOT NULL,
  `company_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`company_json`)),
  `user_mobile` varchar(100) DEFAULT NULL,
  `user_email` varchar(500) DEFAULT NULL,
  `profile_image` varchar(1000) NOT NULL DEFAULT 'profile.jpg',
  `user_status` varchar(50) DEFAULT 'Active',
  `created_date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `profile_name`, `user_name`, `user_passkey`, `user_role_id`, `user_role_name`, `company_json`, `user_mobile`, `user_email`, `profile_image`, `user_status`, `created_date`) VALUES
(1, 'Administrator', 'admin', 'passme', 1, 'Administrator', '[{\"ids\": \"1\", \"company_name\": \"AA Car Rental\"}, {\"ids\": \"2\", \"company_name\": \"Class Rental car\"}]', '12345', 'admin@gmail.com', 'user_69b97ee7ed01a7.18276602.jpg', 'Active', '2026-03-17'),
(63, NULL, 'ajit', 'kumar', NULL, '', NULL, NULL, NULL, 'profile.jpg', 'Active', '0000-00-00');

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
  `vehicle_year` int(11) NOT NULL,
  `vehicle_color` varchar(100) NOT NULL,
  `image_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`image_json`)),
  `other_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`other_details_json`)),
  `vehicle_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`vehicle_attachments`)),
  `vehicle_status` varchar(100) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `vehicle_purchase_date` date NOT NULL,
  `next_passing_date` date DEFAULT NULL,
  `passing_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`passing_histroy`)),
  `next_insurance_date` date DEFAULT NULL,
  `insurance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`insurance_histroy`)),
  `next_maintenance_date` date DEFAULT NULL,
  `maintenance_histroy` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`maintenance_histroy`))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicles`
--

INSERT INTO `tbl_vehicles` (`ids`, `category_id`, `model_id`, `model_names`, `brand_id`, `company_id`, `vehicle_number`, `vehicle_year`, `vehicle_color`, `image_json`, `other_details_json`, `vehicle_attachments`, `vehicle_status`, `created_on`, `created_by`, `vehicle_purchase_date`, `next_passing_date`, `passing_histroy`, `next_insurance_date`, `insurance_histroy`, `next_maintenance_date`, `maintenance_histroy`) VALUES
(1, 1, 2, 'NISSAN SUNNY', 1, 1, '2343', 2345, 'white', '\"[\\\"veh_69c290d1e2edc9.32182635.jpg\\\",\\\"veh_69c290e0433733.45455497.jpg\\\"]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"testcdescvriptiv\",\"vehiclePricePerHour\":11,\"vehiclePricePerDay\":21,\"vehiclePricePerMonth\":31,\"vehiclePurchasePrice\":1233}', '\"{\\\"documentName\\\":\\\"Doc 2\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c290c728aa66.91516906.webp\\\"]}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-10', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 3, 24, 'TOYOTA URBAN CRUISER', 7, 1, '234324', 4321, 'Black', '\"[\\\"veh_69c2b036b36281.63368692.jpg\\\",\\\"veh_69c2b0483ba268.60945188.jpg\\\"]\"', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"tewst\",\"vehiclePricePerHour\":11,\"vehiclePricePerDay\":11,\"vehiclePricePerMonth\":11,\"vehiclePurchasePrice\":1222}', '\"{\\\"vehiclesdoc\\\":[{\\\"documentName\\\":\\\"Ownership\\\",\\\"files\\\":[{\\\"fileName\\\":\\\"file_69c2afedaf4f00.45853939.pdf\\\"}]},{\\\"documentName\\\":\\\"Insurance\\\",\\\"files\\\":[{\\\"fileName\\\":\\\"file_69c2b01fdd3fd9.01497709.pdf\\\"},{\\\"fileName\\\":\\\"file_69c2b01fdd55b0.94876022.pdf\\\"}]}]}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-01', NULL, NULL, NULL, NULL, NULL, NULL),
(3, 3, 20, 'TOYOTA COROLLA CROSS', 7, 1, '678956', 2019, 'white', '\"[]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"fdgdfg cfgdf\",\"vehiclePricePerHour\":23.89999999999999857891452847979962825775146484375,\"vehiclePricePerDay\":67,\"vehiclePricePerMonth\":389.8999999999999772626324556767940521240234375,\"vehiclePurchasePrice\":3456.456000000000130967237055301666259765625}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"tee\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c2b41724c474.11789665.webp\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-01', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 1, 4, 'HONDA CITY', 3, 1, 'fdg342', 2432, '445fdg', '\"[]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Manual\",\"vehicleDescription\":\"fd\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":0}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"dfs\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48b5a77.52932252.webp\\\",\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48fadb1.90196144.webp\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-04', NULL, NULL, NULL, NULL, NULL, NULL),
(5, 1, 4, 'HONDA CITY', 3, 1, 'fdg342', 2432, '445fdg', '\"[]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Manual\",\"vehicleDescription\":\"fd\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":0}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"dfs\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48b5a77.52932252.webp\\\",\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48fadb1.90196144.webp\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-04', NULL, NULL, NULL, NULL, NULL, NULL),
(6, 1, 4, 'HONDA CITY', 3, 1, 'fdg342', 2432, '445fdg', '\"[]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Manual\",\"vehicleDescription\":\"fd\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":0}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"dfs\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48b5a77.52932252.webp\\\",\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48fadb1.90196144.webp\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-04', NULL, NULL, NULL, NULL, NULL, NULL),
(7, 1, 4, 'HONDA CITY', 3, 1, 'fdg342', 2432, '445fdg', '\"[]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Manual\",\"vehicleDescription\":\"fd\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":0}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"dfs\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48b5a77.52932252.webp\\\",\\\"uploads\\/rentedcars\\/webp\\/file_69c2efe48fadb1.90196144.webp\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-03-04', NULL, NULL, NULL, NULL, NULL, NULL),
(8, 1, 2, 'NISSAN SUNNY', 1, 1, '54342', 435, 'fg', '\"[\\\"veh_69c2fa605156f9.33256614.jpg\\\"]\"', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":342}', '\"{\\\"bookingInfo\\\":{},\\\"drivers\\\":[],\\\"vehicles\\\":[{\\\"documentName\\\":\\\"uuuu\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/files\\/file_69c2fa444e7ca8.25888512.pdf\\\"]}],\\\"clients\\\":[],\\\"payments\\\":{},\\\"action\\\":{}}\"', 'Available', '2026-03-24 00:00:00', 1, '2026-02-17', NULL, '[{\"next_date\":\"2026-03-01\",\"done_date\":\"2026-03-01\",\"added_info\":\"dsf\",\"remarks\":\"dsf\",\"documents\":[{\"name\":\"hatchback.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69c8f1f849a889.74314212.jpg\",\"id\":\"1775550793555_va8jt3jrj\"}],\"created_at\":\"2026-03-29\",\"id\":\"1775550793555_3ws0a3uht\"},{\"next_date\":\"2026-03-01\",\"done_date\":\"2026-03-01\",\"added_info\":\"dsf\",\"remarks\":\"dsf\",\"documents\":[{\"name\":\"hatchback.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69c8f210cf7166.37249928.jpg\",\"id\":\"1775550793555_do3fl7vub\"}],\"created_at\":\"2026-03-29\",\"id\":\"1775550793555_v78ae0pph\"},{\"id\":\"1775550827607_0.564830391240319\",\"added_info\":\"tt\",\"next_date\":\"2026-04-08\",\"done_date\":\"2026-04-07\",\"remarks\":\"test\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69d4c16cbe6d85.91144523.jpg\",\"isNew\":false,\"id\":\"1775550827607_5ap8z4ne1\"}]}]', '2026-04-15', '[{\"id\":\"1775550882308_0.319510962286654\",\"added_info\":\"yy\",\"next_date\":\"2026-04-15\",\"done_date\":\"2026-04-08\",\"remarks\":\"tredt\",\"documents\":[]}]', '2026-04-16', '[{\"added_info\":\"cg\",\"next_date\":\"2026-04-16\",\"done_date\":\"2026-04-08\",\"remarks\":\"dghd\",\"documents\":[]}]'),
(9, 1, 1, 'NISSAN MICRA', 1, 1, '12345', 2019, 'Blue', '\"[\\\"veh_69c312f344a0e9.42444548.jpg\\\"]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"ttt\",\"vehiclePricePerHour\":324,\"vehiclePricePerDay\":12,\"vehiclePricePerMonth\":1,\"vehiclePurchasePrice\":3123}', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"yyyy\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c31573d7ea96.67795550.webp\\\"]},{\\\"documentName\\\":\\\"iop\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/files\\/file_69c3191e507a07.06472001.pdf\\\"]}]}\"', 'Available', '2026-03-25 00:00:00', 1, '2026-02-22', '2026-04-11', '[{\"next_date\":\"2026-05-08\",\"done_date\":\"2026-03-06\",\"added_info\":\"testing123343434\",\"remarks\":\"testing...123333333\",\"documents\":[{\"name\":\"isa pjt.docx\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69c8e340216775.25164014.docx\",\"id\":\"1775259053396_e9z4klez6\"},{\"name\":\"hatchback.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69c8e340219010.23921341.jpg\",\"id\":\"1775259053396_jhwxgjya6\"},{\"name\":\"luxury_sedan.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69c8e340219738.16603912.jpg\",\"id\":\"1775259053396_a7blnqhbv\"},{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cbe379e45cd0.32581980.jpg\",\"isNew\":false,\"id\":\"1775259053396_5tksu3j5w\"}],\"created_at\":\"2026-03-29\",\"id\":\"1775259053396_lzpmmnmbo\"},{\"added_info\":\"testing\",\"next_date\":\"2026-04-11\",\"done_date\":\"2026-03-03\",\"remarks\":\"testing...\",\"documents\":[],\"id\":\"1775259053396_2l1t1wbi3\"},{\"added_info\":\"testing\",\"next_date\":\"2026-04-11\",\"done_date\":\"2026-03-03\",\"remarks\":\"testing...\",\"documents\":[],\"id\":\"1775259053396_3o43ybmdk\"},{\"added_info\":\"ttttt\",\"next_date\":\"2026-04-21\",\"done_date\":\"2026-03-30\",\"remarks\":\"tttt\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccee81adcea1.84968861.jpg\",\"isNew\":false,\"id\":\"1775259053396_uluwnj21p\"},{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cceec8b321e0.17986926.jpg\",\"isNew\":false,\"id\":\"1775259053396_heecfgykb\"}],\"id\":\"1775259053396_ehqmx1gib\"},{\"added_info\":\"asd\",\"next_date\":\"2026-04-20\",\"done_date\":\"2026-04-09\",\"remarks\":\"sadas123\",\"documents\":[{\"name\":\"cust_icon.png\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccf22a4bde34.52984961.png\",\"isNew\":false,\"id\":\"1775259053396_a8gt45ehu\"},{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccf2a3da00a7.73544340.jpg\",\"isNew\":false,\"id\":\"1775259053396_eehuugqd9\"},{\"name\":\"133635456243004763.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccf331d31bd0.46475798.jpg\",\"isNew\":false,\"id\":\"1775259053396_tvn1er0s3\"},{\"name\":\"133616973285925745.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccfb65be51d2.24158563.jpg\",\"isNew\":false,\"id\":\"1775259053396_5bn1vaije\"}],\"id\":\"1775259053396_pqr3nffd3\"},{\"added_info\":\"ert\",\"next_date\":\"2026-04-21\",\"done_date\":\"2026-03-31\",\"remarks\":\"drgd\",\"documents\":[{\"name\":\"133863953456603417.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccfd7a9b4d96.26084380.jpg\",\"isNew\":false,\"id\":\"1775259053396_35b93kw8j\"}],\"id\":\"1775259053396_jkmmhuozw\"},{\"added_info\":\"fgd\",\"next_date\":\"2026-05-21\",\"done_date\":\"2026-05-05\",\"remarks\":\"gfh234\",\"documents\":[{\"name\":\"23-1064.pdf\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccfd663ab8f1.45185850.pdf\",\"isNew\":false,\"id\":\"1775259053396_0bn1vwuju\"},{\"name\":\"23-1080.pdf\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69ccfd663ad8d2.74920874.pdf\",\"isNew\":false,\"id\":\"1775259053396_bxl24ok4g\"}],\"id\":\"1775259053396_pgx9vgg34\"},{\"added_info\":\"xsda\",\"next_date\":\"2026-04-17\",\"done_date\":\"2026-04-03\",\"remarks\":\"sad\",\"documents\":[],\"id\":\"1775259053396_4dkad2lgz\"},{\"added_info\":\"asd\",\"next_date\":\"2026-04-29\",\"done_date\":\"2026-04-10\",\"remarks\":\"asdsa\",\"documents\":[{\"name\":\"133863953456603417.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cd0d5d5a7949.36064255.jpg\",\"isNew\":false,\"id\":\"1775259053396_qzkwzeg6w\"}],\"id\":\"1775259053396_up8fd4dth\"},{\"added_info\":\"asd\",\"next_date\":\"2026-04-18\",\"done_date\":\"2026-04-15\",\"remarks\":\"asd\",\"documents\":[],\"id\":\"1775259053396_g2lj1kbov\"},{\"added_info\":\"erdf\",\"next_date\":\"2026-05-01\",\"done_date\":\"2026-04-14\",\"remarks\":\"dg\",\"documents\":[{\"name\":\"133677224870117181.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cd0dbf4a0d51.73102265.jpg\",\"isNew\":false,\"id\":\"1775259053396_l2frf93y0\"},{\"name\":\"default.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cd0de4a2f314.63371714.jpg\",\"isNew\":false,\"id\":\"1775259053396_oc5chh3r0\"},{\"name\":\"pickup.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69cd0de4a2fd01.38003279.jpg\",\"isNew\":false,\"id\":\"1775259053396_pdlh5jq00\"}],\"id\":\"1775259053396_01uokgs1g\"},{\"id\":\"1775259405241_0.17164801201437896\",\"added_info\":\"zxc\",\"done_date\":\"2026-04-08\",\"remarks\":\"zxc\",\"documents\":[{\"name\":\"medium_suv.jpg\",\"url\":\"\\/images\\/vehicle_passing_documents\\/veh_69d04eb1bda243.79712618.jpg\",\"isNew\":false,\"id\":\"1775259313434_fdoi51con\"}],\"next_date\":\"2026-04-19\"}]', '2026-04-06', '[{\"added_info\":\"sdfwerw\",\"next_date\":\"2026-04-06\",\"done_date\":\"2026-04-01\",\"remarks\":\"sdf\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69cd41c1a854f6.28523112.jpg\",\"isNew\":false,\"id\":\"1775259395488_mbho6ainf\"},{\"name\":\"23-1080.pdf\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69cd45d7dc0c17.91204439.pdf\",\"isNew\":false,\"id\":\"1775259395488_j8kava1p3\"},{\"name\":\"23-1080.pdf\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69cd46042b4e95.71598081.pdf\",\"isNew\":false,\"id\":\"1775259395488_fut29ur4t\"}],\"id\":\"1775259395488_p32k14epx\"},{\"added_info\":\"fdgdf\",\"next_date\":\"2026-05-01\",\"done_date\":\"2026-04-15\",\"remarks\":\"gffdg\",\"documents\":[{\"name\":\"23-1080.pdf\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69cd46676cb096.36151579.pdf\",\"isNew\":false,\"id\":\"1775259395488_gvu6owwmi\"}],\"id\":\"1775259395488_x8dmz7uss\"},{\"added_info\":\"asd\",\"next_date\":\"2026-04-16\",\"done_date\":\"2026-04-09\",\"remarks\":\"adf\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d019d161ed34.55687139.jpg\",\"isNew\":false,\"id\":\"1775259395488_pph2becch\"},{\"name\":\"2.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d019d18a1e17.29484502.jpg\",\"isNew\":false,\"id\":\"1775259395488_fz1zj54f7\"},{\"name\":\"3.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d019d19da4a1.54022831.jpg\",\"isNew\":false,\"id\":\"1775259395488_yfmcm9w3h\"},{\"name\":\"133616973285925745.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d019d1d6fa88.58280140.jpg\",\"isNew\":false,\"id\":\"1775259395488_wfvbkz972\"},{\"name\":\"133905646041634409.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d01a08395245.12652823.jpg\",\"isNew\":false,\"id\":\"1775259395488_xeylet46p\"}],\"id\":\"1775259395488_kcmeie1g7\"},{\"id\":\"1775259453431_0.28704891025559276\",\"added_info\":\"dcsad\",\"next_date\":\"2026-05-03\",\"done_date\":\"2026-04-30\",\"remarks\":\"asasd\",\"documents\":[{\"name\":\"medium_suv.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d04f2aa32ee1.72152811.jpg\",\"isNew\":false,\"id\":\"1775259434315_noxev05s0\"},{\"name\":\"hatchback.jpg\",\"url\":\"\\/images\\/vehicle_insurance_document\\/veh_69d04f3dbdf968.21390604.jpg\",\"isNew\":false,\"id\":\"1775259453431_2x78bkq43\"}]}]', '2026-04-10', '[{\"added_info\":\"yrtet\",\"next_date\":\"2026-04-10\",\"done_date\":\"2026-04-03\",\"remarks\":\"dfgd\",\"documents\":[],\"id\":\"1775254781307_mlnlld2b1\"},{\"added_info\":\"yyyy\",\"next_date\":\"2026-05-01\",\"done_date\":\"2026-04-15\",\"remarks\":\"fgd\",\"documents\":[{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfe8fb8ee922.65650622.jpg\",\"isNew\":false,\"id\":\"1775254781307_uhja9dmxn\"}],\"id\":\"1775254781307_o2ulbt1hj\"},{\"added_info\":\"rrrr\",\"next_date\":\"2026-04-29\",\"done_date\":\"2026-04-07\",\"remarks\":\"sdf\",\"documents\":[{\"name\":\"133905646041634409.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfe979e74918.52851405.jpg\",\"isNew\":false,\"id\":\"1775254781307_3fut4vhd7\"},{\"name\":\"133911760273277308.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfe979e77e58.51647798.jpg\",\"isNew\":false,\"id\":\"1775254781307_snbvzl4bm\"}],\"id\":\"1775254781307_3sb19c7l7\"},{\"added_info\":\"testmaintence\",\"next_date\":\"2026-05-03\",\"done_date\":\"2026-04-03\",\"remarks\":\"testmaintenance\",\"documents\":[{\"name\":\"133677224870117181.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeaa363e149.68492875.jpg\",\"isNew\":false,\"id\":\"1775254781307_0t76i7bap\"},{\"name\":\"cust_icon.png\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeaa3645ad9.99643261.png\",\"isNew\":false,\"id\":\"1775254781307_il664j6xb\"}],\"id\":\"1775254781307_mwam3yy6a\"},{\"added_info\":\"iuiui\",\"next_date\":\"\",\"done_date\":\"2026-04-21\",\"remarks\":\"uuuu\",\"documents\":[{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeac8e56ad2.65337015.jpg\",\"isNew\":false,\"id\":\"1775254781307_rpen5w2v7\"}],\"id\":\"1775254781307_edjcpvjdl\"},{\"added_info\":\"fgd\",\"next_date\":\"2026-04-22\",\"done_date\":\"2026-04-03\",\"remarks\":\"gfd\",\"documents\":[{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeb190b89c7.90064895.jpg\",\"isNew\":false,\"id\":\"1775254781307_o0rnskks6\"},{\"name\":\"133879786674228467.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeb190c02e1.35616000.jpg\",\"isNew\":false,\"id\":\"1775254781307_npj0dlr8y\"}],\"id\":\"1775254781307_rl769r0w9\"},{\"added_info\":\"tyut\",\"next_date\":\"2026-04-22\",\"done_date\":\"2026-04-19\",\"remarks\":\"tyuty\",\"documents\":[{\"name\":\"23-1064.pdf\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeb6721c4d6.84666624.pdf\",\"isNew\":false,\"id\":\"1775254781307_ajofisi31\"},{\"name\":\"23-1080.pdf\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69cfeb6721d9f0.95319422.pdf\",\"isNew\":false,\"id\":\"1775254781307_vruevbxrq\"}],\"id\":\"1775254781307_vm0nom820\"},{\"added_info\":\"vfdf\",\"next_date\":\"2026-04-29\",\"done_date\":\"2026-04-15\",\"remarks\":\"fxdg\",\"documents\":[{\"name\":\"2.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d0119405b299.88725665.jpg\",\"isNew\":false,\"id\":\"1775254781307_0rtc3zr4x\"},{\"name\":\"3.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d01194436933.39490092.jpg\",\"isNew\":false,\"id\":\"1775254781307_4gl6s8wl4\"},{\"name\":\"133616973285925745.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d01194b2f735.65141174.jpg\",\"isNew\":false,\"id\":\"1775254781307_76g6401mn\"}],\"id\":\"1775254781307_n0b1ajxlv\"},{\"added_info\":\"xx\",\"next_date\":\"2026-04-21\",\"done_date\":\"2026-04-15\",\"remarks\":\"xz\",\"documents\":[{\"name\":\"133677224870117181.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d0130df0cc45.61601435.jpg\",\"isNew\":false,\"id\":\"1775247065584_0.6149554847351113\"},{\"name\":\"133863953456603417.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d0130e03fb24.33951608.jpg\",\"isNew\":false,\"id\":\"1775247065584_0.04863544617934046\"},{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d013217e94f4.27890747.jpg\",\"isNew\":false,\"id\":\"1775247065584_0.5177968756889234\"}],\"id\":\"1775254781307_05nytbsou\"},{\"added_info\":\"wqe\",\"next_date\":\"2026-04-17\",\"done_date\":\"2026-04-02\",\"remarks\":\"qwe\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d0253621df43.40383332.jpg\",\"isNew\":false,\"id\":\"1775254781307_zf48uoe02\"},{\"name\":\"2.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d02536358816.80761206.jpg\",\"isNew\":false,\"id\":\"1775254781307_ui31anwgh\"}],\"id\":\"1775254781307_4lam5dsao\"},{\"added_info\":\"dsf\",\"next_date\":\"2026-04-29\",\"done_date\":\"2026-04-23\",\"remarks\":\"sdf\",\"documents\":[{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d02fa318f1b6.27109537.jpg\",\"isNew\":false,\"id\":\"1775251367508_0.491337165082118\"},{\"name\":\"133863953456603417.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d02fba01a283.42124681.jpg\",\"isNew\":false,\"id\":\"1775254781307_tepdjrllx\"}],\"id\":\"1775254781307_jtcsdae6e\"},{\"id\":\"1775254869473_0.685135107056245\",\"added_info\":\"wtret\",\"next_date\":\"2026-04-15\",\"done_date\":\"2026-04-06\",\"remarks\":\"fdg\",\"documents\":[{\"name\":\"1.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d03bd10fa624.81967063.jpg\",\"isNew\":false,\"id\":\"1775254781307_csdgg2xpt\"},{\"name\":\"3.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d03bd260a505.61338919.jpg\",\"isNew\":false,\"id\":\"1775254781307_cktenoqcj\"}]},{\"id\":\"1775255427675_0.3717703621955827\",\"added_info\":\"ASx\",\"next_date\":\"2026-04-27\",\"done_date\":\"2026-04-09\",\"remarks\":\"sx\",\"documents\":[{\"name\":\"133659398500417373.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d03d17db1d20.92114938.jpg\",\"isNew\":false,\"id\":\"1775254820716_0.3657573654817867\"}]},{\"id\":\"1775255486712_0.8625375731708016\",\"added_info\":\"afds\",\"next_date\":\"2026-04-16\",\"done_date\":\"2026-04-07\",\"remarks\":\"dsf\",\"documents\":[]},{\"id\":\"1775257394018_0.16529549636445173\",\"added_info\":\"sad\",\"next_date\":\"2026-04-16\",\"done_date\":\"2026-04-17\",\"remarks\":\"sa\",\"documents\":[{\"name\":\"default.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d046f04f03e6.33529521.jpg\",\"isNew\":false,\"id\":\"1775257328061_3zgfjrqpz\"},{\"name\":\"hatchback.jpg\",\"url\":\"\\/images\\/vehicle_maintenance_documents\\/veh_69d046f06bd585.13583234.jpg\",\"isNew\":false,\"id\":\"1775257328061_50wy1utp8\"}]}]'),
(10, 2, 15, 'KIA OPTIMA', 5, 1, '678765', 2000, 'Black', '\"[\\\"veh_69c31b279c1eb6.81080172.jpg\\\"]\"', '{\"vehicleFuelType\":\"Diesel\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"test\",\"vehiclePricePerHour\":10,\"vehiclePricePerDay\":20,\"vehiclePricePerMonth\":40,\"vehiclePurchasePrice\":2000}', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"Ownership certificate\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/files\\/file_69c31b12b96129.60087402.pdf\\\",\\\"uploads\\/rentedcars\\/files\\/file_69c31b12b97ae3.31464645.pdf\\\"]},{\\\"documentName\\\":\\\"tt\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c31c516b54f6.03377151.webp\\\"]},{\\\"documentName\\\":\\\"uu\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69c31c63e150f5.18563168.webp\\\"]}]}\"', 'Available', '2026-03-25 00:00:00', 1, '2026-02-05', NULL, NULL, NULL, NULL, NULL, NULL),
(11, 1, 1, 'NISSAN MICRA', 1, 1, '2222', 222, 'fdwe', '\"[\\\"veh_69db4be69da117.55833232.jpg\\\"]\"', '{\"vehicleFuelType\":\"Petrol\",\"vehicleGearType\":\"Automatic\",\"vehicleDescription\":\"adas\",\"vehiclePricePerHour\":0,\"vehiclePricePerDay\":0,\"vehiclePricePerMonth\":0,\"vehiclePurchasePrice\":12222}', '\"{\\\"vehicles\\\":[{\\\"documentName\\\":\\\"tt\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69db4b9ddef0b7.10249108.webp\\\"]},{\\\"documentName\\\":\\\"123\\\",\\\"files\\\":[\\\"uploads\\/rentedcars\\/webp\\/file_69db4bab7c6c65.76619329.webp\\\"]}]}\"', 'Available', '2026-04-12 00:00:00', 1, '2026-03-31', NULL, NULL, NULL, NULL, NULL, NULL);

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
  `customer_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customer_details_json`)),
  `book_from_date` datetime NOT NULL,
  `book_to_date` datetime DEFAULT NULL,
  `book_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`book_details_json`)),
  `book_status` varchar(100) DEFAULT NULL,
  `company_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_bookings`
--

INSERT INTO `tbl_vehicle_bookings` (`ids`, `booking_no`, `category_id`, `category_name`, `brand_id`, `brand_name`, `model_id`, `model_name`, `vehicle_id`, `vehicle_no`, `book_through`, `quotation_number`, `customer_code`, `customer_name`, `customer_details_json`, `book_from_date`, `book_to_date`, `book_details_json`, `book_status`, `company_id`, `user_id`, `created_date`, `modified_date`) VALUES
(1, 'AA/2026/RS/0001', 2, 'MEDIUM CARS', 5, 'KIA', 15, 'OPTIMA ', 10, '678765', 'direct', '', 'C0025', 'Anu', '{\"customer_code\":\"C0025\",\"customer_name\":\"Anu\",\"phone\":\"1243214\",\"email\":\"sdfsd@dsf.sdf\",\"address\":\"fdsv\",\"attention\":\"dsf\"}', '2026-04-01 12:03:00', '2026-04-10 12:03:00', '{\"fromDate\":\"2026-04-01T12:03\",\"toDate\":\"2026-04-10T12:03\",\"rateType\":\"0\",\"service\":\"0\",\"duration\":\"0\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}', 'Booked', 1, 1, '2026-04-08 12:04:15', '2026-05-16 23:20:31'),
(2, 'AA/2026/RS/0002', 1, 'SMALL CARS', 1, 'NISSAN', 2, 'SUNNY', 1, '2343', 'direct', '', 'C0020', 'Zaya', '{\"customer_code\":\"C0020\",\"customer_name\":\"Zaya\",\"phone\":\"11223344\",\"email\":\"zaya@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"Zaya Ameen\"}', '2026-04-02 16:51:00', '2026-04-30 16:51:00', '{\"fromDate\":\"2026-04-02T16:51\",\"toDate\":\"2026-04-30T16:51\",\"rateType\":\"0\",\"service\":\"0\",\"duration\":\"0\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}', 'Booked', 1, 1, '2026-04-08 16:53:17', '2026-04-08 16:53:17'),
(3, 'AA/2026/RS/0002', 1, 'SMALL CARS', 1, 'NISSAN', 2, 'SUNNY', 8, '54342', 'direct', '', 'C0020', 'Zaya', '{\"customer_code\":\"C0020\",\"customer_name\":\"Zaya\",\"phone\":\"11223344\",\"email\":\"zaya@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"Zaya Ameen\"}', '2026-04-02 16:51:00', '2026-04-30 16:51:00', '{\"fromDate\":\"2026-04-02T16:51\",\"toDate\":\"2026-04-30T16:51\",\"rateType\":\"0\",\"service\":\"0\",\"duration\":\"0\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}', 'Booked', 1, 1, '2026-04-08 16:53:17', '2026-04-15 19:23:26'),
(4, 'AA/2026/RS/0002', 1, 'SMALL CARS', 1, 'NISSAN', 1, 'MICRA', 9, '12345', 'direct', '', 'C0020', 'Zaya', '{\"customer_code\":\"C0020\",\"customer_name\":\"Zaya\",\"phone\":\"11223344\",\"email\":\"zaya@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"Zaya Ameen\"}', '2026-04-02 16:51:00', '2026-04-30 16:51:00', '{\"fromDate\":\"2026-04-02T16:51\",\"toDate\":\"2026-04-30T16:51\",\"rateType\":\"0\",\"service\":\"0\",\"duration\":\"0\",\"price\":\"0\",\"vat\":\"10\",\"total\":\"0.000\",\"notes\":\"\",\"quotation_ref\":\"\"}', 'Booked', 1, 1, '2026-04-08 16:53:17', '2026-04-27 17:16:37'),
(5, 'AA/2026/RS/0003', 1, 'SMALL CARS', 1, 'NISSAN', 2, 'SUNNY', 1, '2343', 'direct', '', 'C0025', 'Anu', '{\"customer_code\":\"C0025\",\"customer_name\":\"Anu\",\"phone\":\"1243214\",\"email\":\"sdfsd@dsf.sdf\",\"address\":\"fdsv\",\"attention\":\"dsf\"}', '2026-04-01 18:08:00', '2026-04-30 18:08:00', '{\"fromDate\":\"2026-04-01T18:08\",\"toDate\":\"2026-04-30T18:08\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"696\",\"price\":\"13\",\"vat\":\"10\",\"total\":\"9952.800\",\"notes\":\"\",\"quotation_ref\":\"\"}', 'Confirmed', 1, 1, '2026-04-13 18:10:57', '2026-04-19 11:27:27'),
(6, 'AA/2026/RS/0004', 1, 'SMALL CARS', 1, 'NISSAN', 1, 'MICRA', 9, '12345', 'direct', '', 'C0020', 'Zaya', '{\"customer_code\":\"C0020\",\"customer_name\":\"Zaya\",\"phone\":\"11223344\",\"email\":\"zaya@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"Zaya Ameen\"}', '2026-04-26 10:27:00', '2026-05-20 10:27:00', '{\"fromDate\":\"2026-04-26T10:27\",\"toDate\":\"2026-05-20T10:27\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"576\",\"price\":\"8\",\"vat\":\"10\",\"total\":\"5068.800\",\"notes\":\"test\",\"quotation_ref\":\"\"}', 'Cancelled', 1, 1, '2026-05-05 10:28:09', '2026-05-17 18:25:25'),
(7, 'AA/2026/RS/0004', 1, 'SMALL CARS', 1, 'NISSAN', 1, 'MICRA', 11, '2222', 'direct', '', 'C0020', 'Zaya', '{\"customer_code\":\"C0020\",\"customer_name\":\"Zaya\",\"phone\":\"11223344\",\"email\":\"zaya@gmail.com\",\"address\":\"Manama, Kingdom of Bahrain\",\"attention\":\"Zaya Ameen\"}', '2026-04-26 10:27:00', '2026-05-20 10:27:00', '{\"fromDate\":\"2026-04-26T10:27\",\"toDate\":\"2026-05-20T10:27\",\"rateType\":\"hour\",\"service\":\"1\",\"duration\":\"576\",\"price\":\"8\",\"vat\":\"10\",\"total\":\"5068.800\",\"notes\":\"test\",\"quotation_ref\":\"\"}', 'Confirmed', 1, 1, '2026-05-05 10:28:09', '2026-05-17 18:04:01');

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
(22, 'ISUZU', '', 'Active', 'default.jpg');

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
(12, 'SIX WHEEL / FLAT BED  / TOWING', 'default.jpg', 'Heavy-duty vehicles designed for transporting large loads, equipment, or towing other vehicles.', 'Active');

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
  `price_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`price_json`))
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_model`
--

INSERT INTO `tbl_vehicle_model` (`ids`, `category_id`, `brand_id`, `modal_name`, `vehicle_modal_pic`, `model_status`, `model_description`, `price_json`) VALUES
(1, 1, 1, 'MICRA', 'micra.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"5\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"5\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"5\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"5\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"5\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"5\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"5\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"5\"}]'),
(2, 1, 1, 'SUNNY', 'sunny.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"10\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"11\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"12\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"13\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"14\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"15\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"16\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"17\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"\"}]'),
(3, 1, 2, 'ALSVIN', 'alsvin.jpg', 'Active', NULL, NULL),
(4, 1, 3, 'CITY', 'city.jpg', 'Active', NULL, NULL),
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
(36, 4, 12, '5 SERIES', 'default.jpg', 'Active', NULL, '[{\"ids\":\"1\",\"item\":\"Price per hour rental without driver\",\"amount\":\"342\"},{\"ids\":\"2\",\"item\":\"Price per hour rental with driver\",\"amount\":\"45\"},{\"ids\":\"3\",\"item\":\"Price per day rental without driver\",\"amount\":\"9.253\"},{\"ids\":\"4\",\"item\":\"Price per day rental with driver\",\"amount\":\"8\"},{\"ids\":\"5\",\"item\":\"Price per week rental without driver\",\"amount\":\"7\"},{\"ids\":\"6\",\"item\":\"Price per week rental with driver\",\"amount\":\"8\"},{\"ids\":\"7\",\"item\":\"Price per month rental without driver\",\"amount\":\"3\"},{\"ids\":\"8\",\"item\":\"Price per month rental with driver\",\"amount\":\"5.485\"},{\"ids\":\"9\",\"item\":\"hjkhn\",\"amount\":\"0\"}]'),
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
(50, 5, 1, 'X-TRAIL', 'default.jpg', 'Active', NULL, NULL),
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
(86, 12, 22, 'NPR DOUBLE CABIN', 'default.jpg', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vehicle_pricing_master`
--

CREATE TABLE `tbl_vehicle_pricing_master` (
  `ids` int(11) NOT NULL,
  `price_item` varchar(1000) DEFAULT NULL,
  `price_status` varchar(100) DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_pricing_master`
--

INSERT INTO `tbl_vehicle_pricing_master` (`ids`, `price_item`, `price_status`) VALUES
(1, 'Price per hour rental without driver', 'Active'),
(2, 'Price per hour rental with driver', 'Active'),
(3, 'Price per day rental without driver', 'Active'),
(4, 'Price per day rental with driver', 'Active'),
(5, 'Price per week rental without driver', 'Active'),
(6, 'Price per week rental with driver', 'Active'),
(7, 'Price per month rental without driver', 'Active'),
(8, 'Price per month rental with driver', 'Active'),
(9, 'hjkhn', 'Active');

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
  `customer_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customer_details`)),
  `quotation_number` varchar(200) NOT NULL,
  `vehicle_category_id` int(11) DEFAULT NULL,
  `vehicle_model_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `vehicle_no` varchar(100) DEFAULT NULL,
  `vechile_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vechile_details`)),
  `service_type` varchar(100) DEFAULT NULL,
  `service_start_date_time` datetime DEFAULT NULL,
  `service_end_date_time` datetime DEFAULT NULL,
  `contract_details_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contract_details_json`)),
  `km_in` decimal(18,3) DEFAULT NULL,
  `km_out` decimal(18,3) DEFAULT NULL,
  `km_used` decimal(18,3) DEFAULT NULL,
  `vehicle_accessories_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vehicle_accessories_details`)),
  `extend_date` date DEFAULT NULL,
  `lease_period` int(11) DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `remarks1` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`remarks1`)),
  `remarks2` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`remarks2`)),
  `terms_condition` longtext DEFAULT NULL,
  `vehicle_rentout_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`vehicle_rentout_images`)),
  `driver_status` varchar(100) DEFAULT NULL,
  `driver_ids` int(11) DEFAULT NULL,
  `driver_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`driver_details`)),
  `customer_driver_name` varchar(1000) DEFAULT NULL,
  `customer_driver_contact_number` varchar(100) DEFAULT NULL,
  `customer_driver_attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`customer_driver_attachments`)),
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
  `minprice_otp_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`minprice_otp_details`)),
  `log_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`log_json`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_vehicle_rentout_contracts`
--

INSERT INTO `tbl_vehicle_rentout_contracts` (`ids`, `company_id`, `booking_ids`, `agreement_no`, `agreement_group_ref_no`, `agreement_date`, `customer_code`, `customer_name`, `customer_details`, `quotation_number`, `vehicle_category_id`, `vehicle_model_id`, `vehicle_id`, `vehicle_no`, `vechile_details`, `service_type`, `service_start_date_time`, `service_end_date_time`, `contract_details_json`, `km_in`, `km_out`, `km_used`, `vehicle_accessories_details`, `extend_date`, `lease_period`, `return_date`, `remarks1`, `remarks2`, `terms_condition`, `vehicle_rentout_images`, `driver_status`, `driver_ids`, `driver_details`, `customer_driver_name`, `customer_driver_contact_number`, `customer_driver_attachments`, `received_by`, `delivered_by`, `hirer_signature`, `hirer_name`, `hirer_signature_date`, `hier_signature_status`, `hirer_signed_ip`, `hirer_signed_device`, `delivered_signature_status`, `delivered_signature`, `delivered_signatory`, `delivered_signature_date`, `delivered_signed_ip`, `delivered_signed_device`, `minprice_otp_details`, `log_json`) VALUES
(1, 1, 7, 'AA/2026/AGR/0003', 'AA/2026/RS/0004', '2026-05-17', 'C0020', 'Zaya', '{\"customer_name\":\"Zaya\",\"customer_code\":\"C0020\",\"customer_mobile\":\"11223344\",\"customer_email\":\"zaya@gmail.com\",\"customer_attention\":\"Zaya Ameen\",\"customer_address\":\"Manama, Kingdom of Bahrain\"}', '', 1, 1, 11, '2222', '{\"vehicle_id\":\"11\",\"category_id\":\"1\",\"model_id\":\"1\",\"veh_no\":\"2222\",\"category_name\":\"SMALL CARS\",\"model_name\":\"NISSAN MICRA\",\"vehicle_color\":\"fdwe\",\"vehicle_year\":\"222\"}', 'Rental Without Driver', '2026-04-26 10:27:00', '2026-05-20 10:27:00', '{\"period_from\":\"2026-04-26T10:27\",\"period_to\":\"2026-05-20T10:27\",\"rate_type_id\":\"hour\",\"rate_type\":\"Hourly\",\"service_id\":\"1\",\"service_name\":\"Rental Without Driver\",\"duration\":\"576\",\"unit_price\":\"8\",\"min_price\":\"5.000\",\"vat\":\"10\",\"total_amt\":\"5068.800\",\"qtn_ref_no\":\"\",\"booking_notes\":\"test\",\"otp_details\":\"\"}', NULL, 100.000, NULL, '{\"chk_tools\":\"Yes\",\"chk_spare\":\"Yes\",\"chk_radio\":\"No\",\"date_out\":\"2026-05-05T18:07\",\"vehicle_km_out\":\"100\",\"cust_driver_name\":\"dsdf\",\"cust_driver_contact_no\":\"32432\",\"cust_driver_documents\":{\"vehicles\":[]},\"vehicle_images\":[\"1779030485_8275.jpg\"]}', NULL, NULL, NULL, NULL, NULL, '<p>The above lease rates are valid for a period of 7 days and are subject to re- confirmation. Vehicles quoted are also subject to availability based on dealer stocks, specifications could change depending on dealer imports. New leased vehicle will be purchased after all original documents like contracts, six to four months bank statements, postdated cheques, security deposit etc. are received by AA CAR RENTAL and are subject to internal credit approval. AA CAR RENTAL Terms and Conditions apply.</p><p><em> Note: Mileage limited to 30,000kms per annum, payment against invoice, above lease rates quoted are inclusive of VAT as per government regulations. </em></p><p><strong>Best Regards, </strong></p><p><strong>AA CAR RENTAL CO. W.L.L. </strong></p>', '[\"1779030485_8275.jpg\"]', NULL, 0, '{\"driver_id\":null,\"driver_name\":\"Select Driver\",\"driver_mobile\":\"\",\"driver_license_no\":\"\",\"driver_license_issplace\":\"\",\"driver_license_issdate\":\"\",\"driver_license_expdate\":\"\"}', 'dsdf', '32432', '{\"vehicles\":[]}', NULL, NULL, 'uploads/signatures/hirer_7_1779087920.png', 'tttt', '2026-05-18 10:05:20', 'Yes', '46.184.209.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'Yes', 'uploads/signatures/delivery_7_1779087920.png', 'uuhggg', '2026-05-18 10:05:20', '46.184.209.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', '\"\"', '{\"user_id\":1,\"datetime\":\"2026-05-18 10:05:02\"}');

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
  `vehicles_details` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`vehicles_details`)),
  `vehicles_status` varchar(25) NOT NULL DEFAULT 'Available',
  `vehicles_number` int(11) NOT NULL,
  `vehicles_passing_date` date NOT NULL,
  `vehicles_insurance_date` datetime NOT NULL,
  `vehicles_purchase_date` date NOT NULL,
  `vehicles_modal` int(11) NOT NULL,
  `category` varchar(200) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `company_name` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`ids`, `vehicles_name`, `vehicles_details`, `vehicles_status`, `vehicles_number`, `vehicles_passing_date`, `vehicles_insurance_date`, `vehicles_purchase_date`, `vehicles_modal`, `category`, `company_id`, `company_name`) VALUES
(49, 'ford', '{\"images\": [\"veh_699427a37247e0.95112347.jpg\"], \"chargeTax\": 1, \"description\": \"<ol><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Vehicular computers, human-machine interfaces, sensors and meters</span></li><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Real-time data processing, artificial intelligence, cloud computing, modelling and simulation</span></li><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Intelligent transportation, vehicle information, industrial IoT in vehicles</span></li><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Cooperative/V2V/V2I communications</span></li><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Positioning, localisation, navigation, mobility management</span></li><li data-list=\\\"bullet\\\"><span class=\\\"ql-ui\\\" contenteditable=\\\"false\\\"></span><span style=\\\"background-color: rgb(255, 255, 255); color: rgb(103, 106, 123);\\\">Communication theory/protocols</span></li></ol><p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"120\", \"vehicleMaxDiscountPrice\": \"100\"}', 'Available', 4543545, '2026-03-09', '0000-00-00 00:00:00', '2026-03-14', 2012, 'Luxury Car', 1, 'AA Car Rental'),
(48, 'Hundai Accent', '{\"images\": [\"veh_69937bc2101242.98098213.jpg\", \"veh_69937bcc8ccc88.01695150.jpg\"], \"chargeTax\": 1, \"description\": \"<p>test</p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"100\", \"vehicleMaxDiscountPrice\": \"10\"}', 'Available', 123232, '2026-05-12', '2026-06-15 00:00:00', '2000-02-11', 2018, 'Normal Car', 1, 'AA Car Rental'),
(15, 'Toyota Corolla LE', '{\"images\": [\"veh_6991b278177580.02181029.jpg\", \"veh_6991b38994f471.41651187.jpg\"], \"chargeTax\": 1, \"description\": \"<p>Information and communication systems of vehicles are the keys to make vehicles and transport systems smart. IJVICS focuses on novel/enhanced theories and applications of these two systems and their integration. It provides a forum for this important research area where the systems may assist the driver or even control the vehicle, big data analysis may help manufacturers build more convenient, comfortable and safer vehicles and the results may also be used to improve safety, efficiency and convenience of transport systems.</p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"15\", \"vehicleMaxDiscountPrice\": \"13\"}', 'Available', 54321, '2027-01-12', '2026-02-02 00:00:00', '2020-06-04', 2015, 'Normal Car', 1, 'AA Car Rental'),
(16, 'Honda Civic EX', '{\"images\": [\"veh_6991b49a91a605.15524300.jpg\", \"veh_6991b49bbd16c8.68115953.jpg\"], \"chargeTax\": 1, \"description\": \"<ul><li>Vehicular computers, human-machine interfaces, sensors and meters</li> <li>Real-time data processing, artificial intelligence, cloud computing, modelling and simulation</li> <li>Intelligent transportation, vehicle information, industrial IoT in vehicles</li> <li>Cooperative/V2V/V2I communications</li> <li>Positioning, localisation, navigation, mobility management</li> <li>Communication theory/protocols</li> <li>Vehicular wireless access technology</li> <li>Collision avoidance systems, vehicle behaviour models</li> <li>Quality of service, security, environmentally aware services</li> <li>Cooperative driving, intelligent/self-driving vehicles</li> <li>New energy vehicle and data management</li> <li>Cyber-physical systems</li> <li>Embedded vehicle engineering</li> <li>Engineering design of optimal systems</li></ul>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"10\", \"vehicleMaxDiscountPrice\": \"8\"}', 'Available', 256802, '2026-03-27', '2026-02-25 00:00:00', '2019-08-05', 2016, 'Normal Car', 1, 'AA Car Rental'),
(17, 'Ford Mustang GT', '{\"images\": [\"veh_6991b600acd892.95096294.jpg\", \"veh_6991b63cda5dd8.33478322.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"22\", \"vehicleMaxDiscountPrice\": \"20.500\"}', 'Available', 102347, '2026-06-11', '2026-11-13 00:00:00', '2022-02-27', 2017, 'Luxury Car', 1, 'AA Car Rental'),
(18, 'BMW 330i M Sport', '{\"images\": [\"veh_6991b778c96f59.92405688.jpg\", \"veh_6991b7d8796169.85747931.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"30\", \"vehicleMaxDiscountPrice\": \"27\"}', 'Available', 100010, '2026-04-24', '2026-06-23 00:00:00', '2021-07-09', 2108, 'Luxury Car', 1, 'AA Car Rental'),
(19, '2019 Mercedes-Benz C300 AMG Line', '{\"images\": [\"veh_6991b8893f9652.44894130.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"30\", \"vehicleMaxDiscountPrice\": \"27\"}', 'Available', 77357, '2026-03-13', '2026-04-09 00:00:00', '2023-10-04', 2019, 'Luxury Car', 1, 'AA Car Rental'),
(20, 'Audi A4 45 TFSI Quattro', '{\"images\": [\"veh_6991b928aa3cf6.09545022.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"30\", \"vehicleMaxDiscountPrice\": \"27\"}', 'Available', 965738, '2026-04-11', '2026-06-11 00:00:00', '2022-10-02', 2020, 'Luxury Car', 1, 'AA Car Rental'),
(21, 'Hyundai Elantra Hybrid Limited', '{\"images\": [\"veh_6991b9c3dad450.48621464.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"25\", \"vehicleMaxDiscountPrice\": \"23\"}', 'Available', 34654, '2026-07-02', '2026-07-24 00:00:00', '2024-08-27', 2021, 'Normal Car', 1, 'AA Car Rental'),
(22, 'Nissan Altima SR', '{\"images\": [\"veh_6991ba507a4584.17942153.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"20\", \"vehicleMaxDiscountPrice\": \"17\"}', 'Available', 2022, '2026-04-17', '2026-04-30 00:00:00', '2023-03-24', 96543, 'Normal Car', 0, 'Select Company'),
(23, 'Chevrolet Malibu LT', '{\"images\": [\"veh_6991bae9b4bac1.26704941.jpg\", \"veh_6991baf6838105.76418328.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"14\", \"vehicleMaxDiscountPrice\": \"12\"}', 'Available', 2015, '2026-04-07', '2026-04-17 00:00:00', '2020-08-19', 3456, 'Normal Car', 1, 'AA Car Rental'),
(24, 'Kia Sportage CRDi SX', '{\"images\": [\"veh_6991bbbb542be5.33786496.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"13\", \"vehicleMaxDiscountPrice\": \"12\"}', 'Available', 27664, '2026-06-19', '2026-06-27 00:00:00', '2018-07-15', 2016, 'Normal Car', 1, 'AA Car Rental'),
(25, 'Volkswagen Golf GTD', '{\"images\": [\"veh_6991bcb8411452.73614365.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"15\", \"vehicleMaxDiscountPrice\": \"13\"}', 'Available', 87543, '2026-03-11', '2026-03-19 00:00:00', '2020-11-11', 2017, 'Normal Car', 1, 'AA Car Rental'),
(26, 'Tesla Model S 75D', '{\"images\": [\"veh_6991bd785780e8.09686601.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"34\", \"vehicleMaxDiscountPrice\": \"33\"}', 'Available', 70051, '2026-08-27', '2026-08-30 00:00:00', '2021-10-16', 2018, 'Luxury Car', 1, 'AA Car Rental'),
(27, 'Lexus RX 450h F Sport', '{\"images\": [\"veh_6991becb337d96.37773955.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"35\", \"vehicleMaxDiscountPrice\": \"33\"}', 'Available', 97500, '2026-06-20', '2026-06-29 00:00:00', '2022-07-23', 2019, 'Luxury Car', 1, 'AA Car Rental'),
(28, 'Porsche Taycan 4S', '{\"images\": [\"veh_6991c01215dc06.73243977.jpg\", \"veh_6991c072f00814.73923741.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"30\", \"vehicleMaxDiscountPrice\": \"27\"}', 'Available', 57774, '2026-03-05', '2026-03-20 00:00:00', '2023-07-17', 2020, 'Luxury Car', 2, 'Classic'),
(29, 'Land Rover Range Rover Velar D200', '{\"images\": [\"veh_6991c0f026b6a7.58998821.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"35\", \"vehicleMaxDiscountPrice\": \"33\"}', 'Available', 257656, '2026-05-16', '2026-05-29 00:00:00', '2024-04-27', 2021, 'Luxury Car', 2, 'Classic'),
(30, 'Mazda CX-5 Grand Touring', '{\"images\": [\"veh_6991c1afdb2320.80991254.jpg\", \"veh_6991c1bcec1480.58829864.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"28\", \"vehicleMaxDiscountPrice\": \"26\"}', 'Available', 45765, '2026-07-03', '2026-07-08 00:00:00', '2025-12-15', 2022, 'SUV', 1, 'AA Car Rental'),
(31, 'Subaru Forester 2.0D', '{\"images\": [\"veh_6991c2ada35f69.82872654.jpg\", \"veh_6991c2e71bce66.60952409.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"15\", \"vehicleMaxDiscountPrice\": \"12\"}', 'Available', 24551, '2026-10-09', '2026-10-17 00:00:00', '2019-03-29', 2015, 'SUV', 2, 'Classic'),
(32, 'Mitsubishi Outlander PHEV', '{\"images\": [\"veh_6991c37ea11181.67900075.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"14\", \"vehicleMaxDiscountPrice\": \"13\"}', 'Available', 14534, '2026-11-21', '2026-11-30 00:00:00', '2019-10-03', 2016, 'SUV', 2, 'Classic'),
(33, 'Volvo XC60 T8 Twin Engine', '{\"images\": [\"veh_6991c434624e38.62952571.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"35\", \"vehicleMaxDiscountPrice\": \"32\"}', 'Available', 64325, '2026-08-05', '2026-08-20 00:00:00', '2023-07-28', 2017, 'Luxury Car', 2, 'Classic'),
(34, 'Jaguar I-PACE EV400', '{\"images\": [\"veh_6991c4dbe41cc3.08648937.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"25\", \"vehicleMaxDiscountPrice\": \"23\"}', 'Available', 35643, '2026-04-24', '2026-04-29 00:00:00', '2023-11-15', 2018, 'Luxury Car', 1, 'AA Car Rental'),
(35, 'Ferrari SF90 Stradale', '{\"images\": [\"veh_6991c58823c669.30888841.jpg\", \"veh_6991c59ba5d695.50042787.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"35\", \"vehicleMaxDiscountPrice\": \"\"}', 'Available', 98654, '2026-02-17', '2026-02-22 00:00:00', '2022-03-05', 2019, 'Luxury Car', 1, 'AA Car Rental'),
(36, 'Lamborghini Huracán EVO', '{\"images\": [\"veh_6991c653296d50.51713407.jpg\", \"veh_6991c76c394767.91194129.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"40\", \"vehicleMaxDiscountPrice\": \"38\"}', 'Available', 64345, '2026-05-09', '2026-05-15 00:00:00', '2024-06-08', 2020, 'Luxury Car', 2, 'Classic'),
(37, 'Bentley Bentayga Hybrid', '{\"images\": [\"veh_6991c7dad73c50.65198542.jpg\", \"veh_6991c811c25b38.58754244.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"42\", \"vehicleMaxDiscountPrice\": \"40\"}', 'Available', 54433, '2026-04-10', '2026-04-24 00:00:00', '0000-00-00', 2021, 'Luxury Car', 1, 'AA Car Rental'),
(38, 'Rolls-Royce Spectre', '{\"images\": [\"veh_6991c8da9fd8a4.54315845.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"55\", \"vehicleMaxDiscountPrice\": \"54\"}', 'Available', 77778, '2026-07-10', '2026-07-17 00:00:00', '2025-06-06', 2022, 'Luxury Car', 1, 'AA Car Rental'),
(39, 'Rolls-Royce Spectre', '{\"images\": [\"veh_6991c96313b439.11318751.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"EV\", \"vehicleCostPerDay\": \"45\", \"vehicleMaxDiscountPrice\": \"43\"}', 'Available', 666661, '2026-04-09', '2026-04-17 00:00:00', '2025-11-14', 2022, 'Luxury Car', 1, 'AA Car Rental'),
(40, 'Jeep Wrangler 4xe', '{\"images\": [\"veh_6991ca199a9fe0.99665064.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"39\", \"vehicleMaxDiscountPrice\": \"41\"}', 'Available', 256434, '2026-03-28', '2026-03-29 00:00:00', '2024-12-12', 2023, 'SUV', 2, 'Classic'),
(41, 'New Flyer Xcelsior XN35', '{\"images\": [\"veh_6992d5199c5744.55535616.jpg\", \"veh_6992d527315352.15949068.jpg\", \"veh_6992d53c0ddbf5.94660788.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"57\", \"vehicleMaxDiscountPrice\": \"55\"}', 'Available', 45634, '2026-06-17', '2026-06-21 00:00:00', '2023-06-10', 2023, 'Bus', 1, 'AA Car Rental'),
(42, 'Volvo 7900 Hybrid Bus ', '{\"images\": [\"veh_6992d6d76c4916.99806639.jpg\", \"veh_6992d6ee80b7e5.25688652.jpg\", \"veh_6992d7050c2a07.74048289.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"55\", \"vehicleMaxDiscountPrice\": \"50\"}', 'Available', 53464, '2026-03-15', '2026-03-18 00:00:00', '2025-02-20', 2023, 'Bus', 2, 'Classic'),
(43, 'Nissan Urvan 2.5 L Microbus', '{\"images\": [\"veh_6992d7df70cea1.32834355.jpg\", \"veh_6992d7f30cb435.92549125.jpg\", \"veh_6992d8051ff046.71323168.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"40\", \"vehicleMaxDiscountPrice\": \"36\"}', 'Available', 54643, '2026-05-07', '2026-05-22 00:00:00', '2024-03-14', 2022, 'Van', 1, 'AA Car Rental'),
(44, 'Ford Transit Van', '{\"images\": [\"veh_6992d95d5568c4.84772407.jpg\", \"veh_6992d9730ccee4.47442371.jpg\", \"veh_6992d98cc2d7f8.94426262.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"45\", \"vehicleMaxDiscountPrice\": \"43\"}', 'Available', 453523, '2026-01-05', '2026-01-07 00:00:00', '2026-01-10', 2024, 'Van', 1, 'AA Car Rental'),
(45, 'Ford F-150', '{\"images\": [\"veh_6992db86391844.24511489.jpg\", \"veh_6992db9baaa4d1.92335529.jpg\", \"veh_6992dbb442f5c7.78062747.jpg\", \"veh_6992dbc287aaf4.78238128.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"60\", \"vehicleMaxDiscountPrice\": \"55\"}', 'Available', 243522, '2026-04-26', '2026-04-30 00:00:00', '2025-11-09', 2024, 'Truck', 1, 'AA Car Rental'),
(46, 'Ford F-350 Super Duty', '{\"images\": [\"veh_6992dc935562e3.04604935.jpg\", \"veh_6992dca55740e2.73245115.jpg\", \"veh_6992dcb6286dd1.91777992.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Petrol\", \"vehicleCostPerDay\": \"54\", \"vehicleMaxDiscountPrice\": \"52\"}', 'Available', 42356, '2026-02-17', '2026-02-18 00:00:00', '2025-01-16', 2024, 'Truck', 2, 'Classic'),
(47, 'Dongfeng 12T Box Truck', '{\"images\": [\"veh_6992ddc45e81e3.30689717.jpg\", \"veh_6992dde442b795.41540672.jpg\"], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"Diesel\", \"vehicleCostPerDay\": \"60\", \"vehicleMaxDiscountPrice\": \"55\"}', 'Available', 42355, '2026-09-29', '2026-09-30 00:00:00', '2025-07-20', 2024, 'Bus', 2, 'Classic'),
(50, '', '{\"images\": [], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"\", \"vehicleCostPerDay\": \"\", \"vehicleMaxDiscountPrice\": \"\"}', 'Available', 0, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 0, '', 0, 'Select Company'),
(51, '', '{\"images\": [], \"chargeTax\": 1, \"description\": \"<p><br></p>\", \"vehicleFuelType\": \"\", \"vehicleCostPerDay\": \"\", \"vehicleMaxDiscountPrice\": \"\"}', 'Available', 0, '0000-00-00', '0000-00-00 00:00:00', '0000-00-00', 0, '', 0, 'Select Company');

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
-- Indexes for table `tbl_company`
--
ALTER TABLE `tbl_company`
  ADD PRIMARY KEY (`ids`),
  ADD UNIQUE KEY `company_code` (`company_code`);

--
-- Indexes for table `tbl_drivers`
--
ALTER TABLE `tbl_drivers`
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`permission_id`);

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
  ADD PRIMARY KEY (`ids`);

--
-- Indexes for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  ADD PRIMARY KEY (`ids`);

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
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  ADD PRIMARY KEY (`ids`);

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
-- Indexes for table `tbl_vehicle_model`
--
ALTER TABLE `tbl_vehicle_model`
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
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `document_sequences`
--
ALTER TABLE `document_sequences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `shortcut_actions`
--
ALTER TABLE `shortcut_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_company`
--
ALTER TABLE `tbl_company`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_drivers`
--
ALTER TABLE `tbl_drivers`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_quotation_introduction`
--
ALTER TABLE `tbl_quotation_introduction`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_role_permissions`
--
ALTER TABLE `tbl_role_permissions`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_service_type`
--
ALTER TABLE `tbl_service_type`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_terms_and_condition`
--
ALTER TABLE `tbl_terms_and_condition`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_terms_and_condition_contract`
--
ALTER TABLE `tbl_terms_and_condition_contract`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tbl_vehicles`
--
ALTER TABLE `tbl_vehicles`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_vehicle_bookings`
--
ALTER TABLE `tbl_vehicle_bookings`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_vehicle_brand`
--
ALTER TABLE `tbl_vehicle_brand`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_vehicle_category`
--
ALTER TABLE `tbl_vehicle_category`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_vehicle_model`
--
ALTER TABLE `tbl_vehicle_model`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_vehicle_pricing_master`
--
ALTER TABLE `tbl_vehicle_pricing_master`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_vehicle_rentout_contracts`
--
ALTER TABLE `tbl_vehicle_rentout_contracts`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_shortcuts`
--
ALTER TABLE `user_shortcuts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `ids` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

-- --------------------------------------------------------

--
-- Structure for view `view_vehicle_details`
--
DROP TABLE IF EXISTS `view_vehicle_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`sandsl23`@`localhost` SQL SECURITY DEFINER VIEW `view_vehicle_details`  AS SELECT `v`.`ids` AS `ids`, `v`.`category_id` AS `category_id`, `c`.`category_name` AS `category_name`, `v`.`brand_id` AS `brand_id`, `b`.`brand_name` AS `brand_name`, `v`.`model_id` AS `model_id`, `m`.`modal_name` AS `model_name`, `v`.`model_names` AS `model_names`, `v`.`company_id` AS `company_id`, `v`.`vehicle_number` AS `vehicle_number`, `v`.`vehicle_year` AS `vehicle_year`, `v`.`vehicle_color` AS `vehicle_color`, `v`.`image_json` AS `image_json`, `v`.`other_details_json` AS `other_details_json`, `v`.`vehicle_attachments` AS `vehicle_attachments`, `v`.`vehicle_status` AS `vehicle_status`, `v`.`created_on` AS `created_on`, `v`.`created_by` AS `created_by`, `v`.`vehicle_purchase_date` AS `vehicle_purchase_date`, `v`.`next_passing_date` AS `next_passing_date`, `v`.`passing_histroy` AS `passing_histroy`, `v`.`next_insurance_date` AS `next_insurance_date`, `v`.`insurance_histroy` AS `insurance_histroy`, `v`.`next_maintenance_date` AS `next_maintenance_date`, `v`.`maintenance_histroy` AS `maintenance_histroy` FROM (((`tbl_vehicles` `v` left join `tbl_vehicle_category` `c` on(`v`.`category_id` = `c`.`ids`)) left join `tbl_vehicle_brand` `b` on(`v`.`brand_id` = `b`.`ids`)) left join `tbl_vehicle_model` `m` on(`v`.`model_id` = `m`.`ids`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_vehicle_model`
--
DROP TABLE IF EXISTS `view_vehicle_model`;

CREATE ALGORITHM=UNDEFINED DEFINER=`sandsl23`@`localhost` SQL SECURITY DEFINER VIEW `view_vehicle_model`  AS SELECT `v`.`ids` AS `model_ids`, `v`.`modal_name` AS `model_name`, `v`.`vehicle_modal_pic` AS `vehicle_modal_pic`, `v`.`category_id` AS `category_id`, `c`.`category_name` AS `category_name`, `c`.`category_image` AS `category_image`, `c`.`category_description` AS `category_description`, `c`.`category_status` AS `category_status`, `v`.`brand_id` AS `brand_id`, `b`.`brand_name` AS `brand_name` FROM ((`tbl_vehicle_model` `v` left join `tbl_vehicle_category` `c` on(`v`.`category_id` = `c`.`ids`)) left join `tbl_vehicle_brand` `b` on(`v`.`brand_id` = `b`.`ids`)) ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
