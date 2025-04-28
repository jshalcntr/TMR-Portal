<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

$userId = $_SESSION['user']['id'];

// Get the category from the AJAX request
$category = $_GET['category'] ?? '';

$currentDateTime = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d') . ' 23:59:00';
// Define queries for each category
$query = "";
switch ($category) {
    case 'overdue':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date < '$currentDateTime' AND tr.ticket_handler_id = '$userId'";
        break;
    case 'today-due':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date >= '$currentDateTime' AND tr.ticket_due_date <= '$currentDate' AND tr.ticket_handler_id = '$userId'";
        break;
    case 'open':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date > '$currentDate' AND tr.ticket_handler_id = '$userId'";
        break;
    case 'for-approval':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status = 'for approval'";
        break;
    case 'all-overdue':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date < '$currentDateTime'";
        break;
    case 'all-today-due':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date >= '$currentDateTime' AND tr.ticket_due_date <= '$currentDate'";
        break;
    case 'all-open':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_due_date > '$currentDate'";
        break;
    case 'all-for-approval':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status = 'for approval'";
        break;
    case 'reopen-tickets':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status = 'reopen'";
        break;
    case 'unassigned':
        $query = "SELECT tr.*, a.full_name, a.department FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id WHERE tr.ticket_status != 'closed' AND tr.ticket_status != 'reopen' AND tr.ticket_handler_id IS NULL OR tr.ticket_handler_id = ''";
        break;
    case 'finished':
        $query = "SELECT tr.*, a.full_name AS full_name, a.department AS department, b.full_name AS handler_name FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id LEFT JOIN accounts_tbl b ON tr.ticket_handler_id = b.id WHERE tr.ticket_status = 'closed'";
        break;
    case 'all':
        $query = "SELECT tr.*, a.full_name, a.department FROM ticket_records_tbl tr JOIN accounts_tbl a ON tr.ticket_requestor_id = a.id";
        break;
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid category']);
        exit;
}

// Execute query
$result = $conn->query($query);

if ($result) {
    $tickets = [];
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $tickets]);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}
