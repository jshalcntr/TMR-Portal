<?php

require('../../dbconn.php');

$accountId = $_POST['accountId'];
$currentPassword = $_POST['currentPassword'];

$sql = "SELECT password FROM accounts_tbl WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to check Current Password. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $accountId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to check Current Password. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        // header('Content-Type: application/json');
        // echo json_encode([
        //     "status" => "success",
        //     "message" => "Full Name Updated Successfully!"
        // ]);
        $data = $stmt->get_result()->fetch_assoc();
        if (password_verify($currentPassword, $data['password'])) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Current Password is Valid!",
                "validity" => true
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Current Password is Invalid!",
                "validity" => false
            ]);
        }
    }
}
