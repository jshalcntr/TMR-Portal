<?php

require "../dbconn.php";

$sql = "SELECT
    accounts_tbl.id,
    accounts_tbl.full_name,
    sections_tbl.section_name,
    departments_tbl.department_name
    FROM accounts_tbl
    JOIN sections_tbl ON accounts_tbl.section = sections_tbl.section_id
    JOIN departments_tbl ON accounts_tbl.department = departments_tbl.department_id
    WHERE department_name = 'Vehicle Sales'
    AND NOT EXISTS (
        SELECT account_id
        FROM sales_groupings_tbl
        WHERE sales_groupings_tbl.account_id = accounts_tbl.id
    );";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Groupless Member. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Groupless Member. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $result = $stmt->get_result();
        $groups = [];
        while ($group = $result->fetch_assoc()) {
            $groups[] = $group;
        }
        header("Content-type: application/json");
        echo json_encode([
            "status" => "success",
            "data" => $groups
        ]);
    }
}
