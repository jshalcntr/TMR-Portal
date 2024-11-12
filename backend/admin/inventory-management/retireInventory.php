<?php
include('../../dbconn.php');

$id = $_POST['id'];
$status = 'Retired';

$sql = "UPDATE inventory_records_tbl SET status = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("si", $status, $id);
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
            "message" => "Inventory Retired Successfully!",
        ]);
    }
}
