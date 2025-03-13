<?php
session_start();
header('Content-Type: application/json');
include('../../dbconn.php');

$ticket_id = $_GET['ticket_id'] ?? '';
$user_id = $_SESSION['user']['id'];


if (empty($ticket_id)) {
    echo json_encode(['status' => 'error', 'message' => 'Ticket ID is required']);
    exit;
}

$query = "
    SELECT 
        tc.id, 
        tc.ticket_id, 
        tc.ticket_user_id, 
        tc.ticket_messages, 
        tc.ticket_convo_date, 
        tc.is_read,
        a.full_name 
    FROM 
        ticket_convo_tbl tc 
    JOIN 
        accounts_tbl a 
    ON 
        tc.ticket_user_id = a.id 
    WHERE 
        tc.ticket_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $ticket_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

// Update messages to read
$update_query = "UPDATE ticket_convo_tbl SET is_read = 1 WHERE ticket_id = ? AND ticket_user_id != ?";
$update_stmt = $conn->prepare($update_query);
$update_stmt->bind_param('ss', $ticket_id, $user_id);
$update_stmt->execute();

echo json_encode(['status' => 'success', 'data' => $messages]);

$stmt->close();
$update_stmt->close();
$conn->close();
