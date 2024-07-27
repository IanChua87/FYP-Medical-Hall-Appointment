<?php
ob_start();
session_start();
include "../db_connect.php";
include "../helper_functions.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit'])){
    $appointment_id = $_POST['appointment_id'];
    $patient_id = $_POST['patient_id'];
    $appointment_date = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['appointment_date'])));
    $appointment_start_time =  date('H:i:s', strtotime($_POST['appointment_start_time']));
    $appointment_end_time = date('H:i:s', strtotime($appointment_start_time) + 900);
    $appointment_status = $_POST['appointment_status'];
    $booked_datetime = date('Y-m-d H:i:s');
    $relation = $_POST['relation'];

    $query = "";
    if(check_appointment_exists_by_id($conn, $appointment_id) !== false){

        if(check_patient_exists_by_id($conn, $patient_id) !== false){
            
            if(update_appointment_details($conn, $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_status, $booked_datetime, $appointment_id) !== false 
            && update_relation_details($conn, $relation, $appointment_id) !== false){
                $_SESSION['message'] = "Appointment successfully updated.";
                header("Location: appointmentDetails.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to update appointment.";
                header("Location: editAppointment.php?appointment_id=" . $appointment_id);
                exit();
            }



        } else{
            $_SESSION['error'] = "Patient not found.";
            header("Location: addPatient.php");
            exit();
        }

    } else{
        $_SESSION['error'] = "Appointment not found.";
        header("Location: addPatient.php");
        exit();
    }

} else {
    $_SESSION['message'] = "Invalid request.";
    header("Location: appointmentDetails.php");
    exit();
}
ob_end_flush();

