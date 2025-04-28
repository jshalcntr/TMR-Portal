<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Validate request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

$ticketId = $_POST['ticket_id'] ?? null;
$newHandlerId = $_POST['handler_id'] ?? null;
$reassignedBy = $_SESSION['user']['id'] ?? null;

// Basic validation
if (!$ticketId || !$newHandlerId) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Optional: You can add logic here to check if the new handler exists
$handlerCheck = $conn->prepare("SELECT id FROM accounts_tbl WHERE id = ?");
$handlerCheck->bind_param('i', $newHandlerId);
$handlerCheck->execute();
$result = $handlerCheck->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Selected handler does not exist']);
    exit;
}
$handlerCheck->close();

// Update the ticket's handler
$stmt = $conn->prepare("UPDATE ticket_records_tbl SET ticket_handler_id = ? WHERE ticket_id = ?");
$stmt->bind_param('is', $newHandlerId, $ticketId);

if ($stmt->execute()) {
    // echo json_encode(['status' => 'success', 'message' => 'Ticket reassigned successfully']);
    echo json_encode([
        'status' => 'success',
        'ticket_id' => $ticketId,
        'handler_id' => $newHandlerId,
        'message' => 'Ticket reassigned successfully'
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to reassign ticket: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
