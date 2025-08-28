<?php
header('Content-Type: application/json');
include('../../dbconn.php');
session_start();

// Get the updated ticket details from the AJAX request
$ticket_id = $_POST['ticket_id'] ?? '';
$ticket_status = $_POST['ticket_status'] ?? '';
$ticket_conclusion = $_POST['ticket_conclusion'] ?? '';
$ticket_close_date = date('Y-m-d H:i:s');

// Validate input
if (empty($ticket_id) || empty($ticket_status) || empty($ticket_conclusion)) {
    echo json_encode(['status' => 'error', 'message' => 'Conclusion fields are required']);
    exit;
}

// File upload settings
$allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
$max_file_size = 2 * 1024 * 1024; // 2MB
$upload_dir = "../../../uploads/tickets/";

if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
    echo json_encode(["status" => "error", "message" => "Failed to create upload directory."]);
    exit;
}
$file_name = '';
$new_target_path = '';

$file_name = '';
$new_target_path = '';

// If file is uploaded
if (isset($_FILES['ticket_conclusion_attachment']) && $_FILES['ticket_conclusion_attachment']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['ticket_conclusion_attachment'];
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($file_extension, $allowed_extensions) && $file['size'] <= $max_file_size) {
        $file_name = uniqid('ticket_', true) . '.' . $file_extension;
        $new_target_path = $upload_dir . $file_name;

        if (!move_uploaded_file($file['tmp_name'], $new_target_path)) {
            echo json_encode(["status" => "error", "message" => "File upload failed. Please try again."]);
            exit;
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Invalid file type or size. Allowed: jpg, jpeg, png, pdf, docx (Max: 2MB)"
        ]);
        exit;
    }
}

// ✅ If file uploaded → update with file path
if (!empty($new_target_path)) {
    $query = "UPDATE ticket_records_tbl 
              SET ticket_status = ?, ticket_conclusion = ?, date_finished = ?, ticket_conclusion_attachment = ? 
              WHERE ticket_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $ticket_status, $ticket_conclusion, $ticket_close_date, $new_target_path, $ticket_id);

    // ✅ If no file uploaded → don’t touch ticket_conclusion_attachment
} else {
    $query = "UPDATE ticket_records_tbl 
              SET ticket_status = ?, ticket_conclusion = ?, date_finished = ? 
              WHERE ticket_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssss', $ticket_status, $ticket_conclusion, $ticket_close_date, $ticket_id);
}

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket details updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
