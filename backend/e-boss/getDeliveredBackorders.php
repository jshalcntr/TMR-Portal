<?php
require_once '../dbconn.php';
session_start();

header('Content-Type: application/json');

try {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $searchPattern = "%$search%";
    
    $query = "SELECT 
                b.id,
                b.ro_number,
                b.order_date,
                b.order_no,
                b.part_number,
                b.qty,
                b.bo_price,
                b.total,
                b.service_type,
                b.unit_model,
                b.plate_no,
                b.appointment_date,
                b.appointment_remarks,
                b.appointment_set_at,
                c.customer_name,
                c.contact_no,
                p.part_name,
                u.full_name as scheduled_by
            FROM backorders b
            LEFT JOIN customers c ON b.customer_id = c.id
            LEFT JOIN parts p ON b.part_id = p.id
            LEFT JOIN users u ON b.appointment_set_by = u.id
            WHERE b.status = 'Delivered'
            AND (
                b.ro_number LIKE ?
                OR c.customer_name LIKE ?
                OR p.part_name LIKE ?
            )
            ORDER BY b.appointment_date ASC, b.order_date DESC
            LIMIT 10";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sss', $searchPattern, $searchPattern, $searchPattern);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    $results = [];
    
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
    
    echo json_encode($results);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}