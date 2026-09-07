-- ==============================================================================
-- DATABASE CLEANUP SCRIPT
-- WARNING: This script will delete ALL data in the specified tables and 
-- reset their auto-increment IDs to 1.
-- ALWAYS TAKE A FULL DATABASE BACKUP BEFORE RUNNING THIS SCRIPT!
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- --------------------------------------------------------
-- TRANSACTION DATA
-- --------------------------------------------------------
DELETE FROM `booking_info`;
ALTER TABLE `booking_info` AUTO_INCREMENT = 1;

DELETE FROM `cashmemo`;
ALTER TABLE `cashmemo` AUTO_INCREMENT = 1;

DELETE FROM `expensevoucher`;
ALTER TABLE `expensevoucher` AUTO_INCREMENT = 1;

DELETE FROM `invoices`;
ALTER TABLE `invoices` AUTO_INCREMENT = 1;

DELETE FROM `quotations`;
ALTER TABLE `quotations` AUTO_INCREMENT = 1;

DELETE FROM `tbl_customer_ledger`;
ALTER TABLE `tbl_customer_ledger` AUTO_INCREMENT = 1;

DELETE FROM `tbl_invoice_billing_schedules`;
ALTER TABLE `tbl_invoice_billing_schedules` AUTO_INCREMENT = 1;

DELETE FROM `tbl_maintenance_request_services`;
ALTER TABLE `tbl_maintenance_request_services` AUTO_INCREMENT = 1;

DELETE FROM `tbl_maintenance_requests`;
ALTER TABLE `tbl_maintenance_requests` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_bookings`;
ALTER TABLE `tbl_vehicle_bookings` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_contract_extensions`;
ALTER TABLE `tbl_vehicle_contract_extensions` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_contract_replacement`;
ALTER TABLE `tbl_vehicle_contract_replacement` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_log_movement`;
ALTER TABLE `tbl_vehicle_log_movement` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_non_revenue_ticket`;
ALTER TABLE `tbl_vehicle_non_revenue_ticket` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicle_rentout_contracts`;
ALTER TABLE `tbl_vehicle_rentout_contracts` AUTO_INCREMENT = 1;

DELETE FROM `document_sequences`;
ALTER TABLE `document_sequences` AUTO_INCREMENT = 1;

-- --------------------------------------------------------
-- REQUESTED MASTER DATA
-- --------------------------------------------------------
DELETE FROM `customer_details`;
ALTER TABLE `customer_details` AUTO_INCREMENT = 1;

DELETE FROM `vehicles`;
ALTER TABLE `vehicles` AUTO_INCREMENT = 1;

DELETE FROM `tbl_vehicles`;
ALTER TABLE `tbl_vehicles` AUTO_INCREMENT = 1;

SET FOREIGN_KEY_CHECKS = 1;

-- ==============================================================================
-- CLEANUP COMPLETE
-- ==============================================================================
