<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if(isset($_POST['submit'])){
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_start_time =  $_POST['appointment_start_time'];
    $appointment_end_time = date('H:i:s', strtotime($appointment_start_time) + 1800);

    $select_query = "SELECT patient_id FROM appointment WHERE appointment_id = ?";
    $select_stmt = mysqli_prepare($conn, $select_query);

    if (!$select_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($select_stmt, 'i', $appointment_id);
        mysqli_stmt_execute($select_stmt);
        $select_result = mysqli_stmt_get_result($select_stmt);

        if (mysqli_num_rows($select_result) > 0) {
            $row = mysqli_fetch_assoc($select_result);
            $patient_id = $row['patient_id'];

            $patient_query = "SELECT * FROM patient WHERE patient_id = ?";
            $patient_stmt = mysqli_prepare($conn, $patient_query);

            if (!$patient_stmt) {
                die("Failed to prepare statement");
            } else {
                mysqli_stmt_bind_param($patient_stmt, 'i', $patient_id);
                mysqli_stmt_execute($patient_stmt);
                $patient_result = mysqli_stmt_get_result($patient_stmt);

                if (mysqli_num_rows($patient_result) > 0) {
                    $patient_row = mysqli_fetch_assoc($patient_result);

                    // Update the appointment with the new end time
                    $update_query = "UPDATE appointment SET appointment_date = ?, appointment_start_time = ?, appointment_end_time = ? WHERE appointment_id = ?";
                    $update_appointment_stmt = mysqli_prepare($conn, $update_query);

                    if(!$update_appointment_stmt){
                        die("Failed to prepare statement");
                    } else {
                        mysqli_stmt_bind_param($update_appointment_stmt, 'sssi', $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_id);

                        if(mysqli_stmt_execute($update_appointment_stmt)){
                            $_SESSION['message'] = "Appointment successfully updated.";
                            header("Location: appointmentDetails.php");
                            exit();
                        } else {
                            $_SESSION['message'] = "Failed to update appointment." . mysqli_stmt_error($update_appointment_stmt);
                        }
                        mysqli_stmt_close($update_appointment_stmt);
                    }
                }
                mysqli_stmt_close($patient_stmt);
            }
        } else {
            $_SESSION['message'] = "Appointment not found.";
            header("Location: editAppointment.php?appointment_id=" . $appointment_id);
            exit();
        }
        mysqli_stmt_close($select_stmt);
    }
} else {
    header("Location: appointmentDetails.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Updating Appointment</title>
</head>
<body>

</body>
</html>
