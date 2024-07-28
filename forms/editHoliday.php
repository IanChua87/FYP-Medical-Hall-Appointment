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
    <title>Admin | Edit Settings</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../style.css" />
    <style>
        #sidebar{
            height: 1280px;
        }

        .session-msg-success, .session-msg-error {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .session-msg-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            margin-left: 50px;
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
                <li class=""><a href="contactDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-envelope"></i> View Contact</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="content" id="content">
            <div class="settings">
            <?php include '../sessionMsg.php' ?>
                <div class="settings-box">
                        <h1>Holiday Settings</h1>
                    <div class="settings-group">
                        <form action="doEditHoliday.php" method="POST">
                            <?php foreach ($holiday as $id => $holiday_data): ?>
                                <div class="form-group row mb-4">
                                    <label for="holiday_<?php echo $id; ?>" class="col-sm-5 col-form-label text-right">
                                        <?php echo $holiday_data['holiday_name']; ?>:
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="hidden" name="holiday_id[]" value="<?php echo $id; ?>">
                                        <input type="text" name="holiday_date_<?php echo $id; ?>" id="holiday_<?php echo $id; ?>" class="form-control date" value="<?php echo $holiday_data['holiday_date']; ?>">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="form-group">
                                <div class="col-sm-12 d-flex flex-end">
                                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

<script>
    $(document).ready(function() {
        $(".date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            yearRange: "c-1:c+100"
        });
    });
</script>

</html>
