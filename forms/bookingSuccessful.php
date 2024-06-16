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
        $options = $_POST['options'];
        $relation = isset($_POST['relation']) ? $_POST['relation'] : null;

        // Separate the timeslot into start and end times
        $timeslot_parts = explode(' - ', $timeslot);
        if (count($timeslot_parts) == 2) {
            $appointment_start_time = $timeslot_parts[0];
            $appointment_end_time = $timeslot_parts[1];

            // Get the current date and time
            $booked_datetime = date('Y-m-d H:i:s');

            // Prepare the SQL query for inserting into appointment table
            $query = "INSERT INTO appointment (appointment_date, appointment_start_time, appointment_end_time, booked_by, booked_datetime, patient_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            if (!$stmt) {
                die("Failed to prepare statement: " . mysqli_error($conn));
            }

            // Bind the parameters for appointment insertion
            mysqli_stmt_bind_param($stmt, "sssssi", $apptdate, $appointment_start_time, $appointment_end_time, $patient_name, $booked_datetime, $patient_id);

            // Execute the statement for appointment insertion
            if (mysqli_stmt_execute($stmt)) {
                // Get the last inserted appointment ID
                $appointment_id = mysqli_insert_id($conn);

                // If booking is for others and relation is provided, insert into relation table
                if ($options === '2' && $relation) {
                    $sql = "INSERT INTO relation (relation_name, appointment_id) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);
                    if (!$stmt) {
                        die("Failed to prepare statement: " . mysqli_error($conn));
                    }
                    mysqli_stmt_bind_param($stmt, "si", $relation, $appointment_id);
                    if (!mysqli_stmt_execute($stmt)) {
                        $error = "Failed to book appointment for relation: " . mysqli_error($conn);
                        header("Location: dobooking.php?error=" . urlencode($error));
                        exit();
                    }
                    mysqli_stmt_close($stmt);
                }

                header("Location: bookingSuccessful.php?success=" . urlencode("Appointment booked successfully for relation: $relation"));
                exit();
            } else {
                $error = "Failed to book appointment: " . mysqli_error($conn);
                header("Location: dobooking.php?error=" . urlencode($error));
                exit();
            }

            // Close the statement and connection
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
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
    <title>Booked | Successful</title>
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
                    <h2>Booking<br> Successful</h2>
                    <div class="mt-3">
                        <a href="../index.php" class="btn back-to-home-btn">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


</body>

</html>

<?php
