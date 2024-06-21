<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if(isset($_POST['submit'])){
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    // $password = $_POST['password'];

    $query = "UPDATE users SET user_name = ?, user_email = ? WHERE user_id = ?";
    $update_users_stmt = mysqli_prepare($conn, $query);

    if(!$update_users_stmt){
        die("Failed to prepare statement");
    } else{
        mysqli_stmt_bind_param($update_users_stmt, 'ssi', $name, $email, $user_id);

        if(mysqli_stmt_execute($update_users_stmt)){
            $_SESSION['message'] = "Updated staff profile successfully.";
            header("Location: staffDetails.php");
            exit();
        } else{
            $_SESSION['message'] = "Failed to update staff." . mysqli_stmt_error($update_appointment_stmt);
        }
        mysqli_stmt_close($update_users_stmt);
    }
} else{
    header("Location: staffDetails.php");
    exit();

}







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Staff</title>
</head>
<body>
    
</body>
</html>