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

// SQL queries for counting tickets
$sql_pending_count = "
    SELECT COUNT(*) AS count
    FROM ticket_records_tbl
    WHERE ticket_status NOT IN ('Closed', 'Cancelled') AND ticket_requestor_id = ?
";

$sql_closed_count = "
    SELECT COUNT(*) AS count
    FROM ticket_records_tbl
    WHERE ticket_status = 'Closed' AND ticket_requestor_id = ?
";

// Function to execute a count query
function get_ticket_count($conn, $sql, $user_id)
{
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return ["error" => true, "message" => $conn->error];
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->fetch_assoc()['count'];
    $stmt->close();

    return ["error" => false, "count" => $count];
}

// Get counts for pending and closed tickets
$pending_count = get_ticket_count($conn, $sql_pending_count, $user_id);
$closed_count = get_ticket_count($conn, $sql_closed_count, $user_id);

// Check for errors
if ($pending_count['error'] || $closed_count['error']) {
    echo json_encode([
        "status" => "error",
        "message" => $pending_count['message'] ?? $closed_count['message']
    ]);
    exit;
}

// Return counts
echo json_encode([
    "status" => "success",
    "data" => [
        "pending_count" => $pending_count['count'],
        "closed_count" => $closed_count['count']
    ]
]);

$conn->close();
