<?php
include "../db_connect.php";
session_start();

$error = "";
$date = null;
$opening_time = null;
$closing_time = null;
$booked_slots = [];
$available_slots = [];
$appointment_duration = 15; // Default duration

if (isset($_POST['apptdate'])) {
    $date = $_POST['apptdate'];
}

if (isset($_POST['relation'])) {
    $relation = $_POST['relation'];
}

if (isset($_POST['options'])) {
    $options = $_POST['options'];
}


// Function to check if the date is in the list
function isOpen($date, $conn) {
    $dayName = strtolower(date('l', strtotime($date)));

    // SQL query to get the settings value
    $sql = "SELECT settings_value FROM settings WHERE settings_key = 'opening_days'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === FALSE) {
        die("Query failed: " . $conn->error);
    }

    // Initialize the variable to store the settings value
    $settingsValue = null;

    // Fetch the result
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $settingsValue = $row['settings_value'];
    }

    // Free the result set
    $result->free();

    // Check if $dayName is in the $settingsValue
    if ($settingsValue !== null) {
        $daysList = strtolower($settingsValue);
        $daysArray = array_map('trim', explode(',', $daysList));
        return in_array($dayName, $daysArray);
    } else {
        return false;
    }
}

// Function to check if the date is a weekend
function isWeekend($date) {
    $dayOfWeek = date('w', strtotime($date));
    return ($dayOfWeek == 0 || $dayOfWeek == 6);
}

if (isset($date) && isOpen($date, $conn)) {
    // SQL query to get opening and closing hours based on weekday/weekend
    if (isWeekend($date)) {
        $sql = "SELECT settings_key, settings_value FROM settings WHERE settings_key IN ('weekend_open_time', 'weekend_close_time')";
    } else {
        $sql = "SELECT settings_key, settings_value FROM settings WHERE settings_key IN ('weekday_open_time', 'weekday_close_time')";
    }
    $result = $conn->query($sql);
} else {

    $error = "Sin Nam Medical Hall is closed on this day.";
    header("Location: booking.php?error=" . urlencode($error));
    exit();
}





if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["settings_key"] == "weekday_open_time" || $row["settings_key"] == "weekend_open_time") {
            $opening_time = $row["settings_value"];
        } elseif ($row["settings_key"] == "weekday_close_time" || $row["settings_key"] == "weekend_close_time") {
            $closing_time = $row["settings_value"];
        }
    }
} else {
    echo "No results found";
}

// Fetch patient status
$patient_sql = "SELECT patient_status FROM patient WHERE patient_id = ?";
$stmt = $conn->prepare($patient_sql);
if ($stmt === false) {
    die("Failed to prepare statement: " . $conn->error);
}

$patient_id = $_SESSION['patient_id'];
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();
$stmt->close();

