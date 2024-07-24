<?php
ob_start();
session_start();
include "../db_connect.php";
?>

<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM users WHERE user_id = ?";
$edit_users_stmt = mysqli_prepare($conn, $query);


if (!$edit_users_stmt) {
    die("Failed to prepare statement");
} else {
    mysqli_stmt_bind_param($edit_users_stmt, 'i', $_GET['user_id']);
    mysqli_stmt_execute($edit_users_stmt);
    $edit_users_result = mysqli_stmt_get_result($edit_users_stmt);

    if (mysqli_num_rows($edit_users_result) > 0) {
        if ($row = mysqli_fetch_assoc($edit_users_result)) {
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            $role = $row['role'];
        }
    } else {
        $_SESSION['message'] = "Staff not found.";
        header("Location: staffDetails.php");
        exit();
    }
}
ob_end_flush();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Patient Details</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <style>
        .session-msg-error {
            margin-top: 40px;
            position: fixed;
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
                <li class=""><a href="checkQueue.php" class="text-decoration-none outer"><i class="fa-solid fa-hourglass-start"></i> Check Queue No.</a></li>
                <li class=""><a href="staffDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-user-doctor"></i> View Staff</a></li>
                <li class=""><a href="patientDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-bed"></i> View Patient</a></li>
                <li class=""><a href="appointmentDetails.php" class="text-decoration-none outer"><i class="fa-solid fa-calendar-check"></i> View Appointment</a></li>
                <li class="active"><a href="settings.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Settings</a></li>
                <li class=""><a href="viewHoliday.php" class="text-decoration-none outer"><i class="fa-solid fa-gear"></i> View Holiday</a></li>
                <div class="sidebar-separator"></div>
                <li class="mt-auto"><a href="loggedOutSuccessful.php" class="text-decoration-none logout-btn outer"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </div>

        <div class="staff" id="staff">
            <div class="container">
                <div class="profile-details">
                    <i class="bi bi-person-circle"></i>
                    <h2 class=""><?php echo $user_name ?></h2>
                </div>
                <div class="form-fields">
                    <form action="doEditStaff.php" method="POST">
                        <div class="form-group mb-3">
                            <input type="text" name="user_id" class="form-control" value="<?php echo $user_id ?>" hidden>
                        </div>

                        <div class="form-group mb-3">
                            <label for="name">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Name:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $user_name ?>">
                        </div>

                        <div class="form-group mb-3">
                            <label for="appointment_time">
                                <span class="asterik"><i class="fa-solid fa-asterisk"></i></span>Email:
                                <span class="required-text">(required)</span>
                            </label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_email ?>">
                        </div>

                        <div class="buttons">
                            <button type="button" class="btn back-btn">Go Back</button>
                            <button type="submit" name="submit" class="btn save-btn">Save</button>
                        </div>
                    </form>
                </div>
                <?php include '../sessionMsg.php' ?>
            </div>
        </div>
    </div>
</body>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
    $(document).ready(function() {
        $('.back-btn').click(function() {
            window.location.href = "staffDetails.php";
        });
    });
    $(document).ready(function() {
        setTimeout(function() {
            $('#session-msg-error').fadeOut('slow');
        }, 1700);
    });
</script>

</html>