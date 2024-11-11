<?php
require('dbconn.php');

if (!isset($_SESSION["user"])) {
    session_destroy();
    header("Location:../../index.php");
    exit();
}



// Assuming you have already authenticated the user
$userId = $_SESSION['user']; // Retrieve user_id from session

// Fetch user's department
$sql = "SELECT department, role FROM accounts_tbl WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_department'] = $row['department']; // Store department in session
        if ($row['role'] = "HEAD") {
            $divsize = "col-md-3";
            $divhidden = "";
        }else{
            $divsize = "col-md-4";
            $divhidden = "hidden";
        }
    }
    
    $stmt->close();
}
?>