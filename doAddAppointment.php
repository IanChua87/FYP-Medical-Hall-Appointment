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
    if (empty($_POST['patient_name']) || empty($_POST['appointment_date']) || empty($_POST['appointment_time']) || empty($_POST['relation'])) {
        $_SESSION['message'] = "Please fill in all fields.";
        header("Location: addAppointment.php");
        exit();
    } else {
        $patient_id = $_POST['patient_id'];
        $patient_name = $_POST['patient_name'];
        $appointment_status = "Pending";
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $queue_no = "";
        $appointment_remark = "";
        $relation = $_POST['relation'];
        $current_time = date('Y-m-d H:i:s');

        $select_query = "SELECT * FROM patient WHERE patient_name = ?";
        $select_stmt = mysqli_prepare($conn, $select_query);

        if (!$select_stmt) {
            die("Failed to prepare statement");
        } else {
            mysqli_stmt_bind_param($select_stmt, 's', $patient_name);
            mysqli_stmt_execute($select_stmt);
            $select_result = mysqli_stmt_get_result($select_stmt);

            if (mysqli_num_rows($select_result) > 0) {
                $row = mysqli_fetch_assoc($select_result);
                $patient_id = $row['patient_id'];

                $insert_query = "INSERT INTO appointment (appointment_status, appointment_date, appointment_time, queue_no, appointment_remarks, booked_by, booked_datetime, patient_id, relation) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $appointment_stmt = mysqli_prepare($conn, $insert_query);

                if (!$appointment_stmt) {
                    die("Failed to prepare statement");
                } else {
                    mysqli_stmt_bind_param($appointment_stmt, 'sssssssss', $appointment_status, $appointment_date, $appointment_time, $queue_no, $appointment_remark, $_SESSION['admin_role'], $current_time, $patient_id, $relation);

                    if (mysqli_stmt_execute($appointment_stmt)) {
                        $_SESSION['message'] = "Appointment successfully added.";
                        header("Location: appointmentDetails.php");
                        exit();
                    } else {
                        $_SESSION['message'] = "Failed to add appointment." . mysqli_stmt_error($appointment_stmt);
                    }

                    mysqli_stmt_close($appointment_stmt);
                }
            } else {
                $_SESSION['message'] = "Patient not found.";
                header("Location: addAppointment.php");
                exit();
            }
        }
    }
} else {
    header("Location: appointmentDetails.php");
    exit();
}
