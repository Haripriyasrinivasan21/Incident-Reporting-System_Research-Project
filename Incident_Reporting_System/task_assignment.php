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

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset(
            $_POST['report_id'],
            $_POST['assignee'],
            $_POST['assigned_date'],
            $_POST['completion_date'],
            $_POST['task_status']
        )
    ) {
        $report_id = $_POST['report_id'];
        $assignee = $_POST['assignee'];
        $assigned_date = $_POST['assigned_date'];
        $completion_date = $_POST['completion_date'];
        $task_status = $_POST['task_status'];
        $created_by = $_SESSION['manager_id'];

        $query = "INSERT INTO task_assignments (report_id, assignee, assigned_date, completion_date, task_status, created_by)
              VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssss", $report_id, $assignee, $assigned_date, $completion_date, $task_status, $created_by);
        if ($stmt->execute()) {
            echo "<script>alert('✅ Task successfully assigned!'); window.location.href='view_assignments.php';</script>";
        } else {
            echo "<script>alert('Error assigning the Task.'); window.location.href='view_assignments.php';</script>";
        }
        $stmt->close();
    }
}
// Fetch reports for dropdown
$reportQuery = "SELECT id, description FROM reports";
$reportResult = $conn->query($reportQuery);

// Fetch team members for assignee dropdown
$handlerQuery = "SELECT first_name, last_name, role FROM team_members ORDER BY first_name";
$handlerResult = $conn->query($handlerQuery);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            max-width: 600px;
            margin-top: 10px;
        }

        .card {
            padding: 20px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-16 col-lg-18 mx-auto">
                <div class="card shadow-lg p-4">
                    <h3 class="mb-4" style="color: hotpink;">📋 Assign Task to Incident Handler</h3>
                    <?php if ($reportResult && $reportResult->num_rows > 0): ?>
                        <form method="POST">
                            <!-- Report ID Dropdown -->
                            <div class="mb-3">
                                <label for="report_id" class="form-label">Report ID</label>
                                <select name="report_id" id="report_id" class="form-select" onchange="populateDescription(this.value)">
                                    <option value="">Select Report</option>
                                    <?php while ($row = $reportResult->fetch_assoc()): ?>
                                        <option value="<?= $row['id'] ?>" data-desc="<?= htmlspecialchars($row['description']) ?>">
                                            <?= $row['id'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Auto-Populated Description -->
                            <div class="mb-3">
                                <label for="report_description" class="form-label">Report Description</label>
                                <textarea class="form-control" id="report_description" rows="3" readonly></textarea>
                            </div>

                            <!-- Assignee -->
                            <div class="mb-3">
                                <label for="assignee" class="form-label">Assignee</label>
                                <select name="assignee" class="form-select" required>
                                    <option value="">Select Assignee</option>
                                    <?php if ($handlerResult && $handlerResult->num_rows > 0): ?>
                                        <?php while ($row = $handlerResult->fetch_assoc()): ?>
                                            <?php $combinedValue = $row['first_name'] . ' ' . $row['last_name'] . ' – ' . $row['role']; ?>
                                            <option value="<?= $combinedValue ?>">
                                                <?= $combinedValue ?>
                                            </option>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <option value="">No handlers available</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <!-- Date Fields -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="assigned_date" class="form-label">Date of Assignment</label>
                                    <input type="date" name="assigned_date" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="completion_date" class="form-label">Expected Completion Date</label>
                                    <input type="date" name="completion_date" class="form-control" required>
                                </div>
                            </div>

                            <!-- Task Status -->
                            <div class="mb-3">
                                <label for="task_status" class="form-label">Task Status</label>
                                <select name="task_status" class="form-select" required>
                                    <option value="Assigned">Assigned</option>
                                    <option value="In-Progress">In-Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Blocked">Blocked</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <button type="submit" class="btn btn-success w-50">Assign Task</button>
                                <a href="manager_dashboard.php" class="btn btn-primary w-50">Back to Dashboard</a>
                            </div>
                        </form>

                    <?php else: ?>
                        <h3 class="text-danger text-center">⚠️ No incident reports available to assign tasks.</h3>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function populateDescription(reportId) {
            const dropdown = document.getElementById('report_id');
            const selected = dropdown.querySelector(`option[value="${reportId}"]`);
            document.getElementById('report_description').value = selected?.dataset.desc || '';
        }
    </script>


</body>

</html>