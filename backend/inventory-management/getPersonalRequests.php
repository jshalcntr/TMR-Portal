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
        $request = [];
        $requestResult = $stmt->get_result();
        while ($row = $requestResult->fetch_assoc()) {
            $request[] = $row;
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $request
        ]);
    }
}
