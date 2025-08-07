<?php
include 'db.php';
session_start();

if (isset($_POST['id'])) {
  $report_id = $_POST['id'];

  $query = "DELETE FROM reports WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $report_id);
  $stmt->execute();

    if ($stmt->execute()) {
        // Redirect back to the verify users page with success message
        //header("Location: submitted_reports.php?success=Deleted the Report successfully");
        echo "<script>
    alert('🗑️ Deleted the Report successfully');
    window.location.href = 'submitted_reports.php';
  </script>";
    } else {
        // Redirect back with an error message
        //header("Location: submitted_reports.php?error=Failed to delete user");
        echo "<script>
    alert('Failed to delete report.');
    window.location.href = 'submitted_reports.php';
  </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if no ID is provided
    //header("Location: submitted_reports.php?error=Invalid request");
    echo "<script>
    alert('Invalid request!');
    window.location.href = 'submitted_reports.php';
  </script>";
    exit();
}
?>