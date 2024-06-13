<?php
include "../db_connect.php";
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$patient_id = $_SESSION['patient_id']; // Assuming patient_id is stored in the session

// Query the database to retrieve the patient's name
$query = "SELECT patient_name FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$stmt->bind_result($patient_name);
$stmt->fetch();
$stmt->close();

// Your SQL query with a placeholder for the patient_id
$query = "SELECT appointment_date, TIME_FORMAT(appointment_start_time, '%H:%i') AS formatted_start_time, TIME_FORMAT(appointment_end_time, '%H:%i') AS formatted_end_time, appointment_status FROM appointment WHERE patient_id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Check if the statement was prepared successfully
if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

// Bind the parameter
$stmt->bind_param("i", $patient_id);

// Execute the prepared statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Initialize an empty array to store the results
$appointments = [];

// Fetch rows from the result set and store them in the array
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

// Close the statement
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

        .btn-back {
            background-color: #948b8b;
            color: #fff;
        }
    </style>
</head>

<body>

    <?php include '../navbar.php'; ?>

    <div class="container mt-5">
    <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            <div class="alert alert-success" role="alert">
                Appointment cancelled successfully!
            </div>
        <?php } ?>
        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php } ?>
        <div class="container mt-3">
            <table class="table table-hover table-secondary">
                <thead class="table-primary">
                    <tr>
                        <th>Appointment date</th>
                        <th>Appointment start time</th>
                        <th>Appointment end time</th>
                        <th>Appointment status</th>
                        <th>Edit</th>
                        <th>Cancel</th>
                    </tr>
                </thead>
                <div class="center-align">
                    <?php
                    $header = "<h2>Appointments for " . $patient_name . "</h2>";
                    echo $header;
                    ?>
                    <br><br>
                </div>
                <?php
                foreach ($appointments as $apptData) {
                    $appt_date = $apptData['appointment_date'];
                    $appt_start_time = $apptData['formatted_start_time'];
                    $appt_end_time = $apptData['formatted_end_time'];
                    $appt_status = $apptData['appointment_status'];
                ?>
                    <tr>
                        <td><?php echo $appt_date; ?></td>
                        <td><?php echo $appt_start_time; ?></td>
                        <td><?php echo $appt_end_time; ?></td>
                        <td><?php echo $appt_status; ?></td>
                        <td><button type="submit" class="btn btn-edit" name="edit">Edit</button></td>
                        <td><button type="button" class="btn btn-cancel" onclick="updateModalContent('<?php echo $appt_date; ?>', '<?php echo $appt_start_time; ?>', '<?php echo $appt_end_time; ?>')" data-bs-toggle="modal" data-bs-target="#cancelapptmodal">Cancel</button></td>
                    </tr>
                <?php } ?>
            </table>
            <br>
        </div>
    </div>

    <script>
        function updateModalContent(apptDate, apptStartTime, apptEndTime) {
            document.getElementById("cancelstatement").innerHTML = "Are you sure you want to cancel the appointment for <strong>" + apptDate + "</strong> from <strong>" + apptStartTime + "</strong> <strong> - </strong> <strong>" + apptEndTime + "</strong>?";
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
                    <form id="cancelForm" action="cancelappointment.php" method="post">
                        <label id="cancelstatement">Are you sure you want to cancel this appointment?</label>
                        <input type="hidden" id="apptdate" name="apptdate" value="" />
                        <input type="hidden" id="apptstarttime" name="apptstarttime" value="" />
                        <input type="hidden" id="apptendtime" name="apptendtime" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-cancel" form="cancelForm" name="cancel">Cancel</button>
                    <button type="button" class="btn btn-back" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
