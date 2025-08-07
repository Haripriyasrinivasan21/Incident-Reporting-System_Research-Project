<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'reporter';

    // Check if phone or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone = ? OR email = ?");
    $stmt->bind_param("ss", $phone, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $message = "Phone number or email is already registered!";
        $alertType = "danger";
    } else {
        // Insert customer details
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, phone, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $phone, $email, $password, $role);
        if ($stmt->execute()) {
            $message = "Sign-up successful! Taking you to the login page...";
            $alertType = "success";
            echo "<script>setTimeout(() => window.location.href='login.php', 2000);</script>";
        } else {
            $message = "Error: " . $stmt->error;
            $alertType = "danger";
        }
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporter Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: url('images/bg.png') center center fixed;}

        .container { max-width: 500px; margin-top: 50px; }
        .card { padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-primary { width: 100%; }
        .alert { text-align: center; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2 class="text-center">Create account as Incident Reporter</h2>
        
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= $alertType ?>" role="alert"><?= $message ?></div>
        <?php endif; ?>

        <form method="post" onsubmit="return validateForm()">
            <div class="mb-3">
                <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Phone Number" pattern="\d{10}" title="Enter a valid 10-digit phone number" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                <small id="passwordHelp" class="form-text text-muted">Password must be at least 8 characters.</small>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
        
        <p class="mt-3 text-center">Already registered? <a href="login.php">Login here</a></p>
    </div>
</div>

<script>
    function validateForm() {
        let password = document.getElementById("password").value;
        if (password.length < 8) {
            alert("Password must be at least 8 characters long.");
            return false;
        }
        return true;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
