<?php
header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Unknown error'];

if(isset($_POST['file'])){
    $filePath = $_POST['file']; // uploads/driver/webp/file_697d1837ce49d1.93872214.webp

    // Base uploads folder (adjust your path)
    $baseUploadDir = realpath(__DIR__ . '/../../uploads');

    if(!$baseUploadDir){
        echo json_encode(['status'=>'error','message'=>'Uploads folder not found']);
        exit;
    }

    // Remove 'uploads/' prefix
    $relativePath = preg_replace('#^uploads/#', '', $filePath);

    // Parent folder (driver/client/rentedcars)
    $parts = explode('/', $relativePath);
    if(count($parts) < 3){
        echo json_encode(['status'=>'error','message'=>'Invalid path structure']);
        exit;
    }

    $parentFolder = $parts[0]; // driver, client, rentedcars
    $fileName = pathinfo($relativePath, PATHINFO_FILENAME); // without extension

    $subFolders = ['webp','thumb','original','files'];
    $deleted = [];
    $notDeleted = [];

    foreach($subFolders as $sub){
        $folderPath = $baseUploadDir . "/$parentFolder/$sub";

        if(is_dir($folderPath)){
            // Find all files starting with the same filename (any extension)
            $files = glob($folderPath . "/$fileName.*");

            foreach($files as $f){
                if(file_exists($f) && unlink($f)){
                    $deleted[] = $f;
                } else {
                    $notDeleted[] = $f;
                }
            }
        }
    }

    if(count($deleted) > 0){
        $response = [
            'status' => 'success',
            'message' => 'All related files deleted',
            'deleted' => $deleted,
            'notDeleted' => $notDeleted
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No files deleted',
            'notDeleted' => $notDeleted
        ];
    }

    echo json_encode($response);
    exit;
}
?>
