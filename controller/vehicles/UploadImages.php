<?php
$uploadDir = "uploads/vehicleImages/";
$allowed = ['jpg', 'jpeg', 'png', 'webp'];

$uploadedFiles = [];

if (!empty($_FILES['images']['name'][0])) {

    foreach ($_FILES['images']['name'] as $key => $name) {

        $tmpName = $_FILES['images']['tmp_name'][$key];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            continue;
        }

        // unique filename
        $fileName = uniqid('veh_', true) . '.' . $ext;
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $target)) {
            $uploadedFiles[] = $fileName;
        }
    }

    echo json_encode([
        'status' => 'success',
        'files' => $uploadedFiles
    ]);
} else {
    echo json_encode(['status' => 'no files']);
}
