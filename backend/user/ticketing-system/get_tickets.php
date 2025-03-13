<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

// Detect base URL dynamically
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$base_path = dirname(dirname(dirname($_SERVER['PHP_SELF'])));
$base_url = $protocol . "://" . $host . $base_path . "/uploads/tickets/";

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$user_id = $_SESSION['user']['id'];

// SQL queries for fetching tickets
$sql_pending = "
    SELECT 
        t.ticket_id, 
        t.ticket_subject, 
        t.ticket_description, 
        t.ticket_status, 
        t.date_created, 
        t.ticket_attachment, 
        a.full_name AS handler_name
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a ON t.ticket_handler_id = a.id
    WHERE t.ticket_status != 'Closed' AND t.ticket_status != 'Cancelled' AND t.ticket_requestor_id = ?
    ORDER BY t.date_created DESC
";

$sql_closed = "
    SELECT 
        t.ticket_id, 
        t.ticket_subject, 
        t.ticket_description, 
        t.ticket_status, 
        t.date_created, 
        t.ticket_attachment, 
        t.ticket_handler_id, 
        a.full_name AS handler_name
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a ON t.ticket_handler_id = a.id
    WHERE t.ticket_status = 'Closed' AND t.ticket_requestor_id = ?
    ORDER BY t.date_created DESC
";

// Function to execute a query and format the result
function fetch_tickets($conn, $sql, $user_id, $base_url)
{
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ["error" => true, "message" => $conn->error];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $tickets = [];
    while ($row = $result->fetch_assoc()) {
        // Append the base URL to ticket attachments
        $row['ticket_attachment'] = $row['ticket_attachment']
            ? $base_url . basename($row['ticket_attachment'])
            : null;

        $tickets[] = $row;
    }

    $stmt->close();
    return ["error" => false, "data" => $tickets];
}

// Fetch pending and closed tickets
$pending_tickets = fetch_tickets($conn, $sql_pending, $user_id, $base_url);
$closed_tickets = fetch_tickets($conn, $sql_closed, $user_id, $base_url);

// Check for errors
if ($pending_tickets['error'] || $closed_tickets['error']) {
    echo json_encode([
        "status" => "error",
        "message" => $pending_tickets['message'] ?? $closed_tickets['message']
    ]);
    exit;
}

// Return results
echo json_encode([
    "status" => "success",
    "data" => [
        "pending" => $pending_tickets['data'],
        "closed" => $closed_tickets['data']
    ]
]);

$conn->close();
