<?php
require('../../backend/dbconn.php');

$sql = "SELECT * FROM sales_groups_tbl WHERE isActive = 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Sub Profiling. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Sub Profiling. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    } else {
        $groupsResult = $stmt->get_result();
        $groups = [];
        while ($row = $groupsResult->fetch_assoc()) {
            $id = $row['group_id'];
            $groupName = $row['group_initials'];
            $groupNumber = $row['group_number'];
            $groupMembers = "?";

            $groups[] = [
                "id" => $id,
                "groupName" => $groupName,
                "groupNumber" => $groupNumber,
                "groupMembers" => $groupMembers
            ];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $groups
        ]);
    }
}
