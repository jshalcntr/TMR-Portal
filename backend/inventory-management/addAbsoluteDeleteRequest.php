<?php
session_start();
require '../dbconn.php';

$inventoryId = $_POST['inventoryId'];
$absoluteDeleteReason = $_POST['absoluteDeleteReason'];

$requestorId = $_SESSION['user']['id'];
$requestName = "Absolute Delete";
$requestedAssetId = $inventoryId;
$requestReason = $absoluteDeleteReason;
$requestDatetime = date("Y-m-d H:i:s");

$sql = "INSERT INTO inventory_requests_tbl (requestor_id, request_name, requested_asset_id, request_reason, request_datetime) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Add Absolute Delete Request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("isiss", $requestorId, $requestName, $requestedAssetId, $requestReason, $requestDatetime);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add Absolute Delete Request. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $requestId = $conn->insert_id;
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Absolute Delete Request Sent Successfully!",
            "data" => [
                "requestId" => $requestId
            ]
        ]);
    }
}
