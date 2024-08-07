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

if (isset($_POST['patient_id'])) {
    $id = $_POST['patient_id'];

    if (check_patient_exist_by_payment_status($conn, $id) !== false) {
        $_SESSION['message'] = "Patient record cannot be deleted as there are payment records associated with it.";
        header("Location: patientDetails.php");
        exit();
    }

    $query = "DELETE FROM patient WHERE patient_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Patient record deleted successfully.";
            header("Location: patientDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Patient record failed to be deleted.";
            header("Location: patientDetails.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else {
    header("Location: patientDetails.php");
    exit();
}
ob_end_flush();
