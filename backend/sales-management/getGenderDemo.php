<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $gender_data = [
        'gender_male' => 0,
        'gender_female' => 0,
        'gender_lgbt' => 0,
    ];

    $query = "SELECT gender, COUNT(*) as count 
              FROM sales_customers_tbl 
              WHERE gender IN ('Male', 'Female', 'LGBT') 
              GROUP BY gender";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $key = 'gender_' . strtolower($row['gender']);
            $gender_data[$key] = (int)$row['count'];
        }
        $result->free();
    } else {
        throw new Exception('Query execution failed: ' . $conn->error);
    }

    echo json_encode([
        'status' => 'success',
        'gender_counts' => $gender_data
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
