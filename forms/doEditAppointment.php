<?php
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
    $appointment_date = $_POST['appointment_date'];
    $appointment_start_time =  $_POST['appointment_start_time'];
    $appointment_end_time = date('H:i:s', strtotime($appointment_start_time) + 1800);
    $appointment_status = $_POST['appointment_status'];
    $booked_datetime = date('Y-m-d H:i:s');
    $queue_no = $_POST['queue_no'];

    if(check_appointment_exists_by_id($conn, $appointment_id) !== false ){

        if(check_patient_exists_by_id($conn, $patient_id) !== false){

            if(update_appointment_details($conn, $appointment_date, $appointment_start_time, $appointment_end_time, $appointment_status, $booked_datetime, $queue_no, $appointment_id) !== false){
                $_SESSION['message'] = "Appointment successfully updated.";
                header("Location: appointmentDetails.php");
                exit();
            } else {
                $_SESSION['error'] = "Failed to update appointment.";
                header("Location: editAppointment.php?appointment_id=" . $appointment_id);
                exit();
            }

        } else{
            $_SESSION['error'] = "Appointment not found.";
            header("Location: editAppointment.php?appointment_id=" . $appointment_id);
            exit();
        }

    } else{
        $_SESSION['error'] = "Appointment not found.";
        header("Location: appointmentDetails.php");
        exit();
    }
} else {
    header("Location: appointmentDetails.php");
    exit();
}

