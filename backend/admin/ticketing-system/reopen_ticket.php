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
$changes_description = $_POST['changes_description'];
$ticket_status = "REOPEN";

// Update the ticket with the changes description and status
$sql = "UPDATE ticket_records_tbl SET ticket_changes_description = ?, ticket_status = ? WHERE ticket_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssi", $changes_description, $ticket_status, $ticket_id);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Ticket updated successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating ticket."]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement.", "data" => $conn->error]);
}
