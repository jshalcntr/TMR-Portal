<?php
require_once '../dbconn.php';
session_start();

header('Content-Type: application/json');

try {
    if (!isset($_POST['backorders']) || !isset($_POST['batchAppointmentDate'])) {
        throw new Exception('Required data is missing');
    }

    $backorders = json_decode($_POST['backorders'], true);
    $appointmentDate = $_POST['batchAppointmentDate'];
    $remarks = isset($_POST['batchRemarks']) ? $_POST['batchRemarks'] : '';
    $userId = $_SESSION['user_id'];

    // Start transaction using mysqli
    mysqli_begin_transaction($conn);

    // Prepare the update statement
    $stmt = mysqli_prepare($conn, "
        UPDATE backorders 
        SET appointment_date = ?,
            appointment_remarks = ?,
            appointment_set_by = ?,
            appointment_set_at = NOW()
        WHERE id = ? AND status = 'Delivered' AND appointment_date IS NULL
    ");

    $successCount = 0;
    $failCount = 0;

    foreach ($backorders as $backorderId) {
        mysqli_stmt_bind_param($stmt, 'ssii', $appointmentDate, $remarks, $userId, $backorderId);

        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $successCount++;
            } else {
                $failCount++;
            }
        } else {
            throw new Exception('Error updating backorder ' . $backorderId);
        }
    }

    // Commit the transaction
    mysqli_commit($conn);

    $message = "Successfully scheduled $successCount backorder(s) for appointment.";
    if ($failCount > 0) {
        $message .= " $failCount backorder(s) could not be scheduled (may already have appointments).";
    }

    echo json_encode([
        'status' => 'success',
        'message' => $message
    ]);
} catch (Exception $e) {
    if (mysqli_get_server_info($conn)) {
        mysqli_rollback($conn);
    }

    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
