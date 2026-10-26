<?php
session_start();
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

$token = $_GET['token'] ?? '';

if (empty($token)) {
    die('Invalid token.');
}

// Restore Base64 padding
$remainder = strlen($token) % 4;
if ($remainder) {
    $token .= str_repeat('=', 4 - $remainder);
}

// Convert URL-safe Base64 back
$combined = base64_decode(strtr($token, '-_', '+/'));

$iv_length = openssl_cipher_iv_length('aes-256-cbc');

// Extract IV
$iv = substr($combined, 0, $iv_length);

// Extract encrypted data
$encrypted = substr($combined, $iv_length);

// Decrypt JSON
$decrypted = openssl_decrypt(
    $encrypted,
    'aes-256-cbc',
    $key,
    OPENSSL_RAW_DATA,
    $iv
);

if ($decrypted === false) {
    die('Invalid or corrupted token.');
}

// Convert JSON to array
$data = json_decode($decrypted, true);

if (!is_array($data)) {
    die('Invalid token data.');
}

// Retrieve values
$startDate     = $data['startDate'] ?? '';
$endDate       = $data['endDate'] ?? '';
$customer_code = $data['customer_code'] ?? '';
$vehicle_model = $data['vehicle_model'] ?? '';
$company_id    = $data['company_id'] ?? ($_SESSION['company_id'] ?? 'all');

// Support for POST or GET parameters
$params = !empty($_POST) ? $_POST : $_GET;

// Database Connection
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sample_mode = false;
if ($mysqli->connect_error) {
    $sample_mode = true;
}

// User Company Access Privileges
$isSuperAdmin = (!empty($_SESSION['is_super_admin'])) || (($_SESSION['user_role_name'] ?? '') === 'Super Admin') || (($_SESSION['user_role_id'] ?? 0) == 3);

$allowedCompanyIds = [];
if (!empty($_SESSION['company_id'])) {
    $allowedCompanyIds[] = intval($_SESSION['company_id']);
}
if (!empty($_SESSION['company_json'])) {
    $cArr = is_string($_SESSION['company_json']) ? json_decode($_SESSION['company_json'], true) : $_SESSION['company_json'];
    if (is_array($cArr)) {
        foreach ($cArr as $c) {
            if (!empty($c['ids'])) {
                $allowedCompanyIds[] = intval($c['ids']);
            }
        }
    }
}
$allowedCompanyIds = array_values(array_unique($allowedCompanyIds));
$allowedCompanyIdsStr = !empty($allowedCompanyIds) ? implode(',', $allowedCompanyIds) : '1';

$company_display_name = 'All Companies';
$company_condition = "1=1";
$company_param = null;

if (!empty($company_id) && $company_id !== 'all' && $company_id !== 'All') {
    $reqCompId = intval($company_id);
    if ($isSuperAdmin || in_array($reqCompId, $allowedCompanyIds)) {
        $company_condition = "r.company_id = ?";
        $company_param = $reqCompId;

        $stmtComp = $mysqli->prepare("SELECT company_name FROM tbl_company WHERE ids = ? LIMIT 1");
        if ($stmtComp) {
            $stmtComp->bind_param("i", $reqCompId);
            $stmtComp->execute();
            $resComp = $stmtComp->get_result();
            if ($rowComp = $resComp->fetch_assoc()) {
                $company_display_name = $rowComp['company_name'];
            }
            $stmtComp->close();
        }
    } else {
        $company_condition = "r.company_id IN ($allowedCompanyIdsStr)";
    }
} else {
    if (!$isSuperAdmin) {
        $company_condition = "r.company_id IN ($allowedCompanyIdsStr)";
    } else {
        $company_condition = "1=1";
    }
}

$customer_name = 'All Customers';

if ($customer_code !== 'All' && $customer_code !== '') {

    $sqlcustomer = "SELECT customer_name
            FROM customer_details
            WHERE customer_id = ?
            LIMIT 1";

    $stmtcustomer = $mysqli->prepare($sqlcustomer);

    if ($stmtcustomer) {
        $stmtcustomer->bind_param("s", $customer_code);
        $stmtcustomer->execute();

        $resultcustomer = $stmtcustomer->get_result();

        if ($rowcustomer = $resultcustomer->fetch_assoc()) {
            $customer_name = $rowcustomer['customer_name'];
        }

        $stmtcustomer->close();
    }
}

$vehicle_model_name = 'All Models';

if ($vehicle_model !== 'All' && $vehicle_model !== '') {

    $sqlmodel = "SELECT model_names
            FROM tbl_vehicles
            WHERE model_id = ?
            LIMIT 1";

    $stmtmodel = $mysqli->prepare($sqlmodel);

    if ($stmtmodel) {
        $stmtmodel->bind_param("i", $vehicle_model);
        $stmtmodel->execute();

        $resultmodel = $stmtmodel->get_result();

        if ($rowmodel = $resultmodel->fetch_assoc()) {
            $vehicle_model_name = $rowmodel['model_names'];
        }

        $stmtmodel->close();
    }
}

