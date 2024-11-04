<?php
include('../../dbconn.php');

$getItemTypesSql = "SELECT DISTINCT item_type FROM inventory_records_tbl";
$stmt = $conn->prepare($getItemTypesSql);

if ($stmt == false) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Date Required. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "error",
            "message" => "Failed to fetch Date Required. Please Contact MIS",
            "data" => $conn->error
        ]);
        $stmt->close();
        exit;
    } else {
        $itemTypes = [];
        $itemTypesResult = $stmt->get_result();
        while ($row = $itemTypesResult->fetch_assoc()) {
            $itemTypes[] = $row['item_type'];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode($itemTypes);
    }
}
