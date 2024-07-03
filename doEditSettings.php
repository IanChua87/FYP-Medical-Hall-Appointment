<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $settings_keys = [
        'weekday_open_time',
        'weekday_close_time',
        'weekend_open_time',
        'weekend_close_time',
        'opening_days',
        'appointment_duration',
        'new_appointment_duration',
        'last_queue_no'
    ];

    // Prepare the update statement outside the loop
    $update_query = "UPDATE settings SET settings_value = ? WHERE settings_key = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    if (!$update_stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    } else{
        mysqli_stmt_bind_param($update_stmt, 'ss', $value, $key);

        for ($i = 0; $i < count($settings_keys); $i++) {
            if(mysqli_stmt_execute($update_stmt)){
                $key = $settings_keys[$i];
                $value = $_POST[$key];
            } else {
                die("Failed to execute statement: " . mysqli_stmt_error($update_stmt));
            }
        }
    }
    mysqli_stmt_close($update_stmt);

    $_SESSION['message'] = "Updated clinic settings successfully.";
    header("Location: editSettings.php");
    exit();
} else {
    header("Location: settings.php");
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
