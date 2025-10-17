<?php
include '../dbconn.php';

$historyId = $_POST['historyId'];

$sql = "UPDATE `sales_inquiry_notifications_tbl` SET `isActive` = 0 WHERE `sales_inquiry_notifications_tbl`.`history_id` = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Update Notification status.",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $historyId);
    if (!$stmt->execute()) {
        header("Content-Type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Update Notification status.",
            "data" => $stmt->error
        ]);
    } else {
        header("Content-Type: application/json");
        echo json_encode([
            "status" => "success",
            "message" => "Notification status updated.",
        ]);
    }
}
