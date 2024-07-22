<?php
ob_start();
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
ob_end_flush(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Patient</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <style>
        .session-msg-error {
            margin-top: 20px;
            text-align: center;
            position: fixed;
        }
    </style>
</head>

<body>
    <div class="main-content d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li><a href="checkQueue.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class="active"><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>
        <div class="patient" id="patient">
            <div class="container">
                <div class="profile-details">
                    <h2 class="">Add Patient</h2>
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="form-fields">
                    <form action="doAddPatient.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="name">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Name:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control" value="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Email:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="email" name="email" id="email" class="form-control" value="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Password:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="password" name="password" id="password" class="form-control" value="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="dob">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Date of Birth:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="dob" id="dob" class="form-control" value="">
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Phone Number:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="phone" id="phone" class="form-control" value="">
                        </div>

                        <div class="buttons">
                            <button type="submit" name="submit" class="btn create-btn">Create Patient</button>
                        </div>
                    </form>
                </div>
                <?php include '../sessionMsg.php' ?>
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
        $('#dob').datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0",
            maxDate: new Date()
        });

        $('#appointment_time').timepicker({
            timeFormat: 'hh:mm p',
            minTime: '1100',
            maxTime: '1630',
            showDuration: true,
            interval: 15
        });
    });
</script>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);

    });
</script>


</html>