<?php
header('Content-Type: application/json');
session_start();
require_once('../../dbconn.php'); // Ensure the DB connection is loaded

// Query: Count of closed tickets grouped by department name (from accounts_tbl)
$sql = "
    SELECT 
        d.department_name AS department,
        COUNT(t.ticket_id) AS ticket_count
    FROM ticket_records_tbl t
    LEFT JOIN accounts_tbl a ON t.ticket_requestor_id = a.id
    LEFT JOIN departments_tbl d ON a.department = d.department_id
    WHERE t.ticket_status = 'closed'
    GROUP BY d.department_name
    ORDER BY ticket_count DESC
";

$result = $conn->query($sql);

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

$conn->close();
