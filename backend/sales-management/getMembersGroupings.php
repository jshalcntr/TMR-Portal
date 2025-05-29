<?php

require "../dbconn.php";

$sql = "SELECT 
        sales_groupings_tbl.account_id,
        accounts_tbl.full_name,
        sections_tbl.section_name,
        sales_groups_tbl.group_initials,
        sales_groups_tbl.group_number
        FROM sales_groupings_tbl
        JOIN accounts_tbl ON sales_groupings_tbl.account_id = accounts_tbl.id
        JOIN sales_groups_tbl ON sales_groupings_tbl.group_id = sales_groups_tbl.group_id
        JOIN sections_tbl ON accounts_tbl.section = sections_tbl.section_id
        JOIN departments_tbl ON accounts_tbl.department = departments_tbl.department_id
        WHERE departments_tbl.department_name = 'Vehicle Sales'
        ";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Members Groupings. Please Contact the Programmer",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
} else {
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Members Groupings. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
    } else {
        $membersGroupingsResult = $stmt->get_result();
        $membersGroupings = [];
        while ($row = $membersGroupingsResult->fetch_assoc()) {
            $accountId = $row['account_id'];
            $fullName = $row['full_name'];
            $sectionName = $row['section_name'];
            $groupInitials = $row['group_initials'];
            $groupNumber = $row['group_number'];
            $membersGroupings[] = [
                "accountId" => $accountId,
                "fullName" => $fullName,
                "sectionName" => $sectionName,
                "groupInitials" => $groupInitials,
                "groupNumber" => $groupNumber
            ];
        }
        header('Content-Type: application/json');
        echo json_encode([
            "data" => $membersGroupings
        ]);
    }
}
