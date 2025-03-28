<?php
session_start();
include "../dbconn.php";

$receiverId = $_POST['receiverId'];
$senderId = $_SESSION['user']['id'];
$inventoryId = $_POST['inventoryId'];
$requestId = $_POST['requestId'];
$notificationType = $_POST['notificationType'];
$notificationSubject = $_POST['notificationSubject'];
$notificationDescription = $_POST['notificationDescription'];
$notificationDateTime = date('Y-m-d H:i:s');

$sql = "INSERT INTO inventory_notifications_tbl (receiver_id, sender_id, inventory_id, notification_type, notification_subject, notification_description, notification_datetime) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Create Notification. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("iiissss", $receiverId, $senderId, $inventoryId, $notificationType, $notificationSubject, $notificationDescription, $notificationDateTime);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Create Notification. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Notification Created!",
        ]);
    }
}
