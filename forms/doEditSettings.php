<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
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
    ];

    $update_query = "UPDATE settings SET settings_value = ? WHERE settings_key = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);

    if (!$update_stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }
    else{
        mysqli_stmt_bind_param($update_stmt, 'ss', $value, $key);

        for ($i = 0; $i < count($settings_keys); $i++) {
            $key = $settings_keys[$i];
            $value = $_POST[$key];

            if (!mysqli_stmt_execute($update_stmt)) {
                die("Failed to execute statement: " . mysqli_stmt_error($update_stmt));
            }
        }

        mysqli_stmt_close($update_stmt);

        $_SESSION['message'] = "Updated clinic settings successfully.";
        header("Location: settings.php");
        exit();
    }

} else {
    header("Location: editSettings.php");
    exit();
}
