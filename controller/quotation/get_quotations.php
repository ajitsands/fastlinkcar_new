<?php
session_start();
$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

$draft = $_GET['draft'] ?? 'No';
$decimals = $_GET['decimals'] ?? 2;;
// $sql = "SELECT id, quotation_no, quotation_date, customer_name, 
//         subtotal, vat_total, grand_total
//         FROM quotations
//         WHERE draft = ?
//         ORDER BY id DESC";
$company_id = $_SESSION['COMPANY_ID'];
$user_id    = $_SESSION['USER_IDS'];
$user_type  = $_SESSION['USER_TYPE'];

if ($user_type === 'Admin') {

    $sql = "SELECT * FROM quotations WHERE company_id = ? and draft ='".$draft."' order by id desc";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $company_id);

} else {

    $sql = "SELECT * FROM quotations 
            WHERE company_id = ? AND user_id = ? and draft ='".$draft."' order by id desc";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $company_id, $user_id);
}

// $stmt = $mysqli->prepare($sql);
// $stmt->bind_param("s", $draft);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $date = date("d-m-Y", strtotime($row['quotation_date']));

    $subtotal = number_format($row['subtotal'], $decimals);
    $vat = number_format($row['vat_total'], $decimals);
    $grand = number_format($row['grand_total'], $decimals);

    echo "<tr>
        <td>{$row['quotation_no']}</td>
        <td>{$date}</td>
        <td>{$row['customer_name']}</td>
        <td style='text-align: right'>{$subtotal}</td>
        <td style='text-align: right'>{$vat}</td>
        <td style='text-align: right'>{$grand}</td>
        <td>
            <button class='btn btn-sm btn-primary viewQuotation' 
                data-id='{$row['id']}'><span class='ri ri-list-view icon-18px'></span></button>
        </td>
        <td>
            <button class='btn btn-sm btn-info' onclick='printQuotation({$row['id']})'>
                <span class='ri ri-printer-line icon-18px'></span>
            </button>
        </td>
    </tr>";
}

$stmt->close();
$mysqli->close();
?>
