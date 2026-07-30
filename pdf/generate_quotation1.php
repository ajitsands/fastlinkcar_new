<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();
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
//define('ROOT_PATH', __DIR__);
//$rootPath = realpath(__DIR__ );
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
$contract_no = openssl_decrypt(
    $encrypted,
    'aes-256-cbc',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);
// Support for POST or GET parameters
//$params = !empty($_POST) ? $_POST : $_GET;

$quotation_id = $contract_no;
//$orientation = (isset($params['orientation']) && strtoupper($params['orientation']) == 'P') ? 'P' : 'L';
$orientation = 'P';
//$font_size_table = isset($params['font_size_table']) ? (float) $params['font_size_table'] : 8;
$font_size_table = 7.5;
$footer_logo_x = isset($params['footer_logo_x']) ? (float) $params['footer_logo_x'] : 15;
$footer_logo_y = isset($params['footer_logo_y']) ? (float) $params['footer_logo_y'] : -35;
$footer_logo_pg = $params['footer_logo_pg'] ?? 'last'; // 'last' or 'all'
$page_break_threshold = isset($params['page_break_threshold']) ? (float) $params['page_break_threshold'] : 30; // Reduced default to 30

$seal_last_pg = $params['seal_last_pg'] ?? 'last_center';
$seal_last_x = isset($params['seal_last_x']) ? (float) $params['seal_last_x'] : 0;
$seal_last_y = isset($params['seal_last_y']) ? (float) $params['seal_last_y'] : 0;

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

