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
    $patient_name = $_POST['name'];
    $dob = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['dob'])));
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $payment_status = $_POST['payment_status'];
    $amount_payable = $_POST['amount_payable'];


    if (check_empty_edit_patient_input_fields($patient_name, $email, $dob, $phone, $payment_status)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: editPatient.php?patient_id=" . $patient_id);
        exit();
    }

    if (invalid_name($patient_name) !== false) {
        $_SESSION['error'] = "Only letters and white space allowed in name.";
        header("Location: editPatient.php?patient_id=" . $patient_id);
        exit();
    }

    if (invalid_email($email) !== false) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: editPatient.php?patient_id=" . $patient_id);
        exit();
    }

    if (invalid_phone_number($phone) !== false) {
        $_SESSION['error'] = "Phone Number must start with 8 or 9 and it must be of 8 characters long";
        header("Location: editPatient.php?patient_id=" . $patient_id);
        exit();
    }

    if (check_patient_exists_by_id($conn, $patient_id) !== false) {

        if (email_exists_for_other_patient($conn, $email, $patient_id)) {
            $_SESSION['error'] = "Email already in use by another patient.";
            header("Location: editPatient.php?patient_id=" . $patient_id);
            exit();
        }

        if (update_patient_details($conn, $patient_name, $dob, $phone, $email, $payment_status, $amount_payable, $patient_id) !== false) {
            $_SESSION['message'] = "Updated patient profile successfully.";
            header("Location: patientDetails.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to update patient profile.";
            header("Location: editPatient.php?patient_id=" . $patient_id);
            exit();
        }
    } else {
        $_SESSION['error'] = "Patient not found.";
        header("Location: patientDetails.php");
        exit();
    }
} else {
    $_SESSION['error'] = "invalid request";
    header("Location: patientDetails.php");
    exit();
}
ob_end_flush();