<?php
include('../../dbconn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'] ?? null;
    $new_status = $_POST['status'] ?? null;

    if (!$ticket_id || !$new_status) {
        echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
        exit;
    }

    // Set due dates based on ticket status
    $ticket_due_date = $date_approved = null;
    if ($new_status === 'Approved') {
        $ticket_due_date = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $date_approved = date('Y-m-d H:i:s');
    }

    $sql = "UPDATE ticket_records_tbl 
            SET ticket_status = ?, ticket_due_date = ?, ticket_date_approved = ? 
            WHERE ticket_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssi", $new_status, $ticket_due_date, $date_approved, $ticket_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ticket status updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to execute statement: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
