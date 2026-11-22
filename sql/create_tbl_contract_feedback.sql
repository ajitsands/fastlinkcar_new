CREATE TABLE IF NOT EXISTS `tbl_contract_feedback` (
  `ids` int(11) NOT NULL AUTO_INCREMENT,
  `contract_id` int(11) NOT NULL,
  `agreement_no` varchar(100) DEFAULT NULL,
  `feedback_date` date NOT NULL,
  `feedback_notes` text NOT NULL,
  `taken_by` varchar(150) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ids`),
  KEY `idx_contract_feedback_cid` (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
