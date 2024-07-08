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
    $staff_name = $_POST['staff_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];
    
    if (check_empty_users_input_fields($staff_name, $email, $password, $role)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: addStaff.php");
        exit();
    } else {
        if(check_users_exists_by_email($conn, $email) !== false){
            $_SESSION['error'] = "Failed to add staff.";
            header("Location: addStaff.php");
            exit();
        } 
        else{
            if(insert_users_details($conn, $staff_name, $email, $hashed_password, $role) !== false){
                $_SESSION['error'] = "Staff successfully added.";
                header("Location: staffDetails.php");
                exit();
            } else{
                $_SESSION['error'] = "Failed to add staff.";
                header("Location: addStaff.php");
            }
        }

        // $select_query = "SELECT * FROM users WHERE user_name = ?";
        // $select_stmt = mysqli_prepare($conn, $select_query);

        // if (!$select_stmt) {
        //     die("Failed to prepare statement");

        // } else {
        //     mysqli_stmt_bind_param($select_stmt, 's', $staff_name);
        //     mysqli_stmt_execute($select_stmt);
        //     $select_result = mysqli_stmt_get_result($select_stmt);

        //     if (mysqli_num_rows($select_result) > 0) {
        //         $_SESSION['error'] = "Failed to add staff, staff already exist.";
        //     } else {
        //         $insert_query = "INSERT INTO users (user_name, user_email, user_password, role) VALUES (?, ?, ?, ?)";
        //         $user_stmt = mysqli_prepare($conn, $insert_query);

        //         if (!$user_stmt) {
        //             die("Failed to prepare statement");
        //         } else {
        //             mysqli_stmt_bind_param($user_stmt, 'ssss', $staff_name, $email, $hashed_password, $role);

        //             if (mysqli_stmt_execute($user_stmt)) {
        //                 $_SESSION['error'] = "Staff successfully added.";
        //                 header("Location: staffDetails.php");
        //                 exit();
        //             } else {
        //                 $_SESSION['error'] = "Failed to add staff." . mysqli_stmt_error($user_stmt);
        //             }

        //             mysqli_stmt_close($user_stmt);
        //         }
        //     }
            
        // }
    }
} else {
    header("Location: staffDetails.php");
    exit();
}
?>


