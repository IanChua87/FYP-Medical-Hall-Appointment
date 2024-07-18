<?php
session_start();
include "db_connect.php";

// Check if patient_id is set in the session
if (!isset($_SESSION['doctor_id'])) {
    header("Location: forms/login.php");
    exit();
}

// Assign session patient_id to a variable
$user_id = $_SESSION['doctor_id'];

// Fetch doctor name
$query = "SELECT user_name FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($doctor_name);
$stmt->fetch();
$stmt->close();
$conn->close();

// Display doctor name

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Logged In</title>
    <!-- 'links.php' contains CDN links' -->
    <?php include 'links.php' ?>
    <link rel="stylesheet" href="style.css" />
    <style>
        
        .view-btn {
            background-color: #682924;
            color: #fff;
            display: inline-block;
            text-align: center;
            padding: 10px 20px;
            text-decoration: none;
            width: auto;
            margin-top: 20px;
        }

        .button-container {
            display: flex;
            gap: 20px;
            /* Space between buttons */

        }

        .navbar-logo{
            width: 60px;

        }

    </style>
</head>

<body>
    <!--navbar-->
    <?php

    echo '
<nav class="navbar navbar-expand-lg">
    <div class="container"> '?>
        <?php if (!isset($_SESSION["doctor_id"])) { ?>
        <a class="navbar-brand" href="../index.php">
        <img src="../svg/logo.svg" alt="Logo" class="navbar-logo">
        </a>   
        <?php } else { ?>
        <a class="navbar-brand" href="../d_index.php">
        <img src="../svg/logo.svg" alt="Logo" class="navbar-logo">
        </a>   
        <?php } ?>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
        

    <?php if (!isset($_SESSION["doctor_id"])) { ?>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="../d_index.php">Home</a>
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

    <?php } ?>
    <?php echo '
                
              
            </ul>' ?>
    <?php
    if (isset($_SESSION['doctor_id'])) {
        echo '
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle"></i>
            </a>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="forms/editDoctorProfile.php">Edit Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/Doctorchangepassword.php">Change Password</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="forms/DoctorloggedOutSuccessful.php">Logout</a></li>
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
                <h1>Welcome to Sin Nam <br>Medical Hall,<br><?php echo htmlspecialchars($doctor_name, ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="button-container mt-3">
                    <a href="../d_viewAppointment.php" class="btn view-btn">View Appointment</a>
                </div>
            </div>
        </div>
    </section>
    <!--hero end-->
</body>

</html>