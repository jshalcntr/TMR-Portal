<?php
require('../dbconn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    // Get all form data
    $ro_number = $_POST['ro_number'] ?? '';
    $customer_name = $_POST['customer_name'] ?? '';
    $order_no = $_POST['order_no'] ?? '';
    $source = $_POST['source'] ?? '';
    $part_number = $_POST['part_number'] ?? '';
    $part_name = $_POST['part_name'] ?? '';
    $qty = floatval($_POST['qty'] ?? 0);
    $bo_price = floatval($_POST['bo_price'] ?? 0);
    $order_status = $_POST['order_status'] ?? '';
    $order_type = $_POST['order_type'] ?? '';
    $service_type = $_POST['service_type'] ?? '';
    $service_estimator = $_POST['service_estimator'] ?? '';
    $unit_model = $_POST['unit_model'] ?? '';
    $plate_no = $_POST['plate_no'] ?? '';
    $unit_status = $_POST['unit_status'] ?? '';
    $eta_1 = $_POST['eta_1'] ?? null;
    $eta_2 = $_POST['eta_2'] ?? null;
    $eta_3 = $_POST['eta_3'] ?? null;
    $order_date = $_POST['order_date'] ?? '';
    $remarks = $_POST['remarks'] ?? '';

    // Validate required fields
    if (empty($customer_name) || empty($order_no) || empty($order_status)) {
        echo json_encode(["status" => "error", "message" => "Customer name, order number, and status are required."]);
        exit;
    }

    // Update the record with all fields
    $sql = "UPDATE backorders_tbl SET 
            ro_number = ?, 
            customer_name = ?, 
            order_no = ?, 
            source = ?, 
            part_number = ?, 
            part_name = ?, 
            qty = ?, 
            bo_price = ?, 
            order_status = ?, 
            order_type = ?, 
            service_type = ?, 
            service_estimator = ?, 
            unit_model = ?, 
            plate_no = ?, 
            unit_status = ?, 
            eta_1 = ?, 
            eta_2 = ?, 
            eta_3 = ?, 
            order_date = ?, 
            remarks = ? 
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssddssssssssssssi",
            $ro_number,
            $customer_name,
            $order_no,
            $source,
            $part_number,
            $part_name,
            $qty,
            $bo_price,
            $order_status,
            $order_type,
            $service_type,
            $service_estimator,
            $unit_model,
            $plate_no,
            $unit_status,
            $eta_1,
            $eta_2,
            $eta_3,
            $order_date,
            $remarks,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["status" => "success", "message" => "Record updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update record."]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
