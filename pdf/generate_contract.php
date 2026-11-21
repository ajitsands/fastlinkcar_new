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
        dirname(__DIR__) . '/.env',
        __DIR__ . '/../envfiles/.env',
        __DIR__ . '/../.env',
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
$mysqli->set_charset('utf8mb4');

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

// Fetch customer master record (for CPR, address, mobile, etc.)
$custMaster = [];
if (!empty($data['customer_code'])) {
    $stmtCust = $mysqli->prepare("SELECT * FROM customer_details WHERE customer_id = ? OR ids = ? LIMIT 1");
    if ($stmtCust) {
        $stmtCust->bind_param("ss", $data['customer_code'], $data['customer_code']);
        $stmtCust->execute();
        $resCust = $stmtCust->get_result();
        $custMaster = $resCust ? ($resCust->fetch_assoc() ?: []) : [];
    }
}

// Fetch vehicle master record (for year, color, reg no, etc.)
$vehMaster = [];
if (!empty($data['vehicle_id'])) {
    $stmtVeh = $mysqli->prepare("SELECT * FROM tbl_vehicles WHERE ids = ? LIMIT 1");
    if ($stmtVeh) {
        $stmtVeh->bind_param("i", $data['vehicle_id']);
        $stmtVeh->execute();
        $resVeh = $stmtVeh->get_result();
        $vehMaster = $resVeh ? ($resVeh->fetch_assoc() ?: []) : [];
    }
}

// Fetch ledger totals (Total Paid & Extra Charges)
$totalPaidAmt = 0.0;
$extraLedgerCharge = 0.0;
$stmtLed = $mysqli->prepare("SELECT trans_type, COALESCE(debit,0) AS debit, COALESCE(credit,0) AS credit, cheque_status FROM tbl_customer_ledger WHERE contract_ids = ?");
if ($stmtLed) {
    $cIdInt = (int)$data['ids'];
    $stmtLed->bind_param("i", $cIdInt);
    $stmtLed->execute();
    $resLed = $stmtLed->get_result();
    while ($lRow = $resLed->fetch_assoc()) {
        if (($lRow['cheque_status'] ?? '') !== 'Bounced') {
            $totalPaidAmt += (float)$lRow['credit'];
        }
        $tType = strtolower(trim($lRow['trans_type'] ?? ''));
        if (strpos($tType, 'overdue') !== false || strpos($tType, 'other fee') !== false || strpos($tType, 'violation') !== false || strpos($tType, 'fine') !== false) {
            $extraLedgerCharge += (float)$lRow['debit'];
        }
    }
}

// Fetch extension total
$extensionTotalAmt = 0.0;
$latestExtEnd = '';
$stmtExt = $mysqli->prepare("SELECT extend_end_date, extend_details FROM tbl_vehicle_contract_extensions WHERE agreement_ids = ? ORDER BY extend_end_date ASC, ids ASC");
if ($stmtExt) {
    $cIdInt = (int)$data['ids'];
    $stmtExt->bind_param("i", $cIdInt);
    $stmtExt->execute();
    $resExt = $stmtExt->get_result();
    while ($eRow = $resExt->fetch_assoc()) {
        $eDet = json_decode($eRow['extend_details'] ?? '{}', true) ?: [];
        $extensionTotalAmt += (float)($eDet['total_amt'] ?? 0);
        if (!empty($eRow['extend_end_date'])) {
            $latestExtEnd = $eRow['extend_end_date'];
        }
    }
}

require_once __DIR__ . '/print_settings_helper.php';
$printSettings = getPrintSettings($mysqli ?? null, $data['company_id'] ?? null);

class AA_Contract_PDF extends TCPDF {
    public $printSettings = [];

    public function Header()
    {
        $pageWidth = $this->getPageWidth();
        $ps = $this->printSettings;
        $accentRgb = $ps['accent_rgb'] ?? [27, 61, 148];

        // Left: Logo (if show_logo) + Company Name + Subtitle (VAT Reg No.) + Address from PrintFormatMaster
        $yLeft = 5;
        $logoPath = !empty($ps['show_logo']) ? ($ps['logo_abs_path'] ?? '') : '';
        if (!empty($ps['show_logo']) && ($logoPath === '' || !file_exists($logoPath))) {
            $fallback = dirname(__DIR__) . '/assets/img/logo_new/fastlinklogoblue.png';
            if (file_exists($fallback)) {
                $logoPath = $fallback;
            }
        }
        if (!empty($ps['show_logo']) && $logoPath !== '' && file_exists($logoPath)) {
            $this->Image($logoPath, 10, 4, 28, 0, '');
            $yLeft = max(17.5, $this->getImageRBY() + 0.8);
        }

        $this->SetTextColor($accentRgb[0], $accentRgb[1], $accentRgb[2]);
        $this->SetFont('helvetica', 'B', 8);
        $this->SetXY(10, $yLeft);
        $this->Cell(85, 3.8, strtoupper($ps['company_name'] ?? 'FAST LINK'), 0, 1, 'L');
        $yLeft += 3.8;

        if (!empty($ps['header_subtitle'])) {
            $this->SetTextColor(25, 25, 25);
            $this->SetFont('helvetica', 'BI', 7.3);
            $this->SetXY(10, $yLeft);
            $this->Cell(85, 3.5, $ps['header_subtitle'], 0, 1, 'L');
            $yLeft += 3.6;
        }
        if (!empty($ps['header_address'])) {
            $this->SetFont('helvetica', '', 7.2);
            $this->SetTextColor(40, 40, 40);
            $this->SetXY(10, $yLeft);
            $this->MultiCell(85, 3.4, $ps['header_address'], 0, 'L', false, 1);
        }

        // Center: CAR HIRE AGREEMENT in brand blue with clean underline
        $this->SetTextColor($accentRgb[0], $accentRgb[1], $accentRgb[2]);
        $this->SetFont('helvetica', 'B', 12);
        $this->SetDrawColor($accentRgb[0], $accentRgb[1], $accentRgb[2]);
        $this->SetLineWidth(0.45);
        $this->SetXY(75, 9);
        $this->Cell(60, 7, 'CAR HIRE AGREEMENT', 'B', 1, 'C');

        // Right: TEL : with stacked phone numbers + email/website + Page X of Y from PrintFormatMaster
        $this->SetTextColor(25, 25, 25);
        $this->SetFont('helvetica', '', 7.5);
        $yPos = 6;
        if (!empty($ps['header_phone'])) {
            $phones = array_values(array_filter(array_map('trim', explode(',', $ps['header_phone']))));
            $this->SetFont('helvetica', 'B', 7.5);
            $this->SetXY($pageWidth - 48, $yPos);
            $this->Cell(12, 3.6, 'TEL :', 0, 0, 'R');
            $this->SetFont('helvetica', '', 7.5);
            $phoneText = '';
            $cnt = count($phones);
            foreach ($phones as $idx => $ph) {
                $phoneText .= $ph . ($idx < $cnt - 1 ? ",\n" : '');
            }
            $this->SetXY($pageWidth - 36, $yPos);
            $this->MultiCell(26, 3.6, $phoneText, 0, 'R', false, 1);
            $yPos = $this->GetY() + 1.0;
        }
        if (!empty($ps['header_email'])) {
            $this->SetXY($pageWidth - 65, $yPos);
            $this->Cell(55, 3.4, $ps['header_email'], 0, 1, 'R');
            $yPos += 3.6;
        }
        if (!empty($ps['header_website'])) {
            $this->SetXY($pageWidth - 65, $yPos);
            $this->Cell(55, 3.4, $ps['header_website'], 0, 1, 'R');
            $yPos += 3.6;
        }
        $this->SetXY($pageWidth - 45, $yPos);
        $this->Cell(35, 3.6, 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages(), 0, 1, 'R');

        $this->SetDrawColor($accentRgb[0], $accentRgb[1], $accentRgb[2]);
        $this->SetLineWidth(0.45);
        $this->Line(10, 36.5, $pageWidth - 10, 36.5);
    }

