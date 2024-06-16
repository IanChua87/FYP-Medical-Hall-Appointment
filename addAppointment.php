<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Appointment</title>
     <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
    <section class="appointment-add">
        <div class="appointment-box">
            <div class="profile-details">
                <i class="fa-regular fa-calendar"></i>
                <h2 class="">Add Appointment</h2>
            </div>
            <form action="doAddAppointment.php" method="POST">
                <div class="form-group">
                    <input type="text" name="patient_id" id="patient_id" class="form-control" value="" hidden>
                </div>

                <div class="form-group">
                    <label for="patient_name">Name:</label>
                    <input type="text" name="patient_name" id="patient_name" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="text" name="appointment_time" id="appointment_time" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="relation">Relation:</label>
                    <input type="text" name="relation" id="relation" class="form-control" value="">
                </div>

                <div class="buttons">
                    <button type="submit" name="submit" class="btn create-btn">Create</button>
                </div>
        </div>
    </section>
</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('#appointment_date').datepicker({
            dateFormat: 'yy-mm-dd', 
            beforeShowDay: function(date) {
                    var day = date.getDay();
                    return [(day !== 1 && day !== 0), ''];
            }
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
</html>