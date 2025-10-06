<?php
require('../dbconn.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    $sql = "UPDATE backorders_tbl SET order_status = 'Delivered' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
