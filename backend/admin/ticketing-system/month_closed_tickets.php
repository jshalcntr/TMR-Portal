<?php
// Set content type and start session
header('Content-Type: application/json');
session_start();
// IMPORTANT: You need to ensure dbconn.php is located correctly for this to work.
include('../../dbconn.php');
date_default_timezone_set('Asia/Manila');

// Get the start and end dates from the request.
$startDate = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : null;

// Build the base SQL query
$query = "
    SELECT 
        DATE(date_finished) as date, 
        COUNT(*) as ticket_count
    FROM 
        ticket_records_tbl
    WHERE 
        ticket_status = 'closed'
";

// If dates are provided, add the date filtering condition
if ($startDate && $endDate) {
    $query .= " AND DATE(date_finished) BETWEEN ? AND ?";
}

// Add the grouping and ordering clauses
$query .= "
    GROUP BY 
        DATE(date_finished)
    ORDER BY 
        DATE(date_finished) ASC
";

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare($query);

// Bind parameters only if dates are provided
if ($startDate && $endDate) {
    $stmt->bind_param("ss", $startDate, $endDate);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'date' => $row['date'],
            'ticket_count' => (int)$row['ticket_count']
        ];
    }
}

echo json_encode(['status' => 'success', 'data' => $data]);
$stmt->close();
$conn->close();
