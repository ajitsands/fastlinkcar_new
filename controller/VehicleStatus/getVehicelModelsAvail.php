<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
?>
<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$company_id = $_GET['company_id'] ?? null;

if ($company_id) {
    $stmt = $pdo->prepare("
        SELECT DISTINCT vm.model_ids, CONCAT(vm.`brand_name`,' ',vm.`model_name`) as model_names, vm.category_id, vm.brand_id 
        FROM `view_vehicle_model` vm
        JOIN `tbl_vehicles` v ON v.model_id = vm.model_ids
        WHERE v.company_id = :company_id
    ");
    $stmt->execute(['company_id' => $company_id]);
} else {
    $stmt = $pdo->query("
        SELECT model_ids, CONCAT(`brand_name`,' ',`model_name`) as model_names, category_id, brand_id 
        FROM `view_vehicle_model`
    ");
}

$models = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

                             
<select id="vehicleModelAvail" name="vehicleModelAvail"  class="form-control form-select">
    <option value="All"  selected>All</option>

    <?php foreach ($models as $model) { ?>
        <option data-id ="<?php echo $model['category_id']; ?>" data-brand="<?php echo $model['brand_id']; ?>" value="<?php echo $model['model_ids']; ?>"><?php echo $model['model_names']; ?></option>
    <?php } ?>

</select>
