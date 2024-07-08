<?php 
session_start();
include "db_connect.php";
?>

<?php 
if (!isset($_SESSION['admin_id'])) {
    header("Location: forms/login.php");
    exit();
}

$query = "SELECT * FROM users WHERE user_id = ?";
$edit_users_stmt = mysqli_prepare($conn, $query);


if (!$edit_users_stmt) {
    die("Failed to prepare statement");
} else{
    mysqli_stmt_bind_param($edit_users_stmt, 's', $_GET['user_id']);
    mysqli_stmt_execute($edit_users_stmt);
    $edit_users_result = mysqli_stmt_get_result($edit_users_stmt);

    if(mysqli_num_rows($edit_users_result) > 0){
        if($row = mysqli_fetch_assoc($edit_users_result)){
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_email = $row['user_email'];
            $user_password = $row['user_password'];
            $role = $row['role'];
        }

    } else{
        $_SESSION['message'] = "Staff not found.";
        header("Location: staffDetails.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Patient Details</title>
     <!-- 'links.php' contains cdn links' -->
    <?php include 'links.php'; ?>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>
<body>
    <section class="patient">
        <div class="patient-box">
            <div class="profile-details">
                <i class="bi bi-person-circle"></i>
                <h2 class=""><?php echo $user_name ?></h2>
            </div>
            <form action="doEditStaff.php" method="POST">
                <div class="form-group">
                    <input type="text" name="user_id" class="form-control" value="<?php echo $user_id ?>" hidden>
                </div>

                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $user_name ?>">
                </div>

                <div class="form-group">
                    <label for="appointment_time">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $user_email ?>">
                </div>

                <div class="buttons">
                    <button type="button" class="btn back-btn">Back</button>
                    <button type="submit" name="submit" class="btn save-btn">Save</button>
                </div>
        </div>
    </section>
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
</script>
</html>