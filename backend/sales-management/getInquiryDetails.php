<?php
session_start();
include('../dbconn.php');
include('../middleware/pipes.php');

$inquiryId = $_GET['inquiryId'];

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
        sales_customers_tbl.marital_status,
        sales_customers_tbl.birthday,
        sales_customers_tbl.occupation,
        sales_customers_tbl.occupation_province,
        sales_customers_tbl.occupation_municipality,
        sales_customers_tbl.occupation_barangay,
        sales_customers_tbl.occupation_street,
        sales_customers_tbl.business_name,
        sales_customers_tbl.business_category,
        sales_customers_tbl.business_size,
        sales_customers_tbl.monthly_average,
        sales_inquiries_history_tbl.inquiry_id,
        sales_inquiries_history_tbl.prospect_type,
        sales_inquiries_history_tbl.inquiry_date,
        sales_inquiries_history_tbl.inquiry_source,
        sales_inquiries_history_tbl.inquiry_source_type,
        sales_inquiries_history_tbl.mall,
        sales_inquiries_history_tbl.buyer_type,
        sales_inquiries_history_tbl.unit_inquired,
        sales_inquiries_history_tbl.transaction_type,
        sales_inquiries_history_tbl.has_application,
        sales_inquiries_history_tbl.has_reservation,
        sales_inquiries_history_tbl.reservation_date,
        sales_inquiries_history_tbl.appointment_date,
        sales_inquiries_history_tbl.appointment_time,
        sales_inquiries_tbl.agent_id,
        sales_inquiries_tamaraw_history_tbl.tamaraw_variant,
        sales_inquiries_tamaraw_history_tbl.additional_unit,
        sales_inquiries_tamaraw_history_tbl.tamaraw_specific_usage,
        sales_inquiries_tamaraw_history_tbl.buyer_decision_hold,
        sales_inquiries_tamaraw_history_tbl.buyer_decision_hold_reason
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
        LEFT JOIN sales_inquiries_tamaraw_history_tbl
            ON sales_inquiries_history_tbl.history_id = sales_inquiries_tamaraw_history_tbl.history_id
        WHERE sales_inquiries_tbl.inquiry_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Inquiry Details. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $inquiryId);
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inquiry Details. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $inquiry = [];
        $inquiryResult = $stmt->get_result();
        while ($inquiryRow = $inquiryResult->fetch_assoc()) {
            foreach ($inquiryRow as $key => $value) {
                if (is_string($value)) {
                    $inquiryRow[$key] = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                }
            }
            $inquiry[] = $inquiryRow;
        }
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "message" => "Inquiry Details Fetched Successfully!",
            "data" => $inquiry
        ]);
    }
}
