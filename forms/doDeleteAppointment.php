<?php
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['appointment_id'])) {
    $id = $_POST['appointment_id'];

    $query = "DELETE FROM appointment WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: appointmentDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Appointment record failed to be deleted.";
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("Location: appointmentDetails.php");
    exit();

}
