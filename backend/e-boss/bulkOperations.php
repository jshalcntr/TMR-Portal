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
    $reason = $_POST['reason'] ?? '';

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
            case 'cancel':
                if (empty($reason)) {
                    throw new Exception("Cancel reason is required.");
                }

                $sql = "UPDATE backorders_tbl SET order_status = 'Cancelled', cancel_reason = ? WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($valid_ids as $id) {
                    mysqli_stmt_bind_param($stmt, "si", $reason, $id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_count++;
                    } else {
                        $errors[] = "Failed to cancel item ID: $id";
                    }
                }
                mysqli_stmt_close($stmt);
                break;

            case 'deliver':
                $sql = "UPDATE backorders_tbl SET order_status = 'Delivered' WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($valid_ids as $id) {
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_count++;
                    } else {
                        $errors[] = "Failed to deliver item ID: $id";
                    }
                }
                mysqli_stmt_close($stmt);
                break;

            case 'delete':
                $sql = "UPDATE backorders_tbl SET order_status = 'Deleted' WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);

                foreach ($valid_ids as $id) {
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_count++;
                    } else {
                        $errors[] = "Failed to delete item ID: $id";
                    }
                }
                mysqli_stmt_close($stmt);
                break;

            case 'update_eta':
                // For each item, determine which ETA field to update and add 15 days
                foreach ($valid_ids as $id) {
                    // Get current ETA data for this item
                    $get_sql = "SELECT eta_1, eta_2, eta_3 FROM backorders_tbl WHERE id = ?";
                    $get_stmt = mysqli_prepare($conn, $get_sql);
                    mysqli_stmt_bind_param($get_stmt, "i", $id);
                    mysqli_stmt_execute($get_stmt);
                    $result = mysqli_stmt_get_result($get_stmt);
                    $row = mysqli_fetch_assoc($result);
                    mysqli_stmt_close($get_stmt);

                    if ($row) {
                        $current_eta = null;
                        $eta_type = null;
                        $new_eta = null;

                        // Determine which ETA to update
                        if (empty($row['eta_2'])) {
                            // Update ETA_2
                            $current_eta = new DateTime($row['eta_1']);
                            $eta_type = 'eta_2';
                        } elseif (empty($row['eta_3'])) {
                            // Update ETA_3
                            $current_eta = new DateTime($row['eta_2']);
                            $eta_type = 'eta_3';
                        } else {
                            // All ETAs filled, update ETA_3
                            $current_eta = new DateTime($row['eta_3']);
                            $eta_type = 'eta_3';
                        }

                        if ($current_eta && $eta_type) {
                            // Add 15 days
                            $new_eta = (clone $current_eta)->modify('+15 days')->format('Y-m-d');

                            // Update the database with confirmation status
                            $update_sql = "UPDATE backorders_tbl SET $eta_type = ?, {$eta_type}_confirmed = 1 WHERE id = ?";
                            $update_stmt = mysqli_prepare($conn, $update_sql);
                            mysqli_stmt_bind_param($update_stmt, "si", $new_eta, $id);

                            if (mysqli_stmt_execute($update_stmt)) {
                                $success_count++;
                            } else {
                                $errors[] = "Failed to update ETA for item ID: $id";
                            }
                            mysqli_stmt_close($update_stmt);
                        } else {
                            $errors[] = "No valid ETA found for item ID: $id";
                        }
                    } else {
                        $errors[] = "Item ID: $id not found";
                    }
                }
                break;

            default:
                throw new Exception("Invalid action specified.");
        }

        if ($success_count > 0) {
            mysqli_commit($conn);
            $message = ucfirst($action) . "ed $success_count item(s) successfully.";
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
