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
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $status = "NEW";
    $last_updated_datetime = date('Y-m-d H:i:s');
    $payment_status = "UNPAID";
    $amount_payable = 50.00;
    $is_verified = 0;

    if (check_empty_add_patient_input_fields($name, $email, $password, $dob, $phone)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: addPatient.php");
        exit();
    } else {

        if (invalid_name($name) !== false) {
            $_SESSION['error'] = "Only letters and white space allowed in name.";
            header("Location: addPatient.php");
            exit();
        }

        if (invalid_email($email) !== false) {
            $_SESSION['error'] = "Invalid email format.";
            header("Location: addPatient.php");
            exit();
        }

        if (check_password_strength($password)) {
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            header("Location: addPatient.php");
            exit();
        }

        if (invalid_phone_number($phone) !== false) {
            $_SESSION['error'] = "Only numbers allowed in phone number.";
            header("Location: addPatient.php");
            exit();
        }

        if (check_patient_exists_by_email($conn, $email) !== false) {
            $_SESSION['error'] = "Patient with this email already exists.";
            header("Location: addPatient.php");
            exit();
        } else {
            if (insert_patient_details($conn, $name, $dob, $phone, $email, $password, $status, $_SESSION['admin_role'], $last_updated_datetime, $payment_status, $amount_payable, $is_verified) !== false) {
                $_SESSION['message'] = "Patient successfully added.";
                header("Location: patientDetails.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to add patient.";
                header("Location: addPatient.php");
                exit();
            }
        }
    }
    
} else {
    header("Location: patientDetails.php");
    exit();
}
ob_end_flush();