<?php
ob_start();
include "db_connect.php"; // Adjust the path based on your setup
session_start();

// Check if doctor_id is set in the session
if (!isset($_SESSION['doctor_id'])) {
    header("Location: forms/login.php");
    exit();
}

// Fetch the doctor's name from the users table
$doctorId = $_SESSION['doctor_id'];
$doctorQuery = "SELECT user_name FROM users WHERE user_id = $doctorId";
$doctorResult = mysqli_query($conn, $doctorQuery);
$doctorRow = mysqli_fetch_assoc($doctorResult);

$doctorName = $doctorRow['user_name'];

// Fetch the settings for appointment durations
$settingsQuery = "SELECT 
    (SELECT settings_value FROM settings WHERE settings_key = 'appointment_duration') AS appointment_duration, 
    (SELECT settings_value FROM settings WHERE settings_key = 'new_appointment_duration') AS new_appointment_duration
";
$settingsResult = mysqli_query($conn, $settingsQuery);
$settingsRow = mysqli_fetch_assoc($settingsResult);
$appointmentDuration = $settingsRow['appointment_duration'];
$newAppointmentDuration = $settingsRow['new_appointment_duration'];

// Fetch appointments with formatted start and end times
$query = "
    SELECT 
        a.appointment_id,
        a.appointment_date, 
        DATE_FORMAT(a.appointment_start_time, '%H:%i') AS appointment_start_time, 
        DATE_FORMAT(a.appointment_end_time, '%H:%i') AS appointment_end_time,
        p.patient_name,
        p.patient_status,
        r.relation_name,
        CONCAT(DATE_FORMAT(a.appointment_start_time, '%H:%i'), ' - ', DATE_FORMAT(a.appointment_end_time, '%H:%i')) AS duration
    FROM 
        appointment a
    JOIN 
        patient p ON a.patient_id = p.patient_id
    LEFT JOIN 
        relation r ON a.appointment_id = r.appointment_id
    ORDER BY 
        a.appointment_date, a.appointment_start_time";
$result = mysqli_query($conn, $query);

$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    $relationInfo = $row['relation_name'] ? ' (Relation: ' . $row['relation_name'] . ')' : '';
    $appointments[] = [
        'id' => $row['appointment_id'],
        'start' => $row['appointment_date'] . 'T' . $row['appointment_start_time'],
        'end' => $row['appointment_date'] . 'T' . $row['appointment_end_time'],
        'title' => $row['patient_name'] . ' (' . $row['patient_status'] . ')' . $relationInfo,
        'duration' => $row['duration'],
        'doctor_name' => $doctorName,
        'status' => 'pending' // default status
    ];
}

// Convert PHP array to JavaScript
$appointments_json = json_encode($appointments);
ob_end_flush();
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Doctor Dashboard | Appointments Calendar</title>
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #calendar {
            max-width: 900px;
            margin: 50px auto;
        }

        .fc-time-grid .fc-slats td {
            height: 3em;
        }

        .fc-widget-content .fc-time-grid .fc-content-col {
            height: auto;
        }

        .modal-dialog {
            max-width: 600px;
        }

        .error {
            color: red;
            display: none;
        }
    </style>
</head>

<body>
<?php
echo '<nav class="navbar navbar-expand-lg"><div class="container">';
if (!isset($_SESSION["doctor_id"])) {
    echo '<a class="navbar-brand" href="../index.php"><img src="../svg/Sin_Nam_Med_Hall_Logo.svg" alt="Logo" class="navbar-logo"></a>';
} else {
    echo '<a class="navbar-brand" href="../d_index.php"><img src="../svg/Sin_Nam_Med_Hall_Logo.svg" alt="Logo" class="navbar-logo"></a>';
}
?>
<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <i class="bi bi-list"></i>
</button>

