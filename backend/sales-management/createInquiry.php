<?php
session_start();
include('../dbconn.php');
include('../middleware/helperFunction.php');

// $prospectType = filter_input(INPUT_POST, 'prospectType', FILTER_SANITIZE_STRING);
// $firstName = filter_input(INPUT_POST, 'customerFirstName', FILTER_SANITIZE_STRING);
// $middleName = filter_input(INPUT_POST, 'customerMiddleName', FILTER_SANITIZE_STRING);
// $lastName = filter_input(INPUT_POST, 'customerLastName', FILTER_SANITIZE_STRING);
// $customerProvince = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
// $customerMunicipality = filter_input(INPUT_POST, 'municipality', FILTER_SANITIZE_STRING);
// $customerBarangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_STRING);
// $customerStreet = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
// $contactNumber = filter_input(INPUT_POST, 'contactNumber', FILTER_SANITIZE_STRING);
// $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
// $maritalStatus = filter_input(INPUT_POST, 'maritalStatus', FILTER_SANITIZE_STRING);
// $birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
// $occupation = filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_STRING);
// $businessName = filter_input(INPUT_POST, 'businessName', FILTER_SANITIZE_STRING);
// $occupationProvince = filter_input(INPUT_POST, 'occupationProvince', FILTER_SANITIZE_STRING);
// $occupationMunicipality = filter_input(INPUT_POST, 'occupationMunicipality', FILTER_SANITIZE_STRING);
// $occupationBarangay = filter_input(INPUT_POST, 'occupationBarangay', FILTER_SANITIZE_STRING);
// $occupationStreet = filter_input(INPUT_POST, 'occupationStreet', FILTER_SANITIZE_STRING);
// $businessCategory = filter_input(INPUT_POST, 'businessCategory', FILTER_SANITIZE_STRING) ?? "";
// $businessSize = filter_input(INPUT_POST, 'businessSize', FILTER_SANITIZE_STRING) ?? "";
// $monthlyAverage = filter_input(INPUT_POST, 'monthlyAverage', FILTER_SANITIZE_STRING);

// $inquiryDate = filter_input(INPUT_POST, 'inquiryDate', FILTER_SANITIZE_STRING);
// $inquirySource = filter_input(INPUT_POST, 'inquirySource', FILTER_SANITIZE_STRING);
// $inquirySourceType = filter_input(INPUT_POST, 'inquirySourceType', FILTER_SANITIZE_STRING);
// $mallDisplay = filter_input(INPUT_POST, 'mallDisplay', FILTER_SANITIZE_STRING);
// $buyerType = filter_input(INPUT_POST, 'buyerType', FILTER_SANITIZE_STRING);
// $unitInquired = filter_input(INPUT_POST, 'unitInquired', FILTER_SANITIZE_STRING);
// $tamarawVariant = filter_input(INPUT_POST, 'tamarawVariant', FILTER_SANITIZE_STRING) ?? "";
// $transactionType = filter_input(INPUT_POST, 'transactionType', FILTER_SANITIZE_STRING);
// $hasApplicationRaw = filter_input(INPUT_POST, 'hasApplication', FILTER_SANITIZE_STRING);
// $hasApplication = $hasApplicationRaw === "Yes" ? 1 : 0;
// $hasReservationRaw = filter_input(INPUT_POST, 'hasReservation', FILTER_SANITIZE_STRING);
// $hasReservation = $hasReservationRaw === "Yes" ? 1 : 0;
// $reservationDate = filter_input(INPUT_POST, 'reservationDate', FILTER_SANITIZE_STRING);
// $additionalUnit = filter_input(INPUT_POST, 'additionalUnit', FILTER_SANITIZE_STRING) ?? "";
// $tamarawSpecificUsage = filter_input(INPUT_POST, 'tamarawSpecificUsage', FILTER_SANITIZE_STRING) ?? "";
// $buyerDecisionHoldRaw = filter_input(INPUT_POST, 'buyerDecisionHold', FILTER_SANITIZE_STRING) ?? "";
// $buyerDecisionHold = $buyerDecisionHoldRaw === "Yes" ? 1 : ($buyerDecisionHoldRaw === "No" ? 0 : $buyerDecisionHoldRaw);
// $buyerDecisionHoldReason = filter_input(INPUT_POST, 'buyerDecisionHoldReason', FILTER_SANITIZE_STRING) ?? "";
// $appointmentDate = filter_input(INPUT_POST, 'appointmentDate', FILTER_SANITIZE_STRING);
// $appointmentTime = filter_input(INPUT_POST, 'appointmentTime', FILTER_SANITIZE_STRING);
// $agentId = $_SESSION['user']['id'];

