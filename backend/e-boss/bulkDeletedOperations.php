<?php
require('../dbconn.php');
header('Content-Type: application/json');
session_start();
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
        case 'array':
            return is_array($data) && !empty($data);
        default:
            return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $ids = $_POST['ids'] ?? [];

    // Validate input
    if (!validateInput($action, 'string')) {
        echo json_encode(["status" => "error", "message" => "Action is required."]);
        exit;
    }

    if (!validateInput($ids, 'array')) {
        echo json_encode(["status" => "error", "message" => "No items selected."]);
        exit;
    }

    // Validate IDs are integers
    $valid_ids = [];
    foreach ($ids as $id) {
        if (is_numeric($id) && $id > 0) {
            $valid_ids[] = (int)$id;
        }
    }

    if (empty($valid_ids)) {
        echo json_encode(["status" => "error", "message" => "No valid items selected."]);
        exit;
    }

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        $success_count = 0;
        $errors = [];

        switch ($action) {
            case 'restore':
                $sql = "UPDATE backorders_tbl SET is_deleted = 0 WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($valid_ids as $id) {
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_count++;
                    } else {
                        $errors[] = "Failed to restore item ID: $id";
                    }
                }
                mysqli_stmt_close($stmt);
                break;

            case 'permanent_delete':
                $sql = "DELETE FROM backorders_tbl WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($valid_ids as $id) {
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_count++;
                    } else {
                        $errors[] = "Failed to permanently delete item ID: $id";
                    }
                }
                mysqli_stmt_close($stmt);
                break;

            default:
                throw new Exception("Invalid action specified.");
        }

        if ($success_count > 0) {
            mysqli_commit($conn);
            $message = ucfirst(str_replace('_', ' ', $action)) . "ed $success_count item(s) successfully.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " item(s) failed.";
            }
            echo json_encode([
                "status" => "success",
                "message" => $message,
                "success_count" => $success_count,
                "error_count" => count($errors)
            ]);
        } else {
            throw new Exception("No items were processed successfully.");
        }
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
