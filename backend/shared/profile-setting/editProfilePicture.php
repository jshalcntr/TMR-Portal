<?php
require('../../dbconn.php');

if (isset($_FILES['profilePictureFile']) && $_FILES['profilePictureFile']['error'] == 0) {
    $accountId = $_POST['accountId'];
    $file = $_FILES['profilePictureFile']['tmp_name'];
    $uploadDir = "../../../uploads/profile_pictures/";
    $fileName = "dp" . $accountId;
    $fileExtension = pathinfo($_FILES['profilePictureFile']['name'], PATHINFO_EXTENSION);

    $newFilePath = $uploadDir . $fileName . '.' . $fileExtension;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (move_uploaded_file($file, $newFilePath)) {
        $fullFilePath = "/tmr-portal_dev/uploads/profile_pictures/" . $fileName . '.' . $fileExtension;

        $updateProfilePictureSql = "UPDATE accounts_tbl SET profile_picture = ? WHERE id = ?";
        $updateProfilePictureStmt = $conn->prepare($updateProfilePictureSql);

        if (!$updateProfilePictureStmt) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "error",
                "message" => "Failed to update profile picture. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $updateProfilePictureStmt->bind_param("si", $fullFilePath, $accountId);
            if (!$updateProfilePictureStmt->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "error",
                    "message" => "Failed to update profile picture. Please Contact the Programmer",
                    "data" => $updateProfilePictureStmt->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Profile Picture Updated Successfully!",
                    "data" => $fullFilePath
                ]);
            }
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "error",
            "message" => "Failed to upload profile picture. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    }
}
