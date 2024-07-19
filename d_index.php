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
    <?php include 'links.php'; ?>
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
            /* Adjust width to fit content */
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

    include 'navbar.php';
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