<?php



header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Get the updated ticket details from the AJAX request
$ticket_id = $_POST['ticket_id'] ?? '';
$ticket_status = $_POST['ticket_status'] ?? '';
$ticket_due_date = $_POST['ticket_due_date'] ?? '';
$ticket_handler_id = $_POST['ticket_handler_id'] ?? $_SESSION['user']['id'];


// Validate input
if (empty($ticket_id) || empty($ticket_status) || empty($ticket_due_date) || empty($ticket_handler_id)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

// Update the ticket details in the database
$query = "UPDATE ticket_records_tbl SET ticket_status = ?, ticket_due_date = ?, ticket_handler_id = ? WHERE ticket_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssss', $ticket_status, $ticket_due_date, $ticket_handler_id, $ticket_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket details updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
