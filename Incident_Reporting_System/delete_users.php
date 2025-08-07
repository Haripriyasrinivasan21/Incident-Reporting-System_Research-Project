<?php
include 'db.php'; // Ensure the database connection file is included

if (isset($_GET['id'])) {
    $dining_id = intval($_GET['id']); // Ensure ID is an integer to prevent SQL injection

    // Delete query
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $dining_id);

    if ($stmt->execute()) {
        // Redirect back to the verify users page with success message
        //header("Location: verify_users.php?success=Deleted the Invalid User successfully");
        echo "<script>
    alert('🗑️ Deleted the Invalid User successfully');
    window.location.href = 'verify_users.php.php';
  </script>";
    } else {
        // Redirect back with an error message
        //header("Location: verify_users.php?error=Failed to delete user");
        echo "<script>
    alert('Failed to delete user');
    window.location.href = 'verify_users.php.php';
  </script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if no ID is provided
    //header("Location: verify_users.php?error=Invalid request");
    echo "<script>
    alert('Invalid request');
    window.location.href = 'verify_users.php.php';
  </script>";
    exit();
}
?>
