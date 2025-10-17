<?php
require('../dbconn.php');
header('Content-Type: application/json');

// Input validation function
function validateInput($data, $type = 'string', $required = true)
{
    if ($required && (empty($data) || $data === null)) {
        return false;
    }

    switch ($type) {
        case 'string':
            return is_string($data) && strlen(trim($data)) > 0;
        case 'number':
            return is_numeric($data) && $data > 0;
        case 'date':
            return DateTime::createFromFormat('Y-m-d', $data) !== false;
        case 'email':
            return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
        default:
            return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate required fields
    $required_fields = ['ro_number', 'customer_name', 'order_date', 'order_no', 'source', 'order_type', 'service_type', 'service_estimator', 'status'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || !validateInput($_POST[$field])) {
            $errors[] = "Field '$field' is required and must be valid.";
        }
    }

    // Validate arrays
    if (!isset($_POST['part_number']) || !is_array($_POST['part_number']) || empty($_POST['part_number'])) {
        $errors[] = "At least one part is required.";
    }

    if (!isset($_POST['part_name']) || !is_array($_POST['part_name']) || empty($_POST['part_name'])) {
        $errors[] = "Part names are required.";
    }

    if (!isset($_POST['qty']) || !is_array($_POST['qty']) || empty($_POST['qty'])) {
        $errors[] = "Quantities are required.";
    }

    if (!isset($_POST['bo_price']) || !is_array($_POST['bo_price']) || empty($_POST['bo_price'])) {
        $errors[] = "Backorder prices are required.";
    }

    // Validate ETA date if provided
    if (!empty($_POST['eta_1']) && !validateInput($_POST['eta_1'], 'date')) {
        $errors[] = "ETA date must be in valid Y-m-d format.";
    }

    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode(" ", $errors)]);
        exit;
    }

    // Sanitize and prepare data
    $ro_number = trim($_POST['ro_number']);
    $customer_name = trim($_POST['customer_name']);
    $order_date = $_POST['order_date'];
    $order_no = trim($_POST['order_no']);
    $eta_1 = !empty($_POST['eta_1']) ? $_POST['eta_1'] : null;
    $order_type = $_POST['order_type'];
    $service_type = $_POST['service_type'];
    $service_estimator = trim($_POST['service_estimator']);
    $unit_model = isset($_POST['unit_model']) ? trim($_POST['unit_model']) : '';
    $plate_no = isset($_POST['plate_no']) ? trim($_POST['plate_no']) : '';
    $remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
    $status = $_POST['status'];
    $source = trim($_POST['source']);
    $order_status = 'Pending';

    // Arrays for multiple parts
    $part_numbers = $_POST['part_number'];
    $part_names = $_POST['part_name'];
    $qtys = $_POST['qty'];
    $bo_prices = $_POST['bo_price'];

    // Validate array lengths match
    if (
        count($part_numbers) !== count($part_names) ||
        count($part_numbers) !== count($qtys) ||
        count($part_numbers) !== count($bo_prices)
    ) {
        echo json_encode(["status" => "error", "message" => "All part arrays must have the same length."]);
        exit;
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        $insert_errors = [];

        for ($i = 0; $i < count($part_numbers); $i++) {
            $part_number = trim($part_numbers[$i]);
            $part_name = trim($part_names[$i]);
            $qty = (int) $qtys[$i];
            $bo_price = (float) $bo_prices[$i];

            // Validate part data
            if (empty($part_number) || empty($part_name) || $qty <= 0 || $bo_price <= 0) {
                $insert_errors[] = "Invalid data for part " . ($i + 1);
                continue;
            }

            // Use prepared statement
            $query = "INSERT INTO backorders_tbl 
                (ro_number, customer_name, order_date, order_no, source, part_number, part_name, qty, bo_price, eta_1, order_type, service_type, service_estimator, unit_model, plate_no, remarks, unit_status, order_status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param(
                $stmt,
                "ssssssssdsssssssss",
                $ro_number,
                $customer_name,
                $order_date,
                $order_no,
                $source,
                $part_number,
                $part_name,
                $qty,
                $bo_price,
                $eta_1,
                $order_type,
                $service_type,
                $service_estimator,
                $unit_model,
                $plate_no,
                $remarks,
                $status,
                $order_status
            );

            if (!mysqli_stmt_execute($stmt)) {
                $insert_errors[] = "Failed to insert part " . ($i + 1) . ": " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);
        }

        if (!empty($insert_errors)) {
            throw new Exception(implode("; ", $insert_errors));
        }

        // Commit transaction
        mysqli_commit($conn);
        echo json_encode(["status" => "success", "message" => "Backorder(s) added successfully!"]);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
}
