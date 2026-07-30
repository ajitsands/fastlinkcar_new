<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$term = $_GET['term'] ?? '';


$stmt = $pdo->prepare("SELECT id, quotation_no, customer_name, attention  FROM quotations WHERE quotation_no LIKE :term1  OR customer_name LIKE :term2
    LIMIT 10");

$stmt->execute([
    ':term1' => "%$term%",
    ':term2' => "%$term%"
]);


$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = $row;
}

echo json_encode($data);