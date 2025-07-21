<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $age_bracket_data = [
        'age_20_and_below' => 0,
        'age_21_30' => 0,
        'age_31_40' => 0,
        'age_41_50' => 0,
        'age_51_and_above' => 0
    ];

    $query = "SELECT 
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) <= 20 THEN '20 and below'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 21 AND 30 THEN '21-30'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 31 AND 40 THEN '31-40'
                    WHEN TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 41 AND 50 THEN '41-50'
                    ELSE '51 and above'
                END AS age_bracket,
                COUNT(*) as count
              FROM sales_customers_tbl
              WHERE birthday IS NOT NULL
              GROUP BY age_bracket";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $key = 'age_' . strtolower(str_replace([' ', '-'], '_', $row['age_bracket']));
            $age_bracket_data[$key] = (int)$row['count'];
        }
        $result->free();
    } else {
        throw new Exception('Query execution failed: ' . $conn->error);
    }

    echo json_encode([
        'status' => 'success',
        'age_bracket_counts' => $age_bracket_data
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
