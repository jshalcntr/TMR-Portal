<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../dbconn.php');
header('Content-Type: application/json');

$sql = "SELECT inquiry_id, appointment_date 
        FROM sales_inquiries_tbl 
        WHERE appointment_date IS NOT NULL";

$result = $conn->query($sql);
$appointments = [];

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL error",
        "sql" => $sql,
        "error" => $conn->error
    ]);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $appointments[] = [
        "id" => $row["inquiry_id"],
        "title" => "Appointment #" . $row["inquiry_id"],
        "start" => $row["appointment_date"],
    ];
}

echo json_encode($appointments);
$conn->close();