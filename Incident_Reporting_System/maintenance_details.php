<?php
include 'user_header.php';
include 'db.php';

$query = "SELECT * FROM maintenance ORDER BY startdate ASC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Maintenance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">🛠️ Upcoming Maintenance</h2>

    <div class="row mt-4">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card shadow-lg mb-4">
                        <!-- <img src="<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="Event Image" style="height: 200px; object-fit: cover;"> -->
                        <div class="card-body">
                            <h4 class="card-title"><?= htmlspecialchars($row['title']) ?></h4>
                            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
                            <p><strong>Starts On:</strong> <?= htmlspecialchars($row['startdate']) ?></p>
                            <p><strong>Completes On:</strong> <?= htmlspecialchars($row['enddate']) ?></p>
                            <p><strong>Impact:</strong> <?= htmlspecialchars($row['impact']) ?></p>
                            <p><strong>Reachout to:</strong> <?= htmlspecialchars($row['admindetails']) ?></p>
                            <a href="acknowledge_maintenance.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn btn-primary w-100">✅ Acknowledge</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center text-muted">No upcoming maintenance as of now!</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php include 'admin_footer.php'; ?>