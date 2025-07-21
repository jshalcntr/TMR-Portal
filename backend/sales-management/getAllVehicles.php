<?php

require "../dbconn.php";

$sql = "SELECT * FROM sales_vehicles_tbl";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Vehicles. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Vehicles. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
    } else {
        $vehicles = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $vehicles[] = $row;
        }
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $vehicles
        ]);
        $stmt->close();
    }
}
