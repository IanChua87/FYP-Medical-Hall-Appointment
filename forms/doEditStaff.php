<?php
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
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    // $password = $_POST['password'];

    if(check_empty_edit_users_input_fields($name, $email)){
        $_SESSION['error'] = "All fields are required";
        header("Location: editStaff.php?user_id=" . $user_id);
        exit();
    }

    if (invalid_name($name) !== false) {
        $_SESSION['error'] = "Only letters and white space allowed in name.";
        header("Location: editStaff.php?user_id=" . $user_id);
        exit();
    }

    if (invalid_email($email) !== false) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: editStaff.php?user_id=" . $user_id);
        exit();
    }

    if(check_users_exists_by_id($conn, $user_id) !== false ){

        if(update_users_details($conn, $name, $email, $user_id) !== false){
            $_SESSION['message'] = "Staff profile successfully updated.";
            header("Location: staffDetails.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to update staff.";
            header("Location: editStaff.php?user_id=" . $user_id);
            exit();
        }

    } else{
        // $_SESSION['message'] = "Staff not found.";
        header("Location: staffDetails.php");
        exit();
    }

    // $select_query = "SELECT user_id FROM users WHERE user_id = ?";
    // $select_stmt = mysqli_prepare($conn, $select_query);

    // if (!$select_stmt) {
    //     die("Failed to prepare statement");
    // } else {
    //     mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
    //     mysqli_stmt_execute($select_stmt);
    //     $select_result = mysqli_stmt_get_result($select_stmt);

    //     if (mysqli_num_rows($select_result) > 0) {
    //         $row = mysqli_fetch_assoc($select_result);
    //         $user_id = $row['user_id'];

    //         $update_query = "UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?";
    //         $update_users_stmt = mysqli_prepare($conn, $update_query);

    //         if (!$update_users_stmt) {
    //             die("Failed to prepare statement");
    //         } else {
    //             mysqli_stmt_bind_param($update_users_stmt, 'sssi', $name, $email, $password, $user_id);

    //             if (mysqli_stmt_execute($update_users_stmt)) {
    //                 $_SESSION['message'] = "Updated staff profile successfully.";
    //                 header("Location: staffDetails.php");
    //                 exit();
    //             } else {
    //                 $_SESSION['message'] = "Failed to update staff." . mysqli_stmt_error($update_appointment_stmt);
    //             }
    //             mysqli_stmt_close($update_users_stmt);
    //         }
    //     }
    // }
} else {
    header("Location: staffDetails.php");
    exit();
}
