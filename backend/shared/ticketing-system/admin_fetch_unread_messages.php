<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

$user_id = $_SESSION['user']['id'] ?? '';

if (empty($user_id)) {
    echo json_encode(['status' => 'error', 'message' => 'User ID is required']);
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
        tc.ticket_requestor_id,
        a.full_name, 
        a.profile_picture, 
        tr.ticket_handler_id,
        tr.ticket_subject
    FROM 
        ticket_convo_tbl tc 
    JOIN 
        accounts_tbl a ON tc.ticket_user_id = a.id 
    JOIN 
        ticket_records_tbl tr ON tc.ticket_id = tr.ticket_id 
    WHERE 
        tc.is_read = '0' 
        AND tc.ticket_user_id != ? 
        AND tr.ticket_handler_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param('ss', $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'data' => $messages]);

$stmt->close();
$conn->close();
