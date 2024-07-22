<?php 
ob_start();
session_start();
include "../db_connect.php";

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT user_name, user_email FROM users WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['doctor_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $user_name, $user_email);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
ob_end_flush();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Edit Profile</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
    if (isset($_GET['message'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['message']) . '</div>';
    }
    ?>
</div>


<section class=" d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 text-black right-col">
                <div class="form-container">
                    <form id="profileForm" method="post" action="doeditDoctorProfile.php">
                        <div class="form-outline mb-4">
                            <div class="icon-text">
                                <i class="bi bi-person-circle"></i>
                                <h3><?php echo htmlspecialchars($user_name); ?></h3>
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($user_name); ?>" hidden/>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Email:</div><input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?php echo htmlspecialchars($user_email); ?>"/>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-6">
                            <a href="../d_index.php" class="btn back-btn" style="background-color: #CFA61E">Back</a>
                            </div>
                            <div class="col-6">
                                <button type="submit" id="saveButton" class="btn save-btn">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<br>


</body>

</html>

