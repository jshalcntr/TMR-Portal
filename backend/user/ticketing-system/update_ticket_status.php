<?php
include('../../dbconn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['status'];

    $sql = "UPDATE ticket_records_tbl SET ticket_status = ? WHERE ticket_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si", $new_status, $ticket_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ticket status updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update ticket status."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement."]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
