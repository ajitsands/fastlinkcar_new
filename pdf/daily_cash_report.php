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
$cm_company_condition = "1=1";
$ev_company_condition = "1=1";
$company_param = null;

if (!empty($company_id) && $company_id !== 'all' && $company_id !== 'All') {
    $reqCompId = intval($company_id);
    if ($isSuperAdmin || in_array($reqCompId, $allowedCompanyIds)) {
        $cm_company_condition = "cm.company_id = ?";
        $ev_company_condition = "ev.company_id = ?";
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
        $cm_company_condition = "cm.company_id IN ($allowedCompanyIdsStr)";
        $ev_company_condition = "ev.company_id IN ($allowedCompanyIdsStr)";
    }
} else {
    if (!$isSuperAdmin) {
        $cm_company_condition = "cm.company_id IN ($allowedCompanyIdsStr)";
        $ev_company_condition = "ev.company_id IN ($allowedCompanyIdsStr)";
    } else {
        $cm_company_condition = "1=1";
        $ev_company_condition = "1=1";
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

$sql1 = "SELECT
    cm.id,
    cm.cashmemo_date AS transaction_date,
    cm.cashmemo_no AS voucher_no,
    cm.customer_code,
    cm.customer_name,
    c.customer_type,
    c.customer_mobile,
    c.customer_email,
    c.customer_cr_cpr,
    cm.cashmemo_payment_type AS payment_type,
    JSON_UNQUOTE(JSON_EXTRACT(cm.items, '$[0].item_name')) AS item_name,
    cm.grand_total AS income,
    0.000 AS expense,
    cm.cashmemo_notes AS remarks,
    cm.vehicle_ids,
    cm.vehicle_no,
    cm.user_name,
    cm.agreement_no,
    cm.model_names,
    'Income' AS transaction_type,
    cm.cashmemo_payment_type AS payment_mode
FROM cashmemo cm
LEFT JOIN customer_details c
    ON c.customer_id = cm.customer_code
WHERE $cm_company_condition
  AND cm.cashmemo_date BETWEEN ? AND ?";

$types1 = "";
$bind1 = [];

if ($company_param !== null) {
    $types1 .= "i";
    $bind1[] = $company_param;
}
$types1 .= "ss";
$bind1[] = $startDate;
$bind1[] = $endDate;

if (!empty($customer_code) && $customer_code != 'All') {
    $sql1 .= " AND cm.customer_code = ?";
    $types1 .= "s";
    $bind1[] = $customer_code;
}

if (!empty($vehicle_model) && $vehicle_model != 'All') {
    $sql1 .= " AND cm.model_ids = ?";
    $types1 .= "s";
    $bind1[] = $vehicle_model;
}

$sql2 = "SELECT
    ev.id,
    ev.expensevoucher_date AS transaction_date,
    ev.expensevoucher_no AS voucher_no,
    ev.customer_code,
    ev.customer_name,
    c.customer_type,
    c.customer_mobile,
    c.customer_email,
    c.customer_cr_cpr,
    ev.expensevoucher_payment_type AS payment_type,
    JSON_UNQUOTE(JSON_EXTRACT(ev.items, '$[0].item_name')) AS item_name,
    0.000 AS income,
    ev.grand_total AS expense,
    ev.expensevoucher_notes AS remarks,
    ev.vehicle_ids,
    ev.vehicle_no,
    ev.user_name,
    ev.agreement_no,
    ev.model_names,
    'Expense' AS transaction_type,
    ev.expensevoucher_payment_type AS payment_mode
FROM expensevoucher ev
LEFT JOIN customer_details c
    ON c.customer_id = ev.customer_code
WHERE $ev_company_condition
  AND ev.expensevoucher_date BETWEEN ? AND ?";

$types2 = "";
$bind2 = [];

if ($company_param !== null) {
    $types2 .= "i";
    $bind2[] = $company_param;
}
$types2 .= "ss";
$bind2[] = $startDate;
$bind2[] = $endDate;

if (!empty($customer_code) && $customer_code != 'All') {
    $sql2 .= " AND ev.customer_code = ?";
    $types2 .= "s";
    $bind2[] = $customer_code;
}

if (!empty($vehicle_model) && $vehicle_model != 'All') {
    $sql2 .= " AND ev.model_ids = ?";
    $types2 .= "s";
    $bind2[] = $vehicle_model;
}

$sql = "SELECT * FROM (($sql1) UNION ALL ($sql2)) AS combined_transactions ORDER BY transaction_date ASC, voucher_no ASC";
$types = $types1 . $types2;
$bind = array_merge($bind1, $bind2);

$stmt = $mysqli->prepare($sql);
$rows = [];
if ($stmt) {
    if (!empty($bind)) {
        $stmt->bind_param($types, ...$bind);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $stmt->close();
}

// Initialize TCPDF
if (!class_exists('AA_DailyCash_PDF')) {
    class AA_DailyCash_PDF extends TCPDF {
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
                'Daily Cash Report | Page '.$this->getAliasNumPage().' of '.$this->getAliasNbPages(),
                0,
                0,
                'C'
            );
        }
    }
}

$pdf = new AA_DailyCash_PDF(
    'L',              // Landscape
    PDF_UNIT,
    'A4',             // A4 size
    true,
    'UTF-8',
    false
);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Daily Cash Report');

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
        <b>DAILY CASH REPORT</b>
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
        <b>Total Records</b>
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

<table border="1" cellpadding="4" cellspacing="0" width="100%">
<thead style="font-weight:bold; background-color:#f2f2f2;">
<tr bgcolor="#1b3d94" style="color:#fff;font-weight:bold;">
    <th width="4%" align="center">#</th>
    <th width="9%" align="center">Date</th>
    <th width="10%" align="center">Ref No</th>
    <th width="9%" align="center">Pay Mode</th>
    <th width="9%" align="center">Ag. No</th>
    <th width="18%" align="left">Customer</th>
    <th width="12%" align="left">Category</th>
    <th width="14%" align="left">Description</th>
    <th width="7%" align="right">Income</th>
    <th width="8%" align="right">Expense</th>
</tr>
</thead>
<tbody>
';
$totalIncome   = 0;
$totalExpense  = 0;
$depositTotal  = 0;
$refundTotal   = 0;

$paymentSummary = [];
$sl = 1;

foreach ($rows as $row) {

    $income  = (float)$row['income'];
    $expense = (float)$row['expense'];

    $totalIncome  += $income;
    $totalExpense += $expense;

    $item = strtolower(trim($row['item_name']));
    $mode = trim($row['payment_mode']);

    if (!isset($paymentSummary[$mode])) {
        $paymentSummary[$mode] = [
            'income'  => 0,
            'expense' => 0
        ];
    }

    $paymentSummary[$mode]['income'] += $income;
    $paymentSummary[$mode]['expense'] += $expense;

    if (strpos($item, 'deposit') !== false) {
        $depositTotal += $income;
    }

    if (strpos($item, 'refund') !== false) {
        $refundTotal += $expense;
    }

    $custName = htmlspecialchars($row['customer_name'] ?? '');
    if (empty($custName) && empty($row['customer_code'])) {
        $custDetails = '<font color="#888888">-</font>';
    } else {
        $custDetails = '<b>' . ($custName ?: 'N/A') . '</b>';
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
            $custDetails .= '<br><font size="7" color="#1b3d94">CPR: ' . htmlspecialchars($row['customer_cr_cpr']) . '</font>';
        }
    }

    $html .= '
    <tr>
        <td width="4%" align="center"><nobr>'.$sl++.'</nobr></td>
        <td width="9%" align="center">'.date('d-m-Y', strtotime($row['transaction_date'])).'</td>
        <td width="10%" align="center">'.htmlspecialchars($row['voucher_no']).'</td>
        <td width="9%" align="center">'.htmlspecialchars($mode).'</td>
        <td width="9%" align="center">'.htmlspecialchars($row['agreement_no']).'</td>
        <td width="18%">'.$custDetails.'</td>
        <td width="12%">'.htmlspecialchars($row['item_name']).'</td>
        <td width="14%">'.htmlspecialchars($row['remarks']).'</td>
        <td width="7%" align="right">'.number_format($income,3).'</td>
        <td width="8%" align="right">'.number_format($expense,3).'</td>
    </tr>';
}

