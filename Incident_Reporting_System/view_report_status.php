<?php
include 'user_header.php';
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the report status
$query = "SELECT * FROM reports WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die('MySQL prepare error: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Reports</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center text-success">📋 Incident Report Status</h2>
        <h5 class="text-center text-success">Track and review the progress, assignments, and resolution updates of submitted incident reports.</h5>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped table-hover mt-4">
                <thead class="table-dark">
                    <tr>
                        <th>Reported By</th>
                        <th>Patient ID/Name</th>
                        <th>Incident Date/Time</th>
                        <th>Incident Type</th>
                        <th>Severity Level</th>
                        <th>Action Taken</th>
                        <th>Incident Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($report = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($report['reporter_name']) ?></td>
                            <td><?= htmlspecialchars($report['patient_id_name']) ?></td>
                            <td><?= date("F j, Y, g:i A", strtotime($report['incident_date_time'])) ?></td>
                            <td><?= htmlspecialchars($report['incident_type']) ?></td>
                            <td><?= htmlspecialchars($report['severity_level']) ?></td>
                            <td><?= htmlspecialchars($report['action_taken']) ?></td>
                            <td>
                                <?php
                                $status = htmlspecialchars($report['incident_status']);
                                $status_class = match ($status) {
                                    'Open' => 'text-warning fw-bold',
                                    'Assigned' => 'text-info fw-bold',
                                    'Under Review' => 'text-danger fw-bold',
                                    'Resolved' => 'text-success fw-bold',
                                    'Closed' => 'text-success fw-bold',
                                    default => 'text-secondary'
                                };
                                ?>
                                <span class="<?= $status_class ?>"><?= $status ?></span>
                            </td>
                            <!-- <td>
                                <a href="order_details.php?order_id=<?= htmlspecialchars($order['id']) ?>" class="btn btn-info btn-sm">🔍 View Details</a>
                                <?php if ($status != 'Cancelled'): ?>
                                    <a href="cancel_order.php?order_id=<?= htmlspecialchars($order['id']) ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to cancel this order?');">❌ Cancel</a>
                                <?php endif; ?>
                            </td> -->
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <h4 class="text-center text-muted mt-4">You haven't submitted any reports yet.</h4>
        <?php endif; ?>
    </div>

</body>

</html>

<?php include 'admin_footer.php'; ?>