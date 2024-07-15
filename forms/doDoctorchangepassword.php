<?php
session_start();
include "../db_connect.php";

// Ensure the user is logged in as a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Doctor') {
    header("Location: login.php");
    exit();
}

// Get the form data
$new_password = trim($_POST['newpassword']);
$confirm_password = trim($_POST['cfmpassword']);

// Validate input
if (empty($new_password) || empty($confirm_password)) {
    $error = "Please fill in all fields.";
    header("Location: Doctorchangepassword.php?error=".urlencode($error));
    exit();
}

// Check if passwords match
if ($new_password !== $confirm_password) {
    $error = "Passwords do not match.";
    header("Location: Doctorchangepassword.php?error=".urlencode($error));
    exit();
}

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update the password in the database
$query = "UPDATE users SET user_password = ? WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
$stmt->bind_param("si", $hashed_password, $_SESSION['user_id']);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Password updated successfully
    $message = "Password updated successfully";
    header("Location: Doctorchangepassword.php?message=".urlencode($message));
} else {
    // No rows updated (could be wrong email or user_id)
    $error = "An error occurred while updating the password";
    header("Location: Doctorchangepassword.php?error=".urlencode($error));
}

$stmt->close();
$conn->close();
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Change Password</title>
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
                <div class="form-container-password">
                    <form id="passwordForm" method="post" action="dochangepassword.php">
                        <div class="form-outline mb-4">
                            <input type="text" class="form-control form-control-lg" placeholder="Name" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>" hidden/>
                        </div>
                        <h2 class="text">Change Password</h2>
                        <br>
                        <div class="form-outline mb-4">
                        <div class="input-text">New Password:</div><input type="password" id="idPassword" class="form-control form-control-lg" placeholder="Password" name="newpassword" required/>
                        </div>
                        <div class="form-outline mb-4">
                        <div class="input-text">Confirm Password:</div><input type="password" id="idPasswordConfirm" class="form-control form-control-lg" placeholder="Password" name="cfmpassword" required/>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-6">
                            <a href="../d_index.php" class="btn back-btn">Back</a>
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
