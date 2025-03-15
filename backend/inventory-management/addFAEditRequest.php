<?php
session_start();
require '../dbconn.php';

$inventoryId = $_POST['inventoryId'];
$newFA = $_POST['newFA'];
$newFAReason = $_POST['newFAReason'];

$requestorId = $_SESSION['user']['id'];
$requestName = "Edit FA Number";
$requestedAssetId = $inventoryId;
$requestReason = $newFAReason;
$requestDateTime = date("Y-m-d H:i:s");

$sql = "INSERT INTO inventory_requests_tbl (requestor_id, request_name, requested_asset_id, request_reason, new_fa_number, request_datetime) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Add FA Edit Request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("isisss", $requestorId, $requestName, $requestedAssetId, $requestReason, $newFA, $requestDateTime);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add FA Edit Request. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "FA Edit Request Sent Successfully!"
        ]);
    }
}
