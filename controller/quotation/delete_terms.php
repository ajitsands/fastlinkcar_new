<?php
session_start();

$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

if ($mysqli->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB Connection failed"]));
}

if (!isset($_POST['id'])) {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
    exit;
}

$id = intval($_POST['id']);

$company_id = $_SESSION['COMPANY_ID'];
$user_id    = $_SESSION['USER_IDS'];
$user_type  = $_SESSION['USER_TYPE'];

/* Base delete query */
$sql = "DELETE FROM tbl_terms_and_condition 
        WHERE ids = ? AND company_id = ?";

$params = [$id, $company_id];
$types  = "ii";

/* If not admin, restrict to user */
if ($user_type != 'Admin') {
    $sql .= " AND user_id = ?";
    $params[] = $user_id;
    $types .= "i";
}

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Not allowed or record not found"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Delete failed"]);
}

$stmt->close();
$mysqli->close();
?>