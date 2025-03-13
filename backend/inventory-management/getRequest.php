<?php
require '../dbconn.php';

$requestId = $_GET['requestId'];
$sql = "SELECT inventory_requests_tbl.*, 
        accounts_tbl.full_name,
        accounts_tbl.profile_picture,
        inventory_records_tbl.item_category,
        inventory_records_tbl.fa_number,
        inventory_records_tbl.computer_name
        FROM inventory_requests_tbl
        JOIN accounts_tbl ON inventory_requests_tbl.requestor_id = accounts_tbl.id
        JOIN inventory_records_tbl ON inventory_requests_tbl.requested_asset_id = inventory_records_tbl.id
        WHERE request_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Fetch Request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $requestId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Fetch Request. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $request = [];
        $requestResult = $stmt->get_result();
        while ($row = $requestResult->fetch_assoc()) {
            $request[] = $row;
        }
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $request
        ]);
    }
}
