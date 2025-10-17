<?php
session_start();
require "../dbconn.php";

$sql = "SELECT * FROM sales_inquiry_notifications_tbl WHERE receiver_id = ? AND isActive = 1 ORDER BY isRead ASC, created_at DESC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch notification. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $_SESSION['user']['id']);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch notification. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
    } else {
        $notification = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $notification[] = $row;
        }
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $notification
        ]);
        $stmt->close();
    }
}
