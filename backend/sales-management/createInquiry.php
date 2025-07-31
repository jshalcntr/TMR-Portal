<?php

include('../dbconn.php');
include('../middleware/helperFunction.php');

// $prospectType = $_POST['prospectType'];
// $firstName = $_POST['customerFirstName'];
// $middleName = $_POST['customerMiddleName'];
// $lastName = $_POST['customerLastName'];
// $customerProvince = $_POST['province'];
// $cusotmerMunicipality = $_POST['municipality'];
// $customerBarangay = $_POST['barangay'];
// $customerStreet = $_POST['street'];
// $contactNumber = $_POST['contactNumber'];
// $gender = $_POST['gender'];
// $maritalStatus = $_POST['maritalStatus'];
// $birthday = $_POST['birthday'];
// $occupation = $_POST['occupation'];
// $businessName = $_POST['businessName'];
// $occupationProvince = $_POST['occupationProvince'];
// $occupationMunicipality = $_POST['occupationMunicipality'];
// $occupationBarangay = $_POST['occupationBarangay'];
// $occupationStreet = $_POST['occupationStreet'];
// $businessCategory = $_POST['businessCategory'] ?? "";
// $businessSize = $_POST['businessSize'] ?? "";
// $monthlyAverage = $_POST['monthlyAverage'];

// $inquiryDate = $_POST['inquiryDate'];
// $inquirySource = $_POST['inquirySource'];
// $inquirySourceType = $_POST['inquirySourceType'];
// $mallDisplay = $_POST['mallDisplay'];
// $buyerType = $_POST['buyerType'];
// $unitInquired = $_POST['unitInquired'];
// $tamarawVariant = $_POST['tamarawVariant'] ?? "";
// $transactionType = $_POST['transactionType'];
// $hasApplication = $_POST['hasApplication'] == "Yes" ? 1 : 0;
// $hasReservation = $_POST['hasReservation'] == "Yes" ? 1 : 0;
// $reservationDate = $_POST['reservationDate'];
// $additionalUnit = $_POST['additionalUnit'] ?? "";
// $tamarawSpecificUsage = $_POST['tamarawSpecificUsage'] ?? "";
// $buyerDecisionHold = $_POST['buyerDecisionHold'] ?? "";
// $buyerDecisionHold = $buyerDecisionHold == "Yes" ? 1 : ($buyerDecisionHold == "No" ? 0 : $buyerDecisionHold);
// $buyerDecisionHoldReason = $_POST['buyerDecisionHoldReason'] ?? "";
// $appointmentDate = $_POST['appointmentDate'];
// $appointmentTime = $_POST['appointmentTime'];
$prospectType = filter_input(INPUT_POST, 'prospectType', FILTER_SANITIZE_STRING);
$firstName = filter_input(INPUT_POST, 'customerFirstName', FILTER_SANITIZE_STRING);
$middleName = filter_input(INPUT_POST, 'customerMiddleName', FILTER_SANITIZE_STRING);
$lastName = filter_input(INPUT_POST, 'customerLastName', FILTER_SANITIZE_STRING);
$customerProvince = filter_input(INPUT_POST, 'province', FILTER_SANITIZE_STRING);
$customerMunicipality = filter_input(INPUT_POST, 'municipality', FILTER_SANITIZE_STRING);
$customerBarangay = filter_input(INPUT_POST, 'barangay', FILTER_SANITIZE_STRING);
$customerStreet = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
$contactNumber = filter_input(INPUT_POST, 'contactNumber', FILTER_SANITIZE_STRING);
$gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
$maritalStatus = filter_input(INPUT_POST, 'maritalStatus', FILTER_SANITIZE_STRING);
$birthday = filter_input(INPUT_POST, 'birthday', FILTER_SANITIZE_STRING);
$occupation = filter_input(INPUT_POST, 'occupation', FILTER_SANITIZE_STRING);
$businessName = filter_input(INPUT_POST, 'businessName', FILTER_SANITIZE_STRING);
$occupationProvince = filter_input(INPUT_POST, 'occupationProvince', FILTER_SANITIZE_STRING);
$occupationMunicipality = filter_input(INPUT_POST, 'occupationMunicipality', FILTER_SANITIZE_STRING);
$occupationBarangay = filter_input(INPUT_POST, 'occupationBarangay', FILTER_SANITIZE_STRING);
$occupationStreet = filter_input(INPUT_POST, 'occupationStreet', FILTER_SANITIZE_STRING);
$businessCategory = filter_input(INPUT_POST, 'businessCategory', FILTER_SANITIZE_STRING) ?? "";
$businessSize = filter_input(INPUT_POST, 'businessSize', FILTER_SANITIZE_STRING) ?? "";
$monthlyAverage = filter_input(INPUT_POST, 'monthlyAverage', FILTER_SANITIZE_STRING);

