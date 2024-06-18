<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $patient_name = $_POST['patient_name'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_date = date('Y-m-d H:i:s');
    $def_payment_status = "Unpaid";
    $def_patient_status = "New";
    $def_payment_amt = 0;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $select_query = "SELECT * FROM patient WHERE patient_name = ?";
    $select_stmt = mysqli_prepare($conn, $select_query);

    if (!$select_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($select_stmt, 's', $patient_name);
        mysqli_stmt_execute($select_stmt);
        $select_result = mysqli_stmt_get_result($select_stmt);

        if (mysqli_num_rows($select_result) > 0) {
        } else {
            $insert_query = "INSERT INTO patient (patient_dob, patient_phoneNo, patient_email, patient_password, patient_name, patient_status, last_updated_by, last_updated_datetime, payment_status, amount_payable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $patient_stmt = mysqli_prepare($conn, $insert_query);

            if (!$patient_stmt) {
                die("Failed to prepare statement");
            } else {
                mysqli_stmt_bind_param($patient_stmt, 'ssssssssss', $dob, $phone_number, $email, $hashed_password, $patient_name, $def_patient_status, $_SESSION['admin_role'], $current_date, $def_payment_status, $def_payment_amt);

                if (mysqli_stmt_execute($patient_stmt)) {
                    $_SESSION['message'] = "Patient successfully added.";
                    header("Location: patientDetails.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Failed to add patient." . mysqli_stmt_error($appointment_stmt);
                }

                mysqli_stmt_close($appointment_stmt);
            }
        }
    }
} else {
    header("Location: patientDetails.php");
    exit();
}
