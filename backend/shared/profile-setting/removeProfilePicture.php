<?php

require('../../dbconn.php');

$accountId = $_POST['accountId'];
$profilePictureLink = $_POST['profilePictureLink'];
$string = "no-link";

$sql = "UPDATE accounts_tbl SET profile_picture = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (file_exists($_SERVER['DOCUMENT_ROOT'] . $profilePictureLink)) {
    if (unlink($_SERVER['DOCUMENT_ROOT'] . $profilePictureLink)) {
        $stmt->bind_param("si", $string, $accountId);
        if (!$stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to remove profile picture. Please Contact the Programmer",
                "data" => $stmt->error
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Profile Picture Removed Successfully!",
            ]);
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "File not found. Please Contact the Programmer",
        ]);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "File not found. Please Contact the Programmer",
    ]);
}
