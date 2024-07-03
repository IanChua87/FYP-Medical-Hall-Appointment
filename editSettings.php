<?php
session_start();
include "db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}
?>

<?php
$query = "SELECT settings_key, settings_value FROM settings";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Failed to fetch settings: " . mysqli_error($conn));
} else{
    $settings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['settings_key']] = $row['settings_value'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Settings</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include 'adminNavbar.php' ?>
    <div class="settings">
        <div class="settings-box">
            <h1>Settings</h1>
            <div class="settings-group">
                <form action="doEditSettings.php" method="POST">
                    <div class="form-group row mb-5">
                        <label for="weekday_open_time" class="col-sm-5 col-form-label text-right">Weekday Open Time:</label>
                        <div class="col-sm-7">
                            <input type="text" name="weekday_open_time" id="weekday_open_time" class="form-control" value="<?php echo $settings['weekday_open_time'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="weekday_close_time" class="col-sm-5 col-form-label text-right">Weekday Close Time:</label>
                        <div class="col-sm-7">
                            <input type="text" name="weekday_close_time" id="weekday_close_time" class="form-control" value="<?php echo $settings['weekday_close_time'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="weekend_open_time" class="col-sm-5 col-form-label text-right">Weekend Open Time:</label>
                        <div class="col-sm-7">
                            <input type="text" name="weekend_open_time" id="weekend_open_time" class="form-control" value="<?php echo $settings['weekend_open_time'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="weekend_close_time" class="col-sm-5 col-form-label text-right">Weekend Close Time:</label>
                        <div class="col-sm-7">
                            <input type="text" name="weekend_close_time" id="weekend_close_time" class="form-control" value="<?php echo $settings['weekend_close_time'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="opening_days" class="col-sm-5 col-form-label text-right">Opening Days:</label>
                        <div class="col-sm-7">
                            <input type="text" name="opening_days" id="opening_days" class="form-control" value="<?php echo $settings['opening_days'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="appointment_duration" class="col-sm-5 col-form-label text-right">Appointment Duration:</label>
                        <div class="col-sm-7">
                            <input type="text" name="appointment_duration" id="appointment_duration" class="form-control" value="<?php echo $settings['appointment_duration'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="new_appointment_duration" class="col-sm-5 col-form-label text-right">New Appointment Duration:</label>
                        <div class="col-sm-7">
                            <input type="text" name="new_appointment_duration" id="new_appointment_duration" class="form-control" value="<?php echo $settings['new_appointment_duration'] ?>">
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="last_queue_no" class="col-sm-5 col-form-label text-right">Last Queue No:</label>
                        <div class="col-sm-7">
                            <input type="text" name="last_queue_no" id="last_queue_no" class="form-control" value="<?php echo $settings['last_queue_no'] ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn save-btn">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
