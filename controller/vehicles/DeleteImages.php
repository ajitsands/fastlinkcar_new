<?php
if (!empty($_POST['file'])) {

    $file = basename($_POST['file']);
    $path = "uploads/vehicleImages/" . $file;

    if (file_exists($path)) {
        unlink($path);
    }

    echo json_encode(['status' => 'deleted']);
}
