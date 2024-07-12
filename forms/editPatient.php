<?php
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM patient WHERE patient_id = ?";
$edit_patient_stmt = mysqli_prepare($conn, $query);


if (!$edit_patient_stmt) {
    die("Failed to prepare statement");
} else {
    mysqli_stmt_bind_param($edit_patient_stmt, 's', $_GET['patient_id']);
    mysqli_stmt_execute($edit_patient_stmt);
    $edit_patient_result = mysqli_stmt_get_result($edit_patient_stmt);

    if (mysqli_num_rows($edit_patient_result) > 0) {
        if ($row = mysqli_fetch_assoc($edit_patient_result)) {
            $patient_id = $row['patient_id'];
            $patient_name = $row['patient_name'];
            $dob = $row['patient_dob'];
            $patient_phoneNo = $row['patient_phoneNo'];
            $patient_email = $row['patient_email'];
            $patient_status = $row['patient_status'];
            $patient_password = $row['patient_password'];
            $payment_status = $row['payment_status'];
            $amount_payable = $row['amount_payable'];
        }
    } else {
        $_SESSION['message'] = "Patient not found.";
        header("Location: patientDetails.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Patient Details</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <style>
        .session-msg-error{
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>
    <section class="patient">
        <div class="patient-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class=""><?php echo $patient_name ?></h2>
            </div>
            <form action="doEditPatient.php" method="POST">
                <div class="form-group">
                    <input type="text" name="patient_id" class="form-control" value="<?php echo $patient_id ?>" hidden>
                </div>

                <div class="form-group">
                    <label for="dob">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $patient_name ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $patient_email ?>">
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="text" name="dob" id="dob" class="form-control" value="<?php echo $dob ?>">
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number:</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $patient_phoneNo ?>">
                </div>

                <div class="double-form-field row mb-2">
                    <div class="col-sm-6">
                        <div class="form-outline">
                            <label for="status">Payment Status:</label>
                            <select name="payment_status" id="payment_status" class="form-control form-control-lg mb-1">
                                <option value="PAID" <?php if ($payment_status == "PAID") echo "selected" ?>>PAID</option>
                                <option value="UNPAID" <?php if ($payment_status == "UNPAID") echo "selected" ?>>UNPAID</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline">
                            <label for="status">Amount Payable</label>
                            <input type="text" id="amount_payable" class="form-control form-control-lg mb-1" placeholder="Payable" name="amount_payable" value="<?php echo $amount_payable ?>" />
                        </div>
                    </div>
                </div>

                <div class="buttons">
                    <button type="button" class="btn back-btn">Back</button>
                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                </div>
            </form>
            <div class="row mb-4">
                <div class="col text-end text-underline">
                    <a href='resetPatientPassword.php?patient_id=<?php echo $row['patient_id'] ?>' class="forgot-text">Reset Password</a>
                </div>
            </div>
            <?php include '../sessionMsg.php' ?>
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
            window.location.href = "patientDetails.php";
        });
    });
    
    $(document).ready(function() {
            $("#dob").datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: "-100:+0",
                dateFormat: "yy-mm-dd"
            });
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

<script>
</script>

</html>