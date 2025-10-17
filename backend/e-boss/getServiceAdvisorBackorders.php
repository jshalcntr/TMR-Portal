<?php
session_start();

// Ensure no output before our JSON
ob_start();

require('../dbconn.php');

// Clear any output that might have occurred during connection
ob_clean();

header('Content-Type: application/json');
header('Cache-Control: no-cache, must-revalidate');

try {
    // Get parameters from DataTables AJAX request
    $draw = isset($_POST['draw']) ? intval($_POST['draw']) : 1;
    $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
    $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
    $search = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
    $orderColumn = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
    $orderDir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'ASC';

    // Map DataTables column index to database column names
    $columns = [
        'order_date',
        'ro_number',
        'customer_name',
        'order_no',
        'part_number',
        'part_name',
        'qty',
        'bo_price',
        'total',
        'eta_1',
        'eta_2',
        'eta_3',
        'aging',
        'order_status',
        'service_type',
        'unit_model',
        'plate_no'
    ];

    // Base query
    $sql = "SELECT 
                id,
                order_date,
                ro_number,
                customer_name,
                order_no,
                part_number,
                part_name,
                qty,
                bo_price,
                DATEDIFF(CURRENT_DATE(), order_date) as aging,
                (qty * bo_price) as total,
                eta_1,
                eta_2,
                eta_3,
                order_status,
                service_type,
                unit_model,
                plate_no
            FROM backorders_tbl 
            WHERE is_deleted = 0 AND order_status = 'DELIVERED'";

    // Search condition
    if (!empty($search)) {
        $sql .= " AND (
            ro_number LIKE ? OR
            customer_name LIKE ? OR
            order_no LIKE ? OR
            part_number LIKE ? OR
            part_name LIKE ? OR
            plate_no LIKE ? OR
            unit_model LIKE ?
        )";
    }

    // Ordering
    if (isset($columns[$orderColumn])) {
        $sql .= " ORDER BY " . $columns[$orderColumn] . " " . $orderDir;
    }

    // Get total count before pagination
    $countSql = "SELECT COUNT(*) as total FROM backorders_tbl WHERE is_deleted = 0";
    if (!empty($search)) {
        $countSql .= " AND (
            ro_number LIKE ? OR
            customer_name LIKE ? OR
            order_no LIKE ? OR
            part_number LIKE ? OR
            part_name LIKE ? OR
            plate_no LIKE ? OR
            unit_model LIKE ?
        )";
    }

    $countStmt = mysqli_prepare($conn, $countSql);

    if (!empty($search)) {
        $searchParam = "%$search%";
        mysqli_stmt_bind_param(
            $countStmt,
            "sssssss",
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam
        );
    }

    mysqli_stmt_execute($countStmt);
    $totalResult = mysqli_stmt_get_result($countStmt);
    $totalRow = mysqli_fetch_assoc($totalResult);
    $totalRecords = $totalRow['total'];
    $filteredRecords = $totalRecords;

    // Add pagination
    $sql .= " LIMIT ?, ?";

    // Prepare and execute the main query
    $stmt = mysqli_prepare($conn, $sql);

    if (!empty($search)) {
        $searchParam = "%$search%";
        mysqli_stmt_bind_param(
            $stmt,
            "sssssssii",
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $searchParam,
            $start,
            $length
        );
    } else {
        mysqli_stmt_bind_param($stmt, "ii", $start, $length);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if there's an appointment
        $appointmentSql = "SELECT * FROM backorders_appointment_tbl WHERE backorder_id = ? LIMIT 1";
        $appointmentStmt = mysqli_prepare($conn, $appointmentSql);
        mysqli_stmt_bind_param($appointmentStmt, "i", $row['id']);
        mysqli_stmt_execute($appointmentStmt);
        $appointmentResult = mysqli_stmt_get_result($appointmentStmt);
        $hasAppointment = mysqli_num_rows($appointmentResult) > 0;

        // Calculate row class based on ETA status
        $rowClass = '';
        $today = time();
        if ($row['eta_1'] && strtotime($row['eta_1']) < time()) {
            $rowClass = 'table-danger';
        } else if ($row['eta_2'] && strtotime($row['eta_2']) < time()) {
            $rowClass = 'table-warning';
        }

        // Format dates
        $order_date = $row['order_date'] ? date('Y-m-d', strtotime($row['order_date'])) : '';
        $eta_1 = $row['eta_1'] ? date('Y-m-d', strtotime($row['eta_1'])) : '';
        $eta_2 = $row['eta_2'] ? date('Y-m-d', strtotime($row['eta_2'])) : '';
        $eta_3 = $row['eta_3'] ? date('Y-m-d', strtotime($row['eta_3'])) : '';

        // Calculate total
        $total = $row['qty'] * $row['bo_price'];

        // Add row to data array
        $data[] = [
            'id' => $row['id'],
            'order_date' => $order_date,
            'ro_number' => $row['ro_number'],
            'customer_name' => $row['customer_name'],
            'order_no' => $row['order_no'],
            'part_number' => $row['part_number'],
            'part_name' => $row['part_name'],
            'qty' => $row['qty'],
            'bo_price' => $row['bo_price'],
            'total' => $total,
            'eta_1' => $eta_1,
            'eta_2' => $eta_2,
            'eta_3' => $eta_3,
            'aging' => $row['aging'],
            'order_status' => $row['order_status'],
            'service_type' => $row['service_type'],
            'unit_model' => $row['unit_model'],
            'plate_no' => $row['plate_no'],
            'has_appointment' => $hasAppointment,
            'rowClass' => ''
        ];
    }

    // Return the JSON response
    echo json_encode([
        'draw' => $draw,
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $filteredRecords,
        'data' => $data
    ]);
} catch (Exception $e) {
    // Return error response in DataTables format
    echo json_encode([
        'draw' => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        'recordsTotal' => 0,
        'recordsFiltered' => 0,
        'data' => [],
        'error' => $e->getMessage()
    ]);
}
