<?php
require '../dbconn.php';

$groupId = $_GET['groupId'];

$sql = "SELECT * FROM sales_groups_tbl WHERE group_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Group Details. Please Contact the Programmer",
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
            "message" => "Failed to fetch Group Details. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $groupDetails = [];
        $groupDetailsResult = $stmt->get_result();
        while ($row = $groupDetailsResult->fetch_assoc()) {
            $groupDetails[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Successfully fetched Group Details",
            "data" => $groupDetails
        ]);
    }
}
