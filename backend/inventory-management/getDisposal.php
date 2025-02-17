<?php
require '../dbconn.php';

$inventoryId = $_GET['inventoryId'];
$sql = "SELECT * FROM inventory_disposal_tbl WHERE inventory_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Disposal Information. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $inventoryId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Disposal Information. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $repair = [];
        $repairResult = $stmt->get_result();
        while ($row = $repairResult->fetch_assoc()) {
            $repair[] = $row;
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $repair
        ]);
    }
}
