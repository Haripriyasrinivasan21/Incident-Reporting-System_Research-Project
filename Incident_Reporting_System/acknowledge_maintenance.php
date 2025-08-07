<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$event_id = $_GET['id'];

    echo "<script>alert('Thank you for your acknowledgment. If any actions are required, you will be notified promptly. We appreciate your commitment to maintaining a safe and transparent reporting environment 😊'); window.location.href='user_dashboard.php';</script>";

?>
