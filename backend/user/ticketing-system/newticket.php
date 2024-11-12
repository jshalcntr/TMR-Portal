<?php
include('../../dbconn.php');
session_start();




// Set response header
header('Content-Type: text/plain');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_category = isset($_POST['ticket_category']) ? $conn->real_escape_string($_POST['ticket_category']) : '';
    $ticket_subject = isset($_POST['ticket_subject']) ? $conn->real_escape_string($_POST['ticket_subject']) : '';
    $ticket_content = isset($_POST['ticket_content']) ? $conn->real_escape_string($_POST['ticket_content']) : '';
    $ticket_requestor_id = $_SESSION['user']['id']; // Assuming user ID is stored in session

    // Initialize variables for file upload
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf', 'docx'];
    $max_file_size = 2 * 1024 * 1024; // 2 MB in bytes
    // Define the upload directory
    $upload_dir = "/tmr-portal/uploads/tickets/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Prepare for SQL query
    $date_created = date("Y-m-d H:i:s");
    $ticket_status = 'Open'; // Default status for new tickets

    // Validate and process the file if uploaded
    $file_name = '';
    $target_path = '';
    if (isset($_FILES['ticket_attachment']) && $_FILES['ticket_attachment']['error'] == 0) {
        $file = $_FILES['ticket_attachment'];
        $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Check file type and size
        if (in_array($file_extension, $allowed_extensions) && $file['size'] <= $max_file_size) {
            // Generate unique filename and move the uploaded file
            $file_name = uniqid('ticket_', true) . '.' . $file_extension;
            $target_path = $upload_dir . $file_name;

            if (!move_uploaded_file($file['tmp_name'], $target_path)) {
                echo "File upload failed. Please try again.";
                exit;
            }
        } else {
            echo "Invalid file type or size. Please upload a .jpg, .png, .pdf, or .docx file under 2 MB.";
            exit;
        }
    }

    // Insert ticket data into the database
    $sql = "INSERT INTO ticket_records_tbl 
(ticket_requestor_id, ticket_subject, ticket_type, ticket_description, ticket_status, date_created, ticket_attachment)
VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issssss", $ticket_requestor_id, $ticket_subject, $ticket_category, $ticket_content, $ticket_status, $date_created, $target_path);

        if ($stmt->execute()) {
            echo "Ticket submitted successfully.";
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Ticket Submitted Successfully!",
            ]);
        } else {
            echo "Error: Unable to submit ticket. Please try again.";
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Internal Error. Please Contact MIS",
                "data" => $stmt->error
            ]);
        }
        $stmt->close();
    } else {
        echo "Database error: Could not prepare statement.";
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Internal Error. Please Contact MIS",
            "data" => $conn->error
        ]);
    }

    // Close database connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
