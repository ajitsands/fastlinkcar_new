<?php
class FileUploader {
    private $uploadDir;
    private $errors = [];
    private $uploadedFiles = [];

    // ✅ Constructor to initialize upload folder
    public function __construct($uploadDir = "uploads/") {
        $this->uploadDir = rtrim($uploadDir, "/") . "/";
        if (!file_exists($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }
    }

    // ✅ Your uploadFiles() method goes here
    public function uploadFiles($filesArray, $allowedExt = ['jpg', 'jpeg', 'png', 'pdf'], $maxSize = 5242880) {
        if (empty($filesArray['name'][0])) {
            $this->errors[] = "No files selected for upload.";
            return false;
        }

        foreach ($filesArray['name'] as $key => $fileName) {
            $tmpName = $filesArray['tmp_name'][$key];
            $error   = $filesArray['error'][$key];
            $size    = $filesArray['size'][$key];
            $ext     = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if ($error !== UPLOAD_ERR_OK) {
                $this->errors[] = "Error uploading file: $fileName";
                continue;
            }

            if (!in_array($ext, $allowedExt)) {
                $this->errors[] = "Invalid file type: $fileName";
                continue;
            }

            if ($size > $maxSize) {
                $this->errors[] = "File too large: $fileName";
                continue;
            }

            $uniqueName = uniqid() . "_" . basename($fileName);
            $targetPath = $this->uploadDir . $uniqueName;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $this->uploadedFiles[] = $targetPath;
            } else {
                $this->errors[] = "Failed to move file: $fileName";
            }
        }

        return empty($this->errors);
    }

    // ✅ Get uploaded files
    public function getUploadedFiles() {
        return $this->uploadedFiles;
    }

    // ✅ Get any errors
    public function getErrors() {
        return $this->errors;
    }
}
?>