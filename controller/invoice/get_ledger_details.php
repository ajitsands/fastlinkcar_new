<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;
$term = '%' . ($_GET['term'] ?? '') . '%';

$stmt = $pdo->prepare("
    SELECT *
    FROM (
        SELECT 
            ids AS id,
            head_name AS text,
            head_type,
            'No' AS ledger_type
        FROM tbl_ledger_heads
        WHERE head_name LIKE :term1

        UNION ALL

        SELECT 
            ids AS id,
            price_item AS text,
            'Debit' AS head_type,
            'Yes' AS ledger_type
        FROM tbl_vehicle_pricing_master
        WHERE ledger_status = 'Yes'
          AND price_item LIKE :term2
    ) AS t
    ORDER BY text ASC
");


$stmt->execute([
    ':term1' => $term,
    ':term2' => $term
]);


$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = [
    
    "value" => $row['text'],
    "id"    => $row['id'],
    "head_type"    => $row['head_type'],
    "ledger_type"    => $row['ledger_type']
];
}

echo json_encode($data);