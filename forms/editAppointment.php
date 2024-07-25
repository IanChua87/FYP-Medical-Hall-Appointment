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

$query = "SELECT * FROM patient P INNER JOIN appointment A ON P.patient_id = A.patient_id WHERE appointment_id = ?";
$edit_appointment_stmt = mysqli_prepare($conn, $query);
if (!$edit_appointment_stmt) {
    die("Failed to prepare statement");
} else {
    mysqli_stmt_bind_param($edit_appointment_stmt, 's', $_GET['appointment_id']);
    mysqli_stmt_execute($edit_appointment_stmt);
    $edit_appointment_result = mysqli_stmt_get_result($edit_appointment_stmt);

    if (mysqli_num_rows($edit_appointment_result) > 0) {
        $row = mysqli_fetch_assoc($edit_appointment_result);

        $patient_name = $row['patient_name'];
        $phone_number = $row['patient_phoneNo'];
        $appointment_id = $row['appointment_id'];
        $appointment_date = $row['appointment_date'];
        $appointment_time = $row['appointment_start_time'];
        $appointment_status = $row['appointment_status'];
        $queue_no = $row['queue_no'];
        $patient_id = $row['patient_id'];
    } else {
        $_SESSION['message'] = "Appointment not found.";
        header("Location: appointmentDetails.php");
        exit();
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Appointment</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li class=""><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="queueDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class="active"><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="appointment" id="appointment">
            <div class="container">
                <div class="profile-details">
                    <i class="bi bi-person-circle"></i>
                    <h2 class=""><?php echo $patient_name ?></h2>
                </div>
                <div class="form-fields">
                    <form action="doEditAppointment.php" method="POST">
                        <div class="form-group mb-3">
                            <input type="text" name="appointment_id" class="form-control" value="<?php echo $appointment_id ?>" hidden>
                        </div>

                        <div class="form-group mb-3">
                            <input type="text" name="patient_id" class="form-control" value="<?php echo $patient_id ?>" hidden>
                        </div>

                        <div class="form-group mb-3">
                            <label for="appointment_date">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Appointment Date:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $appointment_date ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="appointment_time">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Appointment Time:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="appointment_start_time" id="appointment_time" class="form-control" value="<?php echo $appointment_time ?>">
                        </div>

                        <!-- <div class="form-group mb-3">
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
                        </div> -->

                        <div class="form-group mb-3">
                            <label for="appointment_status">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Appointment Status:
                                <span class="required-text">(required)</span>
                            </label>
                            <select name="appointment_status" id="appointment_status" class="form-control">
                                <option value="CANCELLED">CANCELLED</option>
                                <option value="MISSED">MISSED</option>
                                <option value="UPCOMING">UPCOMING</option>
                                <option value="COMPLETED">COMPLETED</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="queue_no">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Queue No:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="queue_no" id="queue_no" class="form-control" value="<?php echo $queue_no ?>" disabled>
                        </div>

                        <div class="buttons">
                            <button type="button" class="btn back-btn">Go Back</button>
                            <button type="submit" name="submit" class="btn save-btn">Save Appointment</button>
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
            yearRange: "-100:+0",
            changeMonth: true,
            changeYear: true,
            minDate: today
        });

        $('#appointment_time').timepicker({
            timeFormat: 'HH:mm',
            minTime: '1100',
            maxTime: '1630',
            showDuration: true,
            interval: 15
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.back-btn').on('click', function() {
            window.location.href = "appointmentDetails.php";
        });
    });
</script>

</html>