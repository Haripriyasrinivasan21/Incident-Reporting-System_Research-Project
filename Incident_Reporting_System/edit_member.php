<?php
include 'manager_header.php';
include 'db.php';

// Ensure only logged-in clients can access
if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

// Load handler details from POST
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('No handler selected.'); window.location.href='team_directory.php';</script>";
    exit();
}


$query = "SELECT * FROM team_members WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$handler = $result->fetch_assoc();

if (!$handler) {
    echo "<script>alert('Handler not found.'); window.location.href='team_directory.php';</script>";
    exit();
}

// Handle update after form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name  = $_POST['last_name'];
    $email      = $_POST['email'];
    $phone      = $_POST['phone'];
    $role       = $_POST['role'];

    $update = "UPDATE team_members SET first_name=?, last_name=?, email=?, phone=?, role=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $phone, $role, $id);
    if ($stmt->execute()) {
       echo "<script>alert('✅ Member details updated successfully!'); window.location.href='team_directory.php';</script>";
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error updating Member Details.</div>";
    }

}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 col-lg-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="mb-4" style="color: darkslateblue;">✏️ Edit Handler Details</h3>
                <form method="POST">
                    <input type="hidden" name="handler_id" value="<?= $handler['id'] ?>">

                    <!-- First Name -->
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?= $handler['first_name'] ?>" required>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?= $handler['last_name'] ?>" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?= $handler['email'] ?>" required>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone" class="form-control" value="<?= $handler['phone'] ?>" pattern="[0-9+\- ]{7,15}" required>
                    </div>

                    <!-- Role Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Designation</label>
                        <select name="role" class="form-select" required>
                            <option value="Analyst" <?= $handler['role'] === 'Analyst' ? 'selected' : '' ?>>Analyst</option>
                            <option value="Investigator" <?= $handler['role'] === 'Investigator' ? 'selected' : '' ?>>Investigator</option>
                            <option value="Reviewer" <?= $handler['role'] === 'Reviewer' ? 'selected' : '' ?>>Reviewer</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-info text-white w-50">Update Member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>