<?php

require('../../dbconn.php');
require('../../middleware/pipes.php');

$forDisposalSql = "SELECT 
                    inventory_records_tbl.id,
                    inventory_records_tbl.fa_number,
                    inventory_records_tbl.item_type,
                    inventory_records_tbl.user,
                    inventory_records_tbl.department,
                    inventory_disposal_tbl.date_added,
                    inventory_disposal_tbl.remarks
                    FROM inventory_records_tbl
                    JOIN inventory_disposal_tbl ON inventory_records_tbl.id = inventory_disposal_tbl.inventory_id
                    WHERE inventory_disposal_tbl.isDisposed = 0";

$stmt = $conn->prepare($forDisposalSql);

if ($stmt == false) {
    header("Content-type: application/json");
    echo json_encode([
        "status" => "internal-error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inventory. Please Contact MIS",
            "data" => $stmt->error
        ]);
    } else {
        $forDisposalResult = $stmt->get_result();
        $forDisposal = [];
        while ($forDisposalRow = $forDisposalResult->fetch_assoc()) {
            $id = $forDisposalRow['id'];
            $faNumber = $forDisposalRow['fa_number'];
            $itemType = $forDisposalRow['item_type'];
            $user = $forDisposalRow['user'];
            $department = $forDisposalRow['department'];
            $dateRetired = $forDisposalRow['date_added'];
            $remarks = $forDisposalRow['remarks'];

            $forDisposal[] = [
                "id" => $id,
                "faNumber" => $faNumber == true ? $faNumber : "N/A",
                "itemType" => $itemType,
                "user" => $user,
                "department" => $department,
                "dateRetired" => $dateRetired,
                "dateRetiredReadable" => convertToReadableDate($dateRetired),
                "remarks" => $remarks ? $remarks : "No Remarks"
            ];
        }
        header("Content-type: application/json");
        echo json_encode([
            "data" => $forDisposal
        ]);
    }
}
