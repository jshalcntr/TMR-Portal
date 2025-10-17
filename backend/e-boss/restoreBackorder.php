<?php
require('../dbconn.php');
session_start();
header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Check if record exists and is in Delivered status
        $check_sql = "SELECT order_status FROM backorders_tbl WHERE id = ? AND is_deleted = 0";
        $check_stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($check_stmt, "i", $id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);
        $record = mysqli_fetch_assoc($result);

        if (!$record) {
            throw new Exception("Record not found");
        }

        if ($record['order_status'] !== 'Delivered') {
            throw new Exception("Only delivered items can be restored to pending");
        }

        // Check if updated_by column exists
        $check_column_sql = "SHOW COLUMNS FROM backorders_tbl LIKE 'updated_by'";
        $column_result = mysqli_query($conn, $check_column_sql);
        $has_update_fields = mysqli_num_rows($column_result) > 0;

        // Update the record to pending status
        if ($has_update_fields) {
            $update_sql = "UPDATE backorders_tbl SET 
                          order_status = 'Pending',
                          updated_at = CURRENT_TIMESTAMP,
                          updated_by = ?
                          WHERE id = ?";

            $update_stmt = mysqli_prepare($conn, $update_sql);
            $user_id = $_SESSION['user_id'] ?? 0;
            mysqli_stmt_bind_param($update_stmt, "ii", $user_id, $id);
        } else {
            $update_sql = "UPDATE backorders_tbl SET 
                          order_status = 'Pending'
                          WHERE id = ?";

            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "i", $id);
        }

        if (!mysqli_stmt_execute($update_stmt)) {
            throw new Exception("Failed to restore record");
        }

        // Commit transaction
        mysqli_commit($conn);

        echo json_encode([
            'success' => true,
            'message' => 'Record has been restored to pending status'
        ]);
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($conn);

        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
