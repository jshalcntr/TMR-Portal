<?php
include('../dbconn.php');

$requestId = $_POST['requestId'];
$sql1 = "UPDATE inventory_requests_tbl SET request_status = 'declined' WHERE request_id = ?";
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Decline this request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt1->bind_param("i", $requestId);
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Decline this request. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        $sql2 = "SELECT requestor_id, request_name, requested_asset_id FROM inventory_requests_tbl WHERE request_id = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Decline this request. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("i", $requestId);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Decline this request. Please Contact the Programmer",
                    "data" => $stmt2->error
                ]);
            } else {
                $result = $stmt2->get_result();
                $row = $result->fetch_assoc();
                $requestorId = $row['requestor_id'];
                $requestType = $row['request_name'];
                $requestedAsset = $row['requested_asset_id'];
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Request Declined!",
                    "data" => [
                        "requestType" => $requestType,
                        "requestorId" => $requestorId,
                        "requestedAsset" => $requestedAsset
                    ]
                ]);
            }
        }
    }
}
