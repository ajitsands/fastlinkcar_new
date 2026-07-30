<?php

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;
$term = '%' . ($_GET['term'] ?? '') . '%';

$stmt = $pdo->prepare("
     SELECT 
            ids AS id,
            head_name AS text,
            head_type,
            'No' AS ledger_type
        FROM tbl_ledger_heads
        WHERE head_type='Debit' and head_name LIKE :term1
    ORDER BY text ASC
");


$stmt->execute([
    ':term1' => $term
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