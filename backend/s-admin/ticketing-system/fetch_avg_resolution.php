<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');
date_default_timezone_set('Asia/Manila');

$start_date = $_GET['start_date'] ?? null;
$end_date   = $_GET['end_date'] ?? null;

$query = "SELECT 
            DATE(date_finished) as date, 
            AVG(TIMESTAMPDIFF(SECOND, date_created, date_finished)) as avg_seconds,
            SEC_TO_TIME(AVG(TIMESTAMPDIFF(SECOND, date_created, date_finished))) as avg_time
          FROM ticket_records_tbl
          WHERE ticket_status = 'CLOSED'";

$params = [];
$types  = '';

if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND DATE(date_finished) BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types = "ss";
}

$query .= " GROUP BY DATE(date_finished) ORDER BY DATE(date_finished) ASC";

$stmt = $conn->prepare($query);

if ($types) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    // Force avg_seconds to float (avoid string issues in JS)
    $row['avg_seconds'] = (float) $row['avg_seconds'];
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data"   => $data
]);
