<?php

require('../dbconn.php');

$groupName = strtoupper($_POST['groupName']);
$groupNumber = $_POST['groupNumber'];

$sql = "INSERT INTO sales_groups_tbl(group_initials, group_number) VALUES (?, ?)";
$stmt1 = $conn->prepare($sql);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Add Group. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt1->bind_param("si", $groupName, $groupNumber);
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add Group. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Group Added Successfully!"
        ]);
    }
}
