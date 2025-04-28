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

// Get the user's department
$department_sql = "SELECT department FROM accounts_tbl WHERE id = ?";
$department_stmt = $conn->prepare($department_sql);

if ($department_stmt) {
    $department_stmt->bind_param("i", $user_id);
    $department_stmt->execute();
    $department_result = $department_stmt->get_result();

    if ($department_result->num_rows > 0) {
        $user_department = $department_result->fetch_assoc()['department'];
        error_log("User Department: " . $user_department); // Log for debugging
    } else {
        echo json_encode(["status" => "error", "message" => "Unable to fetch user department."]);
        exit;
    }
    $department_stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare department statement.", "data" => $conn->error]);
    exit;
}

// Fetch tickets with status "For Approval" for the same department
$sql = "
    SELECT 
        t.ticket_id, 
        t.ticket_subject, 
        t.ticket_description, 
        t.date_created, 
        t.ticket_priority,
        t.ticket_status, 
        t.date_finished,
        t.ticket_for_approval_due_date,
        t.ticket_attachment, 
        t.ticket_requestor_id,
        t.ticket_handler_id,
        COALESCE(a.full_name, 'No handler assigned') AS handler_name,
        r.full_name AS requestor_name
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a 
        ON t.ticket_handler_id = a.id 
        AND a.department = ?
    LEFT JOIN accounts_tbl AS r
        ON t.ticket_requestor_id = r.id
    WHERE LOWER(t.ticket_status) = 'for approval'
    ORDER BY t.ticket_priority ASC, t.date_created DESC
";


$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("s", $user_department); // Bind the user's department
    $stmt->execute();
    $result = $stmt->get_result();

    $tickets = [];
    while ($row = $result->fetch_assoc()) {
        // Ensure the ticket attachment URL is valid
        $row['ticket_attachment'] = $row['ticket_attachment']
            ? $base_url . basename($row['ticket_attachment'])
            : null;

        // Add the requestor's name
        $tickets[] = $row;
    }

    echo json_encode(["status" => "success", "data" => $tickets]);
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement.", "data" => $conn->error]);
}
