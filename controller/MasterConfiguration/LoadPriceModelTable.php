<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

$modelId = $_POST['modelId'];

// ✅ master items (FIXED QUERY)
$master = $pdo->query("SELECT ids, price_item FROM tbl_vehicle_pricing_master")
              ->fetchAll(PDO::FETCH_ASSOC);

// ✅ model json
$stmt = $pdo->prepare("SELECT price_json FROM tbl_vehicle_model WHERE ids = ?");
$stmt->execute([$modelId]);
$model = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ decode safely
$jsonData = [];
if (!empty($model['price_json'])) {
    $decoded = json_decode($model['price_json'], true);
    if (is_array($decoded)) {
        $jsonData = $decoded;
    }
}

// ✅ create map
$priceMap = [];

foreach ($jsonData as $row) {

    $id = $row['ids'] ?? null;
    $amount = $row['amount'] ?? '';

    if ($id !== null) {
        $priceMap[$id] = $amount;
    }
}

// ✅ merge master + json (EMPTY HANDLING FIXED)
$result = [];

foreach ($master as $m) {

    $amount = '';

    if (array_key_exists($m['ids'], $priceMap)) {

        $val = $priceMap[$m['ids']];

        // ✅ handle empty / null properly
        if ($val !== null && $val !== '') {
            $amount = $val;
        }
    }

    $result[] = [
        'id' => $m['ids'],
        'item' => $m['price_item'],
        'amount' => $amount
    ];
}

echo json_encode($result);
?>