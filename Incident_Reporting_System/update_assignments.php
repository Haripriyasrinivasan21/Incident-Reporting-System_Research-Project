<?php
include 'manager_header.php';
include 'db.php';

if (!isset($_SESSION["manager_id"])) {
    header("Location: manager_login.php");
    exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('No task selected.'); window.location.href='view_assignments.php';</script>";
    exit();
}

$query = "SELECT * FROM task_assignments WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    echo "<script>alert('Task not found.'); window.location.href='view_assignments.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $update = "UPDATE task_assignments SET assignee=?, assigned_date=?, completion_date=?, task_status=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param(
        "ssssi",
        $_POST['assignee'],
        $_POST['assigned_date'],
        $_POST['completion_date'],
        $_POST['task_status'],
        $_POST['task_id']
    );
    if ($stmt->execute()) {
        echo "<script>alert('✅ Task assignment updated successfully!'); window.location.href='view_assignments.php';</script>";
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error updating task assignment.</div>";
    }
}

// Fetch team members for assignee dropdown
$handlerQuery = "SELECT first_name, last_name, role FROM team_members ORDER BY first_name";
$handlerResult = $conn->query($handlerQuery);

?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-16 col-lg-18 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 style="color: teal;">✏️ Update Task Assignment</h3>
                <form method="POST">
                    <input type="hidden" name="task_id" value="<?= $task['id'] ?>">

                    <!-- Assignee Name -->
                    <div class="mb-3">
                        <label class="form-label">Assignee</label>
                        <select name="assignee" class="form-select" required>
                            <option value="">Select Assignee</option>
                            <?php if ($handlerResult && $handlerResult->num_rows > 0): ?>
                                <?php while ($row = $handlerResult->fetch_assoc()): ?>
                                    <?php
                                    $combinedValue = $row['first_name'] . ' ' . $row['last_name'] . ' – ' . $row['role'];
                                    $selected = ($combinedValue === trim($task['assignee'])) ? 'selected' : '';
                                    ?>
                                    <option value="<?= $combinedValue ?>" <?= $selected ?>>
                                        <?= $combinedValue ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No handlers available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <!-- Assigned / Completion Date -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Assigned Date</label>
                            <input type="date" name="assigned_date" class="form-control" value="<?= date('Y-m-d', strtotime($task['assigned_date'])) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Expected Completion Date</label>
                            <input type="date" name="completion_date" class="form-control" value="<?= date('Y-m-d', strtotime($task['completion_date'])) ?>" required>
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="task_status" class="form-select">
                            <option <?= $task['task_status'] == 'Assigned' ? 'selected' : '' ?>>Assigned</option>
                            <option <?= $task['task_status'] == 'In-Progress' ? 'selected' : '' ?>>In-Progress</option>
                            <option <?= $task['task_status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                            <option <?= $task['task_status'] == 'Blocked' ? 'selected' : '' ?>>Blocked</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-info text-white  w-50">Update Assignment</button>
                    </div>
                </form>
                <div class="d-flex justify-content-center mt-2">
                    <a href="view_assignments.php" class="btn btn-secondary w-50">Back to Assignments Overview</a>
                </div>
            </div>
        </div>
    </div>
</div>