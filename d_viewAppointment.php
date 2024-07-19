<?php
include "db_connect.php"; // Adjust the path based on your setup]
session_start();

// Check if patient_id is set in the session
if (!isset($_SESSION['doctor_id'])) {
    header("Location: forms/login.php");
    exit();
}

// Fetch the doctor's name from the users table
$doctorQuery = "SELECT user_name FROM users WHERE role = 'Doctor' LIMIT 1";
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

// Fetch appointments with patient name, status, and determine the duration based on patient status or relation
$query = "
    SELECT 
        a.appointment_id,
        a.appointment_date, 
        a.appointment_start_time, 
        a.appointment_end_time,
        p.patient_name,
        p.patient_status,
        r.relation_name,
        CASE 
            WHEN p.patient_status = 'new' OR r.relation_name IS NOT NULL THEN '30'
            ELSE '$appointmentDuration'
        END as duration
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
            background-color: #CFA61E; /* Calendar background color */
            color: white; /* Calendar text color */
        }

        .fc-event, .fc-event:hover {
            background-color: #682924 !important; /* Appointment slot color */
            border-color: #000000 !important; /* Appointment slot border color */
            color: white !important; /* Appointment slot text color */
        }

        .fc-time-grid .fc-slats td,
        .fc-widget-content,
        .fc-widget-content .fc-time-grid .fc-content-col {
            background-color: #CFA61E !important; /* Slot background color */
            border-color: #000000 !important; /* Slot border color */
            color: white !important; /* Slot text color */
        }

        .fc-widget-header {
            background-color: #CFA61E !important; /* Header background color */
            border-color: #000000 !important; /* Header border color */
            color: white !important; /* Header text color */
        }

        .fc-day-header {
            background-color: #CFA61E !important; /* Day header background color */
            border-color: #000000 !important; /* Day header border color */
            color: white !important; /* Day header text color */
        }

        .modal-dialog {
            max-width: 600px;
        }

        .editButton {
            margin-top: 5px;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>
    <div id="calendar"></div>

    <!-- Modal Structure -->
    <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                            <label for="duration">Duration (minutes)</label>
                            <input type="number" class="form-control" id="duration" required>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control" id="remarks" rows="3"></textarea>
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
                    if (event.status === 'COMPLETED') {
                        element.css('background-color', 'grey');
                        element.append('<button type="button" class="btn btn-secondary btn-sm editButton">Edit</button>');
                    }
                },
                eventClick: function (event) {
                    $('#doctorName').val(event.doctor_name);
                    $('#duration').val(event.duration);
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
                        var duration = $('#duration').val();
                        var remarks = $('#remarks').val();

                        if (duration) {
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
                        }
                    });

                    $('#editAppointment').off('click').on('click', function () {
                        var duration = $('#duration').val();
                        var remarks = $('#remarks').val();

                        if (duration) {
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
                        }
                    });
                }
            });

            // Handle edit button click
            $(document).on('click', '.editButton', function(e) {
                e.stopPropagation(); // Prevent the eventClick handler from being called
                var eventId = $(this).closest('.fc-event').data('id'); // Assuming data-id contains the event ID
                var event = $('#calendar').fullCalendar('clientEvents', eventId)[0];
                $('#doctorName').val(event.doctor_name);
                $('#duration').val(event.duration);
                $('#remarks').val(event.description || ''); // Populate current remarks
                $('#appointmentModal').modal('show');

                $('#submitAppointment').hide();
                $('#editAppointment').show();
            });
        });
    </script>
</body>

</html>