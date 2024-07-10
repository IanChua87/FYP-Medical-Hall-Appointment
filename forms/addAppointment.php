<?php
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
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="text" name="appointment_date" id="appointment_date" class="form-control">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="text" name="appointment_time" id="appointment_time" class="form-control">
                </div>

                <div class="form-group">
                    <label for="relation">Relation:</label>
                    <select name="relation" id="relation" class="form-control">
                        <option value="select">Select Relation</option>
                        <option value="parent">Parent</option>
                        <option value="sibling">Sibling</option>
                        <option value="child">Child</option>
                        <option value="spouse">Spouse</option>
                        <option value="friend">Friend</option>
                        <option value="other">Other</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="relation">Queue No:</label>
                    <input type="text" name="queue" id="queue" class="form-control" value="<?php echo $latest_queue_no ?>" disabled>
                </div>

                <div class="buttons">
                    <button type="submit" name="submit" class="btn create-btn">Create</button>
                </div>
            </form>
        </div>

    </section>
</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
    $(document).ready(function() {
        var today = new Date();
        $('#appointment_date').datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day !== 1 && day !== 0), ''];
            },
            minDate: today,
            changeMonth: true,
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