<?php

require('../../dbconn.php');

$accountId = $_POST['accountId'];
$newPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);

$sql = "UPDATE accounts_tbl SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Change Password. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("si", $newPassword, $accountId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Change Password. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Password Changed Successfully! You'll be logout automatically in shortly or after reloading this page."
        ]);
    }
}
