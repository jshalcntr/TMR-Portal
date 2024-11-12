<?php
require '../../dbconn.php';

$repairDescription = $_POST['repairDescription'];
$gatePassNumber = $_POST['gatepassNumber'];
$repairDate = $_POST['repairDate'];
$inventoryId = $_POST['inventoryId'];

$sql = "INSERT INTO inventory_repairs_tbl (repaired_item, repair_description, gatepass_number, start_date)
VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("isss", $inventoryId, $repairDescription, $gatePassNumber, $repairDate);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        $sql2 = "UPDATE inventory_records_tbl SET status = 'Under Repair' WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2 == false) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Internal Error. Please Contact MIS",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("i", $inventoryId);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Internal Error. Please Contact MIS",
                    "data" => $stmt2->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Item Repaired Successfully!"
                ]);
            }
        }
    }
}
