<?php
header('Content-Type: application/json');
include('../../dbconn.php');

$ticket_id = $_POST['ticket_id'] ?? '';

if (empty($ticket_id)) {
    echo json_encode(['exists' => false, 'message' => 'Ticket ID is required']);
    exit;
}

$query = "SELECT COUNT(*) as count FROM ticket_convo_tbl WHERE ticket_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $ticket_id);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();

$response = ['exists' => $count > 0];

echo json_encode($response);

$stmt->close();
$conn->close();
