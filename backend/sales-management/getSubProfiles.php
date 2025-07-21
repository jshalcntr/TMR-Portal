<?php
session_start();
require('../../backend/dbconn.php');

$sql = "SELECT * FROM sales_subprofilings_tbl
        JOIN sales_customers_tbl ON sales_subprofilings_tbl.customer_id = sales_customers_tbl.customer_id
        WHERE created_by = ?";
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
            $clientFirstName = $subProfileResult['customer_firstname'];
            $clientMiddleName = $subProfileResult['customer_middlename'];
            $clientLastName = $subProfileResult['customer_lastname'];
            $csNumber = $subProfileResult['conduction_sticker_number'];
            $inquiryDate = $subProfileResult['inquiry_date'];
            $phone = $subProfileResult['contact_number'];
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
