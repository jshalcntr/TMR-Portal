<?php
session_start();
require '../dbconn.php';

$accountId = $_SESSION['user']['id'];
$sql = "SELECT inventory_notifications_tbl.*,
        sender.id AS sender_id,
        sender.full_name as sender_name,
        sender.profile_picture as sender_profile
        FROM inventory_notifications_tbl
        JOIN accounts_tbl AS sender ON inventory_notifications_tbl.sender_id = sender.id
        WHERE receiver_id = ?
        ORDER BY notification_datetime DESC";
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
