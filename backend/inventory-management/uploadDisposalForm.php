<?php
require('../dbconn.php');
date_default_timezone_set('Asia/Manila');
$date = date('Ymdhis');
$dateNow = date('Y-m-d');
$disposasbleItemIds = isset($_POST['disposableItemIds']) ? json_decode($_POST['disposableItemIds'], true) : [];

if (isset($_FILES['disposalFormFile']) && $_FILES['disposalFormFile']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['disposalFormFile'];
    $uploadDir = "../../uploads/disposal_form/";
    $fileTmpPath = $file['tmp_name'];
    $fileName = "disposalForm-" . $date;
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

    $newFilePath = $uploadDir . $fileName . '.' . $fileExtension;
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($fileTmpPath, $newFilePath)) {
        $fullFilePath = "/tmr-portal/uploads/disposal_form/" . $fileName . '.' . $fileExtension;
        // header('Content-Type: application/json');
        // echo json_encode([
        //     "status0"1. => "success",
        //     "message" => "File uploaded successfully",
        //     "data" => $fullFilePath
        // ]);
        $createDisposedRecordSql = "INSERT INTO inventory_disposed_tbl (disposed_date, scanned_form_file) VALUES (?, ?)";
        $createDisposedRecordStmt = $conn->prepare($createDisposedRecordSql);

        if (!$createDisposedRecordStmt) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "error",
                "message" => "Failed to create disposed record. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $createDisposedRecordStmt->bind_param("ss", $dateNow, $fullFilePath);
            if (!$createDisposedRecordStmt->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to create disposed record. Please Contact the Programmer",
                    "data" => $createDisposedRecordStmt->error
                ]);
            } else {
                $disposedId = $conn->insert_id;
                foreach ($disposasbleItemIds as $disposableItemId) {
                    $disposeItemSql = "INSERT INTO inventory_disposed_items_tbl (disposed_id, inventory_id) VALUES (?, ?)";
                    $disposeItemStmt = $conn->prepare($disposeItemSql);
                    if (!$disposeItemStmt) {
                        header('Content-Type: application/json');
                        echo json_encode([
                            "status" => "error",
                            "message" => "Failed to dispose item. Please Contact the Programmer",
                            "data" => $conn->error
                        ]);
                        // continue;
                    } else {
                        $disposeItemStmt->bind_param("ii", $disposedId, $disposableItemId);
                        if (!$disposeItemStmt->execute()) {
                            header('Content-Type: application/json');
                            echo json_encode([
                                "status" => "error",
                                "message" => "Failed to dispose item. Please Contact the Programmer",
                                "data" => $disposeItemStmt->error
                            ]);
                            // continue;
                        } else {
                            $updateItemInfoSql = "UPDATE inventory_records_tbl SET status = 'Disposed' WHERE id = ?";
                            $updateItemInfoStmt = $conn->prepare($updateItemInfoSql);
                            if (!$updateItemInfoStmt) {
                                header('Content-Type: application/json');
                                echo json_encode([
                                    "status" => "error",
                                    "message" => "Failed to update item info. Please Contact the Programmer",
                                    "data" => $conn->error
                                ]);
                                // continue;
                            } else {
                                $updateItemInfoStmt->bind_param("i", $disposableItemId);
                                if (!$updateItemInfoStmt->execute()) {
                                    header('Content-Type: application/json');
                                    echo json_encode([
                                        "status" => "error",
                                        "message" => "Failed to update item info. Please Contact the Programmer",
                                        "data" => $updateItemInfoStmt->error
                                    ]);
                                } else {
                                    $updateDisposalSql = "UPDATE inventory_disposal_tbl SET isDisposed = 1, date_disposed = ? WHERE inventory_id = ?";
                                    $updateDisposalStmt = $conn->prepare($updateDisposalSql);
                                    if (!$updateDisposalStmt) {
                                        header('Content-Type: application/json');
                                        echo json_encode([
                                            "status" => "error",
                                            "message" => "Failed to update disposal info. Please Contact the Programmer",
                                            "data" => $conn->error
                                        ]);
                                        // continue;
                                    } else {
                                        $updateDisposalStmt->bind_param("si", $dateNow, $disposableItemId);
                                        if (!$updateDisposalStmt->execute()) {
                                            header('Content-Type: application/json');
                                            echo json_encode([
                                                "status" => "error",
                                                "message" => "Failed to update disposal info. Please Contact the Programmer",
                                                "data" => $updateDisposalStmt->error
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "File uploaded successfully",
                    "data" => $fullFilePath
                ]);
            }
        }
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
