<?php
require('dbconn.php');

if (!isset($_SESSION["user"])) {
    session_destroy();
    header("Location:../../index.php");
    exit();
}

if ($_SESSION['user']['role'] == "HEAD") {
    $divsize = "col-md-3";
    $divhidden = "";
    $forApprovalId = "departmentticketCountDisplay";
} else {
    $divsize = "col-md-4";
    $divhidden = "hidden";
    $forApprovalId = "userticketCountDisplay";
}
