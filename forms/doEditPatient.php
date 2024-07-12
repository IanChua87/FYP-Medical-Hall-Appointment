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
    $patient_name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $payment_status = $_POST['payment_status'];
    $amount_payable = $_POST['amount_payable'];

    // $select_query = "SELECT patient_id FROM appointment WHERE appointment_id = ?";
    // $select_stmt = mysqli_prepare($conn, $select_query);

    // if (!$select_stmt) {
    //     die("Failed to prepare statement");
    // } else {
    //     mysqli_stmt_bind_param($select_stmt, 'i', $patient_id);
    //     mysqli_stmt_execute($select_stmt);
    //     $select_result = mysqli_stmt_get_result($select_stmt);

    //     if (mysqli_num_rows($select_result) > 0) {
    //         $row = mysqli_fetch_assoc($select_result);
    //         $patient_id = $row['patient_id'];

    //         $patient_query = "SELECT * FROM patient WHERE patient_id = ?";
    //         $patient_stmt = mysqli_prepare($conn, $patient_query);

    //         if (!$patient_stmt) {
    //             die("Failed to prepare statement");
    //         } else {
    //             mysqli_stmt_bind_param($patient_stmt, 'i', $patient_id);
    //             mysqli_stmt_execute($patient_stmt);
    //             $patient_result = mysqli_stmt_get_result($patient_stmt);

    //             if (mysqli_num_rows($patient_result) > 0) {
    //                 $patient_row = mysqli_fetch_assoc($patient_result);

    //                 // Update the appointment with the new end time
    //                 $update_query = "UPDATE patient SET patient_email = ?, patient_password = ? WHERE patient_id = ?";
    //                 $update_patient_stmt = mysqli_prepare($conn, $update_query);

    //                 if(!$update_patient_stmt){
    //                     die("Failed to prepare statement");
    //                 } else {
    //                     mysqli_stmt_bind_param($update_patient_stmt, 'ssi', $email, $password, $patient_id);

    //                     if(mysqli_stmt_execute($update_patient_stmt)){
    //                         $_SESSION['error'] = "Updated patient profile successfully.";
    //                         header("Location: patientDetails.php");
    //                         exit();
    //                     } else {
    //                         $_SESSION['error'] = "Failed to update appointment." . mysqli_stmt_error($update_appointment_stmt);
    //                     }
    //                     mysqli_stmt_close($update_patient_stmt);
    //                 }
    //             } else {
    //                 $_SESSION['error'] = "Patient not found.";
    //                 header("Location: patientDetails.php");
    //                 exit();
    //             }
    //         }
    //     } else {
    //         $_SESSION['error'] = "Patient not found.";
    //         header("Location: patientDetails.php");
    //         exit();
    //     }
    // }


    if (invalid_name($name) !== false) {
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
        $_SESSION['error'] = "Only numbers allowed in phone number.";
        header("Location: editPatient.php?patient_id=" . $patient_id);
        exit();
    }

    if (check_patient_exists_by_id($conn, $patient_id) !== false) {

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
    header("Location: appointmentDetails.php");
    exit();
}
