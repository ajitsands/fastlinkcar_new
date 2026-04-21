<?php

$uploadDir = "assets/img/users/";
$allowed = ['jpg', 'jpeg', 'png', 'webp'];

if (isset($_FILES['image'])) {

    $originalName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed)) {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid file type"
        ]);
        exit;
    }

    // create unique filename
    $uniqueName = uniqid('user_', true) . '.' . $ext;

    $target = $uploadDir . $uniqueName;

    if (move_uploaded_file($tmpName, $target)) {

        echo json_encode([
            "status" => "success",
            "file" => $uniqueName   // return unique name
        ]);
    } else {

        echo json_encode([
            "status" => "error"
        ]);
    }
}
