<?php
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['patient_id'])) {
    $_SESSION['message'] = "Patient not found.";
    header("Location: patientDetails.php");
    exit();
}


$patient_id = $_GET['patient_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Reset Password</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>

<body>
    <section class="patient">
    <?php include '../sessionMsg.php' ?>
        <div class="patient-box">
            <div class="profile-details">
                <i class="fa-solid fa-lock"></i>
                <h2 class="">
                    Reset Password
                </h2>
            </div>
            <form action="doResetPatientPassword.php" method="POST">
                <input type="text" name="patient_id" id="patient_id" value="<?php echo $patient_id ?>" hidden>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>

                <div class="buttons">
                    <button type="button" class="btn back-btn">Back</button>
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
        $('.back-btn').on('click', function() {
            window.location.href = "editPatient.php?patient_id=<?php echo $_GET['patient_id'] ?>";
        });
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

</html>