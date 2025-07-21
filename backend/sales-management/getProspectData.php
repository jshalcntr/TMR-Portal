<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $client_data = [
        'prospectType_hot' => 0,
        'prospectType_warm' => 0,
        'prospectType_cold' => 0,
        'prospectType_lost' => 0,
    ];

    $query = "SELECT prospect_type, COUNT(*) as count 
              FROM sales_inquiries_tbl 
              WHERE prospect_type IN ('Hot', 'Warm', 'Cold', 'Lost') 
              GROUP BY prospect_type";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $key = 'prospectType_' . $row['prospect_type'];
            $client_data[$key] = (int)$row['count'];
        }
        $result->free();
    } else {
        throw new Exception('Query execution failed: ' . $conn->error);
    }

    echo json_encode([
        'status' => 'success',
        'all_counts' => $client_data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
}

if (isset($conn)) {
    $conn->close();
}
