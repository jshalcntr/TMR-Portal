<?php
session_start();
include ('../../dbconn.php');
require ('../../auth.php');
if (isset($_GET['subject'])) {
    $subject = mysqli_real_escape_string($conn, $_GET['subject']);
    $category = mysqli_real_escape_string($conn, $_GET['category']);
    $userId = $_SESSION['user']['id'];
    // Query to fetch tickets with similar subjects and contents
    // $query = "SELECT * FROM ticket_records_tbl WHERE ticket_subject LIKE '%$subject%' and ticket_type LIKE '%$category%' ";
    $query = "SELECT 
        ticket_records_tbl.*,
        requestor.full_name AS requestor_name
    FROM 
        ticket_records_tbl
    JOIN 
        accounts_tbl AS requestor ON ticket_records_tbl.ticket_requestor_id = requestor.id
    WHERE 
        ticket_records_tbl.ticket_subject LIKE '%$subject%' 
        AND ticket_records_tbl.ticket_type LIKE '%$category%'
";
    $result = mysqli_query($conn, $query);

    $similarTickets = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $similarTickets[] = $row ;
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($similarTickets);
}
?>
