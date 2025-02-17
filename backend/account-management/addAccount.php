<?php

require('../dbconn.php');

$fullName = $_POST['fullName'];
$username = $_POST['username'];
$password = password_hash("Initial@1", PASSWORD_DEFAULT);
$role = $_POST['role'];
$department = $_POST['department'];
$status = "Active";
$inventoryViewAuth = isset($_POST['inventoryView']) ? $_POST['inventoryView'] : 0;
$inventoryEditAuth = isset($_POST['inventoryEdit']) ? $_POST['inventoryEdit'] : 0;
$accountsViewAuth = isset($_POST['accountsView']) ? $_POST['accountsView'] : 0;
$accountsEditAuth = isset($_POST['accountsEdit']) ? $_POST['accountsEdit'] : 0;

$sql = "INSERT INTO accounts_tbl(username, password, full_name, role, department, status)
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt1 = $conn->prepare($sql);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Add Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt1->bind_param("ssssss", $username, $password, $fullName, $role, $department, $status);
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Add Account. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        $accountId = $stmt1->insert_id;
        $sql2 = "INSERT INTO authorizations_tbl(account_id, inventory_view_auth, inventory_edit_auth, accounts_view_auth, accounts_edit_auth)
                 VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Add Account. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("iiiii", $accountId, $inventoryViewAuth, $inventoryEditAuth, $accountsViewAuth, $accountsEditAuth);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Add Account. Please Contact the Programmer",
                    "data" => $stmt2->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Account Added Successfully! <br><b>Password:</b> Initial@1"
                ]);
            }
        }
    }
}
