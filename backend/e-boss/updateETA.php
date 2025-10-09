<?php
require('../dbconn.php');

header('Content-Type: application/json');

if (isset($_POST['backorder_id']) && isset($_POST['new_eta']) && isset($_POST['eta_type'])) {
    $id = intval($_POST['backorder_id']);
    $new_eta = $_POST['new_eta'];
    $eta_type = $_POST['eta_type'];

    // Validate eta_type
    if (!in_array($eta_type, ['eta_1', 'eta_2', 'eta_3'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid ETA type specified'
        ]);
        exit;
    }

    // Add confirmation field for eta_2 and eta_3
    $confirmation_field = '';
    if ($eta_type !== 'eta_1') {
        $confirmation_field = ", {$eta_type}_confirmed = 1";
    }

    $sql = "UPDATE backorders_tbl SET {$eta_type} = ? {$confirmation_field} WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_eta, $id);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'ETA has been updated successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update ETA: ' . $conn->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
}
