<?php
header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

// Check if the user is logged in
if (!isset($_SESSION['user']['id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit;
}

$user_id = $_SESSION['user']['id'];

// Fetch user department
$department_sql = "SELECT department FROM accounts_tbl WHERE id = ?";
$department_stmt = $conn->prepare($department_sql);

if ($department_stmt) {
    $department_stmt->bind_param("i", $user_id);
    $department_stmt->execute();
    $department_result = $department_stmt->get_result();

    if ($department_result->num_rows > 0) {
        $user_department = $department_result->fetch_assoc()['department'];
    } else {
        echo json_encode(["status" => "error", "message" => "Unable to fetch user department."]);
        exit;
    }
    $department_stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare department statement.", "data" => $conn->error]);
    exit;
}

// SQL for tickets raised by the user
$sql_user_tickets = "
    SELECT 
        COUNT(*) AS ticket_count
    FROM ticket_records_tbl AS t
    WHERE LOWER(t.ticket_status) = 'for approval'
    AND t.ticket_requestor_id = ?
";

// SQL for tickets in the same department
$sql_department_tickets = "
    SELECT 
        COUNT(*) AS ticket_count
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a 
        ON t.ticket_handler_id = a.id 
        AND a.department = ?
    WHERE LOWER(t.ticket_status) = 'for approval'
";

// Execute the first query (user-specific tickets)
$user_stmt = $conn->prepare($sql_user_tickets);
if ($user_stmt) {
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_ticket_count = $user_result->fetch_assoc()['ticket_count'] ?? 0;
    $user_stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare user tickets statement.", "data" => $conn->error]);
    exit;
}

// Execute the second query (department-specific tickets)
$department_stmt = $conn->prepare($sql_department_tickets);
if ($department_stmt) {
    $department_stmt->bind_param("s", $user_department);
    $department_stmt->execute();
    $department_result = $department_stmt->get_result();
    $department_ticket_count = $department_result->fetch_assoc()['ticket_count'] ?? 0;
    $department_stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare department tickets statement.", "data" => $conn->error]);
    exit;
}

// Return results
echo json_encode([
    "status" => "success",
    "data" => [
        "user_tickets" => $user_ticket_count,
        "department_tickets" => $department_ticket_count
    ]
]);

$conn->close();
