<?php
// $mysqli = new mysqli("localhost", "sandsl23_quotation_user", "S@nds1@b", "sandsl23_quotation");

// $result = $mysqli->query("SELECT * FROM item_master WHERE status='Active' order by item_name asc");

// $data = [];

// while ($row = $result->fetch_assoc()) {
//     $data[] = $row;
// }

// echo json_encode([
//     "data" => $data
// ]);


$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$stmt = $pdo->prepare("
    SELECT CONCAT(brand_name, ' ', model_name) AS item_name FROM view_vehicle_model ORDER BY item_name ASC
");

$stmt->execute();
$data = [];

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

   $data[] = $row;
}

echo json_encode([
    "data" => $data
]);
?>