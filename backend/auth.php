<?php
session_start();
if (!isset($_SESSION["id"])) {
    session_destroy();
    header("Location:index.php");
    exit();
}
?>

<?php



// Assuming you have already authenticated the user
$userId = $_SESSION['id']; // Retrieve user_id from session

// Fetch user's department
$sql = "SELECT department FROM accounts WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $_SESSION['user_department'] = $row['department']; // Store department in session
    }

    $stmt->close();
}
?>