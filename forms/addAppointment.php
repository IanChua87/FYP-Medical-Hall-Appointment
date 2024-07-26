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
$query = "SELECT * FROM appointment ORDER BY queue_no DESC LIMIT 1";
$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    die("Failed to prepare statement");
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $queue_no = $row['queue_no'];
    } else {
        $queue_no = 0;
    }
    $latest_queue_no = $queue_no + 1;
}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Appointment</title>
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

        .appointment .buttons {
            display: flex;
            justify-content: flex-end;
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
                <li class="active"><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="appointment" id="appointment">
            <div class="container">
                <div class="profile-details">
                    <h2 class="">Add Appointment</h2>
                    <i class="fa-regular fa-calendar"></i>
                </div>
                <div class="form-fields">
                    <form action="doAddAppointment.php" method="POST">
                        <div class="form-group mb-3">
                            <label for="email">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Email:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="email" id="email" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="appointment_date">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Appointment Date:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="appointment_date" id="appointment_date" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="appointment_time">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Appointment Time:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="appointment_time" id="appointment_time" class="form-control">
                        </div>

                        <div class="form-group mb-3">
                            <label for="relation">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Relation:
                                <span class="required-text">(required)</span>
                            </label>
                            <select name="relation" id="relation" class="form-control">
                                <option value="select">Select Relation</option>
                                <option value="family">Family</option>
                                <option value="friend">Friend</option>
                                <option value="relative">Relative</option>
                            </select>
                        </div>

                        <input type="text" name="queue" id="queue" class="form-control" value="<?php echo $latest_queue_no ?>" hidden>

                        <div class="buttons">
                            <button type="submit" name="submit" class="btn create-btn">Create Appointment</button>
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
        var today = new Date();
        $('#appointment_date').datepicker({
            dateFormat: 'dd/mm/yy',
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day !== 1 && day !== 0), ''];
            },
            minDate: today,
            changeMonth: true,
        });

        $('#appointment_time').timepicker({
            timeFormat: 'hh:mm:p',
            minTime: '1100',
            maxTime: '1630',
            showDuration: true,
            interval: 15
        });
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);

    });
</script>

</html>