<?php
require '../../dbconn.php';

$repairDescription = $_POST['repairDescription'];
$gatePassNumber = $_POST['gatepassNumber'];
$repairDate = $_POST['repairDate'];
$repairId = $_POST['repairId'];

$sql = "UPDATE inventory_repairs_tbl SET repair_description = ?, gatepass_number = ?, start_date = ? WHERE repair_id = ?";
$stmt = $conn->prepare($sql);
if ($stmt == false) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("sssi", $repairDescription, $gatePassNumber, $repairDate, $repairId);
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
            "message" => "Item Repair Edited Successfully!"
        ]);
    }
}
