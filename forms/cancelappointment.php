<?php
include "../db_connect.php";
session_start();

$error = "";

// Define the patient_id variable
$patient_id = $_SESSION['patient_id'];

if (!isset($patient_id)) {
    header("Location: login.php");
    exit();
}




if (isset($_POST['cancel'])) {
    if (isset($_POST['apptdate']) && isset($_POST['apptstarttime']) && isset($_POST['apptendtime']) && isset($_POST['appt_id'])) {
        $date = $_POST['apptdate'];
        $start_time = $_POST['apptstarttime'];
        $end_time = $_POST['apptendtime'];
        $appointment_id = $_POST['appt_id'];

          // Check if the selected date is in the past
          $today = date('Y-m-d');
          if ($date < $today) {
              $_SESSION['error'] = "The date is already in the past.";
              header("Location: viewappointment.php");
              exit();
          }

        // SQL query to update the appointment status to 'CANCELLED'
        $query = "UPDATE appointment SET appointment_status = 'CANCELLED' WHERE appointment_date = ? AND appointment_start_time = ? AND appointment_end_time = ? AND patient_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Failed to prepare statement: " . $conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("sssi", $date, $start_time, $end_time, $patient_id);

          // Execute statement
          if ($stmt->execute()) {
            // Redirect with success message
            header("Location: viewappointment.php?success=true");
            exit();
        } else {
            // Redirect with error message
            $error = "Cancellation failed: " . $stmt->error;
            header("Location: viewappointment.php?error=" . urlencode($error));
            exit();
        }

        $stmt->close();
    }
}

// Fetch patient name
$query = "SELECT patient_name FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$stmt->bind_result($patient_name);
$stmt->fetch();
$stmt->close();

// Fetch appointments
$query = "SELECT appointment_date, TIME_FORMAT(appointment_start_time, '%H:%i') AS formatted_start_time, TIME_FORMAT(appointment_end_time, '%H:%i') AS formatted_end_time, appointment_status FROM appointment WHERE patient_id = ? ORDER BY appointment_date";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Appointment Booking</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1AnmE4cbIsrMkeFN5DrGU6QT4M9O1QnNgl49NxqR1pi58A4NE+N" crossorigin="anonymous">
    <style>
        .btn-edit {
            background-color: #CFA61E;
            color: #fff;
        }

        .btn-cancel {
            background-color: #682924;
            color: #fff;
        }

    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-5">
        <div class="container mt-3">
            <table class="table table-hover table-secondary">
                <thead class="table-primary">
                    <tr>
                        <th>Appointment date</th>
                        <th>Appointment start time</th>
                        <th>Appointment end time</th>
                        <th>Appointment status</th>
                        <?php if (isset($patient_id)) { ?>
                        <th>Edit</th>
                        <th>Cancel</th>
                        <?php } ?>
                    </tr>
                </thead>
                <div class="center-align">
                    <h2>Appointments for <?php echo $patient_name; ?></h2>
                    <br><br>
                </div>
                <?php foreach ($appointments as $apptData) {
                    $appt_date = $apptData['appointment_date'];
                    $appt_start_time = $apptData['formatted_start_time'];
                    $appt_end_time = $apptData['formatted_end_time'];
                    $appt_status = $apptData['appointment_status'];
                ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($appt_date)); ?></td>
                        <td><?php echo $appt_start_time; ?></td>
                        <td><?php echo $appt_end_time; ?></td>
                        <td><?php echo $appt_status; ?></td>
                        <?php if (isset($patient_id)) { ?>
                            <td>
                <button type="submit" class="btn btn-edit" name="edit" <?php echo ($appt_status === 'CANCELLED') ? 'disabled' : ''; ?>>Edit</button>
            </td>
            <td>
                <button type="button" class="btn btn-cancel" onclick="updateModalContent('<?php echo $appt_date; ?>', '<?php echo $appt_start_time; ?>', '<?php echo $appt_end_time; ?>')" data-bs-toggle="modal" data-bs-target="#cancelapptmodal" <?php echo ($appt_status === 'CANCELLED') ? 'disabled' : ''; ?>>Cancel</button>
            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>
            <br>
        </div>
    </div>

    <script>
        function updateModalContent(apptDate, apptStartTime, apptEndTime) {
            // Update the modal content with the appropriate appointment date, start time, and end time
            document.getElementById("cancelstatement").innerHTML = "Are you sure you want to cancel the appointment for <strong>" + apptDate + "</strong> from <strong>" + apptStartTime + "</strong> to <strong>" + apptEndTime + "</strong>?";
            // Update hidden form fields with the appointment details
            document.getElementById("apptdate").value = apptDate;
            document.getElementById("apptstarttime").value = apptStartTime;
            document.getElementById("apptendtime").value = apptEndTime;
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="cancelapptmodal" tabindex="-1" aria-labelledby="cancelapptLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Appointment cancellation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelForm" action="viewappointment.php" method="post">
                        <label id="cancelstatement">Are you sure you want to cancel this appointment?</label>
                        <input type="hidden" id="apptdate" name="apptdate" value="" />
                        <input type="hidden" id="apptstarttime" name="apptstarttime" value="" />
                        <input type="hidden" id="apptendtime" name="apptendtime" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-cancel" form="cancelForm" name="cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
