<?php
session_start();
require('../../backend/dbconn.php');

$sql = "SELECT
    client_first_name,
    client_middle_name,
    client_last_name,
    conduction_sticker_number,
    inquiry_date,
    phone,
    gender,
    job_level,
    work_nature,
    subprofile_id
FROM sales_subprofilings_tbl WHERE created_by = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Sub Profiling. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $_SESSION['user']['id']);
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
        $subProfiles = [];
        while ($subProfileResult = $subProfileResults->fetch_assoc()) {
            $id = $subProfileResult['subprofile_id'];
            $clientFirstName = $subProfileResult['client_first_name'];
            $clientMiddleName = $subProfileResult['client_middle_name'];
            $clientLastName = $subProfileResult['client_last_name'];
            $csNumber = $subProfileResult['conduction_sticker_number'];
            $inquiryDate = $subProfileResult['inquiry_date'];
            $phone = $subProfileResult['phone'];
            $gender = $subProfileResult['gender'];
            $jobLevel = $subProfileResult['job_level'];
            $workNature = $subProfileResult['work_nature'];

            $subProfiles[] = [
                "id" => $id,
                "clientFirstName" => $clientFirstName,
                "clientMiddleName" => $clientMiddleName,
                "clientLastName" => $clientLastName,
                "csNumber" => $csNumber,
                "inquiryDate" => $inquiryDate,
                "phone" => $phone,
                "gender" => $gender,
                "jobLevel" => $jobLevel,
                "workNature" => $workNature
            ];
        }

        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "data" => $subProfiles
        ]);
    }
}
