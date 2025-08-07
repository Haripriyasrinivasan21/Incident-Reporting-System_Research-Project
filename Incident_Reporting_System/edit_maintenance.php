<?php
include 'admin_header.php';
include 'db.php';

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->prepare("SELECT * FROM maintenance WHERE id = ?");
$result->bind_param("i", $id);
$result->execute();
$event = $result->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $startdate = htmlspecialchars($_POST['startdate']);
    $enddate = $_POST['enddate'];
    $impact = htmlspecialchars($_POST['impact']);
    $admindetails = $_POST['admindetails'];

    $stmt = $conn->prepare("UPDATE maintenance SET title=?, description=?, startdate=?, enddate=?, impact=?, admindetails=? WHERE id=?");
    $stmt->bind_param("ssssssi", $title, $description, $startdate, $enddate, $impact, $admindetails, $id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Maintenance details updated successfully!'); window.location.href='manage_maintenance.php';</script>";
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error updating maintenance.</div>";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 col-lg-5 mx-auto"> <!-- Adjusted width -->
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">Edit Maintenance Details</h2>
                <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

                    <div class="mb-3">
                        <label class="form-label">Maintenance Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($event['description']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Starts On</label>
                        <input type="date" name="startdate" class="form-control" value="<?php echo $event['startdate']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Completes On</label>
                        <input type="date" name="enddate" class="form-control" value="<?php echo $event['enddate']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Expected Impact</label>
                        <input type="text" name="impact" class="form-control" value="<?php echo htmlspecialchars($event['impact']); ?>" required>
                    </div>

                     <div class="mb-3">
                        <label class="form-label">Admin Details</label>
                        <input type="text" name="admindetails" class="form-control" value="<?php echo htmlspecialchars($event['admindetails']); ?>" required>
                    </div>

                    <div class="text-center d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary">Update Maintenance</button>
                        <a href="manage_maintenance.php" class="btn btn-secondary">Cancel</a>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php include 'admin_footer.php'; ?>
