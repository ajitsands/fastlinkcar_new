<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

// Get categories
$stmt = $pdo->query("
    SELECT * FROM `tbl_vehicle_category` where category_status='Active' order by category_name asc ");
$categorys = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

                             
<select id="vehicleCategory" name="vehicleCategory" class="form-control form-select">
    <option value="0" disabled selected>Select Category</option>

    <?php foreach ($categorys as $category) { ?>
        <option  value="<?php echo $category['ids']; ?>"><?php echo $category['category_name']; ?></option>
    <?php } ?>

</select>
