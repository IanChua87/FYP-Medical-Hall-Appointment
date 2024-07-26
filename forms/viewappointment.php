<?php
ob_start();
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

        // Check if appointment ID exists in the relation table and retrieve the relation_name
        $relation_query = "SELECT relation_name FROM relation WHERE appointment_id = ?";
        $relation_stmt = $conn->prepare($relation_query);

        if (!$relation_stmt) {
            die("Failed to prepare statement: " . $conn->error);
        }

        // Bind the parameters
        $relation_stmt->bind_param("i", $appointment_id);

        // Execute the statement
        $relation_stmt->execute();
        $relation_stmt->bind_result($relation_name);
        $relation_stmt->fetch();
        $relation_stmt->close();

        // SQL query to update the appointment status to 'CANCELLED'
        $query = "UPDATE appointment SET appointment_status = 'CANCELLED' WHERE appointment_id = ? AND patient_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            die("Failed to prepare statement: " . $conn->error);
        }

        // Bind the parameters
        $stmt->bind_param("ii", $appointment_id, $patient_id);

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

// Fetch appointments based on the selected status
$status = isset($_GET['status']) ? $_GET['status'] : 'UPCOMING';
$query = "SELECT a.appointment_id, a.appointment_date, TIME_FORMAT(a.appointment_start_time, '%H:%i') AS formatted_start_time, TIME_FORMAT(a.appointment_end_time, '%H:%i') AS formatted_end_time, a.appointment_status, r.relation_name FROM appointment a LEFT JOIN relation r ON a.appointment_id = r.appointment_id WHERE a.patient_id = ? AND a.appointment_status = ? ORDER BY a.appointment_date";
$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Failed to prepare statement: " . $conn->error);
}

$stmt->bind_param("is", $patient_id, $status);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = $row;
}

$stmt->close();
$conn->close();
ob_end_flush();
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
        
        .table-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .table-header-title {
            margin: 0;
        }

        .filter-dropdown {
            margin-left: 870px;
            display: flex;
            align-items: center;
            width: 200px;
        }
        
        .back-btn:hover{
            background-color: #d1ac47;
            color: black;
        }

        #apptDropdown{
            color: #f9f9f9;
        }

        .dropdown-menu{
            background-color: #682924;
        }

        .dropdown-menu a{
            color: #f9f9f9;
        }

        .nav-link{
            color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container mt-5 mb-5">
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
        <div class="container mt-3">
<<<<<<< Updated upstream
        <div class="filter-dropdown">
=======
            <?php if (count($appointments) === 0) { ?>
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <h3>There are no appointments to be displayed.</h3>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                    <?php if (isset($_GET['status'])) { ?>
                        <a href="viewappointment.php" class="btn back-btn" style="width: 100px;">Back</a>
                    <?php } else { ?>
                        <a href="../P_index.php" class="btn back-btn" style="width: 100px; background-color: #CFA61E; color: #f9f9f9 ">Back</a>
                    <?php } ?>
                </div>
            <?php } else { ?>
                <div class="table-header-row">
                    <h2 class="table-header-title">Appointments for <?php echo $patient_name; ?></h2>
                    <div class="filter-dropdown">
>>>>>>> Stashed changes
                        <select class="form-select" id="filterStatus" onchange="filterAppointments()">
                            <option value="UPCOMING" <?php echo (!isset($_GET['status']) || $_GET['status'] == 'UPCOMING') ? 'selected' : ''; ?>>Upcoming</option>
                            <option value="CANCELLED" <?php echo (isset($_GET['status']) && $_GET['status'] == 'CANCELLED') ? 'selected' : ''; ?>>Cancelled</option>
                            <option value="COMPLETED" <?php echo (isset($_GET['status']) && $_GET['status'] == 'COMPLETED') ? 'selected' : ''; ?>>Completed</option>
                        </select>
                    </div>
                    <br>
            <?php if (count($appointments) === 0) { ?>
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <h3>There are no appointments to be displayed.</h3>
                </div>
                <div class="d-flex justify-content-center align-items-center">
                        <a href="../P_index.php" class="btn back-btn" style="width: 100px;">Back</a>
                </div>
            <?php } else { ?>
                <div class="table-header-row">
                    <h2 class="table-header-title">Appointments for <?php echo $patient_name; ?></h2>
                </div>
                <table class="table table-hover table-secondary mt-3">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Start time</th>
                            <th>End time</th>
                            <th>Status</th>
                            <th>Relation</th>
                            <?php if (isset($patient_id)) { ?>
                                <th>Edit</th>
                                <th>Cancel</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <?php foreach ($appointments as $apptData) {
                        $appt_id = $apptData['appointment_id'];
                        $appt_date = $apptData['appointment_date'];
                        $appt_start_time = $apptData['formatted_start_time'];
                        $appt_end_time = $apptData['formatted_end_time'];
                        $appt_status = $apptData['appointment_status'];
                        $relation_name = $apptData['relation_name'] ? $apptData['relation_name'] : 'n.a.';
                    ?>
                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($appt_date)); ?></td>
                            <td><?php echo $appt_start_time; ?></td>
                            <td><?php echo $appt_end_time; ?></td>
                            <td><?php echo $appt_status; ?></td>
                            <td><?php echo htmlspecialchars($relation_name); ?></td>
                            <?php if (isset($patient_id)) { ?>
                                <td>
                                    <form action="editbooking.php" method="post" onsubmit="return handleEdit('<?php echo $appt_date; ?>')">
                                        <input type="hidden" name="appt_id" value="<?php echo $appt_id; ?>">
                                        <input type="hidden" name="appt_date" value="<?php echo $appt_date; ?>">
                                        <input type="hidden" name="appt_start_time" value="<?php echo $appt_start_time; ?>">
                                        <input type="hidden" name="appt_end_time" value="<?php echo $appt_end_time; ?>">
                                        <button type="submit" class="btn btn-edit" name="edit" <?php echo ($appt_status === 'CANCELLED' || $appt_status === 'COMPLETED') ? 'disabled' : ''; ?>>Edit</button>
                                    </form>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-cancel" onclick="updateModalContent('<?php echo $appt_date; ?>', '<?php echo $appt_start_time; ?>', '<?php echo $appt_end_time; ?>', '<?php echo $appt_id; ?>')" <?php echo ($appt_status === 'CANCELLED' || $appt_status === 'COMPLETED') ? 'disabled' : ''; ?>>Cancel</button>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </table>
            <?php } ?>
        </div>
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

        function handleEdit(apptDate) {
            if (isDateInPast(apptDate)) {
                alert('Date is in the past. Cannot edit appointment.');
                return false; // Prevent form submission
            }
            return true;
        }

        function updateModalContent(apptDate, apptStartTime, apptEndTime, apptID) {
            if (isDateInPast(apptDate)) {
                alert('Date is in the past. Cannot cancel appointment.');
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

        function filterAppointments() {
            const status = document.getElementById('filterStatus').value;
            window.location.href = `viewappointment.php?status=${status}`;
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
                        <input type="hidden" id="appt_id" name="appt_id" value="" />
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-cancel" form="cancelForm" name="cancel">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

