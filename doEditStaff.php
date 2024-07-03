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
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $select_query = "SELECT user_id FROM users WHERE user_id = ?";
    $select_stmt = mysqli_prepare($conn, $select_query);

    if (!$select_stmt) {
        die("Failed to prepare statement");
    } else {
        mysqli_stmt_bind_param($select_stmt, 'i', $user_id);
        mysqli_stmt_execute($select_stmt);
        $select_result = mysqli_stmt_get_result($select_stmt);

        if (mysqli_num_rows($select_result) > 0) {
            $row = mysqli_fetch_assoc($select_result);
            $user_id = $row['user_id'];

            $update_query = "UPDATE users SET user_name = ?, user_email, user_password = ? WHERE user_id = ?";
            $update_users_stmt = mysqli_prepare($conn, $update_query);

            if (!$update_users_stmt) {
                die("Failed to prepare statement");
            } else {
                mysqli_stmt_bind_param($update_users_stmt, 'sssi', $name, $email, $password, $user_id);

                if (mysqli_stmt_execute($update_users_stmt)) {
                    $_SESSION['message'] = "Updated staff profile successfully.";
                    header("Location: staffDetails.php");
                    exit();
                } else {
                    $_SESSION['message'] = "Failed to update staff." . mysqli_stmt_error($update_appointment_stmt);
                }
                mysqli_stmt_close($update_users_stmt);
            }
        }
    }
} else {
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