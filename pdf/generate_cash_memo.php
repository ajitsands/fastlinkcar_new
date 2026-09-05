<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

require_once __DIR__ . '/tcpdf_include.php';

// Fallback environment loader if accessed directly
if (empty($_ENV['DB_HOST']) || empty($_ENV['DB_NAME'])) {
    $possibleEnv = [
        dirname(__DIR__) . '/envfiles/.env',
        __DIR__ . '/../envfiles/.env',
        __DIR__ . '/.env'
    ];
    foreach ($possibleEnv as $f) {
        if (file_exists($f)) {
            $lines = file($f, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || $line[0] === '#') continue;
                if (strpos($line, '=') !== false) {
                    list($key, $val) = explode('=', $line, 2);
                    $key = trim($key);
                    $val = trim($val, " \t\n\r\0\x0B\"'");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                    putenv("$key=$val");
                }
            }
            break;
        }
    }
}

// Database configurations
$dbHost = $_ENV['DB_HOST'] ?? (defined('DB_HOST') ? DB_HOST : 'localhost');
$dbUser = $_ENV['DB_USER'] ?? (defined('DB_USER') ? DB_USER : 'root');
$dbPass = $_ENV['DB_PASS'] ?? (defined('DB_PASS') ? DB_PASS : '');
$dbName = $_ENV['DB_NAME'] ?? (defined('DB_NAME') ? DB_NAME : 'sandsl23_aa_car_rental');

if (!defined('DB_HOST')) define('DB_HOST', $dbHost);
if (!defined('DB_USER')) define('DB_USER', $dbUser);
if (!defined('DB_PASS')) define('DB_PASS', $dbPass);
if (!defined('DB_NAME')) define('DB_NAME', $dbName);

if (isset($_ENV['APP_TIMEZONE'])) {
    date_default_timezone_set($_ENV['APP_TIMEZONE']);
}

// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;
$memo_no = $params['memo_no'] ?? '';

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

$data = null;
if (!$sample_mode && !empty($memo_no)) {
    // We assume the user has a table for cash memos. They will fill this query later.
    // As a placeholder, we try to fetch from contracts or a general cash memo table
    $stmt = $mysqli->prepare("SELECT * FROM tbl_cash_memos WHERE memo_no = ? OR agreement_no = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $memo_no, $memo_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
}

// Load elegant sample data if not found or in sample mode
if (!$data) {
    $data = [
        'agreement_no' => $params['agreement_no'] ?? 'AGR-2026-10023',
        'car_no' => $params['car_no'] ?? '184920',
        'type_of_car' => $params['type_of_car'] ?? 'Hyundai Accent',
        'colour' => $params['colour'] ?? 'Silver',
        'date' => $params['date'] ?? date('d-m-Y'),
        'receipt_no' => $params['receipt_no'] ?? '0006386',
        'customer_name' => $params['customer_name'] ?? 'M/S. ABC COMPANY CO. W.L.L',
        'customer_address' => $params['address'] ?? 'Flat 12, Building 45, Road 8, Block 302, Manama, Kingdom of Bahrain',
        'items' => json_encode([
            ['sno' => 1, 'description' => 'Car Rental Charges (Hyundai Accent) - 1 Week', 'qty' => 1, 'price' => 150.000, 'total' => 150.000],
            ['sno' => 2, 'description' => 'Extra Km Charges (200 Km)', 'qty' => 1, 'price' => 20.000, 'total' => 20.000],
            ['sno' => 3, 'description' => 'Delivery & Collection Service', 'qty' => 1, 'price' => 10.000, 'total' => 10.000]
        ]),
        'total_amount' => 180.000,
        'discount' => 10.000,
        'net_amount' => 170.000,
        'paid' => 170.000,
        'balance' => 0.000,
        'note' => $params['note'] ?? 'Payment received towards car rental agreement charges. Thank you for your business!'
    ];
}

// Parse Items JSON if it's stored as JSON
$items = is_string($data['items']) ? json_decode($data['items'], true) : $data['items'];
if (!is_array($items)) {
    $items = [];
}

// Pad items table to maintain layout height exactly like physical receipt
while (count($items) < 8) {
    $items[] = ['sno' => '', 'description' => '', 'qty' => '', 'price' => '', 'total' => ''];
}

// Initialize TCPDF
class AA_CashMemo_PDF extends TCPDF {
    // Overriding Header and Footer to keep the layout pixel perfect and custom
    public function Header() {}
    public function Footer() {}
}

$pdf = new AA_CashMemo_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Cash Memo ' . $data['receipt_no']);

// Set very narrow margins to match physical layout
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);
$pdf->AddPage();

