<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

$userId = $_SESSION['user']['id'];
// Get today's date
$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d') . ' 23:59:00';

// Queries for each category
$sql = [
    'overdue' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_status != 'reopen' AND ticket_due_date < '$currentDateTime' AND ticket_handler_id = '$userId'",
    'today_due' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_due_date >= '$currentDateTime' AND ticket_due_date <= '$currentDate' AND ticket_handler_id = '$userId'",
    'open' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_due_date > '$currentDate' AND ticket_handler_id = '$userId'",
    'for_approval' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status = 'for approval'",
    'finished' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status = 'closed'",
    'unassigned' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_handler_id IS NULL OR ticket_handler_id = ''",
    'all_overdue' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_status != 'reopen' AND ticket_due_date < '$currentDateTime'",
    'all_today_due' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_status != 'reopen' AND ticket_due_date >= '$currentDateTime' AND ticket_due_date <= '$currentDate'",
    'all_open' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status != 'closed' AND ticket_status != 'reopen' AND ticket_due_date > '$currentDate'",
    'all_for_approval' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status = 'for approval'",
    'all_reopen' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl WHERE ticket_status = 'reopen'",
    'all' => "SELECT COUNT(ticket_id) AS count FROM ticket_records_tbl"
];

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

// Return the data as JSON
echo json_encode(['status' => 'success', 'data' => $data, 'currentDate' => $currentDate, 'currentDateTime' => $currentDateTime]);
