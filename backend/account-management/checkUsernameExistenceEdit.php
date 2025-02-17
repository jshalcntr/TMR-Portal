<?php
require '../dbconn.php';

$id = $_GET['id'];
$username = trim($_GET['username']);

$stmt = $conn->prepare("SELECT COUNT(*) FROM accounts_tbl WHERE username = ? AND id <> ?");
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Check Username Existence. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("si", $username, $id);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Check Username Existence. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $stmt->bind_result($count);
        $stmt->fetch();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "exists" => $count > 0,
        ]);
    }
}
