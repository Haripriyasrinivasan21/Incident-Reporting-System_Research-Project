<?php
include 'manager_header.php';
include 'db.php';

if (!isset($_SESSION["manager_id"])) {
    header("Location: manager_login.php");
    exit();
}

if (isset($_POST['task_id'])) {
  $id = $_POST['task_id'];
  $query = "DELETE FROM task_assignments WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  echo "<script>alert('Task Assignment deleted successfully.'); window.location.href='view_assignments.php';</script>";
} else {
  echo "<script>alert('Invalid deletion attempt.'); window.location.href='view_assignments.php';</script>";
}
?>