<?php
include 'db.php';
session_start();

if (isset($_POST['id'], $_POST['new_status'])) {
  $report_id = $_POST['id'];
  $new_status = $_POST['new_status'];

  $query = "UPDATE reports SET incident_status = ? WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("si", $new_status, $report_id);
  $stmt->execute();

 echo "<script>
          alert('Status updated successfully!');
          window.location.href = 'submitted_reports.php';
        </script>";
  exit();

}
?>