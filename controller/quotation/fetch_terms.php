<?php
session_start();

$mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$company_id = $_SESSION['COMPANY_ID'];
$user_id    = $_SESSION['USER_IDS'];
$user_type  = $_SESSION['USER_TYPE'];

$sql = "SELECT ids, t_c_name, terms_condition, created_at, status 
        FROM tbl_terms_and_condition 
        WHERE company_id = ?";

$params = [$company_id];
$types  = "i";

/*
    If NOT Admin → restrict by user_id
*/
if ($user_type != 'Admin') {
    $sql .= " AND user_id = ?";
    $params[] = $user_id;
    $types .= "i";
}

$sql .= " ORDER BY ids DESC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$data = array();

while ($row = $result->fetch_assoc()) {

    $status = ($row['status'] == 1) 
        ? '<span class="badge bg-success">Active</span>' 
        : '<span class="badge bg-danger">Inactive</span>';

    $data[] = array(
        $row['ids'],
        htmlspecialchars($row['t_c_name']),
        substr(strip_tags($row['terms_condition']), 0, 50) . '...',
        $status,
        '<button class="btn btn-sm btn-primary deleteBtn" data-id="'.$row['ids'].'"><span class="ri ri-delete-bin-6-line"></span></button>',
        '<button class="btn btn-sm btn-info showBtn" data-id="'.$row['ids'].'">Show</button>'
    );
}

echo json_encode(array("data" => $data));

$stmt->close();
$mysqli->close();
?>