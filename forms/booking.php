<?php
session_start();
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
        }
        .radio-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        .hidden {
            display: none;
        }
    </style>
</head>

<body>

<?php include '../navbar.php'; ?>
<div class="container mt-5">

</div>

<div class="message" id="message"></div>


<div class="date-btn-container">
    <h2>Book an Appointment</h2>
    <div class="radio-buttons">
        <label for="self">
            <input type="radio" id="self" name="options" value="1"> Self
        </label>
        <label for="others">
            <input type="radio" id="others" name="options" value="2"> Others
        </label>
    </div>
    <div class="hidden" id="relationField">
        <input type="text" class="form-control" id="relation" name="relation" placeholder="Relationship" style="margin-bottom: 10px;width: 180px; height: 30px">
    </div>
    <input type="date" id="selectedDate" name="selectedDate" style="width: 180px; height: 30px" min="<?php echo date('Y-m-d'); ?>">
</div>

<div id="slotContainer" class="slots-container"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selfRadio = document.getElementById('self');
        const othersRadio = document.getElementById('others');
        const relationField = document.getElementById('relationField');
        const relationInput = document.getElementById('relation');
        const bookButton = document.querySelector('button[name="book"]');

        // Check the value of the radio button from PHP
        const optionsValue = "<?php echo isset($options) ? htmlspecialchars($options) : ''; ?>";

        if (optionsValue === '2') {
            othersRadio.checked = true;
            relationField.classList.remove('hidden');
            relationInput.required = true;
        } else {
            selfRadio.checked = true;
            relationField.classList.add('hidden');
            relationInput.required = false;
        }

        selfRadio.addEventListener('change', function () {
            relationField.classList.add('hidden');
            relationInput.required = false;
        });

        othersRadio.addEventListener('change', function () {
            relationField.classList.remove('hidden');
            relationInput.required = true;
        });
        // Prevent form submission if relation input is empty when others is selected
        bookButton.addEventListener('click', function (event) {
                if (othersRadio.checked && relationInput.value.trim() === '') {
                    event.preventDefault();
                    alert('Please enter the relation.');
                }
            });
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLX5HbYpZ8eylGk8PI6z7dSPyJS+pMS7l+cmDA6j6CmP1U8xjm0JEv1YtQT6V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGgmTZ3lVarvT+LkB3r7SNF6phb5g2Ai3sbgJRMv2d/twvc1pdxDOXP8u3g" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    $('#selectedDate').on('change', function() {
        var selectedDate = new Date($(this).val());
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
            data: { selectedDate: $(this).val() },
            dataType: 'json',
            success: function(response) {
                var slotContainer = $('#slotContainer');
                slotContainer.empty();

                if (response.length > 0) {
                    $.each(response, function(index, slot) {
                        var slotButton = $('<button></button>')
                            .text(slot.start + ' - ' + slot.end)
                            .addClass('slot-button')
                            .prop('disabled', slot.booked);

                        if (slot.booked) {
                            slotButton.addClass('booked-slot');
                        } else {
                            var currentTime = new Date();

                            if (selectedDate.toDateString() === currentTime.toDateString()) {
                                var slotStartTime = new Date(selectedDate);
                                var slotEndTime = new Date(selectedDate);

                                var startParts = slot.start.split(':');
                                var endParts = slot.end.split(':');

                                slotStartTime.setHours(startParts[0], startParts[1], 0, 0);
                                slotEndTime.setHours(endParts[0], endParts[1], 0, 0);

                                if (slotStartTime <= currentTime) {
                                    slotButton.prop('disabled', true).addClass('booked-slot');
                                }
                            }

                            if (!slotButton.prop('disabled')) {
                                slotButton.addClass('available-slot');
                                slotButton.on('click', function() {
                                    populateModal(slot.start, slot.end);
                                    var bookingModal = new bootstrap.Modal(document.getElementById('bookingmodal'));
                                    bookingModal.show();
                                });
                            }
                        }

                        slotContainer.append(slotButton);
                    });
                } else {
                    var alertDiv = $('<div></div>')
                        .addClass('alert alert-danger')
                        .attr('role', 'alert')
                        .text('Sin Nam Medical Hall is not open on this day');

                    $('#message').html(alertDiv);
                }
            },
            error: function(xhr, status, error) {
                $('#slotContainer').html('<p>Error fetching slots. Please try again later.</p>');
                console.error('Error fetching slots:', error);
            }
        });
    });
});

function populateModal(startTime, endTime) {
    const timeslot = startTime + " - " + endTime;
    document.getElementById('timeslot').value = timeslot; // Populate timeslot field
    document.getElementById('modalApptDate').value = document.getElementById('selectedDate').value; // Populate appointment date

    // Check which radio button is selected and populate modal fields accordingly
    const options = document.querySelector('input[name="options"]:checked');
    if (options && options.value === '2') { // If 'others' is selected
        document.getElementById('modalRelation').value = document.getElementById('relation').value; // Populate relation field
    } else {
        document.getElementById('modalRelation').value = ''; // Clear relation field if 'self' is selected (optional)
    }

    // Ensure modal options field is set to the selected radio button value
    document.getElementById('modalOptions').value = options ? options.value : ''; 
}
</script>


<!-- The Modal -->
<div class="modal fade" id="bookingmodal" tabindex="-1" aria-labelledby="bookingmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Booking confirmation</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="bookingForm" action="bookingSuccessful.php" method="post">
                    <label for="timeslot">Time slot:</label>
                    <input required type="text" readonly class="form-control form-control-lg" name="timeslot" id="timeslot" />
                    <br>
                    <label for="date">Date:</label>
                    <input type="date" class="form-control form-control-lg" id="modalApptDate" name="apptdate" readonly>
                    <input type="hidden" name="relation" id="modalRelation" />
                    <input type="hidden" name="options" id="modalOptions" />
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-book" form="bookingForm" name="book">Book</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
            </div>

        </div>
    </div>
</div>

<script>
function populateModal(startTime, endTime) {
    const timeslot = startTime + " - " + endTime;
    document.getElementById('timeslot').value = timeslot; // Populate timeslot field
    document.getElementById('modalApptDate').value = document.getElementById('selectedDate').value; // Populate appointment date

    // Check which radio button is selected and populate modal fields accordingly
    const options = document.querySelector('input[name="options"]:checked');
    if (options && options.value === '2') { // If 'others' is selected
        document.getElementById('modalRelation').value = document.getElementById('relation').value; // Populate relation field
    } else {
        document.getElementById('modalRelation').value = ''; // Clear relation field if 'self' is selected (optional)
    }

    // Ensure modal options field is set to the selected radio button value
    document.getElementById('modalOptions').value = options ? options.value : ''; 
}


    </script>


</body>
</html>
