<?php
require('dbconn.php');

if (!isset($_SESSION["user"])) {
    session_destroy();
    header("Location: /tmr-portal/index.php");
    exit();
}

if ($_SESSION['user']['role'] == "HEAD") {
    $divsize = "col-lg-3";
    $divhidden = "";
    $forApprovalId = "departmentticketCountDisplay";
} else {
    $divsize = "col-lg-4";
    $divhidden = "hidden";
    $forApprovalId = "userticketCountDisplay";
}
