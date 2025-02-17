<?php

require '../dbconn.php';

$newFA = $_GET['newFA'];

$sql = "SELECT COUNT(*) FROM inventory_records_tbl WHERE fa_number = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Check FA Existence. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("s", $newFA);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Check FA Existence. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    } else {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "exists" => $row['COUNT(*)'] > 0
        ]);
    }
    $stmt->close();
}
