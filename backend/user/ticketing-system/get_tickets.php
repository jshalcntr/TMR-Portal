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

// 🔍 Get user's department
$department = null;
$dept_stmt = $conn->prepare("SELECT department FROM accounts_tbl WHERE id = ?");
$dept_stmt->bind_param("i", $user_id);
$dept_stmt->execute();
$dept_stmt->bind_result($department);
$dept_stmt->fetch();
$dept_stmt->close();

if ($department === null) {
    echo json_encode(["status" => "error", "message" => "User department not found."]);
    exit;
}

// SQL: Pending Tickets (based on ticket_requestor_id)
$sql_pending = "
    SELECT 
        t.*, 
        a.full_name AS handler_name,
        r.department AS requestor_department,
        r.full_name AS requestor_name
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a ON t.ticket_handler_id = a.id
    LEFT JOIN accounts_tbl AS r ON t.ticket_requestor_id = r.id
    WHERE t.ticket_status NOT IN ('CLOSED', 'REJECTED', 'CANCELLED') AND t.ticket_requestor_id = ?
    ORDER BY t.date_created DESC
";

// SQL: Closed/Rejected/Cancelled Tickets based on requestor's DEPARTMENT
$sql_closed = "
    SELECT 
        t.*,
        a.full_name AS handler_name,
        r.department AS requestor_department,
        r.full_name AS requestor_name
    FROM ticket_records_tbl AS t
    LEFT JOIN accounts_tbl AS a ON t.ticket_handler_id = a.id
    LEFT JOIN accounts_tbl AS r ON t.ticket_requestor_id = r.id
    WHERE t.ticket_status IN ('CLOSED', 'REJECTED', 'CANCELLED') AND r.department = ?
    ORDER BY t.date_created DESC
";

// Function to execute a query and format the result
function fetch_tickets($conn, $sql, $param, $base_url, $type = "user")
{
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ["error" => true, "message" => $conn->error];
    }

    $stmt->bind_param("i", $param);
    $stmt->execute();
    $result = $stmt->get_result();

    $tickets = [];
    while ($row = $result->fetch_assoc()) {
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
$closed_tickets = fetch_tickets($conn, $sql_closed, $department, $base_url, "department");

// Return results
if ($pending_tickets['error'] || $closed_tickets['error']) {
    echo json_encode([
        "status" => "error",
        "message" => $pending_tickets['message'] ?? $closed_tickets['message']
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "data" => [
        "pending" => $pending_tickets['data'],
        "closed" => $closed_tickets['data']
    ]
]);

$conn->close();
