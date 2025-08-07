<?php
include 'db.php';

$admin_email = "admin@gmail.com";
$admin_phone = "7523698523";
$admin_password = password_hash("Admin@123", PASSWORD_BCRYPT);
$role = "admin";

// Assign first name and last name to variables
$first_name = "Admin";
$last_name = "User";

// Check if admin already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $admin_email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    $stmt->close(); // Close previous statement before creating a new one

    // Insert admin details
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $admin_phone, $admin_email, $admin_password, $role);
    
    if ($stmt->execute()) {
        echo "Admin account created successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Admin account already exists!";
}

$stmt->close();
$conn->close();
?>
