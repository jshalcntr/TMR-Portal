<?php
session_start();
require '../dbconn.php';

$accountId = $_SESSION['user']['id'];
$sql = "SELECT COUNT(*) FROM sales_inquiry_notifications_tbl WHERE receiver_id = ? AND isRead = 0";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Notifications. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $accountId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Notifications. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $notifications = [];
        $notificationsResult = $stmt->get_result();
        while ($row = $notificationsResult->fetch_assoc()) {
            $notifications[] = $row;
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $notifications
        ]);
    }
}
