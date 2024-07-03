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
    <title>Admin | Settings</title>
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
                        <label for="start_weekday" class="col-sm-5 col-form-label text-right">Weekday Open Time:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['weekday_open_time'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="end_weekday" class="col-sm-5 col-form-label text-right">Weekday Close Time:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['weekday_close_time'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="start_weekend" class="col-sm-5 col-form-label text-right">Weekend Open Time:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['weekend_open_time'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="end_weekend" class="col-sm-5 col-form-label text-right">Weekend Close Time:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['weekend_close_time'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="start_weekday_time" class="col-sm-5 col-form-label text-right">Opening Days:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['opening_days'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="end_weekday_time" class="col-sm-5 col-form-label text-right">Appointment Duration:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['appointment_duration'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="start_weekend_time" class="col-sm-5 col-form-label text-right">New Appointment Duration:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['new_appointment_duration'] ?></p>
                        </div>
                    </div>
                    <div class="form-group row mb-5">
                        <label for="end_weekend_time" class="col-sm-5 col-form-label text-right">Last Queue No:</label>
                        <div class="col-sm-7">
                            <p><?php echo $settings['last_queue_no'] ?></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right mb-5">
                            <a href="editSettings.php" class="btn edit-btn">Edit</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
