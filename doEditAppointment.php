<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if(isset($_POST['submit'])){
    $appointment_id = $_POST['appointment_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time =  $_POST['appointment_time'];

    $query = "UPDATE appointment SET appointment_date = ?, appointment_time = ? WHERE appointment_id = ?";
    $update_appointment_stmt = mysqli_prepare($conn, $query);

    if(!$update_appointment_stmt){
        die("Failed to prepare statement");
    } else{
        mysqli_stmt_bind_param($update_appointment_stmt, 'ssi', $appointment_date, $appointment_time, $appointment_id);

        if(mysqli_stmt_execute($update_appointment_stmt)){
            header("Location: appointmentDetails.php");
            exit();
        } else{
            $_SESSION['message'] = "Failed to update appointment." . mysqli_stmt_error($update_appointment_stmt);
        }
        mysqli_stmt_close($update_appointment_stmt);
    }
} else{
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