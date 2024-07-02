<?php
include "../db_connect.php"; // Include database connection file
session_start(); // Start session

$error = "";
$booked_slots = [];
$available_slots = [];
$appointment_duration = 15; // Default duration

// Check if selectedDate is provided via POST
if (isset($_POST['selectedDate'])) {
    $date = $_POST['selectedDate'];

    // Function to check if the date is in the list of opening days
    function isOpen($date, $conn) {
        $dayName = strtolower(date('l', strtotime($date)));

        // SQL query to fetch opening days from settings table
        $sql = "SELECT settings_value FROM settings WHERE settings_key = 'opening_days'";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        $settingsValue = null;

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $settingsValue = $row['settings_value'];
        }

        $result->free();

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

    if (isOpen($date, $conn)) {
        // Query to fetch opening and closing hours based on weekday/weekend
        if (isWeekend($date)) {
            $sql = "SELECT settings_key, settings_value FROM settings WHERE settings_key IN ('weekend_open_time', 'weekend_close_time')";
        } else {
            $sql = "SELECT settings_key, settings_value FROM settings WHERE settings_key IN ('weekday_open_time', 'weekday_close_time')";
        }

        $result = $conn->query($sql);

        if ($result === false) {
            die("Query failed: " . $conn->error);
        }

        $opening_time = null;
        $closing_time = null;

        while ($row = $result->fetch_assoc()) {
            if ($row["settings_key"] == "weekday_open_time" || $row["settings_key"] == "weekend_open_time") {
                $opening_time = $row["settings_value"];
            } elseif ($row["settings_key"] == "weekday_close_time" || $row["settings_key"] == "weekend_close_time") {
                $closing_time = $row["settings_value"];
            }
        }

        if ($opening_time === null || $closing_time === null) {
            die("Opening or closing time not found in settings.");
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

        // Function to fetch booked slots for the selected date
        function getBookedSlots($conn, $date) {
            $query = "SELECT TIME_FORMAT(appointment_start_time, '%H:%i') AS start_time, TIME_FORMAT(appointment_end_time, '%H:%i') AS end_time, appointment_status FROM appointment WHERE appointment_date = ?";
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

        // Fetch booked slots for the selected date
        $booked_slots = getBookedSlots($conn, $date);
        $available_slots = [];

        list($opening_hour, $opening_min) = explode(".", $opening_time);
        list($closing_hour, $closing_min) = explode(".", $closing_time);

        $current_time = strtotime($opening_hour . ':' . $opening_min);

        // while ($current_time < strtotime($closing_hour . ':' . $closing_min)) {
        //     $end_time = strtotime('+' . $appointment_duration . ' minutes', $current_time);
        //     $slot_start = date('H:i', $current_time);
        //     $slot_end = date('H:i', $end_time);

        //     $is_booked = false;

        //     foreach ($booked_slots as $booked) {
        //         $booked_start = strtotime($booked['start_time']);
        //         $booked_end = strtotime($booked['end_time']);

        //         if (($current_time >= $booked_start && $current_time < $booked_end) || 
        //             ($end_time > $booked_start && $end_time <= $booked_end)) {
        //             $is_booked = true;
        //             break;
        //         }
        //     }

        //     $available_slots[] = [
        //         'start' => $slot_start,
        //         'end' => $slot_end,
        //         'booked' => $is_booked
        //     ];

        //     $current_time = $end_time;
        // }
        // Loop through time slots and check availability based on booked slots
while ($current_time < strtotime($closing_hour . ':' . $closing_min)) {
    $end_time = strtotime('+' . $appointment_duration . ' minutes', $current_time);
    $slot_start = date('H:i', $current_time);
    $slot_end = date('H:i', $end_time);

    $is_booked = false;

    foreach ($booked_slots as $booked) {
        $booked_start = strtotime($booked['start_time']);
        $booked_end = strtotime($booked['end_time']);
        $appointment_status = $booked['appointment_status'];

        // Check if slot overlaps with a booked slot that is not cancelled
        if (($current_time >= $booked_start && $current_time < $booked_end) ||
            ($end_time > $booked_start && $end_time <= $booked_end)) {
            if ($appointment_status !== 'CANCELLED') {
                $is_booked = true;
                break;
            }
        }
    }

    $available_slots[] = [
        'start' => $slot_start,
        'end' => $slot_end,
        'booked' => $is_booked
    ];

    $current_time = $end_time;
}


        // Output available slots as JSON
        echo json_encode($available_slots);
    } else {
        echo json_encode(['error' => 'Sin Nam Medical Hall is closed on this day.']);
    }
} else {
    echo json_encode(['error' => 'No date selected.']);
}
?>