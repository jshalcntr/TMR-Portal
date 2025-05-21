<?php
session_start();
require('../../backend/dbconn.php');

$subProfileId = $_GET['subProfileId'];
$sql = "SELECT * FROM sales_subprofilings_tbl WHERE subprofile_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Sub Profiling. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $subProfileId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Sub Profiling. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $subProfileResults = $stmt->get_result();
        $subProfile = [];
        while ($subProfileResult = $subProfileResults->fetch_assoc()) {
            $subProfile[] = $subProfileResult;
        }

        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "data" => $subProfile
        ]);
    }
}
