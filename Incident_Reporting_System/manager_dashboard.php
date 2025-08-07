<?php
include 'manager_header.php';
include 'db.php'; // Database connection

if (!isset($_SESSION['manager_id'])) {
    header("Location: manager_login.php");
    exit();
}

$manager_id = $_SESSION["manager_id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard - Incident Reporting System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .video-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: -1;
            overflow: hidden;

        }

        .video-container video {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            flex-grow: 1;
        }

        .content-wrapper {
            position: relative;
            z-index: 1;
            padding-bottom: 650px;
        }
    </style>
</head>

<body>
    <div class="video-container">
        <video autoplay muted loop>
            <source src="uploads/manager.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <!-- Add this wrapper -->
    <div class="content-wrapper">
    </div>

    <?php include 'manager_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>