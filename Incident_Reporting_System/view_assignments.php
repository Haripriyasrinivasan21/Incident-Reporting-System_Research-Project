<?php
include 'manager_header.php';
include 'db.php';

if (!isset($_SESSION["manager_id"])) {
    header("Location: manager_login.php");
    exit();
}


$query = "SELECT id, report_id, assignee, assigned_date, completion_date, task_status
          FROM task_assignments ORDER BY assigned_date DESC";
$result = $conn->query($query);
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-16 col-lg-18 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="text-center mb-4" style="color: teal;">📋 Task Assignments Overview</h3>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table table-bordered table-hover table-striped shadow-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>🆔 Task ID</th>
                                <th>🔗 Report ID</th>
                                <th>👤 Assignee (Role)</th>
                                <th>📅 Date Assigned</th>
                                <th>📆 Completion Date</th>
                                <th>⏳ Status</th>
                                <th>⚙️ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['id'] ?></td>
                                    <td><?= $row['report_id'] ?></td>
                                    <td><?= $row['assignee'] ?></td>
                                    <td><?= date('d M Y', strtotime($row['assigned_date'])) ?></td>
                                    <td><?= date('d M Y', strtotime($row['completion_date'])) ?></td>
                                    <td>
                                        <?php
                                        $status = $row['task_status'];
                                        $badge = match ($status) {
                                            'Assigned' => 'primary',
                                            'In-Progress' => 'warning',
                                            'Completed' => 'success',
                                            'Blocked' => 'danger',
                                            default => 'secondary'
                                        };
                                        ?>
                                        <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="update_assignments.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white">Edit</a>

                                            <form action="delete_assignments.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this task assignment?');">
                                                <input type="hidden" name="task_id" value="<?= $row['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h5 class="text-danger text-center">⚠️ No task assignments found.</h5>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'manager_footer.php'; ?>