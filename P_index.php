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
    <?php include 'navbar.php'; ?>

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