$inquiryDate = filter_input(INPUT_POST, 'inquiryDate', FILTER_SANITIZE_STRING);
$inquirySource = filter_input(INPUT_POST, 'inquirySource', FILTER_SANITIZE_STRING);
$inquirySourceType = filter_input(INPUT_POST, 'inquirySourceType', FILTER_SANITIZE_STRING);
$mallDisplay = filter_input(INPUT_POST, 'mallDisplay', FILTER_SANITIZE_STRING);
$buyerType = filter_input(INPUT_POST, 'buyerType', FILTER_SANITIZE_STRING);
$unitInquired = filter_input(INPUT_POST, 'unitInquired', FILTER_SANITIZE_STRING);
$tamarawVariant = filter_input(INPUT_POST, 'tamarawVariant', FILTER_SANITIZE_STRING) ?? "";
$transactionType = filter_input(INPUT_POST, 'transactionType', FILTER_SANITIZE_STRING);
$hasApplicationRaw = filter_input(INPUT_POST, 'hasApplication', FILTER_SANITIZE_STRING);
$hasApplication = $hasApplicationRaw === "Yes" ? 1 : 0;
$hasReservationRaw = filter_input(INPUT_POST, 'hasReservation', FILTER_SANITIZE_STRING);
$hasReservation = $hasReservationRaw === "Yes" ? 1 : 0;
$reservationDate = filter_input(INPUT_POST, 'reservationDate', FILTER_SANITIZE_STRING);
$additionalUnit = filter_input(INPUT_POST, 'additionalUnit', FILTER_SANITIZE_STRING) ?? "";
$tamarawSpecificUsage = filter_input(INPUT_POST, 'tamarawSpecificUsage', FILTER_SANITIZE_STRING) ?? "";
$buyerDecisionHoldRaw = filter_input(INPUT_POST, 'buyerDecisionHold', FILTER_SANITIZE_STRING) ?? "";
$buyerDecisionHold = $buyerDecisionHoldRaw === "Yes" ? 1 : ($buyerDecisionHoldRaw === "No" ? 0 : $buyerDecisionHoldRaw);
$buyerDecisionHoldReason = filter_input(INPUT_POST, 'buyerDecisionHoldReason', FILTER_SANITIZE_STRING) ?? "";
$appointmentDate = filter_input(INPUT_POST, 'appointmentDate', FILTER_SANITIZE_STRING);
$appointmentTime = filter_input(INPUT_POST, 'appointmentTime', FILTER_SANITIZE_STRING);


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
    ?
)";

$sql2 = "INSERT INTO sales_inquiries_tbl(
    customer_id,
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
    appointment_time
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
    ?
)";

$sql3 = "INSERT INTO sales_inquiries_tamaraw_tbl(
    inquiry_id,
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
    "sssssssssssssssssss",
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
    $monthlyAverage
);
if (!$stmt1->execute()) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt1->error);
}
$customerId = $stmt1->insert_id;
$stmt1->close();

//* INSERT INQUIRY DATA
$stmt2 = $conn->prepare($sql2);
if (!$stmt2) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
}
$stmt2->bind_param(
    "issssssssiisss",
    $customerId,
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
    $appointmentTime
);
if (!$stmt2->execute()) {
    $conn->rollback();
    respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt2->error);
}
$inquiryId = $stmt2->insert_id;
$stmt2->close();

