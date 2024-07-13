<?php 
session_start();
include "db_connect.php";

// Check if patient_id is set in the session
if (!isset($_SESSION['patient_id'])) {
    header("Location: forms/login.php");
    exit();
}

// Assign session patient_id to a variable
$patient_id = $_SESSION['patient_id'];

// Fetch patient name
$query = "SELECT patient_name FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$stmt->bind_result($patient_name);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Logged In</title>
    <!-- 'links.php' contains CDN links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <style>
        .book-btn {
            background-color: #CFA61E;
            color: #fff;
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            width: auto; /* Adjust width to fit content */
            margin-top: 20px;
        }

        .view-btn{
            background-color: #682924;
            color: #fff;
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            width: auto; /* Adjust width to fit content */
            margin-top: 20px;
        }

        .button-container {
            display: flex;
            gap: 20px; /* Space between buttons */
           
        }
    </style>
</head>
<body>
    <!--navbar-->
    <?php

echo '
<nav class="navbar navbar-expand-lg">
    <div class="container"> ' ?>
    <?php if (!isset($_SESSION["patient_id"])) { ?>
        <a class="navbar-brand" href="../index.php">
        <img src="../svg/logo.svg" alt="Logo" class="navbar-logo">
        </a>
        <?php } else { ?>
        <a class="navbar-brand" href="../P_index.php">
        <img src="../svg/logo.svg" alt="Logo" class="navbar-logo">
        </a>   
        <?php } ?>
        <?php echo '
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">' ?>
            <?php if (!isset($_SESSION["patient_id"])) { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
<?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../P_index.php">Home</a>
                </li>
<?php } ?>
<?php echo '
                
              
            </ul>; ' ?>
<?php
if (isset($_SESSION['patient_id'])) {
    echo '
        <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Appointment
                </a>
            <ul class="dropdown-menu" aria-labelledby="apptDropdown">
                <li><a class="dropdown-item" href="forms/booking.php">Book Appointment</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/viewappointment.php">View Appointment</a></li>
            </ul>
        </div>
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="forms/editprofile.php">Edit Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/changepassword.php">Change Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/loggedOutSuccessful.php">Logout</a></li>
            </ul>
        </div>';
} else {
    echo '<ul class="nav navbar-nav">
            <a class="btn sign-up-btn" href="forms/register.php" role="button">Sign Up</a>
            <a class="btn login-btn" href="forms/login.php" role="button">Login</a>
          </ul>';
}

echo '    </div>
    </div>
</nav>';
?>

    <!--hero start-->
    <section class="hero" id="hero">
        <div class="container">
            <div class="hero-text">
                <h1>Welcome to Sin Nam <br>Medical Hall,<br><?php echo htmlspecialchars($patient_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="button-container mt-3">
                    <a href="forms/booking.php" class="btn book-btn">Book Appointment</a>
                    <a href="forms/viewappointment.php" class="btn view-btn">View Appointment</a>
                </div>
            </div>
        </div>
    </section>
    <!--hero end-->
</body>
</html>
