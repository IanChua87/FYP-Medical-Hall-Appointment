<?php
ob_start();
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

    $weekday_open_time = $_POST['weekday_open_time'];
    $weekday_close_time = $_POST['weekday_close_time'];
    $weekend_open_time = $_POST['weekend_open_time'];
    $weekend_close_time = $_POST['weekend_close_time'];
    $opening_days = $_POST['opening_days'];
    $appointment_duration = $_POST['appointment_duration'];
    $new_appointment_duration = $_POST['new_appointment_duration'];


    if (empty($weekday_open_time) || empty($weekday_close_time) || empty($weekend_open_time) || empty($weekend_close_time) || empty($opening_days) || empty($appointment_duration) || empty($new_appointment_duration)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: editSettings.php");
        exit();
    }

    // if (!preg_match('/^[a-zA-Z]+$/', $opening_days)) {
    //     $_SESSION['error'] = "Opening days must contain only text.";
    //     header("Location: editSettings.php");
    //     exit();
    // }

    if (!is_numeric($appointment_duration) || !is_numeric($new_appointment_duration)) {
        $_SESSION['error'] = "Appointment duration must be a number.";
        header("Location: editSettings.php");
        exit();
    }

    $update_query = "UPDATE settings SET settings_value = ? WHERE settings_key = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);

    if (!$update_stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    } else {
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
    $_SESSION['error'] = "Invalid request.";
    header("Location: editSettings.php");
    exit();
}
ob_end_flush();
