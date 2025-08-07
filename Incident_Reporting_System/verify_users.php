<?php
include 'admin_header.php';
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$query = "SELECT * FROM users WHERE first_name != 'Admin' ORDER BY first_name ASC";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h2 class="text-center mb-4">👥 Registered Users</h2>

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                         <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($users = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($users['id']); ?></td>
                                <td><?php echo htmlspecialchars($users['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($users['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($users['email']); ?></td>
                                <td><?php echo htmlspecialchars($users['role']); ?></td>
                                <td>
                                    <a href="delete_users.php?id=<?php echo $users['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="text-center">
                    <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Ensure the footer sticks at the bottom -->
<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .container {
        flex: 1;
    }
</style>

<?php include 'admin_footer.php'; ?>
