<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require('../dbconn.php');

    if (!isset($conn) || !$conn instanceof mysqli) {
        throw new Exception('MySQLi connection is not properly initialized.');
    }

    $year = isset($_GET['year']) && is_numeric($_GET['year']) ? (int)$_GET['year'] : date('Y');
    $monthly_data = array_fill(1, 12, 0);
    $userId = $_SESSION['user']['id'];

    $stmt = $conn->prepare("
        SELECT MONTH(inquiry_date) AS month, COUNT(*) AS count
        FROM sales_inquiries_history_tbl
        JOIN
            (SELECT inquiry_id, MAX(version) as max_version
                FROM sales_inquiries_history_tbl
                GROUP BY inquiry_id) latest
            ON sales_inquiries_history_tbl.inquiry_id = latest.inquiry_id AND sales_inquiries_history_tbl.version = latest.max_version
        JOIN sales_inquiries_tbl
            ON sales_inquiries_history_tbl.inquiry_id = sales_inquiries_tbl.inquiry_id
        WHERE YEAR(inquiry_date) = ? AND sales_inquiries_tbl.agent_id = ?
        GROUP BY MONTH(inquiry_date)
    ");

    if (!$stmt) {
        throw new Exception('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ii", $year, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $month = (int)$row['month'];
        $monthly_data[$month] = (int)$row['count'];
    }

    $stmt->close();

    echo json_encode([
        'status' => 'success',
        'monthly_counts' => array_values($monthly_data)
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
