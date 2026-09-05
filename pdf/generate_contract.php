<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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

// Load autoloader from pdf/vendor, root vendor, or envfiles
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
} elseif (file_exists(__DIR__ . '/../envfiles/vendor/autoload.php')) {
    require_once __DIR__ . '/../envfiles/vendor/autoload.php';
} elseif (file_exists('vendor/autoload.php')) {
    require_once 'vendor/autoload.php';
}

if (!class_exists('TCPDF')) {
    if (file_exists(__DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php')) {
        require_once __DIR__ . '/vendor/tecnickcom/tcpdf/tcpdf.php';
    }
}

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
//$params = !empty($_POST) ? $_POST : $_GET;

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

//echo $contract_no;
//$contract_no = $params['contract_no'] ?? '';
$view_mode = isset($params['view']) && $params['view'] == 'true';

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die("Database Connection Error");
}

$stmt = $mysqli->prepare("SELECT * FROM tbl_vehicle_rentout_contracts WHERE agreement_no = ? ");
$stmt->bind_param("s", $contract_no);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    // If not found by agreement number, fallback to ID if numeric
    if (is_numeric($contract_no)) {
        $stmt = $mysqli->prepare("SELECT * FROM tbl_vehicle_rentout_contracts WHERE ids = ?");
        $stmt->bind_param("i", $contract_no);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    }
}

if (!$data) {
    die("Contract not found.");
}

// Parse JSON fields
$customer = json_decode($data['customer_details'] ?? '{}', true);
$vehicle = json_decode($data['vechile_details'] ?? '{}', true);
$contract_details = json_decode($data['contract_details_json'] ?? '{}', true);
$accessories = json_decode($data['vehicle_accessories_details'] ?? '{}', true);
$driver = json_decode($data['driver_details'] ?? '{}', true);

class AA_Contract_PDF extends TCPDF {
   public function Header()
{
    $pageWidth = $this->getPageWidth();

    /* --------------------------
       COMPANY LOGO
    -------------------------- */
    $logo_jpg = file_exists('assets/img/logo/logo.jpg') ? 'assets/img/logo/logo.jpg' : dirname(__DIR__) . '/assets/img/logo/logo.jpg';
    $logo_png = file_exists('assets/img/logo/logo.png') ? 'assets/img/logo/logo.png' : dirname(__DIR__) . '/assets/img/logo/logo.png';

    if (file_exists($logo_jpg)) {
        $this->Image($logo_jpg, 15, 6, 48, 0, 'JPG');
    } elseif (file_exists($logo_png)) {
        $this->Image($logo_png, 15, 6, 48, 0, 'PNG');
    }

    /* --------------------------
       COMPANY NAME
    -------------------------- */
    $this->SetTextColor(0, 0, 0);

    $this->SetFont('helvetica', 'B', 18);
    $this->SetXY(0, 10);
    $this->Cell($pageWidth, 7, 'AA CAR RENTAL CO. W.L.L.', 0, 1, 'C');

    $this->SetFont('helvetica', '', 9);
    $this->SetXY(0, 18);
    $this->Cell($pageWidth, 5, 'Salmabad, Kingdom of Bahrain', 0, 1, 'C');

    /* --------------------------
       CONTACT DETAILS
    -------------------------- */
    $this->SetFont('helvetica', '', 8);

    $rightX = $pageWidth - 65;

    $this->SetXY($rightX, 8);
    $this->Cell(50, 4, 'Tel : +973 17300322', 0, 1, 'R');

    $this->SetX($rightX);
    $this->Cell(50, 4, 'Fax : +973 17300311', 0, 1, 'R');

    $this->SetX($rightX);
    $this->Cell(50, 4, 'info@aarentalbh.com', 0, 1, 'R');

    /* --------------------------
       HEADER DIVIDER
    -------------------------- */
    $this->SetDrawColor(180, 180, 180);
    $this->SetLineWidth(0.4);
    $this->Line(15, 32, $pageWidth - 15, 32);
}

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C');
    }
}

$pdf = new AA_Contract_PDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Contract ' . $data['agreement_no']);
$pdf->SetMargins(15, 40, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 9);

