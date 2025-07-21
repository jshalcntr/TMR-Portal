<?php
if (isset($_GET['id'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('../dbconn.php');
    header('Content-Type: application/json');

    $inquiryId = $conn->real_escape_string($_GET['id']);
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - Received inquiryId: $inquiryId\n", FILE_APPEND);

    $sql = "SELECT 
        i.inquiry_id AS id,
        c.customer_firstname AS firstName,
        c.customer_middlename AS middleName,
        c.customer_lastname AS lastName,
        c.contact_number AS contactNumber,
        c.gender,
        c.marital_status AS maritalStatus,
        c.birthday,
        c.province,
        c.municipality,
        c.barangay,
        c.street_address AS street,
        c.occupation,
        c.business_name AS businessName,
        c.business_address AS businessAddress,
        c.business_category AS businessCategory,
        c.business_size AS businessSize,
        c.monthly_average AS monthlyAverage,
        i.inquiry_date AS inquiryDate,
        i.inquiry_source AS inquirySource,
        i.face_to_face_source AS f2fSource,
        i.online_source AS onlineSource,
        i.mall_display AS mallDisplay,
        i.buyer_type AS buyerType,
        i.unit_inquired AS unitInquired,
        i.tamaraw_variant AS tamarawVariant,
        i.transaction_type AS transactionType,
        i.has_application AS hasApplication,
        i.has_reservation AS hasReservation,
        i.reservation_date AS reservationDate,
        i.buyer_decision_hold AS buyerDecisionHold,
        i.buyer_decision_hold_reason AS buyerDecisionHoldReason,
        i.appointment_date AS appointmentDate,
        i.appointment_time AS appointmentTime,
        i.prospect_type AS prospectType
    FROM sales_inquiries_tbl i
    JOIN sales_customers_tbl c ON i.customer_id = c.customer_id
    WHERE i.inquiry_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $inquiryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        echo json_encode(["status" => "success", "data" => $data]);
    } else {
        echo json_encode(["status" => "error", "message" => "No data found for inquiry ID: $inquiryId"]);
    }
    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["status" => "error", "message" => "No inquiry ID provided"]);
    file_put_contents('debug.log', date('Y-m-d H:i:s') . " - No inquiry ID provided\n", FILE_APPEND);
    exit;
}