    public function Footer() {
        $ps = $this->printSettings;
        $this->SetY(-13);
        $this->SetFont('helvetica', 'I', 7.5);
        $this->SetTextColor(90, 90, 90);
        $parts = [];
        if (!empty($ps['show_footer'])) {
            if (!empty($ps['footer_text'])) {
                $parts[] = $ps['footer_text'];
            }
            if (!empty($ps['footer_note'])) {
                $parts[] = $ps['footer_note'];
            }
        }
        $parts[] = 'Page ' . $this->getAliasNumPage() . ' of ' . $this->getAliasNbPages();
        $this->Cell(0, 8, implode('   |   ', $parts), 0, false, 'C');
    }
}

$pdf = new AA_Contract_PDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->printSettings = $printSettings;
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Contract ' . $data['agreement_no']);
$pdf->SetMargins(10, 39, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(TRUE, 14);
$pdf->AddPage('P', 'A4');
$pdf->SetFont('dejavusans', '', 8);

// Prepare values for bilingual agreement layout
$rateTypeStr   = strtoupper(trim($contract_details['rate_type'] ?? ''));
$agreeDisplay  = trim(($data['agreement_no'] ?? '') . ($rateTypeStr !== '' ? ' / ' . $rateTypeStr : ''));
$custName      = $custMaster['customer_name'] ?? ($customer['customer_name'] ?? ($data['customer_name'] ?? ''));
$custCpr       = $custMaster['customer_cr_cpr'] ?? ($customer['customer_cr_cpr'] ?? ($customer['cpr'] ?? ''));
$custAddress   = $customer['customer_address'] ?? ($custMaster['customer_address'] ?? ($custMaster['customer_addr'] ?? ''));
$custMobile    = $customer['customer_mobile'] ?? ($custMaster['customer_mobile'] ?? '');
$custNation    = !empty($custMaster['nationality']) ? $custMaster['nationality'] : ($customer['nationality'] ?? 'Bahrain');
$licNo         = !empty($driver['driver_license_no']) ? $driver['driver_license_no'] : (!empty($custMaster['license_no']) ? $custMaster['license_no'] : ($customer['license_no'] ?? $custCpr));
$licExpiry     = !empty($driver['driver_license_expdate']) ? date('d-m-Y', strtotime($driver['driver_license_expdate'])) : (!empty($custMaster['license_expiry_date']) ? date('d-m-Y', strtotime($custMaster['license_expiry_date'])) : (!empty($custMaster['cpr_expiry_date']) ? date('d-m-Y', strtotime($custMaster['cpr_expiry_date'])) : '-'));
$licIssuePlace = !empty($driver['driver_license_issplace']) ? $driver['driver_license_issplace'] : (!empty($custMaster['license_issue_place']) ? $custMaster['license_issue_place'] : ($customer['license_issue_place'] ?? 'Bahrain'));

$carModelCat   = trim(($vehicle['model_name'] ?? ($vehMaster['model_names'] ?? '')) . (!empty($vehicle['category_name']) ? ' - ' . $vehicle['category_name'] : ''));
$carYear       = $vehicle['vehicle_year'] ?? ($vehMaster['vehicle_year'] ?? '');
$carRegNo      = $vehicle['veh_no'] ?? ($data['vehicle_no'] ?? ($vehMaster['vehicle_number'] ?? ''));
$kmOutVal      = (int)($data['km_out'] ?? ($accessories['vehicle_km_out'] ?? 0));
$kmInVal       = (int)($data['km_in'] ?? ($accessories['vehicle_km_in'] ?? 0));
$kmUsedVal     = (int)($data['km_used'] ?? ($kmInVal > $kmOutVal ? ($kmInVal - $kmOutVal) : 0));
$fuelVal       = trim((string)($accessories['fuel_level'] ?? ''));
$returnFuelVal = trim((string)($accessories['return_fuel_level'] ?? ''));
$fuelDisplay   = $fuelVal !== '' ? (is_numeric($fuelVal) ? $fuelVal . '%' : ucfirst($fuelVal)) : '-';
if ($returnFuelVal !== '') {
    $fuelDisplay .= '  |  IN: ' . (is_numeric($returnFuelVal) ? $returnFuelVal . '%' : ucfirst($returnFuelVal));
}

$startRaw      = $data['service_start_date_time'] ?? ($contract_details['period_from'] ?? '');
$endRaw        = !empty($latestExtEnd) ? $latestExtEnd : ($data['service_end_date_time'] ?? ($contract_details['period_to'] ?? ''));
$receivedDate  = !empty($startRaw) ? date('d-M-Y', strtotime($startRaw)) : '-';
$timeOut       = !empty($startRaw) ? date('H:i', strtotime($startRaw)) : '-';
$returnDtStr   = !empty($endRaw) ? date('d-M-Y   H:i', strtotime($endRaw)) : '-';
$rentPeriod    = trim(($contract_details['duration'] ?? '') . ($rateTypeStr !== '' ? ' ' . ucfirst(strtolower($rateTypeStr)) : ''));
$depositAmt    = (float)($contract_details['refundable_deposit'] ?? 0);

// Financials
$durationNum   = (float)($contract_details['duration'] ?? 0);
$unitPriceNum  = (float)($contract_details['unit_price'] ?? 0);
$vatPct        = (float)($contract_details['vat'] ?? 0);
$baseTotalAmt  = (float)($contract_details['total_amt'] ?? 0);
$rentAmt       = ($durationNum > 0 && $unitPriceNum > 0) ? round($durationNum * $unitPriceNum, 3) : round($baseTotalAmt / (1 + ($vatPct / 100)), 3);
$vatAmt        = round($baseTotalAmt - $rentAmt, 3);
if ($vatAmt < 0) $vatAmt = 0.0;
$extraOtherChg = round($extensionTotalAmt + $extraLedgerCharge, 3);
$grandTotal    = round($rentAmt + $vatAmt + $extraOtherChg, 3);
$balanceAmt    = round($grandTotal - $totalPaidAmt, 3);

$hirer_sig_img = '';
if (!empty($data['hirer_signature'])) {
    $hirer_rel = ltrim($data['hirer_signature'], '/');
    $hirer_path = file_exists($hirer_rel) ? $hirer_rel : (dirname(__DIR__) . '/' . $hirer_rel);
    if (file_exists($hirer_path) && (extension_loaded('gd') || extension_loaded('imagick'))) {
        $img_data = base64_encode(file_get_contents($hirer_path));
        $hirer_sig_img = '<img src="@' . $img_data . '" width="100" height="32">';
    }
}
$renterNameDisp = !empty($data['hirer_name']) ? $data['hirer_name'] : $custName;

$html = '
<style>
    table.agr-table { width: 100%; border-collapse: collapse; font-family: dejavusans; font-size: 8.2pt; border: 0.75px solid #1b3d94; }
    table.agr-table td { border-left: 0.6px solid #cbd5e1; border-right: 0.6px solid #cbd5e1; border-top: none; border-bottom: 0.25px solid #e2e8f0; padding: 3.3px 7px; }
    table.agr-table tr.sec-top td { border-top: 0.75px solid #1b3d94; }
    table.agr-table tr.sec-bot td { border-bottom: 0.75px solid #1b3d94; }
    .lbl-en { width: 28%; color: #1e293b; }
    .val-mid { width: 44%; text-align: center; color: #000000; }
    .lbl-ar { width: 28%; text-align: right; color: #1e293b; }
    .cond-hdr { background-color: #eef2ff; color: #1b3d94; font-weight: bold; border-top: 0.75px solid #1b3d94; border-bottom: 0.75px solid #1b3d94; padding: 4px 7px; }
    .ql-align-right { text-align: right; }
    .ql-align-center { text-align: center; }
    .ql-align-justify { text-align: justify; }
    .tc-box p { margin: 0 0 3px 0; }
</style>

<table class="agr-table">
    <tr class="sec-top">
        <td class="lbl-en"><b>Agreement No.</b></td>
        <td class="val-mid"><b>' . htmlspecialchars($agreeDisplay) . '</b></td>
        <td class="lbl-ar"><b>رقم الاتفاقية</b></td>
    </tr>
    <tr>
        <td class="lbl-en">Customer Name</td>
        <td class="val-mid"><b>' . htmlspecialchars(strtoupper($custName)) . '</b></td>
        <td class="lbl-ar">الإسم</td>
    </tr>
    <tr>
        <td class="lbl-en">CPR.</td>
        <td class="val-mid">' . htmlspecialchars($custCpr) . '</td>
        <td class="lbl-ar">الرقم الشخصي</td>
    </tr>
    <tr>
        <td class="lbl-en">Address</td>
        <td class="val-mid">' . htmlspecialchars(strtoupper($custAddress)) . '</td>
        <td class="lbl-ar">العنوان</td>
    </tr>
    <tr>
        <td class="lbl-en">Mobile No.</td>
        <td class="val-mid">' . htmlspecialchars($custMobile !== '' ? 'M : ' . $custMobile : '-') . '</td>
        <td class="lbl-ar">أرقام الاتصال</td>
    </tr>
    <tr>
        <td class="lbl-en">Nationality</td>
        <td class="val-mid">' . htmlspecialchars($custNation) . '</td>
        <td class="lbl-ar">الجنسية</td>
    </tr>
    <tr>
        <td class="lbl-en">License No.</td>
        <td class="val-mid">' . htmlspecialchars($licNo) . '</td>
        <td class="lbl-ar">رقم الرخصة</td>
    </tr>
    <tr>
        <td class="lbl-en">Validity of License</td>
        <td class="val-mid">' . htmlspecialchars($licExpiry) . '</td>
        <td class="lbl-ar">تاريخ انتهاء الرخصة</td>
    </tr>
    <tr>
        <td class="lbl-en">Issue Place</td>
        <td class="val-mid">' . htmlspecialchars($licIssuePlace) . '</td>
        <td class="lbl-ar">مكان الإصدار</td>
    </tr>
    <tr class="sec-top">
        <td class="lbl-en">Car</td>
        <td class="val-mid"><b>' . htmlspecialchars(strtoupper($carModelCat)) . '</b></td>
        <td class="lbl-ar">نوع المركبة</td>
    </tr>
    <tr>
        <td class="lbl-en">Model</td>
        <td class="val-mid">' . htmlspecialchars($carYear) . '</td>
        <td class="lbl-ar">الطراز</td>
    </tr>
    <tr>
        <td class="lbl-en">Reg. No.</td>
        <td class="val-mid"><b>' . htmlspecialchars($carRegNo) . '</b></td>
        <td class="lbl-ar">رقم المركبة</td>
    </tr>
    <tr>
        <td class="lbl-en">KM</td>
        <td class="val-mid">' . number_format($kmOutVal) . '</td>
        <td class="lbl-ar">الكيلومتر</td>
    </tr>
    <tr>
        <td class="lbl-en">Fuel Level</td>
        <td class="val-mid">' . htmlspecialchars($fuelDisplay) . '</td>
        <td class="lbl-ar">نسبة الوقود</td>
    </tr>
    <tr class="sec-top">
        <td class="lbl-en">Received Date</td>
        <td class="val-mid">' . htmlspecialchars($receivedDate) . '</td>
        <td class="lbl-ar">تاريخ الاستلام</td>
    </tr>
    <tr>
        <td class="lbl-en">Time Out</td>
        <td class="val-mid">' . htmlspecialchars($timeOut) . '</td>
        <td class="lbl-ar">الوقت</td>
    </tr>
    <tr>
        <td class="lbl-en">Mileage Out</td>
        <td class="val-mid">' . number_format($kmOutVal) . '</td>
        <td class="lbl-ar">الكيلومتر عند التسليم</td>
    </tr>
    <tr>
        <td class="lbl-en">Rent Period</td>
        <td class="val-mid">' . htmlspecialchars($rentPeriod) . '</td>
        <td class="lbl-ar">مدة الإيجار</td>
    </tr>
    <tr>
        <td class="lbl-en">Agreed Return Date &amp; Time</td>
        <td class="val-mid">' . htmlspecialchars($returnDtStr) . '</td>
        <td class="lbl-ar">تاريخ إرجاع المركبة</td>
    </tr>
    <tr>
        <td class="lbl-en">Refundable Deposit</td>
        <td class="val-mid">' . number_format($depositAmt, 3) . '</td>
        <td class="lbl-ar">الوديعة المسترجعة</td>
    </tr>
    <tr>
        <td class="lbl-en">Mileage In</td>
        <td class="val-mid">' . ($kmInVal > 0 ? number_format($kmInVal) : '-') . '</td>
        <td class="lbl-ar">الكيلومتر عند الاستلام</td>
    </tr>
    <tr>
        <td class="lbl-en">Total Mileage</td>
        <td class="val-mid"><b>' . ($kmUsedVal > 0 ? number_format($kmUsedVal) : '-') . '</b></td>
        <td class="lbl-ar">اجمالي الكيلومتر</td>
    </tr>
    <tr>
        <td colspan="3" class="cond-hdr">Conditions :</td>
    </tr>
    <tr>
        <td class="lbl-en">Limit of KM Per Day</td>
        <td class="val-mid">100 KM</td>
        <td class="lbl-ar">الحد الأقصى للكيلومترات في اليوم</td>
    </tr>
    <tr>
        <td class="lbl-en">Exceeding KM Every 500 KM</td>
        <td class="val-mid">BD 16.500/-</td>
        <td class="lbl-ar">تعدي الكيلومتر لكل 500 كم</td>
    </tr>
    <tr>
        <td class="lbl-en">Less Fuel</td>
        <td class="val-mid">BD 5/-</td>
        <td class="lbl-ar">إرجاع السيارة بدون وقود</td>
    </tr>
    <tr>
        <td class="lbl-en">Deductible</td>
        <td class="val-mid">BD 200/-</td>
        <td class="lbl-ar">مبلغ التحمل</td>
    </tr>
    <tr>
        <td class="lbl-en">Deductible under 25 year</td>
        <td class="val-mid">BD 500/-</td>
        <td class="lbl-ar">مبلغ التحمل لعمر أقل من 25 سنة</td>
    </tr>
    <tr>
        <td class="lbl-en">Deductible under 2 years driving Exp</td>
        <td class="val-mid">BD 500/-</td>
        <td class="lbl-ar">مبلغ التحمل لخبرة السياقة أقل من سنتين</td>
    </tr>
    <tr class="sec-bot">
        <td class="lbl-en">Rent for Extra days</td>
        <td class="val-mid">BD ' . number_format($unitPriceNum, 3) . '/- For Day</td>
        <td class="lbl-ar">مبلغ إيجار الأيام الإضافية</td>
    </tr>
</table>
';

$rawContractTerms = trim((string)($data['terms_condition'] ?? ''));
$plainTermsCheck  = trim(strip_tags(str_replace('&nbsp;', ' ', $rawContractTerms)));
$useDefaultTerms  = ($plainTermsCheck === '' || strpos($rawContractTerms, '????') !== false);

if ($useDefaultTerms) {
    $termsRowsHtml = '
    <tr>
        <td align="right" style="line-height: 1.50;">
            1 - لا يحق للمستأجر تسليم السيارة لشخص آخر لاستعمالها دون موافقة الشركة.<br>
            2 - لا يسمح بالتدخين بداخل السيارة وإذا خالف المستأجر هذا الشرط يتحمل مبلغ وقدره 15 دينار.<br>
            3 - يتوجب على المستأجر فحص السيارة قبل استلامها والتأكد من وجود جميع الأجهزة واللوازم الخاصة بالمركبة وفي حال ضياعها أو تلفها يلتزم المستأجر بدفع قيمتها.<br>
            4 - يتعهد المستأجر بإشعار إدارة المرور في حال وقوع حادث للمركبة.<br>
            5 - يتحمل المستأجر مبلغ 9 دينار لكل يوم طيلة توقف المركبة عن العمل بسبب حادث تسبب فيه أو تلف للسيارة.<br>
            6 - في حال تخلف المستأجر عن دفع الأجار لمدة 7 أيام من التاريخ المتفق عليه للدفع أو مخالفة أحد شروط هذا العقد يحق للشركة سحب السيارة أينما كانت وبدون إخطار مسبق للمستأجر ولا تتحمل الشركة فقدان المقتنيات الشخصية والأموال المتعلقة بالمستأجر.
        </td>
    </tr>
    <tr>
        <td align="left" style="line-height: 1.50; border-top: 0.5px solid #cbd5e1;">
            1 The renter shall not deliver the car to someone else to use without the company approval.<br>
            2 SMOKING is not permitted inside the car and if the renter violates this condition shall bear an amount of 15 BD.<br>
            3 The renter should check the car before the receipt and make sure all the equipment and supplies it is in the car and in case of loss or damage to the equipment or supplies the renter shall pay for the loss.<br>
            4 The renter undertakes to notify the traffic management in the event of an accident.<br>
            5 The renter shall bear the amount of 9 BD per day throughout the vehicle stopped working because of an accident or damage to the car.<br>
            6 In the event that the renter fails to pay the agreed rent within 7 days, or violate the terms and conditions of the agreement the leasing company may withdraw the vehicle without notice to the renter, and the company are not liable for any collectibles or money inside the vehicle.
        </td>
    </tr>';
} else {
    // Split on <hr> so bilingual or sectioned terms get clean row dividers in TCPDF
    $tcSections = preg_split('/<hr\s*\/?>/i', $rawContractTerms);
    $termsRowsHtml = '';
    foreach ($tcSections as $idx => $secHtml) {
        $secHtml = trim($secHtml);
        if ($secHtml === '') continue;
        $topBorder = ($idx > 0) ? ' border-top: 0.5px solid #cbd5e1;' : '';
        $alignAttr = (stripos($secHtml, 'dir="rtl"') !== false || stripos($secHtml, 'text-align:right') !== false || stripos($secHtml, 'text-align: right') !== false) ? ' align="right"' : '';
        $termsRowsHtml .= '<tr><td class="tc-box"' . $alignAttr . ' style="line-height: 1.50;' . $topBorder . '">' . $secHtml . '</td></tr>';
    }
}

$html .= '
<table width="100%" cellpadding="5" style="border: 0.75px solid #1b3d94; border-top: none; font-family: dejavusans; font-size: 7.5pt;">
    ' . $termsRowsHtml . '
</table>

<table width="100%" cellpadding="3" style="font-family: dejavusans; font-size: 8.2pt; margin-top: 8px;">
    <tr>
        <td width="58%" valign="bottom">
            <b>Renter:</b> &nbsp; ' . htmlspecialchars($renterNameDisp) . '
        </td>
        <td width="42%">
            <table width="100%" cellpadding="2.5" style="font-size: 8.2pt;">
                <tr>
                    <td width="55%"><b>Rent Amount</b></td>
                    <td width="45%" align="right">' . number_format($rentAmt, 3) . '</td>
                </tr>
                <tr>
                    <td><b>VAT Amount</b></td>
                    <td align="right">' . number_format($vatAmt, 3) . '</td>
                </tr>
                <tr>
                    <td><b>Extra Other Charge</b></td>
                    <td align="right">' . number_format($extraOtherChg, 3) . '</td>
                </tr>
                <tr>
                    <td><b>Total Paid</b></td>
                    <td align="right">' . number_format($totalPaidAmt, 3) . '</td>
                </tr>
                <tr>
                    <td style="border-top: 0.8px solid #000; border-bottom: 1.2px solid #000;"><b>Balance Amount</b></td>
                    <td align="right" style="border-top: 0.8px solid #000; border-bottom: 1.2px solid #000;"><b>' . number_format($balanceAmt, 3) . '</b></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="padding-top: 4px;">
            <table width="100%" cellpadding="2" style="border-top: 0.7px solid #222;">
                <tr>
                    <td width="30%" valign="middle"><b>Renter Signature</b></td>
                    <td width="40%" align="center">' . $hirer_sig_img . '</td>
                    <td width="30%" align="right" valign="middle"><b>التوقيع</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Page 2: CAR SURVEY / فحص المركبة (matching flagr.pdf Page 2)
$pdf->AddPage('P', 'A4');

$surveyY = 39;
$pdf->SetTextColor(27, 61, 148);
$pdf->SetFont('dejavusans', 'B', 8.5);
$pdf->SetXY(10, $surveyY);
$pdf->Cell(28, 5, 'Agreement No.', 0, 0, 'L');
$pdf->SetTextColor(15, 15, 15);
$pdf->Cell(42, 5, $data['agreement_no'] ?? '', 0, 0, 'L');

$pdf->SetTextColor(27, 61, 148);
$pdf->SetFont('dejavusans', 'B', 9.5);
$pdf->SetXY(75, $surveyY);
$pdf->Cell(60, 5, 'CAR SURVEY', 0, 1, 'C');
$pdf->SetFont('dejavusans', '', 9);
$pdf->SetXY(75, $surveyY + 4.5);
$pdf->Cell(60, 5, 'فحص المركبة', 'B', 1, 'C');
$pdf->SetTextColor(15, 15, 15);

// Car Survey Diagram Box (IN left, OUT right)
$boxTop = 48;
$boxH   = 68;
$pdf->SetDrawColor(30, 30, 30);
$pdf->SetLineWidth(0.35);
$pdf->Rect(10, $boxTop, 190, $boxH);

// Helper to draw clean top-down car inspection diagram
$drawCarDiagram = function($pdf, $cx, $cy, $title, $marks = []) {
    $pdf->SetFont('dejavusans', 'B', 8);
    $pdf->SetXY($cx - 42, $cy - 32);
    $pdf->Cell(84, 5, $title, 0, 0, 'C');

    // Car outer body
    $pdf->SetDrawColor(40, 40, 40);
    $pdf->SetLineWidth(0.3);
    $pdf->RoundedRect($cx - 40, $cy - 20, 80, 40, 8, '1111', 'D');
    // Hood
    $pdf->RoundedRect($cx - 34, $cy - 14, 18, 28, 3, '1111', 'D');
    // Windshield
    $pdf->Rect($cx - 14, $cy - 14, 7, 28, 'D');
    // Roof
    $pdf->Rect($cx - 5, $cy - 13, 18, 26, 'D');
    // Rear Window
    $pdf->Rect($cx + 15, $cy - 14, 7, 28, 'D');
    // Trunk
    $pdf->RoundedRect($cx + 24, $cy - 14, 12, 28, 3, '1111', 'D');
    // Doors (top & bottom)
    $pdf->Rect($cx - 10, $cy - 20, 12, 5, 'D');
    $pdf->Rect($cx + 4, $cy - 20, 12, 5, 'D');
    $pdf->Rect($cx - 10, $cy + 15, 12, 5, 'D');
    $pdf->Rect($cx + 4, $cy + 15, 12, 5, 'D');

    // 4 Wheel Caps (black circles)
    $pdf->SetFillColor(20, 20, 20);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('dejavusans', 'B', 5.5);
    foreach ([[-24, -22], [22, -22], [-24, 22], [22, 22]] as $w) {
        $pdf->Circle($cx + $w[0], $cy + $w[1], 4.2, 0, 360, 'F');
        $pdf->SetXY($cx + $w[0] - 4, $cy + $w[1] - 2.2);
        $pdf->Cell(8, 4, 'CAP', 0, 0, 'C');
    }

    // Labels
    $pdf->SetTextColor(20, 20, 20);
    $pdf->SetFont('dejavusans', '', 5.8);
    $pdf->SetXY($cx - 34, $cy - 4);
    $pdf->MultiCell(18, 3.8, "غطاء المحرك\nHOOD", 0, 'C', false, 0);
    $pdf->SetXY($cx - 5, $cy - 4);
    $pdf->MultiCell(18, 3.8, "سقف\nROOF", 0, 'C', false, 0);
    $pdf->SetXY($cx + 24, $cy - 3);
    $pdf->Cell(12, 6, 'TRUNK', 0, 0, 'C');
    $pdf->SetFont('dejavusans', '', 5.2);
    $pdf->SetXY($cx - 11, $cy - 20);
    $pdf->Cell(14, 5, 'DOOR باب', 0, 0, 'C');
    $pdf->SetXY($cx + 3, $cy - 20);
    $pdf->Cell(14, 5, 'DOOR باب', 0, 0, 'C');
    $pdf->SetXY($cx - 11, $cy + 15);
    $pdf->Cell(14, 5, 'DOOR باب', 0, 0, 'C');
    $pdf->SetXY($cx + 3, $cy + 15);
    $pdf->Cell(14, 5, 'DOOR باب', 0, 0, 'C');

    // Draw saved damage/scratch survey marks in crisp red
    if (!empty($marks) && is_array($marks)) {
        $pdf->SetDrawColor(220, 38, 38);
        $pdf->SetLineWidth(0.75);
        foreach ($marks as $m) {
            if (!is_array($m)) continue;
            $type = $m['type'] ?? '';
            if ($type === 'x' && isset($m['nx'], $m['ny'])) {
                $mx = $cx + ((float)$m['nx']) * 40.0;
                $my = $cy + ((float)$m['ny']) * 20.0;
                $pdf->Line($mx - 1.8, $my - 1.8, $mx + 1.8, $my + 1.8);
                $pdf->Line($mx + 1.8, $my - 1.8, $mx - 1.8, $my + 1.8);
            } elseif ($type === 'line' && !empty($m['pts']) && is_array($m['pts'])) {
                $pts = $m['pts'];
                for ($i = 1; $i < count($pts); $i++) {
                    if (!isset($pts[$i - 1]['nx'], $pts[$i - 1]['ny'], $pts[$i]['nx'], $pts[$i]['ny'])) continue;
                    $x1 = $cx + ((float)$pts[$i - 1]['nx']) * 40.0;
                    $y1 = $cy + ((float)$pts[$i - 1]['ny']) * 20.0;
                    $x2 = $cx + ((float)$pts[$i]['nx']) * 40.0;
                    $y2 = $cy + ((float)$pts[$i]['ny']) * 20.0;
                    $pdf->Line($x1, $y1, $x2, $y2);
                }
            }
        }
        $pdf->SetDrawColor(30, 30, 30);
        $pdf->SetLineWidth(0.3);
    }
};

$surveyInMarks  = (isset($accessories['car_survey_in']) && is_array($accessories['car_survey_in'])) ? $accessories['car_survey_in'] : [];
$surveyOutMarks = (isset($accessories['car_survey_out']) && is_array($accessories['car_survey_out'])) ? $accessories['car_survey_out'] : [];
$drawCarDiagram($pdf, 58, $boxTop + 37, 'إستلام من الزبون IN', $surveyInMarks);
$drawCarDiagram($pdf, 152, $boxTop + 37, 'تسليم للزبون OUT', $surveyOutMarks);

// Checklist + Fuel Gauge Row
$chkTop = $boxTop + $boxH + 4;
$chkItems = ['Tools Kit', 'S. Wheel', 'W. Cup', 'Radio', 'Scratches Mark X', 'Seats Cleanness'];
$isChkYes = function($val) {
    if ($val === true || $val === 1 || $val === '1') return true;
    return in_array(strtolower(trim((string)$val)), ['yes', 'true', '1', 'on'], true);
};
$returnLog = json_decode($data['return_log_json'] ?? '{}', true) ?: [];
$retChkLog = (isset($returnLog['return_checklist']) && is_array($returnLog['return_checklist'])) ? $returnLog['return_checklist'] : [];

$outChecked = [
    'Tools Kit'        => $isChkYes($accessories['chk_tools'] ?? ''),
    'S. Wheel'         => $isChkYes($accessories['chk_spare'] ?? ''),
    'W. Cup'           => $isChkYes($accessories['chk_wcup'] ?? ''),
    'Radio'            => $isChkYes($accessories['chk_radio'] ?? ''),
    'Scratches Mark X' => $isChkYes($accessories['chk_scratches'] ?? ''),
    'Seats Cleanness'  => $isChkYes($accessories['chk_seats'] ?? ''),
];
$inChecked = [
    'Tools Kit'        => $isChkYes($accessories['ret_chk_tools'] ?? ($retChkLog['ret_chk_tools'] ?? '')),
    'S. Wheel'         => $isChkYes($accessories['ret_chk_spare'] ?? ($retChkLog['ret_chk_spare'] ?? '')),
    'W. Cup'           => $isChkYes($accessories['ret_chk_wcup'] ?? ($retChkLog['ret_chk_wcup'] ?? '')),
    'Radio'            => $isChkYes($accessories['ret_chk_radio'] ?? ($retChkLog['ret_chk_radio'] ?? '')),
    'Scratches Mark X' => $isChkYes($accessories['ret_chk_scratches'] ?? ($retChkLog['ret_chk_scratches'] ?? '')),
    'Seats Cleanness'  => $isChkYes($accessories['ret_chk_seats'] ?? ($retChkLog['ret_chk_seats'] ?? '')),
];

$drawChecklist = function($pdf, $x, $y, $title, $items, $checkedMap = []) {
    $pdf->SetFont('dejavusans', 'B', 7.5);
    $pdf->SetTextColor(20, 20, 20);
    $pdf->SetXY($x, $y);
    $pdf->Cell(58, 5, $title, 0, 1, 'C');
    $curY = $y + 6;
    $pdf->SetFont('dejavusans', 'B', 7);
    foreach ($items as $item) {
        $isChecked = !empty($checkedMap[$item]);
        $pdf->SetDrawColor(30, 30, 30);
        $pdf->SetLineWidth(0.25);
        $pdf->Rect($x, $curY, 54, 6.2, 'D');
        $pdf->SetXY($x, $curY + 0.6);
        $pdf->Cell(54, 5, $item, 0, 0, 'C');
        // Circle on right
        $cx = $x + 59.5;
        $cy = $curY + 3.1;
        if ($isChecked) {
            $pdf->SetFillColor(27, 61, 148);
            $pdf->SetDrawColor(27, 61, 148);
            $pdf->Circle($cx, $cy, 2.8, 0, 360, 'DF');
            // Crisp thick white vector checkmark
            $pdf->SetDrawColor(255, 255, 255);
            $pdf->SetLineWidth(0.75);
            $pdf->Line($cx - 1.3, $cy + 0.1, $cx - 0.3, $cy + 1.2);
            $pdf->Line($cx - 0.3, $cy + 1.2, $cx + 1.5, $cy - 1.1);
            $pdf->SetLineWidth(0.25);
            $pdf->SetDrawColor(30, 30, 30);
        } else {
            $pdf->SetDrawColor(30, 30, 30);
            $pdf->Circle($cx, $cy, 2.7, 0, 360, 'D');
        }
        $curY += 6.2;
    }
};

$drawChecklist($pdf, 14, $chkTop, 'إستلام من الزبون IN', $chkItems, $inChecked);
$drawChecklist($pdf, 128, $chkTop, 'تسليم للزبون OUT', $chkItems, $outChecked);

// Center Fuel Gauge (reflects Return fuel if closed, otherwise Rentout fuel)
$fuelPct = 0.75;
$activeFuelRaw = strtolower(trim($returnFuelVal !== '' ? $returnFuelVal : $fuelVal));
if ($activeFuelRaw !== '') {
    if (strpos($activeFuelRaw, 'empty') !== false || $activeFuelRaw === 'e' || $activeFuelRaw === '0') {
        $fuelPct = 0.0;
    } elseif (strpos($activeFuelRaw, '1/4') !== false || $activeFuelRaw === '25') {
        $fuelPct = 0.25;
    } elseif (strpos($activeFuelRaw, '1/2') !== false || $activeFuelRaw === '50') {
        $fuelPct = 0.50;
    } elseif (strpos($activeFuelRaw, '3/4') !== false || $activeFuelRaw === '75') {
        $fuelPct = 0.75;
    } elseif (strpos($activeFuelRaw, 'full') !== false || $activeFuelRaw === 'f' || $activeFuelRaw === '100') {
        $fuelPct = 1.0;
    } elseif (is_numeric(rtrim($activeFuelRaw, '%'))) {
        $fuelPct = max(0.0, min(1.0, ((float)rtrim($activeFuelRaw, '%')) / 100.0));
    }
}
$fuelCx = 101;
$fuelCy = $chkTop + 31;
$pdf->SetFont('dejavusans', 'B', 8);
$pdf->SetXY($fuelCx - 15, $chkTop + 5);
$pdf->Cell(30, 5, 'Fuel', 0, 0, 'C');
$pdf->SetDrawColor(30, 30, 30);
$pdf->SetLineWidth(0.4);
for ($deg = 15; $deg <= 165; $deg += 15) {
    $rad = deg2rad($deg);
    $x1 = $fuelCx + cos($rad) * 14;
    $y1 = $fuelCy - sin($rad) * 14;
    $x2 = $fuelCx + cos($rad) * 18;
    $y2 = $fuelCy - sin($rad) * 18;
    $pdf->Line($x1, $y1, $x2, $y2);
}
$pdf->SetFont('dejavusans', 'B', 9);
$pdf->SetXY($fuelCx - 22, $fuelCy - 2);
$pdf->Cell(8, 5, 'E', 0, 0, 'C');
$pdf->SetXY($fuelCx + 14, $fuelCy - 2);
$pdf->Cell(8, 5, 'F', 0, 0, 'C');
$pdf->SetFillColor(30, 30, 30);
$pdf->Circle($fuelCx, $fuelCy, 2.5, 0, 360, 'F');
$needleDeg = 165.0 - ($fuelPct * 150.0);
$needleRad = deg2rad($needleDeg);
$pdf->SetLineWidth(1.0);
$pdf->Line($fuelCx, $fuelCy, $fuelCx + cos($needleRad) * 13, $fuelCy - sin($needleRad) * 13);
$pdf->SetLineWidth(0.3);

// Declaration, Notes, Return Details & Rental Signature
$decY = $chkTop + 46;
$pdf->SetXY(10, $decY);
$delivered_sig_img = '';
if (!empty($data['delivered_signature'])) {
    $del_rel = ltrim($data['delivered_signature'], '/');
    $del_path = file_exists($del_rel) ? $del_rel : (dirname(__DIR__) . '/' . $del_rel);
    if (file_exists($del_path) && (extension_loaded('gd') || extension_loaded('imagick'))) {
        $img_data = base64_encode(file_get_contents($del_path));
        $delivered_sig_img = '<img src="@' . $img_data . '" width="100" height="24">';
    }
}
$noteTopText = !empty($data['remarks1']) ? $data['remarks1'] : ($contract_details['notes'] ?? ($data['remarks'] ?? ''));
$noteReturnText = !empty($data['remarks2']) ? $data['remarks2'] : ($accessories['return_note'] ?? '');

$surveyHtml = '
<table width="100%" cellpadding="2" style="font-family: dejavusans; font-size: 7.5pt;">
    <tr>
        <td align="center" style="line-height: 1.4;">
            قد فحصت السيارة مع المؤجر ووجدت الأضرار المذكورة بالأعلى فقط و إذا وجدت أضرار جديدة أكون مسئول عنها مسئولية كاملة.<br>
            <b>I surveyed the car and didn\'t find any other damages.</b>
        </td>
    </tr>
    <tr>
        <td align="right" style="padding-top: 4px; padding-bottom: 4px;">' . (!empty($hirer_sig_img) ? $hirer_sig_img . ' &nbsp;&nbsp;' : '') . '<b>التوقيع</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>
<table width="100%" cellpadding="2" style="font-family: dejavusans; font-size: 7.5pt;">
    <tr>
        <td width="50%"><b>Note</b></td>
        <td width="50%" align="right"><b>ملاحظة:</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 0.7px solid #222; height: 28px;">' . htmlspecialchars($noteTopText) . '</td>
    </tr>
</table>
<br>
<table width="100%" cellpadding="3" style="font-family: dejavusans; font-size: 7.5pt; border-collapse: collapse;">
    <tr>
        <td width="30%" style="border: 0.7px solid #222;"><b>Car Return Date &amp; Time</b></td>
        <td width="40%" align="center" style="border: 0.7px solid #222;">' . htmlspecialchars(!empty($data['return_date']) ? date('d/m/Y   H:i', strtotime($data['return_date'])) : '-') . '</td>
        <td width="30%" align="right" style="border: 0.7px solid #222;"><b>تاريخ إرجاع المركبة الوقت</b></td>
    </tr>
    <tr>
        <td style="border: 0.7px solid #222;"><b>KM In Return</b></td>
        <td align="center" style="border: 0.7px solid #222;">' . ($kmInVal > 0 ? number_format($kmInVal) : '-') . '</td>
        <td align="right" style="border: 0.7px solid #222;"><b>عدد الكيلومترات عند إرجاع المركبة</b></td>
    </tr>
</table>
<br>
<table width="100%" cellpadding="2" style="font-family: dejavusans; font-size: 7.5pt;">
    <tr>
        <td width="50%"><b>Note</b></td>
        <td width="50%" align="right"><b>ملاحظة:</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border: 0.7px solid #222; height: 28px;">' . htmlspecialchars($noteReturnText) . '</td>
    </tr>
</table>
<br>
<table width="100%" cellpadding="3" style="font-family: dejavusans; font-size: 7.5pt; border-collapse: collapse;">
    <tr>
        <td width="25%" style="border: 0.7px solid #222;"><b>Rental Signature</b></td>
        <td width="45%" align="center" style="border: 0.7px solid #222; height: 24px;">' . (!empty($delivered_sig_img) && strpos($delivered_sig_img, '<img') !== false ? $delivered_sig_img : '') . '</td>
        <td width="30%" align="right" style="border: 0.7px solid #222;"><b>توقيع المؤجر</b></td>
    </tr>
</table>
';
$pdf->writeHTML($surveyHtml, true, false, true, false, '');

while (ob_get_level() > 0) {
    ob_end_clean();
}

// Last Page: Vehicle Images (Rentout & Return)
$extractImagePaths = function($jsonStr) {
    $arr = json_decode($jsonStr ?: '[]', true);
    if (empty($arr) || !is_array($arr)) return [];
    $normalized = [];
    foreach ($arr as $key => $val) {
        if (is_string($val)) {
            $normalized[$key] = $val;
        } elseif (is_array($val) && isset($val['image'])) {
            $normalized[$key] = $val['image'];
        } elseif (is_array($val) && isset($val['file'])) {
            $normalized[$key] = $val['file'];
        }
    }
    ksort($normalized);
    $paths = [];
    foreach ($normalized as $rawFile) {
        if (empty($rawFile)) continue;
        $fname = basename($rawFile);
        $candidates = [
            'uploads/rentvehicleImages/' . $fname,
            dirname(__DIR__) . '/uploads/rentvehicleImages/' . $fname,
            dirname(__DIR__) . '/httpdocs/uploads/rentvehicleImages/' . $fname,
        ];
        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_file($cand)) {
                $paths[] = $cand;
                break;
            }
        }
    }
    return $paths;
};

$rentoutImagePaths = $extractImagePaths($data['vehicle_rentout_images'] ?? '[]');
$returnImagePaths  = $extractImagePaths($data['vehicle_return_images'] ?? '[]');

if (!empty($rentoutImagePaths) || !empty($returnImagePaths)) {
    $pdf->AddPage('P', 'A4');
    $pdf->SetTextColor(27, 61, 148);
    $pdf->SetFont('dejavusans', 'B', 12);
    $pdf->Cell(0, 8, 'Vehicle Images / صور المركبة', 0, 1, 'C');
    $pdf->Ln(2);

    $buildImageSection = function($titleEn, $titleAr, $paths) {
        if (empty($paths)) return '';
        $html = '
        <table width="100%" cellpadding="5" cellspacing="0" style="font-family: dejavusans; margin-bottom: 6px; border-collapse: collapse;">
            <tr>
                <td width="50%" align="left" style="background-color: #eef2ff; color: #1b3d94; font-size: 9pt; font-weight: bold; border-top: 0.75px solid #1b3d94; border-bottom: 0.75px solid #1b3d94;">' . htmlspecialchars($titleEn) . '</td>
                <td width="50%" align="right" style="background-color: #eef2ff; color: #1b3d94; font-size: 9pt; font-weight: bold; border-top: 0.75px solid #1b3d94; border-bottom: 0.75px solid #1b3d94;">' . htmlspecialchars($titleAr) . '</td>
            </tr>
        </table>
        <table width="100%" cellpadding="6" cellspacing="6" border="0">';

        $col = 0;
        foreach ($paths as $imgPath) {
            $rawBytes = @file_get_contents($imgPath);
            if ($rawBytes === false) continue;
            $imgData = base64_encode($rawBytes);

            if ($col === 0) {
                $html .= '<tr>';
            }
            $html .= '<td width="50%" align="center" style="border: 0.75px solid #cbd5e1; background-color: #f8fafc;">';
            $html .= '<img src="@' . $imgData . '" width="245" height="175">';
            $html .= '</td>';

            $col++;
            if ($col === 2) {
                $html .= '</tr>';
                $col = 0;
            }
        }
        if ($col === 1) {
            $html .= '<td width="50%"></td></tr>';
        }
        $html .= '</table>';
        return $html;
    };

    $htmlImages = $buildImageSection('Rentout Images', 'صور تسليم المركبة', $rentoutImagePaths);
    if (!empty($rentoutImagePaths) && !empty($returnImagePaths)) {
        $htmlImages .= '<br><br>';
    }
    $htmlImages .= $buildImageSection('Return Images', 'صور إرجاع المركبة', $returnImagePaths);

    $pdf->writeHTML($htmlImages, true, false, true, false, '');
    $pdf->SetTextColor(15, 15, 15);
}


$safe_filename = str_replace('/', '-', $data['agreement_no']) . '.pdf';
$pdf->Output($safe_filename, 'I');
