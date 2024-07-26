<?php
ob_start();
session_start();
include "../db_connect.php";
include "../helper_functions.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    if (invalid_email($email)) {
        $_SESSION['error'] = "Invalid email address.";
        header("Location: forgotPassword.php");
        exit();
    }

    $receiver = "chuaxiangyuian@gmail.com";
    $subject = "Reset Password";
    $body = "Hi, there";
    $sender = "From:chuaxiangyuian@gmail.com";

    if (mail($receiver, $subject, $body, $sender)) {
        $_SESSION['error'] = "Email sent successfully.";
        header("Location: forgotPassword.php");
        exit();
    } else {
        $_SESSION['error'] = "Email could not be sent.";
        header("Location: forgotPassword.php");
        exit();
    }
} else {
    header("Location: forgotPassword.php");
    exit();
}
?>






















// Check if form is submitted
// if (isset($_POST['submit'])) {
// // Get the form data
// $new_password = trim($_POST['newpwd']);
// $old_password = trim($_POST['oldpwd']);

// // Validate input
// if (empty($new_password) || empty($old_password)) {
// $error = "Please fill in all fields.";
// header("Location: forgotPassword.php?error=".urlencode($error));
// exit();
// }

// // Check if passwords match
// if ($new_password !== $old_password) {
// $error = "Passwords do not match.";
// header("Location: forgotPassword.php?error=".urlencode($error));
// exit();
// }

// // Hash the new password
// // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// // Update the password in the database
// $query = "UPDATE patient SET patient_password = ? WHERE patient_id = ?";
// $stmt = mysqli_prepare($conn, $query);
// $stmt->bind_param("si", $new_password, $_SESSION['patient_id']);
// $stmt->execute();

// if ($stmt->affected_rows > 0) {
// // Password updated successfully
// // Fetch user's email address
// $query_email = "SELECT patient_email FROM patient WHERE patient_id = ?";
// $stmt_email = mysqli_prepare($conn, $query_email);
// $stmt_email->bind_param("i", $_SESSION['patient_id']);
// $stmt_email->execute();
// $stmt_email->bind_result($patient_email);
// $stmt_email->fetch();
// $stmt_email->close();

// // Send email notification
// $to = $patient_email;
// $subject = "Password Updated Successfully";
// $message = "Hello,\n\nYour password has been updated successfully.\n\nIf you did not make this change, please contact support immediately.\n\nBest regards,\nSin Nam Medical Hall";
// $headers = "From: no-reply@Sin-Nam-Medicall-Hall";

// if (mail($to, $subject, $message, $headers)) {
// $message = "Password updated successfully and email sent.";
// } else {
// $message = "Password updated successfully, but email could not be sent.";
// }

// header("Location: resetPasswordSuccessful.php?message=".urlencode($message));
// } else {
// // No rows updated (could be wrong email or patient_id)
// $error = "An error occurred while updating the password";
// header("Location: forgotpassword.php?error=".urlencode($error));
// }

// $stmt->close();
// $conn->close();
// } else {
// header("Location: forgotPassword.php");
// exit();
// }
// ob_end_flush();
//


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Sin Nam Medical Hall | Forgot</title>
    <!-- 'links.php' contains cdn links' -->
    <?php include '../links.php'; ?>
    <link rel="stylesheet" href="../style.css" />
</head>



<body>
    <section class="forgot-password vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-8 px-0 d-none d-sm-block">
                    <img src="../img/side-img.jpg" alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
                <div class="col-sm-4 text-black right-col">
                    <div class="form-container">
                        <h3 class="text">Forgot Password</h3>
                        <form method="post" action="doforgotPassword.php">
                            <div data-mdb-input-init class="form-outline mb-5">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" class="form-control form-control-lg" id="oldpwd" placeholder="Old Password" />
                            </div>

                            <div data-mdb-input-init class="form-outline mb-4">
                                <input type="password" id="newpwd" class="form-control form-control-lg" placeholder="New Password" />
                            </div>

                            <!-- Simple link -->
                            <a href="login.php" class="forgot-text">Remember password?</a>

                            <div class="mt-3">
                                <button type="submit" class="btn reset-btn" id="resetbtn">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>

</html>