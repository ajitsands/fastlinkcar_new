<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);
error_reporting(0);

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
$invoice_no = $params['invoice_no'] ?? '';

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

$data = null;
if (!$sample_mode && !empty($invoice_no)) {
    // Attempt to fetch from tbl_tax_invoices. Users will fill this mapping query later.
    $stmt = $mysqli->prepare("SELECT * FROM tbl_tax_invoices WHERE invoice_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $invoice_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
}

// Load elegant sample data if not found or in sample mode
if (!$data) {
    $data = [
        'customer_name' => $params['customer_name'] ?? 'M/S. ABC COMPANY CO. W.L.L',
        'customer_address' => $params['address'] ?? 'Building 120, Road 43, Block 343, Seef District, Bahrain',
        'trn' => $params['trn'] ?? '1002939281',
        'invoice_date' => $params['invoice_date'] ?? '24-05-26',
        'due_date' => $params['due_date'] ?? '24-05-26',
        'invoice_no' => $params['invoice_no'] ?? 'AA/2026/PO/0000',
        'lpo_no' => $params['lpo_no'] ?? 'LPO-829391',
        'items' => json_encode([
            [
                'no' => 1,
                'car_type' => 'Toyota Camry',
                'agreement_no' => 'AGR-2026-92',
                'vehicle_no' => '328129',
                'service' => 'RENTAL WITHOUT DRIVER',
                'period_from' => '23-05-26',
                'period_to' => '22-06-26',
                'qty' => 1,
                'unit_price' => 150.000,
                'amount_excl' => 150.000,
                'vat_percent' => 10,
                'vat_amount' => 15.000,
                'amount_incl' => 165.000
            ],
            [
                'no' => 2,
                'car_type' => 'Nissan Sunny',
                'agreement_no' => 'AGR-2026-93',
                'vehicle_no' => '482910',
                'service' => 'RENTAL WITH DRIVER',
                'period_from' => '23-05-26',
                'period_to' => '28-05-26',
                'qty' => 1,
                'unit_price' => 20.000,
                'amount_excl' => 20.000,
                'vat_percent' => 10,
                'vat_amount' => 2.000,
                'amount_incl' => 22.000
            ]
        ]),
        'total_excl' => 170.000,
        'total_vat' => 17.000,
        'total_incl' => 187.000
    ];
}

// Parse Items JSON
$items = is_string($data['items']) ? json_decode($data['items'], true) : $data['items'];
if (!is_array($items)) {
    $items = [];
}

// Pad items table to maintain layout height exactly like physical invoice
while (count($items) < 5) {
    $items[] = [
        'no' => '',
        'car_type' => '',
        'agreement_no' => '',
        'vehicle_no' => '',
        'service' => '',
        'period_from' => '',
        'period_to' => '',
        'qty' => '',
        'unit_price' => '',
        'amount_excl' => '',
        'vat_percent' => '',
        'vat_amount' => '',
        'amount_incl' => ''
    ];
}

// Initialize TCPDF
class AA_TaxInvoice_PDF extends TCPDF {
    // Custom thin headers and footers for precise control
    public function Header() {}
    public function Footer() {}
}

$pdf = new AA_TaxInvoice_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Tax Invoice ' . $data['invoice_no']);

// Set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Set font to DejaVuSans for dual English/Arabic support
$pdf->SetFont('dejavusans', '', 8);

// Prepare Logo & Print Settings Data
require_once __DIR__ . '/print_settings_helper.php';
$printSettings = getPrintSettings($mysqli ?? null, $data['company_id'] ?? null);
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$logo_width = (int)($printSettings['logo_width'] ?? 155);
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';

$html = '
<style>
    table { width: 100%; border-collapse: collapse; }
    td, th { vertical-align: middle; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .bold { font-weight: bold; }
    .bg-dark { background-color: ' . $printAccent . '; color: #ffffff; }
    .bordered td, .bordered th { border: 1px solid #000; }
    .payment-table { border: 1px solid ' . $printAccent . '; }
    .payment-table td { border-bottom: 1px solid #d0d0d0; }
</style>

<!-- MAIN HEADER -->
<table cellpadding="2" border="0" width="100%">
    <tr>
        <td width="55%" style="vertical-align: middle;">
            ' . (!empty($logo_base64) ? '<img src="@' . $logo_base64 . '" width="' . $logo_width . '">' : '<b style="font-size: 16pt; color:' . $printAccent . ';">' . htmlspecialchars(strtoupper($printSettings['company_name'] ?? 'FAST LINK')) . '</b>') . '
        </td>
        <td width="45%" align="right" style="vertical-align: top; font-size: 8.5pt; line-height: 1.4;">
            <b style="color:' . $printAccent . ';">' . htmlspecialchars(strtoupper($printSettings['company_name'] ?? 'FAST LINK')) . '</b><br>
            ' . (!empty($printSettings['header_address']) ? nl2br(htmlspecialchars($printSettings['header_address'])) . '<br>' : '') . '
            ' . (!empty($printSettings['header_phone']) ? 'Tel: ' . htmlspecialchars($printSettings['header_phone']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_email']) ? htmlspecialchars($printSettings['header_email']) . '<br>' : '') . '
            ' . (!empty($printSettings['header_subtitle']) ? '<span class="bold">' . htmlspecialchars($printSettings['header_subtitle']) . '</span>' : '') . '
        </td>
    </tr>
</table>

<br>

<!-- TAX INVOICE BANNER -->
<table cellpadding="6" width="100%">
    <tr class="bg-dark">
        <td class="text-center bold" style="font-size: 12pt; letter-spacing: 1.5px;">TAX INVOICE</td>
    </tr>
</table>

<br>

<!-- CLIENT AND INVOICE METADATA -->
<table cellpadding="3" border="0" width="100%">
    <tr>
        <!-- Client details -->
        <td width="60%" style="vertical-align: top; line-height: 1.4;">
            <span class="bold" style="font-size: 9.5pt;">M/S. ' . htmlspecialchars($data['customer_name']) . '</span><br>
            ' . htmlspecialchars($data['customer_address']) . '<br>
            <span class="bold">KINGDOM OF BAHRAIN</span><br>
            <span class="bold">TRN: ' . htmlspecialchars($data['trn']) . '</span>
        </td>
        <!-- Invoice metadata -->
        <td width="40%" style="vertical-align: top; line-height: 1.4; padding-left: 20px;">
            <table cellpadding="1" border="0" width="100%">
                <tr>
                    <td width="45%" class="bold">Inv Date:</td>
                    <td width="55%" class="text-right">' . htmlspecialchars($data['invoice_date']) . '</td>
                </tr>
                <tr>
                    <td class="bold">Due Date:</td>
                    <td class="text-right">' . htmlspecialchars($data['due_date']) . '</td>
                </tr>
                <tr>
                    <td class="bold">Inv No.:</td>
                    <td class="text-right bold" style="color: #1b3d94;">' . htmlspecialchars($data['invoice_no']) . '</td>
                </tr>
                <tr>
                    <td class="bold">LPO NO:</td>
                    <td class="text-right">' . htmlspecialchars($data['lpo_no']) . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<!-- MAIN TAX GRID -->
<table class="bordered" cellpadding="4.5" width="100%" style="font-size: 7.3pt;">
    <thead>
        <tr class="bg-dark text-center bold">
            <th rowspan="2" width="4%" style="border: 1px solid #ffffff;">No</th>
            <th rowspan="2" width="11%" style="border: 1px solid #ffffff;">Type of Car</th>
            <th rowspan="2" width="9%" style="border: 1px solid #ffffff;">Agreement no</th>
            <th rowspan="2" width="9%" style="border: 1px solid #ffffff;">vehicle no.</th>
            <th rowspan="2" width="12%" style="border: 1px solid #ffffff;">Service</th>
            <th colspan="2" width="14%" style="border: 1px solid #ffffff;">PERIOD</th>
            <th rowspan="2" width="4%" style="border: 1px solid #ffffff;">Qty</th>
            <th rowspan="2" width="8%" style="border: 1px solid #ffffff;">Unit Price (BHD)</th>
            <th rowspan="2" width="10%" style="border: 1px solid #ffffff;">Amount Excl of VAT (BHD)</th>
            <th rowspan="2" width="4%" style="border: 1px solid #ffffff;">VAT %</th>
            <th rowspan="2" width="6%" style="border: 1px solid #ffffff;">VAT Amount (BHD)</th>
            <th rowspan="2" width="9%" style="border: 1px solid #ffffff;">Amount Incl of VAT (BHD)</th>
        </tr>
        <tr class="bg-dark text-center bold">
            <th width="7%" style="border: 1px solid #ffffff; font-size: 6.5pt;">From</th>
            <th width="7%" style="border: 1px solid #ffffff; font-size: 6.5pt;">To</th>
        </tr>
    </thead>
    <tbody>';

foreach ($items as $item) {
    $no = $item['no'] !== '' ? $item['no'] : '';
    $car_type = $item['car_type'] !== '' ? htmlspecialchars($item['car_type']) : '';
    $agr_no = $item['agreement_no'] !== '' ? htmlspecialchars($item['agreement_no']) : '';
    $veh_no = $item['vehicle_no'] !== '' ? htmlspecialchars($item['vehicle_no']) : '';
    $srv = $item['service'] !== '' ? htmlspecialchars($item['service']) : '';
    $from = $item['period_from'] !== '' ? $item['period_from'] : '';
    $to = $item['period_to'] !== '' ? $item['period_to'] : '';
    $qty = $item['qty'] !== '' ? $item['qty'] : '';
    
    $u_price = $item['unit_price'] !== '' ? (is_numeric($item['unit_price']) ? number_format($item['unit_price'], 3) : $item['unit_price']) : '';
    $amt_excl = $item['amount_excl'] !== '' ? (is_numeric($item['amount_excl']) ? number_format($item['amount_excl'], 3) : $item['amount_excl']) : '';
    $vat_pct = $item['vat_percent'] !== '' ? ($item['vat_percent'] . '%') : '';
    $vat_amt = $item['vat_amount'] !== '' ? (is_numeric($item['vat_amount']) ? number_format($item['vat_amount'], 3) : $item['vat_amount']) : '';
    $amt_incl = $item['amount_incl'] !== '' ? (is_numeric($item['amount_incl']) ? number_format($item['amount_incl'], 3) : $item['amount_incl']) : '';

    $html .= '
        <tr height="25">
            <td width="4%" class="text-center">' . $no . '</td>
            <td width="11%" class="bold">' . $car_type . '</td>
            <td width="9%" class="text-center">' . $agr_no . '</td>
            <td width="9%" class="text-center">' . $veh_no . '</td>
            <td width="12%" class="bold" style="font-size: 6.5pt;">' . $srv . '</td>
            <td width="7%" class="text-center">' . $from . '</td>
            <td width="7%" class="text-center">' . $to . '</td>
            <td width="4%" class="text-center">' . $qty . '</td>
            <td width="8%" class="text-right bold">' . $u_price . '</td>
            <td width="10%" class="text-right bold">' . $amt_excl . '</td>
            <td width="4%" class="text-center">' . $vat_pct . '</td>
            <td width="6%" class="text-right bold">' . $vat_amt . '</td>
            <td width="9%" class="text-right bold">' . $amt_incl . '</td>
        </tr>';
}

$html .= '
        <!-- TOTAL ROW -->
        <tr class="bg-dark text-right bold" style="font-size: 8pt;">
            <td colspan="9" class="text-center" style="border: 1px solid #1b3d94; padding: 6px;">TOTAL</td>
            <td style="border: 1px solid #1b3d94;">' . number_format($data['total_excl'], 3) . '</td>
            <td style="border: 1px solid #1b3d94;" class="text-center">-</td>
            <td style="border: 1px solid #1b3d94;">' . number_format($data['total_vat'], 3) . '</td>
            <td style="border: 1px solid #1b3d94;">' . number_format($data['total_incl'], 3) . '</td>
        </tr>
    </tbody>
</table>

<br><br>

<!-- PAYMENT INFORMATION CARD -->
<table cellpadding="3" class="payment-table" style="width: 320px; border: 1px solid #0056b3;">
    <tr style="background-color: #0056b3; color: #ffffff; font-weight: bold;">
        <td colspan="2" align="center" style="font-size: 8.5pt;">PAYMENT INFORMATION</td>
    </tr>
    <tr style="background-color: #f2f6fc;">
        <td width="35%" class="bold" style="font-size: 7.5pt;">ACCOUNT NAME:</td>
        <td width="65%" style="font-size: 7.5pt;">A. A. CAR RENTAL CO W.L.L</td>
    </tr>
    <tr>
        <td class="bold" style="font-size: 7.5pt;">A/C NUMBER:</td>
        <td style="font-size: 7.5pt;">0010 578804 001</td>
    </tr>
    <tr style="background-color: #f2f6fc;">
        <td class="bold" style="font-size: 7.5pt;">BANK NAME:</td>
        <td style="font-size: 7.5pt;">AHLI UNITED BANK</td>
    </tr>
    <tr>
        <td class="bold" style="font-size: 7.5pt;">BRANCH:</td>
        <td style="font-size: 7.5pt;">SEEF DISTRICT</td>
    </tr>
    <tr style="background-color: #f2f6fc;">
        <td class="bold" style="font-size: 7.5pt;">IBAN:</td>
        <td style="font-size: 7.5pt;" class="bold">BH28AUBB00010578804001</td>
    </tr>
    <tr>
        <td class="bold" style="font-size: 7.5pt;">SWIFT CODE:</td>
        <td style="font-size: 7.5pt;">AUBBB HBM</td>
    </tr>
    <tr style="background-color: #f2f6fc;">
        <td class="bold" style="font-size: 7.5pt;">EMAIL:</td>
        <td style="font-size: 7.5pt; color: #0056b3; text-decoration: underline;">accounts@aarentalbh.com</td>
    </tr>
</table>

<br><br><br>

<!-- INVOICE FOOTER -->
<hr style="height: 1px; color: #d0d0d0; margin-bottom: 5px;">
<table cellpadding="2" border="0" width="100%" style="font-size: 8pt; text-align: center; color: #333;">
    <tr>
        <td class="bold">FAST LINK - اي اي لتأجير السيارات ذ.م.م - CR. 92201-1</td>
    </tr>
    <tr>
        <td>Tel: +973 17300322 | Fax: +973 17300311 | info@aarentalbh.com</td>
    </tr>
    <tr>
        <td class="bold" style="font-family:dejavusans;">Kingdom of Bahrain - مملكة البحرين</td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('TaxInvoice_' . $data['invoice_no'] . '.pdf', 'I');
