<?php
include('../dbconn.php');
$id = $_POST['id'];
$newPassword = password_hash("Initial@1", PASSWORD_DEFAULT);

$sql = "UPDATE accounts_tbl SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Edit Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("si", $newPassword, $id);
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
            "message" => "Account Password was Reset Successfully! <br/><b>New Password: </b> Initial@1"
        ]);
    }
}
