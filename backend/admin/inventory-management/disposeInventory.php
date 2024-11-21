<?php
require '../../dbconn.php';

date_default_timezone_set('Asia/Manila');

$inventoryId = $_POST['inventoryId'];
$remarks = $_POST['remarks'] ? $_POST['remarks'] : "";
$date = date('Y-m-d');

$sql = "INSERT INTO inventory_disposal_tbl (inventory_id, date_added, remarks) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("iss", $inventoryId, $date, $remarks);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Added to Disposal Successfully!",
        ]);
    }
}
