<?php
require('../dbconn.php');
require('../middleware/pipes.php');

$disposedSql = "SELECT * FROM inventory_disposed_tbl";

$stmt = $conn->prepare($disposedSql);

if ($stmt == false) {
    header("Content-type: application/json");
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Inventory. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Inventory. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $disposedResult = $stmt->get_result();
        $disposed = [];
        while ($disposedRow = $disposedResult->fetch_assoc()) {
            $disposedId = $disposedRow['disposed_id'];
            $disposedDate = $disposedRow['disposed_date'];
            $scannedFile = $disposedRow['scanned_form_file'];

            $disposed[] = [
                "disposedId" => $disposedId,
                "disposedDateReadable" => convertToReadableDate($disposedDate),
                "disposedDate" => $disposedDate,
                "scannedFile" => $scannedFile,
            ];
        }
        header("Content-type: application/json");
        echo json_encode([
            "data" => $disposed
        ]);
    }
}
