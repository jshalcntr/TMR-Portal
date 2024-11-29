<?php

header('Content-Type: application/json');
session_start();
include('../../dbconn.php');

$query = "
    SELECT 
        DATE_FORMAT(date_finished, '%b') AS month, 
        COUNT(*) AS ticket_count 
    FROM 
        ticket_records_tbl 
    WHERE 
        LOWER(ticket_status) = 'closed' 
        AND YEAR(date_finished) = YEAR(CURDATE()) 
    GROUP BY 
        MONTH(date_finished) 
    ORDER BY 
        MONTH(date_finished)
";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'month' => $row['month'],
            'ticket_count' => $row['ticket_count']
        ];
    }
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    echo json_encode(['status' => 'success', 'data' => []]);
}
