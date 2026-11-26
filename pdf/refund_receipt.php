<?php
error_reporting(0);
ini_set('display_errors', 0);
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
    SELECT r.*, c.customer_name, c.customer_mobile, c.customer_cr_cpr, c.customer_addr,
           comp.company_name, comp.company_logo, comp.ids AS resolved_company_id,
           COALESCE(NULLIF(u_prep.profile_name, ''), u_prep.user_name, '') AS prepared_by_name,
           COALESCE(NULLIF(u_app.profile_name, ''), u_app.user_name, '') AS approved_by_name
    FROM tbl_refund_requests r
    LEFT JOIN customer_details c ON r.customer_code = c.customer_id
    LEFT JOIN tbl_company comp ON SUBSTRING_INDEX(r.refund_no, '/', 1) = comp.company_code
    LEFT JOIN tbl_users u_prep ON r.created_by = u_prep.user_id
    LEFT JOIN tbl_users u_app ON r.approved_by = u_app.user_id
    WHERE r.id = ?
");
$stmt->execute([$id]);
$refund = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$refund) {
    die("Refund not found.");
}

$agreement_no = $refund['agreement_no'];

$stmtContract = $pdo->prepare("SELECT service_start_date_time, return_date, km_used, vechile_details, vehicle_no, company_id FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ?");
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
$vehicleColor = 'N/A';
$chassisNo = 'N/A';
if ($contract && isset($contract['vechile_details'])) {
    $make = $contract['vechile_details']['make'] ?? $contract['vechile_details']['brand'] ?? $contract['vechile_details']['brand_name'] ?? '';
    $model = $contract['vechile_details']['model_name'] ?? $contract['vechile_details']['model'] ?? '';
    $vehicleColor = $contract['vechile_details']['vehicle_color'] ?? $contract['vechile_details']['color'] ?? 'N/A';
    $chassisNo = $contract['vechile_details']['chassis_number'] ?? $contract['vechile_details']['chassis_no'] ?? 'N/A';
}
$vehicleName = trim($make . ' ' . $model) ?: 'N/A';

class AA_RefundReceipt_PDF extends TCPDF {
    public $footer_settings = [];
    public function Header() {}
    public function Footer() {
        $ps = $this->footer_settings;
        $showFooter = !isset($ps['show_footer']) || !empty($ps['show_footer']);
        $hex = ltrim((string)($ps['accent_color'] ?? '#1b3d94'), '#');
        $r = 27; $g = 61; $b = 148;
        if (strlen($hex) === 6 && ctype_xdigit($hex)) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        $this->SetY(-24);
        $y = $this->GetY();
        $this->SetDrawColor(203, 213, 225);
        $this->SetLineWidth(0.3);
        $this->Line(10, $y, 200, $y);
        if ($showFooter) {
            $footerText = (string)($ps['footer_text'] ?? '');
            $footerNote = (string)($ps['footer_note'] ?? '');
            if ($footerText !== '') {
                $this->SetXY(10, $y + 2.5);
                $this->SetFont('dejavusans', 'B', 8.5);
                $this->SetTextColor($r, $g, $b);
                $this->Cell(190, 4.5, $footerText, 0, 2, 'C');
            }
            if ($footerNote !== '') {
                $this->SetX(10);
                $this->SetFont('dejavusans', '', 7.5);
                $this->SetTextColor(100, 116, 139);
                $this->Cell(190, 4, $footerNote, 0, 0, 'C');
            }
        }
        $this->SetY(-9);
        $this->SetFont('dejavusans', '', 7.5);
        $this->SetTextColor(100, 116, 139);
        $this->Cell(0, 4, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 0, 'R');
    }
}

$pdf = new AA_RefundReceipt_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Refund Receipt ' . $refund['refund_no']);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 26);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 10);

require_once __DIR__ . '/print_settings_helper.php';
$resolvedCompanyId = $refund['resolved_company_id'] ?? ($contract['company_id'] ?? null);
$printSettings = getPrintSettings(null, $resolvedCompanyId);
$pdf->footer_settings = $printSettings;
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$logo_width = (int)($printSettings['logo_width'] ?? 150);
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';

$fmtRefundDate = !empty($refund['date']) ? date('d M Y', strtotime($refund['date'])) : 'N/A';
$fmtStartDate = !empty($contract['service_start_date_time']) ? date('d M Y, H:i', strtotime($contract['service_start_date_time'])) : 'N/A';
$fmtReturnDate = (!empty($contract['return_date']) && $contract['return_date'] !== '0000-00-00 00:00:00') ? date('d M Y, H:i', strtotime($contract['return_date'])) : 'N/A';

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { padding: 6px; }
    .bold { font-weight: bold; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .header-bg { background-color: ' . $printAccent . '; color: #ffffff; }
    .bordered td, .bordered th { border: 1px solid #dddddd; }
</style>

<!-- MAIN HEADER (Same as Receipt Print) -->
<table cellpadding="1" border="0" width="100%" style="border-bottom: 2px solid ' . $printAccent . '; padding-bottom: 6px;">
    <tr>
        <td width="55%" style="vertical-align: middle;">
            ' . (!empty($logo_base64) ? '<img src="@' . $logo_base64 . '" width="' . $logo_width . '">' : '<b style="font-size: 15pt; color:' . $printAccent . ';">' . htmlspecialchars(strtoupper($printSettings['company_name'] ?? 'FAST LINK')) . '</b>') . '
        </td>
        <td width="45%" align="right" style="vertical-align: top; font-size: 8pt; line-height: 1.35; color:#444444;">
            <b style="font-size: 10pt; color:' . $printAccent . ';">' . htmlspecialchars(strtoupper($printSettings['company_name'] ?? 'FAST LINK')) . '</b><br>
            ' . (!empty($printSettings['header_address']) ? nl2br(htmlspecialchars($printSettings['header_address'])) . '<br>' : '') . '
            ' . (!empty($printSettings['header_phone']) ? 'Tel: ' . htmlspecialchars($printSettings['header_phone']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_email']) ? htmlspecialchars($printSettings['header_email']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_subtitle']) ? '<span class="bold" style="color:#000;">' . htmlspecialchars($printSettings['header_subtitle']) . '</span>' : '') . '
        </td>
    </tr>
</table>
<br>
<table cellpadding="4" cellspacing="0" width="100%">
    <tr class="header-bg">
        <td class="text-center bold" style="font-size: 11pt; letter-spacing: 1px;">REFUND REQUEST / RECEIPT</td>
    </tr>
</table>
<br>
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
        <td>' . htmlspecialchars($fmtRefundDate) . '</td>
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
            <strong>Rentout Date:</strong> ' . htmlspecialchars($fmtStartDate) . '<br>
            <strong>Return Date:</strong> ' . htmlspecialchars($fmtReturnDate) . '<br>
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
            <span class="bold">' . htmlspecialchars($refund['prepared_by_name'] ?? '') . '</span><br>
            ________________________<br><br>
            <strong>Prepared By</strong>
        </td>
        <td width="50%" class="text-center">
            <span class="bold">' . ($refund['status'] === 'Approved' ? htmlspecialchars($refund['approved_by_name'] ?? '') : '') . '</span><br>
            ________________________<br><br>
            <strong>Approved By</strong>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Refund_Receipt_' . $refund['refund_no'] . '.pdf', 'I');
?>
