<?php
session_start();
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
$staff_id = $data['staff_id'] ?? '';
$vehicle_id = $data['vehicle_id'] ?? '';
$company_id= $_SESSION['company_id'] ?? 1;


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
$staff_name = 'All Staffs';

if (!empty($staff_id) && $staff_id !== 'All') {

    $sqlstaff = "SELECT staff_name 
                 FROM tbl_staff 
                 WHERE ids = ? 
                 LIMIT 1";

    $stmtstaff = $mysqli->prepare($sqlstaff);

    if ($stmtstaff) {

        $stmtstaff->bind_param("i", $staff_id);
        $stmtstaff->execute();

        $resultstaff = $stmtstaff->get_result();

        if ($resultstaff && $rowstaff = $resultstaff->fetch_assoc()) {
            $staff_name = $rowstaff['staff_name'];
        }

        $stmtstaff->close();
    }
}

$vehicle_name = 'All Vehicles';

if ($vehicle_id !== 'All' && $vehicle_id !== '') {

    $sqlmodel = "SELECT model_names,vehicle_number
            FROM tbl_vehicles
            WHERE ids  = ?";

    $stmtmodel = $mysqli->prepare($sqlmodel);

    if ($stmtmodel) {
        $stmtmodel->bind_param("i", $vehicle_id);
        $stmtmodel->execute();

        $resultmodel = $stmtmodel->get_result();

        if ($rowmodel = $resultmodel->fetch_assoc()) {
            $vehicle_name = $rowmodel['vehicle_number'].' - '.$rowmodel['model_names'];
        }

        $stmtmodel->close();
    }
}

$sql = "SELECT
            r.ids,
            r.booking_no,
            r.category_name,
            r.brand_name,
            r.model_name,
            r.vehicle_id,
            r.vehicle_no,
            r.staff_ids,
            r.staff_name,
            r.book_from_date,
            r.book_to_date,
            r.notes,
            r.book_status,
            r.return_notes,
            JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.mobile')) AS mobile,
            JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.email')) AS email,
            JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.licence_no')) AS licence_no,
            JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.cpr_no')) AS cpr_no,
            JSON_UNQUOTE(JSON_EXTRACT(r.staff_details_json,'$.licence_expiry_date')) AS licence_expiry_date
        FROM tbl_vehicle_non_revenue_ticket r
        WHERE r.company_id = ?
          AND (
                r.book_from_date <= ?
                AND (
                    r.book_to_date IS NULL
                    OR r.book_to_date >= ?
                )
          )";
$params = [
    $company_id,
    $endDate . ' 23:59:59',
    $startDate . ' 00:00:00'
];

$types = "iss";
if (!empty($staff_id) && $staff_id != "All") {
    $sql .= " AND r.staff_ids = ?";
    $types .= "i";
    $params[] = $staff_id;
}

if (!empty($vehicle_id) && $vehicle_id != "All") {
    $sql .= " AND r.vehicle_id = ?";
    $types .= "i";
    $params[] = $vehicle_id;
}

$sql .= " ORDER BY r.ids ASC";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param($types, ...$params);

$stmt->execute();

$result = $stmt->get_result();

$rows = $result->fetch_all(MYSQLI_ASSOC);




// Initialize TCPDF
class AA_CashMemo_PDF extends TCPDF {
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
        'Staff Use Vehicle Report | Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(),
        0,
        0,
        'C'
    );
}

  
}

$pdf = new AA_CashMemo_PDF(
    'L',              // Landscape
    PDF_UNIT,
    'A4',             // A4 size
    true,
    'UTF-8',
    false
);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Staff Use Vehicle Report');

$pdf->SetMargins(8, 8, 8);
$pdf->SetAutoPageBreak(TRUE, 15);

$pdf->AddPage();

$pdf->SetFont('dejavusans', '', 8);
$pdf->setCellPaddings(0, 0, 0, 0);

// Prepare Logo & Print Settings Data
require_once __DIR__ . '/print_settings_helper.php';
$printSettings = getPrintSettings($mysqli ?? null);
$logo_base64 = !empty($printSettings['show_logo']) ? ($printSettings['logo_base64'] ?? '') : '';
$printAccent = $printSettings['accent_color'] ?? '#1b3d94';

$html = '';

$html .= '

<!-- Header Section -->
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>

    <!-- Company Details -->
  <td width="33%" valign="top">

    <font size="14" color="' . $printAccent . '">
        <b>' . htmlspecialchars(strtoupper($printSettings['company_name'] ?? 'FAST LINK')) . '</b>
    </font>

    <br><br>

    <table cellpadding="1" cellspacing="0" border="0" width="100%">
        <tr>
            <td width="22%"><font size="8"><b>Tel</b></font></td>
            <td width="78%"><font size="8">: ' . htmlspecialchars($printSettings['header_phone'] ?? '') . '</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Email</b></font></td>
            <td><font size="8">: ' . htmlspecialchars($printSettings['header_email'] ?? '') . '</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Address</b></font></td>
            <td><font size="8">: ' . htmlspecialchars($printSettings['header_address'] ?? 'Kingdom of Bahrain') . '</font></td>
        </tr>
        <tr>
            <td><font size="8"><b>Info</b></font></td>
            <td><font size="8">: ' . htmlspecialchars($printSettings['header_subtitle'] ?? '') . '</font></td>
        </tr>
    </table>

</td>


    <!-- Logo -->
   <td width="34%" align="center" valign="middle">

    '.(!empty($logo_base64) 
        ? '<img src="@'.$logo_base64.'" width="150" style="max-height:80px;">'
        : '<font size="12"><b>FAST LINK</b></font>'
    ).'

