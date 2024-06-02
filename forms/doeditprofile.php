<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['patient_id'])) {
    header("Location: forms/login.php");
    exit();
}

$error = "";

$patient_id = $_SESSION['patient_id'];
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];
$dob = $_POST['dob'];
$phone = $_POST['phone'];

// Check for empty fields
if (empty($email)) {
    $error = "Please enter your email again.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
if (empty($password)) {
    $error = "Please enter your password again.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}
if (empty($phone)) {
    $error = "Please enter your phone number again.";
    header("Location: editprofile.php?error=" . urlencode($error));
    exit();
}

$query = "UPDATE patient SET patient_email = ?, patient_password = ?, patient_dob = ?, patient_phoneNo = ? WHERE patient_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssii", $email, $password, $dob, $phone, $patient_id);


if (mysqli_stmt_execute($stmt)) {
    $message = "Profile updated successfully";
} else {
    $message = "An error occurred while updating the profile";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
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
        .container{
            width: 1500px;
        }
        .form-container {
            height: 600px; /* Adjust this value as needed */
            /* overflow-y: auto; */
            padding: 20px; /* Adjust the padding as needed */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .back-btn {
            width: 100%;
            background-color: #CFA61E;
            color: #fff;
        }
        .save-btn {
            width: 100%;
            background-color: #CFA61E;
            color: #fff;
        }
        .icon-text {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .icon-text i {
            margin-right: 20px; /* Space between icon and text */
            font-size: 5rem; /* Increase icon size */
        }
        .icon-text h3 {
            margin: 0;
            font-weight: bold; /* Make text bold */
            margin-top: 5px;
            color: #fff;
        }
        .input-text{
            color: #fff;
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
<section class="register vh-100 d-flex align-items-center justify-content-center">
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
                        <div class="form-outline mb-4">
                        <div class="input-text">Password:</div><input type="text" id="password" class="form-control form-control-lg" placeholder="Password" name="password" value="<?php echo htmlspecialchars($password); ?>" readonly />
                        </div>
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
                            <a href="../index.php" class="btn back-btn">Back</a>
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