if (!$sample_mode) {
    $stmt = $mysqli->prepare("SELECT * FROM quotations WHERE id = ?");
    $stmt->bind_param("i", $quotation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    if (!$data)
        $sample_mode = true;
}

$quotation_no = $data['quotation_no'];
$quotation_date = date('d-m-Y', strtotime($data['quotation_date']));
$customer_name = $data['customer_name'];
$customer_email = $data['customer_email'];
$attention = $data['attention'] ?? '';
$introduction = !empty($data['introduction']) ? $data['introduction'] : "With reference to your inquiry regarding the rental of Vehicles, we are pleased to quote our best prices as mention below:";
$custom_notes = !empty($data['terms']) ? $data['terms'] : ($params['notes'] ?? "");
$items = json_decode($data['items'], true);
$customer_address = $data['customer_address'];

class AA_PDF extends TCPDF
{
    public $footer_logo_x;
    public $footer_logo_y;
    public $footer_logo_pg;
    public $seal_pg;

    public function Header()
    {
        $logo_jpg = 'assets/img/logo/logo.jpg';
        $logo_png = 'assets/img/logo/logo.png';
       
          if (file_exists($logo_jpg)) {
            $this->Image($logo_jpg, 15, 10, 45, 0, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        } elseif (file_exists($logo_png)) {
            if (extension_loaded('gd') || extension_loaded('imagick')) {
                $this->Image($logo_png, 15, 10, 45, 0, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }
        }
        
        $this->SetFont('helvetica', 'B', 18);
        $this->SetXY(20, 7);
        $this->Cell(0, 10, 'AA CAR RENTAL CO. W.L.L', 0, 1, 'R');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'SALMABAD- KINGDOM OF BAHRAIN', 0, 1, 'R');
    }

   public function Footer()
{
    $page_w = $this->getPageWidth();
    $page_h = $this->getPageHeight();

    /* --------------------------
       SEAL & SIGNATURE
    -------------------------- */
   $seal_file = 'assets/img/logo/seal_and_sig_clean1.png';

if (
    file_exists($seal_file) &&
    is_file($seal_file) &&
    @getimagesize($seal_file) !== false
) {

    $img_w = 35;

    $x_pos = $page_w - $img_w - 15;
    $y_pos = $page_h - 70;

    $this->Image(
        $seal_file,
        $x_pos,
        $y_pos,
        $img_w,
        0,
        'PNG',
        '',
        'T',
        false,
        300,
        '',
        false,
        false,
        0,
        false,
        false,
        false
    );

} else {

    error_log('Seal image not found or invalid: ' . $seal_file);

}

    /* --------------------------
       FOOTER LINE
    -------------------------- */
    $this->SetY(-30);

    $this->Line(
        20,
        $this->GetY(),
        $page_w - 15,
        $this->GetY()
    );

    $this->Ln(2);

   

    /* --------------------------
       CONTACT DETAILS
    -------------------------- */
    $this->SetFont('dejavusans', '', 8);

    $html = '
    <table width="100%" cellpadding="1">
        <tr>
            <td width="35%">
                <b>+973 17300311 | +973 17300322</b>
            </td>

            <td width="25%" align="center">
                <b>info@aarental.com</b>
            </td>

            <td width="40%" align="right">
                <b>Salmabad - Kingdom of Bahrain</b>
            </td>
        </tr>

        <tr>
            <td colspan="3"
                align="right"
                style="font-family:dejavusans;">
                سلماباد - مملكة البحرين
            </td>
        </tr>
    </table>';

    $this->writeHTML(
        $html,
        true,
        false,
        true,
        false,
        ''
    );

    /* --------------------------
       PAGE NUMBER
    -------------------------- */
    $this->SetY(-10);

    $this->SetFont(
        'helvetica',
        '',
        8
    );

    $this->Cell(
        0,
        5,
        'Page ' .
        $this->getAliasNumPage() .
        ' / ' .
        $this->getAliasNbPages(),
        0,
        0,
        'C'
    );
}
}

$pdf = new AA_PDF($orientation, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->footer_logo_x = $footer_logo_x;
$pdf->footer_logo_y = $footer_logo_y;
$pdf->footer_logo_pg = $footer_logo_pg;
$pdf->seal_pg = $seal_last_pg;

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Quotation ' . $quotation_no);
$pdf->SetMargins(20, 28, 15);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(25);
$pdf->SetAutoPageBreak(TRUE, $page_break_threshold);
$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// Red Bar "QUOTATION"
$pdf->setCellPaddings(1, 1, 1, 1);
$pdf->Ln(5);
$pdf->SetFillColor(237, 28, 36);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 12, 'QUOTATION', 0, 1, 'C', 1);

// Client & Metadata
$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);
$startY = $pdf->GetY();
$colWidth = ($pdf->getPageWidth() - 35) / 2;

// Left Info
// ------------------------------------
// CUSTOMER & QUOTATION HEADER
// ------------------------------------

$startY = $pdf->GetY();

$leftWidth  = 110;
$rightWidth = 65;

// ===== LEFT SECTION =====
$labelWidth = 15;
$dataWidth  = 90;

$pdf->SetFont('helvetica', 'B', 10);

// M/s
$pdf->Cell($labelWidth, 6, 'M/s.', 0, 0);
$pdf->SetFont('helvetica', 'B', 11);
$pdf->Cell($dataWidth, 6, strtoupper($customer_name), 0, 1);

// Attn
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell($labelWidth, 6, 'Attn :', 0, 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell($dataWidth, 6, $attention, 0, 1);

// Email
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell($labelWidth, 6, 'Email:', 0, 0);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell($dataWidth, 6, $customer_email, 0, 1);

// Address
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell($labelWidth, 6, 'Addr :', 0, 0);

$pdf->SetFont('helvetica', '', 9);

$x = $pdf->GetX();
$y = $pdf->GetY();

$pdf->MultiCell(
    $dataWidth,
    5,
    $customer_address,
    0,
    'L',
    false,
    1,
    $x,
    $y,
    true
);

// ===== RIGHT SECTION =====
$pdf->SetXY(130, $startY);

$pdf->SetFont('helvetica', 'B', 10);

$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(25, 6, 'Date', 0, 0, 'R');

$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(5, 6, ':', 0, 0, 'C');

$pdf->Cell(35, 6, $quotation_date, 0, 1, 'L');

$pdf->SetX(130);

$pdf->SetTextColor(0, 0, 255);
$pdf->Cell(25, 6, 'Qtn. No', 0, 0, 'R');

$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(5, 6, ':', 0, 0, 'C');

$pdf->Cell(35, 6, $quotation_no, 0, 1, 'L');

// ===== MOVE BELOW THE TALLEST BLOCK =====
$nextY = max(
    $pdf->GetY(),
    $startY + 22
);

$pdf->SetY($nextY + 5);

// ------------------------------------
// INTRODUCTION
// ------------------------------------

$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0, 0, 0);

$pdf->writeHTML(
    $introduction,
    true,
    false,
    true,
    false,
    'L'
);

// Table scaling
$pdf->SetMargins(20, 28, 15); // left, top, right
$pdf->Ln(5);
$availWidth = 175;

$p = [
    'no'      => 4,
    'car'     => 18,
    'service' => 14,
    'period'  => 16,
    'months'  => 10,  // Duration
    'qty'     => 5,   // Qty
    'unit'    => 10,
    'excl'    => 10,
    'vat_p'   => 6,   // VAT %
    'vat_a'   => 8,   // VAT Amount
    'incl'    => 12
];
$total_p = array_sum($p);
$w = [];
foreach ($p as $k => $v) {
    $w[$k] = ($v / $total_p) * $availWidth;
}

$pdf->SetFillColor(220, 220, 220);
$pdf->SetFont('helvetica', 'B', $font_size_table);

$h_h = 20;

$pdf->MultiCell($w['no'],      $h_h, 'No',                 1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['car'],     $h_h, 'Type of Car',        1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['service'], $h_h, 'Service Type',       1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['period'],  $h_h, 'Period',             1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['months'],  $h_h, 'Duration',           1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['qty'],     $h_h, 'Qty',                1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');

$pdf->MultiCell($w['unit'],    $h_h, "Unit Price\n(BHD)",  1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['excl'],    $h_h, "Amount Excl.\nVAT",  1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');

$pdf->MultiCell($w['vat_p'],   $h_h, "VAT\n%",             1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');
$pdf->MultiCell($w['vat_a'],   $h_h, "VAT\nAmount",        1, 'C', 1, 0, '', '', true, 0, false, true, $h_h, 'M');

$pdf->MultiCell($w['incl'],    $h_h, "Amount Incl.\nVAT",  1, 'C', 1, 1, '', '', true, 0, false, true, $h_h, 'M');

$pdf->SetFont('helvetica', '', $font_size_table);
$count = 1;
$grand_total = 0;
foreach ($items as $item) {
    $qty = (float) ($item['qty'] ?? 0);
    $price = (float) ($item['price'] ?? 0);
    $vat_p = (float) ($item['vat'] ?? 0);
    $amount_excl = $qty * $price;
    $vat_amt = ($amount_excl * $vat_p) / 100;
    $amount_incl = (float) ($item['total'] ?? ($amount_excl + $vat_amt));
    $grand_total += $amount_incl;
    $dur = $item['duration'] . ' ' . $item['rate_type_id'] . ($item['duration'] > 1 ? 's' : '');
    $period =
    date('d-M-Y H:i', strtotime($item['period_from'])) .
    "\nTo\n" .
    date('d-M-Y H:i', strtotime($item['period_to']));

    $h_r = 14;
    $pdf->MultiCell($w['no'], $h_r, $count++, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['car'], $h_r, $item['item_name'] ?? '-', 1, 'L', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['service'], $h_r, $item['service_type'] ?? "Rental Without Driver", 1, 'L', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['period'], $h_r, ($period ?? "") , 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['months'], $h_r, $dur ?? 1, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['qty'], $h_r, $item['qty'] ?? 0, 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['unit'], $h_r, number_format($price, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['excl'], $h_r, number_format($amount_excl, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['vat_p'], $h_r, $vat_p . '%', 1, 'C', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['vat_a'], $h_r, number_format($vat_amt, 3), 1, 'R', 0, 0, '', '', true, 0, false, true, $h_r, 'M');
    $pdf->MultiCell($w['incl'], $h_r, number_format($amount_incl, 3), 1, 'R', 0, 1, '', '', true, 0, false, true, $h_r, 'M');
}

$pdf->SetFillColor(237, 28, 36);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 10);
$total_w_label = array_sum(array_slice(array_values($w), 0, 10));
$pdf->Cell($total_w_label, 10, 'NET TOTAL', 1, 0, 'R', 1);
$pdf->Cell($w['incl'], 10, number_format($grand_total, 3), 1, 1, 'R', 1);

// Notes section
$pdf->Ln(4);
$pdf->SetTextColor(255, 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 5, 'Note :', 0, 1);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);
$display_notes = !empty($custom_notes) ? $custom_notes : "We feel certain you will find our quotation meeting with your kind approval. If you require any further information, please feel free to contact us on 39000199";
$pdf->writeHTML($display_notes, true, false, true, false, 'L');

$total_pages = $pdf->getNumPages();
$pdf->setPage($total_pages);

// Ensure enough space remains for closing remarks
$sig_threshold = (strtoupper($orientation) == 'L') ? 25 : 40;

if ($pdf->GetY() > ($pdf->getPageHeight() - $sig_threshold)) {
    $pdf->AddPage();
}

$pdf->Ln(8);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$pdf->MultiCell(
    0,
    5,
    'Thank you for your interest in our services. We look forward to serving you.',
    0,
    'L',
    false,
    1
);

$pdf->Ln(4);

$pdf->SetFont('helvetica', 'B', 11);
$pdf->SetTextColor(220, 0, 0);

$pdf->Cell(
    0,
    6,
    'A.A. CAR RENTAL CO. W.L.L.',
    0,
    1,
    'L'
);

$pdf->SetTextColor(0, 0, 0);

$pdf->SetFont('helvetica', '', 9);

$pdf->Cell(
    0,
    5,
    'Authorized Vehicle Rental Services',
    0,
    1,
    'L'
);


while (ob_get_level()) {
    ob_end_clean();
}
$pdf->Output('Quotation_' . $quotation_no . '.pdf', 'I');
