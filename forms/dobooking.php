<?php
include "../db_connect.php";
session_start();

$error = "";
$date = null;
$opening_time = null;
$closing_time = null;
$booked_slots = [];
$available_slots = [];

if (isset($_POST['apptdate'])) {
    $date = $_POST['apptdate'];
}

// SQL query to get opening and closing hours
$sql = "SELECT settings_key, settings_value FROM settings WHERE settings_key IN ('weekday_open_time', 'weekday_close_time')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row["settings_key"] == "weekday_open_time") {
            $opening_time = $row["settings_value"];
        } elseif ($row["settings_key"] == "weekday_close_time") {
            $closing_time = $row["settings_value"];
        }
    }
} else {
    echo "No results found";
}

// Function to get booked slots from the database
function getBookedSlots($conn, $date) {
    $query = "SELECT TIME_FORMAT(appointment_start_time, '%H:%i') AS formatted_time FROM appointment WHERE appointment_date = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookedSlots = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return array_column($bookedSlots, 'formatted_time');
}

// Function to get end time by adding 15 minutes
function getEndTime($startTime) {
    $time = strtotime($startTime);
    $endTime = date("H:i", strtotime('+15 minutes', $time));
    return $endTime;
}

// Get slots if a date is set
if (isset($date)) {
    $booked_slots = getBookedSlots($conn, $date);
    $available_slots = [];
    
    list($opening_hour, $opening_min) = explode(".", $opening_time);
    list($closing_hour, $closing_min) = explode(".", $closing_time);
    
    for ($hour = $opening_hour; $hour <= $closing_hour; $hour++) {
        $start_minute = ($hour == $opening_hour) ? $opening_min : 0;
        $minutes_limit = ($hour == $closing_hour) ? $closing_min : 59;
        for ($minute = $start_minute; $minute < $minutes_limit; $minute += 15) {
            $slot = sprintf('%02d:%02d', $hour, $minute);
            if (!in_array($slot, $booked_slots)) {
                $available_slots[] = $slot;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Appointment Booking</title>
    <!-- 'links.php' contains CDN links -->
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
    </style>
</head>

<body>

    <!--navbar-->
    <?php include '../navbar.php'; ?>
    <div class="container mt-5">
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        ?>
    <section class="booking">
        <div class="form-container-booking">
            <h2>Appointment Booking</h2>
            <form action="booking.php" method="post">
                <div class="radio-buttons">
                    <label for="self">
                        <input type="radio" id="self" name="options" value="1"> Self
                    </label>
                    <label for="others">
                        <input type="radio" id="others" name="options" value="2"> Others
                    </label>
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
                            $end_time = getEndTime($slot);
                            echo "<button class='slot available-slot' data-bs-toggle='modal' data-bs-target='#bookingmodal' onclick='populateModal(\"" . htmlspecialchars($slot) . "\", \"" . htmlspecialchars($end_time) . "\")'>" . htmlspecialchars($slot) . " - " . $end_time . "</button>";
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
            document.getElementById('modalApptDate').value = "<?php echo htmlspecialchars($date); ?>";
        }
    </script>

</body>

</html>
