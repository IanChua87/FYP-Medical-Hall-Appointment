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
    $staff_name = $_POST['staff_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if (check_empty_users_input_fields($staff_name, $email, $password, $role)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: addStaff.php");
        exit();
    }

    if (invalid_name($staff_name) !== false) {
        $_SESSION['error'] = "Only letters and white space allowed in name.";
        header("Location: addStaff.php");
        exit();
    }

    if (invalid_email($email) !== false) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: addStaff.php");
        exit();
    }

    if (check_password_strength($password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header("Location: addStaff.php");
        exit();
    }

    if (check_users_exists_by_email($conn, $email) !== false) {
        $_SESSION['error'] = "Staff with this email already exists.";
        header("Location: addStaff.php");
        exit();
    } else {
        if (insert_users_details($conn, $staff_name, $email, $password, $role) !== false) {
            $_SESSION['error'] = "Staff successfully added.";
            header("Location: staffDetails.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to add staff.";
            header("Location: addStaff.php");
        }
    }
} else {

    header("Location: staffDetails.php");
    exit();
}
ob_end_flush();
?>