<div class="collapse navbar-collapse" id="navbarMenu">
    <ul class="navbar-nav ms-auto">
        <?php if (!isset($_SESSION["doctor_id"])) { ?>
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="../d_index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
            <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <?php } ?>
    </ul>
    <?php
    if (isset($_SESSION['doctor_id'])) {
        echo '<div class="nav-item"><a class="nav-link active" aria-current="page" href="../d_index.php">Home</a></div>
              <div class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-person-circle"></i></a>
                  <ul class="dropdown-menu" aria-labelledby="userDropdown">
                      <li><a class="dropdown-item" href="forms/editDoctorProfile.php">Edit Profile</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="forms/Doctorchangepassword.php">Change Password</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="forms/DoctorloggedOutSuccessful.php">Logout</a></li>
                  </ul>
              </div>';
    } else {
        echo '<ul class="nav navbar-nav"><a class="btn sign-up-btn" href="register.php" role="button">Sign Up</a><a class="btn login-btn" href="login.php" role="button">Login</a></ul>';
    }
    echo '</div></div></nav>';
    ?>

    <div id="calendar"></div>

    <!-- Modal Structure -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="appointmentForm">
                    <div class="form-group">
                        <label for="doctorName">Doctor Name</label>
                        <input type="text" class="form-control" id="doctorName" readonly>
                    </div>
                    <div class="form-group">
                        <label for="duration">Start & End Time</label>
                        <input type="text" class="form-control" id="duration" readonly>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" rows="3"></textarea>
                        <div class="error" id="errorRemarks">Please fill in the remarks</div>
                        <div class="error" id="errorRemarksText">Only text allowed to be inputted</div>
                    </div>
                    <button type="button" id="submitAppointment" class="btn btn-primary">Submit</button>
                    <button type="button" id="editAppointment" class="btn btn-secondary" style="display:none;">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        var appointments = <?php echo $appointments_json; ?>;
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            events: appointments,
            timeFormat: 'h:mm A',
            eventRender: function(event, element) {
                element.css('background-color', '#682924'); // Set the color of the appointment slot
                if (event.status === 'COMPLETED') {
                    element.css('background-color', 'grey');
                }
            },
            eventClick: function (event) {
                $('#doctorName').val(event.doctor_name);
                $('#duration').val(event.duration); // Populate duration
                $('#remarks').val(event.description || ''); // Populate current remarks
                $('#appointmentModal').modal('show');

                if (event.status === 'COMPLETED') {
                    $('#submitAppointment').hide();
                    $('#editAppointment').show();
                } else {
                    $('#submitAppointment').show();
                    $('#editAppointment').hide();
                }

                $('#submitAppointment').off('click').on('click', function () {
                    var remarks = $('#remarks').val().trim();
                    var isNumber = /^\d+$/.test(remarks);

                    // Reset error messages
                    $('.error').hide();

                    if (!remarks) {
                        $('#errorRemarks').show();
                        return;
                    }

                    if (isNumber) {
                        $('#errorRemarksText').show();
                        return;
                    }

                    // AJAX call to save remarks to the database
                    $.ajax({
                        url: 'forms/update_appointment.php',
                        type: 'POST',
                        data: {
                            appointment_id: event.id, // Assuming you have appointment ID
                            remarks: remarks,
                            status: 'COMPLETED' // Mark the status as COMPLETED
                        },
                        success: function(response) {
                            // Update the event in the calendar
                            event.title = 'Completed by ' + event.doctor_name;
                            event.description = remarks;
                            event.status = 'COMPLETED'; // Update the status in the event object
                            event.color = 'grey'; // Grey out the completed event
                            $('#calendar').fullCalendar('updateEvent', event);

                            $('#appointmentModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });

                $('#editAppointment').off('click').on('click', function () {
                    var remarks = $('#remarks').val().trim();
                    var isNumber = /^\d+$/.test(remarks);

                    // Reset error messages
                    $('.error').hide();

                    if (!remarks) {
                        $('#errorRemarks').show();
                        return;
                    }

                    if (isNumber) {
                        $('#errorRemarksText').show();
                        return;
                    }

                    // AJAX call to save edited remarks to the database
                    $.ajax({
                        url: 'forms/update_appointment.php',
                        type: 'POST',
                        data: {
                            appointment_id: event.id, // Assuming you have appointment ID
                            remarks: remarks,
                            status: 'COMPLETED' // Maintain the status as COMPLETED
                        },
                        success: function(response) {
                            // Update the event in the calendar
                            event.description = remarks;
                            $('#calendar').fullCalendar('updateEvent', event);

                            $('#appointmentModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });
            }
        });
    });
</script>
</body>

</html>




