<?php
include "../db_connect.php";
session_start();

if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php");
    exit();
}

$error = "";
$patient_id = $_SESSION['patient_id'];

// Query the database to retrieve the patient's name
$query = "SELECT patient_name FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$stmt->bind_result($patient_name);
$stmt->fetch();
$stmt->close();

// Query the database to retrieve the patient's appointments
$query = "SELECT appointment_id, appointment_date, TIME_FORMAT(appointment_start_time, '%H:%i') AS formatted_start_time, TIME_FORMAT(appointment_end_time, '%H:%i') AS formatted_end_time, appointment_status FROM appointment WHERE patient_id = ? ORDER BY appointment_date";
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

// Check for error message in session
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear the error message from session
}
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
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            <div class="alert alert-success" role="alert">
                Appointment cancelled successfully!
            </div>
        <?php } ?>
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>
    </div>
    <div class="container mt-3">
        <table class="table table-hover table-secondary">
            <thead class="table-primary">
                <tr>
                    <th>Date</th>
                    <th>Start time</th>
                    <th>End time</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <div class="center-align">
                <h2>My Appointments</h2>
                <br><br>
            </div>
            <?php foreach ($appointments as $apptData) {
                $appt_id = $apptData['appointment_id'];
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
                    <td>
                        <form action="editbooking.php" method="post">
                            <input type="hidden" name="appt_id" value="<?php echo $appt_id; ?>">
                            <input type="hidden" name="appt_date" value="<?php echo $appt_date; ?>">
                            <input type="hidden" name="appt_start_time" value="<?php echo $appt_start_time; ?>">
                            <input type="hidden" name="appt_end_time" value="<?php echo $appt_end_time; ?>">
                            <button type="submit" class="btn btn-edit" name="edit" <?php echo ($appt_status === 'CANCELLED') ? 'disabled' : ''; ?>>Edit</button>
                        </form>
                    </td>
                    <td>
                        <button type="button" class="btn btn-cancel" onclick="updateModalContent('<?php echo $appt_date; ?>', '<?php echo $appt_start_time; ?>', '<?php echo $appt_end_time; ?>', '<?php echo $appt_id; ?>')" <?php echo ($appt_status === 'CANCELLED') ? 'disabled' : ''; ?>>Cancel</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
    </div>

    <script>
        function formatDate(dateString) {
            let date = new Date(dateString);
            let day = String(date.getDate()).padStart(2, '0');
            let month = String(date.getMonth() + 1).padStart(2, '0');
            let year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        function isDateInPast(dateString) {
            let selectedDate = new Date(dateString);
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Set time to 00:00:00 for accurate date comparison
            return selectedDate < today;
        }

        function updateModalContent(apptDate, apptStartTime, apptEndTime, apptID) {
            if (isDateInPast(apptDate)) {
                alert('The selected date is in the past.');
                return; // Exit the function if the date is in the past
            }

            let formattedDate = formatDate(apptDate);
            document.getElementById("cancelstatement").innerHTML = "Are you sure you want to cancel the appointment for <strong>" + formattedDate + "</strong> from <strong>" + apptStartTime + "</strong> to <strong>" + apptEndTime + "</strong>?";
            document.getElementById("apptdate").value = apptDate;
            document.getElementById("apptstarttime").value = apptStartTime;
            document.getElementById("apptendtime").value = apptEndTime;
            document.getElementById("appt_id").value = apptID;

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('cancelapptmodal'));
            modal.show();
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="cancelapptmodal" tabindex="-1" aria-labelledby="cancelapptLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelapptLabel">Cancel Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="cancelstatement"></p>
                    <form action="cancelappointment.php" method="post">
                        <input type="hidden" id="apptdate" name="apptdate">
                        <input type="hidden" id="apptstarttime" name="apptstarttime">
                        <input type="hidden" id="apptendtime" name="apptendtime">
                        <input type="hidden" id="appt_id" name="appt_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-cancel" form="cancelForm" name="cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlCOv7bF4W3u6eLk3n5veCOFfHw3b1j6Nf/Jr66Q8GXCIJTdMg0t4D9dPbb" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhG+c02p3cJ0MSF4aR2sA4pRHFRpv8IR1JgDQ5si/P72M1l1VVN/t3pgiPYi" crossorigin="anonymous"></script>
</body>

</html>
