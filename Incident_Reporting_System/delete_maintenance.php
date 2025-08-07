<?php
include 'admin_header.php';
include 'db.php';

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM maintenance WHERE id=?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_maintenance.php");
    exit();
} else {
    echo "<p style='color:red;'>Error deleting maintenance.</p>";
}

?>
