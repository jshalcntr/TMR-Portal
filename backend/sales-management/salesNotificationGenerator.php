<?php
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "tmr_portal";
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    echo json_encode($conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set("Asia/Manila");

$conn->set_charset("utf8mb4");

$now = new DateTime();
$currentTimestamp = $now->format('Y-m-d H:i:s');

$sql = "SELECT
            sales_inquiries_history_tbl.appointment_date,
            sales_inquiries_history_tbl.appointment_time,
            sales_inquiries_history_tbl.history_id,
            sales_inquiries_history_tbl.inquiry_id,
            sales_inquiries_history_tbl.version,
            sales_inquiries_tbl.agent_id
        FROM sales_inquiries_history_tbl
        INNER JOIN (
            SELECT inquiry_id, MAX(version) AS latest_version
            FROM sales_inquiries_history_tbl
            GROUP BY inquiry_id
        ) latest 
        ON sales_inquiries_history_tbl.inquiry_id = latest.inquiry_id
        AND sales_inquiries_history_tbl.version = latest.latest_version
        JOIN sales_inquiries_tbl
        ON sales_inquiries_tbl.inquiry_id = sales_inquiries_history_tbl.inquiry_id
        WHERE sales_inquiries_history_tbl.appointment_date != '0000-00-00'
          AND sales_inquiries_history_tbl.appointment_time IS NOT NULL";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $appointment = DateTime::createFromFormat(
        'Y-m-d h:i A',
        $row['appointment_date'] . ' ' . $row['appointment_time']
    );

    if (!$appointment) continue;

    $diff = $appointment->getTimestamp() - $now->getTimestamp();

    if ($diff >= 0 && $diff <= 3600) {
        $check = $conn->prepare("SELECT notification_id 
                                 FROM sales_inquiry_notifications_tbl 
                                 WHERE history_id=?");
        $check->bind_param("i", $row['history_id']);
        $check->execute();
        $existing = $check->get_result();

        if ($existing->num_rows == 0) {
            $msg = "Follow-up appointment due.";
            $stmt = $conn->prepare("INSERT INTO sales_inquiry_notifications_tbl 
                (history_id, message, receiver_id, created_at, appointment_datetime) 
                VALUES (?, ?, ?, ?, ?)");
            $datetime = $appointment->format('Y-m-d H:i:s');
            $stmt->bind_param("isiss", $row['history_id'], $msg, $row['agent_id'], $currentTimestamp, $datetime);
            $stmt->execute();
        }
    }
}
$conn->close();
