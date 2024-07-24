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

    // Prepare update statement
    $update_query = "UPDATE holiday SET holiday_date = ? WHERE holiday_id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);

    if (!$update_stmt) {
        die("Failed to prepare statement: " . mysqli_error($conn));
    }

    // Bind parameters and execute the statement for each holiday
    mysqli_stmt_bind_param($update_stmt, 'si', $date, $id);

    foreach ($holiday_ids as $id) {
        $date = $_POST['holiday_date_' . $id];

        if (!mysqli_stmt_execute($update_stmt)) {
            die("Failed to execute statement: " . mysqli_stmt_error($update_stmt));
        }
    }

    // Close statement and connection
    mysqli_stmt_close($update_stmt);
    $conn->close();
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
