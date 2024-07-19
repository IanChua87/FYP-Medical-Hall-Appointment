<?php
session_start();
include "../db_connect.php";


if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
if (isset($_GET['queue_no'])) {
    $queue_no = $_GET['queue_no'];
} else {
    header("Location: checkQueue.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Queue Details</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
    <div class="main-content d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
            </div>
            <ul class="mt-3">
                <li><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class="active"><a href="checkQueue.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li><a href="editSettings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>
        <div class="content" id="content">
            <div class="queue" id="queue">
                <div class="queue-container">
                    <div class="queue-wrapper">
                        <h1 class="queue-title">Queue Details</h1>
                        <div class="queue_no-wrapper">
                            <h2 class="queue_no"><?php echo $queue_no ?></h2>
                        </div>
                        <div class="buttons">
                            <a href="checkQueue.php" class="back-btn">Go Back</a>
                        </div>
                    </div>
                    <?php include '../sessionMsg.php' ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>