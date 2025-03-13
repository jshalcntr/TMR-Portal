<?php
session_start();
require '../dbconn.php';

$inventoryId = $_GET['inventoryId'];
$sql = "SELECT inventory_requests_tbl.*, accounts_tbl.full_name FROM inventory_requests_tbl
        JOIN accounts_tbl ON inventory_requests_tbl.requestor_id = accounts_tbl.id
        WHERE requested_asset_id = ? AND request_status = 'pending'";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Requests. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $inventoryId);
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
                "requestor" => $row['full_name']
            ];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "data" => $requests
        ]);
    }
}
