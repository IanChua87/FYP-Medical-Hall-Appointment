<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if (isset($_POST['appointment_id'])) {
    $id = $_POST['appointment_id'];

    $query = "DELETE FROM appointment WHERE appointment_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 's', $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: appointmentDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Appointment deleted successfully.";
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("Location: appointmentDetails.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>