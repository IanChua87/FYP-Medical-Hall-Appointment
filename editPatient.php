<?php 
session_start();
include "db_connect.php";
?>

<?php 
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

$query = "SELECT * FROM patient P INNER JOIN appointment A ON P.patient_id = A.patient_id WHERE appointment_id = ?";
$edit_appointment_stmt = mysqli_prepare($conn, $query);
if (!$edit_appointment_stmt) {
    die("Failed to prepare statement");
} else{
    mysqli_stmt_bind_param($edit_appointment_stmt, 's', $_GET['appointment_id']);
    mysqli_stmt_execute($edit_appointment_stmt);
    $edit_appointment_result = mysqli_stmt_get_result($edit_appointment_stmt);

    if(mysqli_num_rows($edit_appointment_result) > 0){
        $row = mysqli_fetch_assoc($edit_appointment_result);

        $patient_name = $row['patient_name'];
        $phone_number = $row['patient_phoneNo'];
        $appointment_id = $row['appointment_id'];
        $appointment_date = $row['appointment_date'];
        $appointment_time = $row['appointment_time'];
        $appointment_status = $row['appointment_status'];

    } else{
        $_SESSION['message'] = "Appointment not found.";
        header("Location: appointmentDetails.php");
        exit();
    
    }
}
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Patient Details</title>
     <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
    <section class="patient">
        <div class="patient-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class=""><?php echo $patient_name ?></h2>
            </div>
            <form action="doEditAppointment.php" method="POST">
                <div class="form-group">
                    <input type="text" name="appointment_id" class="form-control" value="<?php echo $appointment_id ?>" hidden>
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="<?php echo $phone_number ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="appointment_date">Appointment Date:</label>
                    <input type="text" name="appointment_date" id="appointment_date" class="form-control" value="<?php echo $appointment_date ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Appointment Time:</label>
                    <input type="text" name="appointment_time" id="appointment_time" class="form-control" value="<?php echo $appointment_time ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_status">Appointment Status:</label>
                    <input type="text" name="appointment_status" id="appointment_status" class="form-control" value="<?php echo $appointment_status ?>" disabled>
                </div>
                <div class="buttons">
                    <button class="btn back-btn">Back</button>
                    <button type="submit" name="submit" class="btn save-btn">Save</button>
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
            dateFormat: 'yy-mm-dd'
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