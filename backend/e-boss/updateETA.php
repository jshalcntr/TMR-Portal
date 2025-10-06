<?php
require('../dbconn.php');

if (isset($_POST['id']) && isset($_POST['eta_date'])) {
    $id = intval($_POST['id']);
    $eta_date = $_POST['eta_date'];

    $sql = "UPDATE backorders_tbl SET eta_1 = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $eta_date, $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
