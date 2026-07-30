<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
$invoice_no = openssl_decrypt(
    $encrypted,
    'aes-256-cbc',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);
// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;
//$invoice_no = $params['invoice_no'] ?? '';

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
    $stmt = $mysqli->prepare("SELECT * FROM invoices WHERE invoice_no = ?");
    if ($stmt) {
        $stmt->bind_param("s", $invoice_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
}


$items = is_string($data['items']) ? json_decode($data['items'], true) : $data['items'];
if (!is_array($items)) {
    $items = [];
}


// Initialize TCPDF
class AA_TaxInvoice_PDF extends TCPDF {
    // Custom thin headers and footers for precise control
    public function Header() {}
  public function Footer() {

        $this->SetY(-25); // distance from bottom

        $this->SetFont('dejavusans', '', 8);

        // Top line (instead of <hr>)
        $this->SetDrawColor(138, 28, 20); // red

        $this->Cell(0, 0, '', 'T', 1, 'C', false);
        
        // reset back to default (important!)
        $this->SetDrawColor(0, 0, 0);

        $this->Ln(2);

        // Company info (line 1)
        $this->Cell(
            0,
            5,
            'AA CAR RENTAL - اي اي لتأجير السيارات ذ.م.م - CR. 92201-1',
            0,
            1,
            'C'
        );

        // Contact line
        $this->Cell(
            0,
            5,
            'Tel: +973 17300322 | Fax: +973 17300311 | info@aarentalbh.com',
            0,
            1,
            'C'
        );

        // Bahrain line (English + Arabic)
        $this->SetFont('dejavusans', 'B', 8);
        $this->Cell(
            0,
            5,
            'Kingdom of Bahrain - مملكة البحرين',
            0,
            1,
            'C'
        );

        // Page number
       $this->SetY(-10);
        $this->SetFont('dejavusans', 'I', 8);
        
        // Right side page number
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

$pdf = new AA_TaxInvoice_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Tax Invoice ' . $data['invoice_no']);
$pdf->SetFooterMargin(25);
// Set margins
$pdf->SetMargins(8, 10, 8);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();

// Set font to DejaVuSans for dual English/Arabic support
$pdf->SetFont('dejavusans', '', 8);

// Prepare Logo Data
$logo_path = 'assets/img/logo/logo.png';
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
    .bold { font-weight: bold; }
    .bg-dark { background-color: #8A1C14; color: #ffffff; }
    .bordered td, .bordered th { border: 1px solid #000; }
    .payment-table { border: 1px solid #0056b3; }
    .payment-table td { border-bottom: 1px solid #d0d0d0; }
</style>

<!-- MAIN HEADER -->
<table cellpadding="2" border="0" width="100%">
    <tr>
        <td width="55%" style="vertical-align: middle;">
            ' . (!empty($logo_base64) ? '<img src="@' . $logo_base64 . '" width="155">' : '<b style="font-size: 16pt;">AA CAR RENTAL</b>') . '
        </td>
        <td width="45%" align="right" style="vertical-align: top; font-size: 8.5pt; line-height: 1.4;">
            Flat No. 0, Building 168, Road 408<br>
            Block 704, Salmabad, Bahrain<br>
            <span class="bold">VAT NO: 220000485100002</span>
        </td>
    </tr>
</table>

<br>

<!-- TAX INVOICE BANNER -->
<table cellpadding="1" cellspacing="0" width="100%">
    <tr class="bg-dark">
        <td class="text-center bold" style="font-size:9pt; letter-spacing:1.5px; line-height:1;">
            TAX INVOICE
        </td>
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
            <span class="bold">TRN: ' . htmlspecialchars($data['trn_no']) . '</span>
        </td>
        <!-- Invoice metadata -->
        <td width="40%" style="vertical-align: top; line-height: 1.4; padding-left: 20px;">
            <table cellpadding="1" border="0" width="100%">
                <tr>
                    <td width="45%" class="bold">Inv Date:</td>
                    <td width="55%" class="text-right">' . htmlspecialchars(date('d-m-y', strtotime($data['invoice_date']))) . '</td>
                </tr>
                <tr>
                    <td class="bold">Due Date:</td>
                    <td class="text-right">' . htmlspecialchars(date('d-m-y', strtotime($data['invoice_due_date']))) . '</td>
                </tr>
                <tr>
                    <td class="bold">Inv No.:</td>
                    <td class="text-right bold" style="color: #8A1C14;">' . htmlspecialchars($data['invoice_no']) . '</td>
                </tr>
                <tr>
                    <td class="bold">LPO NO:</td>
                    <td class="text-right">' . htmlspecialchars($data['lpo_number']) . '</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<br>

<!-- MAIN TAX GRID -->
<table class="bordered" cellpadding="4" style="font-size: 7pt; border-collapse: collapse;">

<thead>
<tr style="text-align:center; color:#0033cc; white-space:nowrap;">

    <th rowspan="1" width="4%" style=" border:1px solid #000;">No</th>
    <th rowspan="1" width="10%" style="border:1px solid #000;">Type of Car</th>
    <th rowspan="1" width="12%" style=" border:1px solid #000;">Agreement no</th>
    <th rowspan="1"  width="9%" style="border:1px solid #000;">Vehicle no</th>
    <th rowspan="1" width="12%" style=" border:1px solid #000;">Service</th>
    <th colspan="2" width="16%" style=" border:1px solid #000;">Period</th>
    <th rowspan="1" width="5%" style=" border:1px solid #000;">Qty</th>
    <th rowspan="1" width="7%" style="border:1px solid #000;">Unit Price (BHD)</th>
    <th rowspan="1" width="8%"  style="border:1px solid #000;">Excl VAT(BHD)</th>
    <th rowspan="1" width="5%" style="border:1px solid #000;">VAT %</th>
    <th rowspan="1" width="7%" style="border:1px solid #000;">VAT Amount</th>
    <th rowspan="1" width="8%" style="border:1px solid #000;">Incl VAT(BHD)</th>

</tr>
</thead>
<tbody>';

foreach ($items as $index => $item) {
    $no = $index + 1;
    $car_type = $item['model_name'] !== '' ? htmlspecialchars($item['model_name']) : '';
    $agr_no = $item['agreement_no'] !== '' ? htmlspecialchars($item['agreement_no']) : '';
    $veh_no = $item['vehicleno'] !== '' ? htmlspecialchars($item['vehicleno']) : '';
    $srv = $item['item_name'] !== '' ? htmlspecialchars($item['item_name']) : '';
    $from = $item['period_from'] !== '' ? date('d-m-y', strtotime($item['period_from'])) : '';
    $to = $item['period_to'] !== '' ? date('d-m-y', strtotime($item['period_to'])) : '';
     $qty   = is_numeric($item['qty'] ?? null) ? (float)$item['qty'] : 0;
    $u_price = is_numeric($item['price'] ?? null) ? (float)$item['price'] : 0;
    $amt_excl = '';
    $amt_excl = $qty * $u_price;
    $vat_percent = is_numeric($item['vat'] ?? null) ? (float)$item['vat'] : 0;
     
        $vat_amount  = ($amt_excl * $vat_percent) / 100;
        $amt_excl_display = number_format($amt_excl, 3);
        $vat_pct = $vat_percent . '%';
        $vat_amt = number_format($vat_amount, 3);
        $amount_incl = $amt_excl + $vat_amount;
        $amt_incl = number_format($amount_incl, 3);
    

    $html .= '
        <tr style="white-space:nowrap;">

        <td   width="4%" style="border:1px solid #000; text-align:center;">'.$no.'</td>
        <td  width="10%" style="border:1px solid #000;">'.htmlspecialchars($car_type).'</td>
        <td  width="12%" style="border:1px solid #000; text-align:center;">'.$agr_no.'</td>
        <td  width="9%" style="border:1px solid #000; text-align:center;">'.$veh_no.'</td>
        <td width="12%" style="border:1px solid #000;">'.$srv.'</td>
        <td width="8%" style="border:1px solid #000; text-align:center;">'.$from.'</td>
        <td width="8%" style="border:1px solid #000; text-align:center;">'.$to.'</td>
        <td width="5%" style="border:1px solid #000; text-align:center;">'.$qty.'</td>
        <td width="7%" style="border:1px solid #000; text-align:right;">'.number_format($u_price,3).'</td>
        <td width="8%" style="border:1px solid #000; text-align:right;">'.number_format($amt_excl,3).'</td>
        <td width="5%" style="border:1px solid #000; text-align:center;">'.$vat_percent.'%</td>
        <td width="7%" style="border:1px solid #000; text-align:right;">'.number_format($vat_amount,3).'</td>
        <td width="8%" style="border:1px solid #000; text-align:right;">'.number_format($amt_incl,3).'</td>

    </tr>';
}

$html .= '
        <!-- TOTAL ROW -->
        <tr style="font-weight:bold;" class="bg-dark">

    <td colspan="9" style="border:1px solid #000; text-align:right;">TOTAL</td>

    <td style="border:1px solid #000; text-align:right;">'.number_format((float)$data['subtotal'],3).'</td>
    <td style="border:1px solid #000; text-align:center;">-</td>
    <td style="border:1px solid #000; text-align:right;">'.number_format((float)$data['vat_total'],3).'</td>
    <td style="border:1px solid #000; text-align:right;">'.number_format((float)$data['grand_total'],3).'</td>

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

<br>

<!-- INVOICE FOOTER -->

';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('TaxInvoice_' . $data['invoice_no'] . '.pdf', 'I');
