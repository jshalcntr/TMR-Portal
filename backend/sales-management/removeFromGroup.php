<?php

require('../dbconn.php');

$accountId = $_POST['accountId'];

$sql = "DELETE FROM sales_groupings_tbl WHERE account_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Remove Member. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    $stmt->bind_param("i", $accountId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Remove Member. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Member Removed Successfully"
        ]);
    }
}
