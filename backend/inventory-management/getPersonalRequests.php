<?php
session_start();
require '../dbconn.php';

$accountId = $_SESSION['user']['id'];
$inventoryId = $_GET['inventoryId'];
$sql = "SELECT * FROM inventory_requests_tbl WHERE requestor_id = ? AND requested_asset_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Requests. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("ii", $accountId, $inventoryId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Requests. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $requests = [];
        $requestResult = $stmt->get_result();
        while ($row = $requestResult->fetch_assoc()) {
            $requests[] = [
                "requestId" => $row['request_id'],
                "requestName" => $row['request_name'],
                "requestReason" => $row['request_reason'],
                "requestDatetime" => $row['request_datetime'],
                "status" => $row['request_status']
            ];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "data" => $requests
        ]);
    }
}
