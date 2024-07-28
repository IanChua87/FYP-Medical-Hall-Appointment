<?php
ob_start();
session_start();
include "../db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $holiday_ids = $_POST['holiday_id'];
    

    $unique_dates = array();
    $duplicate_dates = array();

    for($i = 0; $i < count($holiday_ids); $i++) {
        if(empty($_POST['holiday_date_' . $holiday_ids[$i]])) {
            $_SESSION['error'] = "All fields are required";
            header("Location: editHoliday.php");
            exit();
        }
    }

    for($i = 0; $i < count($holiday_ids); $i++) {
        if(in_array($_POST['holiday_date_' . $holiday_ids[$i]], $unique_dates)) {
            $duplicate_dates[] = $_POST['holiday_date_' . $holiday_ids[$i]];
        } else {
            $unique_dates[] = $_POST['holiday_date_' . $holiday_ids[$i]];
        }
    }

    if(count($duplicate_dates) > 0) {
        $_SESSION['error'] = "Duplicate dates found: " . implode(", ", $duplicate_dates);
        header("Location: editHoliday.php");
        exit();
    }


    // Prepare update statement
    $update_query = "UPDATE holiday SET holiday_date = ? WHERE holiday_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);

    if (!$update_stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($update_stmt, 'si', $date, $id);

    foreach ($holiday_ids as $id) {
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['holiday_date_' . $id])));

        if (!mysqli_stmt_execute($update_stmt)) {
            die("Failed to execute statement: " . mysqli_stmt_error($update_stmt));
        }
    }

    mysqli_stmt_close($update_stmt);
    mysqli_close($conn);
    $_SESSION['message'] = "Updated holiday settings successfully.";
    header("Location: viewHoliday.php");
    exit();

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: editHoliday.php");
    exit();
}

ob_end_flush();
?>
