<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

$ticket_id = $_POST['ticket_id'] ?? '';
$message = $_POST['message'] ?? '';
$handler_id = $_POST['requestor'] ?? '';
$user_id = $_SESSION['user']['id'] ?? '';

if (empty($ticket_id) || empty($message) || empty($handler_id) || empty($user_id)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

$ticket_convo_date = date('Y-m-d H:i:s');

$query = "INSERT INTO ticket_convo_tbl (ticket_id, ticket_user_id, ticket_messages, ticket_convo_date, ticket_requestor_id, ticket_handler_id) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssssss', $ticket_id, $user_id, $message, $ticket_convo_date, $user_id, $handler_id);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
