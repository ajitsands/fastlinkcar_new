<?php

$uploadDir = dirname(__DIR__) . '../../view/upload/clientdoc/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
//echo '-'.$_POST['client_document_type'].'-'.$_POST['client_document_issue_location'].'-'.$_POST['client_document_issue_date'].'-'.$_POST['client_document_expiry_date'];

if (isset($_FILES['client_document'])) {

    $file      = $_FILES['client_document'];
    $fileName  = $file['name'];
    $fileTmp   = $file['tmp_name'];
    $fileError = $file['error'];

    if ($fileError === 0) {

        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);

        // Create timestamped filename
        $newFileName = time() . '_' . uniqid() . '.' . $fileExt;

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmp, $destination)) {
            //echo "File uploaded successfully as <b>$newFileName</b>";
           echo json_encode([
                'status'       => 'success',
                'messsage'     => 'File Uploaded Successfully',
                'image_url'    => '/view/upload/clientdoc/' . $newFileName,
                'uploaded_by'  => $_POST['client_document_type']
            ]);
        } else {
            echo "Failed to move uploaded file.";
        }

    } else {
        echo "File upload error.";
    }

} else {
    echo "No file received.";
}
