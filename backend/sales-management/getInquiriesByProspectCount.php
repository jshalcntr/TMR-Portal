<?php
session_start();
include('../dbconn.php');

header('Content-Type: application/json');

$sql = "SELECT prospect_type, COUNT(*) as count 
        FROM sales_inquiries_tbl 
        WHERE prospect_type IN ('Hot', 'Warm', 'Cold', 'Lost') AND agent_id = ?
        GROUP BY prospect_type";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Inquiries. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $_SESSION['user']['id']);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inquiries. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);
    }
}
