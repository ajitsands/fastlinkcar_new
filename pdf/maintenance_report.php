<?php
require_once __DIR__ . '/../envfiles/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../envfiles');
$dotenv->load();
include_once __DIR__ . '/../model/common/pdoCommonFunctions.php';
include_once __DIR__ . '/../model/db_connection/pdo_db_connection.php';

$db = new CommonPDOModel();
$pdo = $db->varDBPDO;

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid request ID.");
}

// Fetch Master Data
$stmt = $pdo->prepare("
    SELECT r.*, 
           v.vehicle_number, v.chassis_no, b.brand_name, m.modal_name as model_name,
           g.garage_name, g.address as garage_address, g.contact_number as garage_contact
    FROM tbl_maintenance_requests r
    LEFT JOIN tbl_vehicles v ON r.vehicle_id = v.ids
    LEFT JOIN tbl_vehicle_brand b ON v.brand_id = b.ids
    LEFT JOIN tbl_vehicle_model m ON v.model_id = m.ids
    LEFT JOIN tbl_garages g ON r.garage_id = g.ids
    WHERE r.ids = ?
");
$stmt->execute([$id]);
$req = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$req) {
    die("Maintenance request not found.");
}

// Fetch Services
$stmtS = $pdo->prepare("
    SELECT s.service_name, rs.remarks
    FROM tbl_maintenance_request_services rs
    LEFT JOIN tbl_garage_services s ON rs.service_id = s.ids
    WHERE rs.request_id = ?
");
$stmtS->execute([$id]);
$services = $stmtS->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request - <?php echo htmlspecialchars($req['request_no']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f8f9fa; }
        .print-container { max-width: 800px; margin: 20px auto; background: #fff; padding: 40px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header-section { border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 30px; }
        .section-title { background: #f0f0f0; padding: 5px 10px; font-weight: bold; margin-bottom: 15px; border-left: 4px solid #333; }
        
        @media print {
            body { background: #fff; }
            .print-container { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
            .btn-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="print-container">
    <div class="text-end mb-3 btn-print">
        <button onclick="window.print()" class="btn btn-primary">Print Document</button>
    </div>

    <div class="header-section text-center">
        <h2>VEHICLE MAINTENANCE REQUEST</h2>
        <h5 class="text-muted">Ref No: <?php echo htmlspecialchars($req['request_no']); ?></h5>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <div class="section-title">Vehicle Details</div>
            <table class="table table-sm table-borderless">
                <tr><th width="40%">Vehicle No:</th><td><?php echo htmlspecialchars($req['vehicle_number']); ?></td></tr>
                <tr><th>Make / Model:</th><td><?php echo htmlspecialchars($req['brand_name'] . ' ' . $req['model_name']); ?></td></tr>
                <tr><th>Chassis No:</th><td><?php echo htmlspecialchars($req['chassis_no']); ?></td></tr>
            </table>
        </div>
        <div class="col-6">
            <div class="section-title">Garage Details</div>
            <table class="table table-sm table-borderless">
                <tr><th width="40%">Garage Name:</th><td><?php echo htmlspecialchars($req['garage_name']); ?></td></tr>
                <tr><th>Contact:</th><td><?php echo htmlspecialchars($req['garage_contact']); ?></td></tr>
                <tr><th>Date Issued:</th><td><?php echo date('d-M-Y H:i', strtotime($req['created_on'])); ?></td></tr>
            </table>
        </div>
    </div>

    <div class="section-title mt-4">Requested Services & Remarks</div>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th width="5%">#</th>
                <th width="35%">Service Category</th>
                <th width="60%">Remarks / Instructions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $index => $srv): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><strong><?php echo htmlspecialchars($srv['service_name']); ?></strong></td>
                <td><?php echo nl2br(htmlspecialchars($srv['remarks'])); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($services)): ?>
            <tr><td colspan="3" class="text-center">No specific services listed.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="row mt-5 pt-5">
        <div class="col-6 text-center">
            <hr style="width: 60%; margin: auto;">
            <p class="mt-2">Authorized Signature (Company)</p>
        </div>
        <div class="col-6 text-center">
            <hr style="width: 60%; margin: auto;">
            <p class="mt-2">Received By (Garage)</p>
        </div>
    </div>
    
    <div class="text-center mt-5 pt-4 text-muted" style="font-size: 11px;">
        Generated by Antigravity IDE | Request Date: <?php echo date('d-M-Y', strtotime($req['created_on'])); ?>
    </div>
</div>

<script>
    // Automatically trigger print dialog when page loads
    window.onload = function() {
        setTimeout(() => {
            window.print();
        }, 500);
    };
</script>

</body>
</html>
