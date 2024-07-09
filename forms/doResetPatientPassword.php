<?php
session_start();
include "../db_connect.php";
include "../helper_functions.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $patient_id = $_POST['patient_id'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    if(check_empty_patient_reset_password_field($password, $confirm_password)){
        $_SESSION['error'] = "Please enter your password and confirm password.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if(check_password_match($password, $confirm_password) !== false){
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if(update_patient_password($conn, $password) !== false){
        $_SESSION['message'] = "Updated patient password successfully.";
        header("Location: patientDetails.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update patient password.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    


} else {
    header("Location: appointmentDetails.php");
    exit();
}