</td>


<td width="33%" align="center" valign="middle">

    <br><br><br>

    <font size="13">
        <b>STAFF USE VEHICLE REPORT</b>
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
        <b>Staff</b>
    </td>
    <td width="35%">
        '.htmlspecialchars($staff_name ?: 'All Staffs').'
    </td>
</tr>


<tr>
    <td bgcolor="#eeeeee">
        <b>Vehicle </b>
    </td>
    <td>
        '.htmlspecialchars($vehicle_name ?: 'All Vehicles').'
    </td>

    <td bgcolor="#eeeeee">
        <b>Total Entires</b>
    </td>
    <td>
        '.count($rows).'
    </td>
</tr>

</table>

<br>

<br>

<table border="1" cellpadding="4">
<thead>
<tr bgcolor="#1b3d94" style="color:#fff;font-weight:bold;">

    <th width="4%" align="center">#</th>

    <th width="11%" align="center">Ref. No</th>

    <th width="13%" align="center">Staff</th>

    <th width="12%" align="center">Vehicle</th>

    <th width="22%" align="center">Period</th>

    <th width="14%" align="center">Notes</th>

    <th width="16%" align="center">Return Notes</th>

    <th width="8%" align="center">Status</th>

</tr>
</thead>
<tbody>
';
$total = 0;
$sl = 1;

foreach ($rows as $row) {

    $id           = (int)($row['ids'] ?? 0);
    $booking_no   = htmlspecialchars($row['booking_no'] ?? '');
    $staff_name   = htmlspecialchars($row['staff_name'] ?? '');
    $mobile       = htmlspecialchars($row['mobile'] ?? '');
    $brand_name   = htmlspecialchars($row['brand_name'] ?? '');
    $model_name   = htmlspecialchars($row['model_name'] ?? '');
    $vehicle_no   = htmlspecialchars($row['vehicle_no'] ?? '');
    $vehicle_id   = htmlspecialchars($row['vehicle_id'] ?? '');
    $notes        = htmlspecialchars($row['notes'] ?? '');
    $return_notes = htmlspecialchars($row['return_notes'] ?? '');
    $book_status  = htmlspecialchars($row['book_status'] ?? '');

    // Status
    switch ($book_status) {
        case 'Rentout':
            $status = '<span style="color:#E67E22;font-weight:bold;">At Staff</span>';
            break;

        case 'Returned':
            $status = '<span style="color:#28A745;font-weight:bold;">Returned</span>';
            break;

        default:
            $status = '<span style="color:#6C757D;font-weight:bold;">'.$book_status.'</span>';
            break;
    }

    // Staff
    $staff_val = '
        <b>'.$staff_name.'</b><br/>
        <font color="#666666">'.$mobile.'</font>';

    // Vehicle
    $vehicle_val = '
        <b>'.$vehicle_no.'</b><br/>
        <font color="#666666">'.$brand_name.' '.$model_name.'</font>';

    // ==========================
    // Period & Duration
    // ==========================

    $from = new DateTime($row['book_from_date']);

    if (!empty($row['book_to_date'])) {

        $to = new DateTime($row['book_to_date']);

        $period =
            $from->format('d-M-Y H:i') .
            ' <b>to</b><br/>' .
            $to->format('d-M-Y H:i');

        $interval = $from->diff($to);

        $durationPrefix = '';
        $durationColor  = '#0D6EFD';

    } else {

        // Active booking
        $to = new DateTime();

       $period =
    $from->format('d-M-Y H:i') .
    ' <b>to</b> ' .
    (!empty($row['book_to_date']) 
        ? $to->format('d-M-Y H:i') 
        : '<font color="red"><b>Till Now</b></font>'
    );
        $interval = $from->diff($to);

        $durationPrefix = 'Ongoing : ';
        $durationColor  = '#E67E22';
    }

    $duration = [];

    if ($interval->days > 0) {
        $duration[] = $interval->days . ' Day' . ($interval->days > 1 ? 's' : '');
    }

    if ($interval->h > 0) {
        $duration[] = $interval->h . ' Hr' . ($interval->h > 1 ? 's' : '');
    }

    if ($interval->i > 0) {
        $duration[] = $interval->i . ' Min';
    }

    if ($interval->days == 0 && $interval->h == 0 && $interval->i == 0) {
        $duration[] = '0 Min';
    }
$period_val = '
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
    <td align="left">
        <font size="7">
            '.$from->format('d-M-Y H:i').' - '.
            (!empty($row['book_to_date']) 
                ? $to->format('d-M-Y H:i') 
                : '<font color="red"><b>Till Now</b></font>'
            ).'
        </font>
    </td>
</tr>
<tr>
    <td align="left">
        <font color="'.$durationColor.'">
            <b>'.$durationPrefix.implode(' ', $duration).'</b>
        </font>
    </td>
</tr>
</table>';

    // ==========================
    // PDF Row
    // ==========================

   $html .= '
<tr>
    <td width="4%" align="center">'.$sl++.'</td>

    <td width="11%" align="center">
        '.$booking_no.'
    </td>

    <td width="13%" align="center">
        '.$staff_val.'
    </td>

    <td width="12%" align="center">
        '.$vehicle_val.'
    </td>

    <td width="22%" >
        '.$period_val.'
    </td>

    <td width="14%">
        '.$notes.'
    </td>

    <td width="16%">
        '.$return_notes.'
    </td>

    <td width="8%" align="center">
        '.$status.'
    </td>
</tr>';
}
$html .= '
</tbody>

</table>

<br>

';



$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('Staff Use Vehicle Report - ' . $startDate.' to '.$endDate. '.pdf', 'I');
