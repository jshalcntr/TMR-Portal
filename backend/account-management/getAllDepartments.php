<?php
session_start();
require "../dbconn.php";

$sql = "SELECT * FROM departments_tbl";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Departments. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Departments. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
    } else {
        $departments = [];
        $departmentsResult = $stmt->get_result();
        while ($departmentRow = $departmentsResult->fetch_assoc()) {
            $departments[] = $departmentRow;
        }
        $stmt->close();
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $departments,
        ]);
    }
}
