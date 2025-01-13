<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Fetch handler names from the MIS department
$query = "SELECT id, full_name FROM accounts_tbl WHERE department = 'MIS'";
$result = $conn->query($query);

if ($result) {
    $handlers = [];
    while ($row = $result->fetch_assoc()) {
        $handlers[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $handlers]);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$conn->close();
