<?php
ob_start();
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $appt_id = $_POST['appt_id'];
    $appt_date = $_POST['appt_date'];
    $appt_start_time = $_POST['appt_start_time'];
    $appt_end_time = $_POST['appt_end_time'];
}

 // Check if the selected date is in the past
 $today = date('Y-m-d');
 if ($appt_date < $today) {
     $_SESSION['error'] = "The date is already in the past.";
     header("Location: viewappointment.php");
     exit();
 }
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
        .booking {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .form-container-booking {
            width: 100%;
            max-width: 400px;
        }
        .radio-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        label {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
            /* margin-top: 50px; */
        }
        h3 {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }
        .slots-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 2fr)); /* Adjust the width as needed */
            gap: 20px;
            margin-top: 20px;
            margin-left: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }
        .slot-button {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box;
            height: 60px;
        }
        .available-slot {
            background-color: #fff;
        }
        .booked-slot {
            background-color: lightgray;
            cursor: not-allowed;
        }
        .booked-slot-highlight {
            background-color: #CFA61E; 
            color: black;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            text-align: center;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .btn-book {
            background-color: #CFA61E;
            color: #fff;
        }
        .close:hover,
        .close:focus {
            color: gray;
            text-decoration: none;
            cursor: pointer;
        }
        .hidden {
            display: none;
        }
        .date-btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 50px;
        }
        .message {
            text-align: center;
            margin-top: 20px;
            color: red;
        }
    </style>
</head>

<body>

<?php include '../navbar.php'; ?>
<div class="container mt-5 mb-5"></div>

<div class="message" id="message"></div>

<a href="viewappointment.php">
<i class="bi bi-arrow-left-square-fill" style="font-size:40px;margin-left:50px;color:primary;"></i>
</a>

<div class="date-btn-container">
    <h2>Book an Appointment</h2>
    <input type="date" id="selectedDate" name="selectedDate" style="width: 180px; height: 30px" min="<?php echo date('Y-m-d'); ?>" value="<?php echo isset($appt_date) ? $appt_date : ''; ?>">
</div>

<div id="slotContainer" class="slots-container"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLX5HbYpZ8eylGk8PI6z7dSPyJS+pMS7l+cmDA6j6CmP1U8xjm0JEv1YtQT6V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGgmTZ3lVarvT+LkB3r7SNF6phb5g2Ai3sbgJRMv2d/twvc1pdxDOXP8u3g" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    // Variables to store the previously booked time slot
    var bookedStartTime = "<?php echo isset($appt_start_time) ? $appt_start_time : ''; ?>";
    var bookedEndTime = "<?php echo isset($appt_end_time) ? $appt_end_time : ''; ?>";

    // Function to parse time string in HH:MM format to minutes
    function parseTime(timeStr) {
        var parts = timeStr.split(':');
        return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
    }

    // Function to check if a slot falls within the booked time range
    function isSlotWithinBookedTime(slotStart, slotEnd, bookedStart, bookedEnd) {
        var slotStartMinutes = parseTime(slotStart);
        var slotEndMinutes = parseTime(slotEnd);
        var bookedStartMinutes = parseTime(bookedStart);
        var bookedEndMinutes = parseTime(bookedEnd);

        return (slotStartMinutes >= bookedStartMinutes && slotEndMinutes <= bookedEndMinutes);
    }

    // Function to load slots based on selected date
    function loadSlots() {
        var selectedDate = new Date($('#selectedDate').val());
        var today = new Date();
        today.setHours(0, 0, 0, 0); // Set time to 00:00:00 for accurate comparison

        // Check if the selected date is in the past
        if (selectedDate < today) {
            $('#message').text('Please select a valid date.');
            $('#slotContainer').empty(); // Clear the slot container
            return; // Exit the function
        }

        $('#slotContainer').html('<p>Loading...</p>');
        $('#message').text('');

        $.ajax({
            url: 'getAvailableSlots.php',
            method: 'POST',
            data: { selectedDate: $('#selectedDate').val() },
            dataType: 'json',
            success: function(response) {
                var slotContainer = $('#slotContainer');
                slotContainer.empty();

                if (response.length > 0) {
                    $.each(response, function(index, slot) {
                        var button = $('<button></button>')
                            .text(slot.start + ' - ' + slot.end)
                            .addClass('slot-button')
                            .prop('disabled', slot.booked);
                        if(slot.booked) {
                            button.addClass('booked-slot');
                            if(isSlotWithinBookedTime(slot.start, slot.end, bookedStartTime, bookedEndTime) && selectedDate.toISOString().split('T')[0] == "<?php echo $appt_date; ?>"){
                                button.addClass('booked-slot-highlight'); // Add highlight class for booked slot
                            }
                        }
                        else {
                            button.addClass('available-slot');
                        }
                            

                        if (!slot.booked) {
                            // if (isSlotWithinBookedTime(slot.start, slot.end, bookedStartTime, bookedEndTime)) {
                            //     button.addClass('booked-slot-highlight'); // Add highlight class for booked slot
                            // }
                            button.on('click', function() {
                                // Fill the modal with the slot information
                                $('#timeslot').val(slot.start + ' - ' + slot.end);
                                $('#modalApptDate').val(selectedDate.toISOString().split('T')[0]);

                                // Show the modal
                                var bookingModal = new bootstrap.Modal(document.getElementById('updbookingmodal'));
                                bookingModal.show();
                            });
                        } 

                        slotContainer.append(button);
                    });
                } else {
                    $('#message').text('Sin Nam Medical Hall is not open on this day');
                }
            },
            error: function(xhr, status, error) {
                $('#slotContainer').html('<p>Error fetching slots. Please try again later.</p>');
                console.error('Error fetching slots:', error);
            }
        });
    }

    // Load slots when the date is changed
    $('#selectedDate').on('change', loadSlots);

    // Initial load of slots for the default date
    if ($('#selectedDate').val()) {
        loadSlots();
    }
});

</script>

<!-- The Modal -->
<div class="modal fade" id="updbookingmodal" tabindex="-1" aria-labelledby="bookingmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Booking</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="updbookingForm" action="updbookingSuccessful.php" method="post">
                    <label for="timeslot">Time slot:</label>
                    <input required type="text" readonly class="form-control form-control-lg" name="timeslot" id="timeslot" />
                    <br>
                    <label for="date">Date:</label>
                    <input type="date" class="form-control form-control-lg" id="modalApptDate" name="apptdate" readonly>
                    <input type="hidden" name="appt_id" value="<?php echo $appt_id; ?>">
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-book" form="updbookingForm" name="book">Update</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
            </div>

        </div>
    </div>
</div>

</body>
</html>