//* INSERT TAMARAW DATA IF UNIT INQUIRED IS TAMARAW
if ($unitInquired == "TAMARAW") {
    $stmt3 = $conn->prepare($sql3);
    if (!$stmt3) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $conn->error);
    }
    $stmt3->bind_param(
        "isssis",
        $inquiryId,
        $tamarawVariant,
        $additionalUnit,
        $tamarawSpecificUsage,
        $buyerDecisionHold,
        $buyerDecisionHoldReason
    );
    if (!$stmt3->execute()) {
        $conn->rollback();
        respondWithError("Failed to Create Inquiry. Please Contact the Programmer", $stmt3->error);
    }
    $stmt3->close();
}

//? IF THE INQUIRY IS CREATED SUCCESSFULLY
$conn->commit();
header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "message" => "Inquiry Successfully Created",
]);


// header('Content-Type: application/json');
// echo json_encode([
//     "data" => [
//         "prospectType" => $prospectType,
//         "firstName" => $firstName,
//         "middleName" => $middleName,
//         "lastName" => $lastName,
//         "customerProvince" => $customerProvince,
//         "customerMunicipality" => $customerMunicipality,
//         "customerBarangay" => $customerBarangay,
//         "customerStreet" => $customerStreet,
//         "contactNumber" => $contactNumber,
//         "gender" => $gender,
//         "maritalStatus" => $maritalStatus,
//         "birthday" => $birthday,
//         "occupation" => $occupation,
//         "businessName" => $businessName,
//         "occupationProvince" => $occupationProvince,
//         "occupationMunicipality" => $occupationMunicipality,
//         "occupationBarangay" => $occupationBarangay,
//         "occupationStreet" => $occupationStreet,
//         "businessCategory" => $businessCategory,
//         "businessSize" => $businessSize,
//         "monthlyAverage" => $monthlyAverage,
//         "inquiryDate" => $inquiryDate,
//         "inquirySource" => $inquirySource,
//         "inquirySourceType" => $inquirySourceType,
//         "mallDisplay" => $mallDisplay,
//         "buyerType" => $buyerType,
//         "unitInquired" => $unitInquired,
//         "tamarawVariant" => $tamarawVariant,
//         "transactionType" => $transactionType,
//         "hasApplication" => $hasApplication,
//         "hasReservation" => $hasReservation,
//         "reservationDate" => $reservationDate,
//         "additionalUnit" => $additionalUnit,
//         "tamarawSpecificUsage" => $tamarawSpecificUsage,
//         "buyerDecisionHold" => $buyerDecisionHold,
//         "buyerDecisionHoldReason" => $buyerDecisionHoldReason,
//         "appointmentDate" => $appointmentDate,
//         "appointmentTime" => $appointmentTime
//     ]
// ]);

// $sql1 = "INSERT INTO sales_customer_tbl (
//     customer_firstname,
//     customer_middlename,
//     customer_lastname,
//     province,
//     municipality,
//     barangay,
//     street,
//     contact_number,
//     gender,
//     marital_status,
//     birthday,
//     occupation,
//     occupation_province,
//     occupation_municipality,
//     occupation_barangay,
//     occupation_street,
//     business_name,
//     business_category,
//     monthly_average
// ) VALUES (
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?,
//     ?
// )";
// $stmt1 = $conn->prepare($sql1);
// if (!$stmt1) {
//     header('Content-Type: application/json');
//     echo json_encode([
//         "status" => "internal-error",
//         "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//         "data" => $conn->error
//     ]);
//     exit();
// } else {
//     $stmt1->bind_param(
//         "ssssssssssssssssssssss",
//         $firstName,
//         $middleName,
//         $lastName,
//         $customerProvince,
//         $customerMunicipality,
//         $customerBarangay,
//         $customerStreet,
//         $contactNumber,
//         $gender,
//         $maritalStatus,
//         $birthday,
//         $occupation,
//         $occupationProvince,
//         $occupationMunicipality,
//         $occupationBarangay,
//         $occupationStreet,
//         $businessName,
//         $businessCategory,
//         $monthlyAverage
//     );

