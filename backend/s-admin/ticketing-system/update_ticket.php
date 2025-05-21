<?php

header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Get the updated ticket details from the AJAX request
$ticket_id = $_POST['ticket_id'] ?? '';
$ticket_status = $_POST['ticket_status'] ?? '';
$ticket_priority = $_POST['ticket_priority'] ?? 'NORMAL'; // Default to NORMAL
$ticket_handler_id = $_POST['ticket_handler_id'] ?? $_SESSION['user']['id'];
$current_datetime = date('Y-m-d H:i:s');

// Validate input
if (empty($ticket_id) || empty($ticket_status) || empty($ticket_handler_id)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

// Initialize due dates
$ticket_due_date = null;
$ticket_for_approval_due_date = null;
$date_accepted = null;

// Set due dates based on status and priority
if ($ticket_status === 'FOR APPROVAL') {
    // Determine due date based on priority
    switch (strtoupper($ticket_priority)) {
        case 'CRITICAL':
            $hoursToAdd = 4;
            break;
        case 'IMPORTANT':
            $hoursToAdd = 8;
            break;
        case 'NORMAL':
        default:
            $hoursToAdd = 24;
            break;
    }

    $ticket_for_approval_due_date = date('Y-m-d H:i:s', strtotime("+$hoursToAdd hours"));
    $date_accepted = $current_datetime;
} elseif ($ticket_status === 'OPEN') {
    // Determine due date based on priority
    switch (strtoupper($ticket_priority)) {
        case 'CRITICAL':
            $hoursToAdd = 4;
            break;
        case 'IMPORTANT':
            $hoursToAdd = 8;
            break;
        case 'NORMAL':
        default:
            $hoursToAdd = 24;
            break;
    }

    $ticket_due_date = date('Y-m-d H:i:s', strtotime("+$hoursToAdd hours"));
    $date_accepted = $current_datetime;
}

// Update the ticket details in the database
$query = "UPDATE ticket_records_tbl 
          SET ticket_status = ?, 
            ticket_due_date = ?, 
            ticket_for_approval_due_date = ?, 
            ticket_handler_id = ?, 
            date_accepted = ?, 
            ticket_priority = ?
          WHERE ticket_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('sssssss', $ticket_status, $ticket_due_date, $ticket_for_approval_due_date, $ticket_handler_id, $date_accepted, $ticket_priority, $ticket_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket details updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
