<?php
error_reporting(0);
ini_set('display_errors', 0);

// Fix for TCPDF missing cURL constants on some local setups without the cURL extension
if (!extension_loaded('curl')) {
    $curl_constants = [
        'CURLOPT_CONNECTTIMEOUT', 'CURLOPT_TIMEOUT', 'CURLOPT_MAXREDIRS', 
        'CURLOPT_FOLLOWLOCATION', 'CURLOPT_URL', 'CURLOPT_RETURNTRANSFER',
        'CURLOPT_SSL_VERIFYPEER', 'CURLOPT_SSL_VERIFYHOST', 'CURLOPT_USERAGENT',
        'CURLINFO_HTTP_CODE', 'CURLOPT_HTTPGET', 'CURLOPT_POST', 'CURLOPT_POSTFIELDS',
        'CURLOPT_PROTOCOLS', 'CURLPROTO_HTTPS', 'CURLPROTO_HTTP', 'CURLPROTO_FTP', 
        'CURLPROTO_FTPS', 'CURLOPT_FAILONERROR'
    ];
    foreach ($curl_constants as $c) {
        if (!defined($c)) define($c, 1);
    }
}

// define('ROOT_PATH', __DIR__);
// require_once ROOT_PATH . '/../envfiles/vendor/autoload.php';
// $dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH . '/../envfiles');
// $dotenv->load();

require_once 'vendor/autoload.php';

// Database configurations
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'sandsl23_aa_car_rental');

if (isset($_ENV['APP_TIMEZONE'])) {
    date_default_timezone_set($_ENV['APP_TIMEZONE']);
}
$key = "AA_CAR_RENTAL_SECRET_KEY_2026";
if (!isset($_GET['token'])) {
    die("Invalid token");
}

$token = $_GET['token'];
// Restore Base64 padding
$remainder = strlen($token) % 4;

if ($remainder) {
    $token .= str_repeat('=', 4 - $remainder);
}

// Convert URL-safe Base64 back
$combined = base64_decode(strtr($token, '-_', '+/'));

// Extract IV length
$iv_length = openssl_cipher_iv_length('aes-256-cbc');

// Extract IV
$iv = substr($combined, 0, $iv_length);

// Extract encrypted data
$encrypted = substr($combined, $iv_length);

// Decrypt
$memo_no = openssl_decrypt(
    $encrypted,
    'aes-256-cbc',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);
// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;

// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;
//$memo_no = $params['memo_no'] ?? '';

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

