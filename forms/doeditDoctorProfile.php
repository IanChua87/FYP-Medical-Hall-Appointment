<?php
session_start();
include "../db_connect.php";

if (!isset($_SESSION['doctor_id'])) {
    header("Location: forms/login.php");
    exit();
}

$error = "";

$user_id = $_SESSION['doctor_id'];
$email = $_POST['email'];
$name = $_POST['name'];

// Check for empty fields
if (empty($email)) {
    $error = "Please enter your email again.";
    header("Location: editDoctorProfile.php?error=" . urlencode($error));
    exit();
}

$query = "UPDATE users SET user_email = ? WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "si", $email, $user_id);

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
</style>

<body>

    <?php include '../d_navbar.php'; ?>

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
                                <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($name); ?>" hidden />
                            </div>
                            <div class="form-outline mb-4">
                                <div class="input-text">Email:</div>
                                <input type="email" class="form-control form-control-lg" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly />
                            </div>
                            <br>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <a href="../d_index.php" class="btn back-btn" style="background-color: #CFA61E">Back</a>
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