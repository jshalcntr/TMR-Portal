<?php
include('../dbconn.php');

$sql1 = $_POST['requestSql'];
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Accept this request. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Accept this request. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        $requestId = $_POST['requestId'];
        $sql2 = "UPDATE inventory_requests_tbl SET request_status = 'accepted' WHERE request_id = ?";
        $stmt2 = $conn->prepare($sql2);

        if (!$stmt2) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Accept this request. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("i", $requestId);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Accept this request. Please Contact the Programmer",
                    "data" => $stmt2->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Request Accepted and Executed!",
                ]);
            }
        }
    }
}