//     if(!$stmt1->execute()) {
//         header('Content-Type: application/json');
//         echo json_encode([
//             "status" => "internal-error",
//             "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//             "data" => $stmt1->error
//         ]);
//         exit();
//     }else{
//         $customerId = $stmt1->insert_id;
//         $stmt1->close();

//         $sql2 = "INSERT INTO sales_inquiries_tbl(
//             customer_id,
//             prospect_type,
//             inquiry_date,
//             inquiry_source,
//             inquiry_source_type,
//             mall,
//             buyer_type,
//             unit_inquired,
//             transaction_type,
//             has_application,
//             has_reservation,
//             reservation_date,
//             appointment_date,
//             appointment_time
//         ) VALUES (
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?,
//             ?
//         )";
//         $stmt2 = $conn->prepare($sql2);
//         if (!$stmt2) {
//             //Rollback $sql1/$stmt1
//             header('Content-Type: application/json');
//             echo json_encode([
//                 "status" => "internal-error",
//                 "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//                 "data" => $conn->error
//             ]);
//             exit();
//         }else{
//             $stmt2->bind_param(
//                 "issssssssiisss",
//                 $customerId,
//                 $prospectType,
//                 $inquiryDate,
//                 $inquirySource,
//                 $inquirySourceType,
//                 $mallDisplay,
//                 $buyerType,
//                 $unitInquired,
//                 $transactionType,
//                 $hasApplication,
//                 $hasReservation,
//                 $reservationDate,
//                 $appointmentDate,
//                 $appointmentTime
//             )
//             if(!$stmt2->execute()) {
//                 //Rollback $sql1/$stmt1
//                 header('Content-Type: application/json');
//                 echo json_encode([
//                     "status" => "internal-error",
//                     "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//                     "data" => $stmt2->error
//                 ]);
//                 exit();
//             }else{
//                 $inquiryId = $stmt2->insert_id;
//                 $stmt2->close();
//                 if($unitInquired =="TAMARAW"){
//                     $sql3 = "INSERT INTO sales_inquiries_tamaraw_tbl(
//                         inquiry_id,
//                         tamaraw_variane,
//                         additional_unit,
//                         tamaraw_specific_usage,
//                         buyer_decision_hold,
//                         buyer_decision_hold_reason
//                     ) VALUES(
//                         ?,
//                         ?,
//                         ?,
//                         ?,
//                         ?,
//                         ?
//                     )";
//                     $stmt3 = $conn->prepare($sql3);
//                     if(!$stmt3){
//                         //Rollback $sql1/$stmt1 & $sql2/$stmt2
//                         header('Content-Type: application/json');
//                         echo json_encode([
//                             "status" => "internal-error",
//                             "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//                             "data" => $conn->error
//                         ]);
//                         exit();
//                     }else{
//                         $stmt3->bind_param(
//                             "isssis",
//                             $inquiryId,
//                             $tamarawVariant,
//                             $additionalUnit,
//                             $tamarawSpecificUsage,
//                             $buyerDecisionHold,
//                             $buyerDecisionHoldReason
//                         );
//                         if(!$stmt3->execute()){
//                             //Rollback $sql1/$stmt1 & $sql2/$stmt2
//                             header('Content-Type: application/json');
//                             echo json_encode([
//                                 "status" => "internal-error",
//                                 "message" => "Failed to Create Inquiry. Please Contact the Programmer",
//                                 "data" => $stmt3->error
//                             ]);
//                             exit();
//                         }else{
//                             header('Content-Type: application/json');
//                             echo json_encode([
//                                 "status" => "success",
//                                 "message" => "Inquiry Created Successfully",
//                             ]);
//                         }
//                     }
//                 }else{
//                     header('Content-Type: application/json');
//                     echo json_encode([
//                         "status" => "success",
//                         "message" => "Inquiry Created Successfully",
//                     ]);
//                 }
//             }
//         }
//     }
// }