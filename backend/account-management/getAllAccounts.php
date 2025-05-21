<?php
session_start();
require "../dbconn.php";
require "../middleware/pipes.php";

$sql = "SELECT * FROM accounts_tbl
        JOIN authorizations_tbl ON accounts_tbl.id = authorizations_tbl.account_id
        JOIN departments_tbl ON accounts_tbl.department = departments_tbl.department_id
        WHERE id <> ? ";
if ($_SESSION['user']['accounts_edit_auth']) {
    $sql .= " AND authorizations_tbl.accounts_super_auth <> 1";
}
$stmt = $conn->prepare($sql);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $_SESSION['user']['id']);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Inventory. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $account = [];
        $accountResult = $stmt->get_result();
        while ($accountRow = $accountResult->fetch_assoc()) {
            $account[] = [
                "id" => $accountRow['id'],
                "fullName" => $accountRow['full_name'],
                "username" => $accountRow['username'],
                "role" => $accountRow['role'],
                "profilePicture" => $accountRow['profile_picture'],
                "department" => $accountRow['department_name'],
                "status" => $accountRow['status'],
                "accountEditAuth" => $_SESSION['user']['accounts_edit_auth'],
            ];
        }
        $stmt->close();

        header("Content-type: application/json");
        echo json_encode([
            "data" => $account,
            "status" => "success",
        ]);
    }
}
