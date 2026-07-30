<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
?>
<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

// Get categories
$stmt = $pdo->query("
    SELECT model_ids,concat(`brand_name`,' ',`model_name`) as model_names,category_id,brand_id FROM `view_vehicle_model`");
$models = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

                             
<select id="vehicleModel" name="vehicleModel"  class="form-control form-select">
    <option value="0" disabled selected>Select Model</option>

    <?php foreach ($models as $model) { ?>
        <option data-id ="<?php echo $model['category_id']; ?>" data-brand="<?php echo $model['brand_id']; ?>" value="<?php echo $model['model_ids']; ?>"><?php echo $model['model_names']; ?></option>
    <?php } ?>

</select>
