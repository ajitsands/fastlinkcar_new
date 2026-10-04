<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

function loadEnv($path) {
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $_ENV[trim($name)] = trim($value, " \t\n\r\0\x0B\"'");
        }
    }
}
loadEnv(__DIR__ . '/../.env');

require_once '../model/db_connection/pdo_db_connection.php';

if (isset($_ENV['APP_TIMEZONE'])) {
    date_default_timezone_set($_ENV['APP_TIMEZONE']);
}

$id = $_GET['id'] ?? 0;
if (!$id) {
    die("Invalid ID");
}

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$stmt = $pdo->prepare("
    SELECT r.*, c.customer_name, c.customer_mobile, c.customer_cr_cpr, comp.company_name, comp.company_logo 
    FROM tbl_refund_requests r
    LEFT JOIN customer_details c ON r.customer_code = c.customer_id
    LEFT JOIN tbl_company comp ON SUBSTRING_INDEX(r.refund_no, '/', 1) = comp.company_code
    WHERE r.id = ?
");
$stmt->execute([$id]);
$refund = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$refund) {
    die("Refund not found.");
}

$agreement_no = $refund['agreement_no'];

$stmtContract = $pdo->prepare("SELECT service_start_date_time, return_date, km_used, vechile_details, vehicle_no FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
$stmtContract->execute([$agreement_no]);
$contract = $stmtContract->fetch(PDO::FETCH_ASSOC);
if ($contract) {
    $contract['vechile_details'] = json_decode($contract['vechile_details'], true);
}

$stmtLedgerSum = $pdo->prepare("SELECT SUM(debit) as total_debit, SUM(credit) as total_credit FROM tbl_customer_ledger WHERE booking_no = ? OR agreement_no = ? OR ref_no = ?");
$stmtLedgerSum->execute([$agreement_no, $agreement_no, $agreement_no]);
$ledger_sum = $stmtLedgerSum->fetch(PDO::FETCH_ASSOC);

$totalPaid = $ledger_sum ? floatval($ledger_sum['total_credit'] ?? 0) : 0;
$totalCharged = $ledger_sum ? floatval($ledger_sum['total_debit'] ?? 0) : 0;
$balance = $totalPaid - $totalCharged;

$make = '';
$model = '';
$chassisNo = 'N/A';
if ($contract && isset($contract['vechile_details'])) {
    $make = $contract['vechile_details']['make'] ?? $contract['vechile_details']['brand'] ?? '';
    $model = $contract['vechile_details']['model_name'] ?? $contract['vechile_details']['model'] ?? '';
    $chassisNo = $contract['vechile_details']['chassis_number'] ?? $contract['vechile_details']['chassis_no'] ?? 'N/A';
}
$vehicleName = trim($make . ' ' . $model) ?: 'N/A';

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Refund Receipt ' . $refund['refund_no']);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

// Add logo if exists
$logo_path = '../assets/img/logo/logo.png';
if (!empty($refund['company_logo'])) {
    $company_logo_clean = ltrim($refund['company_logo'], '/');
    if (file_exists('../' . $company_logo_clean)) {
        $logo_path = '../' . $company_logo_clean;
    }
}

if (file_exists($logo_path)) {
    $pdf->Image($logo_path, 15, 15, 30);
}

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { padding: 8px; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }
    .header-bg { background-color: #d12222; color: #ffffff; }
    .bordered td, .bordered th { border: 1px solid #dddddd; }
</style>
<br>
<h2 class="text-center" style="color: #d12222;">REFUND REQUEST / RECEIPT</h2>
<br><br>
<table class="bordered" cellpadding="5">
    <tr class="header-bg">
        <th colspan="2" class="bold">REFUND INFORMATION</th>
    </tr>
    <tr>
        <td width="30%"><strong>Refund No:</strong></td>
        <td width="70%">' . htmlspecialchars($refund['refund_no']) . '</td>
    </tr>
    <tr>
        <td><strong>Date:</strong></td>
        <td>' . htmlspecialchars($refund['date']) . '</td>
    </tr>
    <tr>
        <td><strong>Status:</strong></td>
        <td>' . htmlspecialchars($refund['status']) . '</td>
    </tr>
    <tr>
        <td><strong>Refund Mode:</strong></td>
        <td>' . htmlspecialchars($refund['refund_mode'] ?? 'Cash') . '</td>
    </tr>
    <tr>
        <td><strong>Amount:</strong></td>
        <td>' . number_format($refund['amount'], 3) . '</td>
    </tr>
</table>
<br><br>
<table class="bordered" cellpadding="5">
    <tr class="header-bg">
        <th colspan="2" class="bold">CUSTOMER DETAILS</th>
    </tr>
    <tr>
        <td width="30%"><strong>Customer Name:</strong></td>
        <td width="70%">' . htmlspecialchars($refund['customer_name'] ?? 'N/A') . '</td>
    </tr>
    <tr>
        <td><strong>Customer Code:</strong></td>
        <td>' . htmlspecialchars($refund['customer_code'] ?? 'N/A') . '</td>
    </tr>
    <tr>
        <td><strong>Agreement No:</strong></td>
        <td>' . htmlspecialchars($refund['agreement_no'] ?? 'N/A') . '</td>
    </tr>
</table>
<br><br>
<table class="bordered" cellpadding="5">
    <tr class="header-bg">
        <th colspan="2" class="bold">AGREEMENT SUMMARY</th>
    </tr>
    <tr>
        <td width="50%">
            <strong>Vehicle:</strong> ' . htmlspecialchars($vehicleName) . ' (' . htmlspecialchars($contract['vehicle_no'] ?? 'N/A') . ')<br>
            <strong>Chassis No:</strong> ' . htmlspecialchars($chassisNo) . '<br>
            <strong>Rentout Date:</strong> ' . htmlspecialchars($contract['service_start_date_time'] ?? 'N/A') . '<br>
            <strong>Return Date:</strong> ' . htmlspecialchars($contract['return_date'] ?? 'N/A') . '<br>
            <strong>KM Used:</strong> ' . htmlspecialchars($contract['km_used'] ?? '0') . '
        </td>
        <td width="50%">
            <strong>Total Payable:</strong> ' . number_format($totalCharged, 3) . '<br>
            <strong>Total Paid:</strong> ' . number_format($totalPaid, 3) . '<br>
            <strong>Balance:</strong> ' . number_format($balance, 3) . '
        </td>
    </tr>
</table>
<br><br>
<table class="bordered" cellpadding="5">
    <tr class="header-bg">
        <th class="bold">REASON / REMARKS</th>
    </tr>
    <tr>
        <td>' . nl2br(htmlspecialchars($refund['reason'] ?: 'No reason provided.')) . '</td>
    </tr>
</table>
<br><br><br><br>
<table>
    <tr>
        <td width="50%" class="text-center">
            ________________________<br><br>
            <strong>Prepared By</strong>
        </td>
        <td width="50%" class="text-center">
            ________________________<br><br>
            <strong>Approved By</strong>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Refund_Receipt_' . $refund['refund_no'] . '.pdf', 'I');
?>
