<?php
require('../dbconn.php');
session_start();
if (isset($_POST['position'])) {
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    $query = "SELECT id, full_name FROM accounts_tbl WHERE section = '$position' ORDER BY full_name ASC";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
