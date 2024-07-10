<?php
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
</head>

<body>
    <section class="appointment">
        <div class="appointment-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class=""><?php echo $patient_name ?></h2>
            </div>
            <form action="doEditAppointment.php" method="POST">
                <div class="form-group">
                    <input type="text" name="appointment_id" class="form-control" value="<?php echo $appointment_id ?>" hidden>
                </div>

                <div class="form-group">
                    <input type="text" name="patient_id" class="form-control" value="<?php echo $patient_id ?>" hidden>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $appointment_date ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="text" name="appointment_start_time" id="appointment_time" class="form-control" value="<?php echo $appointment_time ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_status">Appointment Status:</label>
                    <select name="appointment_status" id="appointment_status" class="form-control">
                        <option value="CANCELLED">CANCELLED</option>
                        <option value="MISSED">MISSED</option>
                        <option value="UPCOMING">UPCOMING</option>
                        <option value="COMPLETED">COMPLETED</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="queue_no">Queue No:</label>
                    <input type="text" name="queue_no" id="queue_no" class="form-control" value="<?php echo $queue_no ?>" disabled>
                </div>

                <div class="buttons">
                    <button type="button" class="btn back-btn">Back</button>
                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                </div>
        </div>
    </section>
</body>

<script>
    $(document).ready(function() {
        var today = new Date();
        $('#appointment_date').datepicker({
            dateFormat: 'yy-mm-dd',
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
        $('.back-btn').on('click', function() {
            window.location.href = "appointmentDetails.php";
        });
    });
</script>

</html>