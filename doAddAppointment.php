<?php
session_start();
include "db_connect.php";
include "helper_functions.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $patient_email = $_POST['email'];
    $appointment_status = "Upcoming";
    $appointment_date = $_POST['appointment_date'];
    $appointment_start_time = $_POST['appointment_time'];
    $appointment_end_time = date('H:i:s', strtotime($appointment_start_time) + 1800);
    $queue_no = $_POST['queue'];
    $appointment_remark = "";
    $relation = $_POST['relation'];
    $current_time = date('Y-m-d H:i:s');

    if (check_empty_appointment_input_fields($patient_email, $appointment_date, $appointment_start_time)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: addAppointment.php");
        exit();
    } else {
        if (check_patient_exists_by_email($conn, $patient_email) !== false) {
            $patient_data = check_patient_exists_by_email($conn, $patient_email);
            $patient_id = $patient_data['patient_id'];

            if (insert_appointment_details($conn, $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_status, $_SESSION['admin_role'], $current_time, $patient_id, $queue_no, $appointment_remark) !== false) {

                $appointment_id = mysqli_insert_id($conn);
                if (insert_relation_details($conn, $relation, $appointment_id) !== false) {
                    $_SESSION['error'] = "Appointment successfully added.";
                    header("Location: appointmentDetails.php");
                    exit();
                }
            } else {
                $_SESSION['error'] = "Failed to add appointment.";
                header("Location: addAppointment.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Patient with this email doesn't exist. Please register first.";
            header("Location: forms/register.php");
            exit();
        }
        // $select_query = "SELECT * FROM patient WHERE patient_name = ?";
        // $select_stmt = mysqli_prepare($conn, $select_query);

        // if (!$select_stmt) {
        //     die("Failed to prepare statement");
        // } else {
        //     mysqli_stmt_bind_param($select_stmt, 's', $patient_name);
        //     mysqli_stmt_execute($select_stmt);
        //     $select_result = mysqli_stmt_get_result($select_stmt);

        //     if (mysqli_num_rows($select_result) > 0) {
        //         $row = mysqli_fetch_assoc($select_result);
        //         $patient_id = $row['patient_id'];

        //         $insert_query = "INSERT INTO appointment (appointment_date, appointment_start_time, appointment_end_time, appointment_status, booked_by, booked_datetime, patient_id, queue_no, appointment_remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //         $appointment_stmt = mysqli_prepare($conn, $insert_query);

        //         if (!$appointment_stmt) {
        //             die("Failed to prepare statement");
        //         } else {
        //             mysqli_stmt_bind_param($appointment_stmt, 'ssssssiis', $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_status, $_SESSION['admin_role'], $current_time, $patient_id, $queue_no, $appointment_remark);

        //             if (mysqli_stmt_execute($appointment_stmt)) {
        //                 $_SESSION['error'] = "Appointment successfully added.";
        //                 header("Location: appointmentDetails.php");
        //                 exit();
        //             } else {
        //                 $_SESSION['error'] = "Failed to add appointment." . mysqli_stmt_error($appointment_stmt);
        //             }

        //             mysqli_stmt_close($appointment_stmt);
        //         }
        //     } else {
        //         $_SESSION['error'] = "Patient not found.";
        //         header("Location: addAppointment.php");
        //         exit();
        //     }
        // }
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: addAppointment.php");
    exit();
}
