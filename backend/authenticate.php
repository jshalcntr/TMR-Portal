<?php
session_start();
require('dbconn.php');
session_unset();
// session_write_close();

$username = $_POST['username'];
$password = $_POST['password'];

$authenticateSql = "SELECT accounts_tbl.id,
                    accounts_tbl.username,
                    accounts_tbl.password,
                    accounts_tbl.full_name,
                    accounts_tbl.role,
                    accounts_tbl.profile_picture,
                    accounts_tbl.department,
                    accounts_tbl.section,
                    accounts_tbl.status,
                    departments_tbl.department_name,
                    sections_tbl.section_name,
                    authorizations_tbl.*
                    FROM accounts_tbl
                    JOIN authorizations_tbl ON accounts_tbl.id = authorizations_tbl.account_id
                    LEFT JOIN departments_tbl ON accounts_tbl.department = departments_tbl.department_id 
                    LEFT JOIN sections_tbl ON accounts_tbl.section = sections_tbl.section_id
                    WHERE username = ? ";
$stmt = $conn->prepare($authenticateSql);
$stmt->bind_param("s", $username);

if (!$stmt->execute()) {
    header("Content-type: application/json");
    echo json_encode([
        "status" => "error",
        "message" => "Internal Error. Please Contact MIS",
        "data" => $conn->error
    ]);
    $stmt->close();
    exit;
}

$accountResult = $stmt->get_result();

if ($accountResult->num_rows > 0) {
    $accountRes = $accountResult->fetch_assoc();
    $authenticatedPassword = $accountRes['password'];
    $authenticatedId = $accountRes['id'];

    if (password_verify($password, $authenticatedPassword)) {
        if ($accountRes['status'] == 'Active') {
            $_SESSION['user'] = $accountRes;
            header("Content-type: application/json");
            echo json_encode([
                "status" => "success",
                "message" => "Login Successful",
                "data" => $accountRes
            ]);
        } else {
            header("Content-type: application/json");
            echo json_encode([
                "status" => "failed",
                "message" => "Account is Inactive, Please Contact Administrator"
            ]);
        }
    } else {
        header("Content-type: application/json");
        echo json_encode([
            "status" => "failed",
            "message" => "Incorrect Password."
        ]);
    }
} else {
    header("Content-type: application/json");
    echo json_encode([
        "status" => "failed",
        "message" => "Account doesn't exist"
    ]);
}

$stmt->close();
