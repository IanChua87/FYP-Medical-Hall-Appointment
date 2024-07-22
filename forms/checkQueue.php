<?php
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// $q_query = "SELECT * FROM appointment WHERE appointment_date = CURDATE()
// ORDER BY queue_no DESC 
// LIMIT 1";
// $queue_stmt = mysqli_prepare($conn, $q_query);
// if(!$queue_stmt){
//     die("Failed to prepare statement");
// } else{
//     mysqli_stmt_execute($queue_stmt);
//     $result = mysqli_stmt_get_result($queue_stmt);
//     if(mysqli_num_rows($result) > 0){
//         $row = mysqli_fetch_assoc($result);
//         $queue_no = $row['queue_no'];
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Queue No.</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <style>
        .session-msg-error {
            margin-top: 20px;
            position: fixed;
        }
    </style>
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
                        <h1 class="queue-title">Check Queue Number</h1>
                        <form action="doCheckQueue.php" method="POST">
                            <div class="form-group">
                                <label for="queueNumber" class="queue_label">Enter your queue number:</label>
                                <input type="text" id="queueNumber" name="queueNumber" class="form-control">
                            </div>
                            <button type="submit" name="submit" class="btn check-btn">Check Queue</button>
                        </form>
                    </div>
                    <?php include '../sessionMsg.php' ?>
                </div>
            </div>
        </div>
    </div>
</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

</html>