<?php

header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

// Set timezone
date_default_timezone_set('Asia/Manila');

// Get current year and month
$year = date('Y');
$month = date('m');

// Get number of days in the current month
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Generate list of dates for the whole month
$allDates = [];
for ($day = 1; $day <= $daysInMonth; $day++) {
    $date = date('Y-m-d', strtotime("$year-$month-$day"));
    $allDates[$date] = 0;
}

// Query closed tickets grouped by date
$query = "
    SELECT 
        DATE(date_finished) AS date, 
        COUNT(*) AS ticket_count 
    FROM 
        ticket_records_tbl 
    WHERE 
        LOWER(ticket_status) = 'closed' 
        AND YEAR(date_finished) = '$year' 
        AND MONTH(date_finished) = '$month'
    GROUP BY 
        DATE(date_finished)
";

$result = $conn->query($query);

// Update counts where applicable
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $allDates[$row['date']] = (int)$row['ticket_count'];
    }
}

// Format final data
$data = [];
foreach ($allDates as $date => $count) {
    $data[] = [
        'date' => $date,
        'ticket_count' => $count
    ];
}

echo json_encode(['status' => 'success', 'data' => $data]);
