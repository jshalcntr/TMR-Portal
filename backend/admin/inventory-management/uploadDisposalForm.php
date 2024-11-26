<?php
require('../../dbconn.php');
date_default_timezone_set('Asia/Manila');
$date = date('Ymd');

if (isset($_FILES['disposalFormFile']) && $_FILES['disposalFormFile']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['disposalFormFile'];
    $uploadDir = "../../uploads/inventory/";
    $fileTmpPath = $file['tmp_name'];
    $fileName = "disposalForm-" . $date;
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    $newFilePath = $uploadDir . $fileName . '.' . $fileExtension;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($fileTmpPath, $newFilePath)) {
        $fullFilePath = "/tmr-portal_dev/backend/uploads/inventory/" . $fileName . '.' . $fileExtension;
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "File uploaded successfully",
            "data" => $fullFilePath
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => "Failed to upload file. Please Try Again",
            "data" => $_POST
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => "No file uploaded. Please Try Again",
        "data" => $_POST
    ]);
}
