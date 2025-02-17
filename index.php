<?php
session_start();

if (isset($_SESSION['user'])) {
    $userData = $_SESSION['user'];
    header('Location: modules/shared/dashboard.php');
} else {
    header('Location: login.php');
}
