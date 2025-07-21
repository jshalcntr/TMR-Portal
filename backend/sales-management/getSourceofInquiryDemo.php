<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $source_data = [
        'online' => 0,
        'face_to_face' => 0,
    ];

    $query = "SELECT inquiry_source, COUNT(*) as count 
              FROM sales_inquiries_tbl 
              WHERE inquiry_source IN ('Face to Face', 'Online') 
              GROUP BY inquiry_source";

    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $source = $row['inquiry_source'];
            if ($source === 'Face to Face') {
                $key = 'face_to_face';
            } else {
                $key = strtolower($source);
            }
            $source_data[$key] = (int)$row['count'];
        }
        $result->free();
    } else {
        throw new Exception('Query execution failed: ' . $conn->error);
    }

    echo json_encode([
        'status' => 'success',
        'source_counts' => $source_data
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
