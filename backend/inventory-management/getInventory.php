<?php
include('../dbconn.php');

$queriedId = $_GET['id'];

$sql = "SELECT * FROM inventory_records_tbl WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Inventory. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $queriedId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inventory. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $inventory = [];
        $inventoryResult = $stmt->get_result();
        while ($row = $inventoryResult->fetch_assoc()) {
            $inventory[] = $row;
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $inventory
        ]);
    }
}
