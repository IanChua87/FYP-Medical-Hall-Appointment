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
    if (empty($_POST['staff_name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['role'])) {
        $_SESSION['message'] = "Please fill in all fields.";
        header("Location: addStaff.php");
    } else {
        $staff_name = $_POST['staff_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $select_query = "SELECT * FROM users WHERE user_name = ?";
        $select_stmt = mysqli_prepare($conn, $select_query);

        if (!$select_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($select_stmt, 's', $staff_name);
            mysqli_stmt_execute($select_stmt);
            $select_result = mysqli_stmt_get_result($select_stmt);

            if (mysqli_num_rows($select_result) > 0) {
                $_SESSION['message'] = "Failed to add staff, staff already exist.";
            } else {
                $insert_query = "INSERT INTO users (user_name, user_email, user_password, role) VALUES (?, ?, ?, ?)";
                $user_stmt = mysqli_prepare($conn, $insert_query);

                if (!$user_stmt) {
                    die("Failed to prepare statement");
                } else {
                    mysqli_stmt_bind_param($user_stmt, 'ssss', $staff_name, $email, $hashed_password, $role);

                    if (mysqli_stmt_execute($user_stmt)) {
                        $_SESSION['message'] = "Staff successfully added.";
                        header("Location: staffDetails.php");
                        exit();
                    } else {
                        $_SESSION['message'] = "Failed to add staff." . mysqli_stmt_error($user_stmt);
                    }

                    mysqli_stmt_close($user_stmt);
                }
            }
        }
    }
} else {
    header("Location: staffDetails.php");
    exit();
}
?>


