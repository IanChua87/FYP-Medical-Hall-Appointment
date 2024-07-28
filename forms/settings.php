<?php
ob_start();
session_start();
include "../db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT settings_key, settings_value FROM settings";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Failed to fetch settings: " . mysqli_error($conn));
} else {
    $settings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['settings_key']] = $row['settings_value'];
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Settings</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        .session-msg-success,
        .session-msg-error {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .session-msg-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .session-msg-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
                <li class=""><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class="active"><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <li class=""><a href="contactDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-envelope"></i> View Contact</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <div class="settings">
                <div class="settings-wrapper">
                    <h1>Settings</h1>
                    <div class="settings-group">
                        <div class="row mb-3">
                            <label for="start_weekday" class="col-sm-5 word-label">Weekday Open Time:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $settings['weekday_open_time'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_weekday" class="col-sm-5 word-label">Weekday Close Time:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $settings['weekday_close_time'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend" class="col-sm-5 word-label">Weekend Open Time:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $settings['weekend_open_time'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_weekend" class="col-sm-5 word-label">Weekend Close Time:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $settings['weekend_close_time'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekday_time" class="col-sm-5 word-label">Opening Days:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $settings['opening_days'] ?></p>
                            </div>
                        </div>
                        <div>
                            <a href="editSettings.php" class="btn edit-btn">Edit</a>
                        </div>
                    </div>
                    <?php include '../sessionMsg.php' ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-success').fadeOut('slow');
        }, 1700);
    });
</script>

<!-- <script>
    $(function() {
        $("#dob").timepicker({
            timeFormat: 'hh:mm p',
            interval: 15
        });
    });
</script> -->

</html>