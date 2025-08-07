<?php
session_start();
include 'db.php';

// Restrict access to only logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'admin_header.php';

// Fetch all events
$query = "SELECT * FROM maintenance ORDER BY id ASC";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 col-lg-10 mx-auto"> <!-- Adjusted width -->
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">⚙️ Manage Maintenance</h2>
                
                <?php if ($result->num_rows > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Maintenance Title</th>
                                    <th>Description</th>
                                    <th>Starts On</th>
                                    <th>Completes On</th>
                                    <th>Expected Impact</th>
                                    <th>Admin Details</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($event = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                                        <td><?php echo htmlspecialchars($event['startdate']); ?></td>
                                        <td><?php echo htmlspecialchars($event['enddate']); ?></td>
                                        <td><?php echo htmlspecialchars($event['impact']); ?></td>
                                        <td><?php echo htmlspecialchars($event['admindetails']); ?></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="edit_maintenance.php?id=<?php echo $event['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <a href="delete_maintenance.php?id=<?php echo $event['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this maintenance?')">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-warning text-center">No Maintenance Scheduled so far.</div>
                <?php } ?>

                <div class="text-center mt-4">
                    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Styling -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<?php include 'admin_footer.php'; ?>