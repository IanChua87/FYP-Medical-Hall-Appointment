<?php
ob_start();
include "../db_connect.php"; // Adjust the path based on your setup

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $remarks = $_POST['remarks'];
    $status = $_POST['status'];

    // Update the appointment with the remarks and status
    $updateQuery = "UPDATE appointment SET appointment_remarks = ?, appointment_status = ? WHERE appointment_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssi", $remarks, $status, $appointment_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
ob_end_flush();


