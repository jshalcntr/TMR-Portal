<?php
include '../dbconn.php';

$sql = "SELECT DISTINCT YEAR(h.inquiry_date) AS inquiry_year
        FROM sales_inquiries_history_tbl h
        INNER JOIN (
            SELECT inquiry_id, MAX(version) AS max_version
            FROM sales_inquiries_history_tbl
            GROUP BY inquiry_id
        ) latest
        ON h.inquiry_id = latest.inquiry_id AND h.version = latest.max_version
        WHERE h.inquiry_date IS NOT NULL AND h.inquiry_date <> '0000-00-00'
        ORDER BY inquiry_year DESC;";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "There's an error regarding Inquiries Date Dropdown. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    if (!$stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "There's an error regarding Inquiries Date Dropdown. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $result = $stmt->get_result();
        $inquiryYears = [];
        while ($row = $result->fetch_assoc()) {
            $inquiryYears[] = $row;
        }
        $stmt->close();
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $inquiryYears
        ]);
    }
}
