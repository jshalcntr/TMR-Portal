<?php

require('../../dbconn.php');

$accountId = $_POST['accountId'];
$fullName = $_POST['fullName'];

$sql = "UPDATE accounts_tbl SET full_name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Edit Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("si", $fullName, $accountId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Edit Account. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Full Name Updated Successfully!"
        ]);
    }
}
