<?php
require "../dbconn.php";

$queriedId = $_GET['queriedId'];

$sql = "SELECT * FROM accounts_tbl
        JOIN authorizations_tbl ON accounts_tbl.id = authorizations_tbl.account_id
        WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to fetch Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt->bind_param("i", $queriedId);
    if (!$stmt->execute()) {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to fetch Account. Please Contact the Programmer",
            "data" => $stmt->error
        ]);
        $stmt->close();
        exit;
    } else {
        $account = [];
        $accountResult = $stmt->get_result();
        while ($row = $accountResult->fetch_assoc()) {
            $account[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $account
        ]);
    }
}
