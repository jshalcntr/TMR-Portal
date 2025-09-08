<?php
// Set content type and start session
header('Content-Type: application/json');
session_start();
require_once('../../dbconn.php'); // Ensure the DB connection is loaded
date_default_timezone_set('Asia/Manila');

// Get the start and end dates from the request
$startDate = isset($_GET['start_date']) && !empty($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) && !empty($_GET['end_date']) ? $_GET['end_date'] : null;

// Build the base SQL query
$sql = "
    SELECT 
        d.department_name AS department,
        COUNT(t.ticket_id) AS ticket_count
    FROM ticket_records_tbl t
    LEFT JOIN accounts_tbl a ON t.ticket_requestor_id = a.id
    LEFT JOIN departments_tbl d ON a.department = d.department_id
    WHERE 
        t.ticket_status = 'closed'
";

// If dates are provided, add the date filtering condition
if ($startDate && $endDate) {
    $sql .= " AND DATE(t.date_finished) BETWEEN ? AND ?";
}

// Add the grouping and ordering clauses
$sql .= "
    GROUP BY d.department_name
    ORDER BY ticket_count DESC
";

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare($sql);

// Bind parameters only if dates are provided
if ($startDate && $endDate) {
    $stmt->bind_param("ss", $startDate, $endDate);
}

$stmt->execute();
$result = $stmt->get_result();

// Check for errors
if (!$result) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Query error: ' . $conn->error
    ]);
    exit;
}

// Build response data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'department' => $row['department'],
        'ticket_count' => (int) $row['ticket_count']
    ];
}

// Return success response
echo json_encode([
    'status' => 'success',
    'data' => $data
]);

$stmt->close();
$conn->close();
