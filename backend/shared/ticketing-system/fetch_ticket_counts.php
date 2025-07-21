<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

$userId = $_SESSION['user']['id'];
$userRole = $_SESSION['user']['role'];
$departmentId = $_SESSION['user']['department']; // Already in session

$currentDateTime = date('Y-m-d H:i:s');

// Define queries depending on the user role
if ($userRole === 'ADMIN') {
    // Admin: No department filter
    $sql = [
        'open' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                   WHERE ticket_status != 'closed' 
                   AND ticket_status != 'reopen'",

        'for_approval' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                           WHERE ticket_status = 'for approval'",

        'closed' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                     WHERE ticket_status = 'closed'"
    ];
} else {
    // Regular users: Filter by department
    $sql = [
        'open' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                   WHERE ticket_status != 'closed' 
                   AND ticket_status != 'reopen' 
                   AND requestor_department = '$departmentId'",

        'for_approval' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                           WHERE ticket_status = 'for approval' 
                           AND requestor_department = '$departmentId'",

        'closed' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl 
                     WHERE ticket_status = 'closed'  
                     AND requestor_department = '$departmentId'"
    ];
}

$data = [];

// Execute each query
foreach ($sql as $key => $query) {
    $result = $conn->query($query);
    if ($result) {
        $row = $result->fetch_assoc();
        $data[$key] = $row['count'];
    } else {
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
        exit;
    }
}

// Return the data
echo json_encode([
    'status' => 'success',
    'data' => $data,
    'currentDateTime' => $currentDateTime
]);
