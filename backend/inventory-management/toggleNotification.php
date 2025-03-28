<?php
include '../dbconn.php';

$notificationId = $_POST['notificationId'];

$sql = "UPDATE `inventory_notifications_tbl` SET `isRead` = 1 WHERE `inventory_notifications_tbl`.`notification_id` = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Update Notification status.",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $notificationId);
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
            "data" => $sql
        ]);
    }
}
