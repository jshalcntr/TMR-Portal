<?php
require '../dbconn.php';

$sql = "SELECT DISTINCT item_category FROM inventory_records_tbl WHERE item_type = 'Accessories'";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Categories. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Categories. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $category = [];
        $categoryResult = $stmt->get_result();
        while ($row = $categoryResult->fetch_assoc()) {
            $category[] = $row;
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $category
        ]);
    }
}
