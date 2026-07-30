<?php
$module = $_POST['module'] ?? 'general';

switch($module)
{
    case 'passing':
        $uploadDir = "httpdocs/images/vehicle_passing_documents/";
        $baseUrl   = "/images/vehicle_passing_documents/";
    break;
    case 'insurance':
        $uploadDir = "httpdocs/images/vehicle_insurance_document/";
        $baseUrl   = "/images/vehicle_insurance_document/";
    break;
    case 'maintenance':
        $uploadDir = "httpdocs/images/vehicle_maintenance_documents/";
        $baseUrl   = "/images/vehicle_maintenance_documents/";
    break;
    default:
        $uploadDir = "httpdocs/images/general/";
        $baseUrl   = "/images/general/";
    break;
}

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$allowed = ['jpg', 'jpeg', 'png', 'webp', 'pdf', 'doc', 'docx'];

$uploadedFiles = [];

if (!empty($_FILES['files']['name'][0])) {

    foreach ($_FILES['files']['name'] as $key => $name) {

        $tmpName = $_FILES['files']['tmp_name'][$key];
        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) continue;

        $fileName = uniqid('veh_', true) . '.' . $ext;
        $target = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $target)) {

            $uploadedFiles[] = [
                "name" => $name,
                "url"  => $baseUrl . $fileName
            ];
        }
    }

    echo json_encode([
        'status' => 'success',
        'files' => $uploadedFiles
    ]);

} else {
    echo json_encode([
        'status' => 'no files',
        'files' => []
    ]);
}
?>