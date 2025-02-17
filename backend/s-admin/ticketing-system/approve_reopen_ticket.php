<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$ticket_id = $_POST['ticket_id'];
$reopen_reason_description = $_POST['reopen_reason_description'];
$action = $_POST['action'];

// Fetch the existing description
$sql = "SELECT ticket_description FROM ticket_records_tbl WHERE ticket_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ticket_id);
$stmt->execute();
$result = $stmt->get_result();
$existing_description = $result->fetch_assoc()['ticket_description'];
$stmt->close();

// Append the new description to the existing one
$new_description = $existing_description . "\n\nReopen Reason: " . $reopen_reason_description;

if ($action === 'approve') {
    // Update the ticket with the new description and set status to REOPEN
    $sql = "UPDATE ticket_records_tbl SET ticket_description = ?, ticket_status = 'REOPEN' WHERE ticket_id = ?";
} else {
    // Update the ticket with the new description and set status to REJECTED
    $sql = "UPDATE ticket_records_tbl SET ticket_description = ?, ticket_status = 'REJECTED' WHERE ticket_id = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $new_description, $ticket_id);
if ($stmt->execute()) {
    echo json_encode(["status" => "success", "message" => "Ticket updated successfully."]);
} else {
    echo json_encode(["status" => "error", "message" => "Error updating ticket."]);
}
$stmt->close();
