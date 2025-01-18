<?php
include('../../dbconn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $ticket_date = date('Y-m-d H:i:s');
    // Fetch the details of the closed ticket
    $sql = "SELECT * FROM ticket_records_tbl WHERE ticket_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ticket = $result->fetch_assoc();
        $stmt->close();

        if ($ticket) {
            // Create a new ticket with the same details
            $sql = "INSERT INTO ticket_records_tbl (ticket_requestor_id, ticket_subject, ticket_type, ticket_description, ticket_handler_id, ticket_conclusion, ticket_status, date_created, ticket_attachment) VALUES (?, ?, ?, ?, ?, ?, 'OPEN', NOW(), ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("issssss", $_SESSION['user']['id'], $ticket['ticket_subject'], $ticket['ticket_type'], $ticket['ticket_description'], $ticket['ticket_handler_id'], $ticket['ticket_conclusion'], $ticket['ticket_attachment']);
                if ($stmt->execute()) {
                    echo json_encode(["status" => "success", "message" => "Ticket recreated successfully."]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to recreate ticket."]);
                }
                $stmt->close();
            } else {
                echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Ticket not found."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement."]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
