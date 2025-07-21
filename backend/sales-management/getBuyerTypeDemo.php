<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $buyer_type_data = [
        'first_time' => 0,
        'replacement' => 0,
        'additional' => 0
    ];

    $query = "SELECT buyer_type AS customer_purchase_type, COUNT(*) as count 
          FROM sales_inquiries_tbl 
          WHERE buyer_type IN ('First-Time', 'Replacement', 'Additional') 
          GROUP BY buyer_type";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $buyer_type = $row['customer_purchase_type'];
            $count = (int)$row['count'];
            $key = strtolower(str_replace('-', '_', $buyer_type));
            $buyer_type_data[$key] = $count;
        }
        $result->free();
    }

    echo json_encode([
        'status' => 'success',
        'buyer_type_counts' => $buyer_type_data
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
