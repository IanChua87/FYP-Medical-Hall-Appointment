<?php
ob_start();
session_start();
include "../db_connect.php";
include "../helper_functions.php";

if (!isset($_SESSION['patient_id'])) {
    header("Location: forms/login.php");
    exit();
}

$error = "";

$patient_id = $_SESSION['patient_id'];
$email = $_POST['email'];
$name = $_POST['name'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];

// Check for empty fields
if (empty($email)) {
    $error = "Please enter your email again.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
if (empty($phone)) {
    $error = "Please enter your phone number again.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
if(invalid_email($email)){
    $error = "Please enter a valid email address.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
if(invalid_phone_number($phone)){
    $error = "Please enter a valid phone number.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}


$query = "UPDATE patient SET patient_email = ?, patient_phoneNo = ?, last_updated_by = patient_name WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
if(check_patient_exists_by_email($conn,$email)){
    $error = "Email is already taken by another patient.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
mysqli_stmt_bind_param($stmt, "sii", $email, $phone, $patient_id);


if (mysqli_stmt_execute($stmt)) {
    $message = "Profile updated successfully";
} else {
    $message = "An error occurred while updating the profile";
}



mysqli_stmt_close($stmt);
mysqli_close($conn);
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Updated Profile</title>
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>
<style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        
    </style>
<body>

<?php include '../navbar.php'; ?>

<div class="container mt-5">
    <?php
    if (isset($message)) {
        echo '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
    }
    ?>
</div>
<br>
<section class="d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-12 col-lg-6 text-black right-col">
                <div class="form-container">
                    <form id="profileForm">
                        <div class="form-outline mb-4">
                            <div class="icon-text">
                                <i class="bi bi-person-circle"></i>
                                <h3><?php echo htmlspecialchars($name); ?></h3>
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($patient_name); ?>" hidden/>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Email:</div><input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly/>
                        </div>
                        <!-- <div class="form-outline mb-4">
                        <div class="input-text">Password:</div><input type="text" id="password" class="form-control form-control-lg" placeholder="Password" name="password" value="<?php echo htmlspecialchars($password); ?>" readonly />
                        </div> -->
                        <div class="double-form-field row mb-4">
                            <div class="col">
                            <div class="input-text">Date Of Birth:</div><input type="date" class="form-control date-input" name="dob" value="<?php echo htmlspecialchars($dob); ?>" readonly />
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Phone No:</div><input type="number" class="form-control form-control-lg" placeholder="Phone Number" name="phone" value="<?php echo htmlspecialchars($phone); ?>" readonly/>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-12">
                            <a href="editprofile.php" class="btn back-btn">Back</a>
                            </div>
                        </div>
                    </form>
                    <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
</body>
</html>
