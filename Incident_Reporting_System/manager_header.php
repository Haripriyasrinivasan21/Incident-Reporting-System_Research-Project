<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["manager_id"])) {
    header("Location: manager_login.php");
    exit();
}
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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: rgba(0, 99, 36, 1) !important;
        }

        .navbar-brand {
            color: white !important;

            font-size: 20px;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            background: #495057;
            border-radius: 5px;
        }

        .logout-btn {
            background: none !important;
            color: #dc3545 !important;
            text-decoration: none;
            font-weight: normal;
        }

        .logout-btn:hover {
            text-decoration: underline;
            color: #c82333 !important;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="manager_dashboard.php">Incident Manager Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="submitted_reports.php">Incident Reports</a></li>
                    <li class="nav-item"><a class="nav-link" href="task_assignment.php">Task Assignment</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_assignments.php">View Assignments</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_member.php">Add a Member</a></li>
                    <li class="nav-item"><a class="nav-link" href="team_directory.php">Team Directory</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="add_offer.php">Escalation Procedures</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="escalation_procedures.php">Escalation Procedures</a></li>
                    <li class="nav-item"><a class="nav-link" href="home_contact.php">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="home_about.php">About Us</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="client_view_report_status.php">View Orders</a></li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="manager_logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">