// Construct HTML Table for Contract
// Construct HTML Table for Contract mimicking the physical image layout
$html = '
<style>
    table { width: 100%; border-collapse: collapse; font-family: dejavusans; font-size: 8pt; }
    .bordered-table td { border: 1px solid #000; padding: 3px; }
    .no-border { border: none; }
    .label { color: #d32f2f; font-weight: bold; }
    .bg-gray { background-color: #e0e0e0; font-weight: bold; text-align: center; }
</style>

<table class="no-border" cellpadding="2" width="100%">
    <tr>
        <!-- Left Block -->
        <td class="no-border" width="30%" valign="top">
           

            <b>Date:</b><span >
            ' . htmlspecialchars(
                !empty($data['agreement_date'])
                    ? date('d-M-Y', strtotime($data['agreement_date']))
                    : date('d-M-Y')
            ) . '</span>
        </td>

        <!-- Center Block -->
        <td class="no-border" width="40%" align="center" valign="middle">
            <b style="font-size:14pt; color:#d32f2f;">
                اتفاقية استئجار سيارة
            </b><br/>
            <b style="font-size:11pt; color:#d32f2f;">
                CAR HIRE AGREEMENT
            </b>
        </td>

        <!-- Right Block -->
        <td class="no-border" width="30%" valign="top" align="right">
            <table class="no-border" cellpadding="2" align="right">
                <tr>
                    <td class="no-border" align="right">
                        <b>No:</b>
                        <span style="color:#d32f2f; font-size:11pt;">
                            ' . htmlspecialchars($data['agreement_no']) . '
                        </span>
                    </td>
                </tr>

               
            </table>
        </td>
    </tr>
</table>

<br/>

<table class="bordered-table" cellpadding="3" width="100%">
    <tr>
        <td width="15%" class="label"><b>Name / الإسم</b></td>
        <td width="85%" colspan="5">
            ' . htmlspecialchars($data['customer_name'] ?? '') . '
        </td>
    </tr>

    <tr>
        <td width="15%" class="label"><b>Work Address</b></td>
        <td width="85%" colspan="5">
            ' . htmlspecialchars($customer['customer_address'] ?? '') . '
        </td>
    </tr>

    <tr>
        <td width="15%" class="label"><b>Mob No / النقال</b></td>
        <td width="35%">
            ' . htmlspecialchars($customer['customer_mobile'] ?? '') . '
        </td>

        <td width="15%" class="label"><b>Email</b></td>

        <td width="35%" colspan="3">
            ' . htmlspecialchars($customer['customer_email'] ?? '') . '
        </td>
    </tr>
</table>
<br>

<table class="no-border" cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <!-- LEFT COLUMN: Rates and Financials -->
        <td width="48%" class="no-border" style="padding:0; margin:0;"><table class="bordered-table" cellpadding="3" border="0" width="100%">
                <tr class="bg-gray">
                    <td width="20%">Extra</td>
                    <td width="20%">Yearly</td>
                    <td width="20%">Monthly</td>
                    <td width="20%">Weekly</td>
                    <td width="20%">Daily</td>
                </tr>
                <tr>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">-</td>
                    <td align="center">' . htmlspecialchars($contract_details['unit_price'] ?? '0') . '</td>
                </tr>
                <tr>
                    <td colspan="2" class="bg-gray">Extend Date<br>فترة التمديد</td>
                    <td colspan="3" class="bg-gray">Lease Period<br>فترة التأجير</td>
                </tr>
                <tr>
                    <td colspan="2" align="center">-</td>
                    <td colspan="3" align="center">' . htmlspecialchars(date('d-M-Y H:i', strtotime($contract_details['period_from'] ?? ''))) . ' to ' . htmlspecialchars(date('d-M-Y H:i', strtotime($contract_details['period_to'] ?? ''))) . '</td>
                </tr>
                <tr>
                    <td colspan="2" class="bg-gray">Return Date<br>تاريخ الإعادة</td>
                    <td colspan="3" class="bg-gray">Payment Received<br>المبلغ المستلم</td>
                </tr>
                <tr>
                    <td colspan="2" align="center" height="20">' . htmlspecialchars(!empty($data['return_date']) ? date('d-m-Y', strtotime($data['return_date'])) : '') . '</td>
                    <td colspan="3" align="center"></td>
                </tr>
                <tr>
                    <td colspan="2" class="bg-gray">Damages Cost<br>قيمة التلفيات</td>
                    <td colspan="3" class="bg-gray">Balance Payment<br>المبلغ المتبقي</td>
                </tr>
                <tr>
                    <td colspan="2" align="center" height="20"></td>
                    <td colspan="3" align="center"></td>
                </tr>
                <tr>
                    <td colspan="2" class="label">Total Paid</td>
                    <td colspan="3">' . htmlspecialchars($contract_details['total_amt'] ?? '0') . ' BHD</td>
                </tr>
                <tr>
                    <td colspan="2" class="label">Deposit</td>
                    <td colspan="3"></td>
                </tr>
                <tr class="bg-gray">
                    <td colspan="2">Luxury</td>
                    <td colspan="2">Medium</td>
                    <td colspan="1">Small</td>
                </tr>
                <tr>
                    <td colspan="2" align="center" height="20"></td>
                    <td colspan="2" align="center"></td>
                    <td colspan="1" align="center">' . (strpos(strtoupper($vehicle['category_name'] ?? ''), 'SMALL') !== false ? 'X' : '') . '</td>
                </tr>
            </table>
        </td>
        
        <!-- RIGHT COLUMN: Vehicle and Driver -->
        <td width="52%" class="no-border" style="padding:0; margin:0;"><table class="bordered-table" cellpadding="3" border="0" width="100%">
                <tr>
                    <td width="35%" class="label">Drivers License No</td>
                    <td width="65%">' . htmlspecialchars($driver['driver_license_no'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Issue Place</td>
                    <td>' . htmlspecialchars($driver['driver_license_issplace'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Issue Date</td>
                    <td>' . htmlspecialchars(!empty($driver['driver_license_issdate']) ? date('d-m-Y', strtotime($driver['driver_license_issdate'])) : '') . '</td>
                </tr>
                <tr>
                    <td class="label">Expiry Date</td>
                    <td>' . htmlspecialchars(!empty($driver['driver_license_expdate']) ? date('d-m-Y', strtotime($driver['driver_license_expdate'])) : '') . '</td>
                </tr>
                <tr>
                    <td class="label">Other Driver</td>
                    <td>' . htmlspecialchars($data['customer_driver_name'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Type of Car</td>
                    <td>' . htmlspecialchars($vehicle['category_name'] ?? '') . ' - ' . htmlspecialchars($vehicle['model_name'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Car No</td>
                    <td>' . htmlspecialchars($vehicle['veh_no'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Colour</td>
                    <td>' . htmlspecialchars($vehicle['vehicle_color'] ?? '') . '</td>
                </tr>
                <tr>
                    <td class="label">Date/Time Out</td>
                    <td>' . htmlspecialchars(date('d-m-Y h:i A', strtotime($contract_details['period_from'] ?? ''))) . '</td>
                </tr>
                <tr>
                    <td class="label">Date/Time In</td>
                    <td>' . htmlspecialchars(date('d-m-Y h:i A', strtotime($contract_details['period_to'] ?? ''))) . '</td>
                </tr>
               <tr>
                <td class="label">Km. Out</td>
                <td>' . (int)($data['km_out'] ?? 0) . '</td>
            </tr>
            <tr>
                <td class="label">Km. In</td>
                <td>' . (int)($data['km_in'] ?? 0) . '</td>
            </tr>
            <tr>
                <td class="label">Km. Used</td>
                <td>' . (int)($data['km_used'] ?? 0) . '</td>
            </tr>
            </table>
        </td>
    </tr>
</table>
<br>

<table class="bordered-table" cellpadding="4">
    <tr>
        <td style="background-color: #d32f2f; color: #fff; text-align:right; font-weight:bold; font-size: 9pt;">
            * يحسب مبلغ دينارين للسيارة الصغيرة وأربعة دنانير للسيارة الكبيرة في حالة رجوع السيارة غير نظيفة.<br>
            * يحق للمكتب سحب السيارة فوراً وإنهاء عقد الإيجار ومطالبة المستأجر قانونياً بسداد الإيجار والغرامات والتلفيات إن وجدت في الحالات الآتية:<br>
            1. عدم سداد المبلغ المستحق خلال يومين من الاستئجار.<br>
            2. سوء استخدام السيارة في الطريق العام طبقاً لرؤية المسؤولين في المؤسسة أو رجال شرطة الأمن العام.<br>
            3. في حالة سحب السيارة أو رجوع السيارة للمؤسسة غير مسؤولة عن أي ممتلكات داخل السيارة.
        </td>
    </tr>
</table>
<br>

<table class="bordered-table" cellpadding="3">
    <tr>
        <td width="60%">
            <span class="label">Remarks / الملاحظات:</span><br>
            ' . htmlspecialchars($data['remarks1'] ?? '') . '<br><br><br><br><br>
        </td>
        <td width="40%" style="padding:0; margin:0;"><table class="no-border" cellpadding="3" width="100%">
                <tr>
                    <td width="50%" style="border-bottom:1px solid #000; border-right:1px solid #000;">Jack & Tools : <b>' . htmlspecialchars($accessories['chk_tools'] ?? 'No') . '</b></td>
                    <td width="50%" style="border-bottom:1px solid #000;">Spare Tyre : <b>' . htmlspecialchars($accessories['chk_spare'] ?? 'No') . '</b></td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000; border-right:1px solid #000;">Radio : <b>' . htmlspecialchars($accessories['chk_radio'] ?? 'No') . '</b></td>
                    <td style="border-bottom:1px solid #000;">CD Recorder : <b>' . htmlspecialchars($accessories['chk_radio'] ?? 'No') . '</b></td>
                </tr>
                <tr>
                    <td colspan="2">Petrol Level (1/4, 1/2, 3/4, Full): <br><br></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br><br><br>
';
$received_sig_img = '<br><br><br>';
if (!empty($data['receiver_signature'])) {
   //$hirer_path = ROOT_PATH . '/' . ltrim($data['hirer_signature'], '/');
    $received_path = ltrim($data['receiver_signature'], '/');
    if (file_exists($received_path)) {
        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $img_data = base64_encode(file_get_contents($received_path));
            $received_sig_img = '<br><img src="@' . $img_data . '" width="120" height="40"><br>';
        } else {
            $received_sig_img = '<br><span style="color:blue; font-size:6pt;">[Needs GD]</span><br>';
        }
    }
}
$received_name = !empty($data['receiver_name']) ? $data['receiver_name'] : '';
$received_date = !empty($data['receiver_signature_datetime']) ? date('d-m-Y h:i A', strtotime($data['receiver_signature_datetime'])) : '';
$received_info = ($received_name || $received_date) ? '<br><span style="font-size:7pt; color:#000;">Name: ' . htmlspecialchars($received_name) . '<br>Date: ' . htmlspecialchars($received_date) . '</span>' : '';

$hirer_sig_img = '<br><br><br>';
if (!empty($data['hirer_signature'])) {
   //$hirer_path = ROOT_PATH . '/' . ltrim($data['hirer_signature'], '/');
    $hirer_path = ltrim($data['hirer_signature'], '/');
    if (file_exists($hirer_path)) {
        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $img_data = base64_encode(file_get_contents($hirer_path));
            $hirer_sig_img = '<br><img src="@' . $img_data . '" width="120" height="40"><br>';
        } else {
            $hirer_sig_img = '<br><span style="color:blue; font-size:6pt;">[Needs GD]</span><br>';
        }
    }
}
$hirer_name = !empty($data['hirer_name']) ? $data['hirer_name'] : '';
$hirer_date = !empty($data['hirer_signature_date']) ? date('d-m-Y h:i A', strtotime($data['hirer_signature_date'])) : '';
$hirer_info = ($hirer_name || $hirer_date) ? '<br><span style="font-size:7pt; color:#000;">Name: ' . htmlspecialchars($hirer_name) . '<br>Date: ' . htmlspecialchars($hirer_date) . '</span>' : '';

