

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Admin Dashboard</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <!--navbar-->
    <?php include 'adminNavbar.php'; ?>

    <!--main content-->
    <section class="admin-main" id="admin-main">
        <div class="admin-box">
            <h1>Welcome Admin</h1>
            <div class="control-options">
                <a href="#" class="btn last-queue-btn">Last Queue No.</a>
                <a href="#" class="btn edit-settings-btn">Edit Settings</a>
                <a href="#" class="btn edit-doctor-btn">Edit Doctor Profile</a>
                <a href="#" class="btn edit-appointment-btn">Edit Appointment</a>
                <a href="#" class="btn edit-patient-btn">Edit Patient Details</a>
            </div>
        </div>
    </section>
</body>