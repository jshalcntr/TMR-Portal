<?php
require '../dbconn.php';

date_default_timezone_set('Asia/Manila');

$inventoryId = $_POST['inventoryId'];
$remarks = $_POST['remarks'] ? $_POST['remarks'] : "";
$date = date('Y-m-d');

$sql1 = "INSERT INTO inventory_disposal_tbl (inventory_id, date_added, remarks) VALUES (?, ?, ?)";
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to add to Disposal. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt1->bind_param("iss", $inventoryId, $date, $remarks);
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add to Disposal. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        $sql2 = "UPDATE inventory_records_tbl SET status = 'Under Disposal' WHERE id = ?";
        $stmt2 = $conn->prepare($sql2);

        if (!$stmt2) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to add to Disposal. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("i", $inventoryId);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to add to Disposal. Please Contact the Programmer",
                    "data" => $conn->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Added to Disposal Successfully!",
                ]);
            }
        }
    }
}