if ($patient) {
    if ($patient['patient_status'] === "NEW") {
        // Fetch new appointment duration
        $settings_sql = "SELECT settings_value FROM settings WHERE settings_key = 'new_appointment_duration' AND settings_value = '30'";
        $stmt = $conn->prepare($settings_sql);
        if ($stmt === false) {
            die("Failed to prepare statement: " . $conn->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $settings = $result->fetch_assoc();
        $stmt->close();

        if ($settings) {
            $appointment_duration = 30; // Set duration to 30 minutes for new patients
        }
    }
}

function getBookedSlots($conn, $date) {
    $query = "SELECT TIME_FORMAT(appointment_start_time, '%H:%i') AS start_time, TIME_FORMAT(appointment_end_time, '%H:%i') AS end_time FROM appointment WHERE appointment_date = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookedSlots = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $bookedSlots;
}

if (isset($date)) {
    $booked_slots = getBookedSlots($conn, $date);
    $available_slots = [];

    list($opening_hour, $opening_min) = explode(".", $opening_time);
    list($closing_hour, $closing_min) = explode(".", $closing_time);

    $current_time = strtotime($opening_hour . '.' . $opening_min);

    while ($current_time < strtotime($closing_hour . '.' . $closing_min)) {
        $end_time = strtotime('+' . $appointment_duration . ' minutes', $current_time);
        $slot_start = date('H:i', $current_time);
        $slot_end = date('H:i', $end_time);

        $is_booked = false;
        foreach ($booked_slots as $booked) {
            $booked_start = strtotime($booked['start_time']);
            $booked_end = strtotime($booked['end_time']);
            if (($current_time >= $booked_start && $current_time < $booked_end) || 
                ($end_time > $booked_start && $end_time <= $booked_end)) {
                $is_booked = true;
                break;
            }
        }

        $available_slots[] = ['start' => $slot_start, 'end' => $slot_end, 'booked' => $is_booked];
        
        $current_time = $end_time;
    }
}

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
            margin-top: 50px;
        }
        h3 {
            text-align: center;
            margin-top: 50px;
            margin-bottom: 30px;
        }
        .date-and-button {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .slots-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 20px;
            justify-content: center;
        }
        .slot {
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
        .btn-book{
            background-color: #CFA61E;
            color: #fff;
        }
        .btn-cancel{
            background-color: #682924;
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
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selfRadio = document.getElementById('self');
        const othersRadio = document.getElementById('others');
        const relationField = document.getElementById('relationField');
        const relationInput = document.getElementById('relation');

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
    });
</script>

</head>

<body>

    <!--navbar-->
    <?php include '../navbar.php'; ?>
    <div class="container mt-5">
    </div>
    <section class="booking">
        <div class="form-container-booking">
            <h2>Appointment Booking</h2>
            <form action="booking.php" method="post">
                <div class="radio-buttons">
                    <label for="self">
                        <input type="radio" id="self" name="options" value="1" disabled> Self
                    </label>
                    <label for="others">
                        <input type="radio" id="others" name="options" value="2" disabled> Others
                    </label>
                </div>
                <div class="form-group hidden" id="relationField">
                    <input type="text" class="form-control" id="relation" name="relation" placeholder="Relation" value="<?php echo $relation ?>" style="margin-bottom: 10px;" readonly>
                </div>
                <div class="form-group date-and-button">
                    <input type="date" class="form-control date-input" id="apptdate" name="apptdate" placeholder="Date of appointment" value="<?php echo htmlspecialchars($date); ?>" readonly>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn back-btn">Back</button>
                    </div>
                </div>
            </form>
            <br>
            <?php if (isset($date)): ?>
                <div>
                    <h3>Available slots on <?php echo date('d/m/Y', strtotime($date)); ?></h3>
                    <div class="slots-container">
                        <?php
                        foreach ($available_slots as $slot) {
                            if ($slot['booked']) {
                                echo "<button class='slot booked-slot' disabled>" . htmlspecialchars($slot['start']) . " - " . htmlspecialchars($slot['end']) . "</button>";
                            } else {
                                echo "<button class='slot available-slot' data-bs-toggle='modal' data-bs-target='#bookingmodal' onclick='populateModal(\"" . htmlspecialchars($slot['start']) . "\", \"" . htmlspecialchars($slot['end']) . "\")'>" . htmlspecialchars($slot['start']) . " - " . htmlspecialchars($slot['end']) . "</button>";
                            }
                        }
                        ?>
                    </div>
                    <br>
                </div>
            <?php endif; ?>
        </div>
    </section>

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
                        <input type="date" class="form-control form-control-lg" id="modalApptDate" name="apptdate" value="<?php echo htmlspecialchars($date); ?>" readonly>
                        <input type="hidden" name="relation" id="modalRelation" value="<?php echo htmlspecialchars($relation); ?>" />
                        <input type="hidden" name="options" id="modalOptions" value="<?php echo htmlspecialchars($options); ?>" />
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-book" form="bookingForm" name="book">Book</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        function populateModal(startTime, endTime) {
            const timeslot = startTime + " - " + endTime;
            document.getElementById('timeslot').value = timeslot;
            document.getElementById('modalRelation').value = "<?php echo htmlspecialchars($relation); ?>";
            document.getElementById('modalOptions').value = "<?php echo htmlspecialchars($options); ?>";
            document.getElementById('modalApptDate').value = "<?php echo htmlspecialchars($date); ?>";
        }
    </script>

</body>

</html>
