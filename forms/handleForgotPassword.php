<?php
session_start();
include "../db_connect.php";
include "../helper_functions.php";
?>

<?php
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];

    if(check_empty_reset_password_input_fields($email, $oldPassword, $newPassword)){
        $_SESSION['error'] = "All fields are required.";
        $_SESSION['form_data'] = $_POST;
        header("Location: forgotPassword.php");
        exit();
    } else{
        if (invalid_email($email) !== false) {
            $_SESSION['error'] = "Invalid email format.";
            $_SESSION['form_data'] = $_POST;
            header("Location: forgotPassword.php");
            exit();
        }

        if (check_password_strength($newPassword)){
            $_SESSION['error'] = "Password must be at least 8 characters long.";
            $_SESSION['form_data'] = $_POST;
            header("Location: forgotPassword.php");
            exit();
        }

        if(check_patient_exists_by_email($conn, $email) !== false){
            $_SESSION['error'] = "User with this email already exists.";
            $_SESSION['form_data'] = $_POST;
            header("Location: register.php");
            exit();
        } else{
            if(update_patient_password($conn, $password) !== false){
                $_SESSION['error'] = "Password updated successfully.";
                $_SESSION['form_data'] = $_POST;
                header("Location: login.php");
            }
        }

    }
} else{
    header("Location: forgotPassword.php");
    exit();
}