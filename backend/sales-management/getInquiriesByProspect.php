<?php
session_start();
include('../dbconn.php');
include('../middleware/pipes.php');
header('Content-Type: application/json');

$sql = "SELECT
        sales_inquiries_tbl.prospect_type,
        sales_inquiries_tbl.inquiry_date,
        sales_inquiries_tbl.unit_inquired,
        sales_inquiries_tbl.appointment_date,
        sales_inquiries_tbl.appointment_time,
        sales_inquiries_tbl.inquiry_id,
        sales_customers_tbl.customer_firstname,
        sales_customers_tbl.customer_middlename,
        sales_customers_tbl.customer_lastname
        FROM sales_inquiries_tbl
        JOIN sales_customers_tbl ON sales_inquiries_tbl.customer_id = sales_customers_tbl.customer_id
        WHERE agent_id = ? AND  prospect_type = ?
";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Inquiries. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("is", $_SESSION['user']['id'], $_GET['prospectType']);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inquiries. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $inquiries = [];
        $inquiryResults = $stmt->get_result();
        while ($inquiryRow = $inquiryResults->fetch_assoc()) {
            $prospectType = $inquiryRow['prospect_type'];
            $inquiryDate = $inquiryRow['inquiry_date'];
            $unitInquired = $inquiryRow['unit_inquired'];
            $appointmentDate = $inquiryRow['appointment_date'];
            $appointmentTime = $inquiryRow['appointment_time'];
            $inquiryId = $inquiryRow['inquiry_id'];
            $customerFirstName = $inquiryRow['customer_firstname'];
            $customerMiddleName = $inquiryRow['customer_middlename'];
            $customerLastName = $inquiryRow['customer_lastname'];

            $inquiries[] = [
                "prospectType" => $prospectType,
                "inquiryDateReadable" => convertToReadableDate($inquiryDate),
                "inquiryDate" => $inquiryDate,
                "unitInquired" => $unitInquired,
                "appointmentDateReadable" => convertToReadableDate($appointmentDate),
                "appointmentDate" => $appointmentDate,
                "appointmentTime" => $appointmentTime,
                "inquiryId" => $inquiryId,
                "customerFirstName" => $customerFirstName,
                "customerMiddleName" => $customerMiddleName,
                "customerLastName" => $customerLastName
            ];
        }
        $stmt->close();

        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $inquiries
        ]);
    }
}
