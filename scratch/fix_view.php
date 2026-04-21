<?php
define('ROOT_PATH', dirname(__DIR__));
require_once ROOT_PATH . '/envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/envfiles');
$dotenv->load();

include(ROOT_PATH . '/model/db_connection/pdo_db_connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $db = new ClassDatabaseConnection();
    $pdo = $db->pdo;

    $sql = "CREATE OR REPLACE VIEW `view_vehicle_model` AS 
            SELECT 
                `v`.`ids` AS `model_ids`,
                `v`.`modal_name` AS `model_name`,
                `v`.`vehicle_modal_pic` AS `vehicle_modal_pic`,
                `v`.`category_id` AS `category_id`,
                `c`.`category_name` AS `category_name`,
                `c`.`category_image` AS `category_image`,
                `c`.`category_description` AS `category_description`,
                `c`.`category_status` AS `category_status`,
                `v`.`brand_id` AS `brand_id`,
                `b`.`brand_name` AS `brand_name` 
            FROM `tbl_vehicle_model` `v` 
            LEFT JOIN `tbl_vehicle_category` `c` ON `v`.`category_id` = `c`.`ids`
            LEFT JOIN `tbl_vehicle_brand` `b` ON `v`.`brand_id` = `b`.`ids` ";

    $pdo->exec($sql);
    echo "Success: view_vehicle_model has been re-created with a valid definer.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
