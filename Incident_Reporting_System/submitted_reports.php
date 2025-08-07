<?php
include 'db.php';
include 'manager_header.php';

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

$manager_id = $_SESSION["manager_id"];

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT * FROM reports;";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $conn->error);
}

//$stmt->bind_param("i", $manager_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('images/admin2.jpg') no-repeat center fixed;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .container {
            flex: 1;
        }

        .table-container {
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        .table {
            width: 100%;
            margin-left: 0;
            border-collapse: collapse;
            table-layout: fixed;
            display: block;
            width: 100%;
            overflow-x: auto;
            white-space: nowrap;
        }

        .table-wrapper {
            margin-left: 0;
            padding-left: 0;
        }

        th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }

        td,
        th {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        td.actions-cell {
            white-space: nowrap;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .footer {
            background-color: rgb(210, 219, 227);
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 10px;
            }

            .table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="table-container">
        <h3 class="text-center mb-4">📑 Incident Reports Submissions</h3>
        <table class="table table-wrapper table-bordered">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Reporter Name</th>
                    <th>Reporter Email</th>
                    <th>Reporter Phone</th>
                    <th>Incident Date/Time</th>
                    <th>Location</th>
                    <th>Incident Type</th>
                    <th>Brief Description</th>
                    <th>Severity Level</th>
                    <th>Action Taken</th>
                    <th>Patient ID/Name</th>
                    <th>Witnesses</th>
                    <th>Attachments</th>
                    <th>Incident Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($report = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['id']); ?></td>
                        <td><?php echo !empty($report['reporter_name']) ? htmlspecialchars($report['reporter_name']) : 'Anonymous'; ?></td>
                        <td><?php echo !empty($report['reporter_email']) ? htmlspecialchars($report['reporter_email']) : 'Anonymous'; ?></td>
                        <td><?php echo !empty($report['reporter_phone']) ? htmlspecialchars($report['reporter_phone']) : 'Anonymous'; ?></td>
                        <td><?= date("F j, Y, g:i A", strtotime($report['incident_date_time'])) ?></td>
                        <td><?php echo htmlspecialchars($report['location']); ?></td>
                        <td><?php echo htmlspecialchars($report['incident_type']); ?></td>
                        <td><?php echo htmlspecialchars($report['description']); ?></td>
                        <td><?php echo htmlspecialchars($report['severity_level']); ?></td>
                        <td><?php echo htmlspecialchars($report['action_taken']); ?></td>
                        <td><?php echo htmlspecialchars($report['patient_id_name']); ?></td>
                        <td><?php echo htmlspecialchars($report['witnesses']); ?></td>
                        <td>
                            <?php if ($report['attachments']) { ?>
                                <img src="<?php echo htmlspecialchars($report['attachments']); ?>" alt="Product Image" class="product-img">
                            <?php } else { ?>
                                No attachment
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            $status = htmlspecialchars($report['incident_status']);
                            $status_class = match ($status) {
                                'Open' => 'text-warning fw-bold',
                                'Assigned' => 'text-info fw-bold',
                                'Under Review' => 'text-danger fw-bold',
                                'Resolved' => 'text-success fw-bold',
                                default => 'text-secondary'
                            };
                            ?>
                            <span class="<?= $status_class ?>"><?= $status ?></span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <form action="edit_status.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($report['id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-info text-white">Update</button>
                                </form>
                                <form action="delete_report.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($report['id']) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>

    <?php
    $footer_file = 'manager_footer.php';
    if (file_exists($footer_file)) {
        include $footer_file;
    } else {
        echo "<div class='footer text-center mt-4'>Footer file missing</div>";
    }
    ?>

</body>

</html>