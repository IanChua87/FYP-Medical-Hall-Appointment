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
    <title>Admin | Add Staff</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>

<body>
    <section class="patient-add">
        <div class="patient-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class="">Add Staff</h2>
            </div>
            <form action="doAddStaff.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="staff_name" id="staff_name" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" value="">
                </div>

                <select class="form-select" id="role" name="role">
                    <option selected class="selected">Select...</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Admin">Admin</option>
                </select>

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
        $('#dob').datepicker({
            dateFormat: 'yy-mm-dd',
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

<?php include 'sessionMsg.php' ?>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg').fadeOut('slow');
        }, 1700);
    });
</script>

</html>