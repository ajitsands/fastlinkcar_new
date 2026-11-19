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

        $balance += ($debit - $credit);

        $row['running_balance'] = $balance;
    }

    // final balance
    $final_balance = $balance;
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
    
    public function Header() {}
    public function Footer() {

    $this->SetY(-45);

    $footerY = $this->GetY();

    $this->SetFont('dejavusans', '', 8);

    // Outer box
    $this->Rect(10, $footerY, 190, 30);

    // Middle line
    $this->Line(105, $footerY, 105, $footerY + 30);

    // ================= LEFT SIGNATURE =================

    if (!empty($this->company_signature) && file_exists($this->company_signature)) {
        $this->Image(
            $this->company_signature,
            25,
            $footerY + 2,
            55,
            12
        );
    }

    // Line + text LEFT
    $this->SetXY(10, $footerY + 15);
    $this->Cell(95, 5, '________________________________________', 0, 2, 'C');

    $this->SetX(10);
    $this->Cell(95, 5, 'For FAST LINK', 0, 2, 'C');


    // ================= RIGHT SIGNATURE =================

    if (!empty($this->customer_signature) && file_exists($this->customer_signature)) {
        $this->Image(
            $this->customer_signature,
            120,
            $footerY + 2,
            55,
            12
        );
    }

    $this->SetXY(105, $footerY + 15);
    $this->Cell(95, 5, '________________________________________', 0, 2, 'C');

    $this->SetX(105);
    $this->Cell(95, 5, 'Customer Acceptance / قبول الزبون', 0, 2, 'C');


    // ================= PAGE NUMBER =================

    $this->SetY(-10);
    $this->SetFont('dejavusans', 'I', 8);

    $this->Cell(
        0,
        5,
        'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(),
        0,
        0,
        'R'
    );
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
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$logo_width = (int)($printSettings['logo_width'] ?? 150);
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';
if (!empty($data['company_signature'])) {

   $pdf->company_signature = ltrim($data['company_signature'] ?? '', '/');
}
if (!empty($data['customer_signature'])) {
 $pdf->customer_signature = ltrim($data['customer_signature'] ?? '', '/');
    
}
$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { vertical-align: middle; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .red-text { color: ' . $printAccent . '; }
    .bold { font-weight: bold; }
    .bg-light { background-color: #f5f5f5; }
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

<!-- TAX INVOICE BANNER -->
<table cellpadding="3" cellspacing="0" width="100%">
    <tr style="background-color: #1b3d94; color: #ffffff;">
        <td class="text-center bold" style="font-size:9pt; letter-spacing:2px; line-height:1;">
            CASH MEMO / سند قبض
        </td>
    </tr>
</table>

<br>

<!-- METADATA BOXES (Flat Table for Perfect Left-Right Alignment) -->
<table cellpadding="4" style="border: 1px solid #000; width: 100%; border-collapse: collapse; margin: 0px;">
    <tr>
        <td width="18%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Agreement No.</td>
        <td width="30%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['agreement_no']) . '</td>
        <td width="17%" align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم الاتفاقية</td>
        <td width="35%" rowspan="4" style="vertical-align: top; padding: 8px; line-height: 1.4;">
            <span style="font-size: 9.5pt;"><b>Date :</b> ' . htmlspecialchars(date('d-m-y', strtotime($data['cashmemo_date']))) . '</span><br><br><br>
            <span style="font-size: 10pt; font-weight: bold;">No.</span> 
            <span style="color:#1b3d94; font-size:15pt; font-weight:bold; font-family:courier;">' . htmlspecialchars($data['cashmemo_no']) . '</span>
        </td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Car No.</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['vehicle_no']) . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Type of Car</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['model_names']) . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">نوع السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; vertical-align: middle;">Colour</td>
        <td style="border-right: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['vehicle_color']) . '</td>
        <td align="right" style="border-right: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">اللون</td>
    </tr>
</table>

<br>

<!-- CUSTOMER NAME & ADDRESS -->
<table cellpadding="4" style="border: 1px solid #000; width: 100%;">
    <tr>
        <td width="18%">Customer Name :</td>
        <td width="64%" class="bold">' . htmlspecialchars($data['customer_name']) . '</td>
        <td width="18%" align="right" style="font-family:dejavusans; font-size: 7.5pt;">اسم الزبون :</td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000;">Address :</td>
        <td style="border-top: 1px solid #000;">' . htmlspecialchars($data['customer_address']) . '</td>
        <td align="right" style="border-top: 1px solid #000; font-family:dejavusans; font-size: 7.5pt;">العنوان :</td>
    </tr>
</table>

<br>

<!-- MAIN ITEMS TABLE -->
<table class="bordered" cellpadding="5" width="100%">
    <thead>
        <tr style="background-color:#1b3d94; color:#ffffff; font-weight:bold;">
            <th width="5%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">No.</th>
            <th width="45%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">Description</th>
            <th width="8%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">Qty.</th>
            <th width="10%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">Price</th>
            <th width="8%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">
                VAT%
            </th>
            <th width="12%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">
                VAT Amount
            </th>
            <th width="12%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">Total</th>
        </tr>
    </thead>
    <tbody>';


foreach ($items as $index => $item) {
    $sno = $index + 1;
    $desc = $item['item_name'] !== '' ? htmlspecialchars($item['item_name']) : '';
    $qty = $item['qty'] !== '' ? $item['qty'] : '';
    $price = $item['price'] !== '' ? (is_numeric($item['price']) ? number_format($item['price'], 3) : $item['price']) : '';
    $vat = $item['vat'] !== '' ? (is_numeric($item['vat']) ? number_format($item['vat'], 2) : $item['vat']) : '';
    $amount = $qty * $price;
    $vat_amount = number_format($amount * $vat / 100, 3);
    $total = $item['total'] !== '' ? (is_numeric($item['total']) ? number_format($item['total'], 3) : $item['total']) : '';

    $html .= '
        <tr height="25">
            <td width="5%" class="text-center">' . $sno . '</td>

            <td width="45%" class="bold">' . $desc . '</td>
        
            <td width="8%" class="text-center">' . $qty . '</td>
        
            <td width="10%" class="text-right bold">' . $price . '</td>
        
            <td width="8%" class="text-right bold">' . $vat . '</td>
        
            <td width="12%" class="text-right bold">' . $vat_amount . '</td>
        
            <td width="12%" class="text-right bold">' . $total . '</td>
        </tr>';
}

$html .= '
    </tbody>
</table>

<br>

<!-- FINANCIAL BLOCK AND NOTES -->
<table cellpadding="0" cellspacing="0" border="0" width="100%" style="margin: 0px; padding: 0px; border-collapse: collapse;">
    <tr>
        <!-- Note Box (Directly bordered on top-level outer cell to guarantee exact left alignment) -->
        <td width="61%"  height="70" style="border: 1px solid #000; padding: 6px;" valign="middle">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0px; padding: 0px;">
                <tr>
                    <td width="15%" valign="middle" style="line-height: 1.5; font-weight: bold;">Note:</td>
                    <td width="85%" valign="middle" style="font-size: 8pt; line-height: 1.4; text-align: left;">' . htmlspecialchars($data['cashmemo_notes']) . '</td>
                   
                </tr>
            </table>
        </td>
        
        <!-- Spacer between columns -->
        <td width="2%">&nbsp;</td>
        
        <!-- Right Cell: Financial totals (spans 3 rows) -->
        <td width="37%" rowspan="3" style="padding: 0px; margin: 0px; vertical-align: top;">
            <table cellpadding="4.5" style="border: 1px solid #000; width: 100%; border-collapse: collapse; margin: 0px;">
                <tr>
                    <td width="55%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Subtotal Amount</span>
                    </td>
                     
                    <td width="45%" style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['allItemSubtotal'], 3) . '
                    </td>
                </tr>
                 <tr>
                   
                     <td width="55%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Subtotal Before VAT</span>
                    </td>
                    <td width="45%" style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['subtotal'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Discount </span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['total_discount_amount'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">After Discount </span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['after_discount_amount'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">VAT Total </span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['vat_total'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Paid </span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['grand_total'], 3) . '
                    </td>
                </tr>
              
                <tr>
                    <td style="border-right: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Balance </span>
                    </td>
                    <td style="line-height: 1.5; color: #1b3d94;" valign="middle" align="right" class="bold">
                        ' . number_format($final_balance, 3) . '
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
    <!-- Spacer Row -->
    <tr>
        <td height="8" style="font-size: 1px; line-height: 1px;">&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    
    <!-- Warning Box (Directly bordered on top-level outer cell to guarantee exact left alignment) -->
    <tr>
        <td style="border: 1px solid #1b3d94; padding: 0px;" align="center" valign="middle">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0px; padding: 0px;">
                <tr><td height="12" style="font-size: 1px; line-height: 1px;">&nbsp;</td></tr>
                <tr>
                    <td align="center">
                        <span style="color:#1b3d94; font-family:dejavusans; font-size:9.5pt; font-weight:bold; line-height:1.4;">ملاحظة: المبلغ المدفوع لا يسترجع في حالة الإلغاء</span><br>
                        <span style="color:#1b3d94; font-family:dejavusans; font-size:8.5pt; font-weight:normal; line-height:1.4;">The amount paid not get back in the event of cancellation</span>
                    </td>
                </tr>
                <tr><td height="12" style="font-size: 1px; line-height: 1px;">&nbsp;</td></tr>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>

<br><br>

<!-- SIGNATURE BOX -->

';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('CashMemo_' . $data['cashmemo_no'] . '.pdf', 'I');
