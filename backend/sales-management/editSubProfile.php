<?php
include('../dbconn.php');

header('Content-Type: application/json');

// After reading $_POST variables
$id = isset($_POST['id']) ? (int) trim($_POST['id']) : 0;
$id = $_POST['id'] ?? null;
$clientFirstName = $_POST['clientFirstName'] ?? '';
$clientMiddleName = $_POST['clientMiddleName'] ?? '';
$clientLastName = $_POST['clientLastName'] ?? '';
$csNumber = $_POST['csNumber'] ?? '';
$inquiryDate = $_POST['inquiryDate'] ?? '';
$phone = $_POST['phone'] ?? '';
$birthDate = $_POST['birthDate'] ?? '';
$gender = $_POST['gender'] ?? '';
$maritalStatus = $_POST['maritalStatus'] ?? '';
$jobLevel = $_POST['jobLevel'] ?? '';
$workNature = $_POST['workNature'] ?? '';
$professionSource = $_POST['professionSource'] ?? '';
$businessNatureSource = $_POST['businessNatureSource'] ?? '';
$jobDemoSource = $_POST['jobDemo'] ?? '';
$businessSizeSource = $_POST['businessSizeSource'] ?? '';
$householdIncome = $_POST['householdIncome'] ?? '';
$salesSource = $_POST['salesSource'] ?? '';
$referralSource = $_POST['referral'] ?? '';
$repeatClientSource = $_POST['repeatClient'] ?? '';
$mallDisplaySource = $_POST['mallDisplay'] ?? '';
$tamarawRelease = $_POST['tamarawRelease'] ?? '';
$mannerOfRelease = $_POST['releaseManner'] ?? '';
$releaseDate = $_POST['releaseDate'] ?? '';
$modeOfRelease = $_POST['releaseMode'] ?? '';
$reservationMode = $_POST['reservationMode'] ?? '';
$far = $_POST['far'] ?? '';
$customerPreference = $_POST['customerPreference'] ?? '';
$tintShade = $_POST['tintShade'] ?? '';

if (!$id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID is required.'
    ]);
    exit;
}

$sql = "UPDATE sales_subprofilings_tbl SET 
    client_first_name = ?,
    client_middle_name = ?,
    client_last_name = ?,
    conduction_sticker_number = ?,
    inquiry_date = ?,
    phone = ?,
    birth_date = ?,
    gender = ?,
    marital_status = ?,
    job_level = ?,
    work_nature = ?,
    profession_source = ?,
    business_nature_source = ?,
    job_demo_source = ?,
    business_size_source = ?,
    household_income = ?,
    sales_source = ?,
    referral_source = ?,
    repeat_client_source = ?,
    mall_display_source = ?,
    tamaraw_release = ?,
    manner_of_release = ?,
    release_date = ?,
    mode_of_release = ?,
    reservation_mode = ?,
    far = ?,
    customer_preference = ?,
    tint_shade = ?
WHERE subprofile_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode([
        "status" => "internal-error",
        "message" => "Prepare failed: " . $conn->error,
    ]);
    exit;
}

$stmt->bind_param(
    "ssssssssssssssssssssssssssssi",
    $clientFirstName,
    $clientMiddleName,
    $clientLastName,
    $csNumber,
    $inquiryDate,
    $phone,
    $birthDate,
    $gender,
    $maritalStatus,
    $jobLevel,
    $workNature,
    $professionSource,
    $businessNatureSource,
    $jobDemoSource,
    $businessSizeSource,
    $householdIncome,
    $salesSource,
    $referralSource,
    $repeatClientSource,
    $mallDisplaySource,
    $tamarawRelease,
    $mannerOfRelease,
    $releaseDate,
    $modeOfRelease,
    $reservationMode,
    $far,
    $customerPreference,
    $tintShade,
    $id
);

if (!$stmt->execute()) {
    echo json_encode([
        "status" => "internal-error",
        "message" => "Execute failed: " . $stmt->error,
    ]);
    exit;
}

if ($stmt->affected_rows === 0) {
    echo json_encode([
        "status" => "no-change",
        "message" => "No records were updated. Please check if the ID exists.",
    ]);
    exit;
}

echo json_encode([
    "status" => "success",
    "message" => "Profile Edited Successfully!",
]);
exit;
