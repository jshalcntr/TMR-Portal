<?php
require('../dbconn.php');

header('Content-Type: application/json');

// Function to validate date format YYYY-MM-DD
function isValidDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// Start transaction
mysqli_begin_transaction($conn);

try {
    if (isset($_POST['backorder_id']) && isset($_POST['new_eta']) && isset($_POST['eta_type'])) {
        $id = intval($_POST['backorder_id']);
        $new_eta = trim($_POST['new_eta']);
        $eta_type = trim($_POST['eta_type']);

        // 1. Input Validation
        if (!$id || $id <= 0) {
            throw new Exception('Invalid backorder ID');
        }

        if (!isValidDate($new_eta)) {
            throw new Exception('Invalid date format. Please use YYYY-MM-DD');
        }

        $new_eta_date = new DateTime($new_eta);
        $today = new DateTime();

        if ($new_eta_date < $today) {
            throw new Exception('ETA cannot be set to a past date');
        }

        // Maximum 90 days extension limit
        $max_date = (clone $today)->modify('+90 days');
        if ($new_eta_date > $max_date) {
            throw new Exception('ETA cannot be set more than 90 days in the future');
        }

        // Validate eta_type
        if (!in_array($eta_type, ['eta_1', 'eta_2', 'eta_3'])) {
            throw new Exception('Invalid ETA type specified');
        }

        // Check if backorder exists and get current status
        $check_sql = "SELECT order_status, eta_1, eta_2, eta_3 FROM backorders_tbl 
                     WHERE id = ? AND is_deleted = 0 
                     FOR UPDATE"; // Lock the row for update
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Backorder not found or has been deleted');
        }

        $row = $result->fetch_assoc();

        // Check order status
        if (in_array($row['order_status'], ['Cancelled', 'Delivered'])) {
            throw new Exception('Cannot update ETA for Cancelled or Delivered orders');
        }

        // 2. ETA Logic Validation
        if ($eta_type === 'eta_2' && (!$row['eta_1'] || $new_eta_date <= new DateTime($row['eta_1']))) {
            throw new Exception('ETA 2 must be after ETA 1');
        }
        if ($eta_type === 'eta_3' && (!$row['eta_2'] || $new_eta_date <= new DateTime($row['eta_2']))) {
            throw new Exception('ETA 3 must be after ETA 2');
        }

        // Add confirmation field for eta_2 and eta_3
        $confirmation_field = '';
        if ($eta_type !== 'eta_1') {
            $confirmation_field = ", {$eta_type}_confirmed = 1";
        }

        // 4. Performance Optimization - Use prepared statement with index
        $sql = "UPDATE backorders_tbl SET 
                {$eta_type} = ?, 
                last_updated = CURRENT_TIMESTAMP
                {$confirmation_field} 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $new_eta, $id);

        if (!$stmt->execute()) {
            throw new Exception('Failed to update ETA: ' . $conn->error);
        }

        // Commit transaction
        mysqli_commit($conn);

        echo json_encode([
            'success' => true,
            'message' => 'ETA has been updated successfully',
            'data' => [
                'id' => $id,
                'eta_type' => $eta_type,
                'new_eta' => $new_eta
            ]
        ]);
    } else {
        throw new Exception('Missing required parameters');
    }
} catch (Exception $e) {
    // Rollback transaction on error
    mysqli_rollback($conn);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
