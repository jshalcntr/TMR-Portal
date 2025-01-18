<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json'); // Ensure JSON responses for all cases
include('../../dbconn.php');
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_category = isset($_POST['ticket_category']) ? $conn->real_escape_string($_POST['ticket_category']) : '';
    $ticket_subject = isset($_POST['ticket_subject']) ? $conn->real_escape_string($_POST['ticket_subject']) : '';
    $ticket_content = isset($_POST['ticket_content']) ? $conn->real_escape_string($_POST['ticket_content']) : '';
    $ticket_requestor_id = $_SESSION['user']['id'] ?? null;

    // Ensure the session user ID is set
    if (!$ticket_requestor_id) {
        echo json_encode(["status" => "error", "message" => "User session expired. Please log in again."]);
        exit;
    }

    // Initialize variables for file upload
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    $max_file_size = 2 * 1024 * 1024; // 2 MB
    $upload_dir = "../../../uploads/tickets/";

    // Ensure upload directory exists
    if (!is_dir($upload_dir) && !mkdir($upload_dir, 0777, true)) {
        echo json_encode(["status" => "error", "message" => "Failed to create upload directory."]);
        exit;
    }

    // Prepare data for SQL insertion
    $date_created = date("Y-m-d H:i:s");
    $ticket_status = 'Open';
    $file_name = '';
    $new_target_path = '';

    // Process file upload if a file is uploaded
    if (isset($_FILES['ticket_attachment']) && $_FILES['ticket_attachment']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['ticket_attachment'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Validate file type and size
        if (in_array($file_extension, $allowed_extensions) && $file['size'] <= $max_file_size) {
            $file_name = uniqid('ticket_', true) . '.' . $file_extension;
            $new_target_path = $upload_dir . $file_name;

            // Attempt to move the uploaded file
            if (!move_uploaded_file($file['tmp_name'], $new_target_path)) {
                echo json_encode(["status" => "error", "message" => "File upload failed. Please try again."]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid file type or size. Upload .jpg, .png, .pdf, or .docx files under 2 MB."]);
            exit;
        }
    }

    // Insert ticket data into the database
    $sql = "INSERT INTO ticket_records_tbl 
            (ticket_requestor_id, ticket_subject, ticket_type, ticket_description, ticket_status, date_created, ticket_attachment)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param(
            "issssss",
            $ticket_requestor_id,
            $ticket_subject,
            $ticket_category,
            $ticket_content,
            $ticket_status,
            $date_created,
            $new_target_path
        );

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Ticket submitted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Unable to submit ticket. Please try again later.", "data" => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: Unable to prepare statement.", "data" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
