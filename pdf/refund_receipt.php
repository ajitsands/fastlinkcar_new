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
    SELECT r.*, c.customer_name, c.customer_mobile, c.customer_cr_cpr, c.customer_addr, comp.company_name, comp.company_logo, comp.ids AS resolved_company_id
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
    public $company_label = 'For FAST LINK';
    public $footer_settings = [];
    public function Header() {}
    public function Footer() {
        $this->SetY(-45);
        $footerY = $this->GetY();
        $this->SetFont('dejavusans', '', 8);

        $this->Rect(10, $footerY, 190, 24);
        $this->Line(105, $footerY, 105, $footerY + 24);

        $this->SetXY(10, $footerY + 12);
        $this->Cell(95, 5, '________________________________________', 0, 2, 'C');
        $this->SetX(10);
        $this->Cell(95, 5, $this->company_label, 0, 2, 'C');

        $this->SetXY(105, $footerY + 12);
        $this->Cell(95, 5, '________________________________________', 0, 2, 'C');
        $this->SetX(105);
        $this->Cell(95, 5, 'Customer Acceptance / قبول الزبون', 0, 2, 'C');

        $ps = $this->footer_settings;
        $showFooter = !isset($ps['show_footer']) || !empty($ps['show_footer']);
        $hex = ltrim((string)($ps['accent_color'] ?? '#1b3d94'), '#');
        $r = 27; $g = 61; $b = 148;
        if (strlen($hex) === 6 && ctype_xdigit($hex)) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        $y = $footerY + 26;
        $this->SetDrawColor(203, 213, 225);
        $this->SetLineWidth(0.3);
        $this->Line(10, $y, 200, $y);
        if ($showFooter) {
            $footerText = (string)($ps['footer_text'] ?? '');
            $footerNote = (string)($ps['footer_note'] ?? '');
            if ($footerText !== '') {
                $this->SetXY(10, $y + 2);
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
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 8);
$pdf->setCellPaddings(0, 0, 0, 0);

require_once __DIR__ . '/print_settings_helper.php';
$resolvedCompanyId = $refund['resolved_company_id'] ?? ($contract['company_id'] ?? null);
$printSettings = getPrintSettings(null, $resolvedCompanyId);
$pdf->footer_settings = $printSettings;
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$logo_width = (int)($printSettings['logo_width'] ?? 150);
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';
if (!empty($printSettings['company_name'])) {
    $pdf->company_label = 'For ' . strtoupper($printSettings['company_name']);
}

$fmtRefundDate = !empty($refund['date']) ? date('d M Y', strtotime($refund['date'])) : 'N/A';
$fmtStartDate = !empty($contract['service_start_date_time']) ? date('d M Y', strtotime($contract['service_start_date_time'])) : 'N/A';
$fmtReturnDate = (!empty($contract['return_date']) && $contract['return_date'] !== '0000-00-00 00:00:00') ? date('d M Y', strtotime($contract['return_date'])) : 'N/A';
$custContact = trim(($refund['customer_addr'] ?? '') . (!empty($refund['customer_mobile']) ? ' | Tel: ' . $refund['customer_mobile'] : ''), ' |');
$custContact = $custContact ?: 'N/A';

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { vertical-align: middle; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .bordered td, .bordered th { border: 1px solid #000; }
</style>

<!-- MAIN HEADER -->
<table cellpadding="1" border="0" width="100%">
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

<!-- REFUND RECEIPT BANNER -->
<table cellpadding="3" cellspacing="0" width="100%">
    <tr style="background-color: ' . $printAccent . '; color: #ffffff;">
        <td class="text-center bold" style="font-size:9pt; letter-spacing:2px; line-height:1;">
            REFUND RECEIPT / سند استرداد
        </td>
    </tr>
</table>

<br>

<!-- METADATA BOXES -->
<table cellpadding="4" style="border: 1px solid #000; width: 100%; border-collapse: collapse; margin: 0px;">
    <tr>
        <td width="18%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Agreement No.</td>
        <td width="30%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($refund['agreement_no'] ?? 'N/A') . '</td>
        <td width="17%" align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم الاتفاقية</td>
        <td width="35%" rowspan="4" style="vertical-align: top; padding: 8px; line-height: 1.4;">
            <span style="font-size: 9.5pt;"><b>Date :</b> ' . htmlspecialchars($fmtRefundDate) . '</span><br>
            <span style="font-size: 8.5pt;"><b>Status :</b> ' . htmlspecialchars($refund['status']) . ' &nbsp;|&nbsp; <b>Mode :</b> ' . htmlspecialchars($refund['refund_mode'] ?? 'Cash') . '</span><br><br>
            <span style="font-size: 10pt; font-weight: bold;">No.</span>
            <span style="color:' . $printAccent . '; font-size:14pt; font-weight:bold; font-family:courier;">' . htmlspecialchars($refund['refund_no']) . '</span>
        </td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Car No.</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($contract['vehicle_no'] ?? 'N/A') . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Type of Car</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($vehicleName) . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">نوع السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; vertical-align: middle;">Colour</td>
        <td style="border-right: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($vehicleColor) . '</td>
        <td align="right" style="border-right: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">اللون</td>
    </tr>
</table>

<br>

<!-- CUSTOMER NAME & ADDRESS -->
<table cellpadding="4" style="border: 1px solid #000; width: 100%;">
    <tr>
        <td width="18%">Customer Name :</td>
        <td width="64%" class="bold">' . htmlspecialchars($refund['customer_name'] ?? 'N/A') . ' (' . htmlspecialchars($refund['customer_code'] ?? '-') . ')</td>
        <td width="18%" align="right" style="font-family:dejavusans; font-size: 7.5pt;">اسم الزبون :</td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000;">Address / Tel :</td>
        <td style="border-top: 1px solid #000;">' . htmlspecialchars($custContact) . '</td>
        <td align="right" style="border-top: 1px solid #000; font-family:dejavusans; font-size: 7.5pt;">العنوان / الهاتف :</td>
    </tr>
</table>

<br>

<!-- REFUND DETAILS TABLE -->
<table class="bordered" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:' . $printAccent . '; color:#ffffff; font-weight:bold;">
            <th width="6%" class="text-center" style="font-size: 7.5pt;">No.</th>
            <th width="40%" class="text-center" style="font-size: 7.5pt;">Description</th>
            <th width="22%" class="text-center" style="font-size: 7.5pt;">Rentout / Return</th>
            <th width="10%" class="text-center" style="font-size: 7.5pt;">KM Used</th>
            <th width="10%" class="text-center" style="font-size: 7.5pt;">Mode</th>
            <th width="12%" class="text-center" style="font-size: 7.5pt;">Amount</th>
        </tr>
    </thead>
    <tbody>
        <tr height="28">
            <td width="6%" class="text-center">1</td>
            <td width="40%" class="bold">Refund Voucher - ' . htmlspecialchars($refund['agreement_no'] ?? '') . ($chassisNo !== 'N/A' ? '<br><span style="font-weight:normal; font-size:7pt;">Chassis: ' . htmlspecialchars($chassisNo) . '</span>' : '') . '</td>
            <td width="22%" class="text-center">' . htmlspecialchars($fmtStartDate) . ' to ' . htmlspecialchars($fmtReturnDate) . '</td>
            <td width="10%" class="text-center">' . htmlspecialchars($contract['km_used'] ?? '0') . '</td>
            <td width="10%" class="text-center">' . htmlspecialchars($refund['refund_mode'] ?? 'Cash') . '</td>
            <td width="12%" class="text-right bold">' . number_format($refund['amount'], 3) . '</td>
        </tr>
    </tbody>
</table>

<br>

<!-- REASON / NOTE AND FINANCIAL SUMMARY -->
<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 0px; padding: 0px; border-collapse: collapse;">
    <tr>
        <td width="61%" height="70" style="border: 1px solid #000; padding: 6px;" valign="top">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="22%" valign="top" style="line-height: 1.5; font-weight: bold;">Remarks :</td>
                    <td width="78%" valign="top" style="font-size: 8pt; line-height: 1.4; text-align: left;">' . nl2br(htmlspecialchars($refund['reason'] ?: 'No reason provided.')) . '</td>
                </tr>
            </table>
        </td>
        <td width="2%">&nbsp;</td>
        <td width="37%" style="padding: 0px; margin: 0px; vertical-align: top;">
            <table cellpadding="4.5" style="border: 1px solid #000; width: 100%; border-collapse: collapse; margin: 0px;">
                <tr>
                    <td width="55%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5;" align="center">Total Payable</td>
                    <td width="45%" style="border-bottom: 1px solid #000;" align="right" class="bold">' . number_format($totalCharged, 3) . '</td>
                </tr>
                <tr>
                    <td width="55%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5;" align="center">Total Paid</td>
                    <td width="45%" style="border-bottom: 1px solid #000;" align="right" class="bold">' . number_format($totalPaid, 3) . '</td>
                </tr>
                <tr>
                    <td width="55%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5;" align="center">Agreement Balance</td>
                    <td width="45%" style="border-bottom: 1px solid #000;" align="right" class="bold">' . number_format($balance, 3) . '</td>
                </tr>
                <tr style="background-color: ' . $printAccent . '; color: #ffffff;">
                    <td width="55%" style="border-right: 1px solid #000;" align="center" class="bold">Refund Amount</td>
                    <td width="45%" align="right" class="bold">' . number_format($refund['amount'], 3) . ' BHD</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Refund_Receipt_' . $refund['refund_no'] . '.pdf', 'I');
?>
