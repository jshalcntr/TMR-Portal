<?php
session_start();
include "../dbconn.php";

$receiverAuth = $_POST['receiverAuth'];
$senderId = $_SESSION['user']['id'];
$inventoryId = $_POST['inventoryId'];
$requestId = $_POST['requestId'];
$notificationType = $_POST['notificationType'];
$notificationSubject = $_POST['notificationSubject'];
$notificationDescription = $_POST['notificationDescription'];
$notificationDateTime = date('Y-m-d H:i:s');

$sql1 = "SELECT accounts_tbl.id FROM accounts_tbl
        JOIN authorizations_tbl ON accounts_tbl.id = authorizations_tbl.account_id
        WHERE authorizations_tbl.$receiverAuth = 1";
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Create Notification. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Create Notifications. Please Contact the Programmer"
        ]);
    } else {
        $result = $stmt1->get_result();
        $receiverIds = [];
        while ($row = $result->fetch_assoc()) {
            $receiverIds[] = $row['id'];
        }
        foreach ($receiverIds as $receiverId) {
            $sql2 = "INSERT INTO inventory_notifications_tbl (receiver_id, sender_id, inventory_id, request_id, notification_type, notification_subject, notification_description, notification_datetime)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            if (!$stmt2) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "minor-error",
                    "message" => "Failed to Create Notification. Please Contact the Programmer."
                ]);
                exit();
            } else {
                $stmt2->bind_param("iiiissss", $receiverId, $senderId, $inventoryId, $requestId, $notificationType, $notificationSubject, $notificationDescription, $notificationDateTime);
                if (!$stmt2->execute()) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        "status" => "minor-error",
                        "message" => "Failed to Create Notification. Please Contact the Programmer."
                    ]);
                    exit();
                }
            }
        }
    }
}


// $sql = "INSERT INTO inventory_notifications_tbl (receiver_id, sender_id, inventory_id, notification_type, notification_subject, notification_description, notification_datetime)
//         VALUES (?, ?, ?, ?, ?, ?, ?)";
// $stmt = $conn->prepare($sql);

// if (!$stmt) {
//     header('Content-Type: application/json');
//     echo json_encode([
//         "status" => "internal-error",
//         "message" => "Failed to Create Notification. Please Contact the Programmer",
//         "data" => $conn->error
//     ]);
// }else{
//     $stmt->bind_param("iisssss", $receiverId, $senderId, $inventoryId, $notificationType, $notificationSubject, $notificationDescription, $notificationDateTime);
//     if (!$stmt->execute()) {
//         header('Content-Type: application/json');
//         echo json_encode([
//             "status" => "internal-error",
//             "message" => "Failed to Create Notification. Please Contact the Programmer",
//             "data" => $stmt->error
//         ]);
//     }else{
//         header('Content-Type: application/json');
//         echo json_encode([
//             "status" => "success",
//             "message" => "Notification Created!",
//         ]);
//     }
// }
