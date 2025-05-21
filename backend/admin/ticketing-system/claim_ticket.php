<?php

header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Get the updated ticket details from the AJAX request
$ticket_id = $_POST['ticket_id'] ?? '';
$ticket_status = $_POST['ticket_status'] ?? '';
$ticket_priority = $_POST['ticket_priority'] ?? 'NORMAL'; // Default to NORMAL
$ticket_handler_id = $_POST['ticket_handler_id'] ?? $_SESSION['user']['id'];
$for_approval_reason = $_POST['for_approval_reason'] ?? null;
$current_datetime = date('Y-m-d H:i:s');

// Validate input
if (empty($ticket_id) || empty($ticket_status) || empty($ticket_handler_id)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

// Step 1: Check if ticket_handler_id is already assigned
$checkQuery = "SELECT tr.ticket_handler_id, a.full_name 
               FROM ticket_records_tbl tr 
               LEFT JOIN accounts_tbl a ON tr.ticket_handler_id = a.id 
               WHERE tr.ticket_id = ?";
$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param('s', $ticket_id);
$checkStmt->execute();
$checkStmt->bind_result($existing_handler_id, $existing_handler_name);
$checkStmt->fetch();
$checkStmt->close();

if (!empty($existing_handler_id) && $existing_handler_id !== $ticket_handler_id) {
    echo json_encode([
        'status' => 'error',
        'message' => "Ticket already claimed by $existing_handler_name"
    ]);
    exit;
}

// Initialize due dates
$ticket_due_date = null;
$ticket_for_approval_due_date = null;
$date_accepted = null;

// Set due dates based on status and priority
if (strtoupper($ticket_status) === 'FOR APPROVAL') {
    switch (strtoupper($ticket_priority)) {
        case 'CRITICAL':
            $hoursToAdd = 4;
            break;
        case 'IMPORTANT':
            $hoursToAdd = 8;
            break;
        default:
            $hoursToAdd = 24;
            break;
    }
    $ticket_for_approval_due_date = date('Y-m-d H:i:s', strtotime("+$hoursToAdd hours"));
    $date_accepted = $current_datetime;
} elseif (strtoupper($ticket_status) === 'OPEN') {
    switch (strtoupper($ticket_priority)) {
        case 'CRITICAL':
            $hoursToAdd = 4;
            break;
        case 'IMPORTANT':
            $hoursToAdd = 8;
            break;
        default:
            $hoursToAdd = 24;
            break;
    }
    $ticket_due_date = date('Y-m-d H:i:s', strtotime("+$hoursToAdd hours"));
    $date_accepted = $current_datetime;
}

$attachment_filename = null;

if (isset($_FILES['for_approval_attachment']) && $_FILES['for_approval_attachment']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../../uploads/for_approval/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $originalName = basename($_FILES['for_approval_attachment']['name']);
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $safeFilename = uniqid('attach_') . '.' . $ext;
    $uploadPath = $uploadDir . $safeFilename;

    if (move_uploaded_file($_FILES['for_approval_attachment']['tmp_name'], $uploadPath)) {
        $attachment_filename = $safeFilename;
    }
}
// Step 2: Update the ticket details (with reason for approval if applicable)
$updateQuery = "UPDATE ticket_records_tbl 
                SET ticket_status = ?, 
                    ticket_due_date = ?, 
                    ticket_for_approval_due_date = ?, 
                    ticket_handler_id = ?, 
                    date_accepted = ?, 
                    ticket_priority = ?, 
                    for_approval_reason = ?, 
                    for_approval_attachment = ?
                WHERE ticket_id = ?";
$updateStmt = $conn->prepare($updateQuery);
$updateStmt->bind_param(
    'sssssssss',
    $ticket_status,
    $ticket_due_date,
    $ticket_for_approval_due_date,
    $ticket_handler_id,
    $date_accepted,
    $ticket_priority,
    $for_approval_reason,
    $attachment_filename,
    $ticket_id
);

if ($updateStmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket details updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$updateStmt->close();
$conn->close();