$delivered_sig_img = '<br><br><br>';
if (!empty($data['delivered_signature'])) {
   // $delivered_path = ROOT_PATH . '/../' . ltrim($data['delivered_signature'], '/');
     $delivered_path = ltrim($data['delivered_signature'], '/');
    if (file_exists($delivered_path)) {
        if (extension_loaded('gd') || extension_loaded('imagick')) {
            $img_data = base64_encode(file_get_contents($delivered_path));
            $delivered_sig_img = '<br><img src="@' . $img_data . '" width="120" height="40"><br>';
        } else {
            $delivered_sig_img = '<br><span style="color:blue; font-size:6pt;">[Needs GD]</span><br>';
        }
    }
}
$delivered_name = !empty($data['delivered_signatory']) ? $data['delivered_signatory'] : '';
$delivered_date = !empty($data['delivered_signature_date']) ? date('d-m-Y h:i A', strtotime($data['delivered_signature_date'])) : '';
$delivered_info = ($delivered_name || $delivered_date) ? '<br><span style="font-size:7pt; color:#000;">Name: ' . htmlspecialchars($delivered_name) . '<br>Date: ' . htmlspecialchars($delivered_date) . '</span>' : '';

$html .= '
<table class="no-border" cellpadding="4">
    <tr>
        <td width="33%" align="center" class="no-border">' . $received_sig_img . '_________________________<br><b style="color:#d32f2f;">Received By</b>' . $received_info . '</td>
        <td width="33%" align="center" class="no-border">' . $hirer_sig_img . '_________________________<br><b style="color:#d32f2f;">Hirer Signature</b>' . $hirer_info . '<br><span style="font-size:7pt; color:#d32f2f;">I Agree on the terms & conditions over leaf</span></td>
        <td width="33%" align="center" class="no-border">' . $delivered_sig_img . '_________________________<br><b style="color:#d32f2f;">Delivered By</b>' . $delivered_info . '</td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Terms and Conditions
