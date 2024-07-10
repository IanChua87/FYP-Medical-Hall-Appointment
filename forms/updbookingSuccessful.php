<?php
include "../db_connect.php";
session_start();

$error = "";

// Check if the user is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: forms/login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Query the database to retrieve the patient's name
$query = "SELECT patient_name FROM patient WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $patient_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $patient_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Check if the form is submitted
if (isset($_POST['book'])) {
    if (isset($_POST['timeslot']) && isset($_POST['apptdate'])) {
        $timeslot = $_POST['timeslot'];
        $apptdate = $_POST['apptdate'];
        $appt_id = $_POST['appt_id'];

        // Separate the timeslot into start and end times
        $timeslot_parts = explode(' - ', $timeslot);
        if (count($timeslot_parts) == 2) {
            $appointment_start_time = $timeslot_parts[0];
            $appointment_end_time = $timeslot_parts[1];

            // Prepare the SQL query for updating the appointment table
            $query = "UPDATE appointment SET appointment_date = ?, appointment_start_time = ?, appointment_end_time = ? WHERE appointment_id = ? AND patient_id = ?";
            $stmt = mysqli_prepare($conn, $query);

            if (!$stmt) {
                die("Failed to prepare statement: " . mysqli_error($conn));
            }

            // Bind the parameters for appointment update
            mysqli_stmt_bind_param($stmt, "ssssi", $apptdate, $appointment_start_time, $appointment_end_time, $appt_id, $patient_id);

            // Execute the statement for appointment update
            if (mysqli_stmt_execute($stmt)) {
                // Check if any rows were affected
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);

                    header("Location: updbookingSuccessful.php?success=" . urlencode("Appointment updated successfully"));
                    exit();
                } else {
                    $error = "No appointment found for update.";
                    header("Location: dobooking.php?error=" . urlencode($error));
                    exit();
                }
            } else {
                $error = "Failed to update appointment: " . mysqli_error($conn);
                header("Location: dobooking.php?error=" . urlencode($error));
                exit();
            }

        } else {
            $error = "Invalid timeslot format.";
            header("Location: dobooking.php?error=" . urlencode($error));
            exit();
        }
    } else {
        $error = "Missing required fields.";
        header("Location: dobooking.php?error=" . urlencode($error));
        exit();
    }
}
?>






<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Update Booking | Successful</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>

<body>
<section class="booked vh-100">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-8 px-0 d-sm-block left-col">
                <img src="../img/side-image.png" alt="Login image" class="w-100 vh-100"
                     style="object-fit: cover; object-position: left;">
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 text-black right-col">
                <div class="verified-box">
                    <img src="../img/tick-verification.svg" alt="Tick logo symbol"/>
                    <h2>Update<br> Successful</h2>
                    <div class="mt-3">
                        <a href="../P_index.php" class="btn back-to-home-btn">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>

</html>

<?php
