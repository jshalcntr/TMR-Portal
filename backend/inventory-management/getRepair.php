<?php
require '../dbconn.php';

$repairId = $_GET['repairId'];
$sql = "SELECT * FROM inventory_repairs_tbl WHERE repair_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Repair Information. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $repairId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Repair Information. Please Contact the Programmer",
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
