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
    $password = $_POST['password'];

    $select_query = "SELECT patient_id FROM appointment WHERE appointment_id = ?";
    $select_stmt = mysqli_prepare($conn, $select_query);

    if (!$select_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($select_stmt, 'i', $patient_id);
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
                    $update_query = "UPDATE patient SET patient_email = ?, patient_password = ? WHERE patient_id = ?";
                    $update_patient_stmt = mysqli_prepare($conn, $update_query);

                    if(!$update_patient_stmt){
                        die("Failed to prepare statement");
                    } else {
                        mysqli_stmt_bind_param($update_patient_stmt, 'ssi', $email, $password, $patient_id);

                        if(mysqli_stmt_execute($update_patient_stmt)){
                            $_SESSION['message'] = "Updated patient profile successfully.";
                            header("Location: patientDetails.php");
                            exit();
                        } else {
                            $_SESSION['message'] = "Failed to update appointment." . mysqli_stmt_error($update_appointment_stmt);
                        }
                        mysqli_stmt_close($update_patient_stmt);
                    }
                } else {
                    $_SESSION['message'] = "Patient not found.";
                    header("Location: patientDetails.php");
                    exit();
                }
            }
        } else {
            $_SESSION['message'] = "Patient not found.";
            header("Location: patientDetails.php");
            exit();
        }
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