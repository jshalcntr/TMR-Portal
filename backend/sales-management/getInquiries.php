<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../dbconn.php');
header('Content-Type: application/json');

$sql = "SELECT 
    i.inquiry_id AS id,
    CONCAT(c.customer_firstname, ' ', c.customer_lastname) AS customerFirstName,
    i.inquiry_date AS inquiryDate,
    i.inquiry_source AS inquirySource,
    c.contact_number AS contactNumber,
    c.gender,
    c.marital_status AS maritalStatus,
    c.birthday,
    i.prospect_type AS prospectType
FROM sales_inquiries_tbl i
JOIN sales_customers_tbl c ON i.customer_id = c.customer_id
WHERE i.prospect_type IN ('Hot', 'Warm', 'Cold')";

$result = $conn->query($sql);
$data = [];

if (!$result) {
    echo json_encode([
        "status" => "error",
        "message" => "SQL error",
        "sql" => $sql,
        "error" => $conn->error
    ]);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => "success",
    "data" => $data
]);

$conn->close();
