<?php
ob_start();
session_start();
include "../db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM holiday";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Failed to fetch settings: " . mysqli_error($conn));
} else {
    $holiday = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $holiday[$row['holiday_id']] = $row;
    }
}
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Settings</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        .session-msg-success,
        .session-msg-error {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .session-msg-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .session-msg-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        #sidebar {
            height: 1200px;
        }

        .settings-group label{
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="main-content d-flex">
        <div class="sidebar" id="sidebar">
            <div class="header-box px-3 mt-2 mb-2 d-flex align-items-center justify-content-between">
                <h1 class="header">Sin Nam</h1>
                <!-- <button class="btn close-btn"><i class="fa-solid fa-xmark"></i></button> -->
            </div>
            <ul class="mt-3">
                <li class=""><a href="../adminDashboard.php" class="text-decoration-none outer"><i class="fa-solid fa-house"></i> Dashboard</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class="active"><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>
        <div class="content" id="content">
            <div class="settings">
                <div class="settings-wrapper">
                    <h1>Holiday Settings</h1>
                    <div class="settings-group">
                        <?php foreach ($holiday as $id => $holiday_data) : ?>
                            <div class="row mb-1">
                                <label for="holiday_<?php echo $id; ?>" class="col-sm-6 col-md-6 col-lg-6 word-label">
                                    <?php echo $holiday_data['holiday_name']; ?>:
                                </label>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p><?php echo date('d/m/y', strtotime($holiday_data['holiday_date'])); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <div class="">
                            <a href="editHoliday.php" class="btn edit-btn">Edit</a>
                        </div>

                        <!-- <div class="row mb-3">
                            <label for="start_weekday" class="col-sm-5 word-label">New Year's Day:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday["New Year's Day"] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_weekday" class="col-sm-5 word-label">Chinese New Year:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Chinese New Year'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_weekday" class="col-sm-5 word-label">Chinese New Year:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Chinese New Year'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekday_time" class="col-sm-5 word-label">Good Friday:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Good Friday'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">Hari Raya Puasa:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Hari Raya Puasa'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">Labour Day:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Labour Day'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">Vesak Day:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Vesak Day'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="end_weekday_time" class="col-sm-5 word-label">Hari Raya Haji:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Hari Raya Haji'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">National Day:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['National Day'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">Deepavali:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Deepavali'] ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="start_weekend_time" class="col-sm-5 word-label">Christmas Day:</label>
                            <div class="col-sm-7 settings-value">
                                <p><?php echo $holiday['Christmas Day'] ?></p>
                            </div>
                        </div> -->
                    </div>
                    <?php include '../sessionMsg.php' ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-success').fadeOut('slow');
        }, 1700);
    });
</script>

<script>
    $(function() {
        $("#dob").timepicker({
            timeFormat: 'hh:mm p',
            interval: 15
        });
    });
</script>

</html>