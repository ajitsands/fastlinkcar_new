<?php
session_start();

$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

if ($mysqli->connect_error) {
    die("Connection failed");
}

if (!isset($_GET['id'])) {
    exit;
}

$id = intval($_GET['id']);

$company_id = $_SESSION['COMPANY_ID'];
$user_id    = $_SESSION['USER_IDS'];
$user_type  = $_SESSION['USER_TYPE'];

$sql = "SELECT terms_condition 
        FROM tbl_terms_and_condition 
        WHERE ids = ? AND company_id = ?";

$params = [$id, $company_id];
$types  = "ii";

if ($user_type != 'Admin') {
    $sql .= " AND user_id = ?";
    $params[] = $user_id;
    $types .= "i";
}

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo $row['terms_condition']; // return HTML directly
}

$stmt->close();
$mysqli->close();
?>