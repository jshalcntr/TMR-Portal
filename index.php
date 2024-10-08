<?php
session_start();

if (isset($_SESSION['user'])) {
    $userData = $_SESSION['user'];

    if ($userData['role'] == "ADMIN") {
        header('Location: views/admin/dashboard.php');
    } else if ($userData['role'] == "USER" || $userData['role'] == "HEAD") {
        header('Location: views/user/dashboard.php');
    } else if ($userData['role'] == "S-ADMIN") {
        header('Location: views/s-admin/dashboard.php');
    }
} else {
    header('Location: login.php');
}
