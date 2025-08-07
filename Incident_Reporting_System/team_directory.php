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

$query = "SELECT * FROM team_members ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 col-lg-10 mx-auto">
            <div class="card shadow-lg p-4">
                <h3 class="mb-4 text-center" style="color: darkslateblue;">👥 Incident Handlers Directory</h3>

                <?php if ($result && $result->num_rows > 0): ?>
                    <table class="table table-bordered table-hover table-striped shadow-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>🧑 Name</th>
                                <th>✉️ Email</th>
                                <th>📞 Phone</th>
                                <th>🎓 Role</th>
                                <th>📅 Joined</th>
                                <th>⚙️ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $count++ ?></td>
                                    <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td><?= $row['role'] ?></td>
                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <!-- Edit Button -->
                                            <a href="edit_member.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white">Edit</a>
                                            <!-- Delete Button -->
                                            <form action="delete_member.php" method="POST" style="display:inline;" onsubmit="return confirm('Delete this member?');">
                                                <input type="hidden" name="handler_id" value="<?= $row['id'] ?>">
                                                <button class="btn btn-sm btn-danger text-white">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <h5 class="text-center text-danger">⚠️ No incident handlers added yet.</h5>
                <?php endif; ?>
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