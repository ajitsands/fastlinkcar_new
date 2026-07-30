<?php

header('Content-Type: application/json');
ini_set('memory_limit', '512M');
$uploadDir = "uploads/rentvehicleImages/";

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if (!isset($_FILES['car_images'])) {
    echo json_encode([
        "status" => false,
        "msg" => "No files received"
    ]);
    exit;
}

$uploadedFiles = [];

foreach ($_FILES['car_images']['tmp_name'] as $key => $tmp) {

    if (!is_uploaded_file($tmp)) continue;

    $name = $_FILES['car_images']['name'][$key];

    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    $newName = time() . '_' . rand(1000,9999) . '.jpg';
    $target = $uploadDir . $newName;

    // 🔴 SAFE IMAGE HANDLING
    $imageData = file_get_contents($tmp);

    if ($imageData === false) continue;

    $image = @imagecreatefromstring($imageData);

    if ($image === false) continue;

    imagejpeg($image, $target, 70);
    imagedestroy($image);

    $uploadedFiles[] = $newName;
}

echo json_encode([
    "status" => true,
    "files" => $uploadedFiles
]);