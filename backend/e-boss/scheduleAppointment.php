<?php
require('../dbconn.php');
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_POST['backorder_id']) || !isset($_POST['appointment_date']) || !isset($_POST['appointment_time'])) {
            throw new Exception('Missing required fields');
        }

        $backorder_id = intval($_POST['backorder_id']);
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $notes = $_POST['notes'] ?? '';
        $created_by = $_SESSION['user_id'] ?? 0;

        // Validate date and time
        $datetime = DateTime::createFromFormat('Y-m-d H:i', $appointment_date . ' ' . $appointment_time);
        if (!$datetime) {
            throw new Exception('Invalid date or time format');
        }

        // Check if date is not in the past
        $today = new DateTime();
        if ($datetime < $today) {
            throw new Exception('Cannot schedule appointments in the past');
        }

        // Start transaction
        mysqli_begin_transaction($conn);

        // Check if backorder exists and is delivered
        $check_sql = "SELECT order_status FROM backorders_tbl WHERE id = ? AND is_deleted = 0";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "i", $backorder_id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        $backorder = mysqli_fetch_assoc($result);

        if (!$backorder) {
            throw new Exception('Backorder not found');
        }

        if ($backorder['order_status'] !== 'Delivered') {
            throw new Exception('Can only schedule appointments for delivered items');
        }

        // Check if appointment already exists
        $check_appointment_sql = "SELECT id FROM backorders_appointment_tbl WHERE backorder_id = ? AND status != 'Cancelled'";
        $check_app_stmt = mysqli_prepare($conn, $check_appointment_sql);
        mysqli_stmt_bind_param($check_app_stmt, "i", $backorder_id);
        mysqli_stmt_execute($check_app_stmt);
        if (mysqli_stmt_get_result($check_app_stmt)->num_rows > 0) {
            throw new Exception('An appointment already exists for this backorder');
        }

        // Insert appointment
        $insert_sql = "INSERT INTO backorders_appointment_tbl (
            backorder_id, 
            appointment_date, 
            appointment_time, 
            notes, 
            status,
            created_by, 
            created_at
        ) VALUES (?, ?, ?, ?, 'Scheduled', ?, NOW())";

        $insert_stmt = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param(
            $insert_stmt,
            "isssi",
            $backorder_id,
            $appointment_date,
            $appointment_time,
            $notes,
            $created_by
        );

        if (!mysqli_stmt_execute($insert_stmt)) {
            throw new Exception('Failed to create appointment');
        }

        // Commit transaction
        mysqli_commit($conn);

        echo json_encode([
            'success' => true,
            'message' => 'Appointment scheduled successfully'
        ]);
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
