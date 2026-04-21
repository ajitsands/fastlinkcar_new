if (!empty($_FILES['categoryImage']['name'])) {

    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

    $fileType = mime_content_type($_FILES['categoryImage']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode([
            "status" => "error",
            "message" => "Only image files allowed"
        ]);
        exit;
    }

    // size check (2MB)
    if ($_FILES['categoryImage']['size'] > 2 * 1024 * 1024) {
        echo json_encode([
            "status" => "error",
            "message" => "File too large (Max 2MB)"
        ]);
        exit;
    }

    $imageName = time() . '_' . $_FILES['categoryImage']['name'];
    move_uploaded_file($_FILES['categoryImage']['tmp_name'], 'httpdocs/images/vehicle_category_images/' . $imageName);
}