$data = null;
if (!$sample_mode && !empty($memo_no)) {
  
    $stmt = $mysqli->prepare("SELECT cm.*, c.company_name AS c_company_name, c.company_logo FROM cashmemo cm LEFT JOIN tbl_company c ON cm.company_id = c.ids WHERE cm.cashmemo_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $memo_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
}

if (!$data) {
    die("Cash Memo not found or invalid token.");
}

$contract_id = $data['contract_ids'] ?? '';
$total_advance = 0;
$final_balance = 0;

$stmt_ledger = $mysqli->prepare("
    SELECT l.*
    FROM tbl_customer_ledger l
    WHERE l.contract_ids = ?
    ORDER BY l.trans_date ASC, l.ids ASC
");

if ($stmt_ledger) {
    $stmt_ledger->bind_param("s", $contract_id);
    $stmt_ledger->execute();
    $result_ledger = $stmt_ledger->get_result();
    $rows = $result_ledger->fetch_all(MYSQLI_ASSOC);

    $balance = 0;
    foreach ($rows as &$row) {
        $debit = (float)$row['debit'];
        $credit = (float)$row['credit'];
        $total_advance += $credit;
        $balance += ($debit - $credit);
        $row['running_balance'] = $balance;
    }
    $final_balance = $balance;
}

$contract_from_date = '-';
$contract_to_date = '-';
if (!empty($contract_id) || !empty($data['agreement_no'])) {
    $stmt_c = $mysqli->prepare("SELECT service_start_date_time, service_end_date_time FROM tbl_vehicle_rentout_contracts WHERE ids = ? OR agreement_no = ? LIMIT 1");
    if ($stmt_c) {
        $cid_int = (int)$contract_id;
        $agr_str = (string)($data['agreement_no'] ?? '');
        $stmt_c->bind_param("is", $cid_int, $agr_str);
        $stmt_c->execute();
        $res_c = $stmt_c->get_result();
        if ($c_row = $res_c->fetch_assoc()) {
            if (!empty($c_row['service_start_date_time'])) $contract_from_date = date('d/m/Y', strtotime($c_row['service_start_date_time']));
            if (!empty($c_row['service_end_date_time'])) $contract_to_date = date('d/m/Y', strtotime($c_row['service_end_date_time']));
        }
    }
}

function bhdNumberWords($num) {
    $num = (int)$num;
    if ($num === 0) return 'Zero';
    $ones = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten',
        'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
    $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
    $parts = [];
    if ($num >= 1000000) {
        $parts[] = bhdNumberWords(intdiv($num, 1000000)) . ' Million';
        $num %= 1000000;
    }
    if ($num >= 1000) {
        $parts[] = bhdNumberWords(intdiv($num, 1000)) . ' Thousand';
        $num %= 1000;
    }
    if ($num >= 100) {
        $parts[] = $ones[intdiv($num, 100)] . ' Hundred';
        $num %= 100;
    }
    if ($num >= 20) {
        $t = $tens[intdiv($num, 10)];
        $o = $num % 10;
        $parts[] = $o > 0 ? ($t . '-' . $ones[$o]) : $t;
    } elseif ($num > 0) {
        $parts[] = $ones[$num];
    }
    return implode(' ', $parts);
}

function bhdAmountToWords($amount) {
    $formatted = number_format((float)$amount, 3, '.', '');
    list($dinars, $fils) = explode('.', $formatted);
    return 'BD ' . bhdNumberWords((int)$dinars) . ' and Fils ' . bhdNumberWords((int)$fils) . ' Only';
}
                
$items = is_string($data['items']) ? json_decode($data['items'], true) : $data['items'];
if (!is_array($items)) {
    $items = [];
}

// Initialize TCPDF
class AA_CashMemo_PDF extends TCPDF {
    // Overriding Header and Footer to keep the layout pixel perfect and custom
     public $company_signature = '';
    public $customer_signature = '';
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

$pdf = new AA_CashMemo_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Cash Memo ' . $data['cashmemo_no']);

// Set very narrow margins to match physical layout
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Set font to DejaVuSans for dual English/Arabic support
$pdf->SetFont('dejavusans', '', 8);
$pdf->setCellPaddings(0, 0, 0, 0);

// Prepare Logo & Print Settings Data
require_once __DIR__ . '/print_settings_helper.php';
$printSettings = getPrintSettings($mysqli ?? null, $data['company_id'] ?? null);
$pdf->footer_settings = $printSettings;
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$logo_width = (int)($printSettings['logo_width'] ?? 150);
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';
if (!empty($data['company_signature'])) {

   $pdf->company_signature = ltrim($data['company_signature'] ?? '', '/');
}
if (!empty($data['customer_signature'])) {
 $pdf->customer_signature = ltrim($data['customer_signature'] ?? '', '/');
    
}
$amountWords = bhdAmountToWords($data['grand_total'] ?? 0);
$amtVal = (float)($data['subtotal'] ?? $data['allItemSubtotal'] ?? $data['grand_total'] ?? 0);
$vatVal = (float)($data['vat_total'] ?? 0);
$netVal = (float)($data['grand_total'] ?? 0);
$recDateFmt = !empty($data['cashmemo_date']) ? date('d/m/Y', strtotime($data['cashmemo_date'])) : date('d/m/Y');
$chqDateFmt = (!empty($data['cashmemo_cheque_date']) && $data['cashmemo_cheque_date'] !== '0000-00-00') ? date('d/m/Y', strtotime($data['cashmemo_cheque_date'])) : '';
$receivedFrom = trim(($data['customer_name'] ?? '') . (!empty($data['customer_phone']) ? ' - ' . $data['customer_phone'] : ''));
$beingText = trim(($data['model_names'] ?? '') . (!empty($data['vehicle_no']) ? '   Car No. ' . $data['vehicle_no'] : ''));
$firstItemDesc = !empty($items[0]['item_name']) ? trim((string)$items[0]['item_name']) : '';
$remarksLine = trim(($data['cashmemo_notes'] ?? '') ?: $firstItemDesc);
$companyLabel = strtoupper($printSettings['company_name'] ?? ($data['company_name'] ?? 'FAST LINK'));

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { vertical-align: middle; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .dot-line { border-bottom: 1px dotted #444444; }
    .solid-line { border-bottom: 1px solid #222222; }
    .box-cell { border: 1px solid #333333; padding: 5px; }
</style>

<!-- MAIN HEADER -->
<table cellpadding="1" border="0" width="100%" style="border-bottom: 2px solid ' . $printAccent . '; padding-bottom: 6px;">
    <tr>
        <td width="55%" style="vertical-align: middle;">
            ' . (!empty($logo_base64) ? '<img src="@' . $logo_base64 . '" width="' . $logo_width . '">' : '<b style="font-size: 15pt; color:' . $printAccent . ';">' . htmlspecialchars($companyLabel) . '</b>') . '
        </td>
        <td width="45%" align="right" style="vertical-align: top; font-size: 8pt; line-height: 1.35; color:#444444;">
            <b style="font-size: 10pt; color:' . $printAccent . ';">' . htmlspecialchars($companyLabel) . '</b><br>
            ' . (!empty($printSettings['header_address']) ? nl2br(htmlspecialchars($printSettings['header_address'])) . '<br>' : '') . '
            ' . (!empty($printSettings['header_phone']) ? 'Tel: ' . htmlspecialchars($printSettings['header_phone']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_email']) ? htmlspecialchars($printSettings['header_email']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_subtitle']) ? '<span class="bold" style="color:#000;">' . htmlspecialchars($printSettings['header_subtitle']) . '</span>' : '') . '
        </td>
    </tr>
</table>

<br>

<!-- RECEIPT VOUCHER BANNER -->
<table cellpadding="3" cellspacing="0" width="100%">
    <tr style="background-color: ' . $printAccent . '; color: #ffffff;">
        <td class="text-center bold" style="font-size:9pt; letter-spacing:2px; line-height:1;">
            RECEIPT VOUCHER / سند قبض
        </td>
    </tr>
</table>

<br>

<!-- RECEIPT NO & RECEIPT DATE -->
<table cellpadding="4" border="0" width="100%" style="font-size: 9pt;">
    <tr>
        <td width="13%" class="bold">Receipt No.</td>
        <td width="37%" class="solid-line bold" style="color:' . $printAccent . '; font-size: 10.5pt;">' . htmlspecialchars($data['cashmemo_no']) . '</td>
        <td width="18%"></td>
        <td width="14%" class="bold text-right">Receipt Date</td>
        <td width="18%" class="solid-line bold text-center">' . htmlspecialchars($recDateFmt) . '</td>
    </tr>
</table>

<br>

<!-- RECEIVED FROM & AMOUNT IN WORDS -->
<table cellpadding="5" border="0" width="100%" style="font-size: 9pt;">
    <tr>
        <td width="17%" class="bold">Received From</td>
        <td width="83%" class="dot-line bold text-center" style="font-size: 9.5pt;">' . htmlspecialchars($receivedFrom) . '</td>
    </tr>
    <tr>
        <td width="17%" class="bold">The sum of BD</td>
        <td width="83%" class="dot-line bold text-center" style="font-size: 9.5pt;">' . htmlspecialchars($amountWords) . '</td>
    </tr>
</table>

<table cellpadding="2" border="0" width="100%">
    <tr><td class="dot-line" style="font-size:2pt;">&nbsp;</td></tr>
</table>

<!-- BEING -->
<table cellpadding="5" border="0" width="100%" style="font-size: 9pt;">
    <tr>
        <td width="17%" class="bold text-center">Being</td>
        <td width="83%" class="dot-line bold text-center" style="font-size: 9.5pt;">' . htmlspecialchars($beingText) . '</td>
    </tr>
</table>

<br>

<!-- AMOUNT / VAT / NET + PAY MODE / ADVANCE / BALANCE -->
<table cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size: 8pt;">
    <tr>
        <td width="34%" valign="middle">
            <table cellpadding="4" cellspacing="0" style="border: 1px solid #333333; width: 100%;">
                <tr>
                    <td width="36%" class="text-center bold" style="border-right: 1px solid #333; border-bottom: 1px solid #333; font-size: 7pt;">Amount (BHD)</td>
                    <td width="24%" class="text-center bold" style="border-right: 1px solid #333; border-bottom: 1px solid #333; font-size: 7pt;">VAT</td>
                    <td width="40%" class="text-center bold" style="border-bottom: 1px solid #333; font-size: 7pt;">Net Amount (BHD)</td>
                </tr>
                <tr>
                    <td class="text-center bold" style="border-right: 1px solid #333; font-size: 8.5pt;">' . number_format($amtVal, 3) . '</td>
                    <td class="text-center bold" style="border-right: 1px solid #333; font-size: 8.5pt;">' . number_format($vatVal, 3) . '</td>
                    <td class="text-center bold" style="font-size: 8.5pt;">' . number_format($netVal, 3) . '</td>
                </tr>
            </table>
        </td>
        <td width="1%"></td>
        <td width="21%" valign="middle">
            <table cellpadding="4" border="0" width="100%">
                <tr>
                    <td width="46%" class="bold text-right" style="font-size: 7.5pt; white-space: nowrap;">Pay Mode</td>
                    <td width="54%" class="box-cell text-center bold" style="font-size: 8pt;">' . htmlspecialchars(strtoupper($data['cashmemo_payment_type'] ?? 'CASH')) . '</td>
                </tr>
            </table>
        </td>
        <td width="22%" valign="middle">
            <table cellpadding="4" border="0" width="100%">
                <tr>
                    <td width="46%" class="bold text-right" style="font-size: 7.5pt; white-space: nowrap;">Advance</td>
                    <td width="54%" class="box-cell text-center bold" style="font-size: 8pt;">' . number_format($total_advance, 3) . '</td>
                </tr>
            </table>
        </td>
        <td width="22%" valign="middle">
            <table cellpadding="4" border="0" width="100%">
                <tr>
                    <td width="46%" class="bold text-right" style="font-size: 7.5pt; white-space: nowrap;">Balance</td>
                    <td width="54%" class="box-cell text-center bold" style="font-size: 8pt;">' . number_format($final_balance, 3) . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table cellpadding="2" border="0" width="100%">
    <tr><td class="dot-line" style="font-size:2pt;">&nbsp;</td></tr>
</table>

<!-- CHEQUE / REMARKS LINE -->
<table cellpadding="5" border="0" width="100%" style="font-size: 8.5pt;">
    <tr>
        <td width="15%" class="bold" style="white-space: nowrap;">Cheque / Ref</td>
        <td width="15%" class="bold">' . htmlspecialchars($data['cashmemo_cheque_ref_no'] ?? '') . '</td>
        <td width="10%" class="bold">Notes</td>
        <td width="32%" class="bold">' . htmlspecialchars($remarksLine) . '</td>
        <td width="15%" class="bold text-right" style="white-space: nowrap;">Cheque Date</td>
        <td width="13%" class="bold">' . htmlspecialchars($chqDateFmt) . '</td>
    </tr>
</table>

<table cellpadding="2" border="0" width="100%">
    <tr><td class="dot-line" style="font-size:2pt;">&nbsp;</td></tr>
</table>
<br>

<!-- FROM / TO DATES + AGREEMENT NO + VEHICLE REGN NO -->
<table cellpadding="4" border="0" width="100%" style="font-size: 8.5pt;">
    <tr>
        <td width="11%" class="bold" style="white-space: nowrap;">From Date</td>
        <td width="16%" class="box-cell text-center bold">' . htmlspecialchars($contract_from_date) . '</td>
        <td width="2%"></td>
        <td width="16%" rowspan="2" class="bold text-right" valign="middle" style="white-space: nowrap;">Agreement No.</td>
        <td width="20%" rowspan="2" class="box-cell text-center bold" valign="middle" style="font-size: 9.5pt;">' . htmlspecialchars($data['agreement_no'] ?? '-') . '</td>
        <td width="2%"></td>
        <td width="16%" rowspan="2" class="bold text-right" valign="middle" style="white-space: nowrap;">Vehicle Regn No.</td>
        <td width="17%" rowspan="2" class="box-cell text-center bold" valign="middle" style="font-size: 9.5pt;">' . htmlspecialchars($data['vehicle_no'] ?? '-') . '</td>
    </tr>
    <tr>
        <td class="bold" style="white-space: nowrap;">To Date</td>
        <td class="box-cell text-center bold">' . htmlspecialchars($contract_to_date) . '</td>
        <td></td>
    </tr>
</table>

<table cellpadding="4" border="0" width="100%">
    <tr><td class="dot-line" style="font-size:3pt;">&nbsp;</td></tr>
</table>

<br><br>

<!-- SIGNATURES & COMPANY FOOTER -->
<table cellpadding="4" border="0" width="100%" style="font-size: 8.5pt;">
    <tr>
        <td width="14%" class="bold" valign="bottom">Rent a Car</td>
        <td width="32%" class="solid-line text-center" valign="bottom">'
            . (!empty($data['company_signature']) && file_exists(ltrim($data['company_signature'], '/')) ? '<img src="' . htmlspecialchars(ltrim($data['company_signature'], '/')) . '" height="28"><br>' : '')
            . '<span class="bold">' . htmlspecialchars($data['company_sign_name'] ?: ($data['user_name'] ?? $companyLabel)) . '</span>
        </td>
        <td width="8%"></td>
        <td width="16%" class="bold text-right" valign="bottom">Renter Signature</td>
        <td width="30%" class="solid-line text-center" valign="bottom">'
            . (!empty($data['customer_signature']) && file_exists(ltrim($data['customer_signature'], '/')) ? '<img src="' . htmlspecialchars(ltrim($data['customer_signature'], '/')) . '" height="28"><br>' : '')
            . '<span class="bold">' . htmlspecialchars($data['customer_sign_name'] ?: ($data['customer_name'] ?? '')) . '</span>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('CashMemo_' . $data['cashmemo_no'] . '.pdf', 'I');
