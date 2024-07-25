<?php
ob_start();
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


    if (check_empty_patient_reset_password_field($password, $confirm_password)) {
        $_SESSION['error'] = "Please enter your password and confirm password.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if (check_password_match($password, $confirm_password)) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if (check_password_strength($password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if(check_patient_password($conn, $password, $patient_id) !== false){
        $_SESSION['error'] = "Password cannot be the same as the current password.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

    if (update_patient_password($conn, $password, $patient_id) !== false) {
        $_SESSION['message'] = "Updated patient password successfully.";
        header("Location: patientDetails.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update patient password.";
        header("Location: resetPatientPassword.php?patient_id=" . $patient_id);
        exit();
    }

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: patientDetails.php");
    exit();
}
ob_end_flush();
