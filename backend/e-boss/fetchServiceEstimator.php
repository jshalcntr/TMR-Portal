<?php
require('../dbconn.php');

if (isset($_POST['position'])) {
    $position = mysqli_real_escape_string($conn, $_POST['position']);

    $query = "SELECT id, fullname FROM backorders_svc_advs_tbl WHERE position = '$position' ORDER BY fullname ASC";
    $result = mysqli_query($conn, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