$sql = "SELECT
            r.ids,
            r.agreement_date,
            r.agreement_no,
            r.customer_code,
            r.customer_name,
            r.vehicle_id,

            c.customer_type,
            c.customer_mobile,
            c.customer_email,
            c.customer_cr_cpr,

            r.vehicle_no,

            JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.model_name')) AS model_name,
            JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.vehicle_color')) AS vehicle_color,
            JSON_UNQUOTE(JSON_EXTRACT(r.vechile_details,'$.vehicle_year')) AS vehicle_year,

            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.duration')) AS duration,
            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.unit_price')) AS unit_price,
            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.vat')) AS vat,
            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.rate_type')) AS rate_type,
            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.service_name')) AS service_name,
            JSON_UNQUOTE(JSON_EXTRACT(r.contract_details_json,'$.total_amt')) AS total_amt,

            r.service_type,
            r.delivered_signatory,
            r.agreement_status

        FROM tbl_vehicle_rentout_contracts r

        LEFT JOIN customer_details c
               ON c.customer_id = r.customer_code

        WHERE $company_condition
          AND r.agreement_status IN ('Rentout','Extended')
          AND r.agreement_date BETWEEN ? AND ?";

$queryParams = [];
$types = "";

if ($company_param !== null) {
    $types .= "i";
    $queryParams[] = $company_param;
}

$types .= "ss";
$queryParams[] = $startDate;
$queryParams[] = $endDate;

if (!empty($customer_code) && $customer_code != "All") {
    $sql .= " AND r.customer_code = ?";
    $types .= "s";
    $queryParams[] = $customer_code;
}

if (!empty($vehicle_model) && $vehicle_model != "All") {
    $sql .= " AND r.vehicle_model_id = ?";
    $types .= "s";
    $queryParams[] = $vehicle_model;
}

$sql .= " ORDER BY r.ids ASC";

$stmt = $mysqli->prepare($sql);
$rows = [];
if ($stmt) {
    if (!empty($queryParams)) {
        $stmt->bind_param($types, ...$queryParams);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}




// Initialize TCPDF
if (!class_exists('AA_DailyRental_PDF')) {
    class AA_DailyRental_PDF extends TCPDF {
        // Overriding Header and Footer to keep the layout pixel perfect and custom
        public $company_signature = '';
        public $customer_signature = '';
        
        public function Header() {}
        public function Footer()
        {
            $this->SetY(-10);

            $this->SetFont('dejavusans','I',8);

            $this->Cell(
                0,
                5,
                'Daily Rental Report | Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(),
                0,
                0,
                'C'
            );
        }
    }
}

$pdf = new AA_DailyRental_PDF(
    'L',              // Landscape
    PDF_UNIT,
    'A4',             // A4 size
    true,
    'UTF-8',
    false
);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Daily Rental Report');

$pdf->SetMargins(8, 8, 8);
$pdf->SetAutoPageBreak(TRUE, 15);

$pdf->AddPage();

$pdf->SetFont('dejavusans', '', 8);
$pdf->setCellPaddings(0, 0, 0, 0);

// Prepare Logo Data
$logo_path = 'assets/img/logo/logo.png';
$logo_base64 = '';
if (file_exists($logo_path)) {
    $logo_base64 = base64_encode(file_get_contents($logo_path));
}

$html = '';

$html .= '

<!-- Header Section -->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>

    <!-- Company Details -->
  <td width="33%" valign="top">

    <font size="14" color="#8A1C14">
        <b>AA CAR RENTAL</b>
    </font>

    <br><br>

    <table cellpadding="1" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="22%"><font size="8"><b>Tel</b></font></td>
            <td width="78%"><font size="8">: +973 17300322</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Fax</b></font></td>
            <td><font size="8">: +973 17300311</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Email</b></font></td>
            <td><font size="8">: info@aarentalbh.com</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Address</b></font></td>
            <td><font size="8">: Kingdom of Bahrain</font></td>
        </tr>
    </table>

</td>


    <!-- Logo -->
   <td width="34%" align="center" valign="middle">

    '.(!empty($logo_base64) 
        ? '<img src="@'.$logo_base64.'" width="150" style="max-height:80px;">'
        : '<font size="12"><b>AA CAR RENTAL</b></font>'
    ).'

</td>


<td width="33%" align="center" valign="middle">

    <br><br><br>

    <font size="13">
        <b>DAILY RENTAL REPORT</b>
    </font>
    <br>

    <font size="8">
        Generated Date : '.date('d-m-Y').'
    </font>