$html .= '
<tr style="font-weight:bold;background-color:#f5f5f5;">
    <td colspan="8" width="85%" align="right">
        Grand Total
    </td>
    <td width="7%" align="right">
        '.number_format($totalIncome,3).'
    </td>
    <td width="8%" align="right">
        '.number_format($totalExpense,3).'
    </td>
</tr>

</tbody>
</table>

<br><br><br>

<table width="100%" cellpadding="4" cellspacing="0">
<tr>

<td width="28%" valign="top">

<table border="1" cellpadding="4" width="100%">
<tr bgcolor="#EAF4FF">
    <th align="center">Deposit / Refund</th>
</tr>

<tr>
    <td>
        <b>Total Deposit :</b>
        '.number_format($depositTotal,3).'
    </td>
</tr>

<tr>
    <td>
        <b>Total Refund :</b>
        '.number_format($refundTotal,3).'
    </td>
</tr>

</table>

</td>

<td width="4%"></td>

<td width="68%" valign="top">

<table border="1" cellpadding="4" width="100%">

<tr bgcolor="#EAF4FF">
    <th width="40%">Payment Mode</th>
    <th width="30%" align="right">Income</th>
    <th width="30%" align="right">Expense</th>
</tr>';
foreach ($paymentSummary as $mode => $val) {

    $html .= '
    <tr>
        <td>'.htmlspecialchars($mode).'</td>
        <td align="right">'.number_format($val['income'],3).'</td>
        <td align="right">'.number_format($val['expense'],3).'</td>
    </tr>';
}

$html .= '
</table>

</td>

</tr>

</table>';

$pdf->writeHTML($html, true, false, true, false, '');

// Clean output buffer to prevent output issues
while (ob_get_level() > 0) {
    ob_end_clean();
}

$pdf->Output('Daily Cash Report - ' . $startDate.' to '.$endDate. '.pdf', 'I');
