<?php
require '../dbconn.php';

$inventoryId = $_GET['inventoryId'];
$sql = "SELECT 
        inventory_records_tbl.fa_number,
        inventory_records_tbl.item_type,
        inventory_records_tbl.item_category,
        inventory_records_tbl.brand,
        inventory_records_tbl.model,
        inventory_records_tbl.item_specification,
        inventory_records_tbl.user,
        inventory_records_tbl.computer_name,
        inventory_records_tbl.department,
        inventory_records_tbl.date_acquired,
        inventory_records_tbl.supplier,
        inventory_records_tbl.serial_number,
        inventory_records_tbl.price,
        inventory_records_tbl.status,
        inventory_disposal_tbl.remarks
        FROM inventory_disposal_tbl
        JOIN inventory_records_tbl ON inventory_disposal_tbl.inventory_id = inventory_records_tbl.id
        WHERE inventory_id = ?";
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
