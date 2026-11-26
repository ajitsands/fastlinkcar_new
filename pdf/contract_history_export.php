<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);

if (!class_exists('CommonPDOModel')) {
    require_once ROOT_PATH . '/model/common/pdoCommonFunctions.php';
}

$agreementId = intval($_GET['agreement_id'] ?? $_GET['id'] ?? 0);
if (empty($agreementId)) {
    die("Invalid Agreement ID");
}

$pdoObj = new CommonPDOModel();

// 1. Contract
$stmtC = $pdoObj->selectexecuteQuery(
    "SELECT c.*, cat.category_name, modl.modal_name AS model_name
     FROM tbl_vehicle_rentout_contracts c
     LEFT JOIN tbl_vehicle_category cat ON cat.ids = c.vehicle_category_id
     LEFT JOIN tbl_vehicle_model modl ON modl.ids = c.vehicle_model_id
     WHERE c.ids = :id",
    [':id' => $agreementId]
);
$contract = $stmtC ? $stmtC->fetch(PDO::FETCH_ASSOC) : null;
if (!$contract) {
    die("Contract not found");
}

// 2. Customer
$custCode = $contract['customer_code'] ?? '';
$stmtCust = $pdoObj->selectexecuteQuery("SELECT customer_name, customer_mobile AS mobile_number, customer_cr_cpr AS cpr_no, customer_address, customer_email, customer_id AS customer_code FROM customer_details WHERE customer_id = :ccode OR ids = :ccode LIMIT 1", [':ccode' => $custCode]);
$customer = $stmtCust ? $stmtCust->fetch(PDO::FETCH_ASSOC) : [];

// 3. Replaced History
$replacedHistory = !empty($contract['replaced_vehicle_json']) ? (json_decode($contract['replaced_vehicle_json'], true) ?: []) : [];

// 4. Ledger
$agreementNo = $contract['agreement_no'] ?? '';
$stmtL = $pdoObj->selectexecuteQuery("SELECT * FROM tbl_customer_ledger WHERE contract_ids = :cid OR agreement_no = :refno ORDER BY ids ASC", [':cid' => $agreementId, ':refno' => $agreementNo]);
$ledgerEntries = $stmtL ? $stmtL->fetchAll(PDO::FETCH_ASSOC) : [];

$totDebit = 0; $totCredit = 0;
foreach ($ledgerEntries as $le) {
    $totDebit += floatval($le['debit'] ?? 0);
    $totCredit += floatval($le['credit'] ?? 0);
}
$balance = $totDebit - $totCredit;

