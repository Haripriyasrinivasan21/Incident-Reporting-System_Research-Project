<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all reports
$queryAllReports = "SELECT * FROM reports;";

$result = $conn->query($queryAllReports);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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
            max-width: 100%;
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
            line-height: 1.5;
            max-width: auto;
        }

        .incident-status-column {
            width: 120px;
            /* Adjust as needed */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .footer {
            background-color: rgb(99, 0, 0);
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
            }
        }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <div class="container">
        <div class="table-container">
        <h2 class="text-center mt-4 mb-4">📈 View Reports</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Report ID</th>
                    <th>Reporter Name</th>
                    <th>Reporter Email</th>
                    <th>Reporter Phone</th>
                    <th>Incident Date/Time</th>
                    <th>Location</th>
                    <th>Incident Type</th>
                    <th>Brief Details</th>
                    <th>Severity Level</th>
                    <th>Action Taken</th>
                    <th>Patient ID/Name</th>
                    <th>Witnesses</th>
                    <th>Attachments</th>
                    <th>Incident Status</th>
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
                                No attachments
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
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    </div>

    <!-- Sticky Footer -->
    <!-- <footer class="footer">
        &copy; <?php echo date("Y"); ?> Admin Panel | All Rights Reserved
    </footer> -->

    

</body>
</html>
<?php include 'admin_footer.php'; ?>