</td>

</tr>
</table>

<br>
<br>

<!-- Report Filter Details -->
<table cellpadding="4" border="1" width="100%">

<tr>
    <td width="15%" bgcolor="#eeeeee">
        <b>Period</b>
    </td>
    <td width="35%">
        '.date('d-m-Y',strtotime($startDate)).'
        To 
        '.date('d-m-Y',strtotime($endDate)).'
    </td>

    <td width="15%" bgcolor="#eeeeee">
        <b>Company</b>
    </td>
    <td width="35%">
        '.htmlspecialchars($company_display_name).'
    </td>
</tr>


<tr>
    <td bgcolor="#eeeeee">
        <b>Customer</b>
    </td>
    <td>
        '.htmlspecialchars($customer_name ?: 'All Customers').'
    </td>

    <td bgcolor="#eeeeee">
        <b>Vehicle Model</b>
    </td>
    <td>
        '.htmlspecialchars($vehicle_model_name ?: 'All Models').'
    </td>
</tr>

<tr>
    <td bgcolor="#eeeeee">
        <b>Total Agreements</b>
    </td>
    <td>
        '.count($rows).'
    </td>
    <td bgcolor="#eeeeee">
        <b>Generated Date</b>
    </td>
    <td>
        '.date('d-m-Y H:i').'
    </td>
</tr>

</table>

<br>

<br>

<table border="1" cellpadding="4">
<thead>
<tr bgcolor="#8A1C14" style="color:#fff;font-weight:bold;">
    <th width="4%" align="center">#</th>
    <th width="14%">Customer</th>
    <th width="6%" align="center">C.Type</th>
    <th width="8%">Ag. No</th>
    <th width="7%">Reg. No</th>
    <th width="13%">Make &amp; Model</th>
    <th width="8%" align="center">Ag. Date</th>
    <th width="8%">Service</th>
    <th width="5%" align="center">Type</th>
    <th width="4%" align="center">Dur</th>
    <th width="6.5%" align="right">Rate</th>
    <th width="4%" align="center">VAT</th>
    <th width="7.5%" align="right">Amt</th>
    <th width="5%" align="center">Del.</th>
</tr>
</thead>
<tbody>
';
$total = 0;
$sl = 1;

foreach ($rows as $row) {

    $total += (float)$row['total_amt'];

    $custDetails = '<b>' . htmlspecialchars($row['customer_name'] ?: 'N/A') . '</b>';
    $meta = [];
    if (!empty($row['customer_code'])) {
        $meta[] = '#' . htmlspecialchars($row['customer_code']);
    }
    if (!empty($row['customer_mobile']) && $row['customer_mobile'] !== '-') {
        $meta[] = htmlspecialchars($row['customer_mobile']);
    }
    if (!empty($meta)) {
        $custDetails .= '<br><font size="7" color="#555555">' . implode(' | ', $meta) . '</font>';
    }
    if (!empty($row['customer_cr_cpr']) && $row['customer_cr_cpr'] !== '-' && $row['customer_cr_cpr'] !== 'N/A') {
        $custDetails .= '<br><font size="7" color="#8A1C14">CPR: ' . htmlspecialchars($row['customer_cr_cpr']) . '</font>';
    }

   $html .= '
<tr>
    <td width="4%" align="center"><nobr>'.$sl++.'</nobr></td>
    <td width="14%">'.$custDetails.'</td>
    <td width="6%" align="center">'.$row['customer_type'].'</td>
    <td width="8%">'.$row['agreement_no'].'</td>
    <td width="7%">'.$row['vehicle_no'].'</td>
    <td width="13%">'.htmlspecialchars($row['model_name']).'</td>
    <td width="8%" align="center">'.date('d-m-Y', strtotime($row['agreement_date'])).'</td>
    <td width="8%">'.htmlspecialchars($row['service_name']).'</td>
    <td width="5%" align="center">'.$row['rate_type'].'</td>
    <td width="4%" align="center">'.$row['duration'].'</td>
    <td width="6.5%" align="right">'.number_format((float)$row['unit_price'], 3).'</td>
    <td width="4%" align="center">'.$row['vat'].'%</td>
    <td width="7.5%" align="right">'.number_format((float)$row['total_amt'], 3).'</td>
    <td width="5%" align="center">'.$row['delivered_signatory'].'</td>
</tr>';
}
$html .= '
</tbody>
<tr style="font-weight:bold;">
    <td colspan="12" width="87.5%" align="right"><b>Total Amount (BD)</b></td>
    <td width="7.5%" align="right"><b>'.number_format($total,3).'</b></td>
    <td width="5%"></td>
</tr>

</table>

<br>

';



$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('Daily Rental Report - ' . $startDate.' to '.$endDate. '.pdf', 'I');
