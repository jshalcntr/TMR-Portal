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

    $client_first_name = sanitize($_POST['client_first_name'] ?? '');
    $client_middle_name = sanitize($_POST['client_middle_name'] ?? '');
    $client_last_name = sanitize($_POST['client_last_name'] ?? '');
    $conduction_sticker_number = sanitize($_POST['conduction_sticker_number'] ?? '');
    $inquiry_date = $_POST['inquiry_date'] ?? '';
    $phone = sanitize($_POST['phone'] ?? '');
    $birth_date = $_POST['birth_date'] ?? '';
    $gender = sanitize($_POST['gender'] ?? '');
    $marital_status = sanitize($_POST['marital_status'] ?? '');
    $job_level = sanitize($_POST['job_level'] ?? '');
    $work_nature = sanitize($_POST['work_nature'] ?? '');
    $profession_source = sanitize($_POST['profession_source'] ?? '');
    $business_nature_source = sanitize($_POST['business_nature_source'] ?? '');
    $job_demo_source = sanitize($_POST['job_demo_source'] ?? '');
    $business_size_source = sanitize($_POST['business_size_source'] ?? '');
    $household_income = sanitize($_POST['household_income'] ?? '');
    $sales_source = sanitize($_POST['sales_source'] ?? '');
    $referral_source = sanitize($_POST['referral_source'] ?? '');
    $repeat_client_source = sanitize($_POST['repeat_client_source'] ?? '');
    $mall_display_source = sanitize($_POST['mall_display_source'] ?? '');
    $tamaraw_release = sanitize($_POST['tamaraw_release'] ?? '');
    $manner_of_release = sanitize($_POST['manner_of_release'] ?? '');
    $technical_source = $_POST['technical_source'] ?? null;
    $reservation_mode = $_POST['mode_of_release'] ?? null;
    $mode_of_release = $_POST['reservation_mode'] ?? null;
    $far = sanitize($_POST['far'] ?? '');
    $customer_preference = sanitize($_POST['customer_preference'] ?? '');
    $tint_shade = sanitize($_POST['tint_shade'] ?? '');

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO sales_subprofilings_tbl (
        client_first_name, client_middle_name, client_last_name, conduction_sticker_number, inquiry_date,
        phone, birth_date, gender, marital_status, job_level,
        work_nature, profession_source, business_nature_source, job_demo_source,
        business_size_source, household_income, sales_source, referral_source,
        repeat_client_source, mall_display_source, tamaraw_release, manner_of_release, technical_source,
        mode_of_release, reservation_mode, far, customer_preference, tint_shade
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Check if the prepared statement was successfully created
    if ($stmt === false) {
        die('SQL prepare failed: ' . $conn->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param(
        "ssssssssssssssssssssssssssss",
        $client_first_name,
        $client_middle_name,
        $client_last_name,
        $conduction_sticker_number,
        $inquiry_date,
        $phone,
        $birth_date,
        $gender,
        $marital_status,
        $job_level,
        $work_nature,
        $profession_source,
        $business_nature_source,
        $job_demo_source,
        $business_size_source,
        $household_income,
        $sales_source,
        $referral_source,
        $repeat_client_source,
        $mall_display_source,
        $tamaraw_release,
        $manner_of_release,
        $technical_source,
        $mode_of_release,
        $reservation_mode,
        $far,
        $customer_preference,
        $tint_shade
    );

    // Execute the prepared statement
    if ($stmt->execute()) {
        header("Location: ../../modules/sales-management/subProfiling.php");
        exit();
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
