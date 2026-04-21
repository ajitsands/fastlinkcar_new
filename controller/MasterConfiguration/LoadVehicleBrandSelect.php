<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

// Get categories
$stmt = $pdo->query("
    SELECT * FROM `tbl_vehicle_brand` where brand_status='Active' order by brand_name asc");
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

                             
<select id="vehicleBrand" name="vehicleBrand" class="form-control form-select">
    <option value="0" disabled selected>Select Brand</option>

    <?php foreach ($brands as $brand) { ?>
        <option value="<?php echo $brand['ids']; ?>"><?php echo $brand['brand_name']; ?></option>
    <?php } ?>

</select>
