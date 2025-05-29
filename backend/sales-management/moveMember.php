<?php

require('../dbconn.php');

$accountId = $_POST['accountId'];
$groupId = $_POST['group'];

$sql = "UPDATE sales_groupings_tbl SET group_id = ? WHERE account_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Move Member. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    $stmt->bind_param("ii", $groupId, $accountId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Move Member. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Successfully Moved Member",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    }
}
