<?php
include('../dbconn.php');
session_start();

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    function sanitize($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    $clientFirstName = sanitize($_POST['clientFirstName'] ?? '');
    $clientMiddleName = sanitize($_POST['clientMiddleName'] ?? '');
    $clientLastName = sanitize($_POST['clientLastName'] ?? '');
    $csNumber = sanitize($_POST['csNumber'] ?? '');
    $inquiryDate = $_POST['inquiryDate'] ?? '';
    $phone = sanitize($_POST['phone'] ?? '');
    $birthDate = $_POST['birthDate'] ?? '';
    $gender = sanitize($_POST['gender'] ?? '');
    $maritalStatus = sanitize($_POST['maritalStatus'] ?? '');
    $jobLevel = sanitize($_POST['jobLevel'] ?? '');
    $workNature = sanitize($_POST['workNature'] ?? '');
    $profession = sanitize($_POST['profession'] ?? '');
    $businessNature = sanitize($_POST['businessNature'] ?? '');
    $jobDemo = sanitize($_POST['jobDemo'] ?? '');
    $businessSize = sanitize($_POST['businessSize'] ?? '');
    $householdIncome = sanitize($_POST['householdIncome'] ?? '');
    $salesSource = sanitize($_POST['salesSource'] ?? '');
    $referralSource = sanitize($_POST['referralSource'] ?? '');
    $repeatClient = sanitize($_POST['repeatClient'] ?? '');
    $mallDisplay = sanitize($_POST['mallDisplay'] ?? '');
    $tamarawRelease = sanitize($_POST['tamarawRelease'] ?? '');
    $releaseManner = sanitize($_POST['releaseManner'] ?? '');
    $releaseDate = $_POST['releaseDate'] ?? null;
    $reservationMode = $_POST['reservationMode'] ?? null;
    $releaseMode = $_POST['releaseMode'] ?? null;
    $far = sanitize($_POST['far'] ?? '');
    $customerPreference = sanitize($_POST['customerPreference'] ?? '');
    $tintShade = sanitize($_POST['tintShade'] ?? '');
    $createdBy = $_SESSION['user']['id'];


    // Prepare SQL query //store it first inside the variable (sql) then inclue it inside the statement
    $sql = "INSERT INTO sales_subprofilings_tbl (
        client_first_name, client_middle_name, client_last_name, conduction_sticker_number, inquiry_date,
        phone, birth_date, gender, marital_status, job_level,
        work_nature, profession_source, business_nature_source, job_demo_source,
        business_size_source, household_income, sales_source, referral_source,
        repeat_client_source, mall_display_source, tamaraw_release, manner_of_release, release_date,
        mode_of_release, reservation_mode, far, customer_preference, tint_shade, created_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Check if the prepared statement was successfully created
    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add Sub Profile. Please Contact the Programmer",
            "data" => $conn->error
        ]);
    } else {
        // Bind parameters to the prepared statement
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
            $profession,
            $businessNature,
            $jobDemo,
            $businessSize,
            $householdIncome,
            $salesSource,
            $referralSource,
            $repeatClient,
            $mallDisplay,
            $tamarawRelease,
            $releaseManner,
            $releaseDate,
            $releaseMode,
            $reservationMode,
            $far,
            $customerPreference,
            $tintShade,
            $createdBy
        );

        // Execute the prepared statement
        if (!$stmt->execute()) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Add Sub Profile. Please Contact the Programmer",
                "data" => $stmt2->error
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "success",
                "message" => "Item Added to Sub Profiling Successfully!"
            ]);
        }
    }
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
