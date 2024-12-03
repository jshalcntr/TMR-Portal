<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php'); // Include your MySQLi connection

// Query to fetch ticket counts grouped by department from accounts_tbl
$sql = "
    SELECT 
        a.department AS department, 
        COUNT(t.ticket_id) AS ticket_count
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a ON t.ticket_requestor_id = a.id
    WHERE t.ticket_status = 'closed'
    GROUP BY a.department
    ORDER BY ticket_count DESC
";

$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Query error: ' . $conn->error]);
    exit;
}

// Fetch data and build the response
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'department' => $row['department'] ?? 'Unknown', // Default to 'Unknown' if null
        'ticket_count' => (int)$row['ticket_count']
    ];
}

// Close the connection
$conn->close();

// Return JSON response
echo json_encode(['status' => 'success', 'data' => $data]);
