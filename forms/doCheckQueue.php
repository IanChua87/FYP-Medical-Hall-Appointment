<?php
session_start();
include "../db_connect.php";
include "../helper_functions.php";


if(!isset($_SESSION['admin_id'])){
    header("Location: login.php");
    exit();
}
?>

<?php
if(isset($_POST['submit'])){
    $queue_no = $_POST['queueNumber'];

    if(check_empty_queue_input_field($queue_no)){
        $_SESSION['error'] = "Queue number cannot be empty";
        header("Location: checkQueue.php");
        exit();
    }

    if(invalid_number($queue_no) !== false){
        $_SESSION['error'] = "Queue number must be a number";
        header("Location: checkQueue.php");
        exit();
    }

    if(check_appointment_exists_by_queue_no($conn, $queue_no) === false){
        $_SESSION['error'] = "Queue number does not exist";
        header("Location: checkQueue.php");
        exit();
    } 
    else{
        $_SESSION['message'] = "Queue number exists";
        header("Location: queueDetails.php?queue_no=$queue_no");
        exit();
    }
}
?>