<?php

require('../../dbconn.php');
require('../../middleware/pipes.php');

$disposedId = $_GET['disposedId'];

$getDisposedItemsSql = "SELECT
                        inventory_records_tbl.fa_number,
                        inventory_records_tbl.item_type,
                        inventory_records_tbl.user,
                        inventory_records_tbl.department
                        FROM inventory_disposed_items_tbl
                        JOIN inventory_records_tbl ON inventory_disposed_items_tbl.inventory_id = inventory_records_tbl.id
                        WHERE inventory_disposed_items_tbl.disposed_id = ?";

$stmt = $conn->prepare($getDisposedItemsSql);
if (!$stmt) {
    header("Content-type: application/json");
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $disposedId);
    if (!$stmt->execute()) {
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inventory. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        $disposedItemsResult = $stmt->get_result();
        $disposedItems = [];
        while ($disposedItemsRow = $disposedItemsResult->fetch_assoc()) {
            $faNumber = $disposedItemsRow['fa_number'];
            $itemType = $disposedItemsRow['item_type'];
            $user = $disposedItemsRow['user'];
            $department = $disposedItemsRow['department'];

            $disposedItems[] = [
                "faNumber" => $faNumber == true ? $faNumber : "N/A",
                "itemType" => $itemType,
                "user" => $user,
                "department" => $department
            ];
        }

        echo json_encode([
            "status" => "success",
            "message" => "Inventory Fetched Successfully",
            "data" => $disposedItems
        ]);
    }
}
