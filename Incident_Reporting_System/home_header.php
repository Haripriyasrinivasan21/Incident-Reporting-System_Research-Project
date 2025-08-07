<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incident Reporting System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color:rgb(99, 0, 0) !important;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }
        .navbar-brand img {
            height: 50px;
            margin-right: 10px;
        }
        .nav-link {
            font-weight: bold;
            color: #fff !important; /* White Text */
        }
        .dropdown-menu {
            background-color:rgb(45, 51, 49); /* Dark Gray Dropdown */
        }
        .dropdown-item {
            font-weight: bold;
            color: #fff !important;
        }
        .dropdown-item:hover {
            background-color:rgb(5, 5, 5); /* Slightly Lighter Gray */
        }
        .navbar-toggler {
            border-color: #fff !important;
        }
        .navbar-toggler-icon {
            filter: invert(1); /* Make Toggler White */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="uploads/IRSwhite.png" alt="Logo"> Incident Reporting System
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="home_about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="home_contact.php">Contact Us</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="admin_login.php">Admin Login</a></li>
                        <li><a class="dropdown-item" href="login.php">Reporter Login</a></li>
                        <li><a class="dropdown-item" href="manager_login.php">Incident Manager Login</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
