<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

// Get categories
$stmt = $pdo->query("
    SELECT ids,driver_name,driver_contact_no,license_no,license_issue_place,license_issue_date,license_expiry_date,driver_documents FROM `tbl_drivers` where driver_status='Active'");
$drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

                             
<select id="driverSelect" name="driverSelect" class="form-control form-select">
    <option value="0" disabled selected>Select Driver</option>

    <?php foreach ($drivers as $driver) { ?>
        <option data-documents= "<?php echo $driver['driver_documents']; ?>" data-id ="<?php echo $driver['driver_contact_no']; ?>" data-license_no="<?php echo $driver['license_no']; ?>"  data-license_place="<?php echo $driver['license_issue_place']; ?>" data-license_id="<?php echo $driver['license_issue_date']; ?>" data-license_ed="<?php echo $driver['license_expiry_date']; ?>" value="<?php echo $driver['ids']; ?>"><?php echo $driver['driver_name']; ?></option>
    <?php } ?>

</select>
