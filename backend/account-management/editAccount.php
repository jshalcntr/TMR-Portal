<?php
require('../dbconn.php');
$id = $_POST['id'];
$fullName = $_POST['fullName'];
$username = $_POST['username'];
$role = $_POST['role'];
$department = $_POST['department'];
$section = $_POST['section'];
$inventoryViewAuth = isset($_POST['inventoryView']) ? $_POST['inventoryView'] : 0;
$inventoryEditAuth = isset($_POST['inventoryEdit']) ? $_POST['inventoryEdit'] : 0;
$inventorySuperAuth = isset($_POST['inventorySuper']) ? $_POST['inventorySuper'] : 0;
$accountsViewAuth = isset($_POST['accountsView']) ? $_POST['accountsView'] : 0;
$accountsEditAuth = isset($_POST['accountsEdit']) ? $_POST['accountsEdit'] : 0;
$accountsSuperAuth = isset($_POST['accountsSuper']) ? $_POST['accountsSuper'] : 0;

$sql1 = "UPDATE accounts_tbl SET full_name = ?, username = ?, role = ?, department = ?, section = ? WHERE id = ?";
$stmt1 = $conn->prepare($sql1);

if (!$stmt1) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "internal-error",
        "message" => "Failed to Edit Account. Please Contact the Programmer",
        "data" => $conn->error
    ]);
} else {
    $stmt1->bind_param("sssssi", $fullName, $username, $role, $department, $section, $id);
    if (!$stmt1->execute()) {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "internal-error",
            "message" => "Failed to Edit Account. Please Contact the Programmer",
            "data" => $stmt1->error
        ]);
    } else {
        $sql2 = "UPDATE authorizations_tbl SET inventory_view_auth = ?, inventory_edit_auth = ?, inventory_super_auth = ?, accounts_view_auth = ?, accounts_edit_auth = ?, accounts_super_auth = ? WHERE account_id = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            header('Content-Type: application/json');
            echo json_encode([
                "status" => "internal-error",
                "message" => "Failed to Edit Account. Please Contact the Programmer",
                "data" => $conn->error
            ]);
        } else {
            $stmt2->bind_param("iiiiiii", $inventoryViewAuth, $inventoryEditAuth, $inventorySuperAuth, $accountsViewAuth, $accountsEditAuth, $accountsSuperAuth, $id);
            if (!$stmt2->execute()) {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "internal-error",
                    "message" => "Failed to Edit Account. Please Contact the Programmer",
                    "data" => $stmt2->error
                ]);
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    "status" => "success",
                    "message" => "Account Updated Successfully!"
                ]);
            }
        }
    }
}