// Set font to DejaVuSans for dual English/Arabic support
$pdf->SetFont('dejavusans', '', 8);
$pdf->setCellPaddings(0, 0, 0, 0);

// Prepare Logo Data
$logo_path = '../assets/img/logo/logo.png';
$logo_base64 = '';
if (file_exists($logo_path)) {
    $logo_base64 = base64_encode(file_get_contents($logo_path));
}

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { vertical-align: middle; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .red-text { color: #d32f2f; }
    .bold { font-weight: bold; }
    .bg-light { background-color: #f5f5f5; }
    .bordered td, .bordered th { border: 1px solid #000; }
</style>

<!-- MAIN HEADER -->
<table cellpadding="2" border="0" width="100%">
    <tr>
        <td width="33%" style="vertical-align: top;">
            <b style="font-size:13pt; color:#cc0000; font-family:dejavusans;">AA CAR RENTAL</b><br>
            <span style="font-size:8pt; line-height: 1.3;">
                Tel + 973 17300322<br>
                Fax + 973 17300311<br>
                Email : Info@aarentalbh.com<br>
                Kingdom of Bahrain
            </span>
        </td>
        <td width="34%" align="center" style="vertical-align: middle;">
            ' . (!empty($logo_base64) ? '<img src="@' . $logo_base64 . '" width="115">' : '<b>AA CAR RENTAL</b>') . '
        </td>
        <td width="33%" align="right" style="vertical-align: top; font-family:dejavusans;">
            <b style="font-size:12.5pt; color:#cc0000;">اي اي لتأجير السيارات ذ.م.م.</b><br>
            <span style="font-size:8pt; line-height: 1.3;">
                هاتف: ١٧٣٠٠٣٢٢ ٩٧٣+<br>
                فاكس: ١٧٣٠٠٣١١ ٩٧٣+<br>
                البريد الإلكتروني: info@aarentalbh.com<br>
                مملكة البحرين
            </span>
        </td>
    </tr>
</table>

<hr style="height: 1.5px; color: #000; margin-top: 3px; margin-bottom: 5px;">

<div class="text-center bold" style="font-size: 13pt; letter-spacing: 1.5px; margin-bottom: 8px;">CASH MEMO</div>

<!-- METADATA BOXES (Flat Table for Perfect Left-Right Alignment) -->
<table cellpadding="4" style="border: 1px solid #000; width: 100%; border-collapse: collapse; margin: 0px;">
    <tr>
        <td width="18%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Agreement No.</td>
        <td width="30%" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['agreement_no']) . '</td>
        <td width="17%" align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم الاتفاقية</td>
        <td width="35%" rowspan="4" style="vertical-align: top; padding: 8px; line-height: 1.4;">
            <span style="font-size: 9.5pt;"><b>Date :</b> ' . htmlspecialchars($data['date']) . '</span><br><br><br>
            <span style="font-size: 10pt; font-weight: bold;">No.</span> 
            <span style="color:#d32f2f; font-size:15pt; font-weight:bold; font-family:courier;">' . htmlspecialchars($data['receipt_no']) . '</span>
        </td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Car No.</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['car_no']) . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">رقم السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;">Type of Car</td>
        <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['type_of_car']) . '</td>
        <td align="right" style="border-right: 1px solid #000; border-bottom: 1px solid #000; vertical-align: middle; font-family:dejavusans; font-size: 7.5pt;">نوع السيارة</td>
    </tr>
    <tr>
        <td style="border-right: 1px solid #000; vertical-align: middle;">Colour</td>
        <td style="border-right: 1px solid #000; vertical-align: middle;" class="bold">' . htmlspecialchars($data['colour']) . '</td>
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
        <tr style="background-color:#2a2a2a; color:#ffffff; font-weight:bold;">
            <th width="7%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">المسلسل<br>S.No.</th>
            <th width="53%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">التفاصيل<br>Description</th>
            <th width="10%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">الكمية<br>Qty.</th>
            <th width="15%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">المبلغ<br>Price</th>
            <th width="15%" class="text-center" style="font-size: 7.5pt; font-family:dejavusans;">المجموع<br>Total</th>
        </tr>
    </thead>
    <tbody>';

foreach ($items as $item) {
    $sno = $item['sno'] !== '' ? $item['sno'] : '';
    $desc = $item['description'] !== '' ? htmlspecialchars($item['description']) : '';
    $qty = $item['qty'] !== '' ? $item['qty'] : '';
    $price = $item['price'] !== '' ? (is_numeric($item['price']) ? number_format($item['price'], 3) : $item['price']) : '';
    $total = $item['total'] !== '' ? (is_numeric($item['total']) ? number_format($item['total'], 3) : $item['total']) : '';

    $html .= '
        <tr height="25">
            <td width="7%" class="text-center" height="23">' . $sno . '</td>
            <td width="53%" class="bold">' . $desc . '</td>
            <td width="10%" class="text-center">' . $qty . '</td>
            <td width="15%" class="text-right bold">' . $price . '</td>
            <td width="15%" class="text-right bold">' . $total . '</td>
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
        <td width="61%" style="border: 1px solid #000; padding: 6px;" valign="middle">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0px; padding: 0px;">
                <tr>
                    <td width="15%" valign="middle" style="line-height: 1.5; font-weight: bold;">Note:</td>
                    <td width="70%" valign="middle" style="font-size: 8pt; line-height: 1.4; text-align: left;">' . htmlspecialchars($data['note']) . '</td>
                    <td width="15%" align="right" valign="middle" style="font-family:dejavusans; font-size: 7.5pt; line-height: 1.5;">ملاحظات:</td>
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
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Total Amount / المجموع</span>
                    </td>
                    <td width="45%" style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['total_amount'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Discount / التخفيض</span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['discount'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Net Amount / الصافي</span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['net_amount'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; border-bottom: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Paid / المدفوع</span>
                    </td>
                    <td style="border-bottom: 1px solid #000; line-height: 1.5;" valign="middle" align="right" class="bold">
                        ' . number_format($data['paid'], 3) . '
                    </td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid #000; background-color: #f5f5f5; line-height: 1.5;" valign="middle" align="center">
                        <span style="font-family:dejavusans; font-size: 7.5pt;">Balance / المتبقي</span>
                    </td>
                    <td style="line-height: 1.5; color: #d32f2f;" valign="middle" align="right" class="bold">
                        ' . number_format($data['balance'], 3) . '
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
        <td style="border: 1px solid #cc0000; padding: 0px;" align="center" valign="middle">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 0px; padding: 0px;">
                <tr><td height="12" style="font-size: 1px; line-height: 1px;">&nbsp;</td></tr>
                <tr>
                    <td align="center">
                        <span style="color:#cc0000; font-family:dejavusans; font-size:9.5pt; font-weight:bold; line-height:1.4;">ملاحظة: المبلغ المدفوع لا يسترجع في حالة الإلغاء</span><br>
                        <span style="color:#cc0000; font-family:dejavusans; font-size:8.5pt; font-weight:normal; line-height:1.4;">The amount paid not get back in the event of cancellation</span>
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
<table cellpadding="5" style="border: 1px solid #000; width: 100%;">
    <tr>
        <td width="50%" align="center" style="border-right: 1px solid #000;">
            <br><br><br>
            ________________________________________<br>
            <span style="font-family:dejavusans; font-size: 8pt; font-weight: bold;">عن اي اي لتأجير السيارات ذ.م.م.</span><br>
            <span style="font-size: 8.5pt; font-weight: bold; color: #cc0000;">For AA CAR RENTAL</span>
        </td>
        <td width="50%" align="center" style="vertical-align: bottom;">
            <br><br><br>
            ________________________________________<br>
            <span style="font-size: 9.5pt; font-weight: bold; font-family:dejavusans;">Customer Acceptance / قبول الزبون</span>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('CashMemo_' . $data['receipt_no'] . '.pdf', 'I');
