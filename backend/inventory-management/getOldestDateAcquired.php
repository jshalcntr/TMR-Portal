<?php
include('../dbconn.php');

$getOldestDateSql = "SELECT MIN(date_acquired) AS oldest_date FROM inventory_records_tbl";
$stmt = $conn->prepare($getOldestDateSql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Faile to Fetch Oldest Date. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "error",
            "message" => "Faile to Fetch Oldest Date. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $oldestDate;
        $oldestDateResult = $stmt->get_result();
        while ($row = $oldestDateResult->fetch_assoc()) {
            $oldestDate = $row['oldest_date'];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode($oldestDate);
    }
}
