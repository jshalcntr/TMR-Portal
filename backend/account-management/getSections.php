<?php
session_start();
require "../dbconn.php";

$sql = "SELECT * FROM sections_tbl WHERE department = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Departments. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $_GET['departmentId']);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Departments. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
    } else {
        $sections = [];
        $sectionsResult = $stmt->get_result();
        while ($sectionRow = $sectionsResult->fetch_assoc()) {
            $sections[] = $sectionRow;
        }
        $stmt->close();
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $sections,
        ]);
    }
}
