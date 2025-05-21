<?php
require '../dbconn.php';

$groupId = $_POST['groupId'];
$groupName = $_POST['groupName'];
$groupNumber = $_POST['groupNumber'];

$sql = "UPDATE sales_groups_tbl SET group_initials = ?, group_number = ? WHERE group_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Edit Group Details. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    $stmt->bind_param("ssi", $groupName, $groupNumber, $groupId);

    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Edit Group Details. Please Contact the Programmer",
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
