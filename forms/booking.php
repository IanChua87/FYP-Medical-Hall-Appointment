<?php
include "../db_connect.php";
?>

<?php
$error = "";

session_start();


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // SQL query to get opening and closing hours
// $sql = "SELECT system_key, system_value FROM system WHERE system_key IN ('weekday_open_time', 'weekday_close_time')";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     while ($row = $result->fetch_assoc()) {
//         if ($row["system_key"] == "weekday_open_time") {
//             $opening_time = $row["system_value"];
//             list($hour1, $min1) = explode(".", $opening_time);
//             echo "Opening Hour: " . $hour1 . "\n";
//             echo "Opening Minute: " . $min1 . "\n";
//         } elseif ($row["system_key"] == "weekday_close_time") {
//             $closing_time = $row["system_value"];
//             list($hour2, $min2) = explode(".", $closing_time);
//             echo "Closing Hour: " . $hour2 . "\n";
//             echo "Closing Minute: " . $min2 . "\n";
//         }
//     }
// } else {
//     echo "No results found";
// }

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
    <style>
        .booking {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensure it takes full viewport height */
        }

        .form-container-booking {
            width: 100%;
            max-width: 400px; /* Optional: Limit the max width of the form */
        }

        .radio-buttons {
            display: flex;
            justify-content: center; /* Center the radio buttons horizontally */
            gap: 10px; /* Adjust the gap between radio buttons as needed */
            margin-bottom: 20px; /* Add some space below the radio buttons */
        }

        label {
            display: flex;
            align-items: center;
            margin-right: 10px; /* Adjust the margin as needed */
        }

        input[type="radio"] {
            margin-right: 5px; /* Space between the radio button and the label text */
        }

        h2 {
            margin-bottom: 20px; /* Add some space below the heading */
            text-align: center; /* Center the heading text */
        }

        .date-and-button {
            display: flex;
            gap: 10px; /* Adjust the gap between date field and button */
            align-items: center;
        }

        .btn-go {
            background-color: #CFA61E;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
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
</div>
    <section class="booking">
        <div class="form-container-booking">
            <h2>Appointment Booking</h2>
            <form action="dobooking.php" method="post">
                <div class="radio-buttons">
                    <label for="self">
                        <input type="radio" id="self" name="options" value="1"> Self
                    </label>
                    <label for="others">
                        <input type="radio" id="others" name="options" value="2"> Others
                    </label>
                </div>
                <div class="form-group date-and-button">
                <input type="date" class="form-control date-input" id="apptdate" name="apptdate" placeholder="Date of appointment" required>
                    <button type="submit" name="submit" class="btn btn-go">Go</button>
                </div>
            </form>
        </div>
    </section>

</body>

</html>