$prospectType            = post_clean('prospectType');
$firstName               = post_clean('customerFirstName');
$middleName              = post_clean('customerMiddleName');
$lastName                = post_clean('customerLastName');
$customerProvince        = post_clean('province');
$customerMunicipality    = post_clean('municipality');
$customerBarangay        = post_clean('barangay');
$customerStreet          = post_clean('street');
$contactNumber           = post_clean('contactNumber');
$gender                  = post_clean('gender');
$maritalStatus           = post_clean('maritalStatus');
$birthday                = post_clean('birthday'); // date validation can be added
$occupation              = post_clean('occupation');
$businessName            = post_clean('businessName');
$occupationProvince      = post_clean('occupationProvince');
$occupationMunicipality  = post_clean('occupationMunicipality');
$occupationBarangay      = post_clean('occupationBarangay');
$occupationStreet        = post_clean('occupationStreet');
$businessCategory        = post_clean('businessCategory');
$businessSize            = post_clean('businessSize');
$monthlyAverage          = post_clean('monthlyAverage');

$inquiryDate             = post_clean('inquiryDate');
$inquirySource           = post_clean('inquirySource');
$inquirySourceType       = post_clean('inquirySourceType');
$mallDisplay             = post_clean('mallDisplay');
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

$currentTimestamp = date("Y-m-d H:i:s");


$sql1 = "INSERT INTO sales_customers_tbl (
    customer_firstname,
    customer_middlename,
    customer_lastname,
    province,
    municipality,
    barangay,
    street,
    contact_number,
    gender,
    marital_status,
    birthday,
    occupation,
    occupation_province,
    occupation_municipality,
    occupation_barangay,
    occupation_street,
    business_name,
    business_category,
    business_size,
    monthly_average
) VALUES (
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
    ?,
    ?,
    ?,
    ?,
    ?
)";

$sql2 = "INSERT INTO sales_inquiries_tbl(
    customer_id,
    agent_id,
    created_at
) VALUES (
    ?,
    ?,
    ?
)";

$sql3 = "INSERT INTO sales_inquiries_history_tbl(
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

$sql4 = "INSERT INTO sales_inquiries_tamaraw_history_tbl(
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


$conn->begin_transaction();

//* INSERT CUSTOMER DATA
$stmt1 = $conn->prepare($sql1);
if (!$stmt1) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt1->bind_param(
    "ssssssssssssssssssss",
    $firstName,
    $middleName,
    $lastName,
    $customerProvince,
    $customerMunicipality,
    $customerBarangay,
    $customerStreet,
    $contactNumber,
    $gender,
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
    $monthlyAverage
);
if (!$stmt1->execute()) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt1->error);
}
$customerId = $stmt1->insert_id;
$stmt1->close();

$stmt2 = $conn->prepare($sql2);
if (!$stmt2) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt2->bind_param(
    "iis",
    $customerId,
    $agentId,
    $currentTimestamp
);
if (!$stmt2->execute()) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt2->error);
}
$inquiryId = $stmt2->insert_id;

$stmt3 = $conn->prepare($sql3);
if (!$stmt3) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
}
$version = 1;
$stmt3->bind_param(
    "iissssssssiissss",
    $inquiryId,
    $version,
    $prospectType,
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
if (!$stmt3->execute()) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt3->error);
}
$historyId = $stmt3->insert_id;

if ($unitInquired == "TAMARAW") {
    $stmt4 = $conn->prepare($sql4);
    if (!$stmt4) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
    }
    $stmt4->bind_param(
        "isssis",
        $historyId,
        $tamarawVariant,
        $additionalUnit,
        $tamarawSpecificUsage,
        $buyerDecisionHold,
        $buyerDecisionHoldReason
    );
    if (!$stmt4->execute()) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt4->error);
    }
}

//? IF THE INQUIRY IS CREATED SUCCESSFULLY
$conn->commit();
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "message" => "Inquiry Created Successfully!",
]);