// Render HTML Print View with auto-print
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contract History & Audit Report - <?= htmlspecialchars($agreementNo) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f8f9fa; color: #212529; font-size: 13px; }
        .report-header { border-bottom: 2px solid #1b3d94; padding-bottom: 15px; margin-bottom: 20px; }
        .section-card { background: #fff; border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .section-title { background: #eef3fc; color: #1b3d94; padding: 10px 15px; font-weight: bold; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom: 1px solid #b8c8f5; font-size: 14px; }
        .section-body { padding: 15px; }
        .table-sm td, .table-sm th { padding: 6px 10px; }
        .img-thumb { width: 70px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #ccc; margin-right: 5px; margin-bottom: 5px; }
        .sign-img { max-height: 70px; max-width: 200px; border: 1px solid #ccc; border-radius: 4px; padding: 3px; background: #fff; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; font-size: 12px; }
            .section-card { page-break-inside: avoid; border: 1px solid #ccc; }
        }
    </style>
</head>
<body>

<div class="container my-4">
    <!-- Top Action Bar -->
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">
        <h4 class="mb-0" style="color: #1b3d94;"><i class="ri-file-text-line"></i> Contract Audit & History Report</h4>
        <div>
            <button onclick="window.print()" class="btn btn-sm text-white" style="background-color: #1b3d94; border-color: #1b3d94;"><i class="ri-printer-line me-1"></i> Print / Save PDF</button>
            <button onclick="window.close()" class="btn btn-outline-secondary btn-sm me-2"><i class="ri-close-line me-1"></i> Close</button>
        </div>
    </div>

    <!-- Report Header -->
    <?php
        require_once __DIR__ . '/print_settings_helper.php';
        $printSettings = getPrintSettings($pdo ?? null);
        echo renderPrintHeaderHtml($printSettings, 'Contract Audit & History Report', 'Agreement No: ' . $agreementNo, 'Generated Date: ' . date('d/m/Y H:i'));
    ?>

    <!-- Customer & Contract Overview -->
    <div class="section-card">
        <div class="section-title"><i class="ri-user-line me-1"></i> Customer & Contract Overview</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-6 border-end">
                    <h6 class="fw-bold text-secondary border-bottom pb-1">Customer Information</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="35%">Customer Name:</th><td><?= htmlspecialchars($customer['customer_name'] ?? $contract['customer_name'] ?? 'N/A') ?></td></tr>
                        <tr><th>Customer Code:</th><td><?= htmlspecialchars($contract['customer_code'] ?? 'N/A') ?></td></tr>
                        <tr><th>Contact / Mobile:</th><td><?= htmlspecialchars($customer['mobile_number'] ?? 'N/A') ?></td></tr>
                        <tr><th>CPR / ID No:</th><td><?= htmlspecialchars($customer['cpr_no'] ?? 'N/A') ?></td></tr>
                        <tr><th>Nationality:</th><td><?= htmlspecialchars($customer['country_name'] ?? 'N/A') ?></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-bold text-secondary border-bottom pb-1">Contract Summary</h6>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="35%">Agreement Status:</th><td><span class="badge bg-success"><?= htmlspecialchars($contract['agreement_status'] ?? 'Rentout') ?></span></td></tr>
                        <tr><th>Agreement Date:</th><td><?= htmlspecialchars($contract['agreement_date'] ?? 'N/A') ?></td></tr>
                        <tr><th>Service Type:</th><td><?= htmlspecialchars($contract['service_type'] ?? 'N/A') ?></td></tr>
                        <tr><th>Quotation No:</th><td><?= htmlspecialchars($contract['quotation_number'] ?? 'N/A') ?></td></tr>
                        <tr><th>Total Replacements:</th><td><strong><?= count($replacedHistory) ?></strong></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Active Contract Vehicle -->
    <div class="section-card">
        <div class="section-title"><i class="ri-car-fill me-1"></i> Current Contract Vehicle Status</div>
        <div class="section-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="35%">Vehicle Number:</th><td><strong class="text-primary fs-6"><?= htmlspecialchars($contract['vehicle_no'] ?? 'N/A') ?></strong></td></tr>
                        <tr><th>Category:</th><td><?= htmlspecialchars($contract['category_name'] ?? 'N/A') ?></td></tr>
                        <tr><th>Model:</th><td><?= htmlspecialchars($contract['model_name'] ?? 'N/A') ?></td></tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="35%">KM Out (Current):</th><td><?= htmlspecialchars($contract['km_out'] ?? '0') ?> KM</td></tr>
                        <tr><th>Date Out:</th><td><?= htmlspecialchars($contract['date_out'] ?? 'N/A') ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicle Replacement History Timeline -->
    <div class="section-card">
        <div class="section-title"><i class="ri-history-line me-1"></i> Vehicle Replacement History Timeline</div>
        <div class="section-body">
            <?php if (empty($replacedHistory)): ?>
                <div class="text-muted fst-italic p-2">No vehicle replacements performed for this contract.</div>
            <?php else: ?>
                <?php foreach ($replacedHistory as $idx => $node): ?>
                    <div class="border rounded p-3 mb-3 bg-light">
                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                            <h6 class="fw-bold text-dark mb-0">Replacement #<?= ($idx + 1) ?> (ID: <?= htmlspecialchars($node['replacement_id'] ?? '') ?>)</h6>
                            <span class="badge bg-secondary">Replaced On: <?= htmlspecialchars($node['replaced_on'] ?? '') ?></span>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-6 border-end">
                                <h6 class="fw-bold text-danger"><i class="ri-logout-box-r-line"></i> Replaced Return Vehicle (Old)</h6>
                                <table class="table table-sm table-bordered bg-white mb-2">
                                    <tr><th>Vehicle:</th><td><?= htmlspecialchars($node['old_vehicle']['vehicle_number'] ?? '') ?> - <?= htmlspecialchars($node['old_vehicle']['category_name'] ?? '') ?> <?= htmlspecialchars($node['old_vehicle']['model_name'] ?? '') ?></td></tr>
                                    <tr><th>KM Out / IN / Used:</th><td>Out: <?= $node['old_vehicle']['km_out'] ?? 0 ?> | In: <?= $node['old_vehicle']['km_in'] ?? 0 ?> | Used: <strong><?= $node['old_vehicle']['km_used'] ?? 0 ?> KM</strong></td></tr>
                                    <tr><th>Fuel Level Out / IN:</th><td>Out: <?= htmlspecialchars($node['old_vehicle']['fuel_level_out'] ?? 'N/A') ?> | In: <strong><?= htmlspecialchars($node['old_vehicle']['fuel_level_in'] ?? 'N/A') ?></strong></td></tr>
                                    <tr><th>Date Out / IN:</th><td><?= htmlspecialchars($node['old_vehicle']['dt_out'] ?? 'N/A') ?> to <?= htmlspecialchars($node['old_vehicle']['dt_in'] ?? 'N/A') ?></td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-success"><i class="ri-login-box-r-line"></i> Replacement Vehicle Assigned (New)</h6>
                                <table class="table table-sm table-bordered bg-white mb-2">
                                    <tr><th>Vehicle:</th><td><?= htmlspecialchars($node['new_vehicle']['vehicle_number'] ?? '') ?> - <?= htmlspecialchars($node['new_vehicle']['category_name'] ?? '') ?> <?= htmlspecialchars($node['new_vehicle']['model_name'] ?? '') ?></td></tr>
                                    <tr><th>KM Out (New):</th><td><strong><?= $node['new_vehicle']['km_out'] ?? 0 ?> KM</strong></td></tr>
                                    <tr><th>Fuel Level Out:</th><td><strong><?= htmlspecialchars($node['new_vehicle']['fuel_level_out'] ?? 'N/A') ?></strong></td></tr>
                                    <tr><th>Date Out (New):</th><td><?= htmlspecialchars($node['new_vehicle']['dt_out'] ?? 'N/A') ?></td></tr>
                                </table>
                            </div>
                        </div>

                        <!-- Staff Info & Signature -->
                        <div class="row g-3 align-items-center bg-white p-2 border rounded">
                            <div class="col-md-6">
                                <strong>Responsible Staff Name:</strong> <?= htmlspecialchars($node['staff_name'] ?? 'N/A') ?>
                            </div>
                            <div class="col-md-6 text-end">
                                <strong>Staff Signature:</strong>
                                <?php if (!empty($node['staff_signature'])): ?>
                                    <img src="<?= htmlspecialchars($node['staff_signature']) ?>" class="sign-img ms-2">
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Not Captured</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Financial Ledger & Balances -->
    <div class="section-card">
        <div class="section-title"><i class="ri-money-dollar-circle-line me-1"></i> Financial Ledger & Balances</div>
        <div class="section-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Transaction Type</th>
                            <th>Description</th>
                            <th class="text-end">Debit (BHD)</th>
                            <th class="text-end">Credit (BHD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($ledgerEntries)): ?>
                            <tr><td colspan="6" class="text-center text-muted fst-italic">No ledger transactions found</td></tr>
                        <?php else: ?>
                            <?php foreach ($ledgerEntries as $i => $le): ?>
                                <tr>
                                    <td><?= ($i + 1) ?></td>
                                    <td><?= htmlspecialchars($le['trans_date'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($le['trans_type'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($le['description'] ?? '') ?></td>
                                    <td class="text-end text-danger"><?= number_format(floatval($le['debit'] ?? 0), 3) ?></td>
                                    <td class="text-end text-success"><?= number_format(floatval($le['credit'] ?? 0), 3) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-light fw-bold">
                        <tr>
                            <td colspan="4" class="text-end">Totals:</td>
                            <td class="text-end text-danger"><?= number_format($totDebit, 3) ?> BHD</td>
                            <td class="text-end text-success"><?= number_format($totCredit, 3) ?> BHD</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">Outstanding Net Balance:</td>
                            <td colspan="2" class="text-end fs-6 <?= $balance > 0 ? 'text-danger' : 'text-success' ?>"><?= number_format($balance, 3) ?> BHD</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?= renderPrintFooterHtml($printSettings) ?>
</div>

</body>
</html>
