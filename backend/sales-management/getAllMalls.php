<?php

require "../dbconn.php";

$sql = "SELECT * FROM sales_malls_tbl";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Malls. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Malls. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
    } else {
        $malls = [];
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $malls[] = $row;
        }
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $malls
        ]);
        $stmt->close();
    }
}