<?php
header('Content-Type: application/json');
session_start();
date_default_timezone_set('Asia/Manila');

error_reporting(E_ALL);
ini_set('display_errors', 0);

function sendError($message)
{
    echo json_encode([
        "status" => "error",
        "message" => $message
    ]);
    exit;
}

if (!file_exists('../../dbconn.php')) {
    sendError("Database config not found");
}
include('../../dbconn.php');

$start_date = $_GET['start_date'] ?? null;
$end_date   = $_GET['end_date'] ?? null;

$query = "SELECT AVG(TIMESTAMPDIFF(SECOND, date_created, date_accepted)) AS avg_seconds
FROM ticket_records_tbl
WHERE ticket_status = 'CLOSED'
  AND TIME(date_created) BETWEEN '07:00:00' AND '17:30:00'
  AND DATE(date_created) = DATE(date_accepted)";  // ✅ only between 7am–5:30pm

$params = [];
$types  = '';

if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND DATE(date_accepted) BETWEEN ? AND ?";
    $params[] = $start_date;
    $params[] = $end_date;
    $types = "ss";
}

$stmt = $conn->prepare($query);
if (!$stmt) {
    sendError($conn->error);
}

if ($types) {
    $stmt->bind_param($types, ...$params);
}

if (!$stmt->execute()) {
    sendError($stmt->error);
}

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$avg_time = "N/A";
if ($row && $row['avg_seconds'] !== null) {
    $seconds = (int) round($row['avg_seconds']);
    $hours   = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);

    if ($hours > 0 && $minutes > 0) {
        $avg_time = "{$hours} hr" . ($hours > 1 ? "s" : "") . " {$minutes} min" . ($minutes > 1 ? "s" : "");
    } elseif ($hours > 0) {
        $avg_time = "{$hours} hr" . ($hours > 1 ? "s" : "");
    } elseif ($minutes > 0) {
        $avg_time = "{$minutes} min" . ($minutes > 1 ? "s" : "");
    } else {
        $avg_time = "Less than a minute";
    }
}

echo json_encode([
    "status" => "success",
    "average_response_time" => $avg_time
]);
