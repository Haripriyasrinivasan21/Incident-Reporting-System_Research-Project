<?php
include 'manager_header.php';
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
  $report_id = $_POST['id'];

  // Fetch current status from DB
  $query = "SELECT incident_status FROM reports WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $report_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $current_status = $result->fetch_assoc()['incident_status'];
}
?>

<div class="container mt-4">
  <div class="row">
    <div class="col-md-8 col-lg-10 mx-auto">
      <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4" style="color: darkslateblue;">🔧 Update Incident Status</h3>
        <?php if (!isset($report_id)) { ?>
          <p class="text-danger">No report selected for status update.</p>
        <?php } else { ?>
          <p>Current Status: <strong><?= htmlspecialchars($current_status) ?></strong></p>
        <?php } ?>
        <form action="update_status.php" method="POST">
          <input type="hidden" name="id" value="<?= $report_id ?>">
          <select name="new_status" class="form-select">
            <?php
            $statuses = ['Open', 'Assigned', 'Under Review', 'Resolved'];
            foreach ($statuses as $status) {
              $selected = $status === $current_status ? 'selected' : '';
              echo "<option value='$status' $selected>$status</option>";
            }
            ?>
          </select>
          <button type="submit" class="btn btn-success mt-2">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>