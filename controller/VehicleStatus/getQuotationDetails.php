<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$ids = $_GET['id'] ?? '';


$stmt = $pdo->prepare("SELECT id, quotation_no, customer_code,customer_name, DATE_FORMAT(quotation_date, '%M %e %Y') AS qtnformatted_date,customer_phone,customer_email,customer_address,attention,items FROM quotations WHERE id = :ids");

$stmt->execute([
    ':ids' => $ids
]);


$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = $row;
}

echo json_encode($data);