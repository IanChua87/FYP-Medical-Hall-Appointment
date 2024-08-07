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

if (isset($_POST['appointment_id'])) {
    $id = $_POST['appointment_id'];

    if(check_appointment_by_appointment_status($conn, $id) !== false){
        $_SESSION['message'] = "Appointment record cannot be deleted as it is still in progress.";
        header("Location: appointmentDetails.php");
        exit();
    }

    $query = "DELETE FROM appointment WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Appointment record deleted successfully.";
            header("Location: appointmentDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Appointment record failed to be deleted.";
            header("Location: appointmentDetails.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("Location: appointmentDetails.php");
    exit();

}
ob_end_flush();
