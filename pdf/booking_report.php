<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$db = new CommonPDOModel();
$pdo = $db->varDBPDO;

$booking_ref = $_GET['booking_ref'] ?? null;
if (!$booking_ref) {
    die("Invalid Booking Reference.");
}

// Fetch Master Booking Data
$stmt = $pdo->prepare("
    SELECT b.*, c.company_name, c.company_logo
    FROM tbl_vehicle_bookings b
    LEFT JOIN tbl_company c ON b.company_id = c.ids
    WHERE b.booking_no = ?
    LIMIT 1
");
$stmt->execute([$booking_ref]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Booking not found.");
}

// Fetch Booking Entries (Vehicles)
$stmtE = $pdo->prepare("
    SELECT b.*, v.chassis_number, v.vehicle_year
    FROM tbl_vehicle_bookings b
    LEFT JOIN tbl_vehicles v ON b.vehicle_id = v.ids
    WHERE b.booking_no = ?
    ORDER BY b.ids ASC
");
$stmtE->execute([$booking_ref]);
$entries = $stmtE->fetchAll(PDO::FETCH_ASSOC);

$sysDateFormat = 'd-m-Y';
$stmtSet = $pdo->prepare("SELECT date_format FROM tbl_system_settings WHERE company_id = ? LIMIT 1");
$stmtSet->execute([$booking['company_id']]);
$settings = $stmtSet->fetch(PDO::FETCH_ASSOC);
if ($settings && !empty($settings['date_format'])) {
    $sysDateFormat = $settings['date_format'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation / Booking Report - <?= htmlspecialchars($booking['booking_no']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; color: #212529; font-size: 13px; }
        .report-header { border-bottom: 2px solid #dc3545; padding-bottom: 15px; margin-bottom: 20px; }
        .section-card { background: #fff; border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .section-title { background: #f8d7da; color: #dc3545; padding: 10px 15px; font-weight: bold; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom: 1px solid #f5c2c7; font-size: 14px; }
        .section-body { padding: 15px; }
        .table-sm td, .table-sm th { padding: 6px 10px; }
        @page { size: A4; margin: 15mm; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; font-size: 12px; margin: 0; }
            .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .section-card { page-break-inside: avoid; border: 1px solid #ccc; box-shadow: none; }
        }
    </style>
</head>
<body>

<div class="container my-4">
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h4 class="mb-0 text-danger"><i class="ri-file-chart-line"></i> Reservation / Booking Report</h4>
        <div>
            <button onclick="window.print()" class="btn btn-danger btn-sm"><i class="ri-printer-line me-1"></i> Print Document</button>
            <button onclick="window.close()" class="btn btn-outline-secondary btn-sm me-2"><i class="ri-close-line me-1"></i> Close</button>
        </div>
    </div>

    <!-- Report Header -->
    <div class="report-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <?php if (!empty($booking['company_logo'])): ?>
                <img src="/<?= htmlspecialchars($booking['company_logo']) ?>" alt="Company Logo" style="max-height: 60px;">
            <?php endif; ?>
            <div>
                <h3 class="fw-bold text-dark mb-0"><?= htmlspecialchars(strtoupper($booking['company_name'] ?? 'COMPANY NAME')) ?></h3>
            </div>
        </div>
        <div class="text-end">
            <span class="badge bg-danger fs-6 mb-1">Ref No: <?= htmlspecialchars($booking['booking_no']) ?></span>
            <div class="text-muted small">Generated Date: <?= date('d/m/Y H:i A') ?></div>
        </div>
    </div>

    <!-- Customer & Booking Overview -->
    <div class="row">
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-title"><i class="ri-user-line me-1"></i> Customer Details</div>
                <div class="section-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="40%">Customer Code:</th><td><?= htmlspecialchars($booking['customer_code']) ?></td></tr>
                        <tr><th>Company:</th><td><?= htmlspecialchars($booking['company_name'] ?? 'N/A') ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-title"><i class="ri-calendar-line me-1"></i> Booking Information</div>
                <div class="section-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="40%">Reservation Date:</th><td><?= date($sysDateFormat, strtotime($booking['created_date'])) ?></td></tr>
                        <tr><th>Total Vehicles:</th><td><?= count($entries) ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reserved Vehicles -->
    <div class="section-card">
        <div class="section-title"><i class="ri-car-line me-1"></i> Reserved Vehicles</div>
        <div class="section-body p-0">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Vehicle No</th>
                        <th>Chassis No</th>
                        <th>Make / Model / Year</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach ($entries as $entry): 
                    ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($entry['vehicle_no']) ?></td>
                        <td><?= htmlspecialchars($entry['chassis_number'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($entry['brand_name'] . ' ' . $entry['model_name'] . (!empty($entry['vehicle_year']) ? ' / ' . $entry['vehicle_year'] : '')) ?></td>
                        <td><?= date($sysDateFormat . ' H:i', strtotime($entry['book_from_date'])) ?></td>
                        <td><?= $entry['book_to_date'] ? date($sysDateFormat . ' H:i', strtotime($entry['book_to_date'])) : '-' ?></td>
                        <td>
                            <strong><?= htmlspecialchars($entry['book_status']) ?></strong>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($entries)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">No vehicles found for this reservation.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
