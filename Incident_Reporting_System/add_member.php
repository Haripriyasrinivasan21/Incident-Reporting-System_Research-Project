<?php
include 'manager_header.php';
include 'db.php';

// Fix: Only start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure only logged-in clients can access
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['phone'], $_POST['role'])) {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $role       = $_POST['role'];

    // Insert into handlers table
    $query = "INSERT INTO team_members (first_name, last_name, email, phone, role, created_at)
              VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $role);
    $stmt->execute();

   echo "<script>
  alert('✅ Member added successfully!');
  window.location.href = 'team_directory.php';
</script>";

  }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 col-lg-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="text-center mb-4">👥 Add a New Incident Handler</h3>
                
                <form method="POST">
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" placeholder="Enter their first name" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Enter their last name" required>
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter their email address" required>
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" pattern="[0-9+\- ]{7,15}" placeholder="Enter their phone number" required>
                    </div>

                    <!-- Role Dropdown -->
                    <div class="mb-3">
                        <label for="role" class="form-label">Designation</label>
                        <select name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="Analyst">Analyst</option>
                            <option value="Investigator">Investigator</option>
                            <option value="Reviewer">Reviewer</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-success w-50">➕ Add Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
$footer_file = 'manager_footer.php';
if (file_exists($footer_file)) {
    include $footer_file;
} else {
    echo "<p class='text-center text-muted'>Footer file missing</p>";
}
?>