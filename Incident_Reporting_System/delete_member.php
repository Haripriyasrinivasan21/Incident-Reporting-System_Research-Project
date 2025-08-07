<?php
include 'manager_header.php';
include 'db.php';

if (isset($_POST['handler_id'])) {
  $id = $_POST['handler_id'];

  // Optional: log deletion action, store who deleted what

  $query = "DELETE FROM team_members WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  echo "<script>
    alert('🗑️ Member deleted successfully.');
    window.location.href = 'team_directory.php';
  </script>";
} else {
  echo "<script>
    alert('⚠️ Invalid request. No member selected.');
    window.location.href = 'team_directory.php';
  </script>";
}
?>