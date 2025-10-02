<?php
session_start();
include('../dbconn.php');

header('Content-Type: application/json');

$sql = "SELECT prospect_type, COUNT(*) as count
        FROM sales_inquiries_history_tbl
        JOIN 
            (SELECT inquiry_id, MAX(version) as max_version
                FROM sales_inquiries_history_tbl
                GROUP BY inquiry_id) latest
            ON sales_inquiries_history_tbl.inquiry_id = latest.inquiry_id AND sales_inquiries_history_tbl.version = latest.max_version
        JOIN sales_inquiries_tbl
            ON sales_inquiries_history_tbl.inquiry_id = sales_inquiries_tbl.inquiry_id
        WHERE prospect_type IN ('HOT', 'WARM', 'COLD', 'LOST')
            AND sales_inquiries_tbl.agent_id = ? GROUP BY prospect_type;";

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
