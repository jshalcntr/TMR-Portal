<?php
require '../dbconn.php';

$groupId = $_POST['groupId'];

$sql = "UPDATE sales_groups_tbl SET isActive = 0 WHERE group_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Archive Group. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    $stmt->bind_param("i", $groupId);

    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Archive Group. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Group Details Updated Successfully!"
        ]);
    }
}
