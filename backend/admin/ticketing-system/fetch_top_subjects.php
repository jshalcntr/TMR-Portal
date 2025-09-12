<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');
date_default_timezone_set('Asia/Manila');

$start_date = $_GET['start_date'] ?? null;
$end_date   = $_GET['end_date'] ?? null;

$query = "SELECT ticket_subject, COUNT(*) as subject_count
          FROM ticket_records_tbl
          WHERE ticket_status = 'CLOSED'";

$params = [];
$types  = "";

if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND DATE(date_finished) BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types = "ss";
}

$query .= " GROUP BY ticket_subject
            ORDER BY subject_count DESC
            LIMIT 5";

$stmt = $conn->prepare($query);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);
