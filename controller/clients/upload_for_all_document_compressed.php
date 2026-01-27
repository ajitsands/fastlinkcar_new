<?php
ini_set('memory_limit', '512M');
header('Content-Type: application/json');

/* -----------------------------
   1. SANITIZE & PREPARE FOLDER
--------------------------------*/
$folderName = $_POST['foldername'] ?? 'default';
$folderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $folderName);
if ($folderName === '') {
    $folderName = 'default';
}

$basePath = "uploads/$folderName";

$folders = [
    "$basePath/original",
    "$basePath/webp",
    "$basePath/thumb",
    "$basePath/files" // for non-images
];

foreach ($folders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

/* -----------------------------
   2. ALLOWED TYPES
--------------------------------*/
$allowedImageExt = ['jpg', 'jpeg', 'png', 'webp'];
$allowedDocsExt  = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'];

$response = [];

if (!isset($_FILES['files'])) {
    echo json_encode(['error' => 'No files received']);
    exit;
}

/* -----------------------------
   3. FILE LOOP
--------------------------------*/
foreach ($_FILES['files']['tmp_name'] as $key => $tmp) {

    if (!is_uploaded_file($tmp)) continue;

    $originalName = $_FILES['files']['name'][$key];
    $mimeType     = $_FILES['files']['type'][$key];

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    $safeName = uniqid('file_', true);

    /* -----------------------------
       IMAGE FILES
    --------------------------------*/
    if (in_array($ext, $allowedImageExt) && strpos($mimeType, 'image/') === 0) {

        $jpgPath   = "$basePath/original/$safeName.jpg";
        $webpPath  = "$basePath/webp/$safeName.webp";
        $thumbPath = "$basePath/thumb/$safeName.jpg";

        $src = @imagecreatefromstring(file_get_contents($tmp));
        if (!$src) continue;

        imagejpeg($src, $jpgPath, 85);
        imagewebp($src, $webpPath, 80);
        createThumbnail($src, $thumbPath, 300, 300);

        imagedestroy($src);

        $response[] = [
            'type'  => 'image',
            'jpg'   => $jpgPath,
            'webp'  => $webpPath,
            'thumb' => $thumbPath
        ];
    }

    /* -----------------------------
       NON-IMAGE FILES (PDF, DOC…)
    --------------------------------*/
    elseif (in_array($ext, $allowedDocsExt)) {

        $filePath = "$basePath/files/$safeName.$ext";

        if (move_uploaded_file($tmp, $filePath)) {
            $response[] = [
                'type' => 'file',
                'file' => $filePath,
                'name' => $originalName
            ];
        }
    }
}

/* -----------------------------
   4. RESPONSE
--------------------------------*/
echo json_encode([
    'status' => 'success',
    'count'  => count($response),
    'data'   => $response,
    'messsage'     => 'File Uploaded Successfully',
    'uploaded_by'  => $_POST['documentType']
]);



/* -----------------------------
   5. THUMBNAIL FUNCTION
--------------------------------*/
function createThumbnail($img, $path, $w, $h) {
    $width  = imagesx($img);
    $height = imagesy($img);

    $ratio = min($w / $width, $h / $height);
    $newW = (int)($width * $ratio);
    $newH = (int)($height * $ratio);

    $thumb = imagecreatetruecolor($newW, $newH);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newW, $newH, $width, $height);
    imagejpeg($thumb, $path, 80);
    imagedestroy($thumb);
}
