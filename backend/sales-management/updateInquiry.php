<?php
session_start();
include('../dbconn.php');
include('../middleware/helperFunction.php');

$newProspectType         = post_clean('prospectType');
$maritalStatus           = post_clean('maritalStatus');
$birthday                = post_clean('birthday');
$occupation              = post_clean('occupation');
$businessName            = post_clean('businessName');
$occupationProvince      = post_clean('occupationProvince');
$occupationMunicipality  = post_clean('occupationMunicipality');
$occupationBarangay      = post_clean('occupationBarangay');
$occupationStreet        = post_clean('occupationStreet');
$businessCategory        = post_clean('businessCategory');
$businessSize            = post_clean('businessSize');
$monthlyAverage          = post_clean('monthlyAverage');

$buyerType               = post_clean('buyerType');
$unitInquired            = post_clean('unitInquired');
$tamarawVariant          = post_clean('tamarawVariant');
$transactionType         = post_clean('transactionType');
$hasApplication          = post_yesno('hasApplication');
$hasReservation          = post_yesno('hasReservation');
$reservationDate         = post_clean('reservationDate');
$additionalUnit          = post_clean('additionalUnit');
$tamarawSpecificUsage    = post_clean('tamarawSpecificUsage');
$buyerDecisionHold       = post_yesno('buyerDecisionHold');
$buyerDecisionHoldReason = post_clean('buyerDecisionHoldReason');
$appointmentDate         = post_clean('appointmentDate');
$appointmentTime         = post_clean('appointmentTime');
$agentId                 = $_SESSION['user']['id'] ?? null;

$inquiryId = post_clean('inquiryId');

$currentTimestamp = date("Y-m-d H:i:s");

$sql = "SELECT 
        sales_customers_tbl.customer_id,
        sales_customers_tbl.customer_firstname,
        sales_customers_tbl.customer_middlename,
        sales_customers_tbl.customer_lastname,
        sales_customers_tbl.province,
        sales_customers_tbl.municipality,
        sales_customers_tbl.barangay,
        sales_customers_tbl.street,
        sales_customers_tbl.contact_number,
        sales_customers_tbl.gender,
        sales_inquiries_history_tbl.inquiry_id,
        sales_inquiries_history_tbl.version,
        sales_inquiries_history_tbl.prospect_type,
        sales_inquiries_history_tbl.inquiry_date,
        sales_inquiries_history_tbl.inquiry_source,
        sales_inquiries_history_tbl.inquiry_source_type,
        sales_inquiries_history_tbl.mall,
        sales_inquiries_history_tbl.buyer_type,
        sales_inquiries_history_tbl.unit_inquired,
        sales_inquiries_history_tbl.transaction_type
        FROM sales_inquiries_history_tbl
        JOIN
            (SELECT inquiry_id, MAX(version) as max_version
                FROM sales_inquiries_history_tbl
                GROUP BY inquiry_id) latest
            ON sales_inquiries_history_tbl.inquiry_id = latest.inquiry_id AND sales_inquiries_history_tbl.version = latest.max_version
        JOIN sales_inquiries_tbl
            ON sales_inquiries_history_tbl.inquiry_id = sales_inquiries_tbl.inquiry_id
        JOIN sales_customers_tbl
            ON sales_inquiries_tbl.customer_id = sales_customers_tbl.customer_id
        WHERE sales_inquiries_tbl.inquiry_id = ?";

$sql1 = "INSERT INTO sales_inquiries_history_tbl(
    inquiry_id,
    version,
    prospect_type,
    inquiry_date,
    inquiry_source,
    inquiry_source_type,
    mall,
    buyer_type,
    unit_inquired,
    transaction_type,
    has_application,
    has_reservation,
    reservation_date,
    appointment_date,
    appointment_time,
    updated_at
) VALUES(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
)";

$sql2 = "INSERT INTO sales_inquiries_tamaraw_history_tbl(
    history_id,
    tamaraw_variant,
    additional_unit,
    tamaraw_specific_usage,
    buyer_decision_hold,
    buyer_decision_hold_reason
) VALUES(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
)";

$sql3 = "UPDATE sales_customers_tbl SET
    marital_status = ?,
    birthday = ?,
    occupation = ?,
    occupation_province = ?,
    occupation_municipality = ?,
    occupation_barangay = ?,
    occupation_street = ?,
    business_name = ?,
    business_category = ?,
    business_size = ?,
    monthly_average = ?
    WHERE customer_id = ?
    ";

$conn->begin_transaction();

$stmt = $conn->prepare($sql);
if (!$stmt) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt->bind_param("i", $inquiryId);
if (!$stmt->execute()) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $stmt->error);
}
$oldInquiryDetails = $stmt->get_result()->fetch_assoc();

$inquiryDate       = $oldInquiryDetails['inquiry_date'];
$inquirySource     = $oldInquiryDetails['inquiry_source'];
$inquirySourceType = $oldInquiryDetails['inquiry_source_type'];
$mallDisplay       = $oldInquiryDetails['mall'];
$newVersion        = $oldInquiryDetails['version'] + 1;
$customerId        = $oldInquiryDetails['customer_id'];

$stmt1 = $conn->prepare($sql1);
if (!$stmt1) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt1->bind_param(
    "iissssssssiissss",
    $inquiryId,
    $newVersion,
    $newProspectType,
    $inquiryDate,
    $inquirySource,
    $inquirySourceType,
    $mallDisplay,
    $buyerType,
    $unitInquired,
    $transactionType,
    $hasApplication,
    $hasReservation,
    $reservationDate,
    $appointmentDate,
    $appointmentTime,
    $currentTimestamp
);
if (!$stmt1->execute()) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $stmt1->error);
}
$historyId = $stmt1->insert_id;

if ($unitInquired == "TAMARAW") {
    $stmt2 = $conn->prepare($sql2);
    if (!$stmt2) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
    }
    $stmt2->bind_param(
        "isssis",
        $historyId,
        $tamarawVariant,
        $additionalUnit,
        $tamarawSpecificUsage,
        $buyerDecisionHold,
        $buyerDecisionHoldReason
    );
    if (!$stmt2->execute()) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt2->error);
    }
}

$stmt3 = $conn->prepare($sql3);
if (!$stmt3) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt3->bind_param(
    "sssssssssssi",
    $maritalStatus,
    $birthday,
    $occupation,
    $occupationProvince,
    $occupationMunicipality,
    $occupationBarangay,
    $occupationStreet,
    $businessName,
    $businessCategory,
    $businessSize,
    $monthlyAverage,
    $customerId
);
if (!$stmt3->execute()) {
    $conn->rollback();
    respondWithError("Failed to Update Inquiry. Please Contact the Programmer", $stmt3->error);
}

$conn->commit();
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "message" => "Inquiry Updated Successfully!",
]);