$pdf->AddPage();
$pdf->SetFont('dejavusans', 'B', 12);
$pdf->Cell(0, 10, 'Terms and Conditions / الشروط والأحكام', 0, 1, 'C');
$pdf->SetFont('dejavusans', '', 9);

$terms = $data['terms_condition'] ?? '1. The hirer agrees to return the vehicle in the same condition as received.<br>2. Fuel costs and traffic fines are the responsibility of the hirer.<br>3. In case of an accident, an official police report must be provided.';
$pdf->writeHTML($terms, true, false, true, false, '');

while (ob_get_level() > 0) {
    ob_end_clean();
}

// 3rd Page: Vehicle Images
$images_json = $data['vehicle_rentout_images'] ?? '[]';
$images_arr = json_decode($images_json, true);

if (!empty($images_arr) && is_array($images_arr)) {
    // Normalize and sort images if they are stored with numeric keys
    $normalized_images = [];
    foreach ($images_arr as $key => $val) {
        if (is_string($val)) {
            $normalized_images[$key] = $val;
        } elseif (is_array($val) && isset($val['image'])) {
            $normalized_images[$key] = $val['image'];
        } elseif (is_array($val) && isset($val['file'])) {
            $normalized_images[$key] = $val['file'];
        }
    }
    ksort($normalized_images);

    if (count($normalized_images) > 0) {
        $pdf->AddPage();
        $pdf->SetFont('dejavusans', 'B', 12);
        $pdf->Cell(0, 10, 'Vehicle Images / صور المركبة', 0, 1, 'C');
        $pdf->SetFont('dejavusans', '', 9);

        $html_images = '<table cellpadding="5" border="0" width="100%">';
        $col = 0;
        
        foreach ($normalized_images as $key => $filename) {
            if (empty($filename)) continue;
            
            // Clean up filename just in case
            $filename = basename($filename);
           // $img_path = ROOT_PATH . '/../uploads/rentvehicleImages/' . $filename;
             $img_path ='uploads/rentvehicleImages/' . $filename;
            
            if (file_exists($img_path)) {
                $img_data = base64_encode(file_get_contents($img_path));
                
                if ($col == 0) {
                    $html_images .= '<tr>';
                }
                
                $html_images .= '<td width="50%" align="center">';
                $html_images .= '<b>Image ' . htmlspecialchars($key) . '</b><br><br>';
                // Using 250 for width to ensure they fit side-by-side in portrait mode nicely
                $html_images .= '<img src="@' . $img_data . '" width="250" height="180">';
                $html_images .= '</td>';
                
                $col++;
                if ($col == 2) {
                    $html_images .= '</tr>';
                    $col = 0;
                }
            }
        }
        
        // Fill remaining cell if odd number
        if ($col == 1) {
            $html_images .= '<td width="50%"></td></tr>';
        }
        $html_images .= '</table>';
        
        $pdf->writeHTML($html_images, true, false, true, false, '');
    }
}


$safe_filename = str_replace('/', '-', $data['agreement_no']) . '.pdf';
$pdf->Output($safe_filename, 'I');
