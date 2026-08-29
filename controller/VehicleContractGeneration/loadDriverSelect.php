<?php
include_once __DIR__ . '/../../model/db_connection/pdo_db_connection.php';

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$dateFormat = 'd/m/Y';
try {
    $stmtSettings = $pdo->query("SELECT date_format FROM tbl_system_settings LIMIT 1");
    if ($stmtSettings) {
        $settings = $stmtSettings->fetch(PDO::FETCH_ASSOC);
        if (!empty($settings['date_format'])) {
            $dateFormat = $settings['date_format'];
        }
    }
} catch (Exception $e) {
    // fallback
}

// Get drivers
$stmt = $pdo->query("
    SELECT ids,driver_name,driver_contact_no,license_no,license_issue_place,license_issue_date,license_expiry_date,driver_documents FROM `tbl_drivers` where driver_status='Active'");
$drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<select id="driverSelect" name="driverSelect" class="form-control form-select">
    <option value="0" disabled selected>Select Driver</option>
    <?php foreach ($drivers as $driver) { 
        $issue_date = !empty($driver['license_issue_date']) ? date($dateFormat, strtotime($driver['license_issue_date'])) : '';
        $expiry_date = !empty($driver['license_expiry_date']) ? date($dateFormat, strtotime($driver['license_expiry_date'])) : '';
    ?>
        <option  data-id ="<?php echo htmlspecialchars($driver['driver_contact_no']); ?>" data-license_no="<?php echo htmlspecialchars($driver['license_no']); ?>"  data-license_place="<?php echo htmlspecialchars($driver['license_issue_place']); ?>" data-license_id="<?php echo htmlspecialchars($issue_date); ?>" data-license_ed="<?php echo htmlspecialchars($expiry_date); ?>" data-documents="<?php echo htmlspecialchars($driver['driver_documents']); ?>" value="<?php echo htmlspecialchars($driver['ids']); ?>"><?php echo htmlspecialchars($driver['driver_name']); ?></option>
    <?php } ?>
</select>
