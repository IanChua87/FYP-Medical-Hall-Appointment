<?php 
session_start();
include "../db_connect.php";

if (!isset($_SESSION['patient_id'])) {
    header("Location: forms/login.php");
    exit();
}

$query = "SELECT patient_name, patient_dob, patient_email, patient_phoneNo FROM patient WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['patient_id']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $patient_name, $patient_dob, $patient_email, $patient_phoneNo);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
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
                    <form id="profileForm" method="post" action="doeditprofile.php">
                        <div class="form-outline mb-4">
                            <div class="icon-text">
                                <i class="bi bi-person-circle"></i>
                                <h3><?php echo htmlspecialchars($patient_name); ?></h3>
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($patient_name); ?>" hidden/>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Email:</div><input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?php echo htmlspecialchars($patient_email); ?>"/>
                        </div>
                        <!-- <div class="form-outline mb-4">
                        <div class="input-text">Password:</div><input type="text" id="password" class="form-control form-control-lg" placeholder="Password" name="password" value="<?php echo htmlspecialchars($patient_password); ?>"  />
                        </div> -->
                        <div class="double-form-field row mb-4">
                            <div class="col">
                            <div class="input-text">Date Of Birth:</div><input type="date" class="form-control date-input" name="dob" value="<?php echo htmlspecialchars($patient_dob); ?>" readonly/>
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Phone No:</div><input type="number" class="form-control form-control-lg" placeholder="Phone Number" name="phone" value="<?php echo htmlspecialchars($patient_phoneNo); ?>" />
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-6">
                            <a href="../P_index.php" class="btn back-btn">Back</a>
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
