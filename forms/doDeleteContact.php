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

if (isset($_POST['contact_id'])) {
    $id = $_POST['contact_id'];


    $query = "DELETE FROM contact WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Contact record deleted successfully.";
            header("Location: contactDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Appointment record failed to be deleted.";
            header("Location: contactDetails.php");
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("Location: contactDetails.php");
    exit();

}
ob_end_flush();
