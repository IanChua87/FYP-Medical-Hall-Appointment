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
    $patient_id = $_POST['patient_id'];
    $email = $_POST['email'];

    $query = "UPDATE patient SET patient_email = ? WHERE patient_id = ?";
    $update_patient_stmt = mysqli_prepare($conn, $query);

    if(!$update_patient_stmt){
        die("Failed to prepare statement");
    } else{
        mysqli_stmt_bind_param($update_patient_stmt, 'ss', $email, $patient_id);

        if(mysqli_stmt_execute($update_patient_stmt)){
            $_SESSION['message'] = "Updated patient profile successfully.";
            header("Location: patientDetails.php");
            exit();
        } else{
            $_SESSION['message'] = "Failed to update appointment." . mysqli_stmt_error($update_appointment_stmt);
        }
        mysqli_stmt_close($update_patient_stmt);
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
    <title>Admin | Edit Patient</title>
</head>
<body>
    
</body>
</html>