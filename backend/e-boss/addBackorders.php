<?php
require('../dbconn.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ro_number = mysqli_real_escape_string($conn, $_POST['ro_number']);
    $customer_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $order_date = mysqli_real_escape_string($conn, $_POST['order_date']);
    $order_no = mysqli_real_escape_string($conn, $_POST['order_no']);
    $eta_1 = !empty($_POST['eta_1']) ? mysqli_real_escape_string($conn, $_POST['eta_1']) : null;
    $order_type = mysqli_real_escape_string($conn, $_POST['order_type']);
    $service_type = mysqli_real_escape_string($conn, $_POST['service_type']);
    $service_estimator = mysqli_real_escape_string($conn, $_POST['service_estimator']);
    $unit_model = mysqli_real_escape_string($conn, $_POST['unit_model']);
    $plate_no = mysqli_real_escape_string($conn, $_POST['plate_no']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $source = mysqli_real_escape_string($conn, $_POST['source']);
    // Arrays for multiple parts
    $part_numbers = $_POST['part_number'];
    $part_names = $_POST['part_name'];
    $qtys = $_POST['qty'];
    $bo_prices = $_POST['bo_price'];

    $errors = [];
    for ($i = 0; $i < count($part_numbers); $i++) {
        $part_number = mysqli_real_escape_string($conn, $part_numbers[$i]);
        $part_name = mysqli_real_escape_string($conn, $part_names[$i]);
        $qty = (int) $qtys[$i];
        $bo_price = (float) $bo_prices[$i];

        $query = "INSERT INTO backorders_tbl 
            (ro_number, customer_name, order_date, order_no, source, part_number, part_name, qty, bo_price, eta_1, order_type, service_type, service_estimator, unit_model, plate_no, remarks, status)
            VALUES 
            ('$ro_number','$customer_name','$order_date','$order_no','$source','$part_number','$part_name','$qty','$bo_price',
            " . ($eta_1 ? "'$eta_1'" : "NULL") . ",
            '$order_type','$service_type','$service_estimator','$unit_model','$plate_no','$remarks','$status')";

        if (!mysqli_query($conn, $query)) {
            $errors[] = mysqli_error($conn);
        }
    }

    if (empty($errors)) {
        echo json_encode(["status" => "success", "message" => "Backorder(s) added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => implode(", ", $errors)]);
    }
}
