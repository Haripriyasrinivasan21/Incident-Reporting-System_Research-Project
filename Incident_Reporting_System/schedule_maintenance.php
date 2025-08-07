<?php
include 'admin_header.php';
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $startdate = $_POST['startdate'];
    $enddate = $_POST['enddate'];
    $impact = $_POST['impact'];
    $admindetails = $_POST['admindetails'];
    $created_by = $_SESSION['admin_id'];

    $stmt = $conn->prepare("INSERT INTO maintenance (title, description, startdate, enddate, impact, admindetails, created_by) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $title, $description, $startdate, $enddate, $impact, $admindetails, $created_by);

    if ($stmt->execute()) {
        header("Location: manage_maintenance.php");
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error adding maintenance. Please try again.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
 <style>
        body {
            /* background: url('images/admin4.webp') center center fixed; */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        </style>
</head>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-lg-5 mx-auto"> <!-- Adjusted width -->
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">🧰 Schedule Maintenance</h2>
                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Maintenance title</label>
                        <input type="text" name="title" class="form-control" placeholder="Maintenance Details?" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" placeholder="Breif description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Starts On</label>
                        <input type="date" name="startdate" class="form-control" required>
                    </div>
                     <div class="mb-3">
                        <label class="form-label">Completes On</label>
                        <input type="date" name="enddate" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expected Impact</label>
                        <input type="text" name="impact" class="form-control" placeholder="Enter the Expected Impact" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Admin Details</label>
                        <textarea name="admindetails" class="form-control" placeholder="Reachout to?"></textarea>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php include 'admin_footer.php'; ?>
