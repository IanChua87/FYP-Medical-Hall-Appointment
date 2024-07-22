<?php
ob_start();
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
    $patient_email = $_POST['email'];
    $appointment_status = "UPCOMING";
    $appointment_date = $_POST['appointment_date'];
    $appointment_start_time = $_POST['appointment_time'];
    // $appointment_start_time = DateTime::createFromFormat('h:i A', $_POST['appointment_time']);
    $appointment_end_time = date('H:i:s', strtotime($appointment_start_time) + 900);
    // $appointment_end_time = $appointment_start_time->add(new DateInterval('PT30M'))->format('H:i A');
    $queue_no = $_POST['queue'];
    $appointment_remark = "";
    $relation = $_POST['relation'];
    $current_time = date('Y-m-d H:i:s');
    // $cur_time = new DateTime();
    // $current_time = $cur_time->format('Y-m-d H:i:s');
    

    if (check_empty_appointment_input_fields($patient_email, $appointment_date, $appointment_start_time)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: addAppointment.php");
        exit();
    }

    if (invalid_email($patient_email) !== false) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: addAppointment.php");
        exit();
    }
    
    if (check_patient_exists_by_email($conn, $patient_email) !== false) {
        $patient_data = check_patient_exists_by_email($conn, $patient_email);
        $patient_id = $patient_data['patient_id'];

        if (insert_appointment_details($conn, $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_status, $_SESSION['admin_role'], $current_time, $patient_id, $queue_no, $appointment_remark) !== false) {

            $appointment_id = mysqli_insert_id($conn);
            if (insert_relation_details($conn, $relation, $appointment_id) !== false) {
                $_SESSION['message'] = "Appointment successfully added.";
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
        header("Location: addPatient.php");
        exit();
    }

} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: addAppointment.php");
    exit();
}

ob_end_flush();
