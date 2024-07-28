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
?>

<?php
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
    <title>Admin | Edit Settings</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        #sidebar {
            height: 1250px;
        }

        .session-msg-success,
        .session-msg-error {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .session-msg-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            margin-left: 50px;
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
                <?php include '../sessionMsg.php' ?>
                <div class="settings-box">
                    <h1>Settings</h1>
                    <div class="settings-group">
                        <form action="doEditSettings.php" method="POST">
                            <div class="form-group row mb-5">
                                <label for="weekday_open_time" class="col-sm-5 col-form-label text-right">Weekday Open Time:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="weekday_open_time" id="weekday_open_time" class="form-control time" value="<?php echo $settings['weekday_open_time'] ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <label for="weekday_close_time" class="col-sm-5 col-form-label text-right">Weekday Close Time:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="weekday_close_time" id="weekday_close_time" class="form-control time" value="<?php echo $settings['weekday_close_time'] ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <label for="weekend_open_time" class="col-sm-5 col-form-label text-right">Weekend Open Time:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="weekend_open_time" id="weekend_open_time" class="form-control time" value="<?php echo $settings['weekend_open_time'] ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <label for="weekend_close_time" class="col-sm-5 col-form-label text-right">Weekend Close Time:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="weekend_close_time" id="weekend_close_time" class="form-control time" value="<?php echo $settings['weekend_close_time'] ?>">
                                </div>
                            </div>
                            <div class="form-group row mb-5">
                                <label for="opening_days" class="col-sm-5 col-form-label text-right">Opening Days:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="opening_days" id="opening_days" class="form-control" value="<?php echo $settings['opening_days'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 d-flex flex-end">
                                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

<script>
    $(function() {
        $(".time").timepicker({
            timeFormat: 'HH:mm',
            interval: 30,
            minTime: '11:00',
            maxTime: '16:30',
            defaultTime: '00:00',
            startTime: '00:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
    });
</script>

</html>