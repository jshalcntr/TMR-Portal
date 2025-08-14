<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');
date_default_timezone_set('Asia/Manila');

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

// Default to current month if no date provided
if (!$startDate || !$endDate) {
    $year = date('Y');
    $month = date('m');
    $startDate = "$year-$month-01";
    $endDate = date("Y-m-t", strtotime($startDate));
}

// Generate full date range
$period = new DatePeriod(
    new DateTime($startDate),
    new DateInterval('P1D'),
    (new DateTime($endDate))->modify('+1 day')
);

$allDates = [];
foreach ($period as $date) {
    $formatted = $date->format("Y-m-d");
    $allDates[$formatted] = 0;
}

// Query closed tickets
$query = "
    SELECT 
        DATE(date_finished) AS date, 
        COUNT(*) AS ticket_count 
    FROM 
        ticket_records_tbl 
    WHERE 
        LOWER(ticket_status) = 'closed' 
        AND DATE(date_finished) BETWEEN '$startDate' AND '$endDate'
    GROUP BY 
        DATE(date_finished)
";

$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allDates[$row['date']] = (int)$row['ticket_count'];
    }
}

// Final output
$data = [];
foreach ($allDates as $date => $count) {
    $data[] = [
        'date' => $date,
        'ticket_count' => $count
    ];
}

echo json_encode(['status' => 'success', 'data' => $data]);
