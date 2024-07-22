<?php
ob_start();
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];

    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: staffDetails.php");
            exit();
        } else {
            $_SESSION['message'] = "Staff record failed to be deleted.";
        }
        mysqli_stmt_close($stmt);
    }
} else{
    header("Location: staffDetails.php");
    exit();
}
ob_end_flush();
