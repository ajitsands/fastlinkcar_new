<?php

header('Content-Type: application/json');

$uploadDir = "uploads/rentvehicleImages/";
$file = $_POST['file'] ?? '';

// ❌ if no file provided
if (!$file) {
    echo json_encode([
        "status" => false,
        "message" => "No file specified"
    ]);
    exit;
}

// 🔒 Security: prevent path traversal
$file = basename($file);

$filePath = $uploadDir . $file;

// ✅ Check file exists
if (file_exists($filePath)) {

    if (unlink($filePath)) {
        echo json_encode([
            "status" => true,
            "message" => "File deleted successfully"
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Failed to delete file"
        ]);
    }

} else {
    echo json_encode([
        "status" => false,
        "message" => "File not found"
    ]);
}