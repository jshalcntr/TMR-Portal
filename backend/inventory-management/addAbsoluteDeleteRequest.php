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
$requestSql = "DELETE FROM inventory_disposal_tbl WHERE inventory_id = $requestedAssetId;
                DELETE FROM inventory_disposed_items_tbl WHERE inventory_id = $requestedAssetId;
                DELETE FROM inventory_repairs_tbl WHERE repaired_item = $requestedAssetId;
                DELETE FROM inventory_records_tbl WHERE id = $requestedAssetId;";

$sql = "INSERT INTO inventory_requests_tbl (requestor_id, request_name, requested_asset_id, request_reason, request_sql, request_datetime) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Add Absolute Delete Request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("isisss", $requestorId, $requestName, $requestedAssetId, $requestReason, $requestSql, $requestDatetime);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add Absolute Delete Request. Please Contact the Programmer",
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
