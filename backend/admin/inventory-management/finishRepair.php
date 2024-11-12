<?php
require '../../dbconn.php';
date_default_timezone_set("Asia/Manila");

$repairId = $_POST['repairId'];
$inventoryId = $_POST['inventoryId'];
$endDate = $_POST['date_repaired'];
$remarks = $_POST['repair_remarks'];

$sql = "UPDATE inventory_repairs_tbl SET end_date = ?, remarks = ? WHERE repair_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("ssi", $endDate, $remarks, $repairId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        $sql2 = "UPDATE inventory_records_tbl SET status = 'Repaired' WHERE id = ?";
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
                    "message" => "Item Finished Repairing!"
                ]);
            }
        }
    }
}
