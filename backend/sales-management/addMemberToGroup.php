<?php

require '../dbconn.php';

$accountId = $_POST['member'];
$groupId = $_POST['group'];

$sql = "INSERT INTO sales_groupings_tbl(account_id, group_id) VALUES(?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to add member to group. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    $stmt->bind_param('ii', $accountId, $groupId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to add member to group. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Member added to group successfully"
        ]);
        $stmt->close();
        exit;
    }
}
