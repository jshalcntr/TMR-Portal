<?php
require('../dbconn.php');
session_start();
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $reason = $_POST['reason'];

    $sql = "UPDATE backorders_tbl SET order_status = 'Cancelled', cancel_reason = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $reason, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
