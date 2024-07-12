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
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $status = "New";
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
            if (insert_patient_details($conn, $name, $dob, $phone, $email, $hashed_password, $status, $_SESSION['admin_role'], $last_updated_datetime, $payment_status, $amount_payable, $is_verified) !== false) {
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

    // $select_query = "SELECT * FROM patient WHERE patient_name = ?";
    // $select_stmt = mysqli_prepare($conn, $select_query);

    // if (!$select_stmt) {
    //     die("Failed to prepare statement");
    // } 
    // else {
    //     mysqli_stmt_bind_param($select_stmt, 's', $patient_name);
    //     mysqli_stmt_execute($select_stmt);
    //     $select_result = mysqli_stmt_get_result($select_stmt);

    //     if (mysqli_num_rows($select_result) > 0) {
    //         $_SESSION['error'] = "Failed to add patient, patient already exists.";
    //     } else {
    //         $insert_query = "INSERT INTO patient (patient_dob, patient_phoneNo, patient_email, patient_password, patient_name, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    //         $patient_stmt = mysqli_prepare($conn, $insert_query);

    //         if (!$patient_stmt) {
    //             die("Failed to prepare statement");
    //         } else {
    //             mysqli_stmt_bind_param($patient_stmt, 'ssssssssss', $dob, $phone_number, $email, $hashed_password, $patient_name, $def_patient_status, $_SESSION['admin_role'], $current_date, $def_payment_status, $def_payment_amt);

    //             if (mysqli_stmt_execute($patient_stmt)) {
    //                 $_SESSION['error'] = "Patient successfully added.";
    //                 header("Location: patientDetails.php");
    //                 exit();
    //             } else {
    //                 $_SESSION['error'] = "Failed to add patient." . mysqli_stmt_error($patient_stmt);
    //             }

    //             mysqli_stmt_close($patient_stmt);
    //         }
    //     }
    // }
} else {
    header("Location: patientDetails.php");
    exit();